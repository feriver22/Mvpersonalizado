<?php

namespace Controllers\Sec;

use Dao\Security\Security as DaoSecurity;

class Register extends \Controllers\PublicController
{
    public function run() :void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = \Utilities\Validators::sanitizeInput($_POST['name'] ?? '');
            $email = \Utilities\Validators::sanitizeInput($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';

            if (empty($name) || empty($email) || empty($password)) {
                $data = ["error" => "Todos los campos son requeridos"];
                $this->render("sec/register", $data);
                return;
            }

            if ($password !== $password_confirm) {
                $data = ["error" => "Las contraseñas no coinciden"];
                $this->render("sec/register", $data);
                return;
            }

            if (!preg_match('/^(?=.*[0-9])(?=.*[A-Z]).{8,}$/', $password)) {
                $data = ["error" => "La contraseña debe tener al menos 8 caracteres, incluir un número y una mayúscula"];
                $this->render("sec/register", $data);
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data = ["error" => "Email inválido"];
                $this->render("sec/register", $data);
                return;
            }

            if (DaoSecurity::getUserByEmail($email)) {
                $data = ["error" => "El email ya está registrado"];
                $this->render("sec/register", $data);
                return;
            }

            $hashed_password = \Utilities\Security::hashPassword($password);
            $created = DaoSecurity::createUser($name, $email, $hashed_password);

            if ($created) {
                $data = ["message" => "Cuenta creada exitosamente. Ahora puedes iniciar sesión."];
                $this->render("sec/register_success", $data);
            } else {
                $data = ["error" => "Error al crear la cuenta. Intenta de nuevo."];
                $this->render("sec/register", $data);
            }
            return;
        }

        $data = ["error" => ""];
        $this->render("sec/register", $data);
    }
}
?>
