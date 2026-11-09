<?php

require_once "includes/funciones.php";

// Si no viene un ID, regresa al catálogo
if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$receta = obtenerRecetaPorId((int) $_GET["id"]);

include "includes/header.php";

?>

<div class="container mt-5">

<?php if ($receta !== null) { ?>

<div class="card shadow border-0 rounded-4">

    <img
        src="<?= e($receta["imagen"]) ?>"
        class="card-img-top imagen-detalle"
        alt="<?= e($receta["nombre"]) ?>">

    <div class="card-body p-4">

        <h1><?= e($receta["nombre"]) ?></h1>

        <hr>

        <p>
            <strong>Categoría:</strong>
            <?= e($receta["categoria"]) ?>
        </p>

        <p>
            <strong>Tiempo de preparación:</strong>
            <?= e($receta["tiempo"]) ?>
        </p>

        <h3 class="mt-4">Ingredientes</h3>

        <p><?= nl2br(e($receta["ingredientes"])) ?></p>

        <h3 class="mt-4">Preparación</h3>

        <p><?= nl2br(e($receta["pasos"])) ?></p>

        <a href="index.php" class="btn btn-success mt-3">
            Volver al catálogo
        </a>

    </div>

</div>

<?php } else { ?>

<div class="alert alert-danger">
    La receta solicitada no existe.
</div>

<a href="index.php" class="btn btn-secondary">Volver</a>

<?php } ?>

</div>

<?php include "includes/footer.php"; ?>
