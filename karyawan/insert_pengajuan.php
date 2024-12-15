<?php
include 'koneksi.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_karyawan'])) {
    header('Location: login.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $tanggal_pengajuan = date('Y-m-d H:i:s');
    $tanggal_izin_mulai = $_POST['start_date'];
    $tanggal_izin_selesai = $_POST['end_date'];
    $id_jenis = $_POST['leave_type'];
    $alasan = $_POST['reason'];
    $status = 'Sedang Menunggu';

    // Ambil id_karyawan dari session
    $id_karyawan = $_SESSION['id_karyawan'];

    // Handle file upload (lampiran) jika ada
    $file_data = null;
    $filename = null;
    $filetype = null;
    $file_attachment = NULL; // Variabel untuk file yang di-upload

    // Cek jika ada file yang di-upload
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
        // Ambil tipe file
        $filetype = $_FILES['attachment']['type'];

        // Cek tipe file (hanya PDF yang diterima)
        if ($filetype != 'application/pdf') {
            echo "<script>alert('Error: Hanya file PDF yang diterima.');</script>";
            exit;
        }

        // Baca file dan convert menjadi BLOB
        $file_tmp = $_FILES['attachment']['tmp_name'];
        $file_data = file_get_contents($file_tmp);
        $filename = $_FILES['attachment']['name'];

        // Cek apakah file dapat dibaca
        if ($file_data === false) {
            echo "<script>alert('Error: File tidak dapat dibaca.');</script>";
            exit;
        }

        // Tentukan lampiran untuk file yang di-upload
        $file_attachment = $file_data;
    }

    // Ambil maksimal hari dari jenis izin yang dipilih
    $query_jenis_izin = mysqli_query($connect, "SELECT maks_hari FROM jenis_izin WHERE id_jenis = '$id_jenis'");
    $row_jenis_izin = mysqli_fetch_assoc($query_jenis_izin);
    $max_hari = $row_jenis_izin['maks_hari'];

    // Hitung durasi izin
    $start_date = strtotime($tanggal_izin_mulai);
    $end_date = strtotime($tanggal_izin_selesai);
    $days_diff = ($end_date - $start_date) / (60 * 60 * 24) + 1; // Termasuk hari mulai

    // Periksa apakah durasi melebihi batas maksimal
    if ($days_diff > $max_hari) {
        echo "<script>alert('Durasi izin melebihi batas maksimal $max_hari hari.');</script>";
        exit;
    }

    // Query untuk mengambil sisa saldo izin karyawan untuk jenis izin yang dipilih
    $query_saldo_izin = mysqli_query($connect, "SELECT remaining_izin FROM karyawan WHERE id_karyawan = '$id_karyawan'");
    $row_saldo_izin = mysqli_fetch_assoc($query_saldo_izin);
    $saldo_izin = $row_saldo_izin['remaining_izin'];

    // Periksa apakah saldo izin cukup
    if ($saldo_izin < $days_diff) {
        echo "<script>alert('Saldo izin tidak cukup untuk mengajukan izin selama $days_diff hari.');</script>";
        exit;
    }

    // Kurangi saldo izin karyawan
    $new_saldo_izin = $saldo_izin - $days_diff;
    $update_saldo_izin = "UPDATE karyawan SET remaining_izin = '$new_saldo_izin' WHERE id_karyawan = '$id_karyawan'";
    if (!mysqli_query($connect, $update_saldo_izin)) {
        echo "<script>alert('Error: Gagal mengupdate saldo izin.');</script>";
        exit;
    }

    // Query untuk memasukkan data pengajuan izin ke dalam database
    // Lampiran dan file lainnya bisa NULL jika tidak ada file yang di-upload
    $query = "INSERT INTO pengajuan_izin 
              (id_karyawan, tanggal_pengajuan, tanggal_izin_mulai, tanggal_izin_selesai, id_jenis, alasan, status, lampiran, filename, filetype) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Menggunakan prepared statement untuk menghindari SQL injection
    if ($stmt = mysqli_prepare($connect, $query)) {
        // Bind parameter untuk data yang akan disimpan
        // Jika tidak ada file, lampiran, filename, dan filetype di-set NULL
        if ($file_attachment === NULL) {
            mysqli_stmt_bind_param($stmt, 'isssssssss', 
                $id_karyawan, 
                $tanggal_pengajuan, 
                $tanggal_izin_mulai, 
                $tanggal_izin_selesai, 
                $id_jenis, 
                $alasan, 
                $status, 
                $file_attachment,  
                $filename,        
                $filetype          
            );
        } else {
            mysqli_stmt_bind_param($stmt, 'isssssssss', 
                $id_karyawan, 
                $tanggal_pengajuan, 
                $tanggal_izin_mulai, 
                $tanggal_izin_selesai, 
                $id_jenis, 
                $alasan, 
                $status, 
                $file_attachment, 
                $filename, 
                $filetype
            );
        }

        // Eksekusi query
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Pengajuan izin berhasil!');window.location='pengajuan.php';</script>";
            exit;
        } else {
            echo "<script>alert('Error: " . mysqli_error($connect) . "');</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error: Query gagal dieksekusi.');</script>";
    }
}
?>
