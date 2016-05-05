<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/9/21
 * Time: 下午1:58
 */
class BattleModel
{


    public static function generateBattle($request)
    {
        // 图片上传成功生成对战

        $arr = \DB::table('jt_post_pic')->getAll(array('isbattle' => 0,
            'islock' => 0, 'jt_theme_id' => $request['theme_id']
        ));
        //如果存在，选取一个，生成对战

        if ($arr) {

            $a_arr = $arr[rand(0, (count($arr) - 1))];
            if ($a_arr['id'] != $request['request_pic_id']) {

                \DB::table('jt_battle')->insert(array('left_pic_id' => $request['request_pic_id'],
                    'left_thumb_pic_path' => \DB::table('jt_post_pic')->getVal('thumb_pic'
                        , array('id' => $request['request_pic_id'])),
                    'left_original_pic_path' => \DB::table('jt_post_pic')->getVal('original_pic'
                        , array('id' => $request['request_pic_id'])),
                    'right_pic_id' => $a_arr['id'],
                    'right_thumb_pic_path' => \DB::table('jt_post_pic')->getVal('thumb_pic'
                        , array('id' => $request['request_pic_id'])),
                    'right_original_pic_path' => \DB::table('jt_post_pic')->getVal('original_pic'
                        , array('id' => $request['request_pic_id'])),
                    'jt_theme_id' => $request['theme_id'],
                    'createtime' => date("Y-m-d H:i:s"),
                    'updatetime' => date("Y-m-d H:i:s")
                ));
                \DB::table('jt_post_pic')->update(array('isbattle' => 1, 'updatetime' => date("Y-m-d H:i:s")), array('id' => \DB::table('jt_battle')->getVal('right_pic_id',
                    array('left_pic_id' => $request['request_pic_id']))));
                \DB::table('jt_post_pic')->update(array('isbattle' => 1, 'updatetime' => date("Y-m-d H:i:s")), array('id' => $request['request_pic_id']));
                return array(
                    'Code' => 0,
                    'Msg' => "生成对战成功",
                    'Data' => \DB::table('jt_battle')->getAll(array('left_pic_id' => $request['request_pic_id'],))

                );
            } else {
                throw new  Exception("生产对战失败，当前不存在能够生成对战的图片，即将生成对战", 1041);
            }

        } else {
            throw new  Exception("生产对战失败，当前不存在能够生成对战的图片，即将生成对战", 1041);
        }


    }

    public static function getBattle($request)
    {
        //$arr_list=\Db::table('jt_battle')->getAll(array('isbattle'=>0,'jt_theme_id'=>$request['theme_id']));
        $arr_list = \DB::table('jt_battle')->getAll(array('isbattle' => 0));
        if ($arr_list) {


            if (count($arr_list) > 10) {
                $list = array_rand($arr_list, 10);
                $recommend_arr = array();
                foreach ($list as $key) {
                    array_push($recommend_arr, $arr_list[$key]);
                }
                return array(
                    'Code' => 0,
                    'Msg' => "查询对战信息成功",
                    'Data' => $recommend_arr

                );
            } else {
                return array(
                    'Code' => 0,
                    'Msg' => "查询对战信息成功",
                    'Data' => $arr_list

                );
            }

        } else {
            throw new Exception("获取对战失败，当前没有正在进行的对战", 1042);
        }


    }

    public static function finishBattle($battle_id, $pic_id)
    {
        \DB::table('jt_battle')->update(array('isbattle' => 1, 'updatetime' => date("Y-m-d H:i:s")), array('id' => $battle_id));
        \DB::table('jt_post_pic')->update(array('isbattle' => 0, 'updatetime' => date("Y-m-d H:i:s")), array('id' => $pic_id));
    }

    public static function interGenerateBattle($request_pic_id, $theme_id)
    {
        // 图片上传成功生成对战
        $level = \DB::table('jt_post_pic')->getVal('level', array('id' => $request_pic_id));
        $level = $level + 1;
        \DB::table('jt_post_pic')->update(array('level' => $level, 'updatetime' => date("Y-m-d H-i-s")),
            array('id' => $request_pic_id));
        $arr = \DB::table('jt_post_pic')->getAll(array('isbattle' => 0,
            'islock' => 0, 'jt_theme_id' => $theme_id
        ));
        //如果存在，选取一个，生成对战


        if ($arr) {

            $a_arr = $arr[rand(0, (count($arr) - 1))];
            if ($a_arr['id'] != $request_pic_id) {

                \DB::table('jt_battle')->insert(array('left_pic_id' => $request_pic_id,
                    'left_thumb_pic_path' => \DB::table('jt_post_pic')->getVal('thumb_pic'
                        , array('id' => $request_pic_id)),
                    'left_original_pic_path' => \DB::table('jt_post_pic')->getVal('original_pic'
                        , array('id' => $request_pic_id)),
                    'right_pic_id' => $a_arr['id'],
                    'right_thumb_pic_path' => \DB::table('jt_post_pic')->getVal('thumb_pic'
                        , array('id' => $request_pic_id)),
                    'right_original_pic_path' => \DB::table('jt_post_pic')->getVal('original_pic'
                        , array('id' => $request_pic_id)),
                    'jt_theme_id' => $theme_id,
                    'createtime' => date("Y-m-d H:i:s"),
                    'updatetime' => date("Y-m-d H:i:s")
                ));
                \DB::table('jt_post_pic')->update(array('isbattle' => 1, 'updatetime' => date("Y-m-d H:i:s")), array('id' => \DB::table('jt_battle')->getVal('right_pic_id',
                    array('left_pic_id' => $request_pic_id))));
                \DB::table('jt_post_pic')->update(array('isbattle' => 1, 'updatetime' => date("Y-m-d H:i:s")), array('id' => $request_pic_id));
                return array(
                    'Code' => 0,
                    'Msg' => "生成对战成功",
                    'Data' => \DB::table('jt_battle')->getAll(array('left_pic_id' => $request_pic_id,))

                );
            }


        } else {
            return array(
                'Code' => 1,
                'Msg' => "生成对战失败，当前不存在能够匹配的图片，即将匹配对战",


            );

        }

    }

    public static function resurrectionBattle($request_pic_id, $theme_id)
    {
        \DB::table('jt_resurrection_pic')->insert(array('pic_id' => $request_pic_id,
            'thumb_pic_path' => \DB::table('jt_post_pic')->getVal('thumb_pic', array('id' => $request_pic_id)),
            'original_pic_path' => \DB::table('jt_post_pic')->getVal('original_pic', array('id' => $request_pic_id)),
            'createtime' => date("Y-m-d H-i-s"), 'updatetime' => date("Y-m-d H-i-s"),
            'jt_theme_id' => $theme_id
        ));
        \DB::table('jt_post_pic')->update(array('isbattle' => 1, 'updatetime' => date("Y-m-d H:i:s")), array('id' => $request_pic_id));
    }

    public static function getResurrectionBattle($request)
    {
        $arr_list = \DB::table('jt_resurrection_pic')->getAll(array('isover' => 0
            //,'jt_theme_id'=>$request['theme_id']
        ));
        if ($arr_list) {
            if (count($arr_list) > 10) {
                $list = array_rand($arr_list, 10);
                $recommend_arr = array();
                foreach ($list as $key) {
                    array_push($recommend_arr, $arr_list[$key]);
                }
                return array(
                    'Code' => 0,
                    'Msg' => "查询复活信息成功",
                    'Data' => $recommend_arr

                );
            } else {
                return array(
                    'Code' => 0,
                    'Msg' => "查询复活信息成功",
                    'Data' => $arr_list

                );
            }
        } else {
            throw new Exception("获取复活失败，当前不存在处于复活状态的图片，即将生成复活", 1043);
        }

    }


    public static function finishResurrectionBattle($resurrection_id, $pic_id)
    {
        \DB::table('jt_resurrection_pic')->update(array('isover' => 1, 'updatetime' => date("Y-m-d H:i:s")), array('id' => $resurrection_id));
        //\DB::table('jt_post_pic')->update(array('islock'=>1),array('id'=>$pic_id));
        \DB::table('jt_post_pic')->update(array('isbattle' => 0, 'updatetime' => date("Y-m-d H:i:s")), array('id' => $pic_id));
    }

//查询指定图片得对战内容
    public static function getAppointBattle($request)
    {
        // jt_battle中left_pic_id或者right_pic_id等于指定得pic_id，返回所有对战，按时间排序
        return array(
            'Code' => 0,
            'Message' => "获取指定图片对战内容成功！",
            'Date' => array(
                'BattleMessage' => \DB::table('jt_battle')->getAll(
                    array(
                        'left_pic_id= ? or right_pic_id= ?' => array($request['pic_id'], $request['pic_id']),

                        'order' => 'updatetime desc'
                    )
                ),

            )


        );

    }
}