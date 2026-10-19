<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

require_once "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data["id"] ?? 0);

if ($id <= 0) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "ID inválido."
    ]);
    exit;
}

$stmt = $conn->prepare(
    "SELECT multimedia_url FROM imagenesprev WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$imagen = $resultado->fetch_assoc();

$stmt->close();

if (!$imagen) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Imagen no encontrada."
    ]);
    exit;
}

$stmt = $conn->prepare(
    "DELETE FROM imagenesprev WHERE id = ?"
);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    $rutaFisica = __DIR__ . "/" . $imagen["multimedia_url"];

    if (file_exists($rutaFisica)) {
        unlink($rutaFisica);
    }

    echo json_encode([
        "ok" => true,
        "mensaje" => "Imagen eliminada correctamente."
    ]);

} else {

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se pudo eliminar."
    ]);
}

$stmt->close();
$conn->close();
?>