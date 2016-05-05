<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/8/28
 * Time: 下午2:50
 */
class FileSetheadpicController
{
    public function execute($request)
    {
        if (!isset($request['username']) || !isset($request['accessToken']) || !isset($request['headpic'])) {
            throw new Exception('参数错误!', 1000);
        } else {
            if (!UserModel::checkLogin($request)) {
                throw new Exception("操作失败，该用户未登录！", 1005);

            } else {
                return FileModel::setHeadPic($request);
            }

        }


    }

}