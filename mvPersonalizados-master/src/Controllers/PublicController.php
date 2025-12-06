<?php

namespace Controllers;

abstract class PublicController implements IController
{
    protected $name = "";

    public function __construct()
    {
        $this->name = get_class($this);
        \Utilities\Nav::setPublicNavContext();
        if (\Utilities\Security::isLogged()){
            $layoutFile = \Utilities\Context::getContextByKey("PRIVATE_LAYOUT");
            if ($layoutFile !== "") {
                \Utilities\Context::setContext(
                    "layoutFile",
                    $layoutFile
                );
                \Utilities\Nav::setNavContext();
            }
        }
    }

    public function toString() :string
    {
        return $this->name;
    }

    protected function render($view, $data = array(), $layoutFile = "layout.view.tpl")
    {
        \Views\Renderer::render($view, $data, $layoutFile);
    }
}
?>
