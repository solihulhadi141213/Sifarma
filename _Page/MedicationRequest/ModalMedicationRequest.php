<!-- MODAL FILTER -->
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
                                <option value="id_pasien">No.RM</option>
                                <option value="pasien_nama">Nama Pasien</option>
                                <option value="datetime_creat">Tanggal Kunjungan</option>
                                <option value="kunjungan_tujuan">Tujuan Kunjungan</option>
                                <option value="kunjungan_pembayaran">Metode Pembayaran</option>
                                <option value="priority">Priority</option>
                                <option value="dokter_kode">Dokter</option>
                                <option value="status_resep">Status</option>
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
                                <option value="id_pasien">No.RM</option>
                                <option value="pasien_nama">Nama Pasien</option>
                                <option value="datetime_creat">Tanggal Kunjungan</option>
                                <option value="kunjungan_tujuan">Tujuan Kunjungan</option>
                                <option value="kunjungan_pembayaran">Metode Pembayaran</option>
                                <option value="priority">Priority</option>
                                <option value="dokter_kode">Dokter</option>
                                <option value="status_resep">Status</option>
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

<div class="modal fade" id="ModalKunjungan" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header nav_background">
                <h5 class="modal-title text-light"><i class="bi bi-search"></i> Pilih Kunjungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">

                <!-- FILTER (STICKY) -->
                <div class="p-3 border-bottom bg-white sticky-top" style="z-index: 10;">
                    <form action="javascript:void(0);" id="ProsesFilterKunjungan">
                        <input type="hidden" name="page" id="page_kunjungan" value="1">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="keyword" id="keyword_kunjungan" placeholder="No RM / Nama pasien">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- TABEL (SCROLLABLE) -->
                <div class="p-3" style="height: calc(100vh - 260px); overflow-y: auto;">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="fw-bold">No</th>
                                    <th class="fw-bold">No.RM</th>
                                    <th class="fw-bold">Nama Pasien</th>
                                    <th class="fw-bold">Tgl/Jam</th>
                                    <th class="fw-bold">Tujuan</th>
                                    <th class="fw-bold">Ruangan/Poli</th>
                                    <th class="fw-bold">Encounter</th>
                                    <th class="fw-bold">Status</th>
                                </tr>
                            </thead>
                            <tbody id="TabelKunjungan">
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <small>Tidak Ada Data Yang Ditampilkan</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="modal-footer nav_background d-flex justify-content-between align-items-center">

                <!-- PAGINATION -->
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-info" id="prev_button_kunjungan">
                        <i class="bi bi-chevron-left"></i>
                    </button>

                    <span class="btn btn-sm btn-outline-info disabled" id="page_info_kunjungan">
                        0 / 0
                    </span>

                    <button type="button" class="btn btn-sm btn-info" id="next_button_kunjungan">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>

                <!-- CLOSE -->
                <button type="button" class="btn btn-sm btn-secondary btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>

            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH RESEP -->
 <div class="modal fade" id="ModalTambahResep" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border border-2 border-black">
            <form action="javascript:void(0);" id="ProsesTambahResep" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Resep</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormTambahResep">
                            <!-- Form Proses -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiTambahResep">
                            <!-- Notifikasi Proses -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="ButtonTambahResep">
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

<!-- MODAL DETAIL RESEP -->
<div class="modal fade" id="ModalDetailResep" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesDetail" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-info-circle"></i> Detail Resep</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormDetailResep">
                            <!-- Form Proses -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary btn-rounded">
                        Selengkapnya <i class="bi bi-chevron-right"></i>
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT RESEP -->
<div class="modal fade" id="ModalEditResep" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesEditResep" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-pencil"></i> Edit Resep</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormEditResep">
                            <!-- Form Proses -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiEditResep">
                            <!-- Notifikasi Proses -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="button_edit_resep">
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

<!-- MODAL HAPUS RESEP -->
<div class="modal fade" id="ModalHapusResep" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0);" id="ProsesHapusResep" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-trash"></i> Hapus Resep</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormHapusResep">
                            <!-- Form Proses -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiHapusResep">
                            <!-- Notifikasi Proses -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="button_hapus_resep">
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

<!-- MODAL ITEM OBAT/ALKES -->
<div class="modal fade" id="ModalItemObat" tabindex="-1">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header nav_background">
                <h5 class="modal-title text-light"><i class="bi bi-search"></i> Pilih Obat/Alkes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">

                <!-- FILTER (STICKY) -->
                <div class="p-3 border-bottom bg-white sticky-top" style="z-index: 10;">
                    <form action="javascript:void(0);" id="ProsesFilterObatAlkes">
                        <input type="hidden" name="page" id="page_obat_alkes" value="1">
                        <input type="hidden" name="id_medication_request_group" id="put_id_medication_request_group" value="">
                        <div class="row">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="keyword" id="keyword_obat_alkes" placeholder="Cari Obat/Alkes">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- TABEL (SCROLLABLE) -->
                <div class="p-3" style="height: calc(100vh - 260px); overflow-y: auto;">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="fw-bold">No</th>
                                    <th class="fw-bold">Kode</th>
                                    <th class="fw-bold">Nama Obat/Alkes</th>
                                    <th class="fw-bold">Kategori</th>
                                    <th class="fw-bold">Sediaan</th>
                                    <th class="fw-bold">Racikan</th>
                                    <th class="fw-bold"><i>Medication</i></th>
                                </tr>
                            </thead>
                            <tbody id="TabelObatAlkes">
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <small>Tidak Ada Data Yang Ditampilkan</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="modal-footer nav_background d-flex justify-content-between align-items-center">

                <!-- PAGINATION -->
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-info" id="prev_button_obat_alkes">
                        <i class="bi bi-chevron-left"></i>
                    </button>

                    <span class="btn btn-sm btn-outline-info disabled" id="page_info_obat_alkes">
                        0 / 0
                    </span>

                    <button type="button" class="btn btn-sm btn-info" id="next_button_obat_alkes">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>

                <!-- CLOSE -->
                <button type="button" class="btn btn-sm btn-secondary btn-rounded" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>

            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH ITEM OBAT RESEP -->
<div class="modal fade" id="ModalTambahItem" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border border-2 border-dark">
            <form action="javascript:void(0);" id="ProsesTambahItem" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Item Obat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" id="FormTambahItem">
                            <!-- Form Proses -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiTambahItem">
                            <!-- Notifikasi Proses -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded" id="button_tambah_item">
                        <i class="bi bi-check"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalTambahIngridient" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border border-2 border-primary-subtle rounded-4 shadow-lg">
            <form action="javascript:void(0);" id="ProsesTambahIngridient" autocomplete="off">
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-dark"><i class="bi bi-plus"></i> Tambah Ingridient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="row">
                        <div class="col-md-12" id="FormTambahIngridient">
                            <!-- Form Tambah -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiTambahIngridient">
                            <!-- Notifikasi Proses -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-plus"></i> Tambahkan
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalKirimMedicationRequest" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border border-2 border-primary-subtle rounded-4 shadow-lg">
            <form action="javascript:void(0);" id="ProsesKirimMedicationRequest" autocomplete="off">
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-dark"><i class="bi bi-send"></i> Kirim <i>Medication Request</i></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="row">
                        <div class="col-md-12" id="FormKirimMedicationRequest">
                            <!-- Form Tambah -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiKirimMedicationRequest">
                            <!-- Notifikasi Proses -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-primary btn-rounded">
                        <i class="bi bi-send"></i> Kirim Resource
                    </button>
                    <button type="button" class="btn btn-secondary btn-rounded" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i> Tutup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PENYERAHAN OBAT -->
<div class="modal fade" id="ModalCreatMedicationDispense" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border border-2 border-primary-subtle rounded-4 shadow-lg">
            <form action="javascript:void(0);" id="ProsesCreatMedicationDispense" autocomplete="off">
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-dark"><i class="bi bi-send"></i> Penyerahan Obat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light">
                    <div class="row">
                        <div class="col-md-12" id="FormCreatMedicationDispense">
                            <!-- Form Tambah -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="NotifikasiCreatMedicationDispense">
                            <!-- Notifikasi Proses -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
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