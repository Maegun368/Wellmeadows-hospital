<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\OutPatient;
use App\Models\NextOfKin;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function index()
    {
        $totalPatients = Patient::count();
        $admitted      = Patient::whereNotNull('ward')->where('ward', '!=', '')->count();
        $outpatients   = OutPatient::count();

        $discharged = Patient::where(function ($q) {
            $q->whereNull('ward')->orWhere('ward', '');
        })->count();

        $recentPatients = Patient::latest()->take(5)->get();

        $wardStats = DB::table('patients')
            ->select('ward as ward_name', DB::raw('count(*) as count'))
            ->whereNotNull('ward')
            ->where('ward', '!=', '')
            ->groupBy('ward')
            ->orderByDesc('count')
            ->take(6)
            ->get();

        try {
            $freeBeds = DB::table('wards')->sum('available_beds') ?? 0;
        } catch (\Exception $e) {
            $freeBeds = 0;
        }

        $recentKin = NextOfKin::with('patient')->latest()->take(4)->get();

        $avgStay = Patient::whereNotNull('admission_date')
            ->whereNotNull('ward')
            ->where('ward', '!=', '')
            ->selectRaw("ROUND(AVG(CURRENT_DATE - admission_date::date), 1) as avg")
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

    public function create()
    {
        return view('patients.create');
    }

    // ← only ONE store() here
    public function store(Request $request)
    {
        Patient::create($request->validate([
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
        ]));

        return redirect()->route('patients.index')->with('success', 'Patient registered.');
    }

    public function show(string $id)
    {
        $patient = Patient::findOrFail($id);
        return view('patients.show', compact('patient'));
    }

    public function edit(string $id)
    {
        $patient = Patient::findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, string $id)
    {
        // add your update logic here
    }

    public function destroy(string $id)
    {
        Patient::findOrFail($id)->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted.');
    }
}