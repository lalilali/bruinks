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
<?php
    @session_start();
    	require_once 'php/db.php';
	require_once 'php/function.php';

	if(!isset($_SESSION['is_login']) || !($_SESSION['is_login']))
	{
		header("Location: sign_in.php");
	
    }
$user_data=$_SESSION['login_user'];
?>

    <body>
        <div id="page" class="container">
            <div id="header">
                <?php 

                    if(isset($_FILES['profile']) === true){
                        if(empty($_FILES['profile']['name']) === true){
                            echo 'Please choose a file!';
                        }else{
                            $allowed = array('jpg','jpeg','gif','png');
                            
                            $file_name = $_FILES['profile']['name']; //pic01.png
                            $file_extn = strtolower(end(explode('.', $file_name)));
                            $file_temp = $_FILES['profile']['tmp_name'];
                            
                            if(in_array($file_extn,$allowed)===true){
                                //upload file
                                change_profile_image($user_data['account'],$file_temp,$file_extn);
                            }else{
                                echo 'Incorrect file type. Allowed: ';
                                echo implode(', ',$allowed);
                            }
                        }
                    }
                    ?>
                <div id="logo">
                    <?php 
                if(empty($user_data['profile'])===false){
                        echo '<img src="'. $_SESSION['login_user']['profile'].'" alt="" />';
                }else{
                    echo '<img src="image/pic02.jpg" alt="" />';
                }
                ?>
                    <div style="background: #f9f9f9; border: 1px dashed #ccc; padding: 5px;">

                        <form action="" method="post" enctype="multipart/form-data" id="pro_sub">
                            <input type="file" name="profile" id="profile"> <br><input type="submit">
                        </form>
                    </div>
                    <h1>
                        <a href="profile.php">
                            <?php 
                            echo $user_data['nickname'];
                        ?>
                        </a>
                    </h1>
                </div>
                <div id="menu">
                    <ul>
                        <li class="current_page_item"><a href="index2.php" accesskey="1" title="">Homepage</a></li>

                    </ul>
                </div>
            </div>
            <div id="main">
                <div id="banner">

                </div>
                <div id="welcome">
                    <div class="title">
                        <h2>感謝您的發文!</h2>
                        <span class="byline">發文請遵守版規</span>
                        </br>
                        </br>
                        <p>請注意基本禮貌，請勿人身攻擊、諷刺調侃、髒話謾罵、挑釁引戰。</p>
                        <p>請勿使用簡體字、注音文、火星文。</p>
                        <p>發文需滿10個字，請充實文章內容。</p>
                        <p>轉錄文章、圖片、影音請附上來源網址，請勿發表八卦新聞或未經證實的消息。</p>
                        <p>請勿討論盜版或公開徵求版權物。</p>
                        <p>請勿發表交易文、拍賣文、政治文，以及無關的廣告文、轉錄文。</p>
                        <p>請勿發表重複資訊、洗板/洗留言。</p>
                    </div>
                    <form style="background-color:gray;color:white; font-weight:bold;" action="add_user.php" method="POST" id="post_a">

                        <div>
                            <ul>
                                <div>
                                    <li style="background-color:black;">
                                        <p>標題</p>
                                    </li>
                                    <input style="width:430px;" placeholder="title" name="title" type="text" id="title">
                                    <select name="type" id="type">
									<option value='brunch' >早午餐</option>
									<option value='drinks' >飲料</option>
							</select>
                                    </br>
                                </div>
                                </br>
                                <div>
                                    <li style="background-color:black;">
                                        <p>內容</p>
                                    </li>
                                    <textarea style="width:500px;height:200px;" name="content" id="content"></textarea>
                                </div>
                                </br>
                                <li style="background-color:black;">
                                    <p>店家地址</p>
                                </li>
                                <div id="floating-panel">
                                    <p> 輸入欲查詢的地址<input id="address" type="textbox" value="">
                                    <input id="mapsubmit" type="button" value="搜尋位址"></p>
                                </div>
                                <div id="map" style="width:800px;height:400px;"></div>
                                </br>

                                </br>

                                <input id="submit" type="submit" value="Send Message" />
                                <input type="reset" value="Reset" />
                            </ul>
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
                $("#post_a").submit(function() {
                    //使用 ajax 送出
                    $.ajax({
                        type: "POST",
                        url: "add_article.php",
                        data: {
                            title: $("#title").val(), //使用者帳號
                            type: $("#type").val(), //
                            content: $("#content").val(), //
                            address: $("#address").val()
                        },
                        dataType: 'html' //設定該網頁回應的會是 html 格式
                    }).done(function(data) {
                        //成功的時候
                        if (data == "yes") {
                            alert("發文成功，將自動反往首頁");
                            //註冊新增成功，轉跳到登入頁面。
                            window.location.href = "index2.php";
                            window.event.returnValue = false;
                        } else {
                            alert("發文失敗，請與系統人員聯繫");
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
        <script>
            function initMap() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 10,
                    center: {
                        lat: 25.0081215,
                        lng: 121.53597590000004
                    }
                });
                var geocoder = new google.maps.Geocoder();

                document.getElementById('mapsubmit').addEventListener('click', function() {
                    geocodeAddress(geocoder, map);
                });
            }

            function geocodeAddress(geocoder, resultsMap) {
                var address = document.getElementById('address').value;
                geocoder.geocode({
                    'address': address
                }, function(results, status) {
                    if (status === 'OK') {
                        resultsMap.setCenter(results[0].geometry.location);
                        resultsMap.setZoom(15);
                        var marker = new google.maps.Marker({
                            map: resultsMap,
                            position: results[0].geometry.location
                        });
                    } else {
                        alert('此地址在地圖中找不到(若按送出則不會顯示正確地址)!!');
                    }
                });
            }

        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSMrZMA1kuKbjGlzoPXBMYyi57cjByj3U&callback=initMap">


        </script>
    </body>

</html>
