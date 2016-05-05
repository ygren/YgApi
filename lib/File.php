<?php

/**
 * 文件操作�?
 */
class File
{

    /*
     *
     * @params  $size  String   图片类型 original \  thumb \ theme
     * @params  $path  String   图片保存路径
     * @params  $request  $_POST+$_FILES  信息接收
     * return  array()  图片上传后相应信息
     */

    //存在问题，代码编写分离不好，为实现短期目标，暂时搁置优化存储函数

    public static function saveTo($size, $path, $request)
    {


        $day = date("Y-m-d");

        $path .= '/';
        $path .= $day;
        $path .= '/';
        try {


            File::mkDir($path);
            if ($request[$size]["name"]) {
                $fileFrom = explode(".", $_FILES[$size]["name"]);
                $suffix = $fileFrom[(count($fileFrom) - 1)];

                $fileTo = $path . $request['username'] . '.' . $suffix;
                $flag = 1;

            }

            if ($flag) {
                $result = move_uploaded_file($request[$size]["tmp_name"], $fileTo);


            }
            if ($result) {

                return array(

                    "Msg" => $size . "upload success!",
                    "path" => $fileTo

                );

            }
        } catch (Exception $e) {
            return array(

                "Msg" => "upload fail!",


            );

        }


    }


    public static function saveToHeadPic($path, $request)
    {

        try {


            if ($request['headpic']["name"]) {
                $fileFrom = explode(".", $_FILES['headpic']["name"]);
                $suffix = $fileFrom[(count($fileFrom) - 1)];

                $fileTo = $path . $request['username'] . '.' . $suffix;
                $flag = 1;

            }

            if ($flag) {
                $result = move_uploaded_file($request['headpic']["tmp_name"], $fileTo);


            }
            if ($result) {

                return array(

                    "Msg" => "headpic upload success!",
                    "path" => $fileTo

                );

            }
        } catch (Exception $e) {
            return array(

                "Msg" => "upload fail!",


            );

        }


    }


    public static function saveToBackground($path, $request)
    {

        try {


            if ($request['background']["name"]) {
                $fileFrom = explode(".", $_FILES['background']["name"]);
                $suffix = $fileFrom[(count($fileFrom) - 1)];

                $fileTo = $path . $request['username'] . '.' . $suffix;
                $flag = 1;

            }

            if ($flag) {
                $result = move_uploaded_file($request['background']["tmp_name"], $fileTo);


            }
            if ($result) {

                return array(

                    "Msg" => "background upload success!",
                    "path" => $fileTo

                );

            }
        } catch (Exception $e) {
            return array(

                "Msg" => "upload fail!",


            );

        }


    }


    public static function getDir($dir)
    {
        $filelist = array();
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                $i = 0;
                while (($file = readdir($dh)) !== false) {
                    if ($file !== "." && $file !== "..") {
                        //print "filename: $file : filetype: " . filetype($dir . $file) . "/n";
                        $filelist[$i] = $file;
                        $i++;
                    }
                }
                closedir($dh);
            }
            return $filelist;
        }

    }

    public static function mkDir($dir)
    {
        if (!is_dir($dir)) {
            mkdir($dir);
            chmod($dir, 0777);
            return $dir;
        }
        return true;
    }

    public static function initDir($dir, $power = '0777')
    {
        if (is_dir($dir)) {
            return true;
        } else {
            $basedir = dirname($dir);
            self:
            initDir($basedir);
            mkdir($dir, $power);
            return true;
        }
    }

    public static function mv($file, $sourceDir, $targetDir)
    {


    }

    public static function getFiles($dir)
    {
        $files = array();
        $handle = opendir($dir);
        if ($handle == false) {
            throw new Exception("不能打开该路径" . $dir, 1020);
        }
        while (($file = readdir($handle)) !== false)// 循环读取当前路径
        {
            if ($file == "." || $file = "..") {
                //排除当前路径和前一路径
                continue;
            }
            $filePath = $dir . "/" . $file;
            if (is_dir($filePath)) {
                $files = array_merge($files, self::getFiles($filePath));
            } else {
                $files[] = $filePath;
            }
        }
        return $files;

    }

    public static function rm($file)
    {
        return unlink($file);
    }
}