<?php
require_once '../includes/functions.php';
require_once DB_URL;

if (isAuth()) {
    header('Location: /dashboard');
}

/**
 * Incluir el archivo header.php, el cual contiene los metadatos de la página, titulo de la página 
 * y las importaciones de los archivos css
 */
include_template('header');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $errors = [];

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $passwordConfirm = trim($_POST['passwordConfirm']);

    if (empty($username)) {
        $errors[] = 'El usuario es requerido';
    }

    if (strlen(trim($username)) < 3 || strlen(trim($username)) > 10) {
        $errors[] = 'El usuario debe de tener al menos 3 caracteres y máximo 10';
    }

    if (empty($email)) {
        $errors[] = 'El email es requerido';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email no valido";
    }

    if (empty($password)) {
        $errors[] = 'La contraseña es requerida';
    }

    if (strlen($password) < 8) {
        $errors[] = 'La contraseña es muy corta';
    }

    if (empty($passwordConfirm)) {
        $errors[] = 'La confirmación de la contraseña es requerida';
    }

    if ($password != $passwordConfirm) {
        $errors[] = 'Las contraseñas no son iguales';
    }

    $db = db_connect();

    $queryUserTemp = 'SELECT username from user WHERE username = ?';
    $stmtUserTemp = $db->prepare($queryUserTemp);
    $stmtUserTemp->bindParam(1, $username);
    $stmtUserTemp->execute();
    $stmtUserTemp->fetch(PDO::FETCH_ASSOC);

    if ($stmtUserTemp->rowCount() !== 0) {
        $errors[] = "Nombre de Usuario ya existe";
    }

    $queryEmailTemp = 'SELECT email from user WHERE email = ?';
    $stmtEmailTemp = $db->prepare($queryEmailTemp);
    $stmtEmailTemp->bindParam(1, $email);
    $stmtEmailTemp->execute();
    $stmtEmailTemp->fetch(PDO::FETCH_ASSOC);

    if ($stmtEmailTemp->rowCount() !== 0) {
        $errors[] = "Correo Electrónico ya existe";
    }


    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $query = 'INSERT INTO user (username,passwordHash,email) VALUES (?,?,?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $passwordHash);
        $stmt->bindParam(3, $email);
        $stmt->execute();
        header('Location: /auth/login.php?message="Te has registrado correctamente"');
    }
}
?>
<!--Inicio de Body -->
<div class="register auth h-100">
    <div class="row h-100">
        <div class="col-12 col-lg-6 justify-content-center align-items-center d-flex h-100">
            <form action="register.php" method="POST" class="form card shadow p-3" novalidate>
                <div>
                    <a href="/" class="text-secondary" title="Regresar"><i class="fa-solid fa-arrow-left-long"></i></a>
                </div>
                <div class="d-flex flex-column gap-2 p-5 ">
                    <h2 class="text-center text-primary">Registro</h2>
                    <div class="alert-container">
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger">
                                <span><?php echo $errors[0] ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label fw-bold">
                            Nombre de Usuario
                        </label>
                        <input required class="form-control" type="text" placeholder="Nombre de Usuario" name="username" id="username" value="<?php echo empty($username) ? '' : $username  ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">
                            Correo Electronico
                        </label>
                        <input required class="form-control" type="email" placeholder="Correo Electronico" name="email" id="email" value="<?php echo empty($email) ? '' : $email  ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">
                            Contraseña
                        </label>
                        <input required class="form-control" type="password" placeholder="Contraseña" name="password" id="password" />
                    </div>
                    <div class="mb-3">
                        <label for="passwordConfirm" class="form-label fw-bold">
                            Confirmar Contraseña
                        </label>
                        <input required class="form-control" type="password" placeholder="Confirmar Contraseña" name="passwordConfirm" id="passwordConfirm" />
                    </div>
                    <button class="btn btn-primary">Registrarse</button>
                    <div class="text-end">
                        <a href="/auth/login.php">Iniciar Sesión</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-6 d-none d-lg-block h-100 register-img"></div>
    </div>
</div>
<!--Fin del Body -->
<?php
/**
 * Incluir el archivo footer.php, el cual contiene el footer de la página y las importaciones de los archivos de javascript
 */
include_template('footer', false);
?>