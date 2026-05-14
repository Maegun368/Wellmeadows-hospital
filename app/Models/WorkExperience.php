<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $table = 'work_experience'; // Laravel defaults to 'work_experiences' — override to singular

    protected $primaryKey = 'experience_id';

    protected $fillable = [
        'staff_number','position','start_date','finish_date','organisation',
     ];   
        
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_number', 'staff_id');
    }
}        
        
    

