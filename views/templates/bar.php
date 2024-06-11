<div class="bar">
    <a href="/logout">
        <img class="icon-logout" src="/build/img/logout.svg" alt="Cerrar Sesion">
    </a>
</div>

<?php if ( isset($_SESSION['admin'])): ?>
    <div class="service-bar appointment">
        <a class="button" href="/admin">Ver Citas</a>
        <a class="button" href="/services">Ver Servicios</a>
        <a class="button" href="/services/create">Nuevo Servicio</a>
    </div>
<?php endif; ?>