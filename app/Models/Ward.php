<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $primaryKey = 'ward_id';

    protected $fillable = [
        'ward_name',
        'ward_type',
        'total_beds',
        'occupied_beds',
        'available_beds',
        'location',
        'telephone_extension',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function bedAllocations()
    {
        return $this->hasMany(
            BedAllocation::class,
            'ward_id',
            'ward_id'
        );
    }

    public function activeAllocations()
    {
        return $this->hasMany(
                BedAllocation::class,
                'ward_id',
                'ward_id'
            )
            ->whereNull('actual_leave_date');
    }

    /*
    |--------------------------------------------------------------------------
    | Available Beds
    |--------------------------------------------------------------------------
    */

    public function availableBeds()
    {
        $occupied = $this->bedAllocations()
            ->whereNull('actual_leave_date')
            ->count();

        return $this->total_beds - $occupied;
    }

    /*
    |--------------------------------------------------------------------------
    | Occupied Beds
    |--------------------------------------------------------------------------
    */

    public function occupiedBeds()
    {
        return $this->bedAllocations()
            ->whereNull('actual_leave_date')
            ->count();
    }

    /*
    |--------------------------------------------------------------------------
    | Occupancy Percentage
    |--------------------------------------------------------------------------
    */

    public function occupancyPercentage()
    {
        if ($this->total_beds <= 0) {
            return 0;
        }

        return round(
            ($this->occupiedBeds() / $this->total_beds) * 100
        );
    }
}