<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'gender',
        'contact_number',
        'address',
        'blood_type',
        'ward',
        'bed_number',
        'admission_date',
        'medical_record',
    ];
}