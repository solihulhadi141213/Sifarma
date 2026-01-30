<?php
    // ======================================================
    // KONEKSI, SESSION, GLOBAL FUNCTION
    // ======================================================
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    date_default_timezone_set("Asia/Jakarta");
    header('Content-Type: application/json');

    // ======================================================
    // VALIDASI SESSION
    // ======================================================
    if (empty($SessionIdAccess)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Sesi akses telah berakhir. Silakan login ulang.'
        ]);
        exit;
    }

    // ======================================================
    // VALIDASI INPUT WAJIB
    // ======================================================
    $requiredFields = [
        'id_referensi_questionnaire' => 'ID Pertanyaan Tidak Boleh Kosong.',
        'payload'                    => 'Payload Tidak Boleh Kosong.',
    ];

    foreach ($requiredFields as $field => $message) {
        if (empty($_POST[$field])) {
            echo json_encode([
                'status'  => 'error',
                'message' => $message
            ]);
            exit;
        }
    }

    // ======================================================
    // SANITASI INPUT
    // ======================================================
    $id_referensi_questionnaire = validateAndSanitizeInput($_POST['id_referensi_questionnaire']);
    $payload_json                    = $_POST['payload'];


    // ======================================================
    // KIRIM KE SATU SEHAT 
    // ======================================================

    // Generate Token SATUSEHAT
    $tokenResult = generateTokenSatuSehat($Conn);
    if ($tokenResult['status'] !== 'success') {
        echo json_encode([
            'status'  => 'error',
            'message' => $tokenResult['message']
        ]);
        exit;
    }

    $token = $tokenResult['token'];

    // Ambil konfigurasi koneksi aktif
    $stmt = $Conn->prepare("
        SELECT url_connection_satu_sehat
        FROM connection_satu_sehat
        WHERE status_connection_satu_sehat = 1
        LIMIT 1
    ");
    $stmt->execute();
    $config = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$config) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Koneksi SATU SEHAT tidak ditemukan.'
        ]);
        exit;
    }

    $url_questionnaire = rtrim($config['url_connection_satu_sehat'], '/') . '/fhir-r4/v1/Questionnaire';

    // Kirim ke SATU SEHAT
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url_questionnaire,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload_json,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
            'Accept: application/json'
        ],
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);

    $response  = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curl_err  = curl_error($curl);
    curl_close($curl);

    if ($curl_err) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'cURL Error: ' . $curl_err
        ]);
        exit;
    }

    $result = json_decode($response, true);

    if ($http_code !== 201) {
        $msg = $result['issue'][0]['details']['text']
            ?? $result['issue'][0]['diagnostics']
            ?? 'Gagal mengirim ke SATUSEHAT';

        echo json_encode([
            'status'  => 'error',
            'message' => $msg,
            'http'    => $http_code
        ]);
        exit;
    }

    $id_questionnaire = $result['id'] ?? null;

    // ======================================================
    // SIMPAN KE DATABASE
    // ======================================================
    $stmt = $Conn->prepare("UPDATE referensi_questionnaire SET id_questionnaire = ? WHERE id_referensi_questionnaire = ?");

    $stmt->bind_param(
        "si",
        $id_questionnaire,
        $id_referensi_questionnaire
    );

    if (!$stmt->execute()) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Execute failed: ' . $stmt->error
        ]);
        exit;
    }

    $stmt->close();

    // RESPONSE SUKSES
    echo json_encode([
        'status'  => 'success',
        'message' => 'Referensi ID Questionnaire Satu Sehat Berhasil Diperbaharui'
    ]);
    exit;
?>