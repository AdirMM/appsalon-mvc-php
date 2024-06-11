<?php

namespace Controller;

use Classes\Email;
use Model\User;
use MVC\Router;

class LoginController {

    public static function create (Router $router) {

        $user = new User;

        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user->sync($_POST);
            $alerts = $user->valide();

            if (empty($alerts)) {
                $result = $user->userExists();

                if ($result->num_rows) {
                    $alerts = User::getAlerts();
                } else {
                    // hashear password
                    $user->hashPassword();

                    // Generar un token unico
                    $user->createToken();

                    // Enviar el email
                    $email = new Email($user->email, $user->name, $user->token);

                    $email->sendConfirmation();

                    // Crear el usuario
                    $result = $user->save();

                    if ($result) {
                        header('Location: /message');
                    }
                }
            }
        }

        $router->render('/auth/create-account', [
            'user' => $user,
            'alerts' => $alerts
        ]);
    }

    public static function message (Router $router) {
        $router->render('auth/message');
    }

    public static function confirm (Router $router) {

        $alerts = [];
        $token = s($_GET['token']);

        $user = User::where('token', $token);

        if (empty($user)) {
            // Mostrar mensaje de error
            User::setAlert('error', 'Token No Valido');
        } else {
            // Modificar a un usuario confirmado
            $user->confirmed = '1';
            $user->token = NULL;
            $user->save();

            User::setAlert('success', 'Cuenta comprobada correctamente');
        }

        $alerts = User::getAlerts();

        $router->render('auth/confirm-account', [
            'alerts' => $alerts
        ]);
    }

    public static function login (Router $router) {

        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new User($_POST);
            $alerts = $auth->validateLogin();

            if ( empty($alerts) ) {
                $user = User::where('email', $auth->email);

                if ($user) {
                    if ($user->checkPasswordAndVerified($auth->password)) {
                        
                        // Auntenticar usuario
                        session_start();

                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name . " " . $user->last_name;
                        $_SESSION['email'] = $user->email;
                        $_SESSION['login'] = true;

                            // Redirreccionamiento
                        if ($user->admin === '1') {
                            $_SESSION['admin'] = $user->admin ?? NULL;
                            header('Location: /admin');
                            exit;
                        } else {
                            header('Location: /appointment');
                            exit;
                        }
                    }
                } else {
                    User::setAlert('error', 'Usuario no encontrado');
                }
            }
        }

        $alerts = User::getAlerts();

        $router->render('auth/login', [
            'alerts' => $alerts
        ]);
    }

    public static function logout () {
        session_start();
        $_SESSION = [];

        header('Location: /');
    }

    public static function forget (Router $router) {
        
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new User($_POST);

            $alerts = $auth->validateEmail();

            if (empty($alerts)) {
                $user = User::where('email', $auth->email);

                if ($user && $user->confirmed === '1') {
                    // Generar un token
                    $user->createToken();
                    $user->save();

                    // Enviar email
                    $email = new Email($user->email, $user->name, $user->token);

                    $email->sendInstructions();
                    
                    User::setAlert('success', 'Revisa tu email');
                } else {
                    User::setAlert('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }

        $alerts = User::getAlerts();

        $router->render('auth/forget', [
            'alerts' => $alerts
        ]);
    }

    public static function recover (Router $router) {

        $alerts = [];
        $error = false;
        $token = s($_GET['token']);
        $user = User::where('token', $token);


        if (empty($user)) {
            $error = true;
            User::setAlert('error', 'Token No Valido');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer el nuevo password
            $password = new User($_POST);

            $alerts = $password->validatePassword();

            if (empty($alerts)) {
                // Eliminamos el primer password
                $user->password = Null;
                $user->password = $password->password;

                $user->hashPassword();
                $user->token = Null;

                $result = $user->save();

                if ($result) {
                    header('Location: /');
                }
            }
        }

        $alerts = User::getAlerts();

        $router->render('auth/recover', [
            'alerts' => $alerts,
            'error' => $error
        ]);
    }
} 