<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

require_once "conexion.php";

$id = intval($_POST["id"] ?? 0);
$titulo = trim($_POST["titulo"] ?? "");
$texto = trim($_POST["texto"] ?? "");

if ($id <= 0 || $titulo === "") {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Datos inválidos."
    ]);
    exit;
}

$stmt = $conn->prepare(
    "SELECT multimedia_url FROM epp WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$actual = $resultado->fetch_assoc();

$stmt->close();

if (!$actual) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "EPP no encontrado."
    ]);
    exit;
}

$rutaBD = $actual["multimedia_url"];
$tipo = "imagen";

if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {

    $archivo = $_FILES["imagen"];

    $permitidos = ["jpg", "jpeg", "png", "webp"];

    $extension = strtolower(
        pathinfo($archivo["name"], PATHINFO_EXTENSION)
    );

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

    $carpeta = __DIR__ . "/uploads/epp/";

    if (!is_dir($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $nombre = uniqid("epp_", true) . "." . $extension;

    $nuevaRutaFisica = $carpeta . $nombre;
    $nuevaRutaBD = "uploads/epp/" . $nombre;

    if (!move_uploaded_file($archivo["tmp_name"], $nuevaRutaFisica)) {
        echo json_encode([
            "ok" => false,
            "mensaje" => "No se pudo guardar la nueva imagen."
        ]);
        exit;
    }

    if ($rutaBD) {
        $rutaAnterior = __DIR__ . "/" . $rutaBD;

        if (file_exists($rutaAnterior)) {
            unlink($rutaAnterior);
        }
    }

    $rutaBD = $nuevaRutaBD;
    $tipo = "imagen";
}

$stmt = $conn->prepare(
    "UPDATE epp
     SET titulo = ?, texto = ?, multimedia_url = ?, tipo_multimedia = ?
     WHERE id = ?"
);

$stmt->bind_param(
    "ssssi",
    $titulo,
    $texto,
    $rutaBD,
    $tipo,
    $id
);

if ($stmt->execute()) {

    echo json_encode([
        "ok" => true,
        "mensaje" => "EPP modificado correctamente."
    ]);

} else {

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se pudo modificar el EPP."
    ]);
}

$stmt->close();
$conn->close();
?>