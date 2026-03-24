<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;
    
    protected $table = "bookings";
    protected $hidden = ['created_at', 'updated_at'];
    
    protected $fillable = [
        'title',
        'order_type',
        'status',
        'geometry',
        'latitude',
        'longitude',
        'map_layer',
        'effective_from',
        'news_paper_id',
        'area',
        'borough',
        'user_id'
    ];

    protected $casts = [
        'geometry' => 'array',
        'effective_from' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];
    
    
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
