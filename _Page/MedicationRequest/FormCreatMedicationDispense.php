<?php
    // Koneksi, Function dan Session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/FungsiAkses.php";
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

    // Validasi Primary Key
    if (empty($_POST['kode_medication_request'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Lembar Resep Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel dan Sanitasi
    $kode_medication_request = validateAndSanitizeInput($_POST['kode_medication_request']);

    // Buka Data Dengan Prepared Statment
    $Qry = $Conn->prepare("SELECT * FROM medication_request WHERE kode_medication_request = ?");
    $Qry->bind_param("i", $kode_medication_request);
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
    $id_medication_request_group = $Data['id_medication_request_group'];
    
    // Buka id_encounter
    $id_encounter = GetDetailData($Conn, 'medication_request_group', 'id_medication_request_group', $id_medication_request_group, 'id_encounter');
    $id_kunjungan = GetDetailData($Conn, 'medication_request_group', 'id_medication_request_group', $id_medication_request_group, 'id_kunjungan');

    // Buka API Kunjungan Dari SIMRS
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
    $data_kunjungan = json_decode($response, true);

    // Jika Response Tidak Valid
    if (empty($data_kunjungan['response']['code']) ||$data_kunjungan['response']['code'] != 200) {
        echo '
            <div class="alert alert-danger">
                <small>Gagal memuat data kunjungan<br> Pesan : '.$data_kunjungan['response']['message'].'</small>
            </div>
        ';
        exit;
    }

    // Buka Metadata
    $metadata = $data_kunjungan['metadata'];

    // Informasi Pasien
    $id_ihs = $metadata['pasien']['id_ihs'];
    $nama   = $metadata['pasien']['nama'];

    // Routing Checklist Generate Medication Dispense
    if(!empty($Data['id_medication_request'])&&!empty($Data['id_medication'])&&!empty($access_ihs)&&!empty($id_encounter)&&!empty($id_ihs)){
        $generate_dispensing = "checked";
    }else{
        $generate_dispensing = "";
    }

    echo '<input type="hidden" name="id_medication_request_group" value="'.$Data['id_medication_request_group'].'">';
    echo '<input type="hidden" name="kode_medication_request" value="'.$kode_medication_request.'">';
    
    echo '
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <small>Form ini digunakan untuk mencatat <i>Medication Dispense</i> atau informasi penyerahan obat.</small>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_encounter_for_dispensing"><small><i>ID Encounter</i></small></label>
            </div>
            <div class="col-8">
                <input type="text" readonly name="id_encounter" id="id_encounter_for_dispensing" class="form-control" value="'.$id_encounter.'">
                <small>
                    <small>ID Kunjungan dari Resource Satu Sehat</small>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_medication_request"><small><i>ID Medication Request</i></small></label>
            </div>
            <div class="col-8">
                <input type="text" readonly name="id_medication_request" id="id_medication_request" class="form-control" value="'.$Data['id_medication_request'].'">
                <small>
                    <small>Kode Peresepan Dari Resource Satu Sehat</small>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_medication_for_dispense"><small><i>ID Medication</i></small></label>
            </div>
            <div class="col-8">
                <input type="text" readonly name="id_medication" id="id_medication_for_dispense" class="form-control" value="'.$Data['id_medication'].'">
                <small>
                    <small>Kode Obat/Alkes Dari Index Resource Satu Sehat</small>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_ihs"><small><i>ID IHS Pasien</i></small></label>
            </div>
            <div class="col-8">
                <input type="text" readonly name="id_ihs" id="id_ihs" class="form-control" value="'.$id_ihs.'">
                <small>
                    <small>ID IHS dari Resource Satu Sehat</small>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="nama_pasien"><small>Nama Pasien</small></label>
            </div>
            <div class="col-8">
                <input type="text" readonly name="nama_pasien" id="nama_pasien" class="form-control" value="'.$nama.'" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="name_medication_for_dispense"><small>Nama Obat / Alkes</small></label>
            </div>
            <div class="col-8">
                <input type="text" readonly name="name_medication" id="name_medication_for_dispense" class="form-control" value="'.$Data['name_medication'].'" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="apoteker_id_ihs"><small>ID Apoteker</small></label>
            </div>
            <div class="col-8">
                <input type="text" name="apoteker_id_ihs" id="apoteker_id_ihs" class="form-control" value="'.$access_ihs.'">
                <small>
                    <small>ID Practitioner Dari Resource Satu Sehat</small>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="apoteker_nama"><small>Nama Apoteker</small></label>
            </div>
            <div class="col-8">
                <input type="text" name="apoteker_nama" id="apoteker_nama" class="form-control" value="'.$access_name.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="quantity_value"><small>Jumlah Obat / Alkes</small></label>
            </div>
            <div class="col-8">
                <input type="number" step="0.01" min="0" name="quantity_value" id="quantity_value" class="form-control" value="'.$Data['dispense_value'].'">
                <small>
                    <small>Jumlah Obat / Alkes Yang diserahkan kepada pasien</small>
                </small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="quantity_unit"><small><i>Quantity Unit</i></small></label>
            </div>
            <div class="col-8">
                <input type="text" name="quantity_unit" id="quantity_unit" class="form-control" value="'.$Data['dispense_unit'].'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="quantity_code"><small><i>Quantity Code</i></small></label>
            </div>
            <div class="col-8">
                <input type="text" name="quantity_code" id="quantity_code" class="form-control" value="'.$Data['dispense_code'].'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="quantity_system"><small><i>Quantity System</i></small></label>
            </div>
            <div class="col-8">
                <input type="text" name="quantity_system" id="quantity_system" class="form-control" value="'.$Data['dispense_sys'].'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="status_medication_dispense">
                    <small>* Status Penyerahan</small>
                </label>
            </div>
            <div class="col-8">
                <select name="status" id="status_medication_dispense" class="form-control" required>
                    <option value="">Pilih</option>
                    <option value="preparation">Sedang disiapkan</option>
                    <option value="in-progress">Proses dispensing</option>
                    <option selected value="completed">Sudah Diserahkan Ke Pasien</option>
                    <option value="stopped">Dihentikan</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"></div>
            <div class="col-8">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="generate_id_medication_dispense" id="generate_id_medication_dispense" value="Ya" '.$generate_dispensing.'>
                    <label class="form-check-label" for="generate_id_medication_dispense">
                        <small>Generate ID Medication Dispense</small>
                    </label>
                </div>
            </div>
        </div>
    ';
?>