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

    $id_questionnaire = $Data['id_questionnaire'];
    $link_id          = $Data['link_id'];
    $question_group   = $Data['question_group'];
    $question_text    = $Data['question_text'];
    $question_type    = $Data['question_type'];

    echo '
        <input type="hidden" name="id_referensi_questionnaire" value="'.$id_referensi_questionnaire.'">
        <div class="row mb-3">
            <div class="col-5"><small><i>Kategori Pertanyaan</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$question_group.'</small></div>
        </div>
        <div class="row mb-3">
            <div class="col-5"><small><i>Tipe Pertanyaan</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$question_type.'</small></div>
        </div>
        <div class="row mb-3">
            <div class="col-5"><small><i>Text Pertanyaan</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$question_text.'</small></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-center">
               <div class="alert alert-warning">
                    <small>Apakah Anda Yakin Akan Menghapus Data Referensi Pertanyaan Tersebut?</small>
               </div>
            </div>
        </div>
    ';
?>
