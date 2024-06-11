<h1 class="page-name">Olvide mi contraseña</h1>
<p class="page-description">Reestablece tu password escribiendo tu email a continuacion:</p>

<?php include_once  __DIR__ . "/../templates/alerts.php" ?>

<form class="form" action="/forget" method="POST">
    <div class="field">
        <label for="email">Email</label>
        <input name="email" type="email" id="email" placeholder="Tu email">
    </div>

    <input type="submit" class="button" value="Enviar instrucciones">

    <div class="actions">
        <a href="/">Iniciar Sesion</a>
        <a href="/create-account">Crear Cuenta</a>
    </div>
</form>