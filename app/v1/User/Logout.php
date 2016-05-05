<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/12
 * Time: 下午6:09
 */
class UserLogoutController
{
    public function execute($request)
    {
        if (!isset($request['username']) || !isset($request['accessToken'])) {
            throw new Exception('参数错误!', 1000);
        } else {
            if (!UserModel::checkLogin($request)) {
                throw new Exception("操作失败，该用户未登录", 1005);

            } else {
                return UserModel::logout($request);
            }
        }
    }
}