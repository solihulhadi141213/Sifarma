<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
   
    // Jumlah Data
    $jml_data = 0;

    //Validasi Akses
    if(empty($SessionIdAccess)){
        echo '
            <tr>
                <td colspan="6" class="text-center">
                    <small class="text-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
            <script>
                $("#page_info").html("Data : '.$jml_data.' Baris");
            </script>
        ';
        exit;
    }
    
    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_referensi_questionnaire FROM referensi_questionnaire WHERE status='active'"));
        
    if(empty($jml_data)){
        echo '
            <tr>
                <td colspan="6" class="text-center">
                    <small class="text-danger">Tidak Ada Data Yang Ditampilkan!</small>
                </td>
            </tr>
            <script>
                $("#page_info").html("Data : '.$jml_data.' Baris");
            </script>
        ';
        exit;
    }
    $no = 1;
    $query = mysqli_query($Conn, "SELECT DISTINCT question_group FROM referensi_questionnaire WHERE status='active' ORDER BY question_group ASC");
    while ($data = mysqli_fetch_array($query)) {
        $question_group = $data['question_group'];
       
        // Tampilkan Data
        echo '
            <tr>
                <td class="text-center">'.$no.'</td>
                <td colspan="4">'.$question_group.'</td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-secondary btn-floating modal_edit_kategori" data-id="'.$question_group .'">
                        <i class="bi bi-pencil"></i>
                    </button>
                </td>
            </tr>
            <script>
                $("#page_info").html("Data : '.$jml_data.' Baris");
            </script>
        ';

        // Buka Anggota
        $no2 = 1;
        $query2 = mysqli_query($Conn, "SELECT*FROM referensi_questionnaire WHERE question_group='$question_group' AND status='active'");
        while ($data2 = mysqli_fetch_array($query2)) {
            $id_referensi_questionnaire = $data2['id_referensi_questionnaire'];
            $id_questionnaire           = $data2['id_questionnaire'];
            $question_text              = $data2['question_text'];
            $question_type              = $data2['question_type'];
            $alternative                = $data2['alternative'];
            if(empty($id_questionnaire)){
                $label_q = '
                    <a href="javascrit:void(0);" class="text-warning modal_generate_satu_sehat" data-id="'.$id_referensi_questionnaire .'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Kirim Ke Resource Satu Sehat">
                        <i class="bi bi-plus"></i> Generate ID Questionnaire
                    </a>
                ';
            }else{
                $label_q = '
                    <a href="javascrit:void(0);" class="text-success modal_detail_satu_sehat" data-id="'.$id_questionnaire .'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Lihat Detail Dari Resource Satu Sehat">
                        <i class="bi bi-info-circle"></i> '.$id_questionnaire.'
                    </a>
                ';
            }
            // Tampilkan Data
             echo '
                <tr>
                    <td class="text-center"></td>
                    <td><small>'.$no.'.'.$no2.'</small></td>
                    <td class="">
                        <a href="javascript:void(0);" class="text text-decoration-underline modal_detail" data-id="'.$id_referensi_questionnaire .'">
                            <small>'.$question_text.'</small>
                        </a>
                    </td>
                    <td class=""><small>'.$question_type.'</small></td>
                    <td class=""><small>'.$label_q.'</small></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-floating"  data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                            <li class="dropdown-header text-start">
                                <h6>Option</h6>
                            </li>
                            <li>
                                <a class="dropdown-item modal_detail" href="javascript:void(0)" data-id="'.$id_referensi_questionnaire .'">
                                    <i class="bi bi-info-circle"></i> Detail
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item modal_edit" href="javascript:void(0)" data-id="'.$id_referensi_questionnaire .'">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item modal_hapus" href="javascript:void(0)" data-id="'.$id_referensi_questionnaire .'">
                                    <i class="bi bi-x"></i> Hapus
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            ';

            $no2++;
        }
        $no++;
    }
?>
<script>
    $("#page_info").html("Data : <?php echo $jml_data; ?> Baris");
</script>