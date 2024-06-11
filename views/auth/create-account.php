<h1 class="page-name">Crear cuenta</h1>

<?php 
    include_once __DIR__ . "/../templates/alerts.php";
?>

<form action="/create-account" class="form" method="POST">
    <div class="field two-columns">
        <div class="column">
            <label for="name">Nombre</label>
            <input name="name" type="text" id="name" placeholder="Ej. Adrian" value="<?php echo s($user->name) ?>">
        </div>
        <div class="column">
            <label for="last_name">Apellido</label>
            <input name="last_name" type="text" id="last_name" placeholder="Ej. Miranda" value="<?php echo s($user->last_name) ?>">
        </div>
    </div>

    <div class="field">
        <label for="phone_number">Telefono</label>
        <input name="phone_number" type="number" id="phone_number" placeholder="Ej. 6648821234" value="<?php echo s($user->phone_number) ?>">
    </div>
    
    <div class="field">
        <label for="email">Email</label>
        <input name="email" type="text" id="name" placeholder="correo@correo.com" value="<?php echo s($user->email) ?>">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input name="password" type="password" id="password" placeholder="Ej. 3584">
    </div>

    <input type="submit" class="button" value="Crear Cuenta">

    <div class="actions">
        <a href="/">Ya tengo una cuenta</a>
    </div>
</form>