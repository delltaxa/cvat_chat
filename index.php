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


        function askagin() {
            let inkey = document.getElementById('keebox').value;
            opkey = inkey;
            $.post("verify_key.php",
                   {kee: inkey},
                   function(response){
                        if (response == 1) {
                            $("#messages").load("gmsg.php?pawd="+opkey);
                            if (!document.cookie.includes("cvat")) {
                                let user = "cvat" + Math.floor(Math.random() * (9999 - 1000) + 1000);
                                set_user(user);
                                createCookie("usdn", user, 1)
                            }
                            else {
                                set_user(getCookie("usdn"));
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

                            
                            document.getElementById('inkuy').value = inkey;
                            document.getElementById('ffm').hidden = true;
                            document.getElementById('fff').hidden = true;
                            document.getElementById('pbost').hidden = false;
                        }
                        else {
                            document.getElementById('loginmsg').style.color = "red";
                            document.getElementById('loginmsg').innerText = "";
                            setTimeout(() => { document.getElementById('loginmsg').innerText = "Incorrect Key!"; }, 200);
                        }
                   }
            );
        }

        window.onload = function() {      
            if (window.location != "?#messages") {
                window.location = "?#messages"
            }
        }     
        
    </script>
</head>
<body>
    <form class="vertical-center" onsubmit="askagin();" id="ffm" style="display:flex; justify-content: center;">
        <div id="fff" style="width: 260px; height: 130px; background-color: white; float: left; padding: 30px; border-radius: 5px;">
            <input type="password" style="height: 40px; width: 240px; font-size: 20px;" id="keebox">
            <br/>
            <p id="loginmsg" style="font-size: 16px; font-weight: bolder">Enter The Key</p>
            <input type="submit" value="Join!" style="width: 250px; height: 45px; text-align: center;">
        </div>
    </form>

    <div id="messages">
    </div>
    <form action="post.php" id="pbost" method="POST" hidden>
        <input hidden type="text" id="uname" name="name" />
        <input hidden type="text" name="inkay" id="inkuy">
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
