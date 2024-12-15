<?php
$connect = mysqli_connect('localhost', 'root', '', 'pengajuan_izin');

if (mysqli_connect_errno()) {
    // Jika koneksi gagal, tampilkan pesan error
    die("Koneksi gagal: " . mysqli_connect_error());
}

function getCurrentPage() {
    return basename($_SERVER['PHP_SELF']);
}
?>
