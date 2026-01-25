<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    
    // Inisialisasi Jumlah Halaman Dan Posisi Halaman
    $JmlHalaman = 0;
    $page       = 0;
    
    //Validasi Akses
    if(empty($SessionIdAccess)){
        echo '
            <tr>
                <td colspan="7" class="text-center">
                    <small class="text-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }

    // Validasi 'id_medication_request_group'
    if(empty($_POST['id_medication_request_group'])){
        echo '
            <tr>
                <td colspan="7" class="text-center">
                    <small class="text-danger">ID Resep Tidak Boleh Kosong</small>
                </td>
            </tr>
        ';
        exit;
    }
    $id_medication_request_group=$_POST['id_medication_request_group'];

    //keyword
    if(!empty($_POST['keyword'])){
        $keyword=$_POST['keyword'];
    }else{
        $keyword="";
    }
    $batas   = "10";
    $ShortBy = "DESC";
    $OrderBy = "id";

    //Atur Page
    if(!empty($_POST['page'])){
        $page=$_POST['page'];
        $posisi = ( $page - 1 ) * $batas;
    }else{
        $page="1";
        $posisi = 0;
    }
    if(empty($keyword)){
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id FROM medication"));
    }else{
        $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id FROM medication WHERE medication_code like '%$keyword%' OR medication_name like '%$keyword%' OR medication_category like '%$keyword%' OR sediaan_display like '%$keyword%' OR kfa_code like '%$keyword%'"));
    }
        
    //Mengatur Halaman
    $JmlHalaman = ceil($jml_data/$batas); 
    if(empty($jml_data)){
        echo '
            <tr>
                <td colspan="7" class="text-center">
                    <small class="text-danger">Tidak Ada Data Yang Ditampilkan!</small>
                </td>
            </tr>
        ';
        exit;
    }
    $no = 1+$posisi;
    //KONDISI PENGATURAN MASING FILTER
    if(empty($keyword)){
        $query = mysqli_query($Conn, "SELECT*FROM medication ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
    }else{
        $query = mysqli_query($Conn, "SELECT*FROM medication WHERE medication_code like '%$keyword%' OR medication_name like '%$keyword%' OR medication_category like '%$keyword%' OR sediaan_display like '%$keyword%' OR kfa_code like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
    }
    while ($data = mysqli_fetch_array($query)) {
        $id                  = $data['id'];
        $medication_code     = $data['medication_code'];
        $medication_name     = $data['medication_name'];
        $medication_category = $data['medication_category'];
        $kfa_code            = $data['kfa_code'];
        $sediaan_display     = $data['sediaan_display'];
        $racikan_code        = $data['racikan_code'];
        $racikan_display     = $data['racikan_display'];

        // Memotong Karakter ID Medication
        if(empty($data['id_medication'])){
            $id_medication = "";
            $id_medication_display = "-";
        }else{
            $id_medication       = $data['id_medication'];
            // Jika panjang string lebih dari 8 karakter, potong dan tambahkan ".."
            if (strlen($id_medication) > 8) {
                $id_medication_display = substr($id_medication, 0, 8) . "..";
            } else {
                $id_medication_display = $id_medication;
            }
        }

        // Routing 'medication_category'
        if(empty($data['medication_category'])){
            $medication_category_display = "-";
        }else{
            $medication_category = $data['medication_category'];
            if($medication_category=="Obat"){
                $medication_category_display = '<span class="badge badge-success">Obat</span>';
            }else{
                if($medication_category=="Alkes"){
                    $medication_category_display = '<span class="badge badge-danger">Alkes</span>';
                }else{
                    $medication_category_display = '<span class="badge badge-dark">Lainnya</span>';
                }
            }
        }
                
                
        // Tampilkan Data
        echo '
            <tr class="modal_tambah_item" style="cursor:pointer;" data-id="'.$id_medication_request_group.'" data-id_item="'.$id.'">
                <td class="text-center"><small>'.$no.'</small></td>
                <td><small>'.$medication_code.'</small></td>
                <td><small>'.$medication_name.'</small></td>
                <td>'.$medication_category_display.'</td>
                <td><small>'.$sediaan_display.'</small></td>
                <td>
                    <small data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.$racikan_display .'">
                        '.$racikan_code.'
                    </small>
                </td>
                <td>
                    <small class="text text-grayish" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.$id_medication .'">
                        '.$id_medication_display.'
                    </small>
                </td>
            </tr>
        ';
        $no++;
    }
?>
<script>
    //Creat Javascript Variabel
    var page_count=<?php echo $JmlHalaman; ?>;
    var curent_page=<?php echo $page; ?>;
    
    //Put Into Pagging Element
    $('#page_info_obat_alkes').html(''+curent_page+' / '+page_count+'');
    
    //Set Pagging Button
    if(curent_page==1){
        $('#prev_button_obat_alkes').prop('disabled', true);
    }else{
        $('#prev_button_obat_alkes').prop('disabled', false);
    }
    if(page_count<=curent_page){
        $('#next_button_obat_alkes').prop('disabled', true);
    }else{
        $('#next_button_obat_alkes').prop('disabled', false);
    }
</script>