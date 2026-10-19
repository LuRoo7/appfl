<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

require_once "conexion.php";

try {

    $sql = "SELECT
                pe.puesto_id,
                pe.epp_id,
                p.nombre AS puesto_nombre,
                e.titulo AS epp_nombre
            FROM puesto_epp pe
            INNER JOIN puestos p
                ON p.id = pe.puesto_id
            INNER JOIN epp e
                ON e.id = pe.epp_id
            ORDER BY p.nombre ASC, e.titulo ASC";

    $resultado = $conn->query($sql);

    $relaciones = [];

    while ($fila = $resultado->fetch_assoc()) {

        $relaciones[] = [
            "puesto_id" => (int)$fila["puesto_id"],
            "epp_id" => (int)$fila["epp_id"],
            "puesto_nombre" => $fila["puesto_nombre"],
            "epp_nombre" => $fila["epp_nombre"]
        ];
    }

    echo json_encode([
        "ok" => true,
        "relaciones" => $relaciones
    ]);

} catch (Throwable $e) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se pudieron cargar las relaciones puesto-EPP.",
        "error" => $e->getMessage(),
        "relaciones" => []
    ]);
}

$conn->close();

?>