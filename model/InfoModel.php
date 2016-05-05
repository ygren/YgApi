<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/10/21
 * Time: 下午4:50
 */
class InfoModel
{


    public static function setInfo($request)
    {
        /* if(!(\DB::table('jt_userinfo')->getVal('id',array( 'uid'=>DB::table('jt_user')->getVal('id',
             array('username'=>$request['username']))))))
         {


             \DB::table('jt_userinfo')->insert(array(
                 'nickname'=>$request['nickname'],
                 'sex'=>$request['sex'],
                 'age'=>$request['age'],
                 'location'=>$request['location'],
                 'birthday'=>$request['birthday'],
                 'bloodtype'=>$request['bloodtype'],
                 'email'=>$request['email'],
                 'graduation'=>$request['graduation'],
                 'intro'=>$request['intro'],
                 'chick_id'=>$request['chick_id'],
                 'uid'=>DB::table('jt_user')->getVal('id',
             array('username'=>$request['username'])),
                 'createtime'=>date("Y-m-d H-i-s"),
                 'updatetime'=>date("Y-m-d H-i-s")

             ));
         }else
         {
        */
        if ($request['nickname']) {
            \DB::table('jt_userinfo')->update(array(
                'nickname' => $request['nickname'],
                'updatetime' => date("Y-m-d H-i-s")
            ), array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username']))));
        }
        if ($request['sex']) {
            \DB::table('jt_userinfo')->update(array(
                'sex' => $request['sex'],
                'updatetime' => date("Y-m-d H-i-s")
            ), array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username']))));
        }
        if ($request['age']) {
            \DB::table('jt_userinfo')->update(array(
                'age' => $request['age'],
                'updatetime' => date("Y-m-d H-i-s")
            ), array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username']))));
        }
        if ($request['location_province']) {
            \DB::table('jt_userinfo')->update(array(
                'location_province' => $request['location_province'],
                'updatetime' => date("Y-m-d H-i-s")
            ), array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username']))));
        }
        if ($request['location_city']) {
            \DB::table('jt_userinfo')->update(array(
                'location_city' => $request['location_city'],
                'updatetime' => date("Y-m-d H-i-s")
            ), array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username']))));
        }
        if ($request['birthday']) {
            \DB::table('jt_userinfo')->update(array(
                'birthday' => $request['birthday'],
                'updatetime' => date("Y-m-d H-i-s")
            ), array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username']))));
        }
        if ($request['bloodtype']) {
            \DB::table('jt_userinfo')->update(array(
                'bloodtype' => $request['bloodtype'],
                'updatetime' => date("Y-m-d H-i-s")
            ), array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username']))));
        }
        if ($request['email']) {
            \DB::table('jt_userinfo')->update(array(
                'email' => $request['email'],
                'updatetime' => date("Y-m-d H-i-s")
            ), array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username']))));
        }
        if ($request['graduation']) {
            \DB::table('jt_userinfo')->update(array(
                'graduation' => $request['graduation'],
                'updatetime' => date("Y-m-d H-i-s")
            ), array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username']))));
        }
        if ($request['intro']) {
            \DB::table('jt_userinfo')->update(array(
                'intro' => $request['intro'],
                'updatetime' => date("Y-m-d H-i-s")
            ), array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username']))));
        }
        if ($request['chick_id']) {
            \DB::table('jt_userinfo')->update(array(
                'chick_id' => $request['chick_id'],
                'updatetime' => date("Y-m-d H-i-s")
            ), array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username']))));
        }


        Token::updateToken($request);

        return array(
            'Code' => 0,
            'Msg' => "个人信息设置成功",
            'accessToken' => \DB::table('jt_token')->getVal('accesstoken', array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username'])))),
            'Data' => array(
                'uid' => DB::table('jt_user')->getVal('id',
                    array('username' => $request['username'])),

                'createtime' => \DB::table('jt_userinfo')->getVal('createtime', array('uid' => DB::table('jt_user')->getVal('id',
                    array('username' => $request['username']))
                )),
                'updatetime' => \DB::table('jt_userinfo')->getVal('updatetime', array('uid' => DB::table('jt_user')->getVal('id',
                    array('username' => $request['username']))
                )),

            )
        );

    }

    public static function getInfo($request)
    {

        if (\DB::table('jt_user')->getVal('id', array('username' => $request['username']))) {
            Token::updateToken($request);
            return array(
                'Code' => 0,
                'Msg' => "查询个人信息成功",
                'accessToken' => \DB::table('jt_token')->getVal('accesstoken', array('uid' => DB::table('jt_user')->getVal('id',
                    array('username' => $request['username'])))),
                'Data' =>
                    \DB::table('jt_userinfo')->getRow(array(
                        'field' => 'nickname,sex,age,location_province,location_city,birthday,bloodtype,email,graduation,
            follow,fans,intro,head_pic_path,createtime,updatetime,background_pic_path,chick_id',
                        'uid' => DB::table('jt_user')->getVal('id',
                            array('username' => $request['username'])))),


            );

        } else {
            throw new Exception("获取失败，不存在该用户个人信息", 1002);
        }


    }

    public static function getAppoint($request)
    {

        if (\DB::table('jt_user')->getVal('id', array('id' => $request['uid']))) {
            return array(
                'Code' => 0,
                'Msg' => "查询个人信息成功",
                'Data' =>
                    \DB::table('jt_userinfo')->getAll(array(
                        'field' => 'nickname,sex,age,location_province,location_city,birthday,bloodtype,graduation,
            follow,fans,intro,head_pic_path,createtime,updatetime,background_pic_path,chick_id',
                        'uid' => $request['uid']
                    ))


            );

        } else {
            throw new Exception("获取失败，不存在该用户个人信息", 1002);
        }


    }
}