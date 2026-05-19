<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\NextOfKin;
use App\Models\OutPatient;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    // ── Dashboard view ──────────────────────────────────────────────────────────
    public function index()
    {
        $patients = Patient::query()
            ->with([
                'bedAllocations' => fn($q) => $q->whereNull('actual_leave_date')->with('ward'),
                'nextOfKins',
                'assignedDoctor',
            ])
            ->latest()
            ->paginate(15);

        $totalPatients = Patient::count();
        $admitted      = Patient::whereHas('bedAllocations', fn($q) => $q->whereNull('actual_leave_date'))->count();
        $outpatients   = OutPatient::count();
        $noWard        = Patient::doesntHave('bedAllocations')->count();
        $nextOfKins    = NextOfKin::with('patient')->latest()->take(5)->get();

        return view('patients.index', compact(
            'patients', 'totalPatients', 'admitted', 'outpatients', 'noWard', 'nextOfKins'
        ));
    }

    // ── Full patient list ────────────────────────────────────────────────────────
    public function list()
    {
        $patients = Patient::query()
            ->with([
                'bedAllocations' => fn($q) => $q->whereNull('actual_leave_date')->with('ward'),
                'nextOfKins',
                'assignedDoctor',
            ])
            ->latest()
            ->paginate(15);

        return view('patients.list', compact('patients'));
    }

    // ── Create form ──────────────────────────────────────────────────────────────
    public function create()
    {
        return view('patients.create');
    }

    // ── Store new patient ────────────────────────────────────────────────────────
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
            'doctor'               => 'nullable|string',   // plain text field
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

    // ── Show single patient ──────────────────────────────────────────────────────
    public function show(Patient $patient)
    {
        $patient->load([
            'bedAllocations' => fn($q) => $q->whereNull('actual_leave_date')->with('ward'),
            'nextOfKins',
            'assignedDoctor',
        ]);

        return view('patients.show', compact('patient'));
    }

    // ── Edit form ────────────────────────────────────────────────────────────────
    public function edit(Patient $patient)
    {
        $patient->load(['nextOfKins', 'assignedDoctor']);

        return view('patients.edit', compact('patient'));
    }

    // ── Update patient ───────────────────────────────────────────────────────────
    public function update(Request $request, Patient $patient)
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
            'doctor'               => 'nullable|string',   // plain text field
            'kin_name'             => 'nullable|string',
            'kin_relationship'     => 'nullable|string',
            'kin_phone'            => 'nullable|string',
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

    // ── Delete patient ───────────────────────────────────────────────────────────
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.list')->with('success', 'Patient deleted.');
    }

    // ── Helpers ──────────────────────────────────────────────────────────────────

    /**
     * Resolve a doctor's typed name to an existing Doctor ID,
     * or create a new Doctor record and return its ID.
     */
    private function doctorIdFromName(?string $name): ?int
    {
        if ($name === null || trim($name) === '') {
            return null;
        }

        $name = trim($name);

        // Try matching by full_name first
        $existing = Doctor::where('full_name', $name)->first();
        if ($existing) {
            return $existing->id;
        }

        // Split into first / last name
        $parts = preg_split('/\s+/', $name, 2);
        $first = $parts[0] ?? $name;
        $last  = $parts[1] ?? '';

        $next = ((int) Doctor::max('id')) + 1;

        $doc = Doctor::create([
            'clinic_no'      => 'CLN-' . str_pad((string) $next, 5, '0', STR_PAD_LEFT),
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

    /**
     * Delete existing next-of-kin records and re-create from request data.
     */
    private function syncNextOfKin(Patient $patient, Request $request): void
    {
        $patient->nextOfKins()->delete();

        if ($request->filled('kin_name') || $request->filled('kin_phone') || $request->filled('kin_relationship')) {
            NextOfKin::create([
                'patient_id'   => $patient->id,
                'name'         => $request->input('kin_name') ?: '—',
                'relationship' => $request->input('kin_relationship') ?? '',
                'address'      => '',
                'phone'        => $request->input('kin_phone') ?? '',
            ]);
        }
    }
}