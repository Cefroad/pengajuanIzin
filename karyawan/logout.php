<?php
session_start();
session_destroy();
echo "<script>
        alert('Anda berhasil logout!');
        window.location.href = '../index.php';
      </script>";
exit();
?>
