<?php

/**
 * Created by PhpStorm.
 * User: eudemon
 * Date: 15/9/22
 * Time: 下午4:50
 */
class ThemeGetController
{
    public function execute($request)
    {
        return ThemeModel::getTheme($request);
    }
}