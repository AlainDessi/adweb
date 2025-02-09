<?php

use Core\Html\HtmlBootstrapMenuPills;

class MenuPills
{
    public static function __callStatic($method,$args)
    {
        $form = new HtmlBootstrapMenuPills();
        return call_user_func_array([$form,$method], $args);
    }
}
