<?php

namespace App\Validations;

use App\Core\AppResult;
use Validator, Auth;
use Illuminate\Validation\Rule;
use App\Models\Vendor;

class VendorValidation
{
    /**
     * Validate the vendor data.
     *
     * @param \Illuminate\Http\Request $payload
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed
     */
    public function validate($payload)
    {
        $input = $payload->all();
        $validationMessages = [
            'name.required'=> __('validationMessage.name_required'),
            'qr_id.exists' => __('validationMessage.qr_id_not_found'),
            'qr_id.unique' => __('validationMessage.qr_id_already_selected'),
        ];
        $validator = Validator::make($input, [
            'name' => 'required' ,
            'qr_id' => 'required|exists:qr_codes,number|unique:vendors,qr_id',
        ], $validationMessages);
        if ($validator->fails()) {
            return AppResult::error($validator->messages()->first());
        }
        return AppResult::success(null);
    }
}
