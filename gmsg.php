<?php
    $chat = fopen("chat.txt", "a+") or die("Error upon opening file");
                
    include('config.php');
    include('endecr.php');

    $pw = $_GET['pawd'];


    while(!feof($chat)) {
      $mss = fgets($chat);

      $mss_pause = encrypt_decrypt("decrypt", $mss, $pw);
      $mss = $mss_pause;

      $message = "<div class=\"message\">" . $mss ."</div>";
      echo $message;
    }
            
    echo fread($chat,filesize("chat.txt"));
            
    fclose($chat);
?>