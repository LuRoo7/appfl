<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "conexion.php";

$sql = "SELECT id, titulo, texto, multimedia_url, tipo_multimedia, fecha_creacion FROM epp ORDER BY id ASC";

$resultado = $conn->query($sql);

$epps = [];

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {
        $epps[] = $fila;
    }

    echo json_encode([
        "ok" => true,
        "epps" => $epps
    ]);
} else {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Error al consultar los EPP"
    ]);
}

$conn->close();
?>