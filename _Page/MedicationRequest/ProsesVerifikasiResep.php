<?php
    // ProsesTambah.php
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    // Validasi Sesi
    if(empty($SessionIdAccess)){
        echo json_encode(['status' => 'error','message' => 'Sesi Akses Sudah Berakhir. Silahkan Login Ulang!']);
        exit;
    }

    // Validasi input yang wajib terisi
    if(empty($_POST['id_medication_request_group'])){
        echo json_encode([
            'status' => 'error',
            'message' => 'ID Group Resep tidak Boleh Kosong!'
        ]);
        exit;
    }
    if(empty($_POST['apoteker_nama'])){
        echo json_encode(['status' => 'error','message' => 'Nama Apoteker tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['apoteker_id_ihs'])){
        echo json_encode(['status' => 'error','message' => 'IHS Apoteker tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['tanggal_verifikasi'])){
        echo json_encode(['status' => 'error','message' => 'Tanggal Verifikasi tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['jam_verifikasi'])){
        echo json_encode(['status' => 'error','message' => 'Gender/Jenis Kelamin pasien tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['persetujuan_verifikasi'])){
        echo json_encode(['status' => 'error','message' => 'Persetujuan Verifikasi Belum Diisi!']);
        exit;
    }

    // Buat Variabel dan sanitasi
    $id_medication_request_group = validateAndSanitizeInput($_POST['id_medication_request_group']);
    $apoteker_nama               = validateAndSanitizeInput($_POST['apoteker_nama']);
    $apoteker_id_ihs             = validateAndSanitizeInput($_POST['apoteker_id_ihs']);
    $tanggal_verifikasi          = validateAndSanitizeInput($_POST['tanggal_verifikasi']);
    $jam_verifikasi              = validateAndSanitizeInput($_POST['jam_verifikasi']);
    $persetujuan_verifikasi      = validateAndSanitizeInput($_POST['persetujuan_verifikasi']);

    // Tanggal, Jam Verifikasi
    $datetime_verified = "$tanggal_verifikasi $jam_verifikasi";

    $status_resep = GetDetailData($Conn, 'medication_request_group', 'id_medication_request_group', $id_medication_request_group, 'status_resep');
    
    // Validasi Status
    if($status_resep !== 'Draft'){
        echo json_encode(['status' => 'error','message' => 'Verifikasi Resep Dilakukan Hanya Jika Status Draft']);
        exit;
    }
    
    // Membentuk Status Resep 
    $status_resep = "Verified";
    
    //Update ke Database
    try {
        $query = "UPDATE medication_request_group SET
            datetime_verified = ?,
            apoteker_nama     = ?,
            apoteker_id_ihs   = ?,
            status_resep      = ?
            WHERE id_medication_request_group = ?
        ";

        $stmt = $Conn->prepare($query);

        // Bind parameters
        $stmt->bind_param(
            "ssssi",
            $datetime_verified,
            $apoteker_nama,
            $apoteker_id_ihs,
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