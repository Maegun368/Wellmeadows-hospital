<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Stat Cards ────────────────────────────────────────────────

        $totalPatients = DB::table('patients')->count();

        // Admitted = has a ward assigned and an admission date
        $admitted = DB::table('patients')
            ->whereNotNull('admission_date')
            ->whereNotNull('ward')
            ->count();

        // Outpatients = distinct patients in out_patients table
        $outpatients = DB::table('out_patients')
            ->distinct('patient_id')
            ->count('patient_id');

        // Beds available = total beds across all wards minus active bed allocations
        $totalBeds = DB::table('wards')->sum('total_beds');

        $occupiedBeds = DB::table('bed_allocations')
            ->whereNotNull('date_placed')
            ->whereNull('actual_leave_date')
            ->count();

        $bedsAvailable = max(0, $totalBeds - $occupiedBeds);

        // Deltas
        $thisWeekPatients = DB::table('patients')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])
            ->count();

        $todayAdmitted = DB::table('patients')
            ->whereDate('admission_date', Carbon::today())
            ->count();

        $todayOutpatients = DB::table('out_patients')
            ->whereDate('visit_date', Carbon::today())
            ->count();

        $stats = [
            'total_patients'    => $totalPatients,
            'total_delta'       => '+' . $thisWeekPatients . ' this week',
            'admitted'          => $admitted,
            'admitted_delta'    => ($todayAdmitted >= 0 ? '+' : '') . $todayAdmitted . ' today',
            'outpatients'       => $outpatients,
            'outpatients_delta' => ($todayOutpatients >= 0 ? '+' : '') . $todayOutpatients . ' today',
            'beds_available'    => $bedsAvailable,
            'beds_status'       => $bedsAvailable <= 15 ? 'Low capacity' : 'Available',
        ];

        // ── 7-Day Admissions Chart ────────────────────────────────────

        $admissionsChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $admittedDay = DB::table('patients')
                ->whereDate('admission_date', $date)
                ->count();

            $dischargedDay = DB::table('bed_allocations')
                ->whereDate('actual_leave_date', $date)
                ->count();

            $admissionsChart[] = [
                'day'        => $date->format('D'),
                'admitted'   => $admittedDay,
                'discharged' => $dischargedDay,
            ];
        }

        // ── Ward Occupancy ────────────────────────────────────────────

        $wards = DB::table('wards')->get()->map(function ($ward) {
            $occupied = DB::table('bed_allocations')
                ->where('ward_id', $ward->ward_id)
                ->whereNotNull('date_placed')
                ->whereNull('actual_leave_date')
                ->count();

            $pct = $ward->total_beds > 0
                ? round(($occupied / $ward->total_beds) * 100)
                : 0;

            return [
                'name'     => $ward->ward_name,
                'occupied' => $occupied,
                'total'    => $ward->total_beds,
                'pct'      => $pct,
            ];
        })->toArray();

        // ── Today's Appointments ──────────────────────────────────────

        $appointments = DB::table('appointments')
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            ->join('doctors', 'appointments.consultant_id', '=', 'doctors.id')
            ->whereDate('appointments.appointment_date', Carbon::today())
            ->select(
                DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) as patient"),
                DB::raw("CONCAT('Dr. ', doctors.last_name) as doctor"),
                DB::raw("CASE
                    WHEN appointments.appointment_time < CURRENT_TIME THEN 'Done'
                    ELSE 'Waiting'
                END as status")
            )
            ->limit(5)
            ->get()
            ->toArray();

        // ── Patient Type Breakdown (Donut) ────────────────────────────

        $discharged = DB::table('bed_allocations')
            ->whereNotNull('actual_leave_date')
            ->distinct('patient_id')
            ->count('patient_id');

        $patientBreakdown = [
            'admitted'   => $admitted,
            'outpatient' => $outpatients,
            'discharged' => $discharged,
        ];

        return view('dashboard.index', compact(
            'stats',
            'admissionsChart',
            'wards',
            'appointments',
            'patientBreakdown'
        ));
    }
}