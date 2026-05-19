<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Ward;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::paginate(10);

        $totalStaff   = Staff::count();
        $totalDoctors = Staff::where('position', 'like', '%Doctor%')
                             ->orWhere('position', 'like', '%Consultant%')
                             ->count();
        $totalNurses  = Staff::where('position', 'like', '%Nurse%')->count();
        $totalWards   = Ward::count();

        $todayAppointments = Appointment::whereDate('appointment_date', today())
            ->take(5)
            ->get();

        $wardOccupancy = Ward::withCount([
            'bedAllocations as occupied' => fn($q) => $q->whereNull('actual_leave_date')
        ])->get()->map(function ($ward) {
            $ward->percentage = $ward->total_beds > 0
                ? round(($ward->occupied / $ward->total_beds) * 100)
                : 0;
            return $ward;
        });

        return view('staff.index', compact(
            'staff',
            'totalStaff',
            'totalDoctors',
            'totalNurses',
            'totalWards',
            'todayAppointments',
            'wardOccupancy'
        ));
    }

    public function create()
    {
        $wards = Ward::orderBy('ward_name')->get();
        return view('staff.create', compact('wards'));
    }

    public function edit(string $id)
    {
        $staff = Staff::findOrFail($id);
        $wards = Ward::orderBy('ward_name')->get();
        return view('staff.edit', compact('staff', 'wards'));
    }

    public function show(string $id)
    {
        $staff = Staff::findOrFail($id);
        return view('staff.show', compact('staff'));
    }

    public function store(Request $request)
    {
        // ── Strip empty qualification/experience rows BEFORE validation
        $rawQuals = array_values(array_filter(
            $request->input('qualifications', []),
            fn($q) => array_filter(array_map('trim', array_filter($q, 'is_string')))
        ));

        $rawExp = array_values(array_filter(
            $request->input('work_experience', []),
            fn($w) => array_filter(array_map('trim', array_filter($w, 'is_string')))
        ));

        $request->merge([
            'qualifications'  => $rawQuals,
            'work_experience' => $rawExp,
        ]);

        $validated = $request->validate([
            'first_name'     => 'required|string',
            'last_name'      => 'required|string',
            'position'       => 'required|string',
            'address'        => 'required|string',
            'phone'          => 'required|string',
            'date_of_birth'  => 'required|date',
            'sex'            => 'required|in:Male,Female,Other',
            'current_salary' => 'required|numeric',
            'hours_per_week' => 'required|integer',
            'contract_type'  => 'required|in:Full-time,Part-time',
            'pay_type'       => 'required|in:Monthly,Weekly',
            'NIN'            => 'required|string|unique:staff,NIN',
            'salary_scale'   => 'required|string',

            // System account fields
            'account_email'    => 'required|email|unique:users,email',
            'account_password' => 'required|string|min:8|confirmed',
            'account_role'     => 'required|in:medical_director,personnel_officer,charge_nurse',

            'qualifications'                 => 'nullable|array',
            'qualifications.*.type'          => 'nullable|string|max:255',
            'qualifications.*.date_obtained' => 'nullable|date',
            'qualifications.*.institution'   => 'nullable|string|max:255',

            'work_experience'                => 'nullable|array',
            'work_experience.*.position'     => 'nullable|string|max:255',
            'work_experience.*.organization' => 'nullable|string|max:255',
            'work_experience.*.start_date'   => 'nullable|date',
            'work_experience.*.finish_date'  => 'nullable|date',
        ]);

        // ── Auto-generate staff_id ──
        $position = strtolower($validated['position']);

        if (str_contains($position, 'doctor') || str_contains($position, 'consultant')) {
            $prefix = 'D';
        } elseif (str_contains($position, 'nurse')) {
            $prefix = 'N';
        } elseif (str_contains($position, 'admin')) {
            $prefix = 'A';
        } else {
            $prefix = 'S';
        }

        $existingNumbers = Staff::where('staff_id', 'like', $prefix . '%')
            ->pluck('staff_id')
            ->map(fn($id) => intval(substr($id, 1)))
            ->toArray();

        $nextNumber            = empty($existingNumbers) ? 1 : max($existingNumbers) + 1;
        $validated['staff_id'] = $prefix . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

        // ── Transaction ──
        try {
            DB::transaction(function () use ($validated, $request) {

                $staff = Staff::create(\Illuminate\Support\Arr::except($validated, [
                    'qualifications', 'work_experience',
                ]));

                // Qualifications
                foreach ($validated['qualifications'] ?? [] as $q) {
                    $staff->qualifications()->create([
                        'type'          => $q['type']          ?? null,
                        'date_obtained' => $q['date_obtained'] ?? null,
                        'institution'   => $q['institution']   ?? null,
                    ]);
                }

                // Work experience
                foreach ($validated['work_experience'] ?? [] as $w) {
                    $staff->workExperiences()->create([
                        'position'     => $w['position']     ?? null,
                        'organisation' => $w['organization'] ?? null,
                        'start_date'   => $w['start_date']   ?? null,
                        'finish_date'  => $w['finish_date']  ?? null,
                    ]);
                }

                // Ward assignment
                if (!empty($request->ward_id)) {
                    $staff->wards()->attach($request->ward_id, [
                        'week_start_date' => now(),
                        'week_end_date' => null
                    ]);
                }

                // ── Create system login account ──
                $user = User::create([
                    'name'     => $validated['first_name'] . ' ' . $validated['last_name'],
                    'email'    => $validated['account_email'],
                    'password' => Hash::make($validated['account_password']),
                ]);
                $user->assignRole($validated['account_role']);

                // ── Auto-insert into doctors table if position is Doctor or Consultant ──
                $position = strtolower($validated['position']);
                if (str_contains($position, 'doctor') || str_contains($position, 'consultant')) {
                    DB::table('doctors')->insert([
                        'first_name'      => $validated['first_name'],
                        'last_name'       => $validated['last_name'],
                        'specialization'  => $validated['position'],
                        'phone'           => $validated['phone'],
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ]);
                }
            });

        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['staff_id' => 'A staff ID conflict occurred. Please try submitting again.']);

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['general' => 'Something went wrong while saving the staff member: ' . $e->getMessage()]);
        }

        return redirect()->route('staff.index')
            ->with('success', 'Staff member added successfully.');
    }

    public function update(Request $request, string $id)
    {
        $staff = Staff::findOrFail($id);

        $validated = $request->validate([
            'first_name'     => 'required|string',
            'last_name'      => 'required|string',
            'position'       => 'required|string',
            'address'        => 'required|string',
            'phone'          => 'required|string',
            'date_of_birth'  => 'required|date',
            'sex'            => 'required|in:Male,Female,Other',
            'current_salary' => 'required|numeric',
            'hours_per_week' => 'required|integer',
            'contract_type'  => 'required|in:Full-time,Part-time',
            'pay_type'       => 'required|in:Monthly,Weekly',
            'NIN'            => 'required|string|unique:staff,NIN,' . $id . ',staff_id',
            'salary_scale'   => 'required|string',
        ]);

        DB::transaction(function () use ($staff, $validated) {

            $oldPosition = strtolower($staff->position);
            $newPosition = strtolower($validated['position']);

            $wasDoctor = str_contains($oldPosition, 'doctor') || str_contains($oldPosition, 'consultant');
            $isDoctor  = str_contains($newPosition, 'doctor') || str_contains($newPosition, 'consultant');

            $staff->update($validated);

            if ($isDoctor) {
                // Update existing doctor record or insert if not present
                $existing = DB::table('doctors')
                    ->where('first_name', $staff->first_name)
                    ->where('last_name', $staff->last_name)
                    ->first();

                if ($existing) {
                    DB::table('doctors')->where('id', $existing->id)->update([
                        'first_name'     => $validated['first_name'],
                        'last_name'      => $validated['last_name'],
                        'specialization' => $validated['position'],
                        'phone'          => $validated['phone'],
                        'updated_at'     => now(),
                    ]);
                } else {
                    DB::table('doctors')->insert([
                        'first_name'     => $validated['first_name'],
                        'last_name'      => $validated['last_name'],
                        'specialization' => $validated['position'],
                        'phone'          => $validated['phone'],
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ]);
                }
            } elseif ($wasDoctor && !$isDoctor) {
                // Position changed away from Doctor/Consultant — remove from doctors table
                DB::table('doctors')
                    ->where('first_name', $staff->first_name)
                    ->where('last_name', $staff->last_name)
                    ->delete();
            }
        });

        return redirect()->route('staff.show', $id)->with('success', 'Staff member updated.');
    }

    public function destroy(string $id)
    {
        $staff    = Staff::findOrFail($id);
        $position = strtolower($staff->position);

        // Delete related qualifications (foreign key constraint)
        $staff->qualifications()->delete();

        // Delete related work experiences (foreign key constraint)
        $staff->workExperiences()->delete();

        // Delete from staff_ward junction table
        $staff->wards()->detach();

        // Remove from doctors table if applicable
        if (str_contains($position, 'doctor') || str_contains($position, 'consultant')) {
            DB::table('doctors')
                ->where('first_name', $staff->first_name)
                ->where('last_name', $staff->last_name)
                ->delete();
        }

        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Staff member deleted.');
    }
}