<h1 class="page-name">Nuevo Servicio</h1>
<p class="page-description">Llena todos los campos para añadir un nuevo servicio</p>

<?php
include_once __DIR__ . '/../templates/bar.php';
?>

<form class="form" action="/services/create" method="POST">

    <?php include_once __DIR__ . '/form.php' ?>

    <input class="button" type="submit" value="Crear Servicio">
</form>