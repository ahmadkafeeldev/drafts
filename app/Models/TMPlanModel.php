<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TMPlanModel extends Model
{
    use HasFactory;

    protected $table = "tmplan";

    protected $fillable = [
        'user_id',
        'name',
        'geojson',
    ];
    protected $casts = [
    'geojson' => 'array',
];

}
