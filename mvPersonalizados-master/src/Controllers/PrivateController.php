<?php

namespace Controllers;

abstract class PrivateController implements IController
{
    protected $name = "";
    protected $userId = 0;

    public function __construct()
    {
        $this->name = get_class($this);
        if (!\Utilities\Security::isLogged()) {
            throw new PrivateNoLoggedException("Usuario no autenticado");
        }
        $this->userId = \Utilities\Security::getUserId();
        \Utilities\Nav::setNavContext();
        $layoutFile = \Utilities\Context::getContextByKey("PRIVATE_LAYOUT");
        if ($layoutFile !== "") {
            \Utilities\Context::setContext("layoutFile", $layoutFile);
        }
    }

    public function toString() :string
    {
        return $this->name;
    }

    protected function render($view, $data = array(), $layoutFile = "privatelayout.view.tpl")
    {
        \Views\Renderer::render($view, $data, $layoutFile);
    }
}
?>
