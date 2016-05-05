<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/22
 * Time: 下午3:16
 */
class FansGetController
{
    public function execute($request)
    {
        if (!isset($request['uid'])) {
            throw new Exception('参数错误!', 1000);
        } else {
            return FansModel::get($request);
        }

    }
}
