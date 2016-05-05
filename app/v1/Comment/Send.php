<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/9/22
 * Time: 下午4:39
 */
class CommentSendController
{
    public function execute($request)
    {
        if (!isset($request['username']) || !isset($request['accessToken']) || !isset($request['contentComment'])
            || !isset($request['pic_id'])

        ) {
            throw new Exception('参数错误!', 1000);
        } else {
            if (!UserModel::checkLogin($request)) {
                throw new Exception("操作失败，该用户未登录", 1005);

            } else {

                return CommentModel::sendComment($request);
            }
        }

    }
}