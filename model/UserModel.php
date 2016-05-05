<?php

class UserModel
{
    public static function register($request)
    {


        if (\DB::table('jt_user')->getVal('id', array('username' => $request['username']))) {
            throw new Exception("注册失败，账号已存在！", 1001);
        } else {
            $hash = Encrypt::hashSSHA($request['password']);
            \DB::table('jt_user')->insert(array(
                'username' => $request['username'],
                'encrypted_password' => $hash['encrypted_password'],
                'salt' => $hash['salt'],
                'createtime' => date("Y-m-d H:i:s"),
                'updatetime' => date("Y-m-d H:i:s")

            ));

            //插入设备信息（迁移到登录入口）

            /*
            \DB::table('jt_device')->insert(array(
                    'device_name'=>$request['device_name'],
                'imei_code'=>$request['imei_code'],
                'operating_system'=>$request['operating_system'],
                'uid'=>\DB::table('jt_user')->getVal('id',array(
                    'username'=>$request['username']
                ))
                )
            );
            */
            \DB::table('jt_userinfo')->insert(array(
                'nickname' => $request['username'],
                'sex' => "男",
                'age' => 100,
                'location_province' => "北京",
                'location_city' => '朝阳',
                'birthday' => date("Y-m-d"),
                'bloodtype' => "O型",
                'email' => "",
                'graduation' => "",
                'intro' => "",
                'chick_id' => "",
                'uid' => DB::table('jt_user')->getVal('id',
                    array('username' => $request['username'])),
                'createtime' => date("Y-m-d H-i-s"),
                'updatetime' => date("Y-m-d H-i-s")

            ));

            return array(
                'Code' => 0,
                'Msg' => "注册成功！",
                'Data' =>
                    array(
                        'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])),
                        'createtime' => \DB::table('jt_user')->getVal('createtime', array('username' => $request['username'])),

                    )


            );
        }


    }

    public static function checkLogin($request)
    {
        if (\DB::table('jt_token')->getVal('accesstoken', array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username'])))) == $request['accessToken']
        ) {

            return true;
        } else
            return false;

    }

    public static function checkPassword()
    {
        return true;
    }


    public static function login($request)
    {
        if (\DB::table('jt_user')->getVal('id', array('username' => $request['username']))) {


            $encrypted_password = \DB::table('jt_user')->getVal('encrypted_password', array('username' => $request['username']));
            $salt = \DB::table('jt_user')->getVal('salt', array('username' => $request['username']));
            $hash = Encrypt::checkhashSSHA($salt, $request['password']);

            /*
                    if (!(\DB::table('jt_token')->getVal('accesstoken', array('uid' => DB::table('jt_user')->getVal('id',
                        array('username' => $request['username'])))))
                    ) {
               */
            if ($encrypted_password == $hash) {

                if (\DB::table('jt_device')->getVal('id',
                    array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))
                )
                ) {
                    \DB::table('jt_device')->update(array('device_name' => $request['device_name'],
                        'imei_code' => $request['imei_code'],
                        'operating_system' => $request['operating_system'],
                        'uid' => \DB::table('jt_user')->getVal('id', array(
                            'username' => $request['username']
                        ))), array(
                        'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
                    ));
                } else {
                    \DB::table('jt_device')->insert(array(
                            'device_name' => $request['device_name'],
                            'imei_code' => $request['imei_code'],
                            'operating_system' => $request['operating_system'],
                            'uid' => \DB::table('jt_user')->getVal('id', array(
                                'username' => $request['username']
                            ))
                        )
                    );
                }

                Token::generateToken($request);
                \DB::table('jt_user')->update(array('updatetime' => date("Y-m-d H-i-s")),
                    array('username' => $request['username']));
                if (\DB::table('jt_cid')->getVal('cid',
                    array('uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username'])))
                )
                ) {
                    \DB::table('jt_cid')->update(array('cid' => $request['cid']), array(
                        'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
                    ));
                } else {
                    \DB::table('jt_cid')->insert(array(
                        'cid' => $request['cid'],
                        'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
                    ));

                }

                return array('Code' => 0,
                    'Msg' => '登录成功!',
                    'accessToken' => \DB::table('jt_token')->getVal('accesstoken', array('uid' => DB::table('jt_user')->getVal('id',
                        array('username' => $request['username'])))),
                    'Data' => array(
                        'uid' => DB::table('jt_user')->getVal('id',
                            array('username' => $request['username'])),

                        'islock' => \DB::table('jt_user')->getVal('islock', array('username' => $request['username'])),
                        'createtime' => \DB::table('jt_user')->getVal('createtime', array('username' => $request['username'])),
                        'updatetime' => \DB::table('jt_user')->getVal('updatetime', array('username' => $request['username']))


                    )
                );
            } else {
                throw new Exception("登录失败，用户密码错误！", 1003);
            }


            /*  } else {

                  throw new  Exception("登录失败，用户已在线！",1004);
              }
         */

        } else {

            throw new Exception("登录失败，不存在该用户！", 1002);
        }


    }


    public static function logout($request)
    {
        \DB::table('jt_token')->delete(array(
            'uid' => \DB::table('jt_user')->getVal('id', array('username' => $request['username']))
        ));
        return array(
            'Code' => 0,
            'Message' => "用户退出登录成功"
        );
    }

    public static function check($request)
    {
        $sendMessage = new Message();
        $result = $sendMessage->sendSMS('18613881756', '您好，您的验证码是888888', 'true');
        $result = $sendMessage->execResult($result);
        if ($result[1] == 0) {
            return '发送成功';
        } else {
            return "发送失败{$result[1]}";
        }
    }
}