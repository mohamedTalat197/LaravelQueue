<?php

namespace App\Repos;
use App\Core\AppResult;
use App\Helpers\ImageHelper;
use App\Helpers\NumberHelper;
use App\Models\User;
use Validator, Auth, Artisan, Hash, File, Crypt;

class UserRepo
{

    /**
     * @param $payload
     * @return User
     */
    public function create($payload)
    {
        $user = new User();
        $user->name = $payload->name;
        $user->email = $payload->email;
        $user->phone = $payload->phone;
        $user->password = Hash::make($payload->password);
        $user->status = $payload->status;
        $user->firebase = $payload->firebase;
        $user->msgCode = NumberHelper::getInstance()->generateCode();
        $user->save();
        return $user;
    }

    /**
     * @param $payload
     * @return AppResult
     */
    public function getUserByPhone($payload)
    {
        $user = User::where('phone', $payload->phone)->first();;
        if (is_null($user))
            return AppResult::error(__('responseMessage.user_not_found'));
        return AppResult::success($user);
    }


//رسايل الفاليديشن


}
