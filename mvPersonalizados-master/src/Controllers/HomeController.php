<?php

namespace Controllers;

class HomeController extends PublicController
{
    public function run() :void
    {
        $data = array(
            "pageTitle" => "MVPersonalizados - Regalos Personalizados",
            "pageDescription" => "Convertimos tus momentos especiales en recuerdos únicos"
        );
        $this->render("home", $data);
    }
}
?>
