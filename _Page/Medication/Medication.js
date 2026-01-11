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





