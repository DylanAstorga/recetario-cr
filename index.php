<?php

require_once "includes/funciones.php";

$recetas = obtenerRecetas();

include "includes/header.php";

?>

<div class="container py-5">

    <!-- Título principal -->
    <div class="text-center mb-5">

        <h1 class="display-4 fw-bold text-success">
            Recetario Digital Costarricense
        </h1>

        <p class="lead">
            Descubre las mejores recetas tradicionales de Costa Rica.
        </p>

        <p class="text-muted">
            <?= contarRecetas() ?> recetas disponibles
        </p>

        <hr>

    </div>

    <!-- Catálogo -->
    <div class="row">

        <?php foreach ($recetas as $receta) { ?>

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="card card-receta h-100 shadow border-0 rounded-4">

                <img
                    src="<?= e($receta["imagen"]) ?>"
                    class="card-img-top"
                    alt="<?= e($receta["nombre"]) ?>">

                <div class="card-body">

                    <span class="badge bg-success mb-3">
                        <?= e($receta["categoria"]) ?>
                    </span>

                    <h4 class="fw-bold">
                        <?= e($receta["nombre"]) ?>
                    </h4>

                    <p class="text-muted mb-0">
                        ⏱ <?= e($receta["tiempo"]) ?>
                    </p>

                </div>

                <div class="card-footer bg-white border-0">

                    <a
                        href="receta.php?id=<?= (int) $receta["id"] ?>"
                        class="btn btn-success w-100">
                        Ver receta completa
                    </a>

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

<?php include "includes/footer.php"; ?>
