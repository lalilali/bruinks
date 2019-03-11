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
                    <li class="current_page_item"><a href="#" accesskey="1" title="">Homepage</a></li>
                    <li><a href="sign_up.php" accesskey="2" title="">Sign Up</a></li>
                    <li><a href="sign_in.php" accesskey="3" title="">Sign in</a></li>
					</br></br>
                    <li><a href="brunch.php" accesskey="4" title="">Brunch早午餐</a></li>
                    <li><a href="drinks.php" accesskey="5" title="">Drinks飲料</a></li>
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

                        <!--    PHP Part Start    -->
                        <?php
                        $link=mysql_connect("localhost", "root", "00000000");
                        mysql_select_db("database_project") or die("No database.");
                        $sql = "SELECT * FROM `article` WHERE type='brunch' ORDER BY `article_ID`";
                        mysql_query("SET NAMES utf8");
                        $result = mysql_query($sql) or die("Error Message:".mysql_error( ));

                        $main .='<table border="0" cellspacing="0" cellpadding="0" width="1000">
                                <tr>
                                    <td class="bodyText">';
                        $main .='   <table width="800" border="0">
                                    <tr><td width="200">文章標題</td>    
                                        <td>瀏覽人數</td>    <td>發文時間</td>     
                                        <td>作者</td></tr>';
                                while ( list($article_ID,$content,$post_time,$title,$page_views,$address,$type,$account
                                ) = mysql_fetch_row($result) ){
                                    $main .="<tr>
                                                 <td><a href=url>$title     </a></td>
                                                 <td>$page_views</td>
                                                 <td>$post_time </td>
                                                 <td><a href=url>$account   </a></td></tr>";
                            }
                        $main .='</table></td></tr></table>';         
                        echo $main;
                        mysql_close ($link);
                        ?>
 

        </div>
    </div>
</body>

</html>