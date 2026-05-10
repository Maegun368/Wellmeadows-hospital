<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutPatient extends Model
{
    protected $table = 'out_patients';

    protected $fillable = [
        'patient_id',
        'appointment_date',
        'appointment_time',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
