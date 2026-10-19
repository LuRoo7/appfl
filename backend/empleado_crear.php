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
    !isset($datos["nombre"]) ||
    !isset($datos["dni"]) ||
    !isset($datos["contrasena"])
) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Faltan datos"
    ]);
    exit;
}

$legajo = intval($datos["legajo"]);
$nombre = trim($datos["nombre"]);
$dni = trim($datos["dni"]);
$contrasena = $datos["contrasena"];

if ($legajo <= 0 || $nombre === "" || $dni === "" || $contrasena === "") {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Todos los campos son obligatorios"
    ]);
    exit;
}

$consulta = $conn->prepare(
    "SELECT legajo, dni FROM empleados WHERE legajo = ? OR dni = ?"
);

$consulta->bind_param("is", $legajo, $dni);
$consulta->execute();

$resultado = $consulta->get_result();

if ($resultado->num_rows > 0) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "El legajo o DNI ya está registrado"
    ]);

    exit;
}

$contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

$insertar = $conn->prepare(
    "INSERT INTO empleados
    (legajo, nombre, dni, contrasena, debe_cambiar)
    VALUES (?, ?, ?, ?, 1)"
);

$insertar->bind_param(
    "isss",
    $legajo,
    $nombre,
    $dni,
    $contrasenaHash
);

if ($insertar->execute()) {

    echo json_encode([
        "ok" => true,
        "mensaje" => "Empleado creado correctamente"
    ]);

} else {

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se pudo crear el empleado"
    ]);
}

$conn->close();
?>