<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftsModel extends Model
{
    use HasFactory;

    // INSERT INTO `drafts`(`id`, `booking_type`, `order_type`) VALUES

    protected $table = 'drafts';
    protected $guarded = ['id'];

    protected $fillable = [
        'booking_type',
        'order_type',
    ];

}
