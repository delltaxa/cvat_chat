<?php
header("X-Frame-Options: DENY");
header("Content-Security-Policy: frame-ancestors 'none'", false);
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>#sCaS</title>
    <link rel="stylesheet" href="style.css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script>
        var opkey = "";


        function set_user(name) {
            document.getElementById('uname').value = name;
        }
        
        function createCookie(name, value, days) {
            var expires;
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            }
            else {
                expires = "";
            }
            document.cookie = name + "=" + value + expires + "; path=/";
        }

        function getCookie(c_name) {
            if (document.cookie.length > 0) {
                c_start = document.cookie.indexOf(c_name + "=");
                if (c_start != -1) {
                    c_start = c_start + c_name.length + 1;
                    c_end = document.cookie.indexOf(";", c_start);
                    if (c_end == -1) {
                        c_end = document.cookie.length;
                    }
                    return unescape(document.cookie.substring(c_start, c_end));
                }
            }
            return "";
        }

       

        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }

        function verf(a) {
            $.post("verify_key.php",
                   {kee: a},
                   function(response){
                        if (response == 1) {
                            return true;
                        }
                        else {
                            var askAgain = prompt('key', "xxxxxxxxx");
                            verf(askAgain);
                        }
                   }
            );
        }

        window.onload = function() {           
            const inkey = prompt("key", "xxxxxxxxx");
            opkey = inkey;
            $.post("verify_key.php",
                   {kee: inkey},
                   function(response){
                        if (response == 1) {
                            // correct
                        }
                        else {
                            window.location = "/";
                        }
                   }
            );

            $("#messages").load("gmsg.php?pawd="+opkey);
            if (!document.cookie.includes("cvat")) {
                let user = "cvat" + Math.floor(Math.random() * (9999 - 1000) + 1000);
                set_user(user);
                createCookie("usdn", user, 1)
            }
            else {
                set_user(getCookie("usdn"));
            }

            
        }

        $(document).ready(function () {
            $('#pbost').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url : $(this).attr('action'),
                    type: "POST",
                    data: $(this).serialize()
                });
                document.getElementById('message').value = "";
            });
        });

        var auto_refresh = setInterval(
            (function () {
                $("#messages").load("gmsg.php?pawd="+opkey);
        }), 1000);
        
    </script>
</head>
<body>
    <div id="messages">
    </div>
    <form action="post.php" id="pbost" method="POST">
        <input hidden type="text" id="uname" name="name" <?php if ($_SESSION['name'] !== null) {echo 'value=' . $_SESSION['name'];} ?> />
        <p></p>

        <div style="text-align: center;">
            <input type="text" id="message" class="msag" name="message" style="border-radius: 5px 0px 0px 5px;" autofocus />
            <input type="submit" value="Send" style="border-radius: 0px 5px 5px 0px;" />
        </div>

        <input type="checkbox" name="type" value="nojs" style="display:none" checked/>
        <br/><br/>
    </form>
</body>
</html>
