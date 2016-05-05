<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/8
 * Time: 下午5:42
 */
class BattleGetappointController
{
    public function execute($request)
    {
        return BattleModel::getAppointBattle($request);
    }
}