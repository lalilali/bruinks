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
<?php 
@session_start();
if(!isset($_SESSION['is_login']) || !($_SESSION['is_login']))
	{
		header("Location: sign_in.php");
	
    }
$article=$_SESSION['article'];
$user_data=$_SESSION['login_user'];
?>

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
                <div class="title">
                    <h1>修改文章</h1>
                </div>
            </div>
            <div id="banner">

                <form style="background-color:gray;color:white; font-weight:bold;" method="POST" id="submit">

                    <div>
                        <ul>
                            <div>
                                <li style="background-color:black;">
                                    <p>標題</p>
                                </li>
                                <input style="width:430px;" placeholder="title" name="title" type="text" id="title" value="<?php echo $article['title'];?>">
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
                                <textarea style="width:500px;height:200px;" name="content" id="content"><?php echo $article['content'];?></textarea>
                            </div>
                            </br>
                          
                                <li style="background-color:black;">
                                    <p>店家地址</p>
                                </li>
                                <div id="floating-panel">
                                    <p> 輸入欲查詢的地址<input id="address" type="textbox" value="<?php echo $article['address'];?>">
                                    <input id="mapsubmit" type="button" value="搜尋位址"></p>
                                </div>
                                <div id="map" style="width:800px;height:400px;" ></div>
                         
                            </br>

                            </br>

                            <input id="submit" type="submit" value="確定修改" />
                            <input type="reset" value="Reset" />
                        </ul>
                    </div>
                </form>
            </div>

            <div id="copyright">
                <span>&copy; 這裡可以放置標語. | Photos by <a href="">Fotogrph</a></span>
                <span>Design by <a href="" rel="nofollow">TEMPLATED</a>.</span>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#submit").submit(function() {
                //使用 ajax 送出
                $.ajax({
                    type: "POST",
                    url: "update_article_post.php",
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
                        alert("更新成功");
                        //註冊新增成功，轉跳到登入頁面。
                        window.location.href = "article.php";
                        window.event.returnValue = false;
                    } else {
                        alert("更新失敗，請與系統人員聯繫");
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
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSMrZMA1kuKbjGlzoPXBMYyi57cjByj3U&callback=initMap"></script>
</body>

</html>
