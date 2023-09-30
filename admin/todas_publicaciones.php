<?php
session_start();
extract($_REQUEST);

if (!isset($_SESSION['usuario_logueado']))
    header("location:form_login.php");

$rol = $_SESSION['rol'];
if ($rol != "admin") {
    header("location:mis_publicaciones.php?mensaje=Usted no pose permisos de administrador");
}

require("../backend/admin_noticias.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagenes/logos/favicon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/cac8e89f4d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../estaticos/css/style.css">

    <title>Mis publicaciones</title>
</head>

<body class="bg-secondary bg-gradient text-bg-dark">
    <!-- NAVBAR -->
    <div class="">
        <?php require("menu.php"); ?>
    </div>


    <!-- CONTENT -->
    <div class="container-fluid">
        <div class="container">
            <h1 class="text-center">Todas las publicaciones</h1>
        </div>

        <?php
        if (!empty($mensaje)) {
            echo "<div class='alert alert-success' role='alert'>" . $mensaje . "</div>";
        }
        ?>


        <div class="container mt-3">
            <div class="row">
                <a href="../noticias/form_agregar.php" class="btn btn-sm btn-info col-2 offset-5 mb-4">
                    <i class="fa-solid fa-square-plus"></i>
                    Nueva
                </a>
                <?php if ($todas_publicaciones->rowCount() > 0): ?>
                    <?php foreach ($todas_publicaciones as $noticia): ?>
                        <div class="col-12 mb-4">
                            <div class="card p-3 shadow border-black rounded-1 mb-3">
                                <div class="row g-0">
                                    <div class="col-md-3 col-sm-12 justify-content-center align-items-center">
                                        <!-- src="<php print($noticia['imagen'])";?> -->
                                        <img src="../imagenes/subidas/<?php print($noticia['imagen']); ?>"
                                            class="img-fluid rounded-1" alt="Imagen de la tarjeta">
                                    </div>
                                    <div class="col-md-8 col-sm-12">
                                        <div class="card-body">
                                            <p class="card-title mb-1 border-bottom">
                                                <strong>Título:</strong><br>
                                                "
                                                <?php print($noticia['titulo']); ?>"
                                            </p>

                                            <p class="card-text mb-1 border-bottom">
                                                <strong>Copete:</strong><br>
                                                "
                                                <?php print(substr($noticia['copete'], 0, 100)); ?> ..."
                                            </p>
                                            <p class="card-text mb-1 border-bottom">
                                                <strong>Cuerpo:</strong><br>
                                                "
                                                <?php print(substr($noticia['cuerpo'], 0, 100)); ?> ..."
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-1 col-sm-12">
                                        <div class="">
                                            <div
                                                class=" d-flex flex-column flex-wrap justify-content-center text-center slign-items-center w-100">

                                                <a href="<?php print('noticias_editar.php?id_noticia=' . $noticia["id_noticia"] . ''); ?>"
                                                    class="btn btn-sm btn-dark m-1"><i class="fa-solid fa-pencil"></i></a>
                                                <a href="<?php print('../backend/borrar_noticia.php?id_noticia=' . $noticia["id_noticia"] . '&imagen=' . $noticia["imagen"] . ''); ?>"
                                                    class="btn btn-sm btn-outline-danger m-1"
                                                    onclick="return confirm(&quot; Desea eliminar &quot;)"><i
                                                        class="fa-solid fa-trash-can"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-left col-12">
                                        <small>Publicada el:
                                            <span class="badge text-bg-dark">
                                                <?php print($noticia['fecha']) ?>
                                            </span>
                                        </small>
                                        <small>Autor:
                                            <span class="badge text-bg-dark">
                                                <?php print($noticia['autor']) ?>
                                            </span>
                                        </small>
                                        <?php if ($noticia['rol'] == "admin"): ?>
                                            <small>Rol:
                                                <span class="badge text-bg-danger">
                                                    <?php print(strtoupper($noticia['rol'])) ?>
                                                </span>
                                            </small>
                                        <?php else: ?>
                                            <small>Rol:
                                                <span class="badge text-bg-secondary">
                                                    AUTOR
                                                </span>
                                            </small>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="container mt-3 alert alert-secondary">
                Aún no has publicado nada
            </div>
        <?php endif ?>
</body>

</html>