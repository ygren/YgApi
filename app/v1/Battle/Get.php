<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/9/22
 * Time: 下午4:49
 */
class BattleGetController
{
    public function execute($request)
    {
        return BattleModel::getBattle($request);
    }
}