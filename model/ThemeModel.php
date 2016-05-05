<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/9/21
 * Time: 下午1:59
 */
class ThemeModel
{

    public static function getTheme($request)
    {
        if ($theme = \DB::table('jt_theme')->getAll(array('updatetime' => array('between', date('Y-m-d') . ' ' . '00:00:00',
            date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),))
        ) {
            return array(
                'Code' => 0,
                'Message' => "获取主题内容成功",
                //查询当日主题相关的所有信息
                'Data' => $theme
            );
        } else {
            throw new Exception("获取当日主题失败！主题未更新", 1030);
        }
    }

    public static function getUserPic($request)

    {
        //$uid=\DB::table('jt_user')->getVal('id',array('username'=>$request['username']));
        //$sql = "SELECT * FROM `jt_post_pic` WHERE uid=".$uid;
        //$sql="SELECT * FROM `jt_post_pic` WHERE uid = ".$uid." AND createtime  BETWEEN '".date("Y-m-d",strtotime("-1 day"))."' AND '".date("Y-m-d")."'";
        //$sql="SELECT * FROM `jt_post_pic` WHERE  uid = ".$uid." AND createtime  BETWEEN '".date("Y-m-d")."' AND '".date("Y-m-d",strtotime("+1 day"))."'";
        if ($theme_user = \DB::table('jt_post_pic')->getAll(
            array('field' => 'id,content,createtime,updatetime,thumb_pic,original_pic,jt_theme_id,isbattle,islock,level,praise_count,
           comment_count',
                'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])),
                'createtime' => array('between', date('Y-m-d') . ' ' . '00:00:00',
                    date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),
            ))
        ) {
            Token::updateToken($request);
            return array(
                'Code' => 0,
                'Message' => "获取用户当日发送图片信息成功",
                'accessToken' => \DB::table('jt_token')->getVal('accesstoken', array('uid' => DB::table('jt_user')->getVal('id',
                    array('username' => $request['username'])))),
                'Data' => $theme_user

            );
        } else {
            throw new  Exception("获取失败，用户未发送当日任何主题的图片", 1031);
        }


    }
}