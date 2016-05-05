<?php


define('ROOT', __DIR__);
date_default_timezone_set('Asia/Shanghai');
require 'start.php';


try {

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    //将出错信息输出到一个文本文件
    ini_set('error_log', dirname(__FILE__) . '/error_log.txt');

//    if (!isset($_GET['token']) || !isset($_GET['uuid'])) {
//
//    }
//    Token::check($_GET['token'], $_GET['uuid']);
//    UserModel::checkLogin($_GET['uuid']);

    \DB::config(config('DB'));
    $controller = APP::getController();
    $response = $controller->execute(APP::getRequest());
    Response::send($response);

} catch (Exception $e) {
    Response::error($e);
}

function config($key)
{
    static $config = array();
    if (empty($config)) {
        $config = require ROOT . DIRECTORY_SEPARATOR . 'config/config.php';
    }

    return isset($config[$key]) ? $config[$key] : '';
}


class App
{
    public static function getController()
    {

        if (!isset($_SERVER['PATH_INFO'])) {
            throw new Exception('php info error', 2000);
        }
        list($version, $module, $controller) = explode('/', ltrim($_SERVER['PATH_INFO'], '/'));
        $file = ROOT . DIRECTORY_SEPARATOR
            . 'app' . DIRECTORY_SEPARATOR
            . $version . DIRECTORY_SEPARATOR
            . ucfirst($module) . DIRECTORY_SEPARATOR
            . ucfirst($controller) . '.php';
        $class = ucfirst($module) . ucfirst($controller) . 'Controller';
        if (!is_file($file)) {
            throw new Exception('controller not find', 2001);
        }
        require $file;
        return new $class();
    }

    public static function getRequest()
    {
        return $_POST + $_GET + $_FILES;
    }
}

?>
