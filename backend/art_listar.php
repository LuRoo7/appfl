
<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204);
    exit;
}

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
    exit;
}

$legajo = filter_input(INPUT_GET, "legajo", FILTER_VALIDATE_INT);

if (!$legajo || $legajo < 1) {
    http_response_code(400);
    echo json_encode(["error" => "El legajo es obligatorio y debe ser válido"]);
    exit;
}

$sql = "SELECT id, legajo, titulo, texto, archivo_pdf_url
        FROM art
        WHERE legajo = ?
        ORDER BY id DESC";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(["error" => "No se pudo preparar la consulta SQL"]);
    exit;
}

$stmt->bind_param("i", $legajo);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(["error" => "No se pudieron consultar los documentos ART"]);
    exit;
}

$resultado = $stmt->get_result();
$arts = [];

while ($fila = $resultado->fetch_assoc()) {
    $arts[] = $fila;
}

echo json_encode($arts, JSON_UNESCAPED_UNICODE);

$stmt->close();
$conn->close();
?>
