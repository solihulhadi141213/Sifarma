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


?>
<input type="hidden" name="id_medication_request_group" value="<?php echo "$id_medication_request_group"; ?>">
<div class="row mb-3">
    <div class="col-md-12">
        <b>A. Informasi Resep</b>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="intent"><small>Tujuan Resep</small></label>
    </div>
    <div class="col-md-8">
        <select name="intent" id="intent" class="form-control" required>
            <option value="order">Permintaan (Order)</option>
            <option value="plan">Rencana (Plan)</option>
            <option value="proposal">Pengajuan (Proposal)</option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="racikan_code"><small>Tipe Resep</small></label>
    </div>
    <div class="col-md-8">
        <select name="racikan_code" id="racikan_code" class="form-control" required>
            <option value="NC">Obat Pabrikan</option>
            <option value="SD">Racikan, dosis beda</option>
            <option value="EP">Racikan, dosis sama</option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="intent"><small>Tujuan Resep</small></label>
    </div>
    <div class="col-md-8">
        <select name="intent" id="intent" class="form-control" required>
            <option value="order">Permintaan (Order)</option>
            <option value="plan">Rencana (Plan)</option>
            <option value="proposal">Pengajuan (Proposal)</option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="id_medication"><small><i>ID Medication</i></small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="id_medication" id="id_medication" class="form-control">
        <small>Kode Obat/Alkes Dari Satu Sehat</small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="name_medication"><small><i>Nama Obat/Alkes</i></small></label>
    </div>
    <div class="col-md-8">
        <input type="text" name="name_medication" id="name_medication" class="form-control">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="dosage_inst_text"><small>Instruksi</small></label>
    </div>
    <div class="col-md-8">
       <textarea name="dosage_inst_text" id="dosage_inst_text" class="form-control"></textarea>
       <small>Contoh : Diminum setelah makan, pagi, siang dan malam</small>
    </div>
</div>
<div class="row mb-3 mt-3">
    <div class="col-md-12">
        <small><b>B. Dosis, Frekuensi, Interval, Route</b></small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="dose_value"><small><i>Dosis Obat</i></small></label>
    </div>
    <div class="col-md-8">
        <input type="number" step="0.01" min="0" name="dose_value" id="dose_value" class="form-control">
        <small>Jumlah dosis obat per satuan</small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="dose_unit"><small><i>Satuan</i></small></label>
    </div>
    <div class="col-md-8">
        <select name="dose_unit" id="dose_unit" class="form-control">
            <option value="">Pilih</option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="dosage_inst_frequency"><small><i>Frequency</i></small></label>
    </div>
    <div class="col-md-8">
        <input type="number" step="1" min="0" name="dosage_inst_frequency" id="dosage_inst_frequency" class="form-control">
        <small>Jumlah Berapa Kali Obat Diminum Dalam Sehari (satuan Waktu)</small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="dosage_inst_period"><small><i>Interval</i></small></label>
    </div>
    <div class="col-md-8">
        <input type="number" step="1" min="0" name="dosage_inst_period" id="dosage_inst_period" class="form-control" value="1">
        <small>Interval waktu obat yang diminum (Dikonsumsi, Digunakan, Dimasukan Ke Tubuh)</small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="dosage_inst_period_unit"><small><i>Satuan Waktu</i></small></label>
    </div>
    <div class="col-md-8">
        <select name="dosage_inst_period_unit" id="dosage_inst_period_unit" class="form-control">
            <option value="h">Jam (Hour)</option>
            <option selected value="d">Hari (Day)</option>
            <option value="wk">Minggu (Week)</option>
            <option value="mo">Bulan (Month)</option>
        </select>
        <small>Unit satuan waktu yang digunakan</small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-4">
        <label for="route_code"><small><i>Route</i></small></label>
    </div>
    <div class="col-md-8">
        <select name="route_code" id="route_code" class="form-control">
            <option value="">Pilih</option>
        </select>
        <small>Cara obat masuk (Dikonsumsi)</small>
    </div>
</div>