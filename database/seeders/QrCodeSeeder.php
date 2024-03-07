<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\QrCode;



class QrCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $qrCodes = [
            ['number' => 'QR123'],
            ['number' => 'QR456'],
            ['number' => 'QR789'],
        ];

        foreach ($qrCodes as $qrCode) {
            QrCode::create($qrCode);
        }
    }
}
