<?php

namespace Controllers\Sec;

use Dao\Security\Security as DaoSecurity;

class Login extends \Controllers\PublicController
{
    public function run() :void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = \Utilities\Validators::sanitizeInput($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $data = ["error" => "Email y contraseña son requeridos"];
                $this->render("sec/login", $data);
                return;
            }

            $user = DaoSecurity::getUserByEmail($email);
            if (!$user || !\Utilities\Security::verifyPassword($password, $user->password)) {
                $data = ["error" => "Email o contraseña incorrectos"];
                $this->render("sec/login", $data);
                return;
            }

            \Utilities\Security::login($user->id, $user->name, $user->email);
            
            $redirTo = $_GET['redirto'] ?? 'index.php?page=Home';
            $redirTo = urldecode($redirTo);
            \Utilities\Site::redirectTo($redirTo);
        }

        $data = ["error" => ""];
        $this->render("sec/login", $data);
    }
}
?>
