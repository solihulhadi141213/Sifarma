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
                <td colspan="10" class="text-center">
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
            $OrderBy="id";
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
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id FROM medication"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id FROM medication WHERE medication_code like '%$keyword%' OR medication_name like '%$keyword%' OR medication_category like '%$keyword%' OR sediaan_display like '%$keyword%' OR kfa_code like '%$keyword%'"));
            }
        }else{
            if(empty($keyword)){
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id FROM medication"));
            }else{
                $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id FROM medication WHERE $keyword_by like '%$keyword%'"));
            }
        }
        
        //Mengatur Halaman
        $JmlHalaman = ceil($jml_data/$batas); 
        if(empty($jml_data)){
            echo '
                <tr>
                    <td colspan="9" class="text-center">
                        <small class="text-danger">Tidak Ada Data Yang Ditampilkan!</small>
                    </td>
                </tr>
            ';
        }else{
            $no = 1+$posisi;
            //KONDISI PENGATURAN MASING FILTER
             if(empty($keyword_by)){
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM medication ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM medication WHERE medication_code like '%$keyword%' OR medication_name like '%$keyword%' OR medication_category like '%$keyword%' OR sediaan_display like '%$keyword%' OR kfa_code like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
            }else{
                if(empty($keyword)){
                    $query = mysqli_query($Conn, "SELECT*FROM medication ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }else{
                    $query = mysqli_query($Conn, "SELECT*FROM medication WHERE $keyword_by like '%$keyword%' ORDER BY $OrderBy $ShortBy LIMIT $posisi, $batas");
                }
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

                // Memotong Karakter medication_code
                if(empty($data['medication_code'])){
                    $medication_code_display = "-";
                }else{
                    $medication_code       = $data['medication_code'];
                    // Jika panjang string lebih dari 8 karakter, potong dan tambahkan ".."
                    if (strlen($medication_code) > 8) {
                        $medication_code_display = substr($medication_code, 0, 8) . "..";
                    } else {
                        $medication_code_display = $medication_code;
                    }
                }

                // Memotong Karakter ID Medication
                if(empty($data['id_medication'])){
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
                    <tr>
                        <td class="text-center"><small>'.$no.'</small></td>
                        <td>
                            <a href="javascript:void(0);" class="text-primary text-decoration-underline modal_detail" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="'.$medication_code .'" data-id="'.$id .'">
                                <small>'.$medication_code_display.'</small>
                            </a>
                        </td>
                        <td><small>'.$medication_name.'</small></td>
                        <td>'.$medication_category_display.'</td>
                        <td><small>'.$sediaan_display.'</small></td>
                        <td><small>'.$kfa_code.'</small></td>
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
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-dark btn-floating"  data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                                <li class="dropdown-header text-start">
                                    <h6>Option</h6>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalDetail" data-id="'.$id .'">
                                        <i class="bi bi-info-circle"></i> Detail
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalEdit" data-id="'.$id .'">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#ModalHapus" data-id="'.$id .'">
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