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
                    <h2>Sign up</h2>
                    <span class="byline">輸入以下資訊</span>
                </div>
                <form  action="add_user.php" method="POST" id="sign_up">
                    
                    <div >
                    <input placeholder="nickname" maxlength="10" name="nickname" type="text" id="nickname">
					</br></br>
					<span>性別　　　</span>
				        <select >
                            <option value='Man' >Man</option>
                            <option value='Woman' >Woman</option>
   					    </select>
				    </div>
                    </br>
					<div >
						<input placeholder="account" maxlength="10" name="account" type="text" id="account">
				    </div>
					</br>
					<div >
						<input placeholder="password" maxlength="10" name="password" type="text" id="password">
				    </div>
					</br>
					
					</br>
					<div >
						<select name="year" id="year">
								<?php 
									for($i=1917;$i<=2017;$i+=1)
									{
										echo "<option value={$i} >{$i}</option>\n";
									} 
								?>
   						</select>
						<span>年</span>
						<select name="month" id="month">
								<?php for($i=1;$i<=12;$i+=1){echo "<option value={$i}>{$i}</option>\n";} ?>
						</select>
						<span>月</span>
						<select name="day" id="day">
								<?php for($i=1;$i<=31;$i+=1){echo "<option value={$i} >{$i}</option>\n";} ?>
						</select>
						<span>日</span>
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
			$("#account").keyup(function() {
				if ($(this).value != "") {
					//非空
					//$.ajax 是 jQuery 的方法，裡面使用的是物件。
					$.ajax({
						type: "POST", //表單傳送的方式 同 form 的 method 屬性
						url: "check_user_account.php", //目標給哪個檔案 同 form 的 action 屬性
						data: { //為要傳過去的資料，使用物件方式呈現，因為變數key值為英文的關係，所以用物件方式送。ex: {name : "輸入的名字", password : "輸入的密碼"}
							'n': $(this).val() //代表要傳一個 n 變數值為，username 文字方塊裡的值
						},
						dataType: 'html' //設定該網頁回應的會是 html 格式
					}).done(function(data) {
						//成功的時候
						//console.log(data); //透過 console 看回傳的結果
						if (data == "yes") {
							alert("account重複，無法註冊");
							//把註冊按鈕加上 disabled 不能按，在bootstrap裡 disabled 類別可以讓該元素無法操作
							$("#submit").attr('disabled', true);
							if($(".alert").length<=0)
							{
								$("#account").after('<div class="alert alert-danger" role="alert"> <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> <span class="sr-only">Error:</span> Enter a valid account </div>');
							}
						} else {
							$("#submit").attr('disabled', false);
							$(".alert").remove();
						}
					}).fail(function(jqXHR, textStatus, errorThrown) {
						//失敗的時候
						alert("有錯誤產生，請看 console log");
						console.log(jqXHR.responseText);
					});
				} else {
					//不檢查	
				}
			});
			$("#sign_up").submit(function() {
			//使用 ajax 送出
			$.ajax({
				type: "POST",
				url: "add_user.php",
				data: {
					account: $("#account").val(), //使用者帳號
					//sex: $("#user_sex").val(), //
					password: $("#password").val(), //
					nickname: $("#nickname").val(),
					bd_y: $("#year").val(),
					bd_m: $("#month").val(),
					bd_d: $("#day").val()
				},
				dataType: 'html' //設定該網頁回應的會是 html 格式
			}).done(function(data) {
				//成功的時候
				if (data == "yes") {
					alert("註冊成功，將自動前往登入頁");
					//註冊新增成功，轉跳到登入頁面。
					window.location.href = "sign_in.php";
					window.event.returnValue = false;
				} else {
					alert("註冊失敗，請與系統人員聯繫");
				}

			}).fail(function(jqXHR, textStatus, errorThrown) {
				//失敗的時候
				alert("有錯誤產生，請看 console log");
				console.log(jqXHR.responseText);
			});
			return false;
		});
	});
	</script>
</body>

</html>