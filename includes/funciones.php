<?php

/*
 * funciones.php
 * --------------------------------------------------
 * Funciones para leer, guardar y buscar recetas.
 * Los datos se guardan en un archivo JSON
 * (datos/recetas.json), sin base de datos.
 * --------------------------------------------------
 */

// Ruta absoluta del archivo JSON
define("ARCHIVO_RECETAS", __DIR__ . "/../datos/recetas.json");

// Obtiene todas las recetas guardadas en el archivo JSON
function obtenerRecetas() {

    // Si el archivo no existe, devuelve un arreglo vacío
    if (!file_exists(ARCHIVO_RECETAS)) {
        return [];
    }

    // Lee el contenido del archivo JSON
    $contenido = file_get_contents(ARCHIVO_RECETAS);

    // Convierte el JSON en arreglo asociativo de PHP
    $recetas = json_decode($contenido, true);

    // Si el JSON está vacío o dañado, devuelve un arreglo vacío
    return is_array($recetas) ? $recetas : [];
}

// Busca una receta por su ID. Devuelve null si no existe.
function obtenerRecetaPorId($id) {

    foreach (obtenerRecetas() as $receta) {
        if ((int) $receta["id"] === (int) $id) {
            return $receta;
        }
    }

    return null;
}

// Guarda todas las recetas en el archivo JSON
function guardarTodasLasRecetas($recetas) {

    // LOCK_EX evita que dos guardados al mismo tiempo dañen el archivo
    file_put_contents(
        ARCHIVO_RECETAS,
        json_encode($recetas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        LOCK_EX
    );
}

// Guarda una nueva receta y devuelve su ID
function guardarReceta($nombre, $categoria, $tiempo, $imagen, $ingredientes, $pasos) {

    // Obtiene las recetas existentes
    $recetas = obtenerRecetas();

    // Calcula el siguiente ID (el mayor + 1)
    $nuevoId = 1;
    foreach ($recetas as $receta) {
        $nuevoId = max($nuevoId, (int) $receta["id"] + 1);
    }

    // Los datos se guardan tal como se escribieron.
    // El escape con htmlspecialchars() se hace al MOSTRARLOS,
    // así el texto no se escapa dos veces.
    $recetas[] = [
        "id" => $nuevoId,
        "nombre" => $nombre,
        "categoria" => $categoria,
        "tiempo" => $tiempo,
        "imagen" => $imagen,
        "ingredientes" => $ingredientes,
        "pasos" => $pasos
    ];

    // Guarda nuevamente todas las recetas
    guardarTodasLasRecetas($recetas);

    return $nuevoId;
}

// Busca recetas por nombre o categoría (sin importar mayúsculas)
function buscarRecetas($texto) {

    $texto = mb_strtolower(trim($texto));
    $resultados = [];

    foreach (obtenerRecetas() as $receta) {
        if (
            str_contains(mb_strtolower($receta["nombre"]), $texto) ||
            str_contains(mb_strtolower($receta["categoria"]), $texto)
        ) {
            $resultados[] = $receta;
        }
    }

    return $resultados;
}

// Cuenta cuántas recetas hay guardadas
function contarRecetas() {
    return count(obtenerRecetas());
}

// Valida que un texto exista y no esté vacío
function validarTexto($dato) {
    return isset($dato) && trim($dato) !== "";
}

// Atajo para escapar texto antes de mostrarlo en HTML
function e($texto) {
    return htmlspecialchars((string) $texto, ENT_QUOTES, "UTF-8");
}
