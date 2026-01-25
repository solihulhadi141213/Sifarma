//Fungsi Menampilkan Data
function ShowData() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    var $tabel       = $('#TabelMedicationRequest');

    // Tambahkan efek visual loading (opacity menurun)
    $tabel.css({
        'opacity': '0.5',
        'pointer-events': 'none',
        'transition': 'opacity 0.3s ease'
    });

    $.ajax({
        type   : 'POST',
        url    : '_Page/MedicationRequest/TabelMedicationRequest.php',
        data   : ProsesFilter,
        success: function(data) {
            // Ganti isi tabel tanpa mengganti elemen induk
            $tabel.html(data);

            // Kembalikan efek normal
            $tabel.css({
                'opacity': '1',
                'pointer-events': 'auto'
            });
            
            // 🔁 Re-inisialisasi tooltip setelah data dimuat
            $('[data-bs-toggle="tooltip"]').tooltip();
        },
        error: function() {
            $tabel.html('<div class="alert alert-danger m-2">Gagal memuat data. Silakan coba lagi.</div>');
            $tabel.css({
                'opacity': '1',
                'pointer-events': 'auto'
            });
        }
    });
}

//Fungsi Menampilkan Data Kunjungan
function ShowTableKunjungan() {

    var $container = $('#TabelKunjungan');
    var heightBefore = $container.height(); // simpan tinggi awal

    var ProsesFilterKunjungan = $('#ProsesFilterKunjungan').serialize();

    // Kunci tinggi agar layout tidak loncat
    $container
        .css({
            'min-height': heightBefore + 'px',
            'opacity': 0.5
        });

    $.ajax({
        type    : 'POST',
        url     : '_Page/MedicationRequest/TabelKunjungan.php',
        data    : ProsesFilterKunjungan,
        success : function (data) {

            // Fade out ringan
            $container.fadeOut(150, function () {

                // Ganti isi tabel
                $container.html(data);

                // Fade in
                $container.fadeIn(200, function () {

                    // Lepas kunci tinggi setelah render
                    $container.css({
                        'min-height': '',
                        'opacity': 1
                    });

                    // Re-init tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip();
                });
            });
        }
    });
}

//Fungsi Menampilkan Modal Detail Resep 
function ShowModalDetailResep(id_medication_request_group) {

    // Loading Detail Form
    $('#FormDetailResep').html('<div class="row mb-2"><div class="col-12 text-center">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/MedicationRequest/FormDetailResep.php',
        data        : {id_medication_request_group: id_medication_request_group},
        success     : function(data){
            $('#FormDetailResep').html(data);

            // 🔁 Re-inisialisasi tooltip setelah data dimuat
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });
    
}

function ShowDetailResep() {
    var ProsesDetail = $('#ProsesDetail').serialize();
    var targetElement = $('#RowDetailResep');

    // Ambil tinggi aman
    var currentHeight = targetElement.outerHeight();
    if (currentHeight < 100) {
        currentHeight = 100;
    }

    $.ajax({
        type: 'POST',
        url: '_Page/MedicationRequest/_DetailResep.php',
        data: ProsesDetail,

        beforeSend: function () {
            targetElement
                .css('min-height', currentHeight + 'px')
                .html(
                    '<div class="loading-overlay" style="display:flex;align-items:center;justify-content:center;min-height:' + currentHeight + 'px;">' +
                        '<div class="loading-spinner" style="' +
                            'width:40px;height:40px;' +
                            'border:3px solid #f3f3f3;' +
                            'border-top:3px solid #3498db;' +
                            'border-radius:50%;' +
                            'animation:spin 1s linear infinite;">' +
                        '</div>' +
                    '</div>'
                );
        },

        success: function (data) {
            targetElement.fadeOut(150, function () {
                targetElement
                    .html(data)
                    .fadeIn(150)
                    .css('min-height', '');
            });

            // Init tooltip jika tersedia
            if (typeof bootstrap !== 'undefined') {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        },

        error: function () {
            targetElement.html(
                '<div class="alert alert-danger text-center">Gagal memuat data</div>'
            ).css('min-height', '');
        }
    });
}

//Fungsi Menampilkan Data Obat/Alkes
function ShowTableObat() {

    var $container = $('#TabelObatAlkes');
    var heightBefore = $container.height(); // simpan tinggi awal

    var ProsesFilterObatAlkes = $('#ProsesFilterObatAlkes').serialize();

    // Kunci tinggi agar layout tidak loncat
    $container
        .css({
            'min-height': heightBefore + 'px',
            'opacity': 0.5
        });

    $.ajax({
        type    : 'POST',
        url     : '_Page/MedicationRequest/TabelObatAlkes.php',
        data    : ProsesFilterObatAlkes,
        success : function (data) {

            // Fade out ringan
            $container.fadeOut(150, function () {

                // Ganti isi tabel
                $container.html(data);

                // Fade in
                $container.fadeIn(200, function () {

                    // Lepas kunci tinggi setelah render
                    $container.css({
                        'min-height': '',
                        'opacity': 1
                    });

                    // Re-init tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip();
                });
            });
        }
    });
}

// ===================================================================================================
// INI ADALAH BATAS SUCI ANTARA FUNCION DAN SCRIPT LAINNYA
// ===================================================================================================

//Menampilkan Data Pertama Kali
$(document).ready(function() {
    // Sembunyikan Detail Resep
    $('#SectionDetailResep').hide();
    //Menampilkan Data Pertama Kali
    ShowData();

    // Ketika Reload
    $('.reload_data').click(function(){
        $('#ProsesFilter')[0].reset();
        ShowData();
    });

    // Ketika Modal Filter Ditampilkan
     $('.modal_filter').click(function(){
        $('#ModalFilter').modal('show');
    });

    //Ketika keyword_by diubah
    $('#KeywordBy').change(function(){
        var keyword_by =$('#KeywordBy').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/MedicationRequest/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    //Ketika Data Di Filter Kembalikan Ke Halaman Awal
    $('#ProsesFilter').submit(function(){
        $('#page').val("1");
        $('#ModalFilter').modal('hide');
        ShowData();
    });

    //Pagging
    $(document).on('click', '#next_button', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page').val(next_page);
        ShowData(0);
    });
    $(document).on('click', '#prev_button', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page').val(next_page);
        ShowData(0);
    });


    // Klik tombol buka 'modal_pilih_kunjungan'
    $(document).on('click', '.modal_pilih_kunjungan', function () {
        $('#ModalKunjungan').modal('show');
    });

    // Saat modal benar-benar tampil
    $('#ModalKunjungan').on('shown.bs.modal', function () {
        $('#keyword_kunjungan').focus().select();
        ShowTableKunjungan();
    });

    //Pagging kunjungan
    $(document).on('click', '#next_button_kunjungan', function() {
        var page_now = parseInt($('#page_kunjungan').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_kunjungan').val(next_page);
        ShowTableKunjungan(0);
    });
    $(document).on('click', '#prev_button_kunjungan', function() {
        var page_now = parseInt($('#page_kunjungan').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_kunjungan').val(next_page);
        ShowTableKunjungan(0);
    });

    // Submit Pencarian
    $('#ProsesFilterKunjungan').submit(function(e){

        e.preventDefault();
        // Reset Halaman
        $('#page_kunjungan').val(1);

        // Tampilkan Data
        ShowTableKunjungan(0);
    });

    $(document).on('click', '.pilih_kunjungan', function () {

        var id_kunjungan = $(this).data('id');

        // Reset UI
        $('#NotifikasiTambahResep').html('');
        $('#FormTambahResep').html('Loading...');

        // Tampilkan Modal 'ModalTambahResep'
        $('#ModalTambahResep').modal('show');

        // Tampilkan Form 
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/MedicationRequest/FormTambahResep.php',
            data        : {id_kunjungan: id_kunjungan},
            success     : function(data){
                $('#FormTambahResep').html(data);

                // Select2 Dokter
                $('#dokter').select2({
                    theme         : 'bootstrap-5',
                    placeholder   : 'Cari dokter...',
                    allowClear    : true,
                    width         : '100%',
                    dropdownParent: $('#FormTambahResep')
                });
            }
        });
        
    });

    // Double click untuk edit diagnosis
    let originalValue = '';
    let selectedValue = null;
    let isEditing     = false;

    $(document).on('dblclick', '.reson-view', function () {

        originalValue = $(this).val();
        selectedValue = null;
        isEditing     = true;

        // Hide readonly
        $(this).hide();

        // Show select & select2
        $('#reson').show();
        $('#reson').next('.select2').show();

        if (!$('#reson').hasClass('select2-hidden-accessible')) {
            $('#reson').select2({
                theme: 'bootstrap-5',
                placeholder: 'Cari Kode ICD-10...',
                minimumInputLength: 3,
                allowClear: true,
                width: '100%',
                dropdownParent: $('#FormTambahResep'),
                ajax: {
                    url: '_Page/MedicationRequest/SearchIcd10.php',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { keyword: params.term };
                    },
                    processResults: function (data) {
                        return { results: data };
                    }
                }
            });
        }

        $('#reson').select2('open');
    });

    //SAAT DIAGNOSIS DIPILIH
    $(document).on('select2:select', '#reson', function (e) {
        selectedValue = e.params.data.text;
    });

    //CLICK DI LUAR FORM
    $(document).on('mousedown', function (e) {

        if (!isEditing) return;

        let target = $(e.target);

        // Abaikan klik di area select2
        if (
            target.closest('.select2-container').length ||
            target.closest('.select2-dropdown').length
        ) {
            return;
        }

        // === KEMBALI KE VIEW MODE ===

        // Tentukan value
        if (selectedValue !== null) {
            $('#reson_view').val(selectedValue);
        } else {
            $('#reson_view').val(originalValue);
        }

        // Hide select2 DENGAN BENAR
        $('#reson').select2('close');
        $('#reson').hide();
        $('#reson').next('.select2').hide();

        // Show readonly input
        $('#reson_view').show();

        isEditing = false;
    });

    // ==========================================================
    // PROSES TAMBAH RESEP
    // ==========================================================
    $('#ProsesTambahResep').submit(function(e){
        e.preventDefault(); // WAJIB agar tidak submit normal

        var ProsesTambahResep = $('#ProsesTambahResep').serialize();

        $.ajax({
            type    : 'POST',
            url     : '_Page/MedicationRequest/ProsesTambahResep.php',
            dataType: 'json',
            data    : ProsesTambahResep,

            // 🔒 KUNCI TOMBOL SAAT REQUEST DIMULAI
            beforeSend: function(){
                $('#ButtonTambahResep').prop('disabled', true);
                $('#NotifikasiTambahResep').html('Mengirim data...');
            },

            // ✅ RESPONSE BERHASIL DITERIMA (HTTP 200)
            success: function(response){
                var status                      = response.status;
                var message                     = response.message;
                var id_medication_request_group = response.id_medication_request_group;

                if(status === 'success'){
                   
                    // Reset Form Filter
                    $('#ProsesFilter')[0].reset();
                    $('#ProsesFilterKunjungan')[0].reset();
                    $('#page_kunjungan').val(1);

                    // Tutup Modal
                    $('#NotifikasiTambahResep').html('');
                    $('#ModalTambahResep').modal('hide');
                    $('#ModalKunjungan').modal('hide');

                    // Tampilkan Data
                    ShowData();

                    Swal.fire(
                        'Success!',
                        'Resep Berhasil Dibuat!',
                        'success'
                    );
                }else{
                    $('#NotifikasiTambahResep').html(
                        '<div class="alert alert-danger"><small>'+message+'</small></div>'
                    );
                }
            },

            // ❌ ERROR TEKNIS (NETWORK / 500 / TIMEOUT)
            error: function(xhr){
                $('#NotifikasiTambahResep').html(
                    '<div class="alert alert-danger">' +
                    '<small>Koneksi ke Server Gagal</small>' +
                    '</div>'
                );
            },

            // 🔓 AKTIFKAN KEMBALI TOMBOL (SELALU DIEKSEKUSI)
            complete: function(){
                $('#ButtonTambahResep').prop('disabled', false);
            }
        });
    });

    // Ketika Click Detail Resep
    $(document).on('click', '.modal_detail_resep', function () {
        // Tangkap 'id_medication_request_group'
        var id_medication_request_group = $(this).data('id');

        // Tampilkan Modal
        $('#ModalDetailResep').modal('show');

        // Buka Data Dengan Function
        ShowModalDetailResep(id_medication_request_group);
    });

    // Selengkapnya Mengarah Ke _DetailPemeriksaan
    $('#ProsesDetail').submit(function(e){

        e.preventDefault();

        // Load data
        ShowDetailResep();
        
        // Tutup Modal
        $('#ModalDetailResep').modal('hide');

        // Tampilkan Element Yang Diperlukan
        $('#SectionDetailResep').show();

        // Sembunyikan Element Yang Tidak Perlu
        $('#RowTabelResep').hide();
        
    });

    // Ketika Click Tombol 'back_to_tabel'
    $(document).on('click', '#back_to_tabel', function () {
        // Tampilkan 'RowTabelResep'
        $('#RowTabelResep').show();

        // Sembunyikan 'SectionDetailResep'
        $('#SectionDetailResep').hide();

        // Kembalikan posisi layar ke atas
        $('html, body').scrollTop(0);

        hideFloatingOption();
    });

    // Ketika Klik 'reload_detail_resep'
    $(document).on('click', '#reload_detail_resep', function () {
        ShowDetailResep();
    });

    // ==========================================================
    // MODAL EDIT RESEP
    // ==========================================================
    $(document).on('click', '.modal_edit_resep', function () {
        // Disable tombol
        $("#button_edit_resep").prop("disabled", true);

        // Tangkap 'id_medication_request_group'
        var id_medication_request_group = $(this).data('id');

        // Tampilkan Modal
        $('#ModalEditResep').modal('show');

        // Hapus Notifikasi
        $('#NotifikasiEditResep').html('');
        
        // Tampilkan Form Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/MedicationRequest/FormEditResep.php',
            data        : {id_medication_request_group: id_medication_request_group},
            success     : function(data){
                $('#FormEditResep').html(data);

                // Select2 Dokter
                $('#dokter_edit').select2({
                    theme         : 'bootstrap-5',
                    placeholder   : 'Cari dokter...',
                    allowClear    : true,
                    width         : '100%',
                    dropdownParent: $('#FormEditResep')
                });
            }
        });
    });

    // Double click untuk edit diagnosis
    let originalValue2 = '';
    let selectedValue2 = null;
    let isEditing2     = false;

    $(document).on('dblclick', '.reson-view_edit', function () {

        originalValue2 = $(this).val();
        selectedValue2 = null;
        isEditing2     = true;

        // Hide readonly
        $(this).hide();

        // Show select & select2
        $('#reson_edit').show();
        $('#reson_edit').next('.select2').show();

        if (!$('#reson_edit').hasClass('select2-hidden-accessible')) {
            $('#reson_edit').select2({
                theme             : 'bootstrap-5',
                placeholder       : 'Cari Kode ICD-10...',
                minimumInputLength: 3,
                allowClear        : true,
                width             : '100%',
                dropdownParent    : $('#FormEditResep'),
                ajax: {
                    url: '_Page/MedicationRequest/SearchIcd10.php',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { keyword: params.term };
                    },
                    processResults: function (data) {
                        return { results: data };
                    }
                }
            });
        }

        $('#reson').select2('open');
    });

    //SAAT DIAGNOSIS DIPILIH
    $(document).on('select2:select', '#reson_edit', function (e) {
        selectedValue2 = e.params.data.text;
    });

    //CLICK DI LUAR FORM
    $(document).on('mousedown', function (e) {

        if (!isEditing2) return;

        let target = $(e.target);

        // Abaikan klik di area select2
        if (
            target.closest('.select2-container').length ||
            target.closest('.select2-dropdown').length
        ) {
            return;
        }

        // === KEMBALI KE VIEW MODE ===

        // Tentukan value
        if (selectedValue2 !== null) {
            $('#reson_view_edit').val(selectedValue2);
        } else {
            $('#reson_view_edit').val(originalValue2);
        }

        // Hide select2 DENGAN BENAR
        $('#reson_edit').select2('close');
        $('#reson_edit').hide();
        $('#reson_edit').next('.select2').hide();

        // Show readonly input
        $('#reson_view_edit').show();

        isEditing2 = false;
    });

    // Proses Edit Resep
    $('#ProsesEditResep').submit(function(e){
        e.preventDefault(); // WAJIB agar tidak submit normal

        var ProsesEditResep = $('#ProsesEditResep').serialize();

        $.ajax({
            type    : 'POST',
            url     : '_Page/MedicationRequest/ProsesEditResep.php',
            dataType: 'json',
            data    : ProsesEditResep,

            // 🔒 KUNCI TOMBOL SAAT REQUEST DIMULAI
            beforeSend: function(){
                $('#button_edit_resep').prop('disabled', true);
                $('#NotifikasiEditResep').html('Mengirim data...');
            },

            // ✅ RESPONSE BERHASIL DITERIMA (HTTP 200)
            success: function(response){
                var status                      = response.status;
                var message                     = response.message;
                var id_medication_request_group = response.id_medication_request_group;

                if(status === 'success'){

                    // Tutup Modal
                    $('#NotifikasiEditResep').html('');
                    $('#ModalEditResep').modal('hide');

                    // Tampilkan Data
                    ShowData();
                    ShowDetailResep();

                    Swal.fire(
                        'Success!',
                        'Resep Berhasil Diubah!',
                        'success'
                    );
                }else{
                    $('#NotifikasiEditResep').html(
                        '<div class="alert alert-danger"><small>'+message+'</small></div>'
                    );
                }
            },

            // ❌ ERROR TEKNIS (NETWORK / 500 / TIMEOUT)
            error: function(xhr){
                $('#NotifikasiEditResep').html(
                    '<div class="alert alert-danger">' +
                    '<small>Koneksi ke Server Gagal</small>' +
                    '</div>'
                );
            },

            // 🔓 AKTIFKAN KEMBALI TOMBOL (SELALU DIEKSEKUSI)
            complete: function(){
                $('#button_edit_resep').prop('disabled', false);
            }
        });
    });

    // ==========================================================
    // MODAL HAPUS/DELETE RESEP
    // ==========================================================
    $(document).on('click', '.modal_hapus_resep', function () {
        // Disable tombol
        $("#button_hapus_resep").prop("disabled", true);

        // Tangkap 'id_medication_request_group'
        var id_medication_request_group = $(this).data('id');

        // Tampilkan Modal
        $('#ModalHapusResep').modal('show');

        // Hapus Notifikasi
        $('#NotifikasiHapusResep').html('');

        // Loading Form
        $('#FormHapusResep').html('Loading...');
        
        // Tampilkan Form Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/MedicationRequest/FormHapusResep.php',
            data        : {id_medication_request_group: id_medication_request_group},
            success     : function(data){
                $('#FormHapusResep').html(data);
            }
        });
    });

    // Proses Hapus Resep
    $('#ProsesHapusResep').submit(function(e){
        e.preventDefault(); // WAJIB agar tidak submit normal

        var ProsesHapusResep = $('#ProsesHapusResep').serialize();

        $.ajax({
            type    : 'POST',
            url     : '_Page/MedicationRequest/ProsesHapusResep.php',
            dataType: 'json',
            data    : ProsesHapusResep,

            // 🔒 KUNCI TOMBOL SAAT REQUEST DIMULAI
            beforeSend: function(){
                $('#button_hapus_resep').prop('disabled', true);
                $('#NotifikasiHapusResep').html('Mengirim data...');
            },

            // ✅ RESPONSE BERHASIL DITERIMA (HTTP 200)
            success: function(response){
                var status                      = response.status;
                var message                     = response.message;

                if(status === 'success'){

                    // Tutup Modal
                    $('#NotifikasiHapusResep').html('');
                    $('#ModalHapusResep').modal('hide');

                    // Tampilkan Data
                    ShowData();
                    ShowDetailResep();

                    Swal.fire(
                        'Success!',
                        'Resep Berhasil Dihapus!',
                        'success'
                    );
                }else{
                    $('#NotifikasiHapusResep').html(
                        '<div class="alert alert-danger"><small>'+message+'</small></div>'
                    );
                }
            },

            // ❌ ERROR TEKNIS (NETWORK / 500 / TIMEOUT)
            error: function(xhr){
                $('#NotifikasiHapusResep').html(
                    '<div class="alert alert-danger">' +
                    '<small>Koneksi ke Server Gagal</small>' +
                    '</div>'
                );
            },

            // 🔓 AKTIFKAN KEMBALI TOMBOL (SELALU DIEKSEKUSI)
            complete: function(){
                $('#button_hapus_resep').prop('disabled', false);
            }
        });
    });

    // ==========================================================
    // MODAL DAFTAR OBAT/ALKES
    // ==========================================================

    // Modal Tabel Obat/Alkes Muncul
    $(document).on('click', '.modal_obat_alkes', function () {

        // Tangkap ID group
        var id_medication_request_group = $(this).data('id');

        // Tempelkan ke form
        $('#put_id_medication_request_group').val(id_medication_request_group);

        // Tampilkan modal
        $('#ModalItemObat').modal('show');

    });
    $('#ModalItemObat').on('shown.bs.modal', function () {

        // Fokus ke form pencarian
        $('#keyword_obat_alkes').focus().select();

        // Load data
        ShowTableObat();

    });

    // Ketika Pencarian Obat/Alkes Submit
    $(document).on('submit', '#ProsesFilterObatAlkes', function () {
        // Reset Halaman
        $('#page_obat_alkes').val(1);

        // Tampilkan Tabel
        ShowTableObat();
    });

    // Pagging Obat/Alkes
    $(document).on('click', '#next_button_obat_alkes', function() {
        var page_now = parseInt($('#page_obat_alkes').val(), 10);
        var next_page = page_now + 1;
        $('#page_obat_alkes').val(next_page);
        ShowTableObat();
    });
    $(document).on('click', '#prev_button_obat_alkes', function() {
        var page_now = parseInt($('#page_obat_alkes').val(), 10);
        var next_page = page_now - 1;
        $('#page_obat_alkes').val(next_page);
       ShowTableObat();
    });

    // ==========================================================
    // MODAL TAMBAH ITEM
    // ==========================================================

    $(document).on('click', '.modal_tambah_item', function () {

        // Tangkap ID group
        var id_medication_request_group = $(this).data('id');
        var id                          = $(this).data('id_item');

        // Tampilkan modal 'ModalTambahItem'
        $('#ModalTambahItem').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiTambahItem').html('');

        // Loading Form
        $('#FormTambahItem').html('Loading...');

        // Tampilkan Form Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/MedicationRequest/FormTambahItem.php',
            data        : {id_medication_request_group: id_medication_request_group, id: id},
            success     : function(data){
                $('#FormTambahItem').html(data);
            }
        });

    });

});





