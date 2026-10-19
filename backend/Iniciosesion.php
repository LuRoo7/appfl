<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

require_once "conexion.php";

$datos = json_decode(file_get_contents("php://input"), true);

if (!$datos) {
    echo json_encode([
        "status" => "error",
        "mensaje" => "No se recibieron datos"
    ]);
    exit;
}

$legajo = intval($datos["legajo"] ?? 0);
$contrasena = $datos["contrasena"] ?? "";

if ($legajo <= 0 || $contrasena === "") {
    echo json_encode([
        "status" => "error",
        "mensaje" => "Legajo o contraseña vacíos"
    ]);
    exit;
}

$consulta = $conn->prepare(
    "SELECT legajo, nombre, dni, contrasena, debe_cambiar
     FROM empleados
     WHERE legajo = ?"
);

if (!$consulta) {
    echo json_encode([
        "status" => "error",
        "mensaje" => "Error en la consulta: " . $conn->error
    ]);
    exit;
}

$consulta->bind_param("i", $legajo);
$consulta->execute();

$resultado = $consulta->get_result();

if ($resultado->num_rows === 0) {

    echo json_encode([
        "status" => "error",
        "mensaje" => "El legajo no existe en la base de datos",
        "legajo_recibido" => $legajo
    ]);

    exit;
}

$empleado = $resultado->fetch_assoc();

$contraseña_correcta = password_verify(
    $contrasena,
    $empleado["contrasena"]
);

if (!$contraseña_correcta) {

    echo json_encode([
        "status" => "error",
        "mensaje" => "El legajo existe, pero la contraseña no coincide"
    ]);

    exit;
}

echo json_encode([
    "status" => "success",
    "mensaje" => "Inicio de sesión correcto",
    "legajo" => $empleado["legajo"],
    "nombre" => $empleado["nombre"],
    "dni" => $empleado["dni"],
    "debe_cambiar" => $empleado["debe_cambiar"]
]);

$conn->close();

?>