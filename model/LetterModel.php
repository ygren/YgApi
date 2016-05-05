<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/22
 * Time: 下午3:58
 */
class LetterModel
{
    public static function send($request)
    {
        $pushToLetter = new GeTui();
        $CID = \DB::table('jt_cid')->getVal('cid', array('uid' => $request['toUid']));
        $contentLetter = json_encode(array(
            'Code' => 0,
            'Message' => '私信发送成功！',
            'Data' => array(
                'fromUid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])),
                'nickname' => \DB::table('jt_userinfo')->getVal('nickname',
                    array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))),
                'head_pic_path' => \DB::table('jt_userinfo')->getVal('head_pic_path',
                    array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))),
                'contentLetter' => $request['contentLetter'],
                'createtime' => date("Y-m-d H:i:s")
            )
        ));
        $pushToLetter->setCID($CID);
        $pushToLetter->setTransmissionContent($contentLetter);
        $pushToLetter->pushMessageToSingle();
        Token::updateToken($request);
        return array(
            'Code' => 0,
            'Message' => "私信发送成功!",
            'accessToken' => \DB::table('jt_token')->getVal('accesstoken', array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username']))))

        );

    }
}