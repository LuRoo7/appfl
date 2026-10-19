<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

include "conexion.php";

$datos = json_decode(file_get_contents("php://input"), true);

if (!$datos) {
    echo json_encode([
        "status" => "error",
        "mensaje" => "No se recibieron datos"
    ]);
    exit;
}

$legajo = intval($datos["legajo"] ?? 0);
$nombre = trim($datos["nombre"] ?? "");
$dni = trim($datos["dni"] ?? "");
$contrasena = $datos["contrasena"] ?? "";

if ($legajo <= 0 || $nombre === "" || $dni === "" || $contrasena === "") {
    echo json_encode([
        "status" => "error",
        "mensaje" => "Faltan datos"
    ]);
    exit;
}

$sqlExiste = "SELECT legajo FROM empleados WHERE legajo = ?";

$stmtExiste = $conexion->prepare($sqlExiste);

if (!$stmtExiste) {
    echo json_encode([
        "status" => "error",
        "mensaje" => "Error al verificar el legajo: " . $conexion->error
    ]);
    exit;
}

$stmtExiste->bind_param("i", $legajo);
$stmtExiste->execute();

$resultado = $stmtExiste->get_result();

if ($resultado->num_rows > 0) {
    echo json_encode([
        "status" => "error",
        "mensaje" => "El legajo ya está registrado"
    ]);

    $stmtExiste->close();
    $conexion->close();
    exit;
}

$stmtExiste->close();

$sqlDni = "SELECT dni FROM empleados WHERE dni = ?";

$stmtDni = $conexion->prepare($sqlDni);

if (!$stmtDni) {
    echo json_encode([
        "status" => "error",
        "mensaje" => "Error al verificar el DNI: " . $conexion->error
    ]);
    exit;
}

$stmtDni->bind_param("s", $dni);
$stmtDni->execute();

$resultadoDni = $stmtDni->get_result();

if ($resultadoDni->num_rows > 0) {
    echo json_encode([
        "status" => "error",
        "mensaje" => "El DNI ya está registrado"
    ]);

    $stmtDni->close();
    $conexion->close();
    exit;
}

$stmtDni->close();

$hash = password_hash($contrasena, PASSWORD_DEFAULT);

$sql = "INSERT INTO empleados (legajo, nombre, dni, contrasena)
        VALUES (?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "mensaje" => "Error al preparar la consulta: " . $conexion->error
    ]);
    exit;
}

$stmt->bind_param(
    "isss",
    $legajo,
    $nombre,
    $dni,
    $hash
);

if ($stmt->execute()) {

    echo json_encode([
        "status" => "success",
        "mensaje" => "Usuario registrado correctamente",
        "legajo" => $legajo
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "mensaje" => "No se pudo registrar el usuario: " . $stmt->error
    ]);
}

$stmt->close();
$conexion->close();

?>