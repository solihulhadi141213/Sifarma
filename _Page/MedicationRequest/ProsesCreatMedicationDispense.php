<?php
    // KONEKSI, SESSION, GLOBAL FUNCTION
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    date_default_timezone_set("Asia/Jakarta");

    // RESPONSE HEADER
    header('Content-Type: application/json');

    // Membuat datetime_iso
    $dt           = new DateTime($now, new DateTimeZone('Asia/Jakarta'));
    $datetime_iso = $dt->format('Y-m-d\TH:i:sP');

    // VALIDASI SESSION
    if (empty($SessionIdAccess)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Sesi akses telah berakhir. Silakan login ulang.'
        ]);
        exit;
    }

    // DATA WAJIB
    if(empty($_POST['id_medication_request_group'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'ID Lembar Resep (Medication Request Group) Tidak Boleh Kosong.'
        ]);
        exit;
    }
    if(empty($_POST['kode_medication_request'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Kode Peresepan Tidak Boleh Kosong.'
        ]);
        exit;
    }
    if(empty($_POST['name_medication'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Nama Obat Tidak Boleh Kosong.'
        ]);
        exit;
    }
    if(empty($_POST['apoteker_nama'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Nama Apoteker Tidak Boleh Kosong.'
        ]);
        exit;
    }
    if(empty($_POST['quantity_value'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Jumlah Obat / Alkes Yang Diserahkan Tidak Boleh Kosong.'
        ]);
        exit;
    }
    if(empty($_POST['status'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Status Penyerahan Obat Tidak Boleh Kosong.'
        ]);
        exit;
    }

    if(empty($_POST['nama_pasien'])){
        echo json_encode([
            'status'  => 'error',
            'message' => 'Nama Pasien Tidak Boleh Kosong.'
        ]);
        exit;
    }

    // Buat Variabel dan sanitasi
    $id_medication_request_group = validateAndSanitizeInput($_POST['id_medication_request_group']);
    $kode_medication_request     = validateAndSanitizeInput($_POST['kode_medication_request']);
    $name_medication             = validateAndSanitizeInput($_POST['name_medication']);
    $apoteker_nama               = validateAndSanitizeInput($_POST['apoteker_nama']);
    $quantity_value              = validateAndSanitizeInput($_POST['quantity_value']);
    $status                      = validateAndSanitizeInput($_POST['status']);
    $nama_pasien                 = validateAndSanitizeInput($_POST['nama_pasien']);

    // Tangkap Data Yang Tidak Wajib
    if(empty($_POST['id_ihs'])){
        $id_ihs = "";
    }else{
        $id_ihs = validateAndSanitizeInput($_POST['id_ihs']);
    }
    if(empty($_POST['id_encounter'])){
        $id_encounter = "";
    }else{
        $id_encounter = validateAndSanitizeInput($_POST['id_encounter']);
    }
    if(empty($_POST['id_medication_request'])){
        $id_medication_request = "";
    }else{
        $id_medication_request = validateAndSanitizeInput($_POST['id_medication_request']);
    }
    if(empty($_POST['id_medication'])){
        $id_medication = "";
    }else{
        $id_medication = validateAndSanitizeInput($_POST['id_medication']);
    }
    if(empty($_POST['apoteker_id_ihs'])){
        $apoteker_id_ihs = "";
    }else{
        $apoteker_id_ihs = validateAndSanitizeInput($_POST['apoteker_id_ihs']);
    }
    if(empty($_POST['quantity_unit'])){
        $quantity_unit = "";
    }else{
        $quantity_unit = validateAndSanitizeInput($_POST['quantity_unit']);
    }
    if(empty($_POST['quantity_code'])){
        $quantity_code = "";
    }else{
        $quantity_code = validateAndSanitizeInput($_POST['quantity_code']);
    }
    if(empty($_POST['quantity_system'])){
        $quantity_system = "";
    }else{
        $quantity_system = validateAndSanitizeInput($_POST['quantity_system']);
    }
    if(empty($_POST['generate_id_medication_dispense'])){
        $generate_id_medication_dispense = "";
    }else{
        $generate_id_medication_dispense = validateAndSanitizeInput($_POST['generate_id_medication_dispense']);
    }

    // Generate kode_medication_dispense
    $kode_medication_dispense = generateUUIDv4();

    // Inisialisasi ID Medication Dispense
    $id_medication_dispense = "";
    // Jika Dikonfirmasi Bahwa Perlu Pengiriman Medication Dispense
    if(!empty($generate_id_medication_dispense)){

        // Validasi Persyaratan Pengiriman Resource
        if(empty($id_medication_request)){
             echo json_encode(['status'  => 'error','message' => 'Jika Anda Ingin Mengirim Data Ini Ke Satu Sehat Maka ID Medication Request Tidak Boleh Kosong!']);
            exit;
        }
        if(empty($id_medication)){
             echo json_encode(['status'  => 'error','message' => 'Jika Anda Ingin Mengirim Data Ini Ke Satu Sehat Maka ID Medication Tidak Boleh Kosong!']);
            exit;
        }
        if(empty($apoteker_id_ihs)){
            echo json_encode(['status'  => 'error','message' => 'Jika Anda Ingin Mengirim Data Ini Ke Satu Sehat Maka ID IHS Apoteker Tidak Boleh Kosong!']);
            exit;
        }
        if(empty($id_encounter)){
            echo json_encode(['status'  => 'error','message' => 'Jika Anda Ingin Mengirim Data Ini Ke Satu Sehat Maka ID Encounter Tidak Boleh Kosong!']);
            exit;
        }
        if(empty($id_ihs)){
            echo json_encode(['status'  => 'error','message' => 'Jika Anda Ingin Mengirim Data Ini Ke Satu Sehat Maka ID IHS Pasien Tidak Boleh Kosong!']);
            exit;
        }
        // Jika Memenuhi Syarat Buat Token Satu Sehat
        $tokenResult = generateTokenSatuSehat($Conn);

        if ($tokenResult['status'] !== 'success') {
            echo json_encode([
                'status'  => 'error',
                'message' => $tokenResult['message']
            ]);
            exit;
        }

        $token = $tokenResult['token'];

        // Buka Pengaturan Satu Sehat
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

        // Buat URL
        $url_api    = rtrim($config['url_connection_satu_sehat'], '/');
        $url_MedDis = $url_api . '/fhir-r4/v1/MedicationDispense';

        // Buat Payload
        $payload_medication_dispense = [
            "resourceType" => "MedicationDispense",
            "identifier" => [[
                "system" => "http://sys-ids.kemkes.go.id/prescription/$organization_id",
                "use" => "official",
                "value" => "$kode_medication_dispense",
            ]],
            "meta" => [
                "profile" => [
                    "https://fhir.kemkes.go.id/r4/StructureDefinition/MedicationDispense"
                ]
            ],
            "status" => $status,
            "medicationReference" => [
                "reference" => "Medication/$id_medication"
            ],
            "subject" => [
                "reference" => "Patient/$id_ihs"
            ],
            "context" => [
                "reference" => "Encounter/$id_encounter"
            ],
            "authorizingPrescription" =>[[
                "reference" => "MedicationRequest/$id_medication_request"
            ]],
            "quantity" => [
                "value" => (float)$quantity_value,
                "unit" => $quantity_unit,
                "code" => $quantity_code,
                "system" => $quantity_system
            ],
            "whenHandedOver" => $datetime_iso,
            "performer" => [[
                "actor" => [
                    "reference" => "Practitioner/$apoteker_id_ihs"
                ]
            ]]
        ];

        // Encode Payload
        $payload_medication_dispense = json_encode($payload_medication_dispense, true);

        // Mulai CURL
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url_MedDis,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $payload_medication_dispense,
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
                'message' => 'CURL Error: ' . $curl_error
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
                'payload'   => $payload_medication_dispense,
                'message'   => $msg,
                'http_code' => $http_code
            ]);
            exit;
        }

        // SIMPAN ID MEDICATION KE DATABASE
        $id_medication_dispense = $result['id'] ?? null;
    }

    // Simpan Data Ke Database
    try {
        $query = "INSERT INTO  medication_dispense (
            kode_medication_dispense,
            id_medication_dispense,
            kode_medication_request,
            id_medication_request_group,
            apoteker_id_ihs,
            apoteker_nama,
            quantity_value,
            quantity_unit,
            quantity_code,
            quantity_system,
            status
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";
        
        $stmt = $Conn->prepare($query);
        
        // Bind parameters
        $stmt->bind_param(
            "sssssssssss",
            $kode_medication_dispense,
            $id_medication_dispense,
            $kode_medication_request,
            $id_medication_request_group,
            $apoteker_id_ihs,
            $apoteker_nama,
            $quantity_value,
            $quantity_unit,
            $quantity_code,
            $quantity_system,
            $status
        );
        
        if($stmt->execute()){
            echo json_encode([
                'status' => 'success',
                'message' => 'Penyerahan Obat / Alkes Berhasil Disimpan!',
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $stmt->error
            ]);
        }
        
        $stmt->close();
        
    } catch(Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }
?>