<?php

namespace Controller;

use Model\AdminAppointment;
use MVC\Router;

class AdminController
{
    public static function index(Router $router)
    {
        session_start();
        isAdmin();

        $date = $_GET['date'] ?? date('Y-m-d');
        $dates = explode('-', $date);

        if ( !checkdate( $dates[1], $dates[2], $dates[0] ) ) {
            header('Location: /404');
        }

        // Consulta la base de datos
        $query = "SELECT appointment.id as id, appointment.hour, CONCAT(users.name, ' ', users.last_name) as customer, "; 
        $query .= " users.email, users.phone_number, services.name as service, services.price "; 
        $query .= " FROM appointment ";
        $query .= " LEFT OUTER JOIN users ";
        $query .= " ON appointment.user_id=users.id ";
        $query .= " LEFT OUTER JOIN servicesappointment ";
        $query .= " ON servicesappointment.appointment_id=appointment.id ";
        $query .= " LEFT OUTER JOIN services ";
        $query .= " ON services.id=servicesappointment.service_id ";
        $query .= " WHERE date = '{$date}'";

        $appointments = AdminAppointment::SQL($query);

        $router->render('admin/index', [
            'appointments' => $appointments,
            'date' => $date
        ]);
    }
}
