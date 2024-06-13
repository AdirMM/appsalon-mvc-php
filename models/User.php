<?php

namespace Model;

class User extends ActiveRecord
{
    protected static $table = 'users';
    protected static $columnsDB = ['id', 'name', 'last_name', 'email', 'password', 'phone_number', 'admin', 'token', 'confirmed'];

    public $id;
    public $name;
    public $last_name;
    public $email;
    public $password;
    public $phone_number;
    public $admin;
    public $token;
    public $confirmed;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->name = $args['name'] ?? '';
        $this->last_name = $args['last_name'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->phone_number = $args['phone_number'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->confirmed = $args['confirmed'] ?? 0;
    }

    public function valide()
    {
        switch (true) {
            case !$this->name:
                self::$alerts['error'][] = 'Por favor ingrese su nombre';
            case !$this->last_name:
                self::$alerts['error'][] = 'Por favor ingrese su apellido';
            case !$this->phone_number:
                self::$alerts['error'][] = 'El numero telefonico es obligatorio';
            case !$this->email:
                self::$alerts['error'][] = 'El correo electronico es obligatorio';
            case !$this->password:
                self::$alerts['error'][] = 'La contraseña es obligatoria';
            case strlen($this->password) < 6:
                self::$alerts['error'][] = 'La contraseña debe de contener al menos 6 caracteres';
            default:
                break;
        }

        return self::$alerts;
    }

    public function userExists () {
        $query = "SELECT email, phone_number FROM " . self::$table . " WHERE email = '" . $this->email . "' LIMIT 1";
        
        $result = self::$db->query($query);

        if ($result->num_rows) {
            $user = $result->fetch_assoc(); //Obten los datos del usuario en un array asociativo

            self::$alerts['error'][] = 'El correo electronico ya esta registrado, intenta de nuevo';
        }

        return $result;
    }

    public function hashPassword () {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function createToken () {
        $this->token = uniqid();
    }

    public function validateLogin () {
        if (!$this->email) {
            self::$alerts['error'][] = 'El email es obligatorio';
        }
        if (!$this->password) {
            self::$alerts['error'][] = 'La contraseña es obligatoria';
        }

        return self::$alerts;
    }

    public function checkPasswordAndVerified ($password) {
        $result = password_verify($password, $this->password);

        if (!$result || !$this->confirmed) {
            self::$alerts['error'][] = 'Password incorrecto o cuenta no ha sido confirmada';
        } else {
            return true;
        }
    }

    public function validateEmail () {
        if (!$this->email) {
            self::$alerts['error'][] = 'El email es obligatorio';
        }

        return self::$alerts;
    }

    public function validatePassword () {
        if (!$this->password) {
            self::$alerts['error'][] = 'La contraseña es obligatoria';
        }
        if (strlen($this->password) < 6) {
            self::$alerts['error'][] = 'La contraseña debe tener al menos 6 caracteres';
        }

        return self::$alerts;
    }
}