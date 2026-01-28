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
        'question_group' => 'Kategori Pertanyaan Tidak Boleh Kosong.',
        'question_text'  => 'Text Pertanyaan Tidak Boleh Kosong.',
        'question_type'  => 'Tipe Pertanyaan Tidak Boleh Kosong.'
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
    $question_group   = validateAndSanitizeInput($_POST['question_group']);
    $question_text    = validateAndSanitizeInput($_POST['question_text']);
    $question_type    = validateAndSanitizeInput($_POST['question_type']);

    $id_questionnaire = null;
    $link_id          = generateUUIDv4();
    $alternatif_json  = null;

    // ======================================================
    // FORM TIDAK WAJIB
    // ======================================================
    $kirim_ke_satu_sehat = !empty($_POST['kirim_ke_satu_sehat']) ? 1 : 0;

    // ======================================================
    // KHUSUS TIPE CHOICE
    // ======================================================
    $alternatif_array = [];

    if ($question_type === 'choice') {

        if (
            empty($_POST['alternatif_value']) ||
            empty($_POST['alternatif_display'])
        ) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Alternatif jawaban wajib diisi untuk tipe choice'
            ]);
            exit;
        }

        foreach ($_POST['alternatif_value'] as $i => $value) {

            $value   = trim($value);
            $display = trim($_POST['alternatif_display'][$i] ?? '');

            if ($value === '' || $display === '') {
                continue;
            }

            $alternatif_array[] = [
                'code'    => validateAndSanitizeInput($value),
                'display' => validateAndSanitizeInput($display)
            ];
        }

        if (count($alternatif_array) === 0) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Minimal satu alternatif jawaban harus diisi'
            ]);
            exit;
        }

        $alternatif_json = json_encode($alternatif_array, JSON_UNESCAPED_UNICODE);
    }

    // ======================================================
    // KIRIM KE SATU SEHAT (OPSIONAL)
    // ======================================================
    if ($kirim_ke_satu_sehat === 1) {

        // Bangun item Questionnaire
        $item = [
            "linkId"   => $link_id,
            "text"     => $question_text,
            "type"     => $question_type,
            "required" => true,
            "extension" => [
                [
                    "url" => "http://rs-elsyifa.co.id/fhir/StructureDefinition/question-group",
                    "valueString" => $question_group
                ]
            ]
        ];

        // answerOption hanya untuk choice
        if ($question_type === 'choice') {

            $answerOption = [];

            foreach ($alternatif_array as $alt) {
                $answerOption[] = [
                    'valueCoding' => [
                        'system'  => 'http://rs-elsyifa.co.id/codesystem/questionnaire',
                        'code'    => $alt['code'],
                        'display' => $alt['display']
                    ]
                ];
            }

            $item['answerOption'] = $answerOption;
        }

        // Payload Questionnaire
        $payload = [
            "resourceType" => "Questionnaire",
            "status"       => "active",
            "subjectType"  => ["Practitioner"],
            "title"        => $question_group,
            "publisher"    => $company_name,
            "item"         => [$item]
        ];

        $payload_json = json_encode($payload, JSON_UNESCAPED_UNICODE);

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
                'message' => 'Koneksi SATUSEHAT tidak ditemukan.'
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
    }

    // ======================================================
    // SIMPAN KE DATABASE
    // ======================================================
    $stmt = $Conn->prepare("
        INSERT INTO referensi_questionnaire
        (id_questionnaire, link_id, question_group, question_text, question_type, alternative)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssssss",
        $id_questionnaire,
        $link_id,
        $question_group,
        $question_text,
        $question_type,
        $alternatif_json
    );

    if (!$stmt->execute()) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Execute failed: ' . $stmt->error
        ]);
        exit;
    }

    $stmt->close();

    // ======================================================
    // RESPONSE SUKSES
    // ======================================================
    echo json_encode([
        'status'  => 'success',
        'message' => 'Referensi Pertanyaan Berhasil Disimpan'
    ]);
    exit;
?>