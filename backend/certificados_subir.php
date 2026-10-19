<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
    exit;
}

$legajo = filter_input(INPUT_POST, "legajo", FILTER_VALIDATE_INT);

if (!$legajo || !isset($_FILES["archivo"])) {
    http_response_code(400);
    echo json_encode(["error" => "Falta el legajo o el certificado"]);
    exit;
}

$archivo = $_FILES["archivo"];

if ($archivo["error"] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(["error" => "No se pudo recibir el certificado"]);
    exit;
}

if ($archivo["size"] > 5 * 1024 * 1024) {
    http_response_code(400);
    echo json_encode(["error" => "El archivo no puede superar los 5 MB"]);
    exit;
}

$extension = strtolower(pathinfo($archivo["name"], PATHINFO_EXTENSION));
$extensionesPermitidas = ["pdf", "jpg", "jpeg", "png"];

if (!in_array($extension, $extensionesPermitidas, true)) {
    http_response_code(400);
    echo json_encode(["error" => "Formato no permitido"]);
    exit;
}

$mime = (new finfo(FILEINFO_MIME_TYPE))->file($archivo["tmp_name"]);

$mimesPermitidos = [
    "pdf" => ["application/pdf"],
    "jpg" => ["image/jpeg"],
    "jpeg" => ["image/jpeg"],
    "png" => ["image/png"]
];

if (!in_array($mime, $mimesPermitidos[$extension], true)) {
    http_response_code(400);
    echo json_encode(["error" => "El contenido del archivo no coincide con su formato"]);
    exit;
}

$carpeta = __DIR__ . "/uploads/certificados/";

if (!is_dir($carpeta) && !mkdir($carpeta, 0775, true)) {
    http_response_code(500);
    echo json_encode(["error" => "No se pudo crear la carpeta de certificados"]);
    exit;
}

$nombreArchivo = uniqid("certificado_", true) . "." . $extension;
$rutaFisica = $carpeta . $nombreArchivo;
$rutaBD = "uploads/certificados/" . $nombreArchivo;

if (!move_uploaded_file($archivo["tmp_name"], $rutaFisica)) {
    http_response_code(500);
    echo json_encode(["error" => "No se pudo guardar el certificado"]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO certificados_medicos (legajo, archivo_url)
     VALUES (?, ?)"
);

$stmt->bind_param("is", $legajo, $rutaBD);

if (!$stmt->execute()) {
    if (file_exists($rutaFisica)) {
        unlink($rutaFisica);
    }

    http_response_code(500);
    echo json_encode(["error" => "No se pudo registrar el certificado"]);
    exit;
}

echo json_encode([
    "mensaje" => "Certificado subido correctamente",
    "id" => $stmt->insert_id,
    "archivo_url" => $rutaBD
]);

$stmt->close();
$conn->close();
?>