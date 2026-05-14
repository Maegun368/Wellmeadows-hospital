<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $primaryKey = 'qualification_id'; // adjust if your PK name differs

    protected $fillable = [
        'staff_no',
        'qualification_type',
        'qualification_date',
        'institution_name',
    ];

    /**
     * belongsTo(Related, foreignKey on THIS table, ownerKey on Staff table)
     *
     * This model's "staff_no" column holds the value of staff.staff_id.
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_no', 'staff_id');
    }
}