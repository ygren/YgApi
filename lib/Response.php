<?php

/*
 * 返回请求类
 */

class Response
{
    public static function send($response)
    {
        header('Content-Type:application/json;charset=utf8');
        echo json_encode($response);
    }

    public static function error($e)
    {
        header('Content-Type:application/json;charset=utf8');
        echo json_encode(array(
            "Code" => $e->getCode(),
            "Message" => $e->getMessage()
        ));
    }
}