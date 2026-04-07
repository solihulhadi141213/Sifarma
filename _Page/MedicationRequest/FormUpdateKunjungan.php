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
        exit;
    }

    // Buka Metadata
    $metadata = $data['metadata'];

    // Tampilkan Detail Resep
    echo '
        <input type="hidden" name="id_medication_request_group" value="'.$id_medication_request_group.'">
        <input type="hidden" name="id_kunjungan" value="'.$id_kunjungan.'">
    ';

    $id_pasien2 = $metadata['pasien']['id_pasien'];
?>
<div class="row">
    <div class="col-12">
        <div class="table table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <td align="center"><small><b><i class="bi bi-check-square"></i></b></small></td>
                        <td><small><b>Field</b></small></td>
                        <td><small><b>SIFARMA</b></small></td>
                        <td><small><b>SIMRS</b></small></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" name="update_id_pasien" id="update_id_pasien" checked value="1">
                        </td>
                        <td>
                            <label for="update_id_pasien">
                                <small>ID Pasien</small>
                            </label>
                        </td>
                        <td><small class="text-muted"><?php echo $id_pasien; ?></small></td>
                        <td><small class="text-muted"><?php echo $id_pasien2; ?></small></td>
                    </tr>

                    <tr>
                        <td class="text-center">
                            <input type="checkbox" name="update_id_encounter" id="update_id_encounter" checked value="1">
                        </td>
                        <td>
                            <label for="update_id_encounter">
                                <small>ID Encounter</small>
                            </label>
                        </td>
                        <td><small class="text-muted"><?php echo $id_encounter; ?></small></td>
                        <td><small class="text-muted"><?php echo $metadata['id_encounter']; ?></small></td>
                    </tr>

                    <tr>
                        <td class="text-center">
                            <input type="checkbox" name="update_nama" id="update_nama" checked value="1">
                        </td>
                        <td>
                            <label for="update_nama">
                                <small>Nama Pasien</small>
                            </label>
                        </td>
                        <td><small class="text-muted"><?php echo $pasien_nama; ?></small></td>
                        <td><small class="text-muted"><?php echo $metadata['pasien']['nama']; ?></small></td>
                    </tr>

                    <tr>
                        <td class="text-center">
                            <input type="checkbox" name="update_gender" id="update_gender" checked value="1">
                        </td>
                        <td>
                            <label for="update_gender">
                                <small>Gender</small>
                            </label>
                        </td>
                        <td><small class="text-muted"><?php echo $pasien_gender; ?></small></td>
                        <td><small class="text-muted"><?php echo $metadata['pasien']['gender']; ?></small></td>
                    </tr>

                    <tr>
                        <td class="text-center">
                            <input type="checkbox" name="update_tanggal_lahir" id="update_tanggal_lahir" checked value="1">
                        </td>
                        <td>
                            <label for="update_tanggal_lahir">
                                <small>Tanggal Lahir</small>
                            </label>
                        </td>
                        <td><small class="text-muted"><?php echo $pasien_tanggal_lahir; ?></small></td>
                        <td><small class="text-muted"><?php echo $metadata['pasien']['tanggal_lahir']; ?></small></td>
                    </tr>

                    <tr>
                        <td class="text-center">
                            <input type="checkbox" name="update_tujuan" id="update_tujuan" checked value="1">
                        </td>
                        <td>
                            <label for="update_tujuan">
                                <small>Tujuan</small>
                            </label>
                        </td>
                        <td><small class="text-muted"><?php echo $kunjungan_tujuan; ?></small></td>
                        <td><small class="text-muted"><?php echo $metadata['tujuan']; ?></small></td>
                    </tr>

                    <tr>
                        <td class="text-center">
                            <input type="checkbox" name="update_pembayaran" id="update_pembayaran" checked value="1">
                        </td>
                        <td>
                            <label for="update_pembayaran">
                                <small>Pembayaran</small>
                            </label>
                        </td>
                        <td><small class="text-muted"><?php echo $kunjungan_pembayaran; ?></small></td>
                        <td><small class="text-muted"><?php echo $metadata['pembayaran']; ?></small></td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>