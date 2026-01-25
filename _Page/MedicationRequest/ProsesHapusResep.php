<?php
    // koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Zona Waktu
    date_default_timezone_set("Asia/Jakarta");

    // Response default
    $response = [
        'status'  => 'error',
        'message' => 'Terjadi kesalahan sistem'
    ];

    // Validasi Session Login
    if (empty($SessionIdAccess)) {
        $response['message'] = 'Sesi akses telah berakhir. Silakan login ulang.';
        echo json_encode($response);
        exit;
    }

    // VALIDASI INPUT
    $id_medication_request_group = validateAndSanitizeInput($_POST['id_medication_request_group'] ?? '');

    if (empty($id_medication_request_group)) {
        $response['message'] = 'ID Resep tidak valid.';
        echo json_encode($response);
        exit;
    }

   // CEK DATA ADA ATAU TIDAK
    $QryCheck = $Conn->prepare("SELECT id_medication_request_group FROM medication_request_group WHERE id_medication_request_group = ?");
    if (!$QryCheck) {
        $response['message'] = $Conn->error;
        echo json_encode($response);
        exit;
    }

    $QryCheck->bind_param("i", $id_medication_request_group);
    $QryCheck->execute();
    $Result = $QryCheck->get_result();
    $Data   = $Result->fetch_assoc();
    $QryCheck->close();

    if (!$Data) {
        $response['message'] = 'Data Resep tidak ditemukan.';
        echo json_encode($response);
        exit;
    }

    // =======================
    // PROSES DELETE
    // =======================
    $Conn->begin_transaction();

    try {

        $QryDelete = $Conn->prepare("DELETE FROM medication_request_group WHERE id_medication_request_group = ?");
        if (!$QryDelete) {
            throw new Exception($Conn->error);
        }

        $QryDelete->bind_param("i", $id_medication_request_group);

        if (!$QryDelete->execute()) {
            throw new Exception('Gagal menghapus data resep.');
        }

        $QryDelete->close();
        $Conn->commit();

        $response['status']  = 'success';
        $response['message'] = 'Resep berhasil dihapus.';

    } catch (Exception $e) {
        $Conn->rollback();
        $response['message'] = $e->getMessage();
    }

   // OUTPUT JSON
    echo json_encode($response);
?>
