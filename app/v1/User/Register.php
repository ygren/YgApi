<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/8/23
 * Time: 下午9:48
 */
class UserRegisterController
{
    public static function execute($request)
    {
        //if (!isset($request['username']) || !isset($request['password'])||
        //  !isset($request['device_name'])|| !isset($request['operating_system'])||
        //!isset($request['imei_code'])) {
        if (!isset($request['username']) || !isset($request['password'])) {
            throw new Exception('参数错误!', 1000);
        } else {
            return UserModel::register($request);
        }


    }
}