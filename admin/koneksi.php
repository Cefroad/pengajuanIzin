<?php
$connect = mysqli_connect('localhost','root','','pengajuan_izin');

function getCurrentPage() {
    return basename($_SERVER['PHP_SELF']);
}

?>
<script>
        function confirmLogout(){
            if(confirm("Apakah Anda ingin Logout ?")){
                Window.location.href = "logout.php";
            }
        }
    </script>