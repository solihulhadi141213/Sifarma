<?php
    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');

    // Function Tambahan
    function tampil($value){
        return ($value === null || trim($value) === '')? '-': htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

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
    if (empty($_POST['id_medication_request_group'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Lembar Resep Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel dan Sanitasi
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

    // Buka Variabel Data Resep
    $id_pasien            = tampil($Data['id_pasien'] ?? null);
    $id_kunjungan         = tampil($Data['id_kunjungan'] ?? null);
    $id_encounter         = tampil($Data['id_encounter'] ?? null);
    $pasien_nama          = tampil($Data['pasien_nama'] ?? null);
    $pasien_gender        = tampil($Data['pasien_gender'] ?? null);
    $pasien_tanggal_lahir = tampil($Data['pasien_tanggal_lahir'] ?? null);
    $kunjungan_tujuan     = tampil($Data['kunjungan_tujuan'] ?? null);
    $kunjungan_pembayaran = tampil($Data['kunjungan_pembayaran'] ?? null);
    $priority             = tampil($Data['priority'] ?? null);
    $datetime_creat       = tampil($Data['datetime_creat'] ?? null);
    $dokter_kode          = tampil($Data['dokter_kode'] ?? null);
    $dokter_ihs           = tampil($Data['dokter_ihs'] ?? null);
    $dokter_nama          = tampil($Data['dokter_nama'] ?? null);
    $reason_code          = tampil($Data['reason_code'] ?? null);
    $reason_display       = tampil($Data['reason_display'] ?? null);
    $reason_system        = tampil($Data['reason_system'] ?? null);
    $apoteker             = tampil($Data['apoteker'] ?? null);
    $sumber_data          = tampil($Data['sumber_data'] ?? null);
    $status_resep         = tampil($Data['status_resep'] ?? null);

    // Definisikan 'priority'
    $priority_list = [
        'routine' => '<span class="text-info">Biasa</span>',
        'urgent'  => '<span class="text-warning">Segera</span>',
        'asap'    => '<span class="text-danger">Gawat</span>',
        'stat'    => '<span class="text-danger">Darurat</span>',
    ];
    $priority_name = $priority_list[$priority] ?? '-';

    // Routing Status Resep
    if($status_resep=="Draft"){
        $label_status = '<span class="badge bg-warning">'.$status_resep.'</span>';
    }else{
        if($status_resep=="Verified"){
            $label_status = '<span class="badge bg-info">'.$status_resep.'</span>';
        }else{
            if($status_resep=="Partially"){
                $label_status = '<span class="badge bg-secondary">'.$status_resep.'</span>';
            }else{
                if($status_resep=="Completed"){
                    $label_status = '<span class="badge bg-success">'.$status_resep.'</span>';
                }else{
                    $label_status = '<span class="badge bg-danger">'.$status_resep.'</span>';
                }
            }
        }
    }

    // Tampilkan Detail Resep
    echo '
        <input type="hidden" name="id_medication_request_group" value="'.$id_medication_request_group.'">
        <div class="row mb-2">
            <div class="col-4"><small>No.RM</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-grayish">'.$id_pasien.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>ID Kunjungan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-grayish">'.$id_kunjungan.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>ID Encounter</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-grayish">'.$id_encounter.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-grayish">'.$pasien_nama.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Gender/Jenis Kelamin</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-grayish">'.$pasien_gender.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Prioritas</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-grayish">'.$priority_name.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Tanggal/Jam Resep</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-grayish">'.date('d/m/Y H:i T', strtotime($datetime_creat)).'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Dokter</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text text-grayish">
                    '.$dokter_kode.' - 
                    <span class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.$dokter_ihs.'">'.$dokter_nama.'</span>
                </small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Diagnosa (ICD 10)</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text text-grayish">
                    '.$reason_code.' - 
                    <span class="" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.$reason_system.'">'.$reason_display.'</span>
                </small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Apoteker</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-grayish">'.$apoteker.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Sumber Data</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-grayish">'.$sumber_data.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Status Resep</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7"><small class="text text-grayish">'.$label_status.'</small></div>
        </div>
    ';
?>