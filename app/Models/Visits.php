<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visits extends Model
{
    protected $fillable = [
        'ip',
        'type_calcul',    // 'net' ou 'brut'
        'calcul_count',   // nombre de calculs
        'pdf_count',      // nombre de PDF générés
    ];
}
