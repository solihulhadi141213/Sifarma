<?php
    // ProsesTambah.php
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    // Function Tambahan
    function tampil($value){
        return ($value === null || trim($value) === '')? '-': htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    // Validasi Sesi
    if(empty($SessionIdAccess)){
        echo json_encode(['status' => 'error','message' => 'Sesi Akses Sudah Berakhir. Silahkan Login Ulang!']);
        exit;
    }

    // Validasi input yang wajib terisi
    if(empty($_POST['id_medication_request_group'])){
        echo json_encode([
            'status' => 'error',
            'message' => 'ID Resep tidak valid!'
        ]);
        exit;
    }
    if(empty($_POST['id_kunjungan'])){
        echo json_encode(['status' => 'error','message' => 'ID Kunjungan tidak boleh kosong!']);
        exit;
    }
    $id_medication_request_group = $_POST['id_medication_request_group'];
    $id_kunjungan                = $_POST['id_kunjungan'];

    // Buka Data Dengan Prepared Statment
    $Qry = $Conn->prepare("SELECT * FROM medication_request_group WHERE id_medication_request_group = ?");
    $Qry->bind_param("i", $id_medication_request_group);
    if (!$Qry->execute()) {
        echo json_encode([
            'status' => 'error',
            'message' => '' . htmlspecialchars($Conn->error) . ''
        ]);
        exit;
    }
    $Result = $Qry->get_result();
    $Data   = $Result->fetch_assoc();
    $Qry->close();
    if (!$Data) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Data medication tidak ditemukan.'
        ]);
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
    $apoteker_nama        = tampil($Data['apoteker_nama'] ?? null);
    $apoteker_id_ihs      = tampil($Data['apoteker_id_ihs'] ?? null);
    $sumber_data          = tampil($Data['sumber_data'] ?? null);
    $status_resep         = tampil($Data['status_resep'] ?? null);

    // Buka URL SIMRS
    $status_connection_simrs = 1;
    $url_connection_simrs    = GetDetailData($Conn,'connection_simrs','status_connection_simrs',$status_connection_simrs,'url_connection_simrs');
    
    //Dapatkan Token SIMRS
    $token = GetSimrsToken($Conn);

    // Jika Token Tidak Valid Dan Gagal Dibuat
    if ($token === false) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal mendapatkan token SIMRS!'
        ]);
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
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal memuat data kunjungan<br> Pesan : '.$data['response']['message'].''
        ]);
        exit;
    }

    // Buka Metadata
    $metadata = $data['metadata'];

    // Siapkan array field yang akan diupdate
    $update_fields = [];
    $params = [];
    $types = '';

    // ID Pasien
    if (isset($_POST['update_id_pasien'])) {
        $update_fields[] = "id_pasien = ?";
        $params[] = $metadata['pasien']['id_pasien'];
        $types .= 's';
    }

    // ID Encounter
    if (isset($_POST['update_id_encounter'])) {
        $update_fields[] = "id_encounter = ?";
        $params[] = $metadata['id_encounter'];
        $types .= 's';
    }

    // Nama Pasien
    if (isset($_POST['update_nama'])) {
        $update_fields[] = "pasien_nama = ?";
        $params[] = $metadata['pasien']['nama'];
        $types .= 's';
    }

    // Gender
    if (isset($_POST['update_gender'])) {
        $update_fields[] = "pasien_gender = ?";
        $params[] = $metadata['pasien']['gender'];
        $types .= 's';
    }

    // Tanggal lahir
    if (isset($_POST['update_tanggal_lahir'])) {
        $update_fields[] = "pasien_tanggal_lahir = ?";
        $params[] = $metadata['pasien']['tanggal_lahir'];
        $types .= 's';
    }

    // Tujuan
    if (isset($_POST['update_tujuan'])) {
        $update_fields[] = "kunjungan_tujuan = ?";
        $params[] = $metadata['tujuan'];
        $types .= 's';
    }

    // Pembayaran
    if (isset($_POST['update_pembayaran'])) {
        $update_fields[] = "kunjungan_pembayaran = ?";
        $params[] = $metadata['pembayaran'];
        $types .= 's';
    }

    // Jika tidak ada yang dipilih
    if (empty($update_fields)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Tidak ada field yang dipilih untuk diupdate!'
        ]);
        exit;
    }

    // Tambahkan WHERE
    $sql = "UPDATE medication_request_group 
            SET " . implode(', ', $update_fields) . "
            WHERE id_medication_request_group = ?";

    $params[] = $id_medication_request_group;
    $types .= 'i';

    // Prepare query
    $stmt = $Conn->prepare($sql);

    if (!$stmt) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Prepare gagal: ' . $Conn->error
        ]);
        exit;
    }

    // Bind parameter dinamis
    $stmt->bind_param($types, ...$params);

    // Eksekusi
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Data kunjungan berhasil diperbarui'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Update gagal: ' . $stmt->error
        ]);
    }

    $stmt->close();
?>