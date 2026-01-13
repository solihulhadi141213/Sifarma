<div class="row mb-3">
    <div class="col-md-5"><label for="medication_category_manual"><small>Kategori Data</small></label></div>
    <div class="col-md-7">
        <select name="medication_category" id="medication_category_manual" class="form-control" required>
            <option value="">Pilih Kategori</option>
            <option value="Obat">Obat</option>
            <option value="Alkes">Alkes</option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-5"><label for="medication_code_manual"><small>Kode Lokal</small></label></div>
    <div class="col-md-7">
        <div class="input-group">
            <input type="text" disabled name="medication_code" id="medication_code_manual" class="form-control" required>
            <button class="input-group-text generate_kode_lokal" id="generate_kode_lokal" disabled data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Generate Kode Lokal">
                <i class="bi bi-repeat"></i>
            </button>
        </div>
        <small>
            <small class="text text-grayish">Kode lokal obat/alkes yang di gunakan pada faskes</small>
        </small>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-5"><label for="id_medication_manual"><small><i>ID Medication</i></small></label></div>
    <div class="col-md-7">
        <input type="text" disabled name="id_medication" id="id_medication_manual" class="form-control">
        <div class="form-check">
            <input class="form-check-input" disabled type="checkbox" name="insert_medication" id="insert_medication" value="true">
            <label class="form-check-label" for="insert_medication">
                <small>
                    <small class="text text-grayish">Kirim resource <i>ID Medication</i> Ke Satu Sehat</small>
                </small>
            </label>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-5"><label for="medication_name_manual"><small>Nama/Merek</small></label></div>
    <div class="col-md-7">
        <input type="text" disabled name="medication_name" id="medication_name_manual" class="form-control" required>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-5"><label for="racikan_code"><small>Kategori Racikan</small></label></div>
    <div class="col-md-7">
        <select name="racikan_code" disabled id="racikan_code" class="form-control">
            <option value="">Pilih</option>
            <option value="NC">Obat pabrikan</option>
            <option value="SD">Racikan, dosis beda</option>
            <option value="EP">Racikan, dosis sama</option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-5"><label for="kfa_manual"><small>Kamus Farmasi/Alkes (KFA)</small></label></div>
    <div class="col-md-7">
        <select disabled name="kfa" id="kfa_manual" class="form-control">
            <option value="">Pilih</option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-5"><label for="sediaan_manual"><small>Sediaan</small></label></div>
    <div class="col-md-7">
        <select disabled name="sediaan" id="sediaan_manual" class="form-control" required>
            <option value="">Pilih</option>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-5"><label for="manufaktur_manual"><small><i>Manufacturer</i></small></label></div>
    <div class="col-md-7">
        <select disabled name="manufaktur" id="manufaktur_manual" class="form-control">
            <option value="">Pilih</option>
        </select>
    </div>
</div>
<div class="row mb-2 mt-3">
    <div class="col-md-12">
        <button type="button" disabled class="btn btn-md btn-block btn-secondary" id="modal_tambah_ingridient">
            <i class="bi bi-plus"></i> Tambah Ingredient
        </button>
    </div>
</div>
<div class="row mb-2">
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
                    <tr>
                        <td colspan="6" class="text-center">
                            <small>Konten Belum Ada</small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>