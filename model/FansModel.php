<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/22
 * Time: 下午3:17
 */
class FansModel
{
    public static function get($request)
    {
        return array(
            'Code' => 0,
            'Message' => "获取粉丝列表成功",
            'Data' => \DB::table('jt_follow')->getAll(
                array(
                    'field' => 'id,fans',
                    'order' => 'createtime desc',
                    'follow' => $request['uid']

                )
            )
        );
    }
}