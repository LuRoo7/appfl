<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

require_once "conexion.php";

$titulo = trim($_POST["titulo"] ?? "");
$texto = trim($_POST["texto"] ?? "");

if ($titulo === "") {
    echo json_encode([
        "ok" => false,
        "mensaje" => "El título es obligatorio."
    ]);
    exit;
}

$rutaBD = null;
$tipo = null;

if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {

    $archivo = $_FILES["imagen"];

    $permitidos = ["jpg", "jpeg", "png", "webp"];

    $extension = strtolower(
        pathinfo($archivo["name"], PATHINFO_EXTENSION)
    );

    if (!in_array($extension, $permitidos)) {
        echo json_encode([
            "ok" => false,
            "mensaje" => "Formato de imagen no permitido."
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

    $carpeta = __DIR__ . "/uploads/epp/";

    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $nombre = uniqid("epp_", true) . "." . $extension;

    $rutaFisica = $carpeta . $nombre;
    $rutaBD = "uploads/epp/" . $nombre;
    $tipo = "imagen";

    if (!move_uploaded_file($archivo["tmp_name"], $rutaFisica)) {
        echo json_encode([
            "ok" => false,
            "mensaje" => "No se pudo guardar la imagen."
        ]);
        exit;
    }
}

$stmt = $conn->prepare(
    "INSERT INTO epp
    (titulo, texto, multimedia_url, tipo_multimedia)
    VALUES (?, ?, ?, ?)"
);

$stmt->bind_param(
    "ssss",
    $titulo,
    $texto,
    $rutaBD,
    $tipo
);

if ($stmt->execute()) {

    echo json_encode([
        "ok" => true,
        "mensaje" => "EPP creado correctamente."
    ]);

} else {

    if ($rutaBD) {
        $rutaFisica = __DIR__ . "/" . $rutaBD;

        if (file_exists($rutaFisica)) {
            unlink($rutaFisica);
        }
    }

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se pudo crear el EPP."
    ]);
}

$stmt->close();
$conn->close();
?>