<?php
    // Koneksi, Global Function, Session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/FungsiAkses.php";

    // Set Zona Waktu
    date_default_timezone_set("Asia/Jakarta");

    // Validasi Sesi Akses
    if(empty($SessionIdAccess)){
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Validasi id_medication_request_group tidak boleh kosong
    if(empty($_POST['id_medication_request_group'])){
        echo '
            <div class="alert alert-danger">
                <small>ID Kunjungan Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel id_medication_request_group dan sanitasi
    $id_medication_request_group = validateAndSanitizeInput($_POST['id_medication_request_group']);

     // Buka Data Dengan Prepared Statment
    $Qry = $Conn->prepare("SELECT * FROM medication_request_group WHERE id_medication_request_group = ?");
    $Qry->bind_param("i", $id_medication_request_group);
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
                <small>Data medication tidak ditemukan.</small>
            </div>
        ';
        exit;
    }
?>
<input type="hidden" name="id_medication_request_group" value="<?php echo $id_medication_request_group; ?>">
<div class="row mb-3">
    <div class="col-12">
        <label for="apoteker_nama"><small>Nama Apoteker</small></label>
        <input type="text" name="apoteker_nama" id="apoteker_nama" class="form-control" value="<?php echo $access_name; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <label for="apoteker_id_ihs"><small>IHS Apoteker</small></label>
        <input type="text" name="apoteker_id_ihs" id="apoteker_id_ihs" class="form-control" value="<?php echo $access_ihs; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <label for="tanggal_verifikasi"><small>Tanggal</small></label>
        <input type="date" name="tanggal_verifikasi" id="tanggal_verifikasi" class="form-control" value="<?php echo date('Y-m-d'); ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <label for="jam_verifikasi"><small>Waktu / Jam</small></label>
        <input type="time" name="jam_verifikasi" id="jam_verifikasi" class="form-control" value="<?php echo date('H:i'); ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="persetujuan_verifikasi" name="persetujuan_verifikasi" value="Ya" checked="">
            <label class="form-check-label" for="persetujuan_verifikasi">
                <small>Saya menyatakan bahwa resep ini telah diterima, dikaji secara profesional oleh apoteker, dan telah ditindaklanjuti sesuai dengan standar pelayanan kefarmasian yang berlaku.</small>
            </label>
        </div>
    </div>
</div>