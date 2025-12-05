<?php

namespace Controllers;

class NoAuth extends PublicController
{
    public function run() :void
    {
        $data = array(
            "pageTitle" => "Acceso no autorizado",
            "message" => "Necesitas iniciar sesión para acceder a esta sección"
        );
        $this->render("noauth", $data);
    }
}
?>
