<?php
    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set('Asia/Jakarta');

    // Validasi Session
    if (empty($SessionIdAccess)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Tangkap ID Kunjungan
    if(empty($_POST['id_kunjungan'])){
        echo '
            <div class="alert alert-danger">
                <small>ID Kunjungan Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat variabel id_kunjungan
    $id_kunjungan = validateAndSanitizeInput($_POST['id_kunjungan']);

    // Buka URL SIMRS
    $status_connection_simrs = 1;
    $url_connection_simrs    = GetDetailData($Conn,'connection_simrs','status_connection_simrs',$status_connection_simrs,'url_connection_simrs');
    
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
    }else{

        // Buka Metadata
        $metadata = $data['metadata'];

        // Menampilkan Data
        echo '
            <div class="row mb-2">
                <div class="col-12">
                    <small>
                        <b>A. Informasi pasien</b>
                    </small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>No.RM</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['id_pasien'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Nama Pasien</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['nama'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>NIK</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['nik'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>No.BPJS</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['no_bpjs'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Gender/Jenis Kelamin</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['gender'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Tempat Lahir</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['tempat_lahir'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Tanggal Lahir</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['tanggal_lahir'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Provinsi</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['propinsi'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Kab/Kota</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['kabupaten'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Kecamatan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['kecamatan'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Desa/Kelurahan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['desa'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Alamat</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['alamat'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Kontak Pasien</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['kontak'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Kontak Darurat</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['kontak_darurat'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Penanggung Jawab</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['penanggungjawab'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Status Perkawinan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['perkawinan'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Pekerjaan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['pekerjaan'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Update Terakhir</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['updatetime'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Petugas RM</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['nama_petugas'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Status Pasien</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pasien']['status'].'</small></div>
            </div>
            <div class="row mb-2 mt-3">
                <div class="col-12">
                    <small>
                        <b>B. Informasi Kunjungan</b>
                    </small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>ID Kunjungan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$id_kunjungan.'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>ID Encounter</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['id_encounter'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Antrian</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['no_antrian'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>SEP</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['sep'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>No.Rujukan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['noRujukan'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>SKDP</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['skdp'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Tanggal Kunjungan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['tanggal'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Keluhan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['keluhan'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Tujuan</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['tujuan'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Pembayaran</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['pembayaran'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Diagnosa Awal</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['DiagAwal'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Update Terakhir</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['updatetime'].'</small></div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Petugas Pendaftaran</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text text-grayish">'.$metadata['nama_petugas'].'</small></div>
            </div>
        ';
    }
?>