<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class AdminResource extends JsonResource
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
            'status' => (int)$this->status,
            'code' => (int)$this->code,
            'phone' => $this->phone,
            'email' => $this->email,
            'image' => getImageUrl('Admin',$this->image),
            'token' => $this->my_token,
        ];
    }
}
