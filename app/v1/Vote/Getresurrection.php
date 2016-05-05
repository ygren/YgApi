<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/22
 * Time: 下午6:41
 */
class VoteGetresurrectionController
{
    public function execute($request)
    {
        if (!isset($request['resurrection_id'])) {
            throw new Exception('参数错误!', 1000);
        } else {


            return VoteModel::getAppointResurrection($request);

        }

    }
}