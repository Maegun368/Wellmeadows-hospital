<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientMedication extends Model
{
    protected $primaryKey = 'medication_id';

    protected $fillable = [
        'patient_id', 'drug_no',
        'method_of_admin', 'units_per_day',
        'start_date', 'finish_date'
    ];

    public function patient() {
        return $this->belongsTo(Patient::class, 'patient_id', 'patient_id');
    }

    public function pharmaceutical() {
        return $this->belongsTo(Pharmaceutical::class, 'drug_no', 'drug_no');
    }
}