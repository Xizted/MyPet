<?php


require_once '../includes/functions.php';
require_once DB_URL;
/**
 * Incluir el archivo header.php, el cual contiene los metadatos de la página, titulo de la página 
 * y las importaciones de los archivos css
 */
include_template('header');
include_template('navbar');

if (!isAuth()) {
    header('Location: /auth/login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $errors = [];

    $name = trim($_POST['name']);
    $weight = trim($_POST['weight']);
    $breed = trim($_POST['breed']);
    $specie = trim($_POST['specie']);
    $photo = $_FILES['photo'];

    if (empty($name)) {
        $errors[] = 'El nombre es requerido';
    }

    if (strlen(trim($name)) < 3 || strlen(trim($name)) > 10) {
        $errors[] = 'El nombre debe de tener al menos 3 caracteres y máximo 10';
    }

    if (empty($weight)) {
        $errors[] = 'El peso es requerido';
    }

    if (empty($breed)) {
        $errors[] = 'La raza es requerida';
    }

    if (strlen(trim($breed)) < 3 || strlen(trim($breed)) > 10) {
        $errors[] = 'La raza debe de tener al menos 3 caracteres y máximo 10';
    }

    if (empty($specie)) {
        $errors[] = 'La especie es requerida';
    }

    if (strlen(trim($specie)) < 3 || strlen(trim($specie)) > 10) {
        $errors[] = 'La especie debe de tener al menos 3 caracteres y máximo 10';
    }

    if (empty($photo["name"])) {
        $errors[] = 'Debes de subir una foto';
    }


    if ($photo["size"] > 500000) {
        $errors[] = "El tamaño de la imagen es muy grande";
    }

    $db = db_connect();

    if (empty($errors)) {
        $dir = "../uploads/";
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        $imgFileType = pathinfo($photo["name"])["extension"];
        $imgName = bin2hex(random_bytes(20)) . '.' . $imgFileType;

        move_uploaded_file($photo['tmp_name'], $dir . $imgName);

        $query = 'INSERT INTO pet (name, weight, breed, specie, userId, photo) VALUES (?,?,?,?,?,?)';
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $weight);
        $stmt->bindParam(3, $breed);
        $stmt->bindParam(4, $specie);
        $stmt->bindParam(5, $_SESSION['user']['id']);
        $stmt->bindParam(6, $imgName);
        $stmt->execute();
        header('Location: /dashboard');
    }
}


?>
<!--Inicio de Body -->

<div class="container addPet mt-5 justify-content-center col-12 d-flex">
    <form action="addPet.php" method="POST" class="form card shadow p-3  col-12 col-lg-4" novalidate enctype="multipart/form-data">
        <div>
            <a href="/dashboard" class="text-secondary" title="Regresar"><i class="fa-solid fa-arrow-left-long"></i></a>
        </div>
        <div class="d-flex flex-column gap-2 p-5 ">
            <h2 class="text-center text-primary">Agregar Mascota</h2>
            <div class="alert-container">
                <?php if (!empty($errors)) : ?>
                    <div class="alert alert-danger">
                        <span><?php echo $errors[0] ?></span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label fw-bold">
                    Nombre
                </label>
                <input required class="form-control" type="text" placeholder="Nombre de la mascota" name="name" id="name" value="<?php echo empty($name) ? '' : $name  ?>" />
            </div>
            <div class="mb-3">
                <label for="weight" class="form-label fw-bold">
                    Peso
                </label>
                <input min="1" max="80" required class="form-control" type="number" placeholder="0.00" name="weight" id="weight" value="<?php echo empty($weight) ? '' : $weight  ?>" />
            </div>
            <div class="mb-3">
                <label for="breed" class="form-label fw-bold">
                    Raza
                </label>
                <input required class="form-control" type="text" placeholder="Buldog" name="breed" id="breed" value="<?php echo empty($breed) ? '' : $breed  ?>" />
            </div>
            <div class="mb-3">
                <label for="specie" class="form-label fw-bold">
                    Especie
                </label>
                <input required class="form-control" type="text" placeholder="Perro" name="specie" id="specie" value="<?php echo empty($specie) ? '' : $specie  ?>" />
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label fw-bold">Foto</label>
                <input class="form-control" type="file" id="photo" name="photo" accept=".png,.jpg">
            </div>
            <button class="btn btn-primary">Añadir</button>
        </div>
    </form>
</div>

<!--Fin del Body -->
<?php
/**
 * Incluir el archivo footer.php, el cual contiene el footer de la página y las importaciones de los archivos de javascript
 */
include_template('footer', false);
?>