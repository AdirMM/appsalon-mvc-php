<?php

namespace Controller;

use MVC\Router;

class PageController {
    public static function error404 (Router $router) {
        $router->render('/error404');
    }
}