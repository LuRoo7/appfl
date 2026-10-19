<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once "conexion.php";

$sql = "SELECT id, fecha, titulo, descripcion FROM calendario ORDER BY fecha ASC";

$resultado = $conn->query($sql);

$eventos = [];

while ($fila = $resultado->fetch_assoc()) {

    $id = $fila["id"];

    $sqlImagenes = "SELECT id, imagen_url 
                    FROM calendario_imagenes 
                    WHERE calendario_id = $id
                    ORDER BY id ASC";

    $resultadoImagenes = $conn->query($sqlImagenes);

    $imagenes = [];

    while ($imagen = $resultadoImagenes->fetch_assoc()) {
        $imagenes[] = $imagen["imagen_url"];
    }

    $fila["imagenes"] = $imagenes;

    $eventos[] = $fila;
}

echo json_encode($eventos);

$conn->close();
?>