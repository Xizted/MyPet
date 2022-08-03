<?php
require_once 'includes/functions.php';
/**
 * Incluir el archivo header.php, el cual contiene los metadatos de la página, titulo de la página 
 * y las importaciones de los archivos css
 */
include_template('header');
$imgs = [0 => "dog", 1 => "cat"];

?>
<!--Inicio de Body -->
<!--Inicio de Header -->
<header class="header">
    <!--Inicio del Nav -->
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-2">
        <div class="container-fluid px-5">
            <a class="navbar-brand fw-bolder" href="/">MyPet</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-around" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link fw-normal active" aria-current="page" href="#home">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-normal" href="#services">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-normal" href="#adopt">Nuestra mascotas</a>
                    </li>
                </ul>
                <?php if (!isAuth()) : ?>
                    <div class="d-flex justify-content-center align-items-center gap-5">
                        <span class="d-none d-lg-block m-0">|</span>
                        <a class="btn btn-outline-primary" href="/auth/register.php">Registrarse</a>
                        <a class="btn btn-primary" href="/auth/login.php">Iniciar Sesión</a>
                    </div>
                <?php else : ?>
                    <div class="d-flex justify-content-center align-items-center gap-5">
                        <span class="d-none d-lg-block m-0">|</span>
                        <a href="/dashboard">Bienvenido <strong><?php echo $_SESSION['user']['username'] ?></strong>, ir al Dashboard</a>
                        <a href="/auth/logout.php" class="btn btn-outline-primary">Cerrar Sesión</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <!--FIN del Nav -->

</header>
<!--Fin de Header -->
<!-- Inicio de Hero -->
<main id="home" class="hero vh-100 mb-2">
    <div class="h-100">
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-lg-6 h-100 mt-5 d-flex justify-content-center justify-content-lg-start align-items-center  align-items-lg-start flex-column text-center text-lg-start">
                    <h1 class="title fw-bold mb-3"><span>Encuentra</span> una <span>nueva</span> mascota para ti.</h1>
                    <p class="fw-bolder mb-3 text-secondary">Con nosotros, puede <span>encontrar</span> mascotas o <span>dar en adopción</span> fácil y rápidamente.</p>
                    <button class="btn btn-primary px-5 py-3 fw-bold">
                        Comenzar
                    </button>
                </div>
                <div class="d-none d-lg-block col-md-6 mt-5 img-right ">
                    <img class="  w-100 img-responsive  d-block m-2" src="assets/img/<?php echo $imgs[rand(0, 1)] ?>.png" alt="cat">
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Fin de Hero -->
<!-- Inicio de Servicio -->
<section id="services" class="services text-center mt-5 container">
    <div class="subtitle mb-4">
        <h2 class="fw-bold">¿Qué podemos hacer?</h2>
    </div>
    <p class="text-secondary fw-bolder mb-4">
        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Rem exercitationem minus, magnam provident nobis quae. Sequi nam recusandae, quos quidem, iste ullam perspiciatis cupiditate sunt velit assumenda molestiae nisi autem.
    </p>
    <div class="container">
        <div class="row gap-5 justify-content-center">
            <div class="card rounded shadow pt-3 col-12 col-md-4 col-lg-2 align-items-center d-flex">
                <img src="assets/img/icon-1.png" class="icon w-25 img-responsive d-block" alt="vacunación">
                <p class="fw-bold mt-3">Vacunación</p>
                <p class="text-secondary fw-bold mt-1">Lorem ipsum dolor sit amet.</p>
            </div>
            <div class="card rounded shadow pt-3 col-12 col-md-4 col-lg-2 align-items-center d-flex">
                <img src="assets/img/icon-2.png" class="icon w-25 img-responsive d-block" alt="Peluqueria de mascotas">
                <p class="fw-bold mt-3">Peluquería de mascotas</p>
                <p class="text-secondary fw-bold mt-1">Lorem ipsum dolor sit amet.</p>
            </div>
            <div class="card rounded shadow pt-3 col-12 col-md-4 col-lg-2 align-items-center d-flex">
                <img src="assets/img/icon-3.png" class="icon w-25 img-responsive d-block" alt="Veterinario">
                <p class="fw-bold mt-3">Veterinario</p>
                <p class="text-secondary fw-bold mt-1">Lorem ipsum dolor sit amet.</p>
            </div>
            <div class="card rounded shadow pt-3 col-12 col-md-4 col-lg-2 align-items-center d-flex">
                <img src="assets/img/icon-4.png" class="icon w-25 img-responsive d-block" alt="Limpieza de dientes">
                <p class="fw-bold mt-3">Limpieza de dientes</p>
                <p class="text-secondary fw-bold mt-1">Lorem ipsum dolor sit amet.</p>
            </div>
        </div>
    </div>
</section>
<!-- Fin de Servicio -->
<!-- Inicio de sección de adopcion -->
<?php include_template('anuncios') ?>
<!-- Fin de sección de adopcion -->
<!--Fin del Body -->
<?php
/**
 * Incluir el archivo footer.php, el cual contiene el footer de la página y las importaciones de los archivos de javascript
 */
include_template('footer');
?>