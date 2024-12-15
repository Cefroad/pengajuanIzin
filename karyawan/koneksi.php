<?php
$connect = mysqli_connect('localhost','root','','pengajuan_izin');

function getCurrentPage() {
    return basename($_SERVER['PHP_SELF']);
}

$date = date('Y-m-d'); // Format: Tahun-Bulan-Tanggal
setlocale(LC_TIME, 'id_ID'); // Untuk memastikan bahasa Indonesia
$date = date('d F Y'); // Format: Hari Bulan Tahun
$bulan = array(
    'January' => 'Januari',
    'February' => 'Februari',
    'March' => 'Maret',
    'April' => 'April',
    'May' => 'Mei',
    'June' => 'Juni',
    'July' => 'Juli',
    'August' => 'Agustus',
    'September' => 'September',
    'October' => 'Oktober',
    'November' => 'November',
    'December' => 'Desember'
);
$indo_date = strtr($date, $bulan); 

?>
