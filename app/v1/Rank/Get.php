<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/8
 * Time: 下午5:26
 */
class RankGetController
{
    public function execute($request)
    {
        return RankModel::Get($request);
    }
}