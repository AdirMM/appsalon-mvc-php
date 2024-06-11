<?php

namespace classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $name;
    public $token;

    public function __construct($email, $name, $token)
    {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public function sendConfirmation()
    {
        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = "<html>";
        $content .= "<p> <strong>Hola " . $this->name . "</strong> Has creado tu cuenta en App Salon, solo debes confirmarla presionando en el siguiente enlace:</p>";
        $content .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL'] . "/confirm-account?token=". $this->token ."'>Confirmar cuenta</a> </p>";
        $content .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar este correo.</p>";
        $content .= "</html>";

        $mail->Body = $content;

        // Enviar email
        $mail->send();
    }

    public function sendInstructions () {
        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Reestablece tu password';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $content = "<html>";
        $content .= "<p> <strong>Hola " . $this->name . "</strong> Has solicitado reestablecer tu password, da click en el siguiente enlace para cambiar tu contraseña:</p>";
        $content .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL'] . "/recover?token=". $this->token ."'>Reestablecer Password</a> </p>";
        $content .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar este correo.</p>";
        $content .= "</html>";

        $mail->Body = $content;

        // Enviar email
        $mail->send();
    }
}
