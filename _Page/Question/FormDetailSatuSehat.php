<?php
    // Koneksi Session Dan Function
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

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

    // Validasi id_questionnaire
    if (empty($_POST['id_questionnaire'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Questionnaire Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel 'id_questionnaire' dan sanitazi
    $id_questionnaire = validateAndSanitizeInput($_POST['id_questionnaire']);

    // Generate Token
    $tokenResult = generateTokenSatuSehat($Conn);
    if ($tokenResult['status'] !== 'success') {
        echo '
            <div class="alert alert-danger">
                <small>Terjadi kesalahan pada saat membuat token.<br>Error : '.$tokenResult['message'].'</small>
            </div>
        ';
        exit;
    }

    $token = $tokenResult['token'];

    // Ambil URL SATUSEHAT
    $stmt = $Conn->prepare("SELECT url_connection_satu_sehat FROM connection_satu_sehat WHERE status_connection_satu_sehat = 1 LIMIT 1");
    $stmt->execute();
    $config = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$config) {
        echo '
            <div class="alert alert-danger">
                <small>Terjadi kesalahan pada saat membuat token.<br>Error : '.$tokenResult['message'].'</small>
            </div>
        ';
        exit;
    }

    $url = rtrim($config['url_connection_satu_sehat'], '/') . "/fhir-r4/v1/Questionnaire/$id_questionnaire";

    // CURL PUT
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "GET",
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
        echo '
            <div class="alert alert-danger">
                <small>CURL Error.<br>Error : '.$curl_err.'</small>
            </div>
        ';
        exit;
    }

    $result = json_decode($response, true);

    if (!in_array($http_code, [200, 201])) {
        $msg = $result['issue'][0]['details']['text']?? $result['issue'][0]['diagnostics']?? 'Gagal retire Questionnaire di SATU SEHAT';
        echo '
            <div class="alert alert-danger">
                <small>'.$msg.'.<br>HTTP Error : '.$http_code.'</small>
            </div>
        ';
        exit;
    }

    // Buat variabel
    $id           = $result['id'];
    $item         = $result['item'];
    $meta         = $result['meta'];
    $publisher    = $result['publisher'];
    $resourceType = $result['resourceType'];
    $status       = $result['status'];
    $subjectType  = $result['subjectType'];
    $title        = $result['title'];
    $item_list    = $item[0];
    echo '
        <div class="row mb-3">
            <div class="col-5"><small>ID Questionnaire</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$id.'</small></div>
        </div>
        <div class="row mb-3">
            <div class="col-5"><small>Link ID</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$item_list['linkId'].'</small></div>
        </div>
        <div class="row mb-3">
            <div class="col-5"><small>Publisher</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$publisher.'</small></div>
        </div>
        <div class="row mb-3">
            <div class="col-5"><small>Subject Type</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$subjectType[0].'</small></div>
        </div>
        <div class="row mb-3">
            <div class="col-5"><small>Kategori</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$title.'</small></div>
        </div>
        <div class="row mb-3">
            <div class="col-5"><small>Text</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$item_list['text'].'</small></div>
        </div>
        <div class="row mb-3">
            <div class="col-5"><small>Type</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$item_list['type'].'</small></div>
        </div>
        <div class="row mb-3">
            <div class="col-5"><small>Last Update</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.date('d F Y H:i T', strtotime($meta['lastUpdated'])).'</small></div>
        </div>
        <div class="row mb-3">
            <div class="col-5"><small>Status</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$status.'</small></div>
        </div>
    ';
    // Jika Ada alternatif
    if(!empty($item_list['answerOption'])){
        echo '
            <div class="row mb-3 mt-3">
                <div class="col-12"><small>Alternatif Jawaban</small></div>
            </div>
        ';

        $no =1;
        foreach ($item_list['answerOption'] as $list_alternatif){
            $code_alternatif = $list_alternatif['valueCoding']['code'];
            $display_alternatif = $list_alternatif['valueCoding']['display'];
            echo '
                <div class="row mb-3">
                    <div class="col-1 text-center"><small>'.$no.'</small></div>
                    <div class="col-4"><small class="text text-grayish">'.$code_alternatif.'</small></div>
                    <div class="col-1"><small>:</small></div>
                    <div class="col-6"><small class="text text-grayish">'.$display_alternatif.'</small></div>
                </div>
            ';

            $no++;
        }
    }
    // echo '
    //     <div class="row mb-3">
    //         <div class="col-12">
    //             <small>Payload</small>
    //             <p>
    //                 <pre>'.json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE).'</pre>
    //             </p>
    //         </div>
    //     </div>
    // ';
?>
