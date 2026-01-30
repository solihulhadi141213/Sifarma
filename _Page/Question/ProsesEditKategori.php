<?php
    // Koneksi, Global Function, Session Dan Setting General
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    // Zona Waktu
    date_default_timezone_set("Asia/Jakarta");

    // Header JSON
    header('Content-Type: application/json');

    // Inisialisasi $pesan_kesalahan agar tidak error
    $pesan_kesalahan = [];

    // Validasi Session
    if (empty($SessionIdAccess)) {
        echo json_encode([
            'status'  => 'Error',
            'message' => 'Sesi akses telah berakhir. Silakan login ulang.',
            'pesan_kesalahan' => $pesan_kesalahan
        ]);
        exit;
    }

    // Validasi Input Wajib
    $requiredFields = [
        'question_group_lama' => 'Kategori Lama Tidak Boleh Kosong.',
        'question_group'      => 'Kategori baru Tidak Boleh Kosong.'
    ];

    foreach ($requiredFields as $field => $message) {
        if (empty($_POST[$field])) {
            echo json_encode([
                'status'  => 'Error',
                'message' => $message,
                'pesan_kesalahan' => $pesan_kesalahan
            ]);
            exit;
        }
    }

    // Sanitasi Input
    $question_group_lama = validateAndSanitizeInput($_POST['question_group_lama']);
    $question_group      = validateAndSanitizeInput($_POST['question_group']);

    // Update
    $sql = "UPDATE referensi_questionnaire SET question_group = ? WHERE question_group = ?";
    $stmt = $Conn->prepare($sql);
    if (!$stmt) {
        echo json_encode([
            'status'  => 'Error',
            'message' => 'Gagal menyiapkan query.',
            'pesan_kesalahan' => $pesan_kesalahan
        ]);
        exit;
    }
    $stmt->bind_param(
        "ss",
        $question_group,
        $question_group_lama
    );
    if (!$stmt->execute()) {
        echo json_encode([
            'status'  => 'Error',
            'message' => 'Gagal memperbaharui referensi satuan.',
            'pesan_kesalahan' => $pesan_kesalahan
        ]);
        exit;
    }
    $stmt->close();

    // Jika Berhasil Hitung Jumlah Data
    $jumlah_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_referensi_questionnaire FROM referensi_questionnaire WHERE question_group='$question_group' AND status='active'"));

    // Ambil konfigurasi koneksi aktif
    $stmt2 = $Conn->prepare("SELECT url_connection_satu_sehat FROM connection_satu_sehat WHERE status_connection_satu_sehat = 1 LIMIT 1");
    $stmt2->execute();
    $config = $stmt2->get_result()->fetch_assoc();
    $stmt2->close();

    if (!$config) {

        // Jika Koneksi Satu Sehat Tidak Ditemukan Maka Sukses Saja
        echo json_encode([
            'status'  => 'success',
            'message' => 'Referensi satuan Berhasil Diperbaharui',
            'pesan_kesalahan' => $pesan_kesalahan
        ]);
        exit;
    }
    $url_questionnaire = rtrim($config['url_connection_satu_sehat'], '/') . '/fhir-r4/v1/Questionnaire';

    // Generate Token SATUSEHAT
    $tokenResult = generateTokenSatuSehat($Conn);
    if ($tokenResult['status'] !== 'success') {
        echo json_encode([
            'status'  => 'Error',
            'message' => $tokenResult['message'],
            'pesan_kesalahan' => $pesan_kesalahan
        ]);
        exit;
    }
    $token = $tokenResult['token'];

    // Looping Data
    $jumlah_berhasil = 0;
    $query2 = mysqli_query($Conn, "SELECT*FROM referensi_questionnaire WHERE question_group='$question_group' AND status='active'");
    while ($data2 = mysqli_fetch_array($query2)) {
        if(!empty($data2['id_questionnaire'])){
            // Inisialisasi ID
            $id_questionnaire = $data2['id_questionnaire'];

            // CURL GET
            $curl_get = curl_init();
            curl_setopt_array($curl_get, [
                CURLOPT_URL => "$url_questionnaire/$id_questionnaire",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $token,
                    "Accept: application/fhir+json"
                ],
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ]);

            $existing_response = curl_exec($curl_get);
            curl_close($curl_get);

            $existing_data = json_decode($existing_response, true);

            // Validasi resource existing
            if (empty($existing_data['resourceType'])) {
                $pesan_kesalahan[] = [
                    "id_questionnaire" => $id_questionnaire,
                    "error" => "Gagal mengambil resource Questionnaire lama"
                ];
                continue;
            }

            // Update title saja
            $existing_data['title'] = $question_group;

            // Encode ulang full resource
            $payload_json = json_encode($existing_data, JSON_UNESCAPED_UNICODE);

            // Url
            $url_questionnaire_update = "$url_questionnaire/$id_questionnaire";

            // Mulai CURL
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url_questionnaire_update,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_POSTFIELDS => $payload_json,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $token,
                    "Content-Type: application/fhir+json",
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
                
            // ERROR CURL
                $pesan_kesalahan[] = [
                    "id_questionnaire" => $id_questionnaire,
                    "error"            => $curl_err,
                ];
                $jumlah_berhasil = $jumlah_berhasil+0;
            }else{
                $result = json_decode($response, true);
                if (!in_array($http_code, [200, 201])) {

                    // ERROR RESPONSE
                    $msg = $result['issue'][0]['details']['text']?? $result['issue'][0]['diagnostics']?? 'Gagal mengirim ke SATUSEHAT';
                    $pesan_kesalahan[] = [
                        "id_questionnaire" => $id_questionnaire,
                        "error"            => $msg,
                    ];
                    $jumlah_berhasil = $jumlah_berhasil+0;
                }else{
                    $jumlah_berhasil = $jumlah_berhasil+1;
                }
            }
        }else{
            $jumlah_berhasil = $jumlah_berhasil+1;
        }
    }

    // Jika Jumlah data sama dengan jumlah berhasil
    if($jumlah_data==$jumlah_berhasil){
        echo json_encode([
            'status'  => 'success',
            'message' => 'Referensi satuan Berhasil Diperbaharui',
            'pesan_kesalahan' => $pesan_kesalahan
        ]);
        exit;
    }else{
        echo json_encode([
            'status'  => 'Error',
            'message' => 'Terjadi kesalahan pada saat UPDATE Ke Satu Sehat',
            'pesan_kesalahan' => $pesan_kesalahan
        ]);
    }
?>
