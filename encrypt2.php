<?php
include "koneksi.php"; // Pastikan koneksi ke database sudah benar

if (!$connect) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Ambil semua akun karyawan dari database
$query = "SELECT id_karyawan, password FROM karyawan";
$result = mysqli_query($connect, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id_karyawan = $row['id_karyawan'];
        $plaintext_password = $row['password'];

        if (!empty($plaintext_password)) {
            // Hash password
            $hashed_password = password_hash($plaintext_password, PASSWORD_BCRYPT);

            // Update password yang sudah di-hash ke database
            $update_query = "UPDATE karyawan SET password = ? WHERE id_karyawan = ?";
            $stmt = mysqli_prepare($connect, $update_query);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "si", $hashed_password, $id_karyawan);
                $execute = mysqli_stmt_execute($stmt);

                if ($execute) {
                    echo "Password untuk Karyawan ID $id_karyawan berhasil di-hash.<br>";
                } else {
                    echo "Gagal mengupdate password untuk Karyawan ID $id_karyawan: " . mysqli_stmt_error($stmt) . "<br>";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "Gagal mempersiapkan query untuk Karyawan ID $id_karyawan.<br>";
            }
        } else {
            echo "Password untuk Karyawan ID $id_karyawan kosong, tidak diproses.<br>";
        }
    }
} else {
    echo "Gagal mengambil data karyawan dari database: " . mysqli_error($connect);
}

mysqli_close($connect);
echo "Proses selesai.";
?>
