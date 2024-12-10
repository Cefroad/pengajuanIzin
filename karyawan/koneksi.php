<?php
$connect = mysqli_connect('localhost','root','','pengajuan_izin');

function getCurrentPage() {
    return basename($_SERVER['PHP_SELF']);
}


?>
