
<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Content-Type: text/plain; charset=UTF-8");

ini_set("display_errors", "1");
error_reporting(E_ALL);

try {
    require_once "conexion.php";

    echo "1. CONEXION A LA BASE DE DATOS: OK\n\n";

    $resultado = $conn->query("SHOW COLUMNS FROM art");

    echo "2. TABLA ART: EXISTE\n";
    echo "3. COLUMNAS ENCONTRADAS:\n\n";

    while ($columna = $resultado->fetch_assoc()) {
        echo $columna["Field"] . "\n";
    }

} catch (Throwable $e) {
    http_response_code(500);
    echo "\nERROR:\n";
    echo $e->getMessage();
}
?>
