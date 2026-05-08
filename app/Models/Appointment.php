<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $primaryKey = 'appointment_id';

    protected $fillable = [
        'patient_id', 'consultant_id',
        'appointment_date', 'appointment_time', 'examination_room'
    ];

    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }

    public function consultant() {
        return $this->belongsTo(Staff::class, 'consultant_id', 'staff_id');
    }
}