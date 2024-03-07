<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    public function vendor()
    {
        return $this->hasOne(Vendor::class,'qr_id');
    }
}
