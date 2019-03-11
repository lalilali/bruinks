<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by TEMPLATED
http://templated.co
Released for free under the Creative Commons Attribution License

Name       : Skeleton 
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20130902

-->
<?php
//載入 db.php 檔案，讓我們可以透過它連接資料庫，因為此檔案放在 admin 裡，要找到 db.php 就要回上一層 ../php 裡面才能找到
require_once 'php/db.php';
@session_start();
//如過有 $_SESSION['is_login'] 這個值，以及 $_SESSION['is_login'] 為 true 都代表已登入

?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
    <link href="default1.css" rel="stylesheet" type="text/css" media="all" />
    <link href="fonts.css" rel="stylesheet" type="text/css" media="all" />

    <!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->

</head>

<body>
    <div id="page" class="container">
        <div id="header">
            <div id="menu">
                <ul>
                    <li class="current_page_item"><a href="index.php" accesskey="1" title="">Homepage</a></li>

                </ul>
            </div>
        </div>
        <div id="main">
            <div id="banner">

            </div>
            <div id="welcome">
                <div class="title">
                    <h2>Sign in</h2>
                    <span class="byline">輸入帳號密碼</span>
                </div>
                <form method="POST" id="sign_in">
                    
                  
                    </br>
					<div >
						<input placeholder="account" maxlength="10" name="account" type="text" id="account">
				    </div>
					</br>
					<div >
						<input placeholder="password" maxlength="10" name="password" type="text" id="password">
				    </div>
					</br>
					<div >
						
						<input id="submit" type="submit" value="Send Message" />
						<input type="reset" value="Reset"  />
						
					</div>
                </form>
            </div>

            <div id="copyright">
                <span>&copy; Bruinks. All rights reserved. | Photos by <a href="http://fotogrph.com/">Fotogrph</a></span>
                <span>Design by <a href="https://www.facebook.com/Bruinks-1381790968576517/" rel="nofollow">Bruinks</a>.</span>
            </div>
        </div>
    </div>
	
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script>
	$(document).ready(function() {
		
			$("#sign_in").submit(function(){
				  //使用 ajax 送出 帳密給 verify_user.php
					$.ajax({
            type : "POST",
            url : "php/verify_user.php", //因為此 login.php 是放在 admin 資料夾內，若要前往 php，就要回上一層 ../ 找到 php 才能進入 verify_user.php
            data : {
              account : $("#account").val(), //使用者帳號
              password : $("#password").val() //使用者密碼
            },
            dataType : 'html' //設定該網頁回應的會是 html 格式
          }).done(function(data) {
            //成功的時候
            console.log(data);
            if(data == "yes")
            {
              //註冊新增成功，轉跳到登入頁面。
			alert("登入成功!!");
              window.location.href = "index2.php";
            }
            else
            {
              alert("登入失敗，請確認帳號密碼");
            }
            
          }).fail(function(jqXHR, textStatus, errorThrown) {
            //失敗的時候
            alert("有錯誤產生，請看 console log");
            console.log(jqXHR.responseText);
          });
	        //回傳 false 為了要阻止 from 繼續送出去。由上方ajax處理即可
          return false;
		});
	});
	</script>
</body>

</html>