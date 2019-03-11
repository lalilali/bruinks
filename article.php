<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
    <link href="default1.css" rel="stylesheet" type="text/css" media="all" />
    <link href="fonts.css" rel="stylesheet" type="text/css" media="all" />
    <style type="text/css">
        .starWrapper {
            solid #FFCC00;
        }
        
        .starWrapper img {
            cursor: pointer;
        }

    </style>
    <!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->

</head>
<?php
    @session_start();
	require_once 'php/db.php';
	require_once 'php/function.php';
    $article=$_SESSION['article'];
    $good=good_count($article['article_ID']);
    $bad=bad_count($article['article_ID']);
    $grade=grade_count($article['article_ID']);
	 $user_data=$_SESSION['login_user'];
    
    if($grade=="")
    {
      $grade=0;
    }
	$check=true;
if($_SESSION['login_user']=="log_out")
    $check=false;
    ////判斷是否按過
    $good_check=0;
    $bad_check=0;
  if($_SESSION['login_user']!="log_out")
  {
    $sql = "select * from `grade` where `article_ID`={$_SESSION['article'][article_ID]} and  `account`='{$_SESSION['login_user'][account]}' and `good`='1'";
    
    $query = mysqli_query($_SESSION['link'], $sql);
    if ($query)
    {
      //案過讚
      if(mysqli_affected_rows($_SESSION['link']) == 1)
      {
           $good_check=1;
      }
    }
    else
    {
      echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }
      
      $sql = "select * from `grade` where `article_ID`={$_SESSION['article'][article_ID]} and  `account`='{$_SESSION['login_user'][account]}' and `bad`='1'";
    $query = mysqli_query($_SESSION['link'], $sql);
    if ($query)
    {
      //案過讚
      if(mysqli_affected_rows($_SESSION['link']) == 1)
      {
           $bad_check=1;
      }
    }
    else
    {
      echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
    }
    $user_data=$_SESSION['login_user'];
  }
/////確認是否同人
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
                        <h2>
                            <?php echo $article['title'];?>
                        </h2>
                        <span class="byline"><?php echo $article['nickname'];?></span>
                    </div>


                    <div id="banner">
                        <div id="update">
                            <?php
                        if($check!=false && $article[account]===$user_data[account])
                            echo '<a href="update_article.php">修改文章</a>';
                 ?>

                        </div>

                        <ul style="font-weight:bold;">
                            <li style="background-color:black;color:white;">
                                <p>地址</p>
                            </li>
                            <li>
                                <p>
                                    <?php echo $article['address'];?>
                                </p>
                            </li>
                            <div id="map" style="width:100%;height:400px;" ></div>
                            
                            <li style="background-color:black;color:white;">
                                <p>文章</p>
                            </li>
                            <li>
                                <p>
                                    <?php echo $article['content'];?>
                                </p>
                            </li>
                            <div id="good" style="float:left;">

                                <p><img src='icon/like.png' style="width: 30px;height: 30px;" title="胖" onclick="good(<?php echo $article['article_ID'];?>)">
                                    </>
                                    <?php echo $good;?>　</p>
                                <!--全形空白 才會顯示在網頁 -->

                            </div>
                            <div id="bad" style="float:left;">
                                <p><img src='icon/dislike.png' style="width: 30px;height: 30px;" title="瘦" onclick="bad(<?php echo $article['article_ID'];?>)">
                                    </>
                                    <?php echo $bad;?>　</p>
                            </div>
                            <div id="grade">
                                <p class="starWrapper" onmouseover="rate(this,event,<?php echo $article['article_ID'];?>)" style="width:400px;">
                                    <img src="http://www.jb51.net/upload/20080508122008586.gif" title="很爛" />
                                    <img src="http://www.jb51.net/upload/20080508122008586.gif" title="一般" />
                                    <img src="http://www.jb51.net/upload/20080508122008586.gif" title="還好" />
                                    <img src="http://www.jb51.net/upload/20080508122008586.gif" title="較好" />
                                    <img src="http://www.jb51.net/upload/20080508122008586.gif" title="很好" />
                                    <?php echo $grade[0].$grade[1].$grade[2];?>
                                </p>
                            </div>
                            <li style="background-color:black;color:white;">
                                <p>留言版</p>
                            </li>
                            <li>
                                <div id="list">
                                    <!--    PHP Part Start  這邊可能需要再特別寫一個   -->
                                    <?php
                        
                        echo commentlist($article['article_ID']);
                       
                        ?>
                                </div>
                            </li>
                            </br>
                            <div id="sub_comment">
                                <form method="POST" id="submit" style="background-color:black;">
                                    </br>
                                    <textarea style="width:500px;height:50px;" name="comment" id="comment"></textarea>
                                    </br>
                                    <input id="submit" type="submit" value="留言" />
                                </form>
                            </div>
                        </ul>
                    </div>

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
                var check = "<?php echo $_SESSION['login_user'];?>"; //確定是否登入
                var good_check = <?php echo $good_check?>;
                var bad_check = <?php echo $bad_check?>;
                if (check == "log_out") {
                    document.getElementById("sub_comment").innerHTML = "";
                    document.getElementById("menu").innerHTML = "<ul><li class='current_page_item'><a href='index.php' accesskey='1' title=''>Homepage</a></li></ul>";
                    document.getElementById("good").innerHTML = "<p><img src='icon/like.png'  style='width: 30px;height: 30px;'></>　" + <?php echo $good;?> + "　</p>";
                    document.getElementById("bad").innerHTML = "<p><img src='icon/dislike.png'  style='width: 30px;height: 30px;'></>　" + <?php echo $bad;?> + "　</p>";
                    document.getElementById("grade").innerHTML = "<p>分數　" + <?php echo $grade;?> + "</p>";
                    document.getElementById("grade").style = "width:200px;";
                    document.getElementById("update").innerHTML = "";
                    document.getElementById("logo").innerHTML = "";
                } else {
                    if (good_check == 1) //按過
                    {
                        document.getElementById("good").innerHTML =
                            "<img src='icon/liked.png'  style='width: 30px;height: 30px;' title='胖' onclick='nogood(" + <?php echo $article['article_ID'];?> + ")'></>　 " + <?php echo $good;?> + "　</p>";
                    }　　
                    if (bad_check == 1) //按過
                    {
                        document.getElementById("bad").innerHTML =
                            "<img src='icon/disliked.png'  style='width: 30px;height: 30px;' title='瘦' onclick='nobad(" + <?php echo $article['article_ID'];?> + ")'></>　 " + <?php echo $bad;?> + "　</p>";

                    }

                }

                function gotoarticle(article_ID) {
                    $.post("article_click.php", {
                        article_ID: article_ID
                    }, function(re) {
                        if (re == "No") {
                            alert("無此文章");
                            window.location.href = "index.php";
                        }
                    });
                }

                $("#submit").submit(function() {
                    //使用 ajax 送出
                    $.ajax({
                        type: "POST",
                        url: "insert_comment.php",
                        data: {
                            comment: $("#comment").val() //
                        },
                        dataType: 'html' //設定該網頁回應的會是 html 格式
                    }).done(function(data) {
                        document.getElementById("list").innerHTML = data;

                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        //失敗的時候
                        alert("有錯誤產生，請看 console log");
                        console.log(jqXHR.responseText);
                    });
                    return false;
                });
            });

            function good(ID) {

                $.ajax({
                    type: "POST",
                    url: "good.php",
                    data: {
                        article_ID: ID, //
                        value: 1 //案讚
                    },
                    dataType: 'html' //設定該網頁回應的會是 html 格式
                }).done(function(data) {
                    //成功的時候
                    document.getElementById("good").innerHTML =
                        "<img src='icon/liked.png'  style='width: 30px;height: 30px;' title='胖' onclick='nogood(" + <?php echo $article['article_ID'];?> + ")'></>　 " + data + "　</p>";
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    //失敗的時候
                    alert("有錯誤產生，請看 console log");
                    console.log(jqXHR.responseText);
                });
            }

            function nogood(ID) {

                $.ajax({
                    type: "POST",
                    url: "good.php",
                    data: {
                        article_ID: ID, //
                        value: 0 //案讚
                    },
                    dataType: 'html' //設定該網頁回應的會是 html 格式
                }).done(function(data) {
                    //成功的時候
                    document.getElementById("good").innerHTML =
                        " <p><img src='icon/like.png'  style='width: 30px;height: 30px;' title='胖'  onclick='good(" + <?php echo $article['article_ID'];?> + ")'></>　" + data + "　</p>";

                }).fail(function(jqXHR, textStatus, errorThrown) {
                    //失敗的時候
                    alert("有錯誤產生，請看 console log");
                    console.log(jqXHR.responseText);
                });
            }

            function bad(ID) {

                $.ajax({
                    type: "POST",
                    url: "bad.php",
                    data: {
                        article_ID: ID,
                        value: 1 //
                    },
                    dataType: 'html' //設定該網頁回應的會是 html 格式
                }).done(function(data) {
                    document.getElementById("bad").innerHTML =
                        "<img src='icon/disliked.png'  style='width: 30px;height: 30px;' title='瘦' onclick='nobad(" + <?php echo $article['article_ID'];?> + ")'></>　 " + data + "　</p>";

                }).fail(function(jqXHR, textStatus, errorThrown) {
                    //失敗的時候
                    alert("有錯誤產生，請看 console log");
                    console.log(jqXHR.responseText);
                });
            }

            function nobad(ID) {

                $.ajax({
                    type: "POST",
                    url: "bad.php",
                    data: {
                        article_ID: ID,
                        value: 0 //
                    },
                    dataType: 'html' //設定該網頁回應的會是 html 格式
                }).done(function(data) {
                    //成功的時候
                    document.getElementById("bad").innerHTML =

                        " <p><img src='icon/dislike.png'  style='width: 30px;height: 30px;' title='瘦' onclick='bad(" + <?php echo $article['article_ID'];?> + ")'></>　" + data + "</p>";

                }).fail(function(jqXHR, textStatus, errorThrown) {
                    //失敗的時候
                    alert("有錯誤產生，請看 console log");
                    console.log(jqXHR.responseText);
                });
            }

            function rate(obj, oEvent, ID) {
                //================== 
                // 圖片地址設置 
                //================== 
                var imgSrc = 'http://www.jb51.net/upload/20080508122008586.gif'; //沒有填色的星星
                var imgSrc_2 = 'http://www.jb51.net/upload/20080508122010810.gif'; //打分後有顏色的星星
                //--------------------------------------------------------------------------- 
                if (obj.rateFlag) return;
                var e = oEvent || window.event;
                var target = e.target || e.srcElement;
                var imgArray = obj.getElementsByTagName("img");
                for (var i = 0; i < imgArray.length; i++) {
                    imgArray[i]._num = i;
                    imgArray[i].onclick = function() {
                        if (obj.rateFlag) return;
                        obj.rateFlag = true;
                        // alert(this._num+1);//分數
                        $.ajax({
                            type: "POST",
                            url: "grade.php",
                            data: {
                                article_ID: ID,
                                value: this._num + 1 //
                            },
                            dataType: 'html' //設定該網頁回應的會是 html 格式
                        }).done(function(data) {
                            //成功的時候
                            document.getElementById("grade").innerHTML = " <p class='starWrapper' onmouseover='rate(this,event," + <?php echo $article['article_ID'];?> + ")' style='width:400px;'>" +
                                " <img src='http://www.jb51.net/upload/20080508122008586.gif' title='很爛' />" +
                                " <img src='http://www.jb51.net/upload/20080508122008586.gif' title='一般' />" +
                                " <img src='http://www.jb51.net/upload/20080508122008586.gif' title='還好' />" +
                                " <img src='http://www.jb51.net/upload/20080508122008586.gif' title='較好' />" +
                                " <img src='http://www.jb51.net/upload/20080508122008586.gif' title='很好' />　 " +
                                data[0] + data[1] + data[2] +
                                "</p>";

                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            //失敗的時候
                            alert("有錯誤產生，請看 console log");
                            console.log(jqXHR.responseText);
                        });

                        //this._num+1這個數字寫入到數據庫中,作為評分的依據
                    };
                }
                if (target.tagName == "IMG") {
                    for (var j = 0; j < imgArray.length; j++) {
                        if (j <= target._num) {
                            imgArray[j].src = imgSrc_2;
                        } else {
                            imgArray[j].src = imgSrc;
                        }
                    }
                } else {
                    for (var k = 0; k < imgArray.length; k++) {
                        imgArray[k].src = imgSrc;
                    }
                }
            }

        </script>
        <script>
            function initMap() {
                
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 10,
                    center: {
                        lat: 25.0081215,
                        lng: 122.53597590000004
                    }
                });
                
                var geocoder = new google.maps.Geocoder();
                geocodeAddress(geocoder, map);
                
            }

            function geocodeAddress(geocoder, resultsMap) {
                var address="<?php echo $article['address'];?>"
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
                        alert('無此地址!!');
                    }
                });
            }

        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSMrZMA1kuKbjGlzoPXBMYyi57cjByj3U&callback=initMap"></script>
    </body>

</html>
