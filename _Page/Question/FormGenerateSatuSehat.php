<?php
    // Koneksi Session Dan Function
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Validasi Sesi Akses
    if (empty($SessionIdAccess)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Validasi id_referensi_questionnaire
    if (empty($_POST['id_referensi_questionnaire'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Pertanyaan Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel 'id_referensi_questionnaire' dan sanitazi
    $id_referensi_questionnaire = validateAndSanitizeInput($_POST['id_referensi_questionnaire']);

    // Query Database 'referensi_denominator'
    $Qry = $Conn->prepare("SELECT * FROM referensi_questionnaire WHERE id_referensi_questionnaire = ?");
    $Qry->bind_param("i", $id_referensi_questionnaire);

    if (!$Qry->execute()) {
        echo '
            <div class="alert alert-danger">
                <small>Terjadi kesalahan saat membuka data!<br>
                Keterangan : ' . htmlspecialchars($Conn->error) . '</small>
            </div>
        ';
        exit;
    }

    $Result = $Qry->get_result();
    $Data   = $Result->fetch_assoc();
    $Qry->close();

    if (!$Data) {
        echo '
            <div class="alert alert-warning">
                <small>Data Pertanyaan tidak ditemukan.</small>
            </div>
        ';
        exit;
    }

    $link_id          = $Data['link_id'] ?? '-';
    $question_group   = $Data['question_group'] ?? '-';
    $question_text    = $Data['question_text'] ?? '-';
    $question_type    = $Data['question_type'] ?? '-';
    

    echo '
        <input type="hidden" name="id_referensi_questionnaire" value="'.$id_referensi_questionnaire.'">
        <div class="row mb-3">
            <div class="col-5"><small><i>Link ID</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$link_id.'</small></div>
        </div>
        <div class="row mb-3">
            <div class="col-5"><small>Kategori Pertanyaan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$question_group.'</small></div>
        </div>
        <div class="row mb-3">
            <div class="col-5"><small>Tipe Pertanyaan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$question_type.'</small></div>
        </div>
        <div class="row mb-3">
            <div class="col-5 mb-3"><small>Text Pertanyaan</small></div>
            <div class="col-1 mb-3"><small>:</small></div>
            <div class="col-6 mb-3"><small class="text text-grayish">'.$question_text.'</small></div>
        </div>
    ';
    if(!empty($Data['alternative'])){
        $alternative_arry = json_decode($Data['alternative'], true);
        echo '
            <div class="row mb-3 border-top border-1">
                <div class="col-12 mt-3"><small>Alternatif Jawaban</small></div>
            </div>
        ';
        // Nomor Baris
        $no = 1;
        foreach($alternative_arry as $alternative_list){
            $code = $alternative_list['code'];
            $display = $alternative_list['display'];
            echo '
                <div class="row mb-3">
                    <div class="col-1"><small>'.$no.'</small></div>
                    <div class="col-4"><small>'.$code.'</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6">
                        <small class="text text-grayish">'.$display.'</small>
                    </div>
                </div> 
            ';
            $no++;
        }
    }

    // Memnbuat Payload
    // Bangun item Questionnaire
    $item = [
        "linkId"   => $Data['link_id'],
        "text"     => $Data['question_text'],
        "type"     => $Data['question_type'],
        "required" => true,
        "extension" => [
            [
                "url" => "http://rs-elsyifa.org/fhir/StructureDefinition/question-group",
                "valueString" => $Data['question_group']
            ]
        ]
    ];

    // answerOption hanya untuk choice
    if ($question_type === 'choice') {

        $answerOption = [];

        foreach ($alternative_arry as $alt) {
            $answerOption[] = [
                'valueCoding' => [
                    'system'  => 'http://rs-elsyifa.org/codesystem/questionnaire',
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

    $payload_json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo '
        <div class="row mb-3">
            <div class="col-12">
                <label for="payload_edit"><small>Payload</small></label>
                <textarea name="payload" id="payload_edit" class="form-control">'.$payload_json.'</textarea>
            </div>
        </div>
    ';
?>
    