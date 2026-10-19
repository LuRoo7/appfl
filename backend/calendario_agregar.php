<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

include "conexion.php";

$fecha = $_POST["fecha"] ?? "";
$titulo = $_POST["titulo"] ?? "";
$descripcion = $_POST["descripcion"] ?? "";

if ($fecha === "" || $titulo === "") {
    echo json_encode([
        "success" => false,
        "mensaje" => "La fecha y el título son obligatorios"
    ]);
    exit;
}

$sql = "INSERT INTO calendario (fecha, titulo, descripcion)
        VALUES (?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $fecha, $titulo, $descripcion);

if (!$stmt->execute()) {
    echo json_encode([
        "success" => false,
        "mensaje" => "No se pudo guardar el evento"
    ]);
    exit;
}

$calendarioId = $conn->insert_id;

$carpeta = __DIR__ . "/calendario/";

if (!is_dir($carpeta)) {
    mkdir($carpeta, 0777, true);
}

if (isset($_FILES["imagenes"])) {

    $cantidad = count($_FILES["imagenes"]["name"]);

    for ($i = 0; $i < $cantidad; $i++) {

        if ($_FILES["imagenes"]["error"][$i] !== UPLOAD_ERR_OK) {
            continue;
        }

        $nombreOriginal = $_FILES["imagenes"]["name"][$i];
        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

        $permitidas = ["jpg", "jpeg", "png", "webp"];

        if (!in_array($extension, $permitidas)) {
            continue;
        }

        $nombreArchivo = "calendario_" . uniqid() . "." . $extension;

        $rutaFisica = $carpeta . $nombreArchivo;
        $rutaBD = "calendario/" . $nombreArchivo;

        if (move_uploaded_file(
            $_FILES["imagenes"]["tmp_name"][$i],
            $rutaFisica
        )) {

            $sqlImagen = "INSERT INTO calendario_imagenes
                          (calendario_id, imagen_url)
                          VALUES (?, ?)";

            $stmtImagen = $conn->prepare($sqlImagen);
            $stmtImagen->bind_param("is", $calendarioId, $rutaBD);
            $stmtImagen->execute();
        }
    }
}

echo json_encode([
    "success" => true,
    "mensaje" => "Evento agregado correctamente"
]);

$conn->close();
?>