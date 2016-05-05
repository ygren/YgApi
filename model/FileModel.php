<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/8/26
 * Time: 下午8:10
 */
class FileModel
{
    public static function upload($request)
    {


        $path = ROOT . "/images/";
        if (!file_exists($path)) {
            mkdir("$path", 0777);
        }
        $tp = array("image/gif", "image/jpeg", "image/png");
        if (!in_array($request["thumb"]["type"], $tp)) {
            throw new Exception("can not found file type.", 1021);
            exit;
        }
        if ($request["thumb"]["name"]) {
            $size = "thumb";
            $path .= $size;
            $path .= '/';
            $path .= $request['theme'];
            $data_thumb = File::saveTo($size, $path, $request);

        }
        $path = ROOT . "/images/";
        $tp = array("image/gif", "image/jpeg", "image/png");
        if (!in_array($request["original"]["type"], $tp)) {
            throw new Exception("上传失败，不支持该文件类型.", 1021);
            exit;
        }
        if (\DB::table("jt_post_pic")->getVal('id', array(
            "uid" => \DB::table("jt_user")->getVal("id", array(
                "username" => $request["username"]

            )),

            "jt_theme_id" => \DB::table("jt_theme")->getVal("id", array(
                "theme_code" => $request["theme"],
                'updatetime' => array('between', date('Y-m-d') . ' ' . '00:00:00',
                    date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),
            )),

        ))
        ) {
            throw new Exception("发送失败，该用户已发送该日主题相关图片", 1032);
        } else {

            if ($request["original"]['name']) {
                $size = "original";
                $path .= $size;
                $path .= '/';
                $path .= $request['theme'];
                $data_original = File::saveTo($size, $path, $request);

            }

            \DB::table("jt_post_pic")->insert(array(

                "content" => $request["content"],
                "createtime" => date("Y-m-d H-i-s"),
                'updatetime' => date("Y-m-d H:i:s"),
                "thumb_pic" => $data_thumb["path"],
                "original_pic" => $data_original["path"],
                "uid" => \DB::table("jt_user")->getVal("id", array(
                    "username" => $request["username"]
                )),
                "jt_theme_id" => \DB::table("jt_theme")->getVal("id", array(
                    "theme_code" => $request["theme"],
                    'updatetime' => array('between', date('Y-m-d') . ' ' . '00:00:00',
                        date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),
                )),


            ));

            \Token::updateToken($request);


            return array(
                "Code" => 0,
                "Msg" => "上传成功！",
                "accessToken" => \DB::table('jt_token')->getVal('accesstoken', array('uid' => DB::table('jt_user')->getVal('id',
                    array('username' => $request['username'])))),
                "Data" => array(
                    'uid' => DB::table('jt_user')->getVal('id',
                        array('username' => $request['username'])),
                    "createtime" => \DB::table('jt_post_pic')->getVal('createtime', array('uid' => DB::table('jt_user')->getVal('id',
                        array('username' => $request['username'])))),
                    "jt_theme_id" => \DB::table("jt_theme")->getVal("id", array(
                        "theme_code" => $request["theme"],
                        'updatetime' => array('between', date('Y-m-d') . ' ' . '00:00:00',
                            date('Y-m-d', strtotime("+1 day")) . ' ' . '00:00:00'),

                    )),
                    "Original_pic_path" => $data_original,
                    "Thumb_pic_path" => $data_thumb,

                )
            );


        }

    }


    public static function setHeadPic($request)
    {


        $path = ROOT . "/images/";
        if (!file_exists($path)) {
            mkdir("$path", 0700);
        }
        $tp = array("image/gif", "image/jpeg", "image/png");

        if (!in_array($request["headpic"]["type"], $tp)) {
            throw new Exception("设置失败，不支持该文件类型.", 1021);
            exit;
        }
        if ($request["headpic"]['name']) {
            $size = "headpic";
            $path .= $size;
            $path .= '/';
            $head_pic = File::saveToHeadPic($path, $request);

        }

        \DB::table('jt_userinfo')->update(array(
            'head_pic_path' => $head_pic['path'], 'updatetime' => date("Y-m-d H:i:s")


        ), array('uid' => DB::table('jt_user')->getVal('id',
            array('username' => $request['username']))));

        \Token::updateToken($request);


        return array(
            "Code" => 0,
            "Msg" => "头像设置成功！",
            "accessToken" => \DB::table('jt_token')->getVal('accesstoken', array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username'])))),
            "Data" => array(
                'uid' => DB::table('jt_user')->getVal('id',
                    array('username' => $request['username'])),
                "updatetime" => \DB::table('jt_userinfo')->getVal('updatetime', array('uid' => DB::table('jt_user')->getVal('id',
                    array('username' => $request['username'])))),
                "head_pic_path" => $head_pic,

            )
        );


    }

    public static function setBackground($request)
    {


        $path = ROOT . "/images/";
        if (!file_exists($path)) {
            mkdir("$path", 0700);
        }
        $tp = array("image/gif", "image/jpeg", "image/png");

        if (!in_array($request["background"]["type"], $tp)) {
            throw new Exception("设置失败，不支持该文件类型", 1021);
            exit;
        }
        if ($request["background"]['name']) {
            $size = "background";
            $path .= $size;
            $path .= '/';
            $background_pic = File::saveToBackground($path, $request);

        }

        \DB::table('jt_userinfo')->update(array(
            'background_pic_path' => $background_pic['path'],
            'updatetime' => date("Y-m-d H:i:s")

        ), array('uid' => DB::table('jt_user')->getVal('id',
            array('username' => $request['username']))));

        \Token::updateToken($request);


        return array(
            "Code" => 0,
            "Msg" => "上传成功！",
            "accessToken" => \DB::table('jt_token')->getVal('accesstoken', array('uid' => DB::table('jt_user')->getVal('id',
                array('username' => $request['username'])))),
            "Data" => array(
                'uid' => DB::table('jt_user')->getVal('id',
                    array('username' => $request['username'])),
                "updatetime" => \DB::table('jt_userinfo')->getVal('updatetime', array('uid' => DB::table('jt_user')->getVal('id',
                    array('username' => $request['username'])))),
                "background_pic_path" => $background_pic,

            )
        );


    }


}
