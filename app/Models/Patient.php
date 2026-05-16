<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'sex',
        'marital_status',
        'phone',
        'address',
        'date_registered',
    ];

    protected $casts = [
        'date_of_birth'   => 'date',
        'date_registered' => 'date',
    ];

    public function assignedDoctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function bedAllocations()
    {
        return $this->hasMany(BedAllocation::class, 'patient_id');
    }

    public function activeBedAllocations()
    {
        return $this->bedAllocations()->whereNull('actual_leave_date');
    }

    public function nextOfKins()
    {
        return $this->hasMany(NextOfKin::class, 'patient_id');
    }

    protected function age(): Attribute
    {
        return Attribute::get(fn () => $this->date_of_birth?->age);
    }

    /** Virtual: ERD places ward on BED_ALLOCATION — keeps existing blades working. */
    protected function ward(): Attribute
    {
        return Attribute::get(function () {
            $alloc = $this->relationLoaded('bedAllocations')
                ? $this->bedAllocations->first(fn ($b) => is_null($b->actual_leave_date))
                : $this->activeBedAllocations()->with('ward')->first();

            return $alloc?->ward?->ward_name;
        });
    }

    /** Virtual: admission = active allocation date_placed */
    protected function admissionDate(): Attribute
    {
        return Attribute::get(function () {
            $alloc = $this->relationLoaded('bedAllocations')
                ? $this->bedAllocations->first(fn ($b) => is_null($b->actual_leave_date))
                : $this->activeBedAllocations()->first();

            return $alloc?->date_placed;
        });
    }

    /** Virtual: doctor display name from DOCTOR entity */
    protected function doctor(): Attribute
    {
        return Attribute::get(fn () => $this->assignedDoctor?->full_name);
    }

    /** Not in ERD — blades still reference; always empty. */
    protected function bloodType(): Attribute
    {
        return Attribute::get(fn () => null);
    }

    protected function kinName(): Attribute
    {
        return Attribute::get(fn () => $this->nextOfKins->first()?->name);
    }

    protected function kinRelationship(): Attribute
    {
        return Attribute::get(fn () => $this->nextOfKins->first()?->relationship);
    }

    protected function kinPhone(): Attribute
    {
        return Attribute::get(fn () => $this->nextOfKins->first()?->phone);
    }
}
