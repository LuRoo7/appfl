<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

require_once "conexion.php";

$datos = json_decode(
    file_get_contents("php://input"),
    true
);


if (
    !isset($datos["legajo"]) ||
    !isset($datos["nueva_contrasena"])
) {

    echo json_encode([
        "status" => "error",
        "mensaje" => "Faltan datos"
    ]);

    exit;
}


$legajo = intval($datos["legajo"]);

$nuevaContrasena =
    $datos["nueva_contrasena"];


if (strlen($nuevaContrasena) < 6) {

    echo json_encode([
        "status" => "error",
        "mensaje" =>
            "La contraseña debe tener al menos 6 caracteres"
    ]);

    exit;
}


$nuevaContrasenaHash =
    password_hash(
        $nuevaContrasena,
        PASSWORD_DEFAULT
    );


$consulta = $conn->prepare(
    "UPDATE empleados
     SET contrasena = ?, debe_cambiar = 0
     WHERE legajo = ?"
);


$consulta->bind_param(
    "si",
    $nuevaContrasenaHash,
    $legajo
);


if ($consulta->execute()) {

    echo json_encode([
        "status" => "success",
        "mensaje" =>
            "Contraseña cambiada correctamente"
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "mensaje" =>
            "No se pudo cambiar la contraseña"
    ]);
}


$conn->close();

?>
