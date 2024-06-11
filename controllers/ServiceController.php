<?php

namespace Controller;

use Model\Service;
use MVC\Router;

class ServiceController {

    public static function index (Router $router) {
        session_start();
        isAdmin();
        
        $services = Service::all();

        $router->render('services/index', [
            'services' => $services
        ]);
    }

    public static function create (Router $router) {
        $service = new Service;
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service->sync($_POST);
            $alerts = $service->validate();

            if (empty($alerts)) {
                $service->save();
                header('Location: /services');
            }
        }

        $router->render('services/create', [
            'service' => $service,
            'alerts' => $alerts,
        ]);
    }

    public static function update (Router $router) {
        session_start();

        isAdmin();

        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /error404');
        }

        $service = Service::find($id);
        $alerts = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service->sync($_POST);
            $alerts = $service->validate();

            if (empty($alerts)) {
                $service->save();
                header('Location: /services');
            }
        }

        $router->render('services/update', [
            'service' => $service,
            'alerts' => $alerts
        ]);
    }

    public static function delete () {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $service = Service::find($id);

            $service->delete();
            header('Location: /services');
        }
    }
}