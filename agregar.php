<?php

require_once "includes/funciones.php";

$errores = [];

// Valores del formulario (se conservan si hay errores)
$datos = [
    "nombre" => "",
    "categoria" => "",
    "tiempo" => "",
    "imagen" => "",
    "ingredientes" => "",
    "pasos" => ""
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Leer y limpiar los datos enviados
    foreach ($datos as $campo => $valor) {
        $datos[$campo] = trim($_POST[$campo] ?? "");
    }

    // Validar campos obligatorios
    foreach ($datos as $campo => $valor) {
        if (!validarTexto($valor)) {
            $errores[] = "El campo \"$campo\" es obligatorio.";
        }
    }

    // Validar que la imagen sea una URL http(s)
    if ($datos["imagen"] !== "" &&
        (!filter_var($datos["imagen"], FILTER_VALIDATE_URL) ||
         !preg_match("#^https?://#i", $datos["imagen"]))) {
        $errores[] = "La imagen debe ser una URL válida (http o https).";
    }

    // Si todo está bien, guardar y redirigir a la receta nueva
    if (empty($errores)) {

        $id = guardarReceta(
            $datos["nombre"],
            $datos["categoria"],
            $datos["tiempo"],
            $datos["imagen"],
            $datos["ingredientes"],
            $datos["pasos"]
        );

        header("Location: receta.php?id=" . $id);
        exit();
    }
}

include "includes/header.php";

?>

<div class="container py-5 formulario">

    <h2 class="mb-4 text-success fw-bold">Agregar receta</h2>

    <?php if (!empty($errores)) { ?>
        <div class="alert alert-danger">
            <?php foreach ($errores as $error) { ?>
                <div><?= e($error) ?></div>
            <?php } ?>
        </div>
    <?php } ?>

    <form method="POST" class="card card-body shadow-sm border-0 rounded-4">

        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control mb-3" value="<?= e($datos["nombre"]) ?>" required>

        <label class="form-label">Categoría</label>
        <input type="text" name="categoria" class="form-control mb-3" placeholder="Desayuno, Almuerzo, Postre..." value="<?= e($datos["categoria"]) ?>" required>

        <label class="form-label">Tiempo de preparación</label>
        <input type="text" name="tiempo" class="form-control mb-3" placeholder="30 minutos" value="<?= e($datos["tiempo"]) ?>" required>

        <label class="form-label">Imagen (URL)</label>
        <input type="url" name="imagen" class="form-control mb-3" value="<?= e($datos["imagen"]) ?>" required>

        <label class="form-label">Ingredientes</label>
        <textarea name="ingredientes" class="form-control mb-3" rows="4" required><?= e($datos["ingredientes"]) ?></textarea>

        <label class="form-label">Pasos</label>
        <textarea name="pasos" class="form-control mb-4" rows="5" required><?= e($datos["pasos"]) ?></textarea>

        <button type="submit" class="btn btn-success">Guardar receta</button>

    </form>

</div>

<?php include "includes/footer.php"; ?>
