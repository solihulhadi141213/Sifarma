<?php
    //koneksi dan session
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";
    date_default_timezone_set("Asia/Jakarta");
   
    //Validasi Akses
    if(empty($SessionIdAccess)){
        echo '
            <tr>
                <td colspan="6" class="text-center">
                    <small class="text-danger">Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
                </td>
            </tr>
        ';
        exit;
    }
    
    $jml_data = mysqli_num_rows(mysqli_query($Conn, "SELECT id_referensi_questionnaire FROM referensi_questionnaire"));
        
    if(empty($jml_data)){
        echo '
            <tr>
                <td colspan="6" class="text-center">
                    <small class="text-danger">Tidak Ada Data Yang Ditampilkan!</small>
                </td>
            </tr>
        ';
        exit;
    }
    $no = 1;
    $query = mysqli_query($Conn, "SELECT DISTINCT question_group FROM referensi_questionnaire ORDER BY question_group ASC");
    while ($data = mysqli_fetch_array($query)) {
        $question_group = $data['question_group'];
       
        // Tampilkan Data
        echo '
            <tr>
                <td class="text-center">'.$no.'</td>
                <td colspan="5">'.$question_group.'</td>
            </tr>
        ';

        // Buka Anggota
        $no2 = 1;
        $query2 = mysqli_query($Conn, "SELECT*FROM referensi_questionnaire WHERE question_group='$question_group'");
        while ($data2 = mysqli_fetch_array($query2)) {
            $id_referensi_questionnaire = $data2['id_referensi_questionnaire'];
            $id_questionnaire           = $data2['id_questionnaire'];
            $question_text              = $data2['question_text'];
            $question_type              = $data2['question_type'];
            $alternative                = $data2['alternative'];
            if(empty($id_questionnaire)){
                $label_q = '
                    <a href="javascrit:void(0);" class="text-warning generate_satu_sehat" data-id="'.$id_referensi_questionnaire .'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Kirim Ke Resource Satu Sehat">
                        <i class="bi bi-plus"></i> Generate ID Questionnaire
                    </a>
                ';
            }else{
                $label_q = '
                    <a href="javascrit:void(0);" class="text-success detail_id_questionnaire" data-id="'.$id_questionnaire .'" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Lihat Detail Resource Satu Sehat">
                        <i class="bi bi-info-circle"></i> '.$id_questionnaire.'
                    </a>
                ';
            }
            // Tampilkan Data
             echo '
                <tr>
                    <td class="text-center"></td>
                    <td><small>'.$no.'.'.$no2.'</small></td>
                    <td class=""><small>'.$question_text.'</small></td>
                    <td class=""><small>'.$question_type.'</small></td>
                    <td class=""><small>'.$label_q.'</small></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-dark btn-floating"  data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" style="">
                            <li class="dropdown-header text-start">
                                <h6>Option</h6>
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
