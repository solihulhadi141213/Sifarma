<?php
    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Zona Waktu
    date_default_timezone_set("Asia/Jakarta");

    // Inisialisasi Response
    $response = [
        'status'  => 'error',
        'message' => 'Terjadi kesalahan sistem'
    ];

    // Sessi Akses
    if (empty($SessionIdAccess)) {
        $response['message'] = 'Sesi berakhir';
        echo json_encode($response);
        exit;
    }

    // Validasi Data Mandatory
    if(empty($_POST['id_connection_simrs'])){
        $response['message'] = 'ID Koneksi Tidak Boleh Kosong!';
        echo json_encode($response);
        exit;
    }

    // Ambil input
    $id_connection_simrs = validateAndSanitizeInput($_POST['id_connection_simrs'] ?? '');
    $token               = "";

    // Transaction
    $Conn->begin_transaction();

    try {

        // Update Token
        $QryUpdate = $Conn->prepare("UPDATE connection_simrs SET token = ? WHERE id_connection_simrs = ?");
        if (!$QryUpdate) {
            throw new Exception($Conn->error);
        }

        $QryUpdate->bind_param(
            "si",
            $token,
            $id_connection_simrs
        );

        $QryUpdate->execute();
        $QryUpdate->close();

        $Conn->commit();

        $response['status']  = 'success';
        $response['message'] = 'Reset Token Koneksi SIMRS Berhasi;';

    } catch (Exception $e) {
        $Conn->rollback();
        $response['message'] = $e->getMessage();
    }

    echo json_encode($response);
?>
