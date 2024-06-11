<?php

namespace Model;

class Service extends ActiveRecord {
    protected static $table = 'services';
    protected static $columnsDB = ['id', 'name', 'price'];

    public $id;
    public $name;
    public $price;

    public function __construct( $args = [] )
    {
        $this->id = $args['id'] ?? NULL;
        $this->name = $args['name'] ?? '';
        $this->price = $args['price'] ?? '';
    }

    public function validate () {
        if (!$this->name) {
            self::$alerts['error'][] = 'El nombre del servicio es obligatorio';
        }
        if (!$this->price) {
            self::$alerts['error'][] = 'El precio del servicio es obligatorio';
        }
        if (!is_numeric($this->price)) {
            self::$alerts['error'][] = 'El precio del servicio no es valido';
        }

        return self::$alerts;
    }
}