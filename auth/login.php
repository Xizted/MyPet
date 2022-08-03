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

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

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

    $db = db_connect();

    $query = 'SELECT * from user WHERE email = ?';
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $userTemp = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userTemp || !password_verify($password, $userTemp["passwordHash"])) {
        $errors[] = 'El email o contraseña no coniciden';
    }

    if (empty($errors)) {
        session_start();
        $_SESSION['user'] = ["id" => $userTemp['id'], "username" => $userTemp['username'], "email" => $userTemp['email']];
        $_SESSION['login'] = true;

        header('Location: /dashboard');
    }
}

?>
<!--Inicio de Body -->
<div class="login auth h-100">
    <div class="row h-100">
        <div class="col-6 d-none d-lg-block h-100 login-img"></div>
        <div class="col-12 col-lg-6 justify-content-center align-items-center d-flex h-100">
            <form action="login.php" method="POST" class="form card shadow p-3" novalidate>
                <div>
                    <a href="/" class="text-secondary" title="Regresar"><i class="fa-solid fa-arrow-left-long"></i></a>
                </div>
                <div class="d-flex flex-column gap-2 p-5 ">
                    <h2 class="text-center text-primary">Iniciar Sesión</h2>
                    <div class="alert-container">
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger">
                                <span><?php echo $errors[0] ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_GET["message"])) : ?>
                            <div class="alert alert-success">
                                <span><?php echo $_GET["message"] ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">
                            Correo Electronico
                            <input class="form-control" required type="email" placeholder="Correo Electronico" name="email" id="email" value="<?php echo empty($email) ? '' : $email ?>" />
                        </label>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">
                            Contraseña
                            <input class="form-control" required type="password" placeholder="Contraseña" name="password" id="password" />
                        </label>
                    </div>
                    <button class="btn btn-primary">Ingresar</button>
                    <div class="text-end">
                        <a href="/auth/register.php">Registrarse</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Fin del Body -->
<?php
/**
 * Incluir el archivo footer.php, el cual contiene el footer de la página y las importaciones de los archivos de javascript
 */
include_template('footer', false);
?>