<?php include_once __DIR__ . '/../templates/bar.php' ?>
<h1 class="page-name margin-top">Panel de Administracion</h1>

<h2>Buscar Citas</h2>
<div id="search">
    <form class="form">
        <div class="field">
            <label for="date">Fecha</label>
            <input name="date" type="date" id="date" value="<?php echo $date ?>">
        </div>
    </form>
</div>

<?php 
    if (count($appointments) === 0) {
        echo "<br>";
        echo "<br>";
        echo "<h2 class='page-description error'>No hay citas en esta fecha</h2>";
    }
?>

<div id="appointment-admin">
    <ul class="appointments">
        <?php $idAppointment = 0; foreach ( $appointments as $key => $appointment ):  ?>
            <?php if ($idAppointment !== $appointment->id): 
                    $total = 0;
                ?>
            <li>
                <p>ID: <span><?php echo $appointment->id ?></span></p>
                <p>Hora: <span><?php echo $appointment->hour ?></span></p>
                <p>Cliente: <span><?php echo $appointment->customer ?></span></p>
                <p>Telefono: <span><?php echo $appointment->phone_number ?></span></p>
                <p>Email: <span><?php echo $appointment->email ?></span></p>

                <h3>Servicios</h3>
            <?php $idAppointment = $appointment->id; ?>
            <?php endif; 
                    $total += $appointment->price;
                ?>
                <p class="service"><?php echo $appointment->service . " "?> <span class="price">$<?php echo $appointment->price ?></span></p>
        <?php 
            $current = $appointment->id;
            $next = $appointments[$key + 1]->id ?? 0;

            if (isLast($current, $next)): ?>
                <p class="total">Total: <span>$<?php echo $total ?></span></p>

                <form action="/api/delete" method="POST">
                    <input name="id" type="hidden" value="<?php echo $appointment->id ?>">
                    <input class="delete-button" type="submit" value="Eliminar Cita">
                </form>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>

<?php 
    $script = "<script src='build/js/searcher.js'></script>"
?>