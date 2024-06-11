<?php

function debug($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function isLast ( string $current, string $next): bool {
    if ($current !== $next) {
        return true;
    }
    return false;
}

function isAdmin () : void {
    if ( !isset($_SESSION['admin']) ) {
        // Cerramos sesion
        session_start();
        $_SESSION = [];
        // Redireccionamos al usuario para que inicie sesion
        header('Location: /');
    }
}

//  Funcion que revisa que el usuario este autenticado
function isAuth() : void {
    if ( !isset($_SESSION['login'] )) {
        header('Location: /');
    }
}