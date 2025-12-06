<?php

namespace Controllers;

class Error extends PublicController
{
    public function run() :void
    {
        $data = array(
            "pageTitle" => "Error",
            "errorCode" => \Utilities\Context::getContextByKey("ERROR_CODE"),
            "errorMsg" => \Utilities\Context::getContextByKey("ERROR_MSG")
        );
        $this->render("error", $data);
    }
}
?>
