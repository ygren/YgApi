<?php
spl_autoload_register('autoLoad');

function autoLoad($class)
{
    if (preg_match('/^[a-z|A-Z]+Model$/', $class)) {
        $file = ROOT . DIRECTORY_SEPARATOR . 'model'
            . DIRECTORY_SEPARATOR . ucfirst($class) . '.php';
    } else {
        $file = ROOT . DIRECTORY_SEPARATOR . 'lib'
            . DIRECTORY_SEPARATOR . ucfirst($class) . '.php';
    }
    require $file;
}