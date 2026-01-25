<?php
    // Koneksi, Global Function, Session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

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

    // Validasi id_kunjungan tidak boleh kosong
    if(empty($_POST['id_kunjungan'])){
        echo '
            <div class="alert alert-danger">
                <small>ID Kunjungan Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel id_kunjungan dan sanitasi
    $id_kunjungan = validateAndSanitizeInput($_POST['id_kunjungan']);

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

    // Mulai CURL service API SIMRS Untuk Mendapatkan Detail Kunjungan
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => ''.$url_connection_simrs.'/API/SIMRS/get_detail_kunjungan.php?id='.$id_kunjungan.'',
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

    $response = curl_exec($curl);
    curl_close($curl);

    // Ubah Response Menjadi Arry
    $data = json_decode($response, true);

    // Jika Response Tidak Valid
    if (empty($data['response']['code']) ||$data['response']['code'] != 200) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal memuat data kunjungan<br> Pesan : '.$data['response']['message'].'</small>
            </div>
        ';
        exit;
    }

    // Buka Metadata
    $metadata = $data['metadata'];

    // Buat Variabel Penting
    $id_encounter = $metadata['id_encounter'];
    $tujuan       = $metadata['tujuan'];
    $id_dokter    = $metadata['id_dokter'];

    //Routing asal kiriman
    if($tujuan=="Rajal"){
        $asal_kiriman = $metadata['poliklinik'];
    }else{
        $asal_kiriman = $metadata['ruangan'];
    }
    $jenis_kelamin = $metadata['pasien']['gender'];
    if($jenis_kelamin=="Laki-laki"){
        $select_m = "selected";
        $select_f = "";
    }else{
        if($jenis_kelamin=="Perempuan"){
            $select_m = "";
            $select_f = "selected";
        }else{
            $select_m = "";
            $select_f = "";
        }
    }

    // Routing Rajal/Ranap
    if($tujuan=="Rajal"){
        $select_rajal = "selected";
        $select_ranap = "";
    }else{
        if($tujuan=="Ranap"){
            $select_rajal = "";
            $select_ranap = "selected";
        }else{
            $select_rajal = "";
            $select_ranap = "";
        }
    }
    //Tampilkan Form
    echo '
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_pasien"><small>No.RM</small></label>
            </div>
            <div class="col-md-8">
                <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="'.$metadata['pasien']['id_pasien'].'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_kunjungan"><small>No.Kunjungan</small></label>
            </div>
            <div class="col-md-8">
                <input type="text" readonly name="id_kunjungan" id="id_kunjungan" class="form-control" value="'.$metadata['id_kunjungan'].'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_encounter"><small>ID Encounter</small></label>
            </div>
            <div class="col-md-8">
                <input type="text" readonly name="id_encounter" id="id_encounter" class="form-control" value="'.$metadata['id_encounter'].'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="nama_pasien"><small>Nama Pasien</small></label>
            </div>
            <div class="col-md-8">
                <input type="text" name="nama_pasien" id="nama_pasien" class="form-control" value="'.$metadata['pasien']['nama'].'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="gender"><small>Jenis Kelamin / Gender</small></label>
            </div>
            <div class="col-md-8">
                <select name="gender" id="gender" class="form-control">
                    <option value="">Pilih</option>
                    <option '.$select_m.' value="Laki-laki">Laki-laki</option>
                    <option '.$select_f.' value="Perempuan">Perempuan</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="tanggal_lahir"><small>Tanggal Lahir</small></label>
            </div>
            <div class="col-md-8">
                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="'.$metadata['pasien']['tanggal_lahir'].'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="tujuan"><small>Tujuan Kunjungan</small></label>
            </div>
            <div class="col-md-8">
                <select name="tujuan" id="tujuan" class="form-control">
                    <option value="">Pilih</option>
                    <option '.$select_rajal.' value="Rajal">Rajal</option>
                    <option '.$select_ranap.' value="Ranap">Ranap</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="pembayaran"><small>Metode Pembayaran</small></label>
            </div>
            <div class="col-md-8">
                <input type="text" name="pembayaran" id="pembayaran" class="form-control" value="'.$metadata['pembayaran'].'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="priority"><small>Prioritisasi</small></label>
            </div>
            <div class="col-md-8">
                <select name="priority" id="priority" class="form-control">
                    <option value="routine">Biasa</option>
                    <option value="urgent">Segera</option>
                    <option value="asap">Gawat</option>
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
                <label for="dokter"><small>Dokter Pengirim</small></label>
            </div>
    ';
    echo '  <div class="col-md-8">';
    echo '      <select name="dokter" id="dokter" class="form-control">';
    echo '          <option value="">Pilih</option>';
    foreach ($list_dokter as $row) {
        $id_dokter_list      = $row['id_dokter'];
        $kode                = $row['kode'];
        $nama                = $row['nama'];
        $kategori            = $row['kategori'];
        $id_ihs_practitioner = $row['id_ihs_practitioner'];
        if($id_dokter== $id_dokter_list){
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
                <label for="datetime_creat"><small>Tanggal/Jam</small></label>
            </div>
            <div class="col-md-4 col-6">
                <input type="date" name="date_creat" id="date_creat" class="form-control" value="'.date('Y-m-d').'">
            </div>
            <div class="col-md-4 col-6">
                <input type="time" name="time_creat" id="time_creat" class="form-control" value="'.date('H:i').'">
            </div>
        </div>
    ';

    echo '
       <div class="row mb-3">
            <div class="col-md-4">
                <label><small>Diagnosis (ICD 10)</small></label>
            </div>
            <div class="col-md-8">
                <input type="text" readonly name="reson" id="reson_view" class="form-control reson-view" value="'.$metadata['DiagAwal'].'">
                <select name="reson" id="reson" class="form-control reson-edit" style="display:none;">
                </select>
                <small class="text text-grayish">
                    Double click untuk mengubah diagnosis
                </small>
            </div>
        </div>
    ';
?>