<?php

namespace App\Repos;
use App\Core\AppResult;
use App\Helpers\ImageHelper;
use App\Helpers\NumberHelper;
use App\Models\QrCode;

use Validator, Auth, Artisan, Hash, File, Crypt;

class QrCodeRepo
{
    public function single($qrNumber)
    {
        $qrCode = QrCode::where('number', $qrNumber)->firstOrFail();
        return $qrCode;
    }
}
