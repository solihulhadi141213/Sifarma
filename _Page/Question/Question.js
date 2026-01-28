//Fungsi Menampilkan Data
function ShowData() {
    var $tabel       = $('#TabelQuestion');

    // Tambahkan efek visual loading (opacity menurun)
    $tabel.css({
        'opacity': '0.5',
        'pointer-events': 'none',
        'transition': 'opacity 0.3s ease'
    });

    $.ajax({
        type   : 'POST',
        url    : '_Page/Question/TabelQuestion.php',
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
            $tabel.html('<tr><td class="text-center" colspan="5"><small class="text-danger">Gagal Memuat, Silahkan Coba Lagi!</small></td></tr>');
            $tabel.css({
                'opacity': '1',
                'pointer-events': 'auto'
            });
        }
    });
}

// ================================================================================================================================================
// BATAS SUCI
// ================================================================================================================================================

//Menampilkan Data Pertama Kali
$(document).ready(function() {

    //Menampilkan Data Pertama Kali
    ShowData();

    //Ketika Data Di Filter Kembalikan Ke Halaman Awal
    $('#reload_data').click(function(){
        ShowData();
    });

    
    // ================================================================================================================================================
    // TAMBAH Question
    // ================================================================================================================================================
    $(document).on('click', '.modal_tambah', function () {

        // Tampilkan modal 'ModalTambah'
        $('#ModalTambah').modal('show');

    });

    //Ketika Modal Tambah Muncul
    $('#ModalTambah').on('show.bs.modal', function (e) {
        // Menangkap question_type
        var question_type = $('#question_type').val();

        // Menampilkan Datalist Category Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Question/list_kategori.php',
            success     : function(data){
                $('#list_kategori').html(data);
            }
        });

        if(question_type!=="choice"){
            $('#form_alternatif').hide();
        }
    });

    $(document).on('change', '#question_type', function () {
        let question_type = $(this).val();

        if (question_type !== "choice") {
            $('#form_alternatif').hide();
        } else {
            $('#form_alternatif').show();
        }
    });

    // Tambah baris alternatif
    $(document).on('click', '.tambah_alternatif', function () {
        let jumlah = $('#list_alternatif tr').length + 1;

        let row = `
            <tr>
                <td class="text-center">${jumlah}</td>
                <td>
                    <input type="text" name="alternatif_value[]" class="form-control" required>
                </td>
                <td>
                    <input type="text" name="alternatif_display[]" class="form-control" required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-md btn-danger hapus_alternatif" 
                        data-bs-toggle="tooltip" title="Hapus Alternatif Jawaban">
                        <i class="bi bi-x"></i>
                    </button>
                </td>
            </tr>
        `;

        $('#list_alternatif').append(row);
    });

    // Hapus baris alternatif
    $(document).on('click', '.hapus_alternatif', function () {

        let total = $('#list_alternatif tr').length;

        // Optional: cegah hapus jika tinggal 1 baris
        if (total <= 1) {
            alert('Minimal harus ada 1 alternatif jawaban');
            return;
        }

        $(this).closest('tr').remove();

        // Re-index nomor
        $('#list_alternatif tr').each(function (index) {
            $(this).find('td:first').text(index + 1);
        });
    });

    //Proses Tambah
    $('#ProsesTambah').submit(function(e){
        e.preventDefault();
        
        // Ambil Data Dari form
        var ProsesTambah = $(this).serialize();

        //Loading Notifikasi
        $('#NotifikasiTambah').html('<small class="text-muted">Menyimpan data...</small>');

        // Ajax Request
        $.ajax({
            type     : 'POST',
            url      : '_Page/Question/ProsesTambah.php',
            dataType : 'json',
            data     : ProsesTambah,

            success: function(response){

                var status  = response.status;
                var message = response.message || 'Proses berhasil';

                if(status === 'success'){

                    // Bersihkan notifikasi
                    $('#NotifikasiTambah').html('');

                    // Tutup modal jika ada
                    $('#ModalTambah').modal('hide');

                    // Reset Form
                    $("#ProsesTambah")[0].reset();

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
                    $('#NotifikasiTambah').html(
                        '<div class="alert alert-danger"><small>'+message+'</small></div>'
                    );
                }
            },

            error: function(xhr){
                console.log(xhr.responseText);

                $('#NotifikasiTambah').html(
                    '<div class="alert alert-danger"><small>Terjadi kesalahan sistem</small></div>'
                );
            }
        });
    });

    // ================================================================================================================================================
    // EDIT Question
    // ================================================================================================================================================
    // Modal Edit
    $(document).on('click', '.modal_edit', function () {

        //tangkap data 'kfa_code' dan buat variabel
        var id_referensi_Question   = $(this).data('id');

        //tampilkan modal
        $('#ModalEdit').modal('show');

        //Form Loading
        $('#FormEdit').html('Loading...');

        //Tampilkan Form Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Question/FormEdit.php',
            data        : {id_referensi_Question: id_referensi_Question},
            success     : function(data){
                $('#FormEdit').html(data);

                // 🔁 Re-inisialisasi tooltip setelah data dimuat
                $('[data-bs-toggle="tooltip"]').tooltip();

                // Menampilkan Datalist Category Dengan AJAX
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Question/list_system.php',
                    success     : function(data){
                        $('#list_system_edit').html(data);
                    }
                });
            }
        });
    });

    //Proses Edit
    $('#ProsesEdit').submit(function(e){
        e.preventDefault();
        
        // Ambil Data Dari form
        var ProsesEdit = $(this).serialize();

        //Loading Notifikasi
        $('#NotifikasiEdit').html('<small class="text-muted">Menyimpan data...</small>');

        // Ajax Request
        $.ajax({
            type     : 'POST',
            url      : '_Page/Question/ProsesEdit.php',
            dataType : 'json',
            data     : ProsesEdit,

            success: function(response){

                var status  = response.status;
                var message = response.message;

                if(status === 'success'){

                    // Bersihkan notifikasi
                    $('#NotifikasiEdit').html('');

                    // Tutup modal jika ada
                    $('#ModalEdit').modal('hide');

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
                    $('#NotifikasiEdit').html(
                        '<div class="alert alert-danger"><small>'+message+'</small></div>'
                    );
                }
            },

            error: function(xhr){
                console.log(xhr.responseText);

                $('#NotifikasiEdit').html(
                    '<div class="alert alert-danger"><small>Terjadi kesalahan sistem</small></div>'
                );
            }
        });
    });
    // ================================================================================================================================================
    // HAPUS Question
    // ================================================================================================================================================
    // Modal Hapus
    $(document).on('click', '.modal_hapus', function () {

        //tangkap data 'kfa_code' dan buat variabel
        var id_referensi_Question   = $(this).data('id');

        //tampilkan modal
        $('#ModalHapus').modal('show');

        //Form Loading
        $('#FormHapus').html('Loading...');

        //Tampilkan Form Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Question/FormHapus.php',
            data        : {id_referensi_Question: id_referensi_Question},
            success     : function(data){
                $('#FormHapus').html(data);
            }
        });
    });

    //Proses Hapus
    $('#ProsesHapus').submit(function(e){
        e.preventDefault();
        
        // Ambil Data Dari form
        var ProsesHapus = $(this).serialize();

        //Loading Notifikasi
        $('#NotifikasiHapus').html('<small class="text-muted">Loading...</small>');

        // Ajax Request
        $.ajax({
            type     : 'POST',
            url      : '_Page/Question/ProsesHapus.php',
            dataType : 'json',
            data     : ProsesHapus,

            success: function(response){

                var status  = response.status;
                var message = response.message;

                if(status === 'success'){

                    // Bersihkan notifikasi
                    $('#NotifikasiHapus').html('');

                    // Tutup modal jika ada
                    $('#ModalHapus').modal('hide');

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
                    $('#NotifikasiHapus').html(
                        '<div class="alert alert-danger"><small>'+message+'</small></div>'
                    );
                }
            },

            error: function(xhr){
                console.log(xhr.responseText);

                $('#NotifikasiHapus').html(
                    '<div class="alert alert-danger"><small>Terjadi kesalahan sistem</small></div>'
                );
            }
        });
    });

    

});





