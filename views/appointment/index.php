<?php include_once __DIR__ . '/../templates/bar.php' ?>
<h1 class="page-name" id="margin-top">Crear Nueva Cita</h1>

<p class="page-description">Elige tus servicios y coloca tus datos:</p>

<div id="app">

    <nav class="tabs">
        <button type="button" data-step="1" class="current">Servicios</button>
        <button type="button" data-step="2">Informacion Cita</button>
        <button type="button" data-step="3">Resumen</button>
    </nav>

    <div id="step-1" class="section">
        <h2>Services</h2>
        <p class="text-center" id="margin-bottom">Elige tus servicios</p>
        <div id="services" class="list-services"></div>
    </div>

    <div id="step-2" class="section">
        <h2>Tus datos y Cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita:</p>

        <form class="form">
            <div class="field">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" placeholder="Tu nombre" value="<?php echo $name; ?>" readonly>
            </div>

            <div class="field">
                <label for="date">Fecha</label>
                <input type="date" name="date" id="date" min="<?php echo date( 'Y-m-d', strtotime('+1 day') ) ?>">
            </div>

            <div class="field">
                <label for="hour">Hora</label>
                <input type="time" name="hour" id="hour">
            </div>

            <input type="hidden" id="id" value="<?php echo $id ?>">
        </form>

    </div>

    <div id="step-3" class="section summary-content">
    </div>

    <div class="pagination">
        <button id="previous" class="button">&laquo; Anterior</button>
        <button id="later" class="button">Siguiente &raquo;</button>
    </div>
</div>

<?php 
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";
?>