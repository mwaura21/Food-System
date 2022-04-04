<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    protected $table = 'counties';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function customers()
    {

        return $this->hasMany(Customer::class, 'counties');

    }

    public function vendors()
    {

        return $this->hasMany(Vendor::class, 'counties');
        
    }

}
