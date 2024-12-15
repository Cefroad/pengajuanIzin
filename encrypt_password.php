<?php
include "koneksi.php"; // Pastikan koneksi ke database sudah benar

// Ambil semua akun admin dari database
$result = mysqli_query($connect, "SELECT id_admin, password FROM admin");

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id_admin = $row['id_admin'];
        $plaintext_password = $row['password'];

        // Hash password
        $hashed_password = password_hash($plaintext_password, PASSWORD_BCRYPT);

        // Update password yang sudah di-hash ke database
        $update = mysqli_query($connect, "UPDATE admin SET password = '$hashed_password' WHERE id_admin = $id_admin");

        if ($update) {
            echo "Password untuk Admin ID $id_admin berhasil di-hash.<br>";
        } else {
            echo "Gagal mengupdate password untuk Admin ID $id_admin.<br>";
        }
    }
} else {
    echo "Gagal mengambil data admin dari database.";
}

echo "Proses selesai.";
?>
