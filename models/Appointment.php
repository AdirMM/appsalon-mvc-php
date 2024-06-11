<?php

namespace Model;

class Appointment extends ActiveRecord {
    protected static $table = 'appointment';
    protected static $columnsDB = ['id', 'date', 'hour', 'user_id'];

    public $id;
    public $date;
    public $hour;
    public $user_id;

    public function __construct( $args = [] )
    {
        $this->id = $args['id'] ?? NULL;
        $this->date = $args['date'] ?? '';
        $this->hour = $args['hour'] ?? '';
        $this->user_id = $args['user_id'] ?? '';
    }
}