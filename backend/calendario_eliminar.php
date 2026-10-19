<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "mensaje" => "Método no permitido"
    ]);
    exit;
}

$id = $_POST["id"] ?? "";

if ($id === "") {
    echo json_encode([
        "success" => false,
        "mensaje" => "Falta el ID del evento"
    ]);
    exit;
}

$sql = "SELECT imagen_url
        FROM calendario_imagenes
        WHERE calendario_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

while ($imagen = $resultado->fetch_assoc()) {

    $archivo = __DIR__ . "/" . $imagen["imagen_url"];

    if (file_exists($archivo)) {
        unlink($archivo);
    }
}

$sqlEliminar = "DELETE FROM calendario WHERE id = ?";

$stmtEliminar = $conn->prepare($sqlEliminar);
$stmtEliminar->bind_param("i", $id);

if ($stmtEliminar->execute()) {

    echo json_encode([
        "success" => true,
        "mensaje" => "Evento eliminado correctamente"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "mensaje" => "No se pudo eliminar el evento"
    ]);
}

$conn->close();
?>