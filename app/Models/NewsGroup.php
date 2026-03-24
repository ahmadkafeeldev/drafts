<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsGroup extends Model
{
    use HasFactory;
    protected $table = "news_groups";

    protected $hidden = ['created_at', 'updated_at'];
}
