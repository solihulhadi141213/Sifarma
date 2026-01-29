<?php
    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');

    $no = 1;
    
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
    if (empty($_POST['kode_medication_request'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Item Resep Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel dan Sanitasi
    $kode_medication_request = validateAndSanitizeInput($_POST['kode_medication_request']);

    // Buka Data Dengan Prepared Statment
    $Qry = $Conn->prepare("SELECT * FROM medication_request WHERE kode_medication_request = ?");
    $Qry->bind_param("s", $kode_medication_request);
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
                <small>Data Item Resep tidak ditemukan.</small>
            </div>
        ';
        exit;
    }

    // Buka Variabel Data Resep
    $id_medication_request_group = tampil($Data['id_medication_request_group'] ?? null);
    $intent                      = tampil($Data['intent'] ?? null);
    $id_medication               = tampil($Data['id_medication'] ?? null);
    $name_medication             = tampil($Data['name_medication'] ?? null);
    $status                      = tampil($Data['status'] ?? null);
    $dosage_inst_text            = tampil($Data['dosage_inst_text'] ?? null);
    $dosage_inst_frequency       = tampil($Data['dosage_inst_frequency'] ?? null);
    $dosage_inst_period          = tampil($Data['dosage_inst_period'] ?? null);
    $dosage_inst_period_unit     = tampil($Data['dosage_inst_period_unit'] ?? null);
    $dose_value                  = tampil($Data['dose_value'] ?? null);
    $dose_unit                   = tampil($Data['dose_unit'] ?? null);
    $dose_code                   = tampil($Data['dose_code'] ?? null);
    $dose_system                 = tampil($Data['dose_system'] ?? null);
    $route_display               = tampil($Data['route_display'] ?? null);
    $route_code                  = tampil($Data['route_code'] ?? null);
    $route_system                = tampil($Data['route_system'] ?? null);
    $dispense_value              = tampil($Data['dispense_value'] ?? null);
    $dispense_unit               = tampil($Data['dispense_unit'] ?? null);
    $dispense_code               = tampil($Data['dispense_code'] ?? null);
    $dispense_sys                = tampil($Data['dispense_sys'] ?? null);
    $supply_duration_value       = tampil($Data['supply_duration_value'] ?? null);
    $supply_duration_unit        = tampil($Data['supply_duration_unit'] ?? null);
    $supply_duration_code        = tampil($Data['supply_duration_code'] ?? null);
    $supply_duration_sys         = tampil($Data['supply_duration_sys'] ?? null);
    $racikan_code                = tampil($Data['racikan_code'] ?? null);
    $racikan_display             = tampil($Data['racikan_display'] ?? null);
    $ingredient                  = $Data['ingredient'] ?? null;

    // Definisi
    $periode_unit = [
        "s" => "Detik",
        "m" => "Menit",
        "h" => "Jam",
        "d" => "Hari",
        "wk" => "Minggu",
        "mo" => "Bulan"
    ];
    $dosage_inst_period_unit_text =  $periode_unit[$dosage_inst_period_unit];


    // Menampilkan Informasi Obat
    $Qry3 = $Conn->prepare("SELECT * FROM medication WHERE id_medication = ?");
    $Qry3->bind_param("s", $id_medication);
    if (!$Qry3->execute()) {
        echo '
            <div class="alert alert-danger">
                <small>Terjadi kesalahan saat membuka data!<br>
                Keterangan : ' . htmlspecialchars($Conn->error) . '</small>
            </div>
        ';
        exit;
    }
    $Result3 = $Qry3->get_result();
    $Data3   = $Result3->fetch_assoc();
    $Qry3->close();
    
    echo '
        <div class="row mb-2">
            <div class="col-12">
                <small><b>A. Informasi Item Obat</b></small>
            </div>
        </div>
    ';
    if(empty($Data3['id'])){
        echo '
            <div class="row mt-3">
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        <small>Data Obat / Alkes Belum Terdaftar Pada Index <i>Medication</i></small>
                    </div>
                </div>
            </div>
        ';
    }else{
        echo '
            <div class="row mb-2">
                <div class="col-5"><small><i>ID Medication</i></small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6">
                    <small>
                        <a href="javascript:void(0);" class="modal_detail_medication" data-id="'.$id_medication.'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Lihat Informasi Lengkap Dari Satu Sehat">
                            <code  class="text text-primary">'.$id_medication.' <i class="bi bi-arrow-up-right-circle"></i></code>
                        </a>
                    </small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Kode Lokal</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6">
                    <small>
                        <a href="javascript:void(0);" class="modal_detail_medication_lokal" data-id="'.$Data3['medication_code'].'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Lihat Informasi Lengkap Kode Lokal">
                            '.$Data3['medication_code'].' <i class="bi bi-arrow-up-right-circle"></i>
                        </a>
                    </small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Nama Obat / Alkes</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small class="text text-grayish">'.$Data3['medication_name'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Kategori</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small class="text text-grayish">'.$Data3['medication_category'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Sediaan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small class="text text-grayish">'.$Data3['sediaan_display'].' ('.$Data3['sediaan_code'].')</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Obat Racikan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small class="text text-grayish">'.$Data3['racikan_display'].' ('.$Data3['racikan_code'].')</small></div>
            </div>
        ';
    }

    // Routing medication Request
    if(empty($Data['id_medication_request'])){
        $id_medication_request = '<code class="text-danger">Resource Belum Dikirim</code>';
    }else{
        $id_medication_request = '<code class="text-grayish">'.$Data['id_medication_request'].'</code>';
    }
    $no = $no + 1;
    // Tampilkan Detail Resep
    echo '
        <div class="row mb-2 mt-3">
            <div class="col-12">
                <small><b>B.Informasi Peresepan</b></small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small><i>ID Medication Request</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$id_medication_request.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Nama Obat / Alkes</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$name_medication.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Instruksi / Keterangan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$dosage_inst_text.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Frekuensi / Periode</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6"><small class="text text-grayish">'.$dosage_inst_frequency.' Kali Dalam '.$dosage_inst_period.' '.$dosage_inst_period_unit_text.'</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small>Dosis Per Penggunaan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6">
                <small class="text text-grayish underscore_doted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.$dose_system.'">
                    '.$dose_value.' '.$dose_unit.' ('.$dose_code.')
                </small>
            </div>
        </div>
       
        <div class="row mb-2">
            <div class="col-5"><small><i></i>Rout / Cara Penggunaan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6">
                <small class="text text-grayish underscore_doted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.$route_system.'">
                    '.$route_display.' ('.$route_code.')
                </small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small><i></i>Jumlah Yang Harus Diserahkan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6">
                <small class="text text-grayish underscore_doted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.$dispense_sys.'">
                    '.$dispense_value.' '.$dispense_unit.' ('.$dispense_code.')
                </small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small><i></i>Durasi Pengunaan</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-6">
                <small class="text text-grayish underscore_doted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.$supply_duration_sys.'">
                    '.$supply_duration_value.' '.$supply_duration_unit.' ('.$supply_duration_code.')
                </small>
            </div>
        </div>
    ';

    echo '
        <div class="row mb-2 mt-3">
            <div class="col-12">
                <small><b>C. Penyerahan Obat</b></small>
            </div>
        </div>
    ';
    // APabila Sudah Ada Informasi Penyerahan
    $Qry2 = $Conn->prepare("SELECT * FROM medication_dispense WHERE kode_medication_request = ?");
    $Qry2->bind_param("s", $kode_medication_request);
    if (!$Qry2->execute()) {
        echo '
            <div class="alert alert-danger">
                <small>Terjadi kesalahan saat membuka data!<br>
                Keterangan : ' . htmlspecialchars($Conn->error) . '</small>
            </div>
        ';
        exit;
    }
    $Result2 = $Qry2->get_result();
    $Data2   = $Result2->fetch_assoc();
    $Qry2->close();
    if (!$Data2) {
        echo '
            <div class="row mt-3">
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        <small>Belum ada informasi penyerahan obat untuk item resep ini</small>
                    </div>
                </div>
            </div>
        ';
        exit;
    }
    if(!empty($Data2['id_medication_request_group'])){
        if(empty($Data2['id_medication_dispense'])){
            $id_medication_dispense = '<code class="text-danger">Resource Belum Dikirim</code>';
        }else{
            $id_medication_dispense = '<code class="text-grayish">'.$Data2['id_medication_dispense'].'</code>';
        }
        echo '
            <div class="row mb-2">
                <div class="col-5"><small><i>ID Medication Dispense</i></small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small class="text text-grayish">'.$id_medication_dispense.'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Nama Apoteker</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small class="text text-grayish">'.$Data2['apoteker_nama'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>IHS Apoteker</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6"><small class="text text-grayish">'.$Data2['apoteker_id_ihs'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-5"><small>Jumlah Yang Diserahkan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-6">
                    <small class="text text-grayish underscore_doted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.$Data2['quantity_system'].'">
                        '.$Data2['quantity_value'].' '.$Data2['quantity_unit'].' ('.$Data2['quantity_code'].')
                    </small>
                </div>
            </div>
        ';
    }

?>