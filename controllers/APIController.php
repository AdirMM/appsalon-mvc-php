<?php

namespace Controller;

use Model\Appointment;
use Model\Service;
use Model\ServiceAppointment;

class APIController {
    public static function index () {
        $service = Service::all();

        echo json_encode($service);
    }

    public static function save () {
        // Almacena la cita y devuelve el ID

        $appointment = new Appointment($_POST);
        $result = $appointment->save();
        $id = $result['id'];

        // Almacena la cita y el servicio

        $servicesId = explode(",", $_POST['services']); 

        foreach($servicesId as $serviceId) {
            $args = [
                'appointment_id' => $id,
                'service_id' => $serviceId
            ];
            $serviceAppointment = new ServiceAppointment($args);
            $serviceAppointment->save();
        }

        echo json_encode( ['result' => $result] );
    }

    public static function delete () {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];

            $appointment = Appointment::find($id);
            $appointment->delete();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}