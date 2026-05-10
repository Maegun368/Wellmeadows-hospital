<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'clinic_no',
        'full_name',
        'address',
        'first_name',
        'last_name',
        'specialization',
        'phone',
        'email',
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class, 'doctor_id');
    }
}
