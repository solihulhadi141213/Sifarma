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

    // Validasi question_group
    if (empty($_POST['question_group'])) {
        echo '
            <div class="alert alert-danger">
                <small>Kategori Pertanyaan Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel 'question_group' dan sanitazi
    $question_group = validateAndSanitizeInput($_POST['question_group']);

    // Query Database 'referensi_denominator'
    $Qry = $Conn->prepare("SELECT * FROM referensi_questionnaire WHERE question_group = ?");
    $Qry->bind_param("s", $question_group);

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

    $question_group = $Data['question_group'];

    echo '
        <input type="hidden" name="question_group_lama"  value="'.$question_group.'">
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="question_group_edit">Kategori Pertanyaan</label>
                <input type="text" name="question_group" id="question_group_edit" class="form-control" value="'.$question_group.'">
            </div>
        </div>
    ';
?>
