<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

require_once "conexion.php";

if (!isset($_POST["titulo"]) || !isset($_FILES["archivo"])) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Faltan datos."
    ]);
    exit;
}

$titulo = trim($_POST["titulo"]);
$archivo = $_FILES["archivo"];

if ($archivo["error"] !== UPLOAD_ERR_OK) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Error al subir el archivo."
    ]);
    exit;
}

$permitidos = ["jpg", "jpeg", "png", "webp"];

$extension = strtolower(pathinfo($archivo["name"], PATHINFO_EXTENSION));

if (!in_array($extension, $permitidos)) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Formato no permitido."
    ]);
    exit;
}

if ($archivo["size"] > 5 * 1024 * 1024) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "La imagen no puede superar los 5 MB."
    ]);
    exit;
}

$nombre = uniqid("higiene_", true) . "." . $extension;

$carpeta = __DIR__ . "/uploads/higiene/";

if (!is_dir($carpeta)) {
    mkdir($carpeta, 0777, true);
}

$rutaFisica = $carpeta . $nombre;
$rutaBD = "uploads/higiene/" . $nombre;

if (!move_uploaded_file($archivo["tmp_name"], $rutaFisica)) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "No se pudo guardar la imagen."
    ]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO imagenesprev
    (titulo, multimedia_url, tipo_multimedia)
    VALUES (?, ?, 'imagen')"
);

$stmt->bind_param("ss", $titulo, $rutaBD);

if ($stmt->execute()) {
    echo json_encode([
        "ok" => true,
        "mensaje" => "Imagen agregada correctamente."
    ]);
} else {
    if (file_exists($rutaFisica)) {
        unlink($rutaFisica);
    }

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se pudo guardar en la base de datos."
    ]);
}

$stmt->close();
$conn->close();
?>