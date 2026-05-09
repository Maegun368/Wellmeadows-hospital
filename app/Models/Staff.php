<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $primaryKey = 'staff_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'first_name', 'last_name', 'position', 'address',
        'phone', 'date_of_birth', 'sex', 'current_salary',
        'hours_per_week', 'contract_type', 'pay_type', 'NIN', 'salary_scale'
    ];

    public function qualifications()
    {
        return $this->hasMany(Qualification::class, 'staff_id');
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class, 'staff_id');
    }

    public function wards()
    {
        return $this->belongsToMany(
            Ward::class, 'staff_ward', 'staff_id', 'ward_id'
        )->withPivot('week_start_date', 'shift');
    }
}