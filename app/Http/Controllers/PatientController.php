<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\NextOfKin;
use App\Models\OutPatient;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function index()
    {
        $totalPatients = Patient::count();

        $admitted = Patient::query()
            ->whereHas('bedAllocations', function ($q) {
                $q->whereNull('actual_leave_date')->whereNotNull('date_placed');
            })
            ->count();

        $outpatients = (int) DB::table('out_patients')->selectRaw('count(distinct patient_id) as c')->value('c');

        $discharged = Patient::query()
            ->whereDoesntHave('bedAllocations', function ($q) {
                $q->whereNull('actual_leave_date')->whereNotNull('date_placed');
            })
            ->count();

        $recentPatients = Patient::query()
            ->with([
                'bedAllocations' => function ($q) {
                    $q->whereNull('actual_leave_date')->with('ward');
                },
                'nextOfKins',
                'assignedDoctor',
            ])
            ->latest()
            ->take(5)
            ->get();

        $wardStats = DB::table('bed_allocations as ba')
            ->join('wards as w', 'ba.ward_id', '=', 'w.ward_id')
            ->whereNull('ba.actual_leave_date')
            ->whereNotNull('ba.date_placed')
            ->select('w.ward_name as ward_name', DB::raw('count(*) as count'))
            ->groupBy('w.ward_id', 'w.ward_name')
            ->orderByDesc('count')
            ->take(6)
            ->get();

        $totalBeds = (int) DB::table('wards')->sum('total_beds');
        $occupiedBeds = DB::table('bed_allocations')
            ->whereNull('actual_leave_date')
            ->whereNotNull('date_placed')
            ->count();
        $freeBeds = max(0, $totalBeds - $occupiedBeds);

        $recentKin = NextOfKin::with('patient')->latest()->take(4)->get();

        $avgStay = DB::table('bed_allocations')
            ->whereNotNull('date_placed')
            ->whereNull('actual_leave_date')
            ->selectRaw('ROUND(AVG(CURRENT_DATE - date_placed::date), 1) as avg')
            ->value('avg');

        return view('dashboard', compact(
            'totalPatients',
            'admitted',
            'outpatients',
            'discharged',
            'recentPatients',
            'wardStats',
            'freeBeds',
            'recentKin',
            'avgStay'
        ));
    }

    public function list()
    {
        $patients = Patient::query()
            ->with([
                'bedAllocations' => function ($q) {
                    $q->whereNull('actual_leave_date')->with('ward');
                },
                'nextOfKins',
                'assignedDoctor',
            ])
            ->latest()
            ->paginate(15);

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'first_name'           => 'required|string',
            'last_name'            => 'required|string',
            'date_of_birth'        => 'required|date',
            'sex'                  => 'required|in:Male,Female,Other',
            'marital_status'       => 'nullable|string',
            'address'              => 'nullable|string',
            'phone'                => 'nullable|string',
            'date_of_registration' => 'nullable|date',
            'ward'                 => 'nullable|string',
            'admission_date'       => 'nullable|date',
            'doctor'               => 'nullable|string',
            'kin_name'             => 'nullable|string',
            'kin_relationship'     => 'nullable|string',
            'kin_phone'            => 'nullable|string',
        ]);

        $patient = Patient::create([
            'first_name'      => $v['first_name'],
            'last_name'       => $v['last_name'],
            'date_of_birth'   => $v['date_of_birth'],
            'sex'             => $v['sex'],
            'marital_status'  => $v['marital_status'] ?? null,
            'address'         => $v['address'] ?? null,
            'phone'           => $v['phone'] ?? null,
            'date_registered' => $v['date_of_registration'] ?? null,
            'doctor_id'       => $this->doctorIdFromName($v['doctor'] ?? null),
        ]);

        $this->syncNextOfKin($patient, $request);

        return redirect()->route('patients.index')->with('success', 'Patient registered.');
    }

    public function show(Patient $patient)
    {
        $patient->load([
            'bedAllocations' => function ($q) {
                $q->whereNull('actual_leave_date')->with('ward');
            },
            'nextOfKins',
            'assignedDoctor',
        ]);

        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        $patient->load(['nextOfKins', 'assignedDoctor']);

        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $v = $request->validate([
            'first_name'            => 'required|string',
            'last_name'             => 'required|string',
            'date_of_birth'         => 'required|date',
            'sex'                   => 'required|in:Male,Female,Other',
            'marital_status'        => 'nullable|string',
            'address'               => 'nullable|string',
            'phone'                 => 'nullable|string',
            'date_of_registration'  => 'nullable|date',
            'ward'                  => 'nullable|string',
            'admission_date'        => 'nullable|date',
            'doctor'                => 'nullable|string',
            'kin_name'              => 'nullable|string',
            'kin_relationship'      => 'nullable|string',
            'kin_phone'             => 'nullable|string',
        ]);

        $patient->update([
            'first_name'      => $v['first_name'],
            'last_name'       => $v['last_name'],
            'date_of_birth'   => $v['date_of_birth'],
            'sex'             => $v['sex'],
            'marital_status'  => $v['marital_status'] ?? null,
            'address'         => $v['address'] ?? null,
            'phone'           => $v['phone'] ?? null,
            'date_registered' => $v['date_of_registration'] ?? null,
            'doctor_id'       => $this->doctorIdFromName($v['doctor'] ?? null),
        ]);

        $this->syncNextOfKin($patient, $request);

        return redirect()
            ->route('patients.show', $patient)
            ->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient deleted.');
    }

    private function doctorIdFromName(?string $name): ?int
    {
        if ($name === null || trim($name) === '') {
            return null;
        }

        $name = trim($name);

        $existing = Doctor::where('full_name', $name)->first();
        if ($existing) {
            return $existing->id;
        }

        $parts = preg_split('/\s+/', $name, 2);
        $first = $parts[0] ?? $name;
        $last = $parts[1] ?? '';

        $next = ((int) Doctor::max('id')) + 1;

        $doc = Doctor::create([
            'clinic_no'      => 'CLN-'.str_pad((string) $next, 5, '0', STR_PAD_LEFT),
            'full_name'      => $name,
            'first_name'     => $first,
            'last_name'      => $last,
            'address'        => null,
            'specialization' => null,
            'phone'          => null,
            'email'          => null,
        ]);

        return $doc->id;
    }

    private function syncNextOfKin(Patient $patient, Request $request): void
    {
        $patient->nextOfKins()->delete();

        if ($request->filled('kin_name') || $request->filled('kin_phone') || $request->filled('kin_relationship')) {
            NextOfKin::create([
                'patient_id'    => $patient->id,
                'name'          => $request->input('kin_name') ?: '—',
                'relationship'  => $request->input('kin_relationship') ?? '',
                'address'       => '',
                'phone'         => $request->input('kin_phone') ?? '',
            ]);
        }
    }
}
