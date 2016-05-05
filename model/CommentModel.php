<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/9/21
 * Time: 下午1:59
 */
class CommentModel
{
    public static function sendComment($request)
    {
        //发送评论
        $comment_count = \DB::table('jt_post_pic')->getVal('comment_count', array('id' => $request['pic_id']));
        $comment_count++;
        \DB::table('jt_comment')->insert(array(
            'content' => $request['contentComment'],
            'createtime' => date("Y-m-d H:i:s"),
            'from_uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])),
            'jt_post_pic_id' => $request['pic_id']
        ));
        \DB::table('jt_post_pic')->update(array('comment_count' => $comment_count), array('id' => $request['pic_id']));
        $pushToComment = new GeTui();
        $CID = \DB::table('jt_cid')->getVal('cid',
            array('uid' => \DB::table('jt_post_pic')->getVal('uid', array('id' => $request['pic_id']))));
        $contentComment = json_encode(array(
            'Code' => 0,
            'Message' => "评论提醒成功",
            'Date' => array(
                'from_uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])),
                'nickname' => \DB::table('jt_userinfo')->getVal('nickname', array(
                    'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
                )),
                'head_pic_path' => \DB::table('jt_userinfo')->getVal('head_pic_path', array(
                    'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
                )),
                'contentComment' => $request['contentComment'],
                'createtime' => date("Y-m-d H:i:s")

            )
        ));
        $pushToComment->setCID($CID);
        $pushToComment->setTransmissionContent($contentComment);
        $pushToComment->pushMessageToSingle();

        Token::updateToken($request);
        return array(
            'Code' => 0,
            'Message' => "评论发送成功",
            'accessToken' => \DB::table('jt_token')->getVal('accesstoken', array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username']))))
        );

    }

    public static function getComment($request)
    {
        //获取评论
        return array(
            'Code' => 0,
            'Message' => "获取评论",
            'Data' => \DB::table('jt_comment')->getAll(array(
                // 'uid'=>\DB::table('jt_user')->getVal('id',array('username'=>$request['username'])),
                'jt_post_pic_id' => $request['pic_id'],
                'order' => 'createtime desc'
            ))
        );
    }

    public static function deleteComment($request)
    {
        //删除评论
        if (\DB::table('jt_comment')->delete(array(
                'id' => $request['comment_id']
            )) != null
        ) {

            $comment_count = \DB::table('jt_post_pic')->getVal('comment_count', array('id' => $request['pic_id']));
            $comment_count--;
            \DB::table('jt_comment')->delete(array(
                'id' => $request['comment_id']
            ));
            \DB::table('jt_post_pic')->update(array('comment_count' => $comment_count), array('id' => $request['pic_id']));

            Token::updateToken($request);
            return array(
                'Code' => 0,
                'Message' => "评论删除成功",
                'accessToken' => \DB::table('jt_token')->getVal('accesstoken', array('uid' => DB::table('jt_user')->getVal('id',
                    array('username' => $request['username'])))),
            );
        } else {
            return array(
                'Code' => 1,
                'Message' => "该评论不存在"
            );
        }
    }
}