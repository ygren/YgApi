<?php

/**
 * Token�?
 */
class Token
{

    public static function check($token, $userId)
    {
        return true;
    }

    public static function generateToken($request)
    {
        $IMEICode = \DB::table('jt_device')->getVal('imei_code', array(
            'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
        ));
        $accessToken = md5($IMEICode . date('Y-m-d h-i-s'));
        DB::table('jt_token')->insert(array('accesstoken' => $accessToken,
            'createtime' => date("Y-m-d H:i:s"),
            'updatetime' => date("Y-m-d H:i:s"),

            'uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username']))));
        return $accessToken;
    }

    public static function updateToken($request)

    {
        $IMEICode = \DB::table('jt_device')->getVal('imei_code', array(
            'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
        ));
        $accessToken = md5($IMEICode . date('Y-m-d h-i-s'));
        \DB::table('jt_token')->update(array('updatetime' => date("Y-m-d H:i:s"), "accesstoken" => $accessToken), array('uid' => DB::table('jt_user')->getVal('id',
            array('username' => $request['username']))));
        return $accessToken;
    }


}