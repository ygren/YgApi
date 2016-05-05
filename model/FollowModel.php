<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/22
 * Time: 下午2:05
 */
class FollowModel
{
    public static function send($request)
    {
        if (\DB::table('jt_follow')->getVal('follow', array(
            'fans' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
        ))
        ) {
            throw new Exception("关注失败，该用户已被关注", 1051);
        } else {
            \DB::table('jt_follow')->insert(
                array(
                    'follow' => $request['follow_id'],
                    'fans' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])),
                    'createtime' => date("Y-m-d H-i-s")
                ));
            $CID = \DB::table('jt_cid')->getVal('cid', array('uid' => $request['follow_id']));
            $contentFollow = json_encode(
                array(
                    'Code' => 0,
                    'Message' => "关注提醒",
                    'Date' => array(
                        'id' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])),
                        'nickname' => \DB::table('jt_userinfo')->getVal('nickname',
                            array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))),
                        'head_pic_path' => \DB::table('jt_userinfo')->getVal('head_pic_path',
                            array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))),
                        'creattime' => \DB::table('jt_follow')->getVal('createtime', array(
                            'follow' => $request['follow_id'],
                            'fans' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
                        ))
                    )

                ));

            $pushToFollow = new GeTui();
            $pushToFollow->setCID($CID);
            $pushToFollow->setTransmissionContent($contentFollow);
            $pushToFollow->pushMessageToSingle();
            Token::updateToken($request);
            return array(
                'Code' => 0,
                'Message' => "关注成功！",

                'accessToken' => \DB::table('jt_token')->getVal('accesstoken', array('uid' => DB::table('jt_user')->getVal('id',
                    array('username' => $request['username']))))
            );

        }

    }

    public static function get($request)
    {
        return array(
            'Code' => 0,
            'Message' => "获取关注用户列表成功！",
            'Data' => \DB::table('jt_follow')->getAll(
                array(
                    'field' => 'id,follow',
                    'order' => 'createtime desc',
                    'fans' => $request['uid']

                )
            )
        );
    }
}