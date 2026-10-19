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

$legajoTexto = trim($_POST["legajo"] ?? "");
$titulo = trim($_POST["titulo"] ?? "");
$texto = trim($_POST["texto"] ?? "");

if ($titulo === "" || !isset($_FILES["archivo"])) {
    http_response_code(400);
    echo json_encode(["error" => "El título y el archivo son obligatorios"]);
    exit;
}

$legajo = null;

if ($legajoTexto !== "") {
    $legajo = filter_var($legajoTexto, FILTER_VALIDATE_INT);

    if ($legajo === false || $legajo < 1) {
        http_response_code(400);
        echo json_encode(["error" => "Legajo inválido"]);
        exit;
    }
}

$archivo = $_FILES["archivo"];

if ($archivo["error"] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(["error" => "No se pudo recibir el archivo"]);
    exit;
}

if ($archivo["size"] > 40 * 1024 * 1024) {
    http_response_code(400);
    echo json_encode(["error" => "El archivo no puede superar los 20 MB"]);
    exit;
}

$extension = strtolower(pathinfo($archivo["name"], PATHINFO_EXTENSION));

if ($extension !== "pdf") {
    http_response_code(400);
    echo json_encode(["error" => "El documento de ART debe ser un PDF"]);
    exit;
}

$carpeta = __DIR__ . "/uploads/art/";

if (!is_dir($carpeta) && !mkdir($carpeta, 0775, true)) {
    http_response_code(500);
    echo json_encode(["error" => "No se pudo crear la carpeta de ART"]);
    exit;
}

$nombreArchivo = uniqid("art_", true) . ".pdf";
$rutaFisica = $carpeta . $nombreArchivo;
$rutaBD = "uploads/art/" . $nombreArchivo;

if (!move_uploaded_file($archivo["tmp_name"], $rutaFisica)) {
    http_response_code(500);
    echo json_encode(["error" => "No se pudo guardar el archivo"]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO art (legajo, titulo, texto, archivo_pdf_url)
     VALUES (?, ?, ?, ?)"
);

$stmt->bind_param("isss", $legajo, $titulo, $texto, $rutaBD);

if (!$stmt->execute()) {
    if (file_exists($rutaFisica)) {
        unlink($rutaFisica);
    }

    http_response_code(500);
    echo json_encode(["error" => "No se pudo registrar el documento de ART"]);
    exit;
}

echo json_encode([
    "mensaje" => "Documento de ART guardado correctamente",
    "id" => $stmt->insert_id,
    "archivo_pdf_url" => $rutaBD
]);

$stmt->close();
$conn->close();
?>