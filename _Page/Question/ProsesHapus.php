<?php
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    date_default_timezone_set("Asia/Jakarta");
    header('Content-Type: application/json');

    // Validasi Session
    if (empty($SessionIdAccess)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Sesi akses telah berakhir. Silakan login ulang.'
        ]);
        exit;
    }

    // Validasi Input
    if (empty($_POST['id_referensi_questionnaire'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID Pertanyaan Tidak Boleh Kosong.'
        ]);
        exit;
    }

    // Sanitasi
    $id_referensi_questionnaire = validateAndSanitizeInput($_POST['id_referensi_questionnaire']);

    // Ambil ID Questionnaire SATUSEHAT
    $id_questionnaire = GetDetailData(
        $Conn,
        'referensi_questionnaire',
        'id_referensi_questionnaire',
        $id_referensi_questionnaire,
        'id_questionnaire'
    );

    // Jika terdaftar di SATU SEHAT → Retire
    if (!empty($id_questionnaire)) {

        // Generate Token
        $tokenResult = generateTokenSatuSehat($Conn);
        if ($tokenResult['status'] !== 'success') {
            echo json_encode([
                'status' => 'error',
                'message' => $tokenResult['message']
            ]);
            exit;
        }

        $token = $tokenResult['token'];

        // Ambil URL SATUSEHAT
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
                'status' => 'error',
                'message' => 'Koneksi SATU SEHAT tidak ditemukan.'
            ]);
            exit;
        }

        // Payload retire
        $payload = [
            "resourceType" => "Questionnaire",
            "id" => $id_questionnaire,
            "status" => "retired"
        ];

        $payload_json = json_encode($payload, JSON_UNESCAPED_UNICODE);

        $url = rtrim($config['url_connection_satu_sehat'], '/') 
            . "/fhir-r4/v1/Questionnaire/$id_questionnaire";

        // CURL PUT
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => $payload_json,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer $token",
                "Content-Type: application/fhir+json",
                "Accept: application/fhir+json"
            ],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ]);

        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_err = curl_error($curl);
        curl_close($curl);

        if ($curl_err) {
            echo json_encode([
                'status' => 'error',
                'message' => "CURL Error: $curl_err"
            ]);
            exit;
        }

        $result = json_decode($response, true);

        if (!in_array($http_code, [200, 201])) {
            $msg = $result['issue'][0]['details']['text']
                ?? $result['issue'][0]['diagnostics']
                ?? 'Gagal retire Questionnaire di SATU SEHAT';

            echo json_encode([
                'status' => 'error',
                'message' => $msg,
                'http_code' => $http_code
            ]);
            exit;
        }
    }

    // Hapus S(oft Delete)
    $status = "retired";
    $sql = "UPDATE referensi_questionnaire SET status = ? WHERE id_referensi_questionnaire = ?";
    $stmt = $Conn->prepare($sql);
    if (!$stmt) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal menyiapkan query.'
        ]);
        exit;
    }
    $stmt->bind_param(
        "si",
        $status,
        $id_referensi_questionnaire
    );

    if (!$stmt->execute()) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Gagal memperbaharui Status'
        ]);
        exit;
    }
    $stmt->close();

    // Jika Berhasil
    echo json_encode([
        'status'  => 'success',
        'message' => 'Referensi Pertanyaan Berhasil Dihapus'
    ]);
    exit;

?>