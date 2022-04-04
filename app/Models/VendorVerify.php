<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorVerify extends Model
{
    use HasFactory;

    public $table = "vendor_verify";

    /**
     * Write code on Method
     *
     * @return response()
     */
    protected $fillable = [
        'vendor_id',
        'token',
    ];
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function vendor()
    {
        
        return $this->belongsTo(Vendor::class);
        
    }
}