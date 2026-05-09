<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutPatient extends Model
{
    protected $fillable = [
        'patient_id',
        'visit_date',
        'reason',
        'doctor_id',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}