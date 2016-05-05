<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/22
 * Time: 下午7:28
 */
class UserMessagetestController
{
    public function execute($request)
    {
        return UserModel::check($request);
    }
}
