<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/8/26
 * Time: 下午8:11
 */
class FileUploadController
{
    public function execute($request)
    {
        if (!isset($request['username']) || !isset($request['accessToken']) || !isset($request['content'])
            || !isset($request['theme']) || !isset($request['original']) || !isset($request['thumb'])

        ) {
            throw new Exception('参数错误!', 1000);
        } else {
            if (!UserModel::checkLogin($request)) {
                throw new Exception("账号未登录", 1005);

            } else {
                return FileModel::upload($request);
            }

        }


    }
}