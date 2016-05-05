<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/1
 * Time: 上午10:10
 */
class FileSetbackgroundController
{

    public function execute($request)
    {
        if (!isset($request['username']) || !isset($request['accessToken']) || !isset($request['background'])) {
            throw new Exception('参数错误!', 1000);
        } else {
            if (!UserModel::checkLogin($request)) {
                throw new Exception(1005, "操作失败，该用户未登录！");

            } else {
                return FileModel::setBackground($request);
            }

        }

    }


}