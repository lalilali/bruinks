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
                    <li class="current_page_item"><a href="#" accesskey="1" title="">Homepage</a></li>
                    <li><a href="index.php" accesskey="3" title="" onclick="log_out()">登出</a></li>
                    <li><a href="post.php" accesskey="4" title="">發文</a></li>
                    <br><br>
                    <li><a href="#" accesskey="4" title="">Brunch早午餐</a></li>
                    <li><a href="drinks2.php" accesskey="5" title="">Drinks飲料 </a></li>
                    <li><a href="index_c.php" accesskey="6" target="_blank">Chat Room</a></li>
                    <li><a href="https://www.facebook.com/Bruinks-1381790968576517/" accesskey="7" title="">Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div id="main">
            <div id="banner">
                <img src="image/brunch.jpg" alt="" class="image-full" />
            </div>
            <div id="welcome">
                <div class="title">
                    <h2>早午餐店文章列表</h2>
                    <span class="byline">有喜歡的早午餐店歡迎分享給大家知道</span>
                </div>
                <form action="search.php" method="POST" id="searching">
                    <div >
                        <span class="byline"><p align="right">文章搜尋:</span>
                        <input placeholder="search" maxlength="20" name="search" type="text" id="search">
                        <select name="option" type="text" id="option">
                            <option value='bruinks' >早午餐&飲料</option>
                            <option value='brunch' >早午餐</option>
                            <option value='drinks' >飲料</option>
                        </select>
                        <input id="submit" type="submit" value="搜尋" />
                    </div>
                </form>
                <button onclick="change()" style="float: right;">按發文時間</button> 
                <button onclick="change_title()" style="float: right;">按標題</button> 
                <button onclick="change_pageview()" style="float: right;">按瀏覽人數</button>
                <div id="list">
                        <!--    PHP Part Start    -->
                        <?php
                        $sql="SELECT * FROM `article` natural join `user` WHERE type='brunch' ORDER BY `article_ID`DESC";
                        $main=articlelist($sql);  
                        echo $main;
                        ?>
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
    function gotoarticle(article_ID)
    {
          $.post("article_click.php", {article_ID: article_ID},function(re){
              if(re=="No")
                  {
                      alert("無此文章");
                      window.location.href = "index.php";
                  }
            });   
    }
    
    function log_out(article_ID)//否則登出後 還會保留會員資料
    {
       $.post("log_out.php",function(re){
           alert(re);
            });  
    }
    var c=true
        function change() {
            var sql;
            if(c==true)
            {
                sql="SELECT * FROM `article` natural join `user` WHERE type='brunch' ORDER BY `article_ID`";
                c=false;
            }
            else
            {
                sql = "SELECT * FROM `article` natural join `user` WHERE type='brunch' ORDER BY `article_ID`DESC";
                c=true;
            }
            
            $.post("article_sequential.php", {
                sql: sql
            }, function(re) {
                
                    document.getElementById("list").innerHTML=re;
                
            });
        }
        var b=true
        function change_title() {
            var sql;
            if(b==true)
            {
                sql="SELECT * FROM `article` natural join `user` WHERE type='brunch' ORDER BY `title`";
                b=false;
            }
            else
            {
                sql = "SELECT * FROM `article` natural join `user` WHERE type='brunch' ORDER BY `title`DESC";
                b=true;
            }
            
            $.post("article_sequential.php", {
                sql: sql
            }, function(re) {
                
                    document.getElementById("list").innerHTML=re;
                
            });
        }
        var a=true
        function change_pageview() {
            var sql;
            if(a==true)
            {
                sql="SELECT * FROM `article` natural join `user` WHERE type='brunch' ORDER BY `page_views`DESC";
                a=false;
            }
            else
            {
                sql = "SELECT * FROM `article` natural join `user` WHERE type='brunch' ORDER BY `page_views`";
                a=true;
            }
            
            $.post("article_sequential.php", {
                sql: sql
            }, function(re) {
                
                    document.getElementById("list").innerHTML=re;
                
            });
        }
    $(document).ready(function() {
            $("#searching").submit(function() {
               //使用 ajax 送出
            $.ajax({
                type: "POST",
                url: "do_search.php",
                data: {
                    search: $("#search").val(), 
                    option: $("#option").val(),

                },
                dataType: 'html' //設定該網頁回應的會是 html 格式
            }).done(function(data) {
                //成功的時候
                if(data == "yes")
                {
                    alert("搜尋成功!!");
                    window.location.href = "search.php";
                }
                else {
                    alert("沒有找到相關的主題!");
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
