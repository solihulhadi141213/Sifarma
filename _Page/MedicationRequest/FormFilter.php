<?php
    include "../../_Config/Connection.php";

    // Jika tidak ada 'keyword_by'
    if(empty($_POST['keyword_by'])){
        echo '<input type="text" name="keyword" id="keyword" class="form-control">';
    }else{

        // Variabel 'keyword_by'
        $keyword_by=$_POST['keyword_by'];
        
        if($keyword_by=="datetime_creat"){
            echo '<input type="date" name="keyword" id="keyword" class="form-control">';
        }else{
            if($keyword_by=="kunjungan_tujuan"){
                // Select Distinct 'kunjungan_tujuan'
                echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                echo '  <option value="">Pilih</option>';
                $query = mysqli_query($Conn, "SELECT DISTINCT kunjungan_tujuan FROM medication_request_group ORDER BY kunjungan_tujuan ASC");
                while ($data = mysqli_fetch_array($query)) {
                    $kunjungan_tujuan= $data['kunjungan_tujuan'];
                    echo '  <option value="'.$kunjungan_tujuan.'">'.$kunjungan_tujuan.'</option>';
                }
                echo '</select>';
            }else{
                if($keyword_by=="kunjungan_pembayaran"){
                    // Select Distinct 'kunjungan_pembayaran'
                    echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                    echo '  <option value="">Pilih</option>';
                    $query = mysqli_query($Conn, "SELECT DISTINCT kunjungan_pembayaran FROM medication_request_group ORDER BY kunjungan_pembayaran ASC");
                    while ($data = mysqli_fetch_array($query)) {
                        $kunjungan_pembayaran= $data['kunjungan_pembayaran'];
                        echo '  <option value="'.$kunjungan_pembayaran.'">'.$kunjungan_pembayaran.'</option>';
                    }
                    echo '</select>';
                }else{
                    if($keyword_by=="dokter_nama"){
                        // Select Distinct 'dokter_nama'
                        echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                        echo '  <option value="">Pilih</option>';
                        $query = mysqli_query($Conn, "SELECT DISTINCT dokter_nama FROM medication_request_group ORDER BY dokter_nama ASC");
                        while ($data = mysqli_fetch_array($query)) {
                            $dokter_nama= $data['dokter_nama'];
                            echo '  <option value="'.$dokter_nama.'">'.$dokter_nama.'</option>';
                        }
                        echo '</select>';
                    }else{
                        if($keyword_by=="priority"){
                            // Select Distinct 'priority'
                            echo '<select type="text" name="keyword" id="keyword" class="form-control">';
                            echo '  <option value="">Pilih</option>';
                            $query = mysqli_query($Conn, "SELECT DISTINCT priority FROM medication_request_group ORDER BY priority ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $priority= $data['priority'];
                                echo '  <option value="'.$priority.'">'.$priority.'</option>';
                            }
                            echo '</select>';
                        }else{
                            echo '<input type="text" name="keyword" id="keyword" class="form-control">';
                        }
                    }
                }
            }
        }
    }
?>