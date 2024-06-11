<?php

namespace Controller;

use MVC\Router;

class AppointmentController {
    public static function index (Router $router) {

        session_start();

        isAuth();

        $router->render('appointment/index', [
            // Al ya haber una sesion iniciada podemos acceder a la superglobal SESSION
            'id' => $_SESSION['id'],
            'name' => $_SESSION['name']
        ]);
    }
}