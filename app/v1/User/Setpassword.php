<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/8/28
 * Time: 下午2:28
 */
class UserSetpasswordController
{
    public function execute($request)
    {
        if (!UserModel::checkLogin($request)) {
            throw new Exception(2001, "账号未登录");

        }
        return UserModel::setPassword($request);
    }

}