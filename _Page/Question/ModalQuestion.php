<!-- 
==========================================================================================
TAMBAH PERTANYAAN
==========================================================================================
-->
<div class="modal fade" id="ModalTambah" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesTambah" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah PERTANYAAN Obat / Alkes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="question_group">Kategori Pertanyaan</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="question_group" id="question_group" list="list_kategori" class="form-control" placeholder="">
                            <datalist id="list_kategori"></datalist>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="question_text">Text Pertanyaan</label>
                        </div>
                         <div class="col-md-8">
                            <input type="text" name="question_text" id="question_text" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="question_type">Tipe Pertanyaan</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control" name="question_type" id="question_type">
                                <option value = "">Pilih</option>
                                <option value = "boolean">Boolean</option>
                                <option value = "choice">Choice</option>
                                <option value = "text">Text</option>
                                <option value = "decimal">Decimal</option>
                                <option value = "integer">Integer</option>
                                <option value = "date">Date</option>
                                <option value = "url">URL</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="kirim_ke_satu_sehat" id="kirim_ke_satu_sehat" value="Ya" checked="">
                                <label class="form-check-label" for="kirim_ke_satu_sehat">
                                    <small>Generate ID Questionnaire Dari Satu Sehat</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 mt-3" id="form_alternatif">
                        <div class="col-12 mb-3">
                            <label><b>Alternatif Jawaban</b></label>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="table table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr class="border-top border-1">
                                            <td class="text-center"><b>No</b></td>
                                            <td class="text-center"><b>Value / Nilai</b></td>
                                            <td class="text-center"><b>Option Display</b></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-md btn-primary tambah_alternatif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Tambah Alternatif Jawaban">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody id="list_alternatif">
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td>
                                                <input type="text" name="alternatif_value[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="alternatif_display[]" class="form-control">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-md btn-danger hapus_alternatif" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hapus Alternatif Jawaban">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td>
                                                <input type="text" name="alternatif_value[]" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="alternatif_display[]" class="form-control">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-md btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Hapus Alternatif Jawaban">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiTambah">
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
DETAIL PERTANYAAN
==========================================================================================
-->
<div class="modal fade" id="ModalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Referensi Pertanyaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetail">
                        <!-- Form Edit -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalDetailSatuSehat" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Questionnaire (Satu Sehat)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" id="FormDetailSatuSehat">
                        <!-- Form Edit -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 
==========================================================================================
EDIT PERTANYAAN
==========================================================================================
-->
<div class="modal fade" id="ModalEdit" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEdit" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Referensi Pertanyaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEdit">
                            <!-- Form Edit -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEdit">
                            <!-- Notifikasi Edit -->
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

<div class="modal fade" id="ModalEditKategori" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditKategori" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Kategori Pertanyaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditKategori">
                            <!-- Form Edit -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditKategori">
                            <!-- Notifikasi Edit -->
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
HAPUS PERTANYAAN
==========================================================================================
-->
<div class="modal fade" id="ModalHapus" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapus" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Pertanyaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapus">
                            <!-- Form Edit -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiHapus">
                            <!-- Notifikasi Edit -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-check"></i> Ya, Hapus
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
GENERATE ID PERTANYAAN DARI SATU SEHAT
==========================================================================================
-->
<div class="modal fade" id="ModalGenerateSatuSehat" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesGenerateSatuSehat" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Generate ID Questionnaire</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormGenerateSatuSehat">
                            <!-- Form Edit -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiGenerateSatuSehat">
                            <!-- Notifikasi Edit -->
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

