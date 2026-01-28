<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
    $JmlHalaman=0;
    $page=0;
    //Validasi Akses
    if(empty($SessionIdAccess)){
        echo '
            <tr>
                <td colspan="12" class="text-center">
                    <small class="text-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
    }else{
        //Keyword_by
        if(!empty($_POST['keyword_by'])){
            $keyword_by=$_POST['keyword_by'];
        }else{
            $keyword_by="";
        }
        //keyword
        if(!empty($_POST['keyword'])){
            $keyword=$_POST['keyword'];
        }else{
            $keyword="";
        }
        //batas
        if(!empty($_POST['batas'])){
            $batas=$_POST['batas'];
        }else{
            $batas="10";
        }
        //ShortBy
        if(!empty($_POST['ShortBy'])){
            $ShortBy=$_POST['ShortBy'];
        }else{
            $ShortBy="DESC";
        }
        //OrderBy
        if(!empty($_POST['OrderBy'])){
            $OrderBy=$_POST['OrderBy'];
        }else{
            $OrderBy="id_medication_request_group";
        }
        //Atur Page
        if(!empty($_POST['page'])){
            $page=$_POST['page'];
            $posisi = ( $page - 1 ) * $batas;
        }else{
            $page="1";
            $posisi = 0;
        }
        if(empty($keyword_by)){
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_medication_request_group FROM medication_request_group"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_medication_request_group FROM medication_request_group WHERE id_pasien LIKE '%$keyword%' OR pasien_nama LIKE '%$keyword%' OR datetime_creat LIKE '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_medication_request_group FROM medication_request_group"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_medication_request_group FROM medication_request_group WHERE $keyword_by LIKE '%$keyword%'"));
            }
        }
        
        //Mengatur Halaman
        $JmlHalaman = ceil($jml_data/$batas); 
        if(empty($jml_data)){
            echo '
                <tr>
                    <td colspan="12" class="text-center">
                        <small class="text-danger">Tidak Ada Data Yang Ditampilkan!</small>
                    </td>
                </tr>
            ';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
             if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM medication_request_group ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM medication_request_group WHERE WHERE id_pasien LIKE '%$keyword%' OR pasien_nama LIKE '%$keyword%' OR datetime_creat LIKE '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM medication_request_group ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM medication_request_group WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }
            while ($data = mysqli_fetch_array($query)) {
                $id_medication_request_group = $data['id_medication_request_group'];
                $id_pasien                   = $data['id_pasien'];
                $pasien_nama                 = $data['pasien_nama'];
                $kunjungan_tujuan            = $data['kunjungan_tujuan'];
                $kunjungan_pembayaran        = $data['kunjungan_pembayaran'];
                $datetime_creat              = $data['datetime_creat'];
                $dokter_kode                 = $data['dokter_kode'];
                $dokter_nama                 = $data['dokter_nama'];
                $priority                    = $data['priority'];
                $status_resep                = $data['status_resep'];

                // Routing Label
                if($status_resep=="Draft"){
                    $label_status = '<span class="badge bg-warning">'.$status_resep.'</span>';
                }else{
                    if($status_resep=="Verified"){
                        $label_status = '<span class="badge bg-info">'.$status_resep.'</span>';
                    }else{
                        if($status_resep=="Partially"){
                            $label_status = '<span class="badge bg-secondary">'.$status_resep.'</span>';
                        }else{
                            if($status_resep=="Completed"){
                                $label_status = '<span class="badge bg-success">'.$status_resep.'</span>';
                            }else{
                                $label_status = '<span class="badge bg-danger">'.$status_resep.'</span>';
                            }
                        }
                    }
                }

                // Definisikan 'priority'
                $priority_list = [
                    'routine' => '<span class="text-info">Biasa</span>',
                    'urgent'  => '<span class="text-warning">Segera</span>',
                    'asap'    => '<span class="text-danger">Gawat</span>',
                    'stat'    => '<span class="text-danger">Darurat</span>',
                ];
                $priority_name = $priority_list[$priority] ?? '-';
                
                // Jumlah Item Resep
                $jumlah_item_resep = mysqli_num_rows(mysqli_query($Conn, "SELECT id_medication_request FROM medication_request WHERE id_medication_request_group='$id_medication_request_group '"));
                $jumlah_penyerahan = mysqli_num_rows(mysqli_query($Conn, "SELECT kode_medication_dispense FROM medication_dispense WHERE id_medication_request_group='$id_medication_request_group '"));
                
                // Routing Label Penyerahan Peresepan
                if(empty($jumlah_item_resep)){
                    $label_peresepan ='<label class="badge badge-danger">'.$jumlah_item_resep.' / '.$jumlah_penyerahan.'</label>';
                }else{
                    if(empty($jumlah_penyerahan)){
                        $label_peresepan ='<label class="badge badge-warning">'.$jumlah_item_resep.' / '.$jumlah_penyerahan.'</label>';
                    }else{
                        if($jumlah_penyerahan!==$jumlah_item_resep){
                            $label_peresepan ='<label class="badge badge-info">'.$jumlah_item_resep.' / '.$jumlah_penyerahan.'</label>';
                        }else{
                            $label_peresepan ='<label class="badge badge-success">'.$jumlah_item_resep.' / '.$jumlah_penyerahan.'</label>';
                        }
                    }
                }

                // Tampilkan Data
                echo '
                    <tr>
                        <td class="text-center"><small>'.$no.'</small></td>
                        <td>
                            <a href="javascript:void(0);" class="text-primary text-decoration-underline modal_detail_resep" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Lihat Detail Resep" data-id="'.$id_medication_request_group .'">
                                <small>'.$pasien_nama.'</small>
                            </a>
                        </td>
                        <td><small>'.$id_pasien.'</small></td>
                        <td><small>'.date('d/m/Y', strtotime($datetime_creat)).'</small></td>
                        <td><small>'.$kunjungan_tujuan.'</small></td>
                        <td><small>'.$kunjungan_pembayaran.'</small></td>
                        <td><small>'.$dokter_nama.'</small></td>
                        <td><small>'.$label_peresepan.'</small></td>
                        <td><small>'.$priority_name.'</small></td>
                        <td><small>'.$label_status.'</small></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-dark btn-floating"  data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow bg-body-secondary shadow-2-strong" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item modal_detail_resep" href="javascript:void(0)" data-id="'.$id_medication_request_group .'">
                                        <i class="bi bi-info-circle"></i> Detail
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item modal_edit_resep" href="javascript:void(0)" data-id="'.$id_medication_request_group .'">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item modal_hapus_resep" href="javascript:void(0)" data-id="'.$id_medication_request_group .'">
                                        <i class="bi bi-x"></i> Hapus
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                ';
                $no++;
            }
        }
    }
?>
<script>
    //Creat Javascript Variabel
    var page_count=<?php echo $JmlHalaman; ?>;
    var curent_page=<?php echo $page; ?>;
    
    //Put Into Pagging Element
    $('#page_info').html('Page '+curent_page+' Of '+page_count+'');
    
    //Set Pagging Button
    if(curent_page==1){
        $('#prev_button').prop('disabled', true);
    }else{
        $('#prev_button').prop('disabled', false);
    }
    if(page_count<=curent_page){
        $('#next_button').prop('disabled', true);
    }else{
        $('#next_button').prop('disabled', false);
    }
</script>