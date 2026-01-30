<?php
    // Koneksi Session Dan Function
    include "../../_Config/Connection.php";
    include "../../_Config/GlobalFunction.php";
    include "../../_Config/Session.php";

    // Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Validasi Sesi Akses
    if (empty($SessionIdAccess)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi Akses Sudah Berakhir. Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Validasi id_referensi_questionnaire
    if (empty($_POST['id_referensi_questionnaire'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Pertanyaan Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    // Buat Variabel 'id_referensi_questionnaire' dan sanitazi
    $id_referensi_questionnaire = validateAndSanitizeInput($_POST['id_referensi_questionnaire']);

    // Query Database 'referensi_denominator'
    $Qry = $Conn->prepare("SELECT * FROM referensi_questionnaire WHERE id_referensi_questionnaire = ?");
    $Qry->bind_param("i", $id_referensi_questionnaire);

    if (!$Qry->execute()) {
        echo '
            <div class="alert alert-danger">
                <small>Terjadi kesalahan saat membuka data!<br>
                Keterangan : ' . htmlspecialchars($Conn->error) . '</small>
            </div>
        ';
        exit;
    }

    $Result = $Qry->get_result();
    $Data   = $Result->fetch_assoc();
    $Qry->close();

    if (!$Data) {
        echo '
            <div class="alert alert-warning">
                <small>Data Pertanyaan tidak ditemukan.</small>
            </div>
        ';
        exit;
    }

    $id_questionnaire = $Data['id_questionnaire'];
    $link_id          = $Data['link_id'];
    $question_group   = $Data['question_group'];
    $question_text    = $Data['question_text'];
    $question_type    = $Data['question_type'];
    

    // Routing $question_type
    if($question_type=="boolean"){
        $label_boolean = "selected";
        $label_choice  = "";
        $label_text    = "";
        $label_decimal = "";
        $label_integer = "";
        $label_date    = "";
        $label_url     = "";
    }else{
        if($question_type=="choice"){
            $label_boolean = "";
            $label_choice  = "selected";
            $label_text    = "";
            $label_decimal = "";
            $label_integer = "";
            $label_date    = "";
            $label_url     = "";
        }else{
            if($question_type=="text"){
                $label_boolean = "";
                $label_choice  = "";
                $label_text    = "selected";
                $label_decimal = "";
                $label_integer = "";
                $label_date    = "";
                $label_url     = "";
            }else{
                if($question_type=="decimal"){
                    $label_boolean = "";
                    $label_choice  = "";
                    $label_text    = "";
                    $label_decimal = "selected";
                    $label_integer = "";
                    $label_date    = "";
                    $label_url     = "";
                }else{
                    if($question_type=="integer"){
                        $label_boolean = "";
                        $label_choice  = "";
                        $label_text    = "";
                        $label_decimal = "";
                        $label_integer = "selected";
                        $label_date    = "";
                        $label_url     = "";
                    }else{
                        if($question_type=="date"){
                            $label_boolean = "";
                            $label_choice  = "";
                            $label_text    = "";
                            $label_decimal = "";
                            $label_integer = "";
                            $label_date    = "selected";
                            $label_url     = "";
                        }else{
                            if($question_type=="url"){
                                $label_boolean = "";
                                $label_choice  = "";
                                $label_text    = "";
                                $label_decimal = "";
                                $label_integer = "";
                                $label_date    = "";
                                $label_url     = "selected";
                            }else{
                                $label_boolean = "";
                                $label_choice  = "";
                                $label_text    = "";
                                $label_decimal = "";
                                $label_integer = "";
                                $label_date    = "";
                                $label_url     = "";
                            }
                        }
                    }
                }
            }
        }
    }

    echo '
        <input type="hidden" name="id_referensi_questionnaire" value="'.$id_referensi_questionnaire.'">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="id_questionnaire_edit">ID Questionnaire</label>
            </div>
            <div class="col-md-8">
                <input type="text" readonly name="id_questionnaire" id="id_questionnaire_edit" class="form-control" value="'.$id_questionnaire.'">
            </div>
        </div>
    ';
    if(!empty($id_questionnaire)){
        echo '
            <div class="row mb-3">
                <div class="col-md-4"></div>
                <div class="col-md-8">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="kirim_ke_satu_sehat" id="kirim_ke_satu_sehat_edit" value="Ya" checked="">
                        <label class="form-check-label" for="kirim_ke_satu_sehat_edit">
                            <small>Generate ID Questionnaire Dari Satu Sehat</small>
                        </label>
                    </div>
                </div>
            </div>
        ';
    }
    echo '
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="question_group_edit_normal">Kategori Pertanyaan</label>
            </div>
            <div class="col-md-8">
                <input type="text" name="question_group" id="question_group_edit_normal" list="list_kategori_edit" class="form-control" value="'.$question_group.'">
                <datalist id="list_kategori_edit"></datalist>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="question_text_edit">Text Pertanyaan</label>
            </div>
                <div class="col-md-8">
                <input type="text" name="question_text" id="question_text_edit" class="form-control" value="'.$question_text.'">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="question_type_edit">Tipe Pertanyaan</label>
            </div>
            <div class="col-md-8">
                <select class="form-control" name="question_type" id="question_type_edit">
                    <option value = "">Pilih</option>
                    <option '.$label_boolean.' value = "boolean">Boolean</option>
                    <option '.$label_choice.' value = "choice">Choice</option>
                    <option '.$label_text.' value = "text">Text</option>
                    <option '.$label_decimal.' value = "decimal">Decimal</option>
                    <option '.$label_integer.' value = "integer">Integer</option>
                    <option '.$label_date.' value = "date">Date</option>
                    <option '.$label_url.' value = "url">URL</option>
                </select>
            </div>
        </div>
    ';
?>
<div class="row mb-3 mt-3" id="form_alternatif_edit">
    <div class="col-12 mb-3">
        <label><b>Alternatif Jawaban</b></label>
    </div>
    <div class="col-12 mb-3">
        <div class="table table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr class="border-top border-1">
                        <td class="text-center"><b>No</b></td>
                        <td class="text-center"><b>Value / Nilai</b></td>
                        <td class="text-center"><b>Option Display</b></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-md btn-primary tambah_alternatif_edit" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Tambah Alternatif Jawaban">
                                <i class="bi bi-plus"></i>
                            </button>
                        </td>
                    </tr>
                </thead>
                <tbody id="list_alternatif_edit">
                    <?php
                        if(!empty($Data['alternative'])){
                            $alternative      = $Data['alternative'];
                            $alternative_arry = json_decode($alternative, true);

                            // Looping Arry
                            $no = 1;
                            foreach ($alternative_arry as $alternative_list){
                                echo '
                                    <tr>
                                        <td class="text-center">'.$no.'</td>
                                        <td>
                                            <input type="text" name="alternatif_value[]" class="form-control" value="'.$alternative_list['code'].'">
                                        </td>
                                        <td>
                                            <input type="text" name="alternatif_display[]" class="form-control" value="'.$alternative_list['display'].'">
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-md btn-danger hapus_alternatif_edit">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </td>
                                    </tr>
                                ';
                                $no++;

                            }
                        }else{
                            echo '
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>
                                        <input type="text" name="alternatif_value[]" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="alternatif_display[]" class="form-control">
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-md btn-danger hapus_alternatif_edit">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>
                                        <input type="text" name="alternatif_value[]" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" name="alternatif_display[]" class="form-control">
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-md btn-danger hapus_alternatif_edit">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </td>
                                </tr>
                            ';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>