<!-- 
==========================================================================================
FILTER DATA 
==========================================================================================
-->
<div class="modal fade" id="ModalFilter" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesFilter">
                <input type="hidden" name="page" id="page" value="1">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-funnel"></i> Filter Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="batas">
                                <small>Limit</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="OrderBy">
                                <small>Dasar Urutan</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="OrderBy" id="OrderBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="medication_code">Kode</option>
                                <option value="medication_name">Nama Obat/Alkes</option>
                                <option value="medication_category">Kategori</option>
                                <option value="sediaan_display">Sediaan</option>
                                <option value="kfa_code">KFA</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="ShortBy">
                                <small>Tipe Urutan</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="ShortBy" id="ShortBy" class="form-control">
                                <option value="ASC">A To Z</option>
                                <option selected value="DESC">Z To A</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="KeywordBy">
                                <small>Dasar Pencarian</small>
                            </label>
                        </div>
                        <div class="col-8">
                            <select name="keyword_by" id="KeywordBy" class="form-control">
                                <option value="">Pilih</option>
                                <option value="medication_code">Kode</option>
                                <option value="medication_name">Nama Obat/Alkes</option>
                                <option value="medication_category">Kategori</option>
                                <option value="sediaan_display">Sediaan</option>
                                <option value="kfa_code">KFA</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="keyword">
                                <small>Kata Kunci</small>
                            </label>
                        </div>
                        <div class="col-8" id="FormFilter">
                            <input type="text" name="keyword" id="keyword" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-check"></i> Tampilkan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- 
==========================================================================================
FILTER DATA 
==========================================================================================
-->
<div class="modal fade" id="ModalCariKfa" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-search"></i> Cari KFA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <form action="javascript:void(0);" id="ProsesCariKfa" autocomplete="off">
                    <input type="hidden" name="page" id="page_kfa" value="1">
                    <div class="row mb-3 border-1 border-bottom">
                        <div class="col-md-2 mb-2">
                            <select name="versi_pencarian" id="versi_pencarian" class="form-control">
                                <option value="">Pilih Versi</option>
                                <option value="V1">V1</option>
                                <option selected value="V2">V2</option>
                                <option value="V3">V3</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select name="kategori_pencarian" id="kategori_pencarian" class="form-control">
                                <option value="">Pilih Kategori</option>
                                <option selected value="farmasi">Obat</option>
                                <option value="alkes">Alkes</option>
                            </select>
                        </div>
                        <div class="col-md-7 mb-2">
                            <div class="input-group">
                                <input type="text" name="keyword_pencarian" id="keyword_pencarian" class="form-control" placeholder="Kata Kunci Pencarian">
                            </div>
                        </div>
                        <div class="col-md-1 mb-2">
                            <div class="input-group">
                                <button type="submit" class="btn btn-lg btn-primary btn-block">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="table table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td class="text-center"><b>No</b></td>
                                        <td><b>Produk Obat/Alkes</b></td>
                                        <td><b>KFA</b></td>
                                        <td class="text-center"><b>Opsi</b></td>
                                    </tr>
                                </thead>
                                <tbody id="tabel_kfa">
                                    <tr>
                                        <td colspan="4" class="text-center">Loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button_kfa">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-info btn-rounded" id="page_info_kfa">0 / 0</button>
                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button_kfa">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<!-- 
==========================================================================================
TAMBAH MEDICATION DARI KFA
==========================================================================================
-->
<div class="modal fade" id="ModalTambahMedicationKfa" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahMedicationKfa" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Obat / Alkes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormTambahMedicationKfa">
                            <!-- Form Proses -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiTambahMedicationKfa">
                            <!-- Notifikasi Proses -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 
==========================================================================================
TAMBAH MEDICATION MANUAL
==========================================================================================
-->
<div class="modal fade" id="ModalTambahManual" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambahManual" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Obat / Alkes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-5"><small><b>A. Informasi Umum</b></small></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-5"><label for="medication_code_manual"><small>Kode Lokal</small></label></div>
                        <div class="col-md-7">
                            <div class="input-group">
                                <input type="text" name="medication_code" id="medication_code_manual" class="form-control">
                                <a href="javascript:void(0)" class="input-group-text generate_kode_lokal" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Generate Kode Lokal">
                                    <i class="bi bi-repeat"></i>
                                </a>
                            </div>
                            <small>
                                <small class="text text-grayish">Kode lokal obat/alkes yang di gunakan pada faskes</small>
                            </small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-5"><label for="id_medication_manual"><small><i>ID Medication</i></small></label></div>
                        <div class="col-md-7">
                            <input type="text" name="id_medication" id="id_medication_manual" class="form-control">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="insert_medication" id="insert_medication" value="true">
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
                            <input type="text" name="medication_name" id="medication_name_manual" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-5"><label for="medication_category_manual"><small>Kategori</small></label></div>
                        <div class="col-md-7">
                            <select name="medication_category" id="medication_category_manual" class="form-control">
                                <option value="">Pilih Kategori</option>
                                <option value="Obat">Obat</option>
                                <option value="Alkes">Alkes</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-5"><label for="racikan_code"><small>Kategori Racikan</small></label></div>
                        <div class="col-md-7">
                            <select name="racikan_code" id="racikan_code" class="form-control">
                                <option value="">Pilih</option>
                                <option value="NC">Non-compound</option>
                                <option value="C">Compound</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3 mt-3">
                        <div class="col-12"><small><b>B. Kamus Farmasi & Alat Kesehatan (KFA)</b></small></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-5"><label for="kfa_code_manual"><small>Kode KFA</small></label></div>
                        <div class="col-md-7">
                            <input type="text" name="kfa_code" id="kfa_code_manual" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-5"><label for="kfa_display_manual"><small>Nama KFA</small></label></div>
                        <div class="col-md-7">
                            <input type="text" name="kfa_display" id="kfa_display_manual" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row mb-3 mt-3">
                        <div class="col-12"><small><b>C. Informasi Sediaan</b></small></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-5"><label for="sediaan_code"><small>Kode Sediaan</small></label></div>
                        <div class="col-md-7">
                            <input type="text" name="sediaan_code" id="sediaan_code" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-5"><label for="sediaan_display"><small>Nama Sediaan</small></label></div>
                        <div class="col-md-7">
                            <input type="text" name="sediaan_display" id="sediaan_display" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row mb-3 mt-3">
                        <div class="col-5"><small><b>D. Manufaktur</b></small></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-5"><label for="manufacturer_id"><small><i>ID Manufacturer</i></small></label></div>
                        <div class="col-md-7">
                            <input type="text" name="manufacturer_id" id="manufacturer_id" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-5"><label for="manufacturer_name_manual"><small><i>Manufacturer Name</i></small></label></div>
                        <div class="col-md-7">
                            <input type="text" name="manufacturer_name" id="manufacturer_name_manual" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row mb-3 mt-3">
                        <div class="col-12"><small><b><i>E. Ingredient</i></b></small></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiTambahManual">
                            <!-- Notifikasi Proses -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 
==========================================================================================
DETAIL MEDICATION
==========================================================================================
-->
<div class="modal fade" id="ModalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Detail Obat/Alkes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetail">
                        <!-- Form Proses -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-rounded">
                    Selengkapnya <i class="bi bi-chevron-right"></i>
                </button>
                <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
