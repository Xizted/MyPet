<?php
require_once DB_URL;
$db = db_connect();

$pets = [];
$query = 'SELECT pet.name, pet.breed, pet.specie, pet.photo, user.username FROM pet INNER JOIN user ON pet.userid = user.id ORDER BY pet.id DESC LIMIT 4';
$stmt = $db->prepare($query);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pets[] = $row;
}


?>

<section id="adopt" class="adopt text-center mt-5 container">
    <div class="subtitle mb-4">
        <h2 class="fw-bold">Algunas de nuestra mascotas</h2>
    </div>
    <div class="container">
        <div class="row gap-5 justify-content-center">
            <?php foreach ($pets as $pet) : ?>
                <div class="card shadow col-12 col-md-4 col-lg-2" style="width: 18rem; ">
                    <img src="uploads/<?php echo $pet['photo'] ?>" class="card-img-top w-100" style="height: 10rem;" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $pet['name'] ?></h5>
                        <div class="text-start">
                            <p><strong>Raza:</strong> <?php echo $pet['breed'] ?> </p>
                            <p><strong>Especie:</strong> <?php echo $pet['specie'] ?> </p>
                            <p><strong>Dueño:</strong> <?php echo $pet['username'] ?> </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>