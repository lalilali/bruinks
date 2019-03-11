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
$user_data=$_SESSION['login_user'];
$check=true;
if($_SESSION['login_user']=="log_out")
    $check=false;
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
            <div id="logo">
                <?php 
                if(empty($user_data['profile'])===false){
                        echo '<img src="'. $_SESSION['login_user']['profile'].'" alt="" />';
                }else{
                    echo '<img src="image/pic02.jpg" alt="" />';
                }
                ?>
            

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
                     <?php
                    if($check==true)
                    {
                         echo '<li class="current_page_item"><a href="index2.php" accesskey="1" title="">Homepage</a></li>';
                         echo '<li><a href="index.php" accesskey="3" title="" onclick="log_out()">登出</a></li>';
                         echo '<li><a href="post.php" accesskey="4" title="">發文</a></li>';
                         echo '</br></br><li><a href="index2.php" accesskey="4" title="">Brunch早午餐</a></li>';
                         echo '<li><a href="drinks2.php" accesskey="5" title="">Drinks飲料</a></li>';
                         echo '<li><a href="index_c.php" accesskey="6" title="">Chat Room</a></li>';
                    }   
                    else
                    {
                         echo '<li class="current_page_item"><a href="index.php" accesskey="1" title="">Homepage</a></li>';
                        echo '</br></br><li><a href="index.php" accesskey="4" title="">Brunch早午餐</a></li>';
                        echo '<li><a href="drinks.php" accesskey="5" title="">Drinks飲料</a></li>';
                        
                    }
                       
                    ?>
                    <li><a href="#" accesskey="7" title="">Contact Us</a></li>
                    
                </ul>
            </div>
        </div>
        <div id="main">
            <div id="banner">
                <img src="image/brunch.jpg" alt="" class="image-full" />
            </div>
            <div id="welcome">
                <div class="title">
                    <h2>搜尋結果</h2>
                    <span class="byline">以下是你所搜尋的關鍵字</span>
                </div>
                <div id="list">
                    <!--    PHP Part Start    -->
                    <?php

                        $search= $_SESSION['search'];
                        $option= $_SESSION['option'];
                        if($option == 'bruinks')
                        {
                            $sql = "SELECT * FROM `article` NATURAL JOIN `user` WHERE `title` LIKE '%{$search}%' ORDER BY `article_ID`DESC";
                        }
                        else
                        {
                            $sql = "SELECT * FROM `article` NATURAL JOIN `user` WHERE `title` LIKE '%{$search}%' AND type='{$option}' ORDER BY `article_ID`";
                        }
                        $main=articlelist($sql);  
                        echo $main;
                        ?>
                </div>
            </div>
            <div id="copyright">
                <span>&copy; Untitled. All rights reserved. | Photos by <a href="http://fotogrph.com/">Fotogrph</a></span>
                <span>Design by <a href="http://templated.com" rel="nofollow">TEMPLATED</a>.</span>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
         var check="<?php echo $_SESSION['login_user'];?>";//確定是否登入

    if(check=="log_out")
    {
        document.getElementById("logo").innerHTML="";
    }
        function gotoarticle(article_ID) {
            $.post("article_click.php", {
                article_ID: article_ID
            }, function(re) {
                if (re == "No") {
                    alert(data);
                    window.location.href = "index.php";
                }
            });
        }

        function log_out(article_ID) //否則登出後 還會保留會員資料
        {
            $.post("log_out.php", function(re) {});
        }
    </script>
</body>

</html>