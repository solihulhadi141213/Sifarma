<?php
    // ProsesTambah.php
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    // Fungsi money
    function moneyToNumber($value) {
        if ($value === null || $value === '') return 0;
        return (float) str_replace(['.', ','], ['', '.'], $value);
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
    if(empty($_POST['id_pasien'])){
        echo json_encode(['status' => 'error','message' => 'No RM pasien tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['id_kunjungan'])){
        echo json_encode(['status' => 'error','message' => 'No Kunjungan pasien tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['nama_pasien'])){
        echo json_encode(['status' => 'error','message' => 'Nama pasien tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['gender'])){
        echo json_encode(['status' => 'error','message' => 'Gender/Jenis Kelamin pasien tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['tujuan'])){
        echo json_encode(['status' => 'error','message' => 'Tujuan Kunjungan tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['pembayaran'])){
        echo json_encode(['status' => 'error','message' => 'Metode pembayaran yang digunakan tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['priority'])){
        echo json_encode(['status' => 'error','message' => 'Prioritas Permintaan Resep tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['dokter'])){
        echo json_encode(['status' => 'error','message' => 'Dokter pembuat resep tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['date_creat'])){
        echo json_encode(['status' => 'error','message' => 'Tanggal pembuatan resep tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['time_creat'])){
        echo json_encode(['status' => 'error','message' => 'Jam pembuatan resep tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['reson'])){
        echo json_encode(['status' => 'error','message' => 'Diagnosis resep (Reson Code) tidak boleh kosong!']);
        exit;
    }

      // Buat Variabel dan sanitasi
    $id_medication_request_group = validateAndSanitizeInput($_POST['id_medication_request_group']);
    $id_pasien                   = validateAndSanitizeInput($_POST['id_pasien']);
    $id_kunjungan                = validateAndSanitizeInput($_POST['id_kunjungan']);
    $nama_pasien                 = validateAndSanitizeInput($_POST['nama_pasien']);
    $gender                      = validateAndSanitizeInput($_POST['gender']);
    $tujuan                      = validateAndSanitizeInput($_POST['tujuan']);
    $pembayaran                  = validateAndSanitizeInput($_POST['pembayaran']);
    $priority                    = validateAndSanitizeInput($_POST['priority']);
    $id_dokter                   = validateAndSanitizeInput($_POST['dokter']);
    $date_creat                  = validateAndSanitizeInput($_POST['date_creat']);
    $time_creat                  = validateAndSanitizeInput($_POST['time_creat']);
    $reson                       = validateAndSanitizeInput($_POST['reson']);
    $id_encounter                = validateAndSanitizeInput($_POST['id_encounter'] ?? '');           // Mungkin Belum Ada
    $tanggal_lahir               = validateAndSanitizeInput($_POST['tanggal_lahir'] ?? '');          // Mungkin Belum Ada

    $status_resep = GetDetailData($Conn, 'medication_request_group', 'id_medication_request_group', $id_medication_request_group, 'status_resep');
    // Validasi Status
    if($status_resep == 'Completed' || $status_resep == 'Cancelled'){
        echo json_encode(['status' => 'error','message' => 'Resep Sudah Selesai, Anda tidak bisa mengubahnya!']);
        exit;
    }

    // Reson (Diagnosis ICD 10)
    $parts          = explode("-", $reson, 2);
    $reason_code    = trim($parts[0]);
    $reason_display = trim($parts[1] ?? '');
    $reason_system  = "http://hl7.org/fhir/sid/icd-10";

    if(empty($reason_code) || empty($reason_display)){
        echo json_encode([
            'status' => 'error',
            'message' => 'Format diagnosis tidak valid (Kode - Nama)'
        ]);
        exit;
    }

    // Inisiasi Variabel lain yang belum di definisikan
    $sumber_data    = $app_title;
    $datetime_creat = "$date_creat $time_creat";
    $status_resep   = "Draft";

    // Koneksi Dengan SIMRS
    $status_connection_simrs = 1;
    $url_connection_simrs    = GetDetailData($Conn,'connection_simrs','status_connection_simrs',$status_connection_simrs,'url_connection_simrs');
    $token                   = GetSimrsToken($Conn);
    if($token === false){
        echo json_encode([
            'status' => 'error',
            'message' => 'Gagal mendapatkan token SIMRS!'
        ]);
        exit;
    }

    // Cari Data Lengkap DOKTER dari API SIMRS
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
    $data_dokter = json_decode($response_dokter, true);
    
    $dokter_kode = '';
    $dokter_ihs  = '';
    $dokter_nama = '';
    
    if(!empty($data_dokter['response']['code']) && $data_dokter['response']['code'] == 200){
        $list_dokter = $data_dokter['metadata']['list_dokter'] ?? [];
        foreach($list_dokter as $dokter){
            if($dokter['id_dokter'] == $id_dokter){
                $dokter_kode = $dokter['kode'] ?? '';
                $dokter_ihs  = $dokter['id_ihs_practitioner'] ?? '';
                $dokter_nama = $dokter['nama'] ?? '';
                break;
            }
        }
    }

    // 10. Update ke Database
    try {
        $query = "UPDATE medication_request_group SET
            id_pasien                = ?,
            id_kunjungan             = ?,
            id_encounter             = ?,
            pasien_nama              = ?,
            pasien_gender            = ?,
            pasien_tanggal_lahir     = ?,
            kunjungan_tujuan         = ?,
            kunjungan_pembayaran     = ?,
            priority                 = ?,
            datetime_creat           = ?,
            dokter_kode              = ?,
            dokter_ihs               = ?,
            dokter_nama              = ?,
            reason_code              = ?,
            reason_display           = ?,
            reason_system            = ?,
            sumber_data              = ?,
            status_resep             = ?
            WHERE id_medication_request_group = ?
        ";

        $stmt = $Conn->prepare($query);

        // Bind parameters
        $stmt->bind_param(
            "iissssssssssssssssi",
            $id_pasien,
            $id_kunjungan,
            $id_encounter,
            $nama_pasien,
            $gender,
            $tanggal_lahir,
            $tujuan,
            $pembayaran,
            $priority,
            $datetime_creat,
            $dokter_kode,
            $dokter_ihs,
            $dokter_nama,
            $reason_code,
            $reason_display,
            $reason_system,
            $sumber_data,
            $status_resep,
            $id_medication_request_group
        );

        if($stmt->execute()){
            echo json_encode([
                'status' => 'success',
                'message' => 'Data permintaan resep berhasil diperbarui!',
                'id_medication_request_group' => $id_medication_request_group
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal memperbarui data: ' . $stmt->error
            ]);
        }

        $stmt->close();

    } catch(Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ]);
    }

?>