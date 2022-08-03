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

$db = db_connect();

$query = 'SELECT id, name, weight, breed, specie, photo from pet WHERE userid = ?';
$stmt = $db->prepare($query);
$stmt->bindParam(1, $_SESSION['user']['id']);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pets[] = $row;
}


?>
<!--Inicio de Body -->

<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="my-5">Mis mascotas</h2>
        <a href="addPet.php" class="btn btn-outline-primary">Agregar</a>
    </div>
    <div style="overflow: auto;">
        <?php if (!empty($pets)) : ?>
            <table class="table table-striped table-bordered shadow">
                <thead>
                    <tr class="table-dark">
                        <th>Foto</th>
                        <th>Nombre</th>
                        <th>Peso</th>
                        <th>Raza</th>
                        <th>Especie</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pets as $pet) : ?>
                        <tr>
                            <td class="d-flex justify-content-center">
                                <img class="d-block" style="width: 150px" src="/uploads/<?php echo $pet["photo"] ?>" alt="">
                            </td>
                            <td><?php echo $pet["name"]; ?></td>
                            <td><?php echo number_format($pet["weight"], 2); ?> kg</td>
                            <td><?php echo $pet["breed"]; ?></td>
                            <td><?php echo $pet["specie"]; ?></td>
                            <td class="text-center">
                                <a href='deletePet.php?id=<?php echo $pet['id'] ?>' class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                                <a href="editPet.php?id=<?php echo $pet['id'] ?>" class="btn btn-info text-white">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="alert alert-info">
                <span>No tienes mascota registrada</span>
            </div>
        <?php endif; ?>
    </div>
</div>

<!--Fin del Body -->
<?php
/**
 * Incluir el archivo footer.php, el cual contiene el footer de la página y las importaciones de los archivos de javascript
 */
include_template('footer', false);
?>