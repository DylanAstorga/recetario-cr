<?php

require_once "includes/funciones.php";

$texto = trim($_GET["buscar"] ?? "");

// Si hay texto, filtra; si no, muestra todas las recetas
$resultados = $texto !== "" ? buscarRecetas($texto) : obtenerRecetas();

include "includes/header.php";

?>

<div class="container py-5">

    <h2 class="mb-4 text-success fw-bold">Buscar recetas</h2>

    <form method="GET" class="d-flex gap-2 mb-4">
        <input
            type="text"
            name="buscar"
            class="form-control"
            placeholder="Nombre o categoría (ej: almuerzo)"
            value="<?= e($texto) ?>">
        <button type="submit" class="btn btn-success">Buscar</button>
    </form>

    <?php if (empty($resultados)) { ?>

        <div class="alert alert-warning">
            No se encontraron recetas para "<?= e($texto) ?>".
        </div>

    <?php } else { ?>

        <p class="text-muted"><?= count($resultados) ?> resultado(s)</p>

        <div class="list-group">
            <?php foreach ($resultados as $receta) { ?>
                <a href="receta.php?id=<?= (int) $receta["id"] ?>"
                   class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                    <img src="<?= e($receta["imagen"]) ?>" alt="" width="90" height="70" style="object-fit:cover" class="rounded">
                    <div>
                        <strong><?= e($receta["nombre"]) ?></strong><br>
                        <small class="text-muted"><?= e($receta["categoria"]) ?> · <?= e($receta["tiempo"]) ?></small>
                    </div>
                </a>
            <?php } ?>
        </div>

    <?php } ?>

</div>

<?php include "includes/footer.php"; ?>
