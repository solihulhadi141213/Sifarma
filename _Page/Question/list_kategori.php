<?php
    include "../../_Config/Connection.php";
    $query = mysqli_query($Conn, "SELECT DISTINCT question_group FROM referensi_questionnaire ORDER BY question_group ASC");
    while ($data = mysqli_fetch_array($query)) {
        $question_group = $data['question_group'];
        echo '<option value="'.$question_group.'">';
    }
?>