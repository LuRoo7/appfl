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

if (
    !isset($datos["legajo"]) ||
    !isset($datos["contrasena"])
) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Faltan datos"
    ]);

    exit;
}

$legajo = intval($datos["legajo"]);
$contrasena = $datos["contrasena"];

$consulta = $conn->prepare(
    "SELECT legajo, nombre, dni, contrasena, debe_cambiar
     FROM empleados
     WHERE legajo = ?"
);

$consulta->bind_param("i", $legajo);
$consulta->execute();

$resultado = $consulta->get_result();

if ($resultado->num_rows === 0) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Legajo o contraseña incorrectos"
    ]);

    exit;
}

$empleado = $resultado->fetch_assoc();

if (!password_verify($contrasena, $empleado["contrasena"])) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Legajo o contraseña incorrectos"
    ]);

    exit;
}

echo json_encode([
    "ok" => true,
    "mensaje" => "Inicio de sesión correcto",
    "empleado" => [
        "legajo" => $empleado["legajo"],
        "nombre" => $empleado["nombre"],
        "dni" => $empleado["dni"],
        "debe_cambiar" => (bool)$empleado["debe_cambiar"]
    ]
]);

$conn->close();
?>