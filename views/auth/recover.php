<h1 class="page-name">Recuperar Password</h1>
<p class="page-description">Coloca tu nuevo password a continuacion:</p>

<?php include_once __DIR__ . '/../templates/alerts.php' ?>

<?php if ($error) return; ?>

<form class="form" method="POST">
    <div class="field">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="email" placeholder="Tu password">
    </div>

    <input type="submit" class="button" value="Guardar nuevo password">

    <div class="actions">
        <a href="/">Iniciar Sesion</a>
        <a href="/create-account">Crear Cuenta</a>
    </div>
</form>