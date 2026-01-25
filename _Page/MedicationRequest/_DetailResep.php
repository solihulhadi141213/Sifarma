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

    // Informasi Pasien
    $nik             = $metadata['pasien']['nik'];
    $no_bpjs         = $metadata['pasien']['no_bpjs'];
    $tempat_lahir    = $metadata['pasien']['tempat_lahir'];
    $tanggal_lahir   = $metadata['pasien']['tanggal_lahir'];
    $propinsi        = $metadata['pasien']['propinsi'];
    $kabupaten       = $metadata['pasien']['kabupaten'];
    $kecamatan       = $metadata['pasien']['kecamatan'];
    $desa            = $metadata['pasien']['desa'];
    $alamat          = $metadata['pasien']['alamat'];
    $kontak          = $metadata['pasien']['kontak'];
    $kontak_darurat  = $metadata['pasien']['kontak_darurat'];
    $penanggungjawab = $metadata['pasien']['penanggungjawab'];
    $perkawinan      = $metadata['pasien']['perkawinan'];
    $pekerjaan       = $metadata['pasien']['pekerjaan'];

    // Informasi Kunjungan
    $sep          = $metadata['sep'];
    $keluhan      = $metadata['keluhan'];
    $DiagAwal     = $metadata['DiagAwal'];
    $nama_petugas = $metadata['nama_petugas'];
?>
<div class="row mb-3">
    <div class="col-12 text-end">
        <button type="button" class="btn btn-md btn-floating btn-dark" id="back_to_tabel">
            <i class="bi bi-chevron-left"></i>
        </button>
        <button type="button" class="btn btn-md btn-floating btn-outline-primary" id="reload_detail_resep">
            <i class="bi bi-repeat"></i>
        </button>
        <button type="button" class="btn btn-md btn-floating btn-primary" id="reload_detail_resep">
            <i class="bi bi-printer"></i>
        </button>
    </div>
</div>
<div class="row">
    <!-- KOLOM KE 1 -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <b>A. Informasi Pasien</b>
            </div>
            <div class="card-body">
                <?php
                    echo '
                        <div class="row mb-2">
                            <div class="col-4"><small>No.RM</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$id_pasien.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Nama Pasien</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$pasien_nama.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>NIK</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$nik.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>No.BPJS</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$no_bpjs.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Gender/Jenis Kelamin</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$pasien_gender.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Tempat Lahir</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$tempat_lahir.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Tanggal Lahir</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$tanggal_lahir.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Provinsi</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$propinsi.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Kab/Kota</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$kabupaten.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Kecamatan</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$kecamatan.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Desa/Kelurahan</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$desa.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Alamat</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$alamat.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Kontak Pasien</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$kontak.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Kontak Darurat</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$kontak_darurat.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Penanggung Jawab</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$penanggungjawab.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Status Perkawinan</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$perkawinan.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Pekerjaan</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$pekerjaan.'</small></div>
                        </div>
                    ';
                ?>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <b>B. Informasi Kunjungan</b>
            </div>
            <div class="card-body">
                <?php
                    echo '
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
                            <div class="col-4"><small>SEP</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$sep.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Keluhan</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$keluhan.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Tujuan</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$kunjungan_tujuan.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Pembayaran</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$kunjungan_pembayaran.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Diagnosa Awal</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$DiagAwal.'</small></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><small>Petugas Pendaftaran</small></div>
                            <div class="col-1"><small>:</small></div>
                            <div class="col-7"><small class="text text-grayish">'.$nama_petugas.'</small></div>
                        </div>
                    ';
                ?>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-10">
                        <b>D. Informasi Resep</b>
                    </div>
                    <div class="col-2 text-end">
                        <button type="button" class="btn btn-sm btn-secondary btn-floating modal_edit_resep" data-id="<?php echo $id_medication_request_group; ?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php
                    echo '
                        <div class="row mb-2">
                            <div class="col-4"><small>Prioritas Resep</small></div>
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
            </div>
        </div>
    </div>

    <!-- KOLOM KE 2 -->
    <div class="col-md-6">

        <!-- Item Obat -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <b class="card-title">E. Item Obat</b>
                    </div>
                    <div class="col-4 text-end">
                        <button type="button" class="btn btn-sm btn-primary btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-plus"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow bg-body-secondary shadow-2-strong" style="">
                            <li class="dropdown-header text-start">
                                <h6>Option</h6>
                            </li>
                            <li>
                                <a class="dropdown-item modal_obat_alkes" href="javascript:void(0)" data-id="<?php echo $id_medication_request_group; ?>">
                                    <i class="bi bi-plus"></i> Tambah Dari Index Obat/Alkes
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item modal_tambah_item" href="javascript:void(0)" data-id="<?php echo $id_medication_request_group; ?>">
                                    <i class="bi bi-plus"></i> Tambah Manual
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table table-responsive">
                    <table class="table table-sm table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <td class="text-center"><small><b>No</b></small></td>
                                <td class="text-center"><small><b>Kode</b></small></td>
                                <td class="text-center"><small><b>Item Obat/Alkes</b></small></td>
                                <td class="text-center"><small><b>Opsi</b></small></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center" colspan="4">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>