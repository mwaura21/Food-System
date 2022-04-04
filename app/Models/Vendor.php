<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Vendor extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    
    protected $guard = 'vendor';

    protected $table = 'vendor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'logo',
        'phone_number',
        'counties',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function countiez()
    {

        return $this->belongsTo(County::class, 'counties');

    }

    public function subvendorz()
    {

        return $this->hasMany(SubVendor::class, 'vendor');

    }

    public function vendororder()
    {

        return $this->hasMany(Order::class);
        
    }
    
}