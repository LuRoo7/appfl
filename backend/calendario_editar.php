<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "mensaje" => "Método no permitido"
    ]);
    exit;
}

$id = $_POST["id"] ?? "";
$fecha = $_POST["fecha"] ?? "";
$titulo = $_POST["titulo"] ?? "";
$descripcion = $_POST["descripcion"] ?? "";

if ($id === "" || $fecha === "" || $titulo === "") {
    echo json_encode([
        "success" => false,
        "mensaje" => "Faltan datos obligatorios"
    ]);
    exit;
}

$sql = "UPDATE calendario
        SET fecha = ?, titulo = ?, descripcion = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $fecha, $titulo, $descripcion, $id);

if (!$stmt->execute()) {
    echo json_encode([
        "success" => false,
        "mensaje" => "No se pudo actualizar el evento"
    ]);
    exit;
}

if (isset($_FILES["imagenes"]) && count($_FILES["imagenes"]["name"]) > 0) {

    $sqlBuscar = "SELECT imagen_url 
                  FROM calendario_imagenes 
                  WHERE calendario_id = ?";

    $stmtBuscar = $conn->prepare($sqlBuscar);
    $stmtBuscar->bind_param("i", $id);
    $stmtBuscar->execute();

    $resultado = $stmtBuscar->get_result();

    while ($imagen = $resultado->fetch_assoc()) {

        $archivo = __DIR__ . "/" . $imagen["imagen_url"];

        if (file_exists($archivo)) {
            unlink($archivo);
        }
    }

    $sqlEliminar = "DELETE FROM calendario_imagenes 
                    WHERE calendario_id = ?";

    $stmtEliminar = $conn->prepare($sqlEliminar);
    $stmtEliminar->bind_param("i", $id);
    $stmtEliminar->execute();

    $carpeta = __DIR__ . "/calendario/";

    foreach ($_FILES["imagenes"]["tmp_name"] as $indice => $tmp_name) {

        if ($_FILES["imagenes"]["error"][$indice] !== UPLOAD_ERR_OK) {
            continue;
        }

        $nombreOriginal = $_FILES["imagenes"]["name"][$indice];
        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

        $extensionesPermitidas = ["jpg", "jpeg", "png", "webp"];

        if (!in_array($extension, $extensionesPermitidas)) {
            continue;
        }

        $nombreArchivo = uniqid("calendario_") . "." . $extension;

        $rutaCompleta = $carpeta . $nombreArchivo;

        if (move_uploaded_file($tmp_name, $rutaCompleta)) {

            $rutaBD = "calendario/" . $nombreArchivo;

            $sqlImagen = "INSERT INTO calendario_imagenes
                          (calendario_id, imagen_url)
                          VALUES (?, ?)";

            $stmtImagen = $conn->prepare($sqlImagen);
            $stmtImagen->bind_param("is", $id, $rutaBD);
            $stmtImagen->execute();
        }
    }
}

echo json_encode([
    "success" => true,
    "mensaje" => "Evento actualizado correctamente"
]);

$conn->close();
?>