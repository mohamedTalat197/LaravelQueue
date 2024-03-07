<?php

namespace App\Repos;
use App\Core\AppResult;
use App\Helpers\ImageHelper;
use App\Helpers\NumberHelper;
use App\Models\Vendor;
use Validator, Auth, Artisan, Hash, File, Crypt;

class VendorRepo
{
    /**
     * @param $payload
     * @return Vendor
     */
    public function create($payload,$qrCode_id)
    {
        $vendor = new Vendor();
        $vendor->name = $payload->name;
        $vendor->address = $payload->address;
        $vendor->shopName = $payload->shopName;
        $vendor->mobile = $payload->mobile;
        $vendor->percentage = $payload->percentage;
        $vendor->status = $payload->status;
        $vendor->qr_id=$qrCode_id;
        $vendor->user_id=Auth::id();
        $vendor->save();
        return $vendor;
    }


    public function get($filter)
    {
        $vendors=Vendor::orderBy('id','desc');
        $limit=$filter->limit ? $filter->limit : 10;
        if($filter->parent_id)
            $vendors=$vendors->where('user_id',$filter->parent_id);
        if($filter->status)
            $vendors=$vendors->where('status',$filter->status);
        $vendors=$vendors->paginate($limit);
        return $vendors;
    }


}
