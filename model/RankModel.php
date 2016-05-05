<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/8
 * Time: 下午5:26
 */
class RankModel
{
    public static function Get($request)
    {
        return array(
            'Code' => 0,
            'Message' => "获取当日排行榜成功",
            'Data' => array(
                'person' => \DB::table('jt_post_pic')->getAll(array(
                    //'createtime'=>array('between',date('Y-m-d 00:00:00'),date('Y-m-d 00:00:00.00',strtotime("+1 day"))),
                    'createtime' => array('between', date('Y-m-d') . ' ' . '00:00:00', date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),
                    'order' => 'level desc',
                    'limit' => '0,100',
                    'jt_theme_id' => \DB::table('jt_theme')->getVal('id', array(
                        'updatetime' => array('between', date('Y-m-d') . ' ' . '00:00:00',
                            date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),
                        'theme_code' => "person"
                    ))

                )),
                'food' => \DB::table('jt_post_pic')->getAll(array(
                    //'createtime'=>array('between',date('Y-m-d 00:00:00'),date('Y-m-d 00:00:00.00',strtotime("+1 day"))),
                    'createtime' => array('between', date('Y-m-d') . ' ' . '00:00:00', date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),
                    'order' => 'level desc',
                    'limit' => '0,100',
                    'jt_theme_id' => \DB::table('jt_theme')->getVal('id', array(
                        'updatetime' => array('between', date('Y-m-d') . ' ' . '00:00:00',
                            date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),
                        'theme_code' => "food"
                    ))

                )),
                'memory' => \DB::table('jt_post_pic')->getAll(array(
                    //'createtime'=>array('between',date('Y-m-d 00:00:00'),date('Y-m-d 00:00:00.00',strtotime("+1 day"))),
                    'createtime' => array('between', date('Y-m-d') . ' ' . '00:00:00', date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),
                    'order' => 'level desc',
                    'limit' => '0,100',
                    'jt_theme_id' => \DB::table('jt_theme')->getVal('id', array(
                        'updatetime' => array('between', date('Y-m-d') . ' ' . '00:00:00',
                            date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),
                        'theme_code' => "memory"
                    ))

                )),
                'complain' => \DB::table('jt_post_pic')->getAll(array(
                    //'createtime'=>array('between',date('Y-m-d 00:00:00'),date('Y-m-d 00:00:00.00',strtotime("+1 day"))),
                    'updatetime' => array('between', date('Y-m-d') . ' ' . '00:00:00', date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),
                    'order' => 'level desc',
                    'limit' => '0,100',
                    'jt_theme_id' => \DB::table('jt_theme')->getVal('id', array(
                        'updatetime' => array('between', date('Y-m-d') . ' ' . '00:00:00',
                            date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),
                        'theme_code' => "complain"
                    ))

                )),
                'alterone' => \DB::table('jt_post_pic')->getAll(array(
                    //'createtime'=>array('between',date('Y-m-d 00:00:00'),date('Y-m-d 00:00:00.00',strtotime("+1 day"))),
                    'createtime' => array('between', date('Y-m-d') . ' ' . '00:00:00', date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),
                    'order' => 'level desc',
                    'limit' => '0,100',
                    'jt_theme_id' => \DB::table('jt_theme')->getVal('id', array(
                        'updatetime' => array('between', date('Y-m-d') . ' ' . '00:00:00',
                            date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),
                        'theme_code' => "alterone"
                    ))

                )),
                'altertwo' => \DB::table('jt_post_pic')->getAll(array(
                    //'createtime'=>array('between',date('Y-m-d 00:00:00'),date('Y-m-d 00:00:00.00',strtotime("+1 day"))),
                    'createtime' => array('between', date('Y-m-d') . ' ' . '00:00:00', date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),
                    'order' => 'level desc',
                    'limit' => '0,100',
                    'jt_theme_id' => \DB::table('jt_theme')->getVal('id', array(
                        'updatetime' => array('between', date('Y-m-d') . ' ' . '00:00:00',
                            date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),
                        'theme_code' => "altertwo"
                    ))

                )),
            )


        );
    }
}