<?php
    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');

    // Validasi Session
    if (empty($SessionIdAccess)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Validasi Primary Key
    if (empty($_POST['id_encounter'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Encounter Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel dan Sanitasi
    $id_encounter = validateAndSanitizeInput($_POST['id_encounter']);

    // MEMBUAT TOKEN SATU SEHAT
    $tokenResult = generateTokenSatuSehat($Conn);
    if ($tokenResult['status'] !== 'success') {
        echo '
            <div class="alert alert-danger">
                <small>Terjadi Kesalahan Pada Saat Membuat Token SATUSEHAT!<br><pre>'.$tokenResult['message'].'</pre></small>
            </div>
        ';
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
        echo '
            <div class="alert alert-danger">
                <small>Koneksi SATUSEHAT tidak ditemukan.</small>
            </div>
        ';
        exit;
    }

    // Buka Encounter Dari Satusehat
    $url_api       = rtrim($config['url_connection_satu_sehat'], '/');
    $url_encounter = $url_api . '/fhir-r4/v1/Encounter/'.$id_encounter.'';

    // Mulai CURL
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url_encounter,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
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
        echo '
            <div class="alert alert-danger">
                <small>cURL Error: ' . $curl_error.'</small>
            </div>
        ';
        exit;
    }

   // DECODE RESPONSE
    $result = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo '
            <div class="alert alert-danger">
                <small>Response bukan JSON valid: '.substr($response, 0, 300).'</small>
            </div>
        ';
        exit;
    }

    // VALIDASI RESPONSE SATUSEHAT
    if ($http_code !== 200) {
        echo '
            <div class="alert alert-danger">
                <small>Terjadi Kesalahan Pada Response: <br> <pre>'.$response.'</pre></small>
            </div>
        ';
        exit;
    }

    // Membuat Variabel

    // Menampilkan Data
    echo '
        <div class="row mb-2">
            <div class="col-4"><small>ID Encounter</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$id_encounter.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Jenis Kunjungan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$result['class']['code'].' - '.$result['class']['display'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>System</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$result['class']['system'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>Nomor Kunjungan</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$result['identifier'][0]['value'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>System</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$result['identifier'][0]['system'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Dokter Penerima</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$result['participant'][0]['individual']['display'].'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Tanggal / Waktu</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-muted">'.$result['period']['start'].'</small></div>
        </div>
    ';
?>