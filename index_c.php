<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
//載入資料庫與處理的方法
require_once 'php/db.php';
require_once 'php/function.php';

@session_start();
if(!isset($_SESSION['is_login']) || !($_SESSION['is_login']))
	{
		header("Location: sign_in.php");
	
    }
$user_data=$_SESSION['login_user'];
?>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <head>
        <title>聊天室</title>
    </head>

    <link rel="stylesheet" href="style.css" type="text/css" />

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript">
        var instanse = false;
        var state;
        var mes;
        var file;

        function Chat() {
            this.update = updateChat;
            this.send = sendChat;
            this.getState = getStateOfChat;
        }

        //gets the state of the chat
        function getStateOfChat() {
            if (!instanse) {
                instanse = true;
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {
                        'function': 'getState',
                        'file': file
                    },
                    dataType: "json",

                    success: function(data) {
                        state = data.state;
                        instanse = false;
                    },
                });
            }
        }

        //Updates the chat
        function updateChat() {
            if (!instanse) {
                instanse = true;
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {
                        'function': 'update',
                        'state': state,
                        'file': file
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.text) {
                            for (var i = 0; i < data.text.length; i++) {
                                $('#chat-area').append($("<p>" + data.text[i] + "</p>"));
                            }
                        }
                        document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
                        instanse = false;
                        state = data.state;
                    },
                });
            } else {
                setTimeout(updateChat, 1500);
            }
        }

        //send the message
        function sendChat(message, nickname, profile) {
            updateChat();
            $.ajax({
                type: "POST",
                url: "process.php",
                data: {
                    'function': 'send',
                    'message': message,
                    'nickname': nickname,
                    'profile': profile,
                    'file': file
                },
                dataType: "json",
                success: function(data) {
                    updateChat();
                },
            });
        }

    </script>
    <script type="text/javascript">
        // user name    
        var name = '<?php echo $user_data['nickname'] ?>';

        var file_path = '<?php echo $user_data['profile'] ?>';
        if (file_path != null) { // display name on page
            $("#name-area").html("<img src=" + file_path + " alt='' />");
        } else {
            $("#name-area").html("<img src='image/pic02.jpg' alt='' />");
        }
        $("#name-area").html("<span>" + name + "</span>");
        // kick off chat
        var chat = new Chat();
        $(function() {

            chat.getState();

            // watch textarea for key presses
            $("#sendie").keydown(function(event) {

                var key = event.which;

                //all keys including return.  
                if (key >= 33) {

                    var maxLength = $(this).attr("maxlength");
                    var length = this.value.length;

                    // don't allow new content if length is maxed out
                    if (length >= maxLength) {
                        event.preventDefault();
                    }
                }
            });
            // watch textarea for release of key press
            $('#sendie').keyup(function(e) {
                if (e.keyCode == 13 && e.ctrlKey) {
                    document.getElementById("sendie").value += "\n";
                } else if (e.keyCode == 13) {

                    var text = $(this).val();
                    var maxLength = $(this).attr("maxlength");
                    var length = text.length;

                    // send 
                    if (length <= maxLength + 1) {

                        chat.send(text, name, file_path);
                        $(this).val("");

                    } else {

                        $(this).val(text.substring(0, maxLength));

                    }


                }
            });
        });

    </script>

</head>

<body onload="setInterval('chat.update()', 10000)">

    <div id="page-wrap">

        <h2>Chat room</h2>

        <p id="name-area"></p>

        <div id="chat-wrap">
            <div id="chat-area"></div>
        </div>

        <form id="send-message-area">
            <p>輸入訊息: </p>
            <textarea id="sendie" maxlength='1000'></textarea>
        </form>

    </div>

</body>

</html>
