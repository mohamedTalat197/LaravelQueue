<?php

namespace App\Validations;

use App\Core\AppResult;
use Validator,Auth;

class AdminValidation
{
    /***
     * @param $payload
     *  i can customize error messages
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|mixed
     */
    public function validate($payload)
    {
        $input = $payload->all();
        $admin_id=$payload->admin_id ? $payload->admin_id : null;
        $validationMessages = [
            'name.required' => __('validationMessage.name_required'),
            'email.required' => __('validationMessage.email_required'),
            'email.unique' => __('validationMessage.email_unique'),
        ];
        $validator = Validator::make($input, [
            'email' => $admin_id  ? 'required|unique:admins,email,'.$admin_id.'|regex:/(.+)@(.+)\.(.+)/i' : 'required|unique:admins|regex:/(.+)@(.+)\.(.+)/i',
            'name' =>  'required' ,
            'image' =>  'image' ,
            'password' => $admin_id ? '' : 'required'  ,
        ],$validationMessages);
        if ($validator->fails()) {
            return AppResult::error($validator->messages()->first());
        }
        return AppResult::success(null);
    }
}
