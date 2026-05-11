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
        $freeBeds      = $bedsAvailable;

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
            $admissionsChart[] = [
                'day'        => $date->format('D'),
                'admitted'   => DB::table('bed_allocations')->whereDate('date_placed', $date)->count(),
                'discharged' => DB::table('bed_allocations')->whereDate('actual_leave_date', $date)->count(),
            ];
        }

        // Keep as Collection (no toArray) so blade can call ->count(), ->max()
        $wards = DB::table('wards')->get()->map(function ($ward) {
            $occupied = DB::table('bed_allocations')
                ->where('ward_id', $ward->ward_id)
                ->whereNotNull('date_placed')
                ->whereNull('actual_leave_date')
                ->count();

            $pct = $ward->total_beds > 0
                ? round(($occupied / $ward->total_beds) * 100)
                : 0;

            return (object) [
                'name'      => $ward->ward_name,
                'ward_name' => $ward->ward_name,
                'count'     => $occupied,
                'occupied'  => $occupied,
                'total'     => $ward->total_beds,
                'pct'       => $pct,
            ];
        });

        $wardStats = $wards;

        $appointments = DB::table('appointments')
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            ->join('doctors', 'appointments.consultant_id', '=', 'doctors.id')
            ->whereDate('appointments.appointment_date', Carbon::today())
            ->select(
                DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) as patient"),
                DB::raw("COALESCE(NULLIF(doctors.full_name, ''), CONCAT(doctors.first_name, ' ', doctors.last_name)) as doctor"),
                DB::raw("CASE WHEN appointments.appointment_time < CURRENT_TIME THEN 'Done' ELSE 'Waiting' END as status")
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

        // Collection so blade can call ->take(4)
        $recentPatients = DB::table('patients')
            ->leftJoin('bed_allocations', function ($join) {
                $join->on('bed_allocations.patient_id', '=', 'patients.id')
                     ->whereNull('bed_allocations.actual_leave_date')
                     ->whereNotNull('bed_allocations.date_placed');
            })
            ->leftJoin('wards', 'bed_allocations.ward_id', '=', 'wards.ward_id')
            ->select('patients.*', 'wards.ward_name as ward')
            ->orderBy('patients.created_at', 'desc')
            ->limit(5)
            ->get(); // no toArray()

        $recentKin = DB::table('next_of_kin')
    ->leftJoin('patients', 'next_of_kin.patient_id', '=', 'patients.id')
    ->select(
        'next_of_kin.*',
        'patients.first_name as patient_first_name',
        'patients.last_name as patient_last_name',
    )
    ->orderBy('next_of_kin.created_at', 'desc')
    ->limit(5)
    ->get();

     $avgStay = DB::table('bed_allocations')
    ->whereNotNull('date_placed')
    ->whereNotNull('actual_leave_date')
    ->selectRaw('AVG(actual_leave_date::date - date_placed::date) as avg_days')
    ->value('avg_days');
$avgStay = $avgStay ? round($avgStay, 1) : null;

        return view('dashboard', compact(
            'stats',
            'totalPatients',
            'admitted',
            'outpatients',
            'bedsAvailable',
            'freeBeds',
            'admissionsChart',
            'wards',
            'wardStats',
            'appointments',
            'discharged',
            'patientBreakdown',
            'recentPatients',
            'recentKin',
            'avgStay'
        ));
    }
}