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

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Método no permitido"
    ]);
    exit;
}

$legajo = intval($_POST["legajo"] ?? 0);

if ($legajo <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "No se recibió un legajo válido"
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| VERIFICAR QUE EL LEGAJO EXISTA
|--------------------------------------------------------------------------
*/

$sqlEmpleado = "SELECT legajo FROM empleados WHERE legajo = ?";

$stmtEmpleado = $conexion->prepare($sqlEmpleado);

if (!$stmtEmpleado) {
    echo json_encode([
        "success" => false,
        "message" => "Error al preparar la consulta del empleado: " . $conexion->error
    ]);
    exit;
}

$stmtEmpleado->bind_param("i", $legajo);
$stmtEmpleado->execute();

$resultado = $stmtEmpleado->get_result();

if ($resultado->num_rows === 0) {

    $stmtEmpleado->close();
    $conexion->close();

    echo json_encode([
        "success" => false,
        "message" => "El legajo no existe en la tabla empleados"
    ]);

    exit;
}

$stmtEmpleado->close();

/*
|--------------------------------------------------------------------------
| VERIFICAR ARCHIVO
|--------------------------------------------------------------------------
*/

if (!isset($_FILES["archivo"])) {

    $conexion->close();

    echo json_encode([
        "success" => false,
        "message" => "No se recibió ningún archivo"
    ]);

    exit;
}

$archivo = $_FILES["archivo"];

if ($archivo["error"] !== UPLOAD_ERR_OK) {

    $conexion->close();

    echo json_encode([
        "success" => false,
        "message" => "Error al recibir el archivo. Código: " . $archivo["error"]
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| TAMAÑO
|--------------------------------------------------------------------------
*/

$maximo = 5 * 1024 * 1024;

if ($archivo["size"] > $maximo) {

    $conexion->close();

    echo json_encode([
        "success" => false,
        "message" => "El archivo no puede superar los 5 MB"
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| TIPO DE ARCHIVO
|--------------------------------------------------------------------------
*/

$tiposPermitidos = [
    "application/pdf" => "pdf",
    "image/jpeg" => "jpg",
    "image/png" => "png"
];

$tipo = $archivo["type"];

if (!isset($tiposPermitidos[$tipo])) {

    $conexion->close();

    echo json_encode([
        "success" => false,
        "message" => "Solo se permiten archivos PDF, JPG, JPEG o PNG"
    ]);

    exit;
}

$extension = $tiposPermitidos[$tipo];

/*
|--------------------------------------------------------------------------
| CARPETA DE CERTIFICADOS
|--------------------------------------------------------------------------
*/

$carpeta = __DIR__ . "/certificados/";

if (!is_dir($carpeta)) {

    if (!mkdir($carpeta, 0777, true)) {

        $conexion->close();

        echo json_encode([
            "success" => false,
            "message" => "No se pudo crear la carpeta certificados"
        ]);

        exit;
    }
}

/*
|--------------------------------------------------------------------------
| NOMBRE DEL ARCHIVO
|--------------------------------------------------------------------------
*/

$nombreArchivo = "certificado_" . $legajo . "_" . time() . "." . $extension;

$rutaCompleta = $carpeta . $nombreArchivo;

/*
|--------------------------------------------------------------------------
| GUARDAR ARCHIVO FÍSICAMENTE
|--------------------------------------------------------------------------
*/

if (!move_uploaded_file($archivo["tmp_name"], $rutaCompleta)) {

    $conexion->close();

    echo json_encode([
        "success" => false,
        "message" => "No se pudo guardar físicamente el archivo"
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| RUTA PARA LA BASE DE DATOS
|--------------------------------------------------------------------------
*/

$archivoUrl = "certificados/" . $nombreArchivo;

/*
|--------------------------------------------------------------------------
| GUARDAR EN certificados_medicos
|--------------------------------------------------------------------------
*/

$sql = "INSERT INTO certificados_medicos
        (legajo, archivo_url, fecha_subida)
        VALUES (?, ?, NOW())";

$stmt = $conexion->prepare($sql);

if (!$stmt) {

    if (file_exists($rutaCompleta)) {
        unlink($rutaCompleta);
    }

    $conexion->close();

    echo json_encode([
        "success" => false,
        "message" => "Error al preparar el guardado en la base de datos: " . $conexion->error
    ]);

    exit;
}

$stmt->bind_param(
    "is",
    $legajo,
    $archivoUrl
);

/*
|--------------------------------------------------------------------------
| EJECUTAR
|--------------------------------------------------------------------------
*/

if ($stmt->execute()) {

    echo json_encode([
        "success" => true,
        "message" => "Certificado subido correctamente",
        "legajo" => $legajo,
        "archivo" => $archivoUrl
    ]);

} else {

    if (file_exists($rutaCompleta)) {
        unlink($rutaCompleta);
    }

    echo json_encode([
        "success" => false,
        "message" => "No se pudo guardar el certificado en la base de datos: " . $stmt->error
    ]);
}

$stmt->close();
$conexion->close();

?>