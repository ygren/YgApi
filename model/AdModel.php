<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/8
 * Time: 下午3:43
 */
class AdModel
{
    public static function get($request)
    {
        return array(
            'Code' => 0,
            'Message' => "几图当日宣传及广告栏内容",
            'Data' => \DB::table('jt_ad')->getAll(array(
                //'creatime'=>array('between',date("Y-m-d"),date("Y-m-d",strtotime("+1 day")))
                'createtime' => date("Y-m-d")
            ))
        );
    }
}