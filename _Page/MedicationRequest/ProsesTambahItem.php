<?php
    // Connection, Function, Session dan Setting General
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingGeneral.php";

    // Validasi Session Login
    if(empty($SessionIdAccess)){
        echo json_encode(['status' => 'error','message' => 'Sesi Akses Sudah Berakhir. Silahkan Login Ulang!']);
        exit;
    }

    // Validasi Kelengkapan data
    if(empty($_POST['id_medication_request_group'])){
        echo json_encode(['status' => 'error','message' => 'ID Resep tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['intent'])){
        echo json_encode(['status' => 'error','message' => 'Tujuan Resep tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['racikan_code'])){
        echo json_encode(['status' => 'error','message' => 'Tipe Resep tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['name_medication'])){
        echo json_encode(['status' => 'error','message' => 'Nama Obat/Alkes tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['dosage_inst_text'])){
        echo json_encode(['status' => 'error','message' => 'Setidaknya tercatat instrukti pemberian obat!']);
        exit;
    }
    if(empty($_POST['dose_value'])){
        echo json_encode(['status' => 'error','message' => 'Dosis/jumlah satuan resep tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['dose_code'])){
        echo json_encode(['status' => 'error','message' => 'Dosis/jumlah Unit resep tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['dosage_inst_frequency'])){
        echo json_encode(['status' => 'error','message' => 'Informasi frekuensi pemakaian tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['dosage_inst_period'])){
        echo json_encode(['status' => 'error','message' => 'Interval waktu pemakaian tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['dosage_inst_period_unit'])){
        echo json_encode(['status' => 'error','message' => 'Satuan waktu frekuensi pemakaian tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['route_code'])){
        echo json_encode(['status' => 'error','message' => 'Cara pemakaian / Cara obat masuk ke dalam tubuh tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['dispense_value'])){
        echo json_encode(['status' => 'error','message' => 'Jumlah total obat yang diserahkan kepada pasien tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['dispense_code'])){
        echo json_encode(['status' => 'error','message' => 'Satuan jumlah total obat yang diserahkan kepada pasien tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['supply_duration_value'])){
        echo json_encode(['status' => 'error','message' => 'Durasi waktu, lama obat dikonsumsi tidak boleh kosong!']);
        exit;
    }
    if(empty($_POST['supply_duration_code'])){
        echo json_encode(['status' => 'error','message' => 'satuan waktu lama obat dikonsumsi tidak boleh kosong!']);
        exit;
    }

    // Buat Variabelnya
    $id_medication_request_group = validateAndSanitizeInput($_POST['id_medication_request_group']);
    $intent                      = validateAndSanitizeInput($_POST['intent']);
    $racikan_code                = validateAndSanitizeInput($_POST['racikan_code']);
    $name_medication             = validateAndSanitizeInput($_POST['name_medication']);
    $dosage_inst_text            = validateAndSanitizeInput($_POST['dosage_inst_text']);
    $dose_value                  = validateAndSanitizeInput($_POST['dose_value']);
    $dose_code                   = validateAndSanitizeInput($_POST['dose_code']);
    $dosage_inst_frequency       = validateAndSanitizeInput($_POST['dosage_inst_frequency']);
    $dosage_inst_period          = validateAndSanitizeInput($_POST['dosage_inst_period']);
    $dosage_inst_period_unit     = validateAndSanitizeInput($_POST['dosage_inst_period_unit']);
    $route_code                  = validateAndSanitizeInput($_POST['route_code']);
    $dispense_value              = validateAndSanitizeInput($_POST['dispense_value']);
    $dispense_code               = validateAndSanitizeInput($_POST['dispense_code']);
    $supply_duration_value       = validateAndSanitizeInput($_POST['supply_duration_value']);
    $supply_duration_code        = validateAndSanitizeInput($_POST['supply_duration_code']);

    // Apabila 'id_medication'
    if(empty($_POST['id_medication'])){
        $id_medication ="";
    }else{
        $id_medication = validateAndSanitizeInput($_POST['id_medication']);
    }

    // Routing ingredients
    if ($racikan_code === "NC") {

        $ingredients = null;

    } else {

        if (empty($_POST['payload_ingridient'])) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Untuk obat racikan, ingredient wajib diisi!'
            ]);
            exit;
        }

        $ingredientsArray = [];

        foreach ($_POST['payload_ingridient'] as $item) {

            // bersihkan whitespace
            $item = trim($item);

            // kalau JSON masih terbungkus tanda kutip (double encoded)
            if ($item !== '' && $item[0] === '"' && substr($item, -1) === '"') {
                $item = json_decode($item);
            }

            // decode JSON ke array
            $decoded = json_decode($item, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode([
                    'status'  => 'error',
                    'message' => 'Format ingredient tidak valid',
                    'debug'   => $item,
                    'json_error' => json_last_error_msg()
                ]);
                exit;
            }

            $ingredientsArray[] = $decoded;
        }

        // encode ulang → VALID JSON ARRAY OF OBJECT
        $ingredients = json_encode(
            $ingredientsArray,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }


    // Mendefinisikan racikan_list
    $racikan_list =[
        'NC' => 'Non-compound',
        'SD' => 'Gives of such doses',
        'EP' => 'Divide into equal parts',
    ];
    $racikan_display = $racikan_list[$racikan_code];

    // Mendefinisikasn 'dose_code'
    $dose_unit   = GetDetailData($Conn, 'referensi_satuan_dosis', 'code_satuan_dosis', $dose_code, 'unit_satuan_dosis');
    $dose_system = GetDetailData($Conn, 'referensi_satuan_dosis', 'code_satuan_dosis', $dose_code, 'system_satuan_dosis');

    // Mendefinisikasn 'dosage_inst_period_unit'
    $parts                           = explode('|', $dosage_inst_period_unit);
    $dosage_inst_period_unit_code    = $parts[0] ?? null;
    $dosage_inst_period_unit_display = $parts[1] ?? null;

    // Mendefinisikasn 'route_code'
    $route_display = GetDetailData($Conn, 'referensi_route', 'code_route', $route_code, 'display_route');
    $route_system  = GetDetailData($Conn, 'referensi_route', 'code_route', $route_code, 'system_route');

    // Mendefinisikasn 'dispense_code'
    $dispense_unit = GetDetailData($Conn, 'referensi_satuan_dosis', 'code_satuan_dosis', $dispense_code, 'unit_satuan_dosis');
    $dispense_sys  = GetDetailData($Conn, 'referensi_satuan_dosis', 'code_satuan_dosis', $dispense_code, 'system_satuan_dosis');

    // Mendefinisikan 'supply_duration_code'
    $parts2                  = explode('|', $supply_duration_code);
    $supply_duration_code    = $parts2[0] ?? null;
    $supply_duration_display = $parts2[1] ?? null;

    // Buat 'kode_medication_request'
    $kode_medication_request = generateUUIDv4();

    // Inisiasi Status
    $status = "active";

    // Inisiaslisasi $supply_duration_sys
    $supply_duration_sys = "http://unitsofmeasure.org";

    // Proses Insert Ke Database
    try {
        $query = "INSERT INTO  medication_request (
            kode_medication_request,
            id_medication_request_group,
            intent,
            id_medication,
            name_medication,
            status,
            dosage_inst_text,
            dosage_inst_frequency,
            dosage_inst_period,
            dosage_inst_period_unit,
            dose_value,
            dose_unit,
            dose_code,
            dose_system,
            route_display,
            route_code,
            route_system,
            dispense_value,
            dispense_unit,
            dispense_code,
            dispense_sys,
            supply_duration_value,
            supply_duration_unit,
            supply_duration_code,
            supply_duration_sys,
            racikan_code,
            racikan_display,
            ingredient
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )";
        
        $stmt = $Conn->prepare($query);
        
        // Bind parameters
        $stmt->bind_param(
            "ssssssssssssssssssssssssssss",
            $kode_medication_request,
            $id_medication_request_group,
            $intent,
            $id_medication,
            $name_medication,
            $status,
            $dosage_inst_text,
            $dosage_inst_frequency,
            $dosage_inst_period,
            $dosage_inst_period_unit_code,
            $dose_value,
            $dose_unit,
            $dose_code,
            $dose_system,
            $route_display,
            $route_code,
            $route_system,
            $dispense_value,
            $dispense_unit,
            $dispense_code,
            $dispense_sys,
            $supply_duration_value,
            $supply_duration_display,
            $supply_duration_code,
            $supply_duration_sys,
            $racikan_code,
            $racikan_display,
            $ingredients
        );
        
        if($stmt->execute()){
            // Tangkap 'id_medication_request_group' setelah berhasil
            $id_medication_request_group = $Conn->insert_id;
            echo json_encode([
                'status' => 'success',
                'message' => 'Item Resep berhasil ditambahkan!',
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal menyimpan data: ' . $stmt->error
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