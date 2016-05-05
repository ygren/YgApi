<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/9/30
 * Time: 下午5:14
 */
class BattleGetresurrectionController
{
    public function execute($request)
    {
        return BattleModel::getResurrectionBattle($request);
    }
}