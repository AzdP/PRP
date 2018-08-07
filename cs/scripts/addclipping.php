<?php
// add clipping
$sql = "INSERT INTO clipping
        VALUES ('', '$_SESSION[ed_sector]', '$_SESSION[ed_x]', '$_SESSION[ed_y]')";

$result = $db->db_query($sql);
?>