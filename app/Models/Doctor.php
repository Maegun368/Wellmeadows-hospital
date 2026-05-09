<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'specialization',
        'phone',
        'email',
    ];

    public function outPatients()
    {
        return $this->hasMany(OutPatient::class, 'doctor_id');
    }
}