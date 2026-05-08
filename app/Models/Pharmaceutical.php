<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pharmaceutical extends Model
{
    protected $primaryKey = 'drug_no';

    protected $fillable = [
        'supplier_no', 'drug_name', 'description',
        'dosage', 'method_of_admin', 'quantity_in_stock',
        'reorder_level', 'cost_per_unit'
    ];
}