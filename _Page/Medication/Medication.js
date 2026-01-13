//Fungsi Menampilkan Data
function ShowData() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    var $tabel       = $('#TabelMedication');

    // Tambahkan efek visual loading (opacity menurun)
    $tabel.css({
        'opacity': '0.5',
        'pointer-events': 'none',
        'transition': 'opacity 0.3s ease'
    });

    $.ajax({
        type   : 'POST',
        url    : '_Page/Medication/TabelMedication.php',
        data   : ProsesFilter,
        success: function(data) {
            // Ganti isi tabel tanpa mengganti elemen induk
            $tabel.html(data);

            // Reset checkbox utama
            $('input[name="check_all"]').prop('checked', false);

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

//Fungsi Menampilkan Data KFA
function ShowDataKfa() {
    var ProsesCariKfa = $('#ProsesCariKfa').serialize();
    var $tabel       = $('#tabel_kfa');

    // Tambahkan efek visual loading (opacity menurun)
    $tabel.css({
        'opacity': '0.5',
        'pointer-events': 'none',
        'transition': 'opacity 0.3s ease'
    });

    $.ajax({
        type   : 'POST',
        url    : '_Page/Medication/TabelKfa.php',
        data   : ProsesCariKfa,
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
            $tabel.html('<tr><td colspan="4" class="text-center">Gagal Memuat Data! Silahkan Coba Lagi</td></tr>');
            $tabel.css({
                'opacity': '1',
                'pointer-events': 'auto'
            });
        }
    });
}
function initSelect2Sediaan() {
    $('#sediaan_manual').select2({
        theme             : 'bootstrap-5',
        dropdownParent    : $('#ModalTambahManual'),
        placeholder       : 'Cari sediaan...',
        allowClear        : true,
        minimumInputLength: 2,
        ajax: {
            url     : '_Page/Medication/ListSediaan.php',
            dataType: 'json',
            delay   : 300,
            data    : function (params) {
                return {
                    keyword            : params.term,
                    medication_category: $('#medication_category_manual').val()
                };
            },
            processResults: function (data) {
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
}

function initSelect2KfaManual() {
    $('#kfa_manual').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#ModalTambahManual'),
        placeholder: 'Cari KFA...',
        allowClear: true,
        minimumInputLength: 3,
        ajax: {
            url: '_Page/Medication/ListKfa.php',
            dataType: 'json',
            delay: 300,
            data: function (params) {
                return {
                    keyword: params.term,
                    medication_category: $('#medication_category_manual').val(),
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.results,
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
            cache: true
        }
    });
}

function initSelect2ManufakturManual() {
    $('#manufaktur_manual').select2({
        theme             : 'bootstrap-5',
        dropdownParent    : $('#ModalTambahManual'),
        placeholder       : 'Cari Manufacturer...',
        allowClear        : true,
        minimumInputLength: 3,
        ajax: {
            url     : '_Page/Medication/ListManufacturer.php',
            dataType: 'json',
            delay   : 300,
            data    : function (params) {
                return {
                    keyword : params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
}

function initSelect2KfaIngridient() {
    var medication_category = 'Obat';
    $('#ingridient_kfa').select2({
        theme             : 'bootstrap-5',
        dropdownParent    : $('#ModalTambahIngridient'),
        placeholder       : 'Cari Zat/Kandungan...',
        allowClear        : true,
        minimumInputLength: 3,
        ajax              : {
            url     : '_Page/Medication/ListKfa.php',
            dataType: 'json',
            delay   : 300,
            data    : function (params) {
                return {
                    keyword            : params.term,
                    medication_category: medication_category,
                    page               : params.page || 1
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results   : data.results,
                    pagination: {
                        more: data.pagination.more
                    }
                };
            },
            cache: true
        }
    });
}

function initSelect2SatuanNumerator() {
    $('#satuan_numerator').select2({
        theme             : 'bootstrap-5',
        dropdownParent    : $('#ModalTambahIngridient'),
        placeholder       : 'Satuan Numerator...',
        allowClear        : true,
        minimumInputLength: 1,
        ajax              : {
            url     : '_Page/Medication/ListNumerator.php',
            dataType: 'json',
            delay   : 300,
            data    : function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
}

function initSelect2SatuanDenominator() {
    $('#satuan_denominator').select2({
        theme             : 'bootstrap-5',
        dropdownParent    : $('#ModalTambahIngridient'),
        placeholder       : 'Satuan Denominator...',
        allowClear        : true,
        minimumInputLength: 3,
        ajax              : {
            url     : '_Page/Medication/ListDenominator.php',
            dataType: 'json',
            delay   : 300,
            data    : function (params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.results
                };
            },
            cache: true
        }
    });
}

// ===================================================================================================
// INI ADALAH BATAS SUCI ANTARA FUNCION DAN SCRIPT LAINNYA
// ===================================================================================================

//Menampilkan Data Pertama Kali
$(document).ready(function() {

    //Menampilkan Data Pertama Kali
    ShowData();
    ShowDataKfa();

    //Ketika keyword_by diubah
    $('#KeywordBy').change(function(){
        var keyword_by =$('#KeywordBy').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Medication/FormFilter.php',
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

    // Ketika Pencarian KFA
    $('#ProsesCariKfa').submit(function(){
        $('#page_kfa').val("1");
        ShowDataKfa();
    });

    //Pagging KFA
    $(document).on('click', '#next_button_kfa', function() {
        var page_now = parseInt($('#page_kfa').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_kfa').val(next_page);
        ShowDataKfa(0);
    });
    $(document).on('click', '#prev_button_kfa', function() {
        var page_now = parseInt($('#page_kfa').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_kfa').val(next_page);
        ShowDataKfa(0);
    });

    // Ketika Generate Kode Lokal
    $(document).on('click', '.generate_kode_lokal', function () {
        const length = 12;
        const chars = '0123456789';
        let result = '';

        for (let i = 0; i < length; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }

        $('#medication_code_manual').val(result);
        $('#medication_code').val(result);
    });
    



    // Modal Tambah Medication KFA
    $(document).on('click', '.modal_tambah_medication_kfa', function () {

        //tangkap data 'kfa_code' dan buat variabel
        var kfa_code   = $(this).data('id');

        //tampilkan modal
        $('#ModalTambahMedicationKfa').modal('show');

        //Form Loading
        $('#FormTambahMedicationKfa').html('Loading...');

        //Tampilkan Form Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Medication/FormTambahMedicationKfa.php',
            data        : {kfa_code: kfa_code},
            success     : function(data){
                $('#FormTambahMedicationKfa').html(data);

                // 🔁 Re-inisialisasi tooltip setelah data dimuat
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        });
    });

    //Proses Tambah Medication KFA
    $('#ProsesTambahMedicationKfa').submit(function(e){
        e.preventDefault();
        
        // Ambil Data Dari form
        var ProsesTambahMedicationKfa = $(this).serialize();

        //Loading Notifikasi
        $('#NotifikasiEditTagihan').html('<small class="text-muted">Menyimpan data...</small>');

        // Ajax Request
        $.ajax({
            type     : 'POST',
            url      : '_Page/Medication/ProsesTambahMedicationKfa.php',
            dataType : 'json',
            data     : ProsesTambahMedicationKfa,

            success: function(response){

                var payload  = response.payload;
                var status  = response.status;
                var message = response.message || 'Proses berhasil';

                if(status === 'success'){

                    // Bersihkan notifikasi
                    $('#NotifikasiTambahMedicationKfa').html('');

                    // Tutup modal jika ada
                    $('#ModalTambahMedicationKfa').modal('hide');
                    $('#ModalCariKfa').modal('hide');

                    // Reload detail pemeriksaan
                    ShowData();

                    // Toast Proses Berhasil
                    $('#put_message').html('<i class="bi bi-check-circle me-2"></i> ' + message);

                    // Tampilkan Toast
                    var toastEl = document.getElementById('toast_proses');
                    var toast   = new bootstrap.Toast(toastEl, {delay: 3000});
                    toast.show();

                } else {
                    // Tampilkan Pesan Kesalahan
                    $('#NotifikasiTambahMedicationKfa').html(
                        '<div class="alert alert-danger"><small>'+message+'</small></div><div class="alert alert-danger"><code>'+payload+'</code></div>'
                    );
                }
            },

            error: function(xhr){
                console.log(xhr.responseText);

                $('#NotifikasiTambahMedicationKfa').html(
                    '<div class="alert alert-danger"><small>Terjadi kesalahan sistem</small></div>'
                );
            }
        });
    });

    // Modal Tambah Medication Manual
    $(document).on('click', '.modal_tambah_manual', function () {

        //tampilkan modal
        $('#ModalTambahManual').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiTambahManual').html('');

        //Form Loading
        $('#FormTambahManual').html('Loading...');

        //Tampilkan Form Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Medication/FormTambahManual.php',
            success     : function(data){
                $('#FormTambahManual').html(data);

                // 🔁 Re-inisialisasi tooltip setelah data dimuat
                $('[data-bs-toggle="tooltip"]').tooltip();

                // Select2 Untuk 'sediaan_manual'
                initSelect2Sediaan();
                initSelect2KfaManual();
                initSelect2ManufakturManual();

            }
        });
    });

    // Modal Tambah Ingridient
    $(document).on('click', '#modal_tambah_ingridient', function () {

        //tampilkan modal
        $('#ModalTambahIngridient').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiTambahIngridient').html('');

        //Form Loading
        $('#FormTambahIngridient').html('Loading...');

        //Tampilkan Form Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Medication/FormTambahIngridient.php',
            success     : function(data){
                $('#FormTambahIngridient').html(data);

                // 🔁 Re-inisialisasi tooltip setelah data dimuat
                $('[data-bs-toggle="tooltip"]').tooltip();

                // Inisialisasi Select2
                initSelect2KfaIngridient();
                initSelect2SatuanNumerator();
                initSelect2SatuanDenominator();

            }
        });
    });

    //Proses Tambah Ingridient
    $('#ProsesTambahIngridient').submit(function(e){
        e.preventDefault();
        
        // Ambil Data Dari form
        var ProsesTambahIngridient = $(this).serialize();


        // Ajax Request
        $.ajax({
            type     : 'POST',
            url      : '_Page/Medication/ProsesTambahIngridient.php',
            dataType : 'json',
            data     : ProsesTambahIngridient,

            success: function(response){
                // Buat Variabel
                var status   = response.status;
                var payload  = response.payload;
                var message  = response.message || 'Proses berhasil';

                if(status === 'success'){

                    // Hapus row "Konten Belum Ada" jika ada
                    if($('#table_list_ingridient tr td').length === 1){
                        $('#table_list_ingridient').empty();
                    }

                    // Hitung nomor baris
                    var no = $('#table_list_ingridient tr').length + 1;

                    // Format numerator
                    var numerator = '';
                    if(payload.jumlah_numerator !== ''){
                        numerator = payload.jumlah_numerator + ' ' + payload.nama_numerator;
                    }

                    // Format denominator
                    var denominator = '';
                    if(payload.jumlah_denominator !== ''){
                        denominator = payload.jumlah_denominator + ' ' + payload.nama_denominator;
                    }

                    // Buat row
                    var content_row = `
                        <tr>
                            <td class="text-center"><small>${no}</small></td>
                            <td><small>${payload.kode_kfa}</small></td>
                            <td><small>${payload.nama_kfa}</small></td>
                            <td class="text-center"><small>${numerator}</small></td>
                            <td class="text-center"><small>${denominator}</small></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm btn-hapus-ingridient" title="Hapus Ingridient">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <input type="hidden" name="payload_ingridient[]" value='${JSON.stringify(payload)}'>
                            </td>
                        </tr>
                    `;

                    // Append ke tabel
                    $('#table_list_ingridient').append(content_row);

                    // Reset form
                    $('#ProsesTambahIngridient')[0].reset();

                    // Optional: reset Select2
                    $('#ingridient_kfa, #satuan_numerator, #satuan_denominator').val(null).trigger('change');

                } else {

                    $('#NotifikasiTambahIngridient').html(
                        '<div class="alert alert-danger"><small>'+message+'</small></div>'
                    );

                }
            },

            error: function(xhr){
                console.log(xhr.responseText);

                $('#NotifikasiTambahIngridient').html(
                    '<div class="alert alert-danger"><small>Terjadi kesalahan sistem</small></div>'
                );
            }
        });
    });

    // Hapus Ingrident List
    $(document).on('click', '.btn-hapus-ingridient', function(){
        $(this).closest('tr').remove();

        // Update ulang nomor
        $('#table_list_ingridient tr').each(function(index){
            $(this).find('td:first small').text(index + 1);
        });

        // Jika kosong, tampilkan placeholder
        if($('#table_list_ingridient tr').length === 0){
            $('#table_list_ingridient').html(`
                <tr>
                    <td colspan="6" class="text-center">
                        <small>Konten Belum Ada</small>
                    </td>
                </tr>
            `);
        }
    });

    // Ketika medication_category_manual diubah
    $(document).on('change', '#medication_category_manual', function() {
        var medication_category= $(this).val();
        
        if(medication_category=="Obat"){
            $('#medication_code_manual').removeAttr('disabled');
            $('#generate_kode_lokal').removeAttr('disabled');
            $('#insert_medication').removeAttr('disabled');
            $('#id_medication_manual').removeAttr('disabled');
            $('#medication_name_manual').removeAttr('disabled');
            $('#racikan_code').removeAttr('disabled');
            $('#kfa_manual').removeAttr('disabled');
            $('#sediaan_manual').removeAttr('disabled');
            $('#manufaktur_manual').removeAttr('disabled');
            $('#modal_tambah_ingridient').removeAttr('disabled');
        }
        if(medication_category=="Alkes"){
            $('#medication_code_manual').removeAttr('disabled');
            $('#generate_kode_lokal').removeAttr('disabled');
            $('#insert_medication').removeAttr('disabled');
            $('#id_medication_manual').removeAttr('disabled');
            $('#medication_name_manual').removeAttr('disabled');
            $('#racikan_code').attr('disabled', 'disabled');
            $('#racikan_code').val('');
            $('#kfa_manual').removeAttr('disabled');
            $('#sediaan_manual').removeAttr('disabled');
            $('#manufaktur_manual').removeAttr('disabled');
            $('#modal_tambah_ingridient').attr('disabled', 'disabled');

            $('#table_list_ingridient').html('<tr><td colspan="6" class="text-center"><small>Konten Belum Ada</small></td></tr>');
        }
        if (medication_category == "") {

            $('#medication_code_manual').val('').prop('disabled', true);
            $('#generate_kode_lokal').prop('disabled', true);
            $('#insert_medication').prop('disabled', true);
            $('#id_medication_manual').val('').prop('disabled', true);
            $('#medication_name_manual').val('').prop('disabled', true);

            $('#racikan_code').val('').prop('disabled', true);
            $('#kfa_manual').val(null).trigger('change').prop('disabled', true);

            $('#sediaan_manual').val(null).trigger('change').prop('disabled', true);
            $('#manufaktur_manual').val(null).trigger('change').prop('disabled', true);

            $('#modal_tambah_ingridient').prop('disabled', true);
            $('#table_list_ingridient').html('<tr><td colspan="6" class="text-center"><small>Konten Belum Ada</small></td></tr>');
        }
    });

    //Proses Tambah Medication Manual
    $('#ProsesTambahManual').submit(function(e){
        e.preventDefault();
        
        // Ambil Data Dari form
        var ProsesTambahManual = $(this).serialize();

        //Loading Notifikasi
        $('#NotifikasiEditTagihan').html('<small class="text-muted">Menyimpan data...</small>');

        // Ajax Request
        $.ajax({
            type     : 'POST',
            url      : '_Page/Medication/ProsesTambahManual.php',
            dataType : 'json',
            data     : ProsesTambahManual,

            success: function(response){
                var status  = response.status;
                var message = response.message || 'Proses berhasil';

                // =============================
                // SUCCESS
                // =============================
                if(status === 'success'){
                    $('#NotifikasiTambahManual').html('');
                    $('#ModalTambahManual').modal('hide');
                    ShowData();

                    $('#put_message').html('<i class="bi bi-check-circle me-2"></i> ' + message);
                    var toastEl = document.getElementById('toast_proses');
                    var toast   = new bootstrap.Toast(toastEl, {delay: 3000});
                    toast.show();

                } else {
                    // =============================
                    // ERROR DETAIL - TAMPILKAN SEMUA
                    // =============================
                    var errorHtml = '<div class="alert alert-danger">';
                    errorHtml += '<h6 class="alert-heading"><i class="bi bi-exclamation-triangle me-2"></i> ' + message + '</h6>';
                    
                    // Informasi HTTP
                    if (response.http_code !== undefined) {
                        if (response.http_code === 0) {
                            errorHtml += '<hr><p class="mb-1"><strong>HTTP Status:</strong> 0 (Koneksi gagal)</p>';
                            errorHtml += '<p class="mb-1"><strong>Kemungkinan Penyebab:</strong></p>';
                            errorHtml += '<ul class="mb-1">';
                            errorHtml += '<li>Koneksi internet terputus</li>';
                            errorHtml += '<li>Server SatuSehat tidak dapat diakses</li>';
                            errorHtml += '<li>Firewall memblokir koneksi</li>';
                            errorHtml += '<li>Masalah DNS</li>';
                            errorHtml += '<li>Timeout koneksi</li>';
                            errorHtml += '</ul>';
                        } else {
                            errorHtml += '<p class="mb-1"><strong>HTTP Status:</strong> ' + response.http_code + '</p>';
                        }
                    }
                    errorHtml += '</div>';
                    
                    // Tampilkan RESPONSE DARI SATUSEHAT (jika ada)
                    if (response.response) {
                        errorHtml += '<div class="alert alert-warning mt-3">';
                        errorHtml += '<h6 class="alert-heading">Response Lengkap dari SatuSehat:</h6>';
                        errorHtml += '<div class="mt-2 p-3 bg-light border rounded">';
                        errorHtml += '<pre style="white-space: pre-wrap; word-wrap: break-word; font-size: 12px; margin: 0;">';
                        errorHtml += JSON.stringify(response.response, null, 2);
                        errorHtml += '</pre>';
                        errorHtml += '</div>';
                        
                        // Jika ada error spesifik dari SatuSehat
                        if (response.response.issue && Array.isArray(response.response.issue)) {
                            errorHtml += '<hr><h6 class="mt-2 mb-2">Detail Error dari SatuSehat:</h6>';
                            response.response.issue.forEach(function(issue, index) {
                                errorHtml += '<div class="mb-2">';
                                errorHtml += '<strong>Issue #' + (index + 1) + ':</strong><br>';
                                
                                if (issue.severity) {
                                    errorHtml += '<span class="badge bg-danger">' + issue.severity + '</span> ';
                                }
                                if (issue.code) {
                                    errorHtml += '<span class="badge bg-info">' + issue.code + '</span> ';
                                }
                                
                                errorHtml += '<div class="mt-1">';
                                if (issue.diagnostics) {
                                    errorHtml += '<strong>Diagnostics:</strong> ' + issue.diagnostics + '<br>';
                                }
                                if (issue.details && issue.details.text) {
                                    errorHtml += '<strong>Details:</strong> ' + issue.details.text + '<br>';
                                }
                                if (issue.expression && issue.expression.length > 0) {
                                    errorHtml += '<strong>Field yang bermasalah:</strong> ' + issue.expression.join(', ') + '<br>';
                                }
                                errorHtml += '</div>';
                                errorHtml += '</div>';
                            });
                        }
                        errorHtml += '</div>';
                    }
                    
                    // Tampilkan DEBUG INFO (jika ada)
                    if (response.debug_info) {
                        errorHtml += '<div class="alert alert-info mt-3">';
                        errorHtml += '<h6 class="alert-heading">Informasi Debug:</h6>';
                        errorHtml += '<div class="row">';
                        errorHtml += '<div class="col-md-6">';
                        errorHtml += '<ul class="mb-0">';
                        errorHtml += '<li><strong>URL:</strong> ' + (response.debug_info.url || '-') + '</li>';
                        errorHtml += '<li><strong>Organization ID:</strong> ' + (response.debug_info.organization_id || '-') + '</li>';
                        errorHtml += '<li><strong>Waktu:</strong> ' + (response.debug_info.timestamp || '-') + '</li>';
                        errorHtml += '</ul>';
                        errorHtml += '</div>';
                        errorHtml += '<div class="col-md-6">';
                        errorHtml += '<ul class="mb-0">';
                        errorHtml += '<li><strong>Token Tersedia:</strong> ' + (response.debug_info.token_available || 'Tidak') + '</li>';
                        if (response.debug_info.curl_error) {
                            errorHtml += '<li><strong>Error CURL:</strong> ' + response.debug_info.curl_error + '</li>';
                        }
                        errorHtml += '</ul>';
                        errorHtml += '</div>';
                        errorHtml += '</div>';
                        errorHtml += '</div>';
                    }
                    
                    // Tampilkan PAYLOAD (jika ada)
                    if (response.payload) {
                        errorHtml += '<div class="alert alert-secondary mt-3">';
                        errorHtml += '<h6 class="alert-heading">Payload yang dikirim ke SatuSehat:</h6>';
                        errorHtml += '<div class="mt-2 p-3 bg-light border rounded">';
                        errorHtml += '<pre style="white-space: pre-wrap; word-wrap: break-word; font-size: 12px; margin: 0;">';
                        errorHtml += JSON.stringify(response.payload, null, 2);
                        errorHtml += '</pre>';
                        errorHtml += '</div>';
                        errorHtml += '</div>';
                    }
                    
                    // Tombol untuk debugging lanjutan
                    errorHtml += '<div class="mt-3">';
                    errorHtml += '<button class="btn btn-sm btn-outline-primary me-2" onclick="copyErrorToClipboard()">';
                    errorHtml += '<i class="bi bi-clipboard me-1"></i> Salin Error ke Clipboard';
                    errorHtml += '</button>';
                    errorHtml += '<button class="btn btn-sm btn-outline-secondary" onclick="$(this).parent().next().toggle()">';
                    errorHtml += '<i class="bi bi-code me-1"></i> Tampilkan/Sembunyikan Raw Response';
                    errorHtml += '</button>';
                    errorHtml += '</div>';
                    
                    // Raw response (tersembunyi awal)
                    errorHtml += '<div class="mt-2" style="display: none;">';
                    errorHtml += '<div class="alert alert-dark">';
                    errorHtml += '<h6 class="alert-heading">Raw Response (JSON):</h6>';
                    errorHtml += '<div class="mt-2 p-3 bg-dark text-light border rounded">';
                    errorHtml += '<pre style="white-space: pre-wrap; word-wrap: break-word; font-size: 11px; margin: 0; font-family: monospace;">';
                    errorHtml += JSON.stringify(response, null, 2);
                    errorHtml += '</pre>';
                    errorHtml += '</div>';
                    errorHtml += '</div>';
                    errorHtml += '</div>';
                    
                    $('#NotifikasiTambahManual').html(errorHtml);
                    
                    // Scroll ke error message
                    $('html, body').animate({
                        scrollTop: $('#NotifikasiTambahManual').offset().top - 100
                    }, 500);
                }
            },

            error: function(xhr, status, error){
                var errorHtml = '<div class="alert alert-danger">';
                errorHtml += '<h6 class="alert-heading"><i class="bi bi-exclamation-octagon me-2"></i> Ajax Request Error</h6>';
                errorHtml += '<hr>';
                errorHtml += '<p class="mb-1"><strong>Status:</strong> ' + status + '</p>';
                errorHtml += '<p class="mb-1"><strong>Error:</strong> ' + error + '</p>';
                
                if (xhr.status) {
                    errorHtml += '<p class="mb-1"><strong>HTTP Status:</strong> ' + xhr.status + '</p>';
                }
                
                if (xhr.responseText) {
                    errorHtml += '<hr>';
                    errorHtml += '<p class="mb-1"><strong>Response Server:</strong></p>';
                    errorHtml += '<div class="p-2 bg-light border rounded">';
                    errorHtml += '<pre style="white-space: pre-wrap; word-wrap: break-word; font-size: 12px; margin: 0;">';
                    errorHtml += xhr.responseText;
                    errorHtml += '</pre>';
                    errorHtml += '</div>';
                }
                
                errorHtml += '</div>';
                
                $('#NotifikasiTambahManual').html(errorHtml);
            }
        });
    });

    // Fungsi untuk menyalin error ke clipboard
    function copyErrorToClipboard() {
        var errorText = $('#NotifikasiTambahManual').text();
        
        // Buat textarea sementara
        var tempTextArea = document.createElement("textarea");
        tempTextArea.value = errorText;
        document.body.appendChild(tempTextArea);
        tempTextArea.select();
        tempTextArea.setSelectionRange(0, 99999); // Untuk mobile
        
        // Salin teks
        try {
            document.execCommand("copy");
            alert("Error berhasil disalin ke clipboard!");
        } catch (err) {
            console.error("Gagal menyalin: ", err);
            alert("Gagal menyalin error ke clipboard");
        }
        
        // Hapus textarea
        document.body.removeChild(tempTextArea);
    }

    // Fungsi untuk escape HTML, agar tidak broken ketika menampilkan string JSON
    function escapeHtml(text) {
        if (!text) return '';
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(text));
        return div.innerHTML;
    }

    // Modal Detail Medication KFA
    $(document).on('click', '.modal_detail', function () {

        //tangkap data 'kfa_code' dan buat variabel
        var id   = $(this).data('id');

        //tampilkan modal
        $('#ModalDetail').modal('show');

        //Form Loading
        $('#FormDetail').html('Loading...');

        //Tampilkan Form Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Medication/FormDetail.php',
            data        : {id: id},
            success     : function(data){
                $('#FormDetail').html(data);

                // 🔁 Re-inisialisasi tooltip setelah data dimuat
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        });
    });

    

    

});





