<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/8
 * Time: 下午3:42
 */
class AdGetController
{
    public function execute($request)
    {
        return AdModel::get($request);
    }
}