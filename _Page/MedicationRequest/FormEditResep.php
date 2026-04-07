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

    // Apabila status sudah selesai maka tidak bisa di edit
    if($status_resep=="Completed"){
        echo '
            <div class="alert alert-warning">
                <small>Resep sudah selesai, anda tidak bisa mengubahnya.</small>
            </div>
        ';
        exit;
    }

    //Routing Jenis Kelamin
    if($pasien_gender=="Laki-laki"){
        $select_m = "selected";
        $select_f = "";
    }else{
        if($pasien_gender=="Perempuan"){
            $select_m = "";
            $select_f = "selected";
        }else{
            $select_m = "";
            $select_f = "";
        }
    }

    // Definisikan 'priority'
    $priority_list = [
        'routine' => '<span class="text-info">Biasa</span>',
        'urgent'  => '<span class="text-warning">Segera</span>',
        'asap'    => '<span class="text-danger">Gawat</span>',
        'stat'    => '<span class="text-danger">Darurat</span>',
    ];
    $priority_name = $priority_list[$priority] ?? '-';

    // Routing 'priority'
    if($priority=="routine"){
        $select_routine = 'selected';
        $select_urgent  = '';
        $select_asap    = '';
    }else{
        if($priority=="urgent"){
            $select_routine = '';
            $select_urgent  = 'selected';
            $select_asap    = '';
        }else{
            if($priority=="asap"){
                $select_routine = '';
                $select_urgent  = '';
                $select_asap    = 'selected';
            }else{
                $select_routine = '';
                $select_urgent  = '';
                $select_asap    = '';
            }
        }
    }

    // Routing 'kunjungan_tujuan'
    if($kunjungan_tujuan=="Rajal"){
        $select_rajal = "selected";
        $select_ranap = "";
    }else{
        if($kunjungan_tujuan=="Ranap"){
            $select_rajal = "";
            $select_ranap = "selected";
        }else{
            $select_rajal = "";
            $select_ranap = "";
        }
    }

    // Tampilkan Detail Resep
    echo '
        <input type="hidden" name="id_medication_request_group" value="'.$id_medication_request_group.'">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_pasien_edit"><small>No.RM</small></label>
            </div>
            <div class="col-md-8">
                <input type="text" readonly name="id_pasien" id="id_pasien_edit" class="form-control" value="'.$id_pasien.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_kunjungan_edit"><small>No.Kunjungan</small></label>
            </div>
            <div class="col-md-8">
                <input type="text" readonly name="id_kunjungan" id="id_kunjungan_edit" class="form-control" value="'.$id_kunjungan.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_encounter_edit"><small>ID Encounter</small></label>
            </div>
            <div class="col-md-8">
                <input type="text" name="id_encounter" id="id_encounter_edit" class="form-control" value="'.$id_encounter.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="nama_pasien_edit"><small>Nama Pasien</small></label>
            </div>
            <div class="col-md-8">
                <input type="text" name="nama_pasien" id="nama_pasien_edit" class="form-control" value="'.$pasien_nama.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="gender_edit"><small>Jenis Kelamin / Gender</small></label>
            </div>
            <div class="col-md-8">
                <select name="gender" id="gender_edit" class="form-control">
                    <option value="">Pilih</option>
                    <option '.$select_m.' value="Laki-laki">Laki-laki</option>
                    <option '.$select_f.' value="Perempuan">Perempuan</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="tanggal_lahir_edit"><small>Tanggal Lahir</small></label>
            </div>
            <div class="col-md-8">
                <input type="date" name="tanggal_lahir" id="tanggal_lahir_edit" class="form-control" value="'.$pasien_tanggal_lahir.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="tujuan_edit"><small>Tujuan Kunjungan</small></label>
            </div>
            <div class="col-md-8">
                <select name="tujuan" id="tujuan_edit" class="form-control">
                    <option value="">Pilih</option>
                    <option '.$select_rajal.' value="Rajal">Rajal</option>
                    <option '.$select_ranap.' value="Ranap">Ranap</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="pembayaran_edit"><small>Metode Pembayaran</small></label>
            </div>
            <div class="col-md-8">
                <input type="text" name="pembayaran" id="pembayaran_edit" class="form-control" value="'.$kunjungan_pembayaran.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="priority_edit"><small>Prioritisasi</small></label>
            </div>
            <div class="col-md-8">
                <select name="priority" id="priority_edit" class="form-control">
                    <option '.$select_routine.' value="routine">Biasa</option>
                    <option '.$select_urgent.' value="urgent">Segera</option>
                    <option '.$select_asap.' value="asap">Gawat</option>
                </select>
                <small>
                    <small class="text text-grayish">
                        Skala prioritas adalah tingkat urgensi pasien, untuk menentukan urutan dan kecepatan pelayanan pemeriksaan serta pelaporan hasil.
                    </small>
                </small>
            </div>
        </div>
    ';
    // ===============================
    // MEMBUKA DATA REFERENSI DOKTER DARI SIMRS
    // ===============================
    // Buka URL SIMRS
    $status_connection_simrs = 1;
    $url_connection_simrs = GetDetailData($Conn,'connection_simrs','status_connection_simrs',$status_connection_simrs,'url_connection_simrs');

    //Dapatkan Token SIMRS
    $token = GetSimrsToken($Conn);

    // Jika Token Tidak Valid Dan Gagal Dibuat
    if ($token === false) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal mendapatkan token SIMRS!</small>
            </div>
        ';
        exit;
    }

    $curl2 = curl_init();
    curl_setopt_array($curl2, array(
        CURLOPT_URL => ''.$url_connection_simrs.'/API/SIMRS/get_dokter.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'token: '.$token.'',
            'X-API-Key: ••••••'
        ),
    ));
    $response_dokter = curl_exec($curl2);
    curl_close($curl2);
    
    // Ubah Response Menjadi Arry
    $data_doketer = json_decode($response_dokter, true);

    // Jika Response Tidak Valid
    if (empty($data_doketer['response']['code']) ||$data_doketer['response']['code'] != 200) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal memuat data dokter<br> Pesan : '.$data['response']['message'].'</small>
            </div>
        ';
        exit;
    }

    $metadata_dokter = $data_doketer['metadata'];
    $list_dokter     = $metadata_dokter['list_dokter']?? [];

    // Jika Data Dokter Tidak Ada
    if (empty($list_dokter)) {
        echo '
            <div class="alert alert-danger">
                <small>Tidak Ada Data Dokter Yang Ditampilkan</small>
            </div>
        ';
        exit;
    }

    //Menampilkan Form
    echo '<div class="row mb-2">';
    echo '
            <div class="col-md-4">
                <label for="dokter_edit"><small>Dokter Pengirim</small></label>
            </div>
    ';
    echo '  <div class="col-md-8">';
    echo '      <select name="dokter" id="dokter_edit" class="form-control">';
    echo '          <option value="">Pilih</option>';
    foreach ($list_dokter as $row) {
        $id_dokter_list      = $row['id_dokter'];
        $kode                = $row['kode'];
        $nama                = $row['nama'];
        $kategori            = $row['kategori'];
        $id_ihs_practitioner = $row['id_ihs_practitioner'];
        if($dokter_kode== $kode){
            echo '<option selected value="'.$id_dokter_list.'">'.$nama.'</option>';
        }else{
            echo '<option value="'.$id_dokter_list.'">'.$nama.'</option>';
        }
        
    }
    echo '      </select>';
    echo '  </div>';
    echo '</div>';
    echo '
        <div class="row mb-2">
            <div class="col-md-4">
                <label for="datetime_creat_edit"><small>Tanggal/Jam</small></label>
            </div>
            <div class="col-md-4 col-6">
                <input type="date" name="date_creat" id="date_creat_edit" class="form-control" value="'.date('Y-m-d', strtotime($datetime_creat)).'">
            </div>
            <div class="col-md-4 col-6">
                <input type="time" name="time_creat" id="time_creat_edit" class="form-control" value="'.date('H:i', strtotime($datetime_creat)).'">
            </div>
        </div>
    ';

    echo '
       <div class="row mb-3">
            <div class="col-md-4">
                <label for="reson_view_edit"><small>Diagnosis (ICD 10)</small></label>
            </div>
            <div class="col-md-8">
                <input type="text" readonly name="reson" id="reson_view_edit" class="form-control reson-view_edit" value="'.$reason_code.' - '.$reason_display.'">
                <select name="reson" id="reson_edit" class="form-control reson-edit_edit" style="display:none;">
                </select>
                <small class="text text-grayish">
                    Double click untuk mengubah diagnosis
                </small>
            </div>
        </div>
    ';
?>
<script>
    $("#button_edit_resep").prop("disabled", false);
</script>