<?php

namespace Model;

class ServiceAppointment extends ActiveRecord {
    protected static $table = 'servicesAppointment';
    protected static $columnsDB = ['id', 'appointment_id', 'service_id'];

    public $id;
    public $appointment_id;
    public $service_id;

    public function __construct( $args = [])
    {   
        $this->id = $args['id'] ?? NULL;
        $this->appointment_id = $args['appointment_id'] ?? '';
        $this->service_id = $args['service_id'] ?? '';
    }
}