<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");

    $now = date('Y-m-d H:i:s');

    // Validasi Session
    if(empty($SessionIdAccess)){
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Validasi kode_medication_request
    if(empty($_POST['kode_medication_request'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>Kode Item Resep Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }
    $kode_medication_request = $_POST['kode_medication_request'];

    // Buka Dari Database
    $Qry = $Conn->prepare("SELECT * FROM medication_request WHERE kode_medication_request = ?");
    $Qry->bind_param("s", $kode_medication_request);
    if (!$Qry->execute()) {
        echo '
            <div class="alert alert-danger">
                <small>Terjadi kesalahan saat membuka data Item Resep!<br>
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
    $id_medication_request_group = $Data['id_medication_request_group'];
    $intent                      = $Data['intent'];
    $id_medication               = $Data['id_medication'];
    $name_medication             = $Data['name_medication'];
    $status                      = $Data['status'];
    
    // dosage_inst
    $dosage_inst_text        = $Data['dosage_inst_text'];
    $dosage_inst_frequency   = $Data['dosage_inst_frequency'];
    $dosage_inst_period      = $Data['dosage_inst_period'];
    $dosage_inst_period_unit = $Data['dosage_inst_period_unit'];
    
    // Route
    $route_display = $Data['route_display'];
    $route_code    = $Data['route_code'];
    $route_system  = $Data['route_system'];
    
    //Dispense
    $dispense_value = $Data['dispense_value'];
    $dispense_unit  = $Data['dispense_unit'];
    $dispense_code  = $Data['dispense_code'];
    $dispense_sys   = $Data['dispense_sys'];

    // Dose
    $dose_value  = $Data['dose_value'];
    $dose_unit   = $Data['dose_unit'];
    $dose_code   = $Data['dose_code'];
    $dose_system = $Data['dose_system'];

    //supply_duration
    $supply_duration_value = $Data['supply_duration_value'];
    $supply_duration_unit  = $Data['supply_duration_unit'];
    $supply_duration_code  = $Data['supply_duration_code'];
    $supply_duration_sys   = $Data['supply_duration_sys'];

    // Buka Pengaturan Satu Sehat
    $status_active = 1;
    $stmt = $Conn->prepare("SELECT url_connection_satu_sehat, organization_id FROM connection_satu_sehat WHERE status_connection_satu_sehat = ?");
    $stmt->bind_param("i", $status_active);
    $stmt->execute();
    $result = $stmt->get_result();
    $config = $result->fetch_assoc();
    $stmt->close();

    if (!$config) {
        echo '
            <div class="alert alert-warning">
                <small>Koneksi SATU SEHAT tidak ditemukan.</small>
            </div>
        ';
        exit;
    }
    $organization_id      = $config['organization_id'];

    // Buka Beberapa informasi dari medication_request_group
    $priority     = GetDetailData($Conn, 'medication_request_group', 'id_medication_request_group', $id_medication_request_group, 'priority');
    $pasien_nama  = GetDetailData($Conn, 'medication_request_group', 'id_medication_request_group', $id_medication_request_group, 'pasien_nama');
    $id_kunjungan = GetDetailData($Conn, 'medication_request_group', 'id_medication_request_group', $id_medication_request_group, 'id_kunjungan');
    $id_encounter = GetDetailData($Conn, 'medication_request_group', 'id_medication_request_group', $id_medication_request_group, 'id_encounter');
    $dokter_nama  = GetDetailData($Conn, 'medication_request_group', 'id_medication_request_group', $id_medication_request_group, 'dokter_nama');
    $dokter_ihs   = GetDetailData($Conn, 'medication_request_group', 'id_medication_request_group', $id_medication_request_group, 'dokter_ihs');

    if(empty($id_kunjungan)){
        echo '
            <div class="alert alert-danger">
                <small>ID Kunjungan Tidak Ditemukan Pada Lembar Resep Ini</small>
            </div>
        ';
        exit;
    }

    // Buka Pengaturan SIMRS
    $status_connection_simrs = 1;
    $url_connection_simrs    = GetDetailData($Conn,'connection_simrs','status_connection_simrs',$status_connection_simrs,'url_connection_simrs');
    
    //Dapatkan Token SIMRS
    $token_simrs = GetSimrsToken($Conn);

    // Jika Token Tidak Valid Dan Gagal Dibuat
    if ($token_simrs === false) {
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
            'token: '.$token_simrs.'',
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
    $id_ihs             = $metadata['pasien']['id_ihs'];

    // Membuat datetime_iso
    $dt = new DateTime($now, new DateTimeZone('Asia/Jakarta'));
    $datetime_iso = $dt->format('Y-m-d\TH:i:sP');

    // Menyusun Payload
    $payload = [
        "resourceType" => "MedicationRequest",

        "identifier" => [[
            "system" => "http://sys-ids.kemkes.go.id/prescription/$organization_id",
            "value"  => (string) $kode_medication_request
        ]],

        "status"   => (string) $status,      // active
        "intent"   => (string) $intent,      // order
        "priority" => (string) $priority,    // routine

        "medicationReference" => [
            "reference" => "Medication/$id_medication",
            "display"   => (string) $name_medication
        ],

        "subject" => [
            "reference" => "Patient/$id_ihs",
            "display"   => (string) $pasien_nama
        ],

        "encounter" => [
            "reference" => "Encounter/$id_encounter"
        ],

        "authoredOn" => (string) $datetime_iso,

        "requester" => [
            "reference" => "Practitioner/$dokter_ihs",
            "display"   => (string) $dokter_nama
        ],

        "dosageInstruction" => [[
            "text" => (string) $dosage_inst_text,

            "timing" => [
                "repeat" => [
                    "frequency"  => (int) $dosage_inst_frequency, // 🔢
                    "period"     => (int) $dosage_inst_period,    // 🔢
                    "periodUnit" => (string) $dosage_inst_period_unit // d
                ]
            ],

            "route" => [
                "coding" => [[
                    "system"  => "http://www.whocc.no/atc",
                    "code"    => (string) $route_code,
                    "display" => (string) $route_display
                ]]
            ],

            "doseAndRate" => [[
                "doseQuantity" => [
                    "value"  => (float) $dose_value, // 🔢
                    "unit"   => (string) $dose_unit,
                    "system" => "http://unitsofmeasure.org",
                    "code"   => (string) $dose_code
                ]
            ]]
        ]],

        "dispenseRequest" => [
            "quantity" => [
                "value"  => (int) $dispense_value, // 🔢
                "unit"   => (string) $dispense_unit,
                "system" => "http://unitsofmeasure.org",
                "code"   => (string) $dispense_code
            ],

            "expectedSupplyDuration" => [
                "value"  => (int) $supply_duration_value, // 🔢
                "unit"   => (string) $supply_duration_unit,
                "system" => "http://unitsofmeasure.org",
                "code"   => (string) $supply_duration_code
            ]
        ]
    ];

    $payload_json = json_encode($payload,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    // Menampilkan Payload
    echo '
        <input type="hidden" name="kode_medication_request" value="'.$kode_medication_request.'">
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="table table-responsive">
                    <table class="table table-sm table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="2"><small><b>A. Informasi Resep</b></small></td>
                            </tr>
                            <tr>
                                <td><small>ID Medication</small></td>
                                <td>
                                    <small class="text text-grayish">'.$id_medication.'</small>
                                </td>
                            </tr>
                            <tr>
                                <td><small>Nama Obat/Alkes</small></td>
                                <td>
                                    <small class="text text-grayish">'.$name_medication.'</small>
                                </td>
                            </tr>
                            <tr>
                                <td><small>Status</small></td>
                                <td>
                                    <small class="text text-grayish">'.$status.'</small>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><small><b>B. Informasi Pasien & Kunjungan</b></small></td>
                            </tr>
                            <tr>
                                <td><small>ID Kunjungan</small></td>
                                <td>
                                    <small class="text text-grayish">'.$id_kunjungan.'</small>
                                </td>
                            </tr>
                            <tr>
                                <td><small>ID Encounter</small></td>
                                <td>
                                    <small class="text text-grayish">'.$id_encounter.'</small>
                                </td>
                            </tr>
                            <tr>
                                <td><small>Nama Pasien</small></td>
                                <td>
                                    <small class="text text-grayish">'.$pasien_nama.'</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12"><small><b>Payload</b></small></div>
            <div class="col-md-12">
                <label for="payload_medication_request"><small>Payload Medication Request</small></label>
                <textarea name="payload_medication_request" id="payload_medication_request" class="form-control">'.$payload_json.'</textarea>
            </div>
        </div>
    ';
?>
