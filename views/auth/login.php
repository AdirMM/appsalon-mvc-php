<h1 class="page-name">Login</h1>
<p class="page-description">Inicia sesion con tus datos</p>

<?php include_once __DIR__ . '/../templates/alerts.php' ?>

<form class="form" method="POST" action="/">
    <div class="field">
        <label for="email">Email</label>
        <input name="email" type="email" id="email" placeholder="correo@gmail.com">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input name="password" type="password" id="password" placeholder="Ej. 24231">
    </div>

    <input type="submit" class="button" value="Iniciar Sesion">
</form>

<div class="actions">
    <a href="/create-account">Aun no tienes una cuenta? Crea una!</a>
    <a href="/forget">Olvide mi contraseña!</a>
</div>