<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_pengajuan = intval($_GET['id']);
    $query = "SELECT lampiran, filename, filetype FROM pengajuan_izin WHERE id_pengajuan = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_pengajuan);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $lampiran, $filename, $filetype);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($lampiran) {
        header("Content-Type: $filetype");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        echo $lampiran;
    } else {
        echo "Lampiran tidak ditemukan.";
    }
    exit;
}
?>
