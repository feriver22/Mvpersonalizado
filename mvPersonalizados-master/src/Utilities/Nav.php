<?php

namespace Utilities;

class Nav
{
    public static function setPublicNavContext()
    {
        $configFile = file_get_contents("nav.config.json");
        $config = json_decode($configFile);
        \Utilities\Context::setContext("NavItems", $config->public);
    }

    public static function setNavContext()
    {
        $configFile = file_get_contents("nav.config.json");
        $config = json_decode($configFile);
        \Utilities\Context::setContext("NavItems", $config->private);
    }
}
?>
