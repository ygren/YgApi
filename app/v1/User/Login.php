<?php

class UserLoginController
{
    public function execute($request)
    {
        if (!isset($request['username']) || !isset($request['password']) || !isset($request['cid'])
            || !isset($request['device_name']) || !isset($request['operating_system']) ||
            !isset($request['imei_code'])
        ) {
            throw new Exception('参数错误!', 1000);
        } else {
            return UserModel::login($request);
        }

    }

}