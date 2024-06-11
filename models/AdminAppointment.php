<?php

namespace Model;

class AdminAppointment extends ActiveRecord {
    protected static $table = 'servicesAppointment';
    protected static $columnsDB = ['id', 'hour', 'customer', 'email', 'phone_number', 'service', 'price'];

    public $id;
    public $hour;
    public $customer;
    public $email;
    public $phone_number;
    public $service;
    public $price;

    public function __construct( $args = [] )
    {
        $this->id = $args['id'] ?? NULL;
        $this->hour = $args['hour'] ?? '';
        $this->customer = $args['customer'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->phone_number = $args['phone_number'] ?? '';
        $this->service = $args['service'] ?? '';
        $this->price = $args['price'] ?? '';
    }
}