<?php include_once __DIR__ . '/../templates/bar.php' ?>

<h1 class="page-name margin-top">Servicios</h1>
<p class="page-description">Administracion de Servicios</p>

<ul class="services">
    <?php foreach ($services as $service): ?>
        <li>
            <p>Nombre: <span><?php echo $service->name; ?></span></p>
            <p>Precio: <span>$<?php echo $service->price; ?></span></p>

            <div class="actions">
                <a class="button" href="/services/update?id=<?php echo $service->id; ?>">Actualizar</a>

                <form action="/services/delete" method="POST">
                    <input name="id" type="hidden" value="<?php echo $service->id ?>">
                    <input class="delete-button" type="submit" value="Eliminar">
                </form>
            </div>
        </li>
    <?php endforeach; ?>
</ul>