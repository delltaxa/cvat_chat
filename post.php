<?php
    header("X-Frame-Options: DENY");
    header("Content-Security-Policy: frame-ancestors 'none'", false);
    header("Content-Type: application/json; charset=UTF-8");
    
    session_start();

    function scrub($input) {
        $splitted = explode('<', $input);
        $splitted = implode('&lt;', $splitted);
        $splitted = explode('>', $splitted);
        $splitted = implode('&gt;', $splitted);
        return $splitted;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['type'] == "nojs") {
            $data['name'] = $_POST['name'];
            $data['message'] = $_POST['message'];

            header('Location: nojs.php#message');
        } else {
        
            $data = json_decode(file_get_contents("php://input"), false);
            print_r($data);
        }
    }

    $data = (array) $data;

    date_default_timezone_set("UTC");
    
    $chat = fopen('chat.txt', 'a') or die('Error upon opening file');

    $name = 'anonymous';

    if ($_POST['name'] !== '') {
        $name = $data['name'];
    }

    $message = scrub($data['message']);
    
    $name = scrub($name);
    $name = explode(' ', $name);
    $name = implode('_', $name);

    $_SESSION['name'] = $name;

    $text = '<name>' . $name . '</name>' . '<message>' . $message . '</message>  <date>' . date("Y-m-d") . ' ' . date("H:i:s") . "</date>\n";

    include('config.php');
    include('endecr.php');

    $text_paus = encrypt_decrypt("encrypt", $text, $passw);
    $text = $text_paus . "\n";

    if ($message !== '') {
        $status = 'Success!';
        fwrite($chat, $text);
    }
    else {
        $status = 'Error. No message';
    }

    echo $status;

    fclose($chat);
?>
