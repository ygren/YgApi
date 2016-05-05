<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/9/22
 * Time: 下午4:39
 */
class CommentGetController
{
    public function execute($request)
    {
        if (!isset($request['pic_id'])) {
            throw new Exception('参数错误!', 1000);
        } else {


            return CommentModel::getComment($request);

        }

    }
}