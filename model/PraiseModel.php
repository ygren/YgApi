<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/8
 * Time: 下午3:36
 */
class PraiseModel
{
    public static function sendPraise($request)
    {
        if ($praise_count = \DB::table('jt_post_pic')->getVal('praise_count', array('id' => $request['pic_id']))) {

            $praise_count++;
            \DB::table('jt_post_pic')->update(array('praise_count' => $praise_count, 'updatetime' => date("Y-m-d H-i-s")), array('id' => $request['pic_id']));
            return array(
                'Code' => 0,
                'Message' => "点赞成功！",
                'Data' => \DB::table('jt_post_pic')->getAll(array(
                    // 'field'=>'id,content,createtime,updatetime,thumb_pic,original_pic,jt_theme_id,isbattle,islock,level,praise_count,comment_count',
                    'id' => $request['pic_id']))
            );
        } else {
            throw new Exception("点赞失败，不存在该图片！", 1050);
        }
    }

}