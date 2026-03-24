<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'company_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at',
        'is_verified'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->type == USER_TYPES['admin'];
    }

    public function isUser()
    {
        return $this->type == USER_TYPES['user'];
    }

    public function isStaff()
    {
        return $this->type == USER_TYPES['staff'];
    }

    function getProfileImageAttribute($value)
    {
        if($value == "")
        {
            return $value;
        }else{
            $value = url('/').'/'.$value;
            return $value;
        }
    }

    function getFcmTokenAttribute($value)
    {
        if($value == null)
        {
            return "";
        }else{
            return $value;
        }
    }
    
    public function getLatitudeAttribute($value)
    {
        if($value == "" || $value == null)
        {
            return 0;
        }else{
            return $value;
        }
    }
    
    public function getLongitudeAttribute($value)
    {
        if($value == "" || $value == null)
        {
            return 0;
        }else{
            return $value;
        }
    }

    public function drawRequests()
    {
        return $this->hasMany(WithdrawRequest::class);
    }
}
