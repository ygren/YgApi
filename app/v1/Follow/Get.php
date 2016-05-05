<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/22
 * Time: 下午2:03
 */
class FollowGetController
{
    public function execute($request)
    {
        if (!isset($request['uid'])) {
            throw new Exception('参数错误!', 1000);
        } else {
            return FollowModel::get($request);
        }

    }
}