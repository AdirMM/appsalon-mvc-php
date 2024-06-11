<?php 

require_once __DIR__ . '/../includes/app.php';

use Controller\AdminController;
use Controller\APIController;
use Controller\AppointmentController;
use Controller\LoginController;
use Controller\PageController;
use Controller\ServiceController;
use MVC\Router;

$router = new Router();

$router->get('/create-account', [LoginController::class, 'create']);
$router->post('/create-account', [LoginController::class, 'create']);

$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

$router->get('/forget', [LoginController::class, 'forget']);
$router->post('/forget', [LoginController::class, 'forget']);
$router->get('/recover', [LoginController::class, 'recover']);
$router->post('/recover', [LoginController::class, 'recover']);

$router->get('/confirm-account', [LoginController::class, 'confirm']);
$router->get('/message', [LoginController::class, 'message']);

// Area privada
$router->get('/appointment', [AppointmentController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

//* API
// endpoint
$router->get('/api/services', [APIController::class, 'index']);
$router->post('/api/appointments', [APIController::class, 'save']);
$router->post('/api/delete', [APIController::class, 'delete']);

// CRUD de servicios
$router->get('/services', [ServiceController::class, 'index']);
$router->get('/services/create', [ServiceController::class, 'create']);
$router->post('/services/create', [ServiceController::class, 'create']);
$router->get('/services/update', [ServiceController::class, 'update']);
$router->post('/services/update', [ServiceController::class, 'update']);
$router->post('/services/delete', [ServiceController::class, 'delete']);

$router->get('/error404', [PageController::class, 'error404']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->checkRoutes();