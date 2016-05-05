<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/22
 * Time: 下午6:34
 */
class VoteGetbattleController
{
    public function execute($request)
    {
        if (!isset($request['battle_id'])) {
            throw new Exception('参数错误!', 1000);
        } else {


            return VoteModel::getAppointBattle($request);

        }

    }
}