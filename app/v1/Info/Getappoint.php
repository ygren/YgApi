<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/21
 * Time: 下午4:46
 */
class InfoGetappointController
{
    public function execute($request)
    {
        if (!isset($request['uid'])) {
            throw new Exception('参数错误!', 1000);
        } else {


            return InfoModel::getAppoint($request);

        }
    }

}