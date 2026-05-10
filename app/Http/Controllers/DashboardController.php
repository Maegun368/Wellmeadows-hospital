<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPatients = DB::table('patients')->count();

        $admitted = DB::table('bed_allocations')
            ->whereNotNull('date_placed')
            ->whereNull('actual_leave_date')
            ->distinct('patient_id')
            ->count('patient_id');

        $outpatients = DB::table('out_patients')
            ->distinct('patient_id')
            ->count('patient_id');

        $totalBeds = DB::table('wards')->sum('total_beds');

        $occupiedBeds = DB::table('bed_allocations')
            ->whereNotNull('date_placed')
            ->whereNull('actual_leave_date')
            ->count();

        $bedsAvailable = max(0, $totalBeds - $occupiedBeds);

        $thisWeekPatients = DB::table('patients')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])
            ->count();

        $todayAdmitted = DB::table('bed_allocations')
            ->whereDate('date_placed', Carbon::today())
            ->whereNull('actual_leave_date')
            ->count();

        $todayOutpatients = DB::table('out_patients')
            ->whereDate('appointment_date', Carbon::today())
            ->count();

        $stats = [
            'total_patients'    => $totalPatients,
            'total_delta'       => '+'.$thisWeekPatients.' this week',
            'admitted'          => $admitted,
            'admitted_delta'    => ($todayAdmitted >= 0 ? '+' : '').$todayAdmitted.' today',
            'outpatients'       => $outpatients,
            'outpatients_delta' => ($todayOutpatients >= 0 ? '+' : '').$todayOutpatients.' today',
            'beds_available'    => $bedsAvailable,
            'beds_status'       => $bedsAvailable <= 15 ? 'Low capacity' : 'Available',
        ];

        $admissionsChart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $admittedDay = DB::table('bed_allocations')
                ->whereDate('date_placed', $date)
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

        $appointments = DB::table('appointments')
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            ->join('doctors', 'appointments.consultant_id', '=', 'doctors.id')
            ->whereDate('appointments.appointment_date', Carbon::today())
            ->select(
                DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) as patient"),
                DB::raw("COALESCE(NULLIF(doctors.full_name, ''), CONCAT(doctors.first_name, ' ', doctors.last_name)) as doctor"),
                DB::raw("CASE
                    WHEN appointments.appointment_time < CURRENT_TIME THEN 'Done'
                    ELSE 'Waiting'
                END as status")
            )
            ->limit(5)
            ->get()
            ->toArray();

        $discharged = DB::table('bed_allocations')
            ->whereNotNull('actual_leave_date')
            ->distinct('patient_id')
            ->count('patient_id');

        $patientBreakdown = [
            'admitted'   => $admitted,
            'outpatient' => $outpatients,
            'discharged' => $discharged,
        ];

        return view('dashboard', compact(
            'stats',
            'admissionsChart',
            'wards',
            'appointments',
            'patientBreakdown'
        ));
    }
}
