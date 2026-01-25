<?php
    //Cek Aksesibilitas ke halaman ini
    $IjinAksesSaya=IjinAksesSaya($Conn,$SessionIdAccess,'emy9Q1p9V9hhsdoYK0Wz0CQPdZj41uKrSP7H');
    if($IjinAksesSaya!=="Ada"){
        include "_Page/Error/NoAccess.php";
    }else{
?>
    <div class="pagetitle">
        <h1>
            <a href="">
                <i class="bi bi-receipt"></i> Peresepan</a>
            </a>
        </h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Peresepan</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard" id="RowTabelResep">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <small>
                        Halaman ini digunakan untuk mengelola resep dokter.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                       <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="button" class="btn btn-md btn-outline-secondary btn-floating reload_data" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Reload Data">
                                    <i class="bi bi-repeat"></i>
                                </button>
                                <button type="button" class="btn btn-md btn-secondary btn-floating modal_filter" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Cari / Filter">
                                    <i class="bi bi-search"></i>
                                </button>
                                <button type="button" class="btn btn-md btn-primary btn-floating modal_pilih_kunjungan" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Tambah / Buat Resep">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td align="center"><b>No</b></td>
                                        <td><b>Nama Pasien</b></td>
                                        <td><b>RM</b></td>
                                        <td><b>Tanggal</b></td>
                                        <td><b>Kunjungan</b></td>
                                        <td><b>Pembayaran</b></td>
                                        <td><b>Dokter</b></td>
                                        <td><b>Item</b></td>
                                        <td><b><i>Priority</i></b></td>
                                        <td><b>Status</b></td>
                                        <td><b>Opsi</b></td>
                                    </tr>
                                </thead>
                                <tbody id="TabelMedicationRequest">
                                    <tr>
                                        <td class="text-center" colspan="11">
                                            <small>Loading...</small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <small id="page_info">
                                    Page 1 Of 100
                                </small>
                            </div>
                            <div class="col-6 text-end">
                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="prev_button">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-info btn-floating" id="next_button">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section dashboard" id="SectionDetailResep">
        <div class="row">
            <div class="col-lg-12" id="RowDetailResep">
                
            </div>
        </div>
    </section>
<?php } ?>