<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'shopName' => $this->shopName,
            'shopMobile'=>$this->mobile,
            'percentage'=> $this->percentage,
            'status' => (int)$this->status,
            'qrCode' => new QrCodeResource($this->qrCode),
            'user'=>new UserResource($this->user)
        ];
    }
}
