<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $table = 'work_experience'; // Laravel defaults to 'work_experiences' — override to singular

    protected $primaryKey = 'experience_id';

    protected $fillable = [
        'staff_no',
        'organisation_name',
        'position',
        'start_date',
        'finish_date',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_no', 'staff_id');
    }
}