<?php
    // KONEKSI, SESSION, GLOBAL FUNCTION
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    date_default_timezone_set("Asia/Jakarta");

    // RESPONSE HEADER
    header('Content-Type: application/json');

    // VALIDASI SESSION
    if (empty($SessionIdAccess)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Sesi akses telah berakhir. Silakan login ulang.'
        ]);
        exit;
    }

    // DATA WAJIB
    if(empty($_POST['kode_medication_request'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Kode Resep Tidak Boleh Kosong.'
        ]);
        exit;
    }

    if(empty($_POST['payload_medication_request'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Payload Resep Tidak Boleh Kosong.'
        ]);
        exit;
    }

    $kode_medication_request    = $_POST['kode_medication_request'];
    $payload_medication_request = $_POST['payload_medication_request'];

    // MEMBUAT TOKEN SATU SEHAT
    $tokenResult = generateTokenSatuSehat($Conn);

    if ($tokenResult['status'] !== 'success') {
        echo json_encode([
            'status'  => 'error',
            'message' => $tokenResult['message']
        ]);
        exit;
    }

    $token = $tokenResult['token'];

    // AMBIL KONFIGURASI SATUSEHAT AKTIF
    $status_active = 1;
    $stmt = $Conn->prepare("SELECT url_connection_satu_sehat, organization_id FROM connection_satu_sehat WHERE status_connection_satu_sehat = ?");
    $stmt->bind_param("i", $status_active);
    $stmt->execute();
    $result = $stmt->get_result();
    $config = $result->fetch_assoc();
    $stmt->close();

    if (!$config) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Koneksi SATUSEHAT tidak ditemukan.'
        ]);
        exit;
    }

    $organization_id = $config['organization_id'];

    // BUAT URL
    $url_api    = rtrim($config['url_connection_satu_sehat'], '/');
    $url_medReq = $url_api . '/fhir-r4/v1/MedicationRequest';

    // KIRIM KE SATUSEHAT
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url_medReq,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $payload_medication_request,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
            'Accept: application/json'
        ],
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ]);

    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($curl);
    curl_close($curl);

   // HANDLE ERROR CURL
    if ($curl_error) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'cURL Error: ' . $curl_error
        ]);
        exit;
    }

   // DECODE RESPONSE
    $result = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Response bukan JSON valid.',
            'response_raw' => substr($response, 0, 300)
        ]);
        exit;
    }

    // VALIDASI RESPONSE SATUSEHAT
    if ($http_code !== 201) {
        $msg = 'Gagal mengirim Medication ke SATUSEHAT';

        if (($result['resourceType'] ?? '') === 'OperationOutcome') {
            $msg = $result['issue'][0]['details']['text']
                ?? $result['issue'][0]['diagnostics']
                ?? $msg;
        }

        echo json_encode([
            'status'    => 'error',
            'payload'   => $payload_medication_request,
            'message'   => $msg,
            'http_code' => $http_code
        ]);
        exit;
    }

    // SIMPAN ID MEDICATION KE DATABASE
    $id_medication_request = $result['id'] ?? null;

    $UpdateMedicationRequest = mysqli_query($Conn,"UPDATE medication_request SET 
        id_medication_request='$id_medication_request'
    WHERE kode_medication_request='$kode_medication_request'") or die(mysqli_error($Conn)); 
    if($UpdateMedicationRequest){
        echo json_encode([
            'status'                => 'success',
            'id_medication_request' => $id_medication_request,
            'message'               => 'Medication Request Berhasil Dibuat'
        ]);
        exit;
    }else{
        echo json_encode([
            'status'    => 'error',
            'payload'   => $payload_medication_request,
            'message'   => 'Terjadi kesalahan pada saat update data'
        ]);
        exit;
    }

?>