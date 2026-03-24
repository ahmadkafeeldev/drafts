<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;
    
    protected $table = "bookings";
    protected $hidden = ['created_at', 'updated_at'];
    
    
    // Relationship with the NewsPaper model
    public function newsPaper()
    {
        return $this->belongsTo(NewsPaper::class, 'news_paper_id');
    }

    // Relationship with the Area model
    public function area()
    {
        return $this->belongsTo(Area::class, 'area');
    }

    // Relationship with the Borough model
    public function borough()
    {
        return $this->belongsTo(Borough::class, 'borough');
    }
}
