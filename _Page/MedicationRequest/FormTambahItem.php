<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");

    // Validasi Session
    if(empty($SessionIdAccess)){
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Validasi id_medication_request_group
    if(empty($_POST['id_medication_request_group'])){
        echo '
            <div class="alert alert-danger text-center">
                <small>ID Resep Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }
    $id_medication_request_group = $_POST['id_medication_request_group'];

    // Jika ada item Medication Yang Dipilih
    $id_medication       = "";
    $racikan_code        = "";
    $medication_name     = "";
    $ingredient          = "";
    if(!empty($_POST['id'])){
        $id=$_POST['id'];

        // Buka Dari Database
        $Qry = $Conn->prepare("SELECT * FROM medication WHERE id = ?");
        $Qry->bind_param("i", $id);
        if (!$Qry->execute()) {
            echo '
                <div class="alert alert-danger">
                    <small>Terjadi kesalahan saat membuka data <i>Medication</i>!<br>
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
        $id_medication       = $Data['id_medication'];
        $racikan_code        = $Data['racikan_code'];
        $medication_name     = $Data['medication_name'];
        $ingredient          = $Data['ingredient'];
    }


?>
<input type="hidden" name="id_medication_request_group" value="<?php echo "$id_medication_request_group"; ?>">
<div class="row mb-3">
    <div class="col-md-12">
        <b>A. Informasi Resep</b>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4 mb-2">
        <label for="intent"><small>* Tujuan Resep</small></label>
    </div>
    <div class="col-md-8 mb-2">
        <select name="intent" id="intent" class="form-control" required>
            <option value="order">Permintaan (Order)</option>
            <option value="plan">Rencana (Plan)</option>
            <option value="proposal">Pengajuan (Proposal)</option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4 mb-2">
        <label for="racikan_code"><small>* Tipe Resep</small></label>
    </div>
    <div class="col-md-8 mb-2">
        <select name="racikan_code" id="racikan_code" class="form-control" required>
            <option <?php if($racikan_code=="NC"){echo "selected";} ?> value="NC">Obat Pabrikan</option>
            <option <?php if($racikan_code=="SD"){echo "selected";} ?> value="SD">Racikan, dosis beda</option>
            <option <?php if($racikan_code=="EP"){echo "selected";} ?> value="EP">Racikan, dosis sama</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4 mb-2">
        <label for="id_medication"><small><i>ID Medication</i></small></label>
    </div>
    <div class="col-md-8">
        <input type="text mb-2" name="id_medication" id="id_medication" class="form-control" value="<?php echo "$id_medication"; ?>">
        <small>Kode Obat/Alkes Dari Satu Sehat</small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4 mb-2">
        <label for="name_medication"><small><i>* Nama Obat/Alkes</i></small></label>
    </div>
    <div class="col-md-8 mb-2">
        <input type="text" name="name_medication" id="name_medication" class="form-control" required value="<?php echo "$medication_name"; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4 mb-2">
        <label for="dosage_inst_text"><small>* Instruksi</small></label>
    </div>
    <div class="col-md-8 mb-2">
       <textarea name="dosage_inst_text" id="dosage_inst_text" class="form-control" required></textarea>
       <small><small>Contoh : Diminum setelah makan, pagi, siang dan malam</small></small>
    </div>
</div>
<div class="row mb-3 mt-3">
    <div class="col-md-12">
        <small><b>B. Dosis, Frekuensi, Interval, Route</b></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4 mb-2">
        <label for="dose_value"><small><i>* Dosis Obat</i></small></label>
    </div>
    <div class="col-md-5 mb-2">
        <input type="number" step="0.01" min="0" name="dose_value" id="dose_value" required class="form-control">
        <small><small>* Jumlah dosis obat per sekali digunakan</small></small>
    </div>
    <div class="col-md-3 mb-2">
        <select name="dose_code" id="dose_code" class="form-control select_satuan" required>
            <option value="">Pilih Satuan</option>
        </select>
        <small><small>* Unit satuan dosis</small></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4 mb-2">
        <label for="dosage_inst_frequency"><small><i>* Frequency</i></small></label>
    </div>
    <div class="col-md-8 mb-2">
        <input type="number" step="1" min="0" name="dosage_inst_frequency" id="dosage_inst_frequency" class="form-control" required>
        <small><small>* Jumlah Berapa Kali Obat Diminum Dalam Sehari (satuan Waktu)</small></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4 mb-2">
        <label for="dosage_inst_period"><small><i>* Interval</i></small></label>
    </div>
    <div class="col-md-5 mb-2">
        <input type="number" step="1" min="0" name="dosage_inst_period" id="dosage_inst_period" class="form-control" value="1" required>
        <small><small>Interval waktu per setiap frekuensi obat yang diminum (Dikonsumsi, Digunakan, Dimasukan Ke Tubuh)</small></small>
    </div>
    <div class="col-md-3 mb-2">
        <select name="dosage_inst_period_unit" id="dosage_inst_period_unit" class="form-control" required>
            <option value="s|second">Detik (Second)</option>
            <option value="m|minute">Menit (Minute)</option>
            <option value="h|hour">Jam (Hour)</option>
            <option selected value="d|day">Hari (Day)</option>
            <option value="wk|week">Minggu (Week)</option>
            <option value="mo|month">Bulan (Month)</option>
        </select>
        <small><small>* Satuan waktu yang digunakan</small></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4 mb-2">
        <label for="route_code"><small><i>* Route</i></small></label>
    </div>
    <div class="col-md-8 mb-2">
        <select name="route_code" id="route_code" class="form-control" required>
            <option value="">Pilih</option>
            <?php
                $query_route = mysqli_query($Conn,"SELECT nama_route, code_route FROM referensi_route ORDER BY nama_route ASC");
                while ($data_route = mysqli_fetch_array($query_route)) {
                    echo '<option value="'.$data_route['code_route'].'">'
                    . htmlspecialchars($data_route['nama_route'])
                    . '</option>';
                }
            ?>
        </select>
        <small><small>Cara obat masuk ke dalam tubuh (Dikonsumsi)</small></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4 mb-2">
        <label for="dispense_value"><small><i>* Dispense Value</i></small></label>
    </div>
    <div class="col-md-5 mb-2">
        <input type="number" step="1" min="0" name="dispense_value" id="dispense_value" class="form-control" required>
        <small><small>Jumlah Total Obat Yang Harus Diserahkan Kepada Pasien</small></small>
    </div>
    <div class="col-md-3 mb-2">
        <select name="dispense_code" id="dispense_code" class="form-control select_satuan">
            <option value="">Pilih Satuan</option>
        </select>
        <small><small>Satuan Obat Yang Diserahkan</small></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4 md-2">
        <label for="supply_duration_value"><small><i>* Supply Duration Value</i></small></label>
    </div>
    <div class="col-md-5 md-2">
        <input type="number" step="1" min="0" name="supply_duration_value" id="supply_duration_value" class="form-control" required>
        <small><small>* Durasi waktu / berapa lama obat harus dikonsumsi</small></small>
    </div>
    <div class="col-md-3 md-2">
        <select name="supply_duration_code" id="supply_duration_code" class="form-control" required>
            <option value="s|second">Detik (Second)</option>
            <option value="m|minute">Menit (Minute)</option>
            <option value="h|hour">Jam (Hour)</option>
            <option selected value="d|day">Hari (Day)</option>
            <option value="wk|week">Minggu (Week)</option>
            <option value="mo|month">Bulan (Month)</option>
        </select>
        <small><small>Satuan waktu</small></small>
    </div>
</div>

<div class="row mb-3 mt-3">
    <div class="col-md-12">
        <small><b>C. Ingredient (Untuk Obat Racikan)</b></small>
    </div>
</div>
<div class="row mb-3 mt-3">
    <div class="col-md-12">
        <button type="button" disabled class="btn btn-md btn-block btn-secondary" id="modal_tambah_ingridient">
            <i class="bi bi-plus"></i> Tambah Ingredient
        </button>
    </div>
</div>
<div class="row mb-2 mt-3">
    <div class="col-md-12" id="table_ingridient">
        <div class="table table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <td class="text-center"><small><b>No</b></small></td>
                        <td><small><b>Kode</b></small></td>
                        <td><small><b>Nama</b></small></td>
                        <td class="text-center"><small><b>Numerator</b></small></td>
                        <td class="text-center"><small><b>Denominator</b></small></td>
                        <td class="text-center"><small><b>Opsi</b></small></td>
                    </tr>
                </thead>
                <tbody id="table_list_ingridient">
                    <?php
                        if(!empty($ingredient)){
                            $ingredient_arry = json_decode($ingredient, true);
                            if(empty(count($ingredient_arry))){
                                echo '
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <small>Item Tidak Memiliki Daftar Ingredient</small>
                                        </td>
                                    </tr>
                                ';
                            }else{
                                $no = 1;
                                foreach($ingredient_arry as $ingredient_list){
                                    $payload_ingredient_item = [
                                        "kode_kfa" => $ingredient_list['kode_kfa'],
                                        "nama_kfa" => $ingredient_list['nama_kfa'],
                                        "kode_numerator" => $ingredient_list['kode_numerator'],
                                        "nama_numerator" => $ingredient_list['nama_numerator'],
                                        "jumlah_numerator" => $ingredient_list['jumlah_numerator'],
                                        "kode_denominator" => $ingredient_list['kode_denominator'],
                                        "nama_denominator" => $ingredient_list['nama_denominator'],
                                        "jumlah_denominator" => $ingredient_list['jumlah_denominator']
                                    ];
                                    $ingredient_item = htmlspecialchars(
                                        json_encode($payload_ingredient_item, JSON_UNESCAPED_UNICODE),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );
                                    echo '
                                        <tr>
                                            <td class="text-center"><small>'.$no.'</small></td>
                                            <td><small>'.$ingredient_list['kode_kfa'].'</small></td>
                                            <td><small>'.$ingredient_list['nama_kfa'].'</small></td>
                                            <td class="text-center"><small>'.$ingredient_list['jumlah_numerator'].' '.$ingredient_list['nama_numerator'].'</small></td>
                                            <td class="text-center"><small>'.$ingredient_list['jumlah_denominator'].' '.$ingredient_list['nama_denominator'].'</small></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-danger btn-sm btn-hapus-ingridient" title="Hapus Ingridient">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                                <input type="hidden" name="payload_ingridient[]" value="'.$ingredient_item.'">
                                            </td>
                                        </tr>
                                    ';
                                    $no++;
                                }
                            }
                        }else{
                            echo '
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <small>Tidak Ada Daftar Ingredient</small>
                                    </td>
                                </tr>
                            ';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>