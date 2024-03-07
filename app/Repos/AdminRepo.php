<?php

namespace App\Repos;

use App\Core\AppResult;
use App\Helpers\NumberHelper;
use App\Models\Admin;
use App\Models\Models\City;
use App\Models\User;
use Validator,Auth,Artisan,Hash,File,Crypt;

class AdminRepo{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param $filter
     * @return mixed
     */
    public function get($filter)
    {
        $cities=Admin::orderBy('id','desc');
        $cities=$cities->paginate(10);
        return $cities;
    }


    /**
     * @param $id
     * @return AppResult
     */
    public function getAdminById($id)
    {
        $admin=Admin::findOrfail($id);
        return AppResult::success($admin);
    }

    /**
     * @param $email
     * @return AppResult
     */
    public function getAdminByEmail($email){
        $admin=Admin::where('email',$email)->first();
        if(is_null($admin))
            return AppResult::error('email not found');
        return AppResult::success($admin);
    }

    /**
     * @param $payload
     * @return City
     */
    public function create($payload)
    {
        $city=new City();
        $city->name_ar=$payload->name_ar;
        $city->name_en=$payload->name_en;
        $city->save();
        return $city;
    }

    /***
     * @param $payload
     * @param $admin
     * @return mixed
     */
    public function update($payload,$admin)
    {
        $admin->name=$payload->name;
        $admin->email=$payload->email;
        if($payload->image){
            deleteFile('Admin',$admin->image);
            $admin->image=saveImage('Admin',$payload->image);
        }
        if($payload->password)
            $admin->password=Hash::make($payload->password);
        $admin->save();
        return $admin;
    }

    /**
     * @param $admin
     */
    public function generatePasswordCode($admin){
        $admin->code = NumberHelper::getInstance()->generateCode();
        $admin->save();
    }

    /**
     * @param $admin
     * @param $newPassword
     */
    public function changePassword($admin,$newPassword){
        $admin->password=Hash::make($newPassword);
        $admin->save();
    }

    /**
     * @param $admin
     */
    public function delete($admin)
    {
        $admin->delete();
    }


}
