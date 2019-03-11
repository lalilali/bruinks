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
//載入資料庫與處理的方法
require_once 'php/db.php';
require_once 'php/function.php';

@session_start();
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
                    <h1><?php echo $_SESSION['login_user'][nickname];?> 的個人小屋</h1>
                </div>
            </div>
            <div id="banner">
                <div id="logo">
                <?php 
                if(empty($user_data['profile'])===false){
                        echo '<img src="'. $_SESSION['login_user']['profile'].'" alt="" />';
                }else{
                    echo '<img src="image/pic02.jpg" alt="" />';
                }
                ?>
                </div>
				<ul style="font-weight:bold;">
					<li style="background-color:black;color:white;"><p>創帳號時間</p></li>
					<li ><p><?php echo $_SESSION['login_user'][create_time];?></p></li>
					<li style="background-color:black;color:white;"><p>生日</p></li>
					<li ><p><?php echo $_SESSION['login_user'][birthday];?></p></li>
					<li style="background-color:black;color:white;"><p>興趣   <a href="update_interest.php" rel="nofollow">修改</a></p></li>
					<li ><p><?php echo $_SESSION['login_user'][interest];?></p></li>
					<li style="background-color:black;color:white;"><p>喜愛店家   <a href="update_likeshop.php" rel="nofollow">修改</a></p></li>
					<li ><p><?php echo $_SESSION['login_user'][like_shop];?></p></li>
                    <li style="background-color:black;color:white;"><p>所po文章    </p></li></p></li>
                    <li>
                        <div id="list" >
                        <!--    PHP Part Start  這邊可能需要再特別寫一個   -->
                        <?php
                        $sql="SELECT * FROM `article` natural join `user` WHERE account='{$_SESSION['login_user'][account]}' ORDER BY `article_ID`DESC";
                        $main=delete_articlelist($sql);  
                        echo $main;
                        ?>
                        </div> 
                    </li>
					
				</ul>
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
    function delete_article(article_ID)
    {
        del = confirm('確定要刪除嗎？') 
        if(del == true) 
        { 
            $.post("delete_article_click.php", {article_ID: article_ID},function(re){
              document.getElementById("list").innerHTML=re;
            });
        }        

    }

</script>
</body>

</html>