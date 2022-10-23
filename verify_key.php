<?php
    include("config.php");
    $kee = $_POST['kee'];
    $true_kee = $passw;

    if ($kee == $true_kee) {
        echo "1";
    }
    else {
        echo "0";
    } 
?>