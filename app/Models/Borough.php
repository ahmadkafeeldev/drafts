<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borough extends Model
{
    use HasFactory;
    protected $table = "boroughs";

    protected $hidden = ['created_at', 'updated_at'];
}
