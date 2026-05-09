<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BedAllocation extends Model
{
    protected $primaryKey = 'allocation_id';

    protected $fillable = [
        'ward_id',
        'patient_id',
        'bed_number',
        'date_placed_waiting',
        'expected_duration_days',
        'date_placed',
        'date_expected_leave',
        'actual_leave_date',
    ];

    protected $casts = [
        'date_placed_waiting'  => 'date',
        'date_placed'          => 'date',
        'date_expected_leave'  => 'date',
        'actual_leave_date'    => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeOccupied($query)
    {
        return $query->whereNull('actual_leave_date');
    }

    public function scopeDischarged($query)
    {
        return $query->whereNotNull('actual_leave_date');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isOccupied(): bool
    {
        return is_null($this->actual_leave_date);
    }
}