<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

require_once "conexion.php";

try {

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    if (!is_array($data)) {
        echo json_encode([
            "ok" => false,
            "mensaje" => "Los datos recibidos no son válidos."
        ]);
        exit;
    }

    $puesto_id = intval(
        $data["puesto_id"] ?? 0
    );

    $epp_ids = $data["epp_ids"] ?? [];

    if ($puesto_id <= 0) {
        echo json_encode([
            "ok" => false,
            "mensaje" => "El puesto seleccionado no es válido."
        ]);
        exit;
    }

    if (!is_array($epp_ids)) {
        echo json_encode([
            "ok" => false,
            "mensaje" => "Los EPP seleccionados no son válidos."
        ]);
        exit;
    }

    $puestoExiste = $conn->prepare(
        "SELECT id FROM puestos WHERE id = ?"
    );

    $puestoExiste->bind_param(
        "i",
        $puesto_id
    );

    $puestoExiste->execute();

    $resultadoPuesto = $puestoExiste->get_result();

    if ($resultadoPuesto->num_rows === 0) {

        $puestoExiste->close();

        echo json_encode([
            "ok" => false,
            "mensaje" => "El puesto seleccionado no existe."
        ]);

        exit;
    }

    $puestoExiste->close();

    $conn->begin_transaction();

    $stmtEliminar = $conn->prepare(
        "DELETE FROM puesto_epp
         WHERE puesto_id = ?"
    );

    $stmtEliminar->bind_param(
        "i",
        $puesto_id
    );

    $stmtEliminar->execute();

    $stmtEliminar->close();

    $cantidadGuardada = 0;

    if (count($epp_ids) > 0) {

        $stmtInsertar = $conn->prepare(
            "INSERT INTO puesto_epp
            (puesto_id, epp_id)
            VALUES (?, ?)"
        );

        foreach ($epp_ids as $epp_id) {

            $epp_id = intval($epp_id);

            if ($epp_id <= 0) {
                continue;
            }

            $eppExiste = $conn->prepare(
                "SELECT id FROM epp WHERE id = ?"
            );

            $eppExiste->bind_param(
                "i",
                $epp_id
            );

            $eppExiste->execute();

            $resultadoEpp = $eppExiste->get_result();

            $existe = $resultadoEpp->num_rows > 0;

            $eppExiste->close();

            if (!$existe) {
                continue;
            }

            $stmtInsertar->bind_param(
                "ii",
                $puesto_id,
                $epp_id
            );

            $stmtInsertar->execute();

            $cantidadGuardada++;
        }

        $stmtInsertar->close();
    }

    $conn->commit();

    echo json_encode([
        "ok" => true,
        "mensaje" => "EPP del puesto actualizado correctamente.",
        "puesto_id" => $puesto_id,
        "cantidad" => $cantidadGuardada
    ]);

} catch (Throwable $e) {

    if ($conn->connect_errno === 0) {
        try {
            $conn->rollback();
        } catch (Throwable $errorRollback) {
        }
    }

    echo json_encode([
        "ok" => false,
        "mensaje" => "No se pudieron guardar los EPP del puesto.",
        "error" => $e->getMessage()
    ]);
}

$conn->close();

?>