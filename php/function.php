<?php 
	@session_start();

/**
 * 檢查資料庫有無該email
 */
function check_has_account($account)
{
	//宣告要回傳的結果
  $result = null;

  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `user` WHERE `account` = '{$account}';";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query)
  {
    //使用 mysqli_num_rows 方法，判別執行的語法，其取得的資料量，是否有一筆資料
    if (mysqli_num_rows($query) >= 1)
    {
      //取得的量大於0代表有資料
      //回傳的 $result 就給 true 代表有該帳號，不可以被新增
      $result = true;
    }

    //釋放資料庫查詢到的記憶體
    mysqli_free_result($query);
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 添加使用者
 */
function add_user_data($account,$password,$nickname,$bd)
{
	//宣告要回傳的結果
  $result = null;
	//先把密碼用md5加密
  $pw = md5($pw);
  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "INSERT INTO `user` (`account`,`password`, `nickname`, `birthday`) VALUE ('{$account}','{$password}', '{$nickname}', '{$bd}');";
  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);
	
  //如果請求成功
  if ($query)
  {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if(mysqli_affected_rows($_SESSION['link']) == 1)
    {
      $result = true;
    }
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 檢查資料庫有無該使用者名稱
 */
function verify_user($account, $password)
{
  //宣告要回傳的結果
  $result = null;
  //先把密碼用md5加密
  $pw = md5($pw);
  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "SELECT * FROM `user` WHERE `account` = '{$account}' AND `password` = '{$password}'";

  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query)
  {
    //使用 mysqli_num_rows 回傳 $query 請求的結果數量有幾筆，為一筆代表找到會員且密碼正確。
    if(mysqli_num_rows($query)==1)
    {
      //取得使用者資料
      $user = mysqli_fetch_assoc($query);
      
      //在session李設定 is_login 並給 true 值，代表已經登入
      $_SESSION['is_login'] = TRUE;
      //紀錄登入者的id，之後若要隨時取得使用者資料時，可以透過 $_SESSION['login_user_id'] 取用
      $_SESSION['login_user'] = $user;
      //回傳的 $result 就給 true 代表驗證成功
      $result = true;
    }
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 添加文章
 */
function add_user_article($title,$type,$content,$address)
{
	//宣告要回傳的結果
  $result = null;
  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "INSERT INTO `article` (`title`,`type`, `content`, `address`,`account`) VALUE ('{$title}','{$type}', '{$content}', '{$address}', '{$_SESSION['login_user'][account]}');";
  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);
	
  //如果請求成功
  if ($query)
  {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if(mysqli_affected_rows($_SESSION['link']) == 1)
    {
      $result = true;
    }
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}
/**
 * 修改興趣
 */
function update_user_interest($interest)
{
	//宣告要回傳的結果
  $result = null;
	//先把密碼用md5加密
  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "UPDATE `user` SET `interest` = '{$interest}' WHERE `user`.`account` = '{$_SESSION['login_user'][account]}';";
  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);
	
  //如果請求成功
  if ($query)
  {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if(mysqli_affected_rows($_SESSION['link']) == 1 and  verify_user($_SESSION['login_user'][account],$_SESSION['login_user'][password]))
    {
      $result = true;
    }
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}
/**
 * 修改喜愛
 */
function update_user_likeshop($likeshop)
{
	//宣告要回傳的結果
  $result = null;
	//先把密碼用md5加密
  //將查詢語法當成字串，記錄在$sql變數中
  $sql = "UPDATE `user` SET `like_shop` = '{$likeshop}' WHERE `user`.`account` = '{$_SESSION['login_user'][account]}';";
  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);
	
  //如果請求成功
  if ($query)
  {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if(mysqli_affected_rows($_SESSION['link']) == 1 and  verify_user($_SESSION['login_user'][account],$_SESSION['login_user'][password]))
    {
      $result = true;
    }
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}
/**
 * 匯入圖片
 */
function change_profile_image($user_account,$file_temp,$file_extn)
{
    $file_path = 'image/profile/' . substr(md5(time()),0,10 ). '.' . $file_extn;
    move_uploaded_file($file_temp,$file_path);
    $sql ="UPDATE `user` SET `profile` = '{$file_path }' WHERE `account` = '{$user_account}';";
	//verify_user($_SESSION['login_user'][account],$_SESSION['login_user'][password]);
    $query=mysqli_query($_SESSION['link'], $sql);
     //如果請求成功
  if ($query)
  {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if(mysqli_affected_rows($_SESSION['link']) == 1 and  verify_user($_SESSION['login_user'][account],$_SESSION['login_user'][password]))
    {
      $result = true;
    }
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }
}




/**
 * 文章
 */
function article($ID)
{ $result = null;
 
  $sql = "SELECT * FROM `article`natural join `user` WHERE `article_ID` = {$ID}";

  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query)
  {
    if(mysqli_num_rows($query)==1)
    {
      $article = mysqli_fetch_assoc($query);
      //這個是當前文章內容，很重要的變數，會常用
      $_SESSION['article'] = $article;
      $result =true;
    }
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }
  $sql = "UPDATE `article` SET `page_views` = `page_views`+1 WHERE `article_ID` = {$ID}";
  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中
  $query = mysqli_query($_SESSION['link'], $sql);
  //回傳結果
  return $result;
}

function delete($ID)
{ $result = null;
 
  $sql = "DELETE FROM`article` WHERE `article_ID` = {$ID}";

  $query = mysqli_query($_SESSION['link'], $sql);

  //如果請求成功
  if ($query)
  {
      $result =true;
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }
  //回傳結果
  return $result;
}

/**
 * 文章表
 */
function articlelist($sql)
{ //$link=mysql_connect("localhost", "root", "00000000");
    //mysql_select_db("database_project") or die("No database.");
   // mysql_query("SET NAMES utf8");
    //$result = mysql_query($sql) or die("Error Message:".mysql_error( ));
    $result = mysqli_query($_SESSION['link'], $sql);
    $count = mysqli_num_rows($result);//總共幾筆
    $per = 10;//每頁筆數
    $pages = ceil($count/10);//每頁顯示幾筆
    if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
        $page=1; //則在此設定起始頁數
    } else {
        $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
    }
    $start=$per*($page-1);//每一頁開始的資料序號
    $result = mysqli_query($_SESSION['link'],$sql.' LIMIT '.$start.', '.$per) or die("Error");
                
                $main .='<table border="0" cellspacing="0" cellpadding="0" width="1000">
                                <tr>
                                    <td class="bodyText">';
                        $main .='   <table width="800" border="0">
                                    <tr><td width="200">文章標題</td>    
                                        <td>瀏覽人數</td>    <td>發文時間</td>     
                                        <td>作者</td>
                                        <td>讚</td>
                                        <td>爛</td>
                                        <td>分數</td>';
                                while ( list($account,$article_ID,$content,$post_time,$title,$page_views,$address,$type,
                                  $password,$nickname) = mysqli_fetch_row($result) ){
                                    $main .="<tr>
                                                 <td><a href='article.php' onclick='gotoarticle($article_ID)'>　$title 　</a></td>
                                                 <td>$page_views</td>
                                                 <td>$post_time </td>
                                                 <td><a href='profile2.php' onclick='gotoarticle($article_ID)'>$nickname   </a></td>
                                                 <td>".good_count($article_ID)."</td>
                                                 <td>".bad_count($article_ID)."</td>
                                                 <td>".grade_count($article_ID)."</td></tr>";
                            }
                        $main .='</table></td></tr></table>';
                        $main .="<td>共 $count 筆-在 $page 頁-共 $pages 頁</td>
                                  <td><a href=?page=1>最前頁</a> 第 </td>";
                                  for( $i=1 ; $i<=$pages ; $i++ ) 
                                  {
                                    if ( $page-3 < $i && $i < $page+3 ) 
                                    {
                                      $main .="<td><a href=?page=$i>$i</a></td>&nbsp&nbsp";
                                    }
                                  }
                        $main .="頁 <td><a href=?page=".$pages.">最末頁</a></td>";
 //mysql_close ($link);
 return $main;
}

/**
 * 各文章的留言表
 */
function commentlist($ID)
{
  $result = null;
 
  $sql = "SELECT * FROM `comment` natural join `user`  WHERE `article_ID` = {$ID} ORDER BY `comment_ID`";

$result = mysqli_query($_SESSION['link'], $sql);             
                $main .='<table border="0" cellspacing="0" cellpadding="0" width="1000"><tr><td class="bodyText">';
                        $main .='   <table width="800" border="0"><tr style="background-color:gray;color:white;"><td>發言人</td><td width="400">留言</td>    <td>發言時間</td>     </tr>';
                                while ( list($account,$article_ID,$comment_ID,$content,$post_time,$password,$nickname)
                                       = mysqli_fetch_row($result) ){
                                    $main .="<tr><td>$nickname  </td><td>$content  </td><td>$post_time </td></tr>";
                            }
                        $main .='</table></td></tr></table>';  
 return $main;
}


/**
 * 增加留言
 */
function insert_comment($comment)
{
	//宣告要回傳的結果
  $result = null;
  $sql = "INSERT INTO `comment` (`article_ID`,`content`, `account`) VALUE ('{$_SESSION['article'][article_ID]}','{$comment}', '{$_SESSION['login_user'][account]}');";
  $query = mysqli_query($_SESSION['link'], $sql);
	
  //如果請求成功
  if ($query)
  {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if(mysqli_affected_rows($_SESSION['link']) == 1)
    {
      $result = true;
    }
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

function find_search($search,$option)
{
  //宣告要回傳的結果
  $result = null;
  $sql = "SELECT * FROM `article` WHERE `title` LIKE '%".'{$search}'."%' ORDER BY `article_ID`";
  $query = mysqli_query($_SESSION['link'], $sql);
  
  //如果請求成功
  
  if ($query)
  {
	  $_SESSION['search']=$search;
    $_SESSION['option']=$option;
      $result = true;
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 案讚
 */
function good($value)
{
	//宣告要回傳的結果
  $result = null;
  
    
$sql = "select * from `grade` where `article_ID`={$_SESSION['article'][article_ID]} and  `account`='{$_SESSION['login_user'][account]}'";
  $query = mysqli_query($_SESSION['link'], $sql);
  //如果請求成功
  if ($query)
  {
   	 
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if(mysqli_affected_rows($_SESSION['link']) == 1)//此人曾評過此文 則修改原資料，否則會可以一直按讚
    {
      $sql = "UPDATE `grade` SET `good` = '{$value}' WHERE `account` = '{$_SESSION['login_user'][account]}' and `article_ID`={$_SESSION['article'][article_ID]};";
       $query = mysqli_query($_SESSION['link'], $sql);
        if ($query)
        {
            $result = true;
        }
    }
    else //沒有此資料
    {
        
        $sql = "INSERT INTO `grade` (`article_ID`, `account`,`good`) VALUE ('{$_SESSION['article'][article_ID]}', '{$_SESSION['login_user'][account]}','1');"; 
        $query = mysqli_query($_SESSION['link'], $sql);
        if ($query)
        {
            $result = true;
        }
    }
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 按爛
 */
function bad($value)
{
	//宣告要回傳的結果
  $result = null;
  
    
$sql = "select * from `grade` where `article_ID`={$_SESSION['article'][article_ID]} and  `account`='{$_SESSION['login_user'][account]}'";
  $query = mysqli_query($_SESSION['link'], $sql);
	
  //如果請求成功
  if ($query)
  {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if(mysqli_affected_rows($_SESSION['link']) == 1)//此人曾評過此文 則修改原資料，否則會可以一直按讚
    {
      $sql = "UPDATE `grade` SET `bad` = '{$value}' WHERE `account` = '{$_SESSION['login_user'][account]}' and `article_ID`={$_SESSION['article'][article_ID]};";
       $query = mysqli_query($_SESSION['link'], $sql);
        if ($query)
        {
            $result = true;
        }
    }
    else if (mysqli_affected_rows($_SESSION['link']) ==0) //沒有此資料
    {
        $sql = "INSERT INTO `grade` (`article_ID`, `account`,`bad`) VALUE ('{$_SESSION['article'][article_ID]}', '{$_SESSION['login_user'][account]}','1');";
        $query = mysqli_query($_SESSION['link'], $sql);
        if ($query)
        {
            $result = true;
        }
    }
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}
/**
 * 讚數 這是直接回傳讚數的 不是yes no
 */
function good_count($article_ID)
{
	//宣告要回傳的結果
  $result = null;
  
    
$sql = "select count(*) from `grade` where `article_ID`={$article_ID} and `good` = '1';";
  $query = mysqli_query($_SESSION['link'], $sql);
	
  //如果請求成功
  if ($query)
  {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if(mysqli_affected_rows($_SESSION['link']) == 1)//此人曾評過此文 則修改原資料，否則會可以一直按讚
    {
         $good= mysqli_fetch_assoc($query);
        $result =$good['count(*)'];
    
    }
   
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}
/**
 * 爛數 這是直接回傳讚數的 不是yes no
 */
function bad_count($article_ID)
{
	//宣告要回傳的結果
  $result = null;
  
    
$sql = "select count(*) from `grade` where `article_ID`={$article_ID} and `bad` = '1';";
  $query = mysqli_query($_SESSION['link'], $sql);
	
  //如果請求成功
  if ($query)
  {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if(mysqli_affected_rows($_SESSION['link']) == 1)//此人曾評過此文 則修改原資料，否則會可以一直按讚
    {
         $bad= mysqli_fetch_assoc($query);
        $result =$bad['count(*)'];
    
    }
   
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}

/**
 * 按爛
 */
function grade($value)
{
	//宣告要回傳的結果
  $result = null;
$sql = "select * from `grade` where `article_ID`={$_SESSION['article'][article_ID]} and  `account`='{$_SESSION['login_user'][account]}'";
  $query = mysqli_query($_SESSION['link'], $sql);
  //如果請求成功
  if ($query)
  {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if(mysqli_affected_rows($_SESSION['link']) == 1)//此人曾評過此文 則修改原資料，否則會可以一直按讚
    {
      $sql = "UPDATE `grade` SET `grade` = '{$value}' WHERE `account` = '{$_SESSION['login_user'][account]}' and `article_ID`={$_SESSION['article'][article_ID]};";
       $query = mysqli_query($_SESSION['link'], $sql);
        if ($query)
        {
            $result = true;
        }
    }
    else if (mysqli_affected_rows($_SESSION['link']) ==0) //沒有此資料
    {
        $sql = "INSERT INTO `grade` (`article_ID`, `account`,`grade`) VALUE ('{$_SESSION['article'][article_ID]}', '{$_SESSION['login_user'][account]}','{$value}');";
        $query = mysqli_query($_SESSION['link'], $sql);
        if ($query)
        {
            $result = true;
        }
    }
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }
  //回傳結果
  return $result;
}
/**
 * 分數 這是直接回傳讚數的 不是yes no
 */
function grade_count($article_ID)
{
	//宣告要回傳的結果
  $result = null;  
  $sql = "select AVG(`grade`) from `grade` where `article_ID`={$article_ID} and `grade` != 'null';";
  $query = mysqli_query($_SESSION['link'], $sql);
	
  //如果請求成功
  if ($query)
  {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if(mysqli_affected_rows($_SESSION['link']) == 1)//此人曾評過此文 則修改原資料，否則會可以一直按讚
    {
         $good= mysqli_fetch_assoc($query);
        $result =$good['AVG(`grade`)'];
    
    }
   
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}
function delete_articlelist($sql)
{ 
    $result = mysqli_query($_SESSION['link'], $sql);
    $count = mysqli_num_rows($result);//總共幾筆
    $per = 10;//每頁筆數
    $pages = ceil($count/10);//每頁顯示幾筆
    if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
        $page=1; //則在此設定起始頁數
    } else {
        $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
    }
    $start=$per*($page-1);//每一頁開始的資料序號
    $result = mysqli_query($_SESSION['link'],$sql.' LIMIT '.$start.', '.$per) or die("Error");
                
                $main .='<table border="0" cellspacing="0" cellpadding="0" width="1000">
                                <tr>
                                    <td class="bodyText">';
                        $main .='   <table width="800" border="0">
                                    <tr><td width="200">文章標題</td>    
                                        <td>瀏覽人數</td>    <td>發文時間</td>     
                                        <td>作者</td>
                                        <td>讚</td>
                                        <td>爛</td>
                                        <td>分數</td>
                                        <td>刪除文章</a></td>';
                                while ( list($account,$article_ID,$content,$post_time,$title,$page_views,$address,$type,
                                  $password,$nickname) = mysqli_fetch_row($result) ){
                                    $main .="<tr>
                                                 <td><a href='article.php' onclick='gotoarticle($article_ID)'>　$title 　</a></td>
                                                 <td>$page_views</td>
                                                 <td>$post_time </td>
                                                 <td><a href='profile2.php'  onclick='gotoarticle($article_ID)'>$nickname</a></td>
                                                 <td>".good_count($article_ID)."</td>
                                                 <td>".bad_count($article_ID)."</td>
                                                 <td>".grade_count($article_ID)."</td>
                                                 <td><input type='button' name='delete' value='刪 除' onclick='delete_article($article_ID)'></td></tr>";
                            }
                        $main .='</table></td></tr></table>';
                        $main .="<td>共 $count 筆-在 $page 頁-共 $pages 頁</td>
                                  <td><a href=?page=1>最前頁</a> 第 </td>";
                                  for( $i=1 ; $i<=$pages ; $i++ ) 
                                  {
                                    if ( $page-3 < $i && $i < $page+3 ) 
                                    {
                                      $main .="<td><a href=?page=$i>$i</a></td>&nbsp&nbsp";
                                    }
                                  }
                        $main .="頁 <td><a href=?page=".$pages.">最末頁</a></td>";
 //mysql_close ($link);
 return $main;
}
/**
 * 修改文章
 */
function update_article($title,$type,$content,$address)
{
  $result = null;
  $sql = "UPDATE `article` SET `title` = '{$title}' , `type`='{$type}' , `content`='{$content}' , `address`='{$address}' WHERE `article_ID` = '{$_SESSION['article'][article_ID]}';";
  //用 mysqli_query 方法取執行請求（也就是sql語法），請求後的結果存在 $query 變數中 
  $query = mysqli_query($_SESSION['link'], $sql);
	
  //如果請求成功
  if ($query)
  {
    //使用 mysqli_affected_rows 判別異動的資料有幾筆，基本上只有新增一筆，所以判別是否 == 1
    if(mysqli_affected_rows($_SESSION['link']) == 1 and article($_SESSION['article'][article_ID]))
    {
      $result = true;
    }
  }
  else
  {
    echo "{$sql} 語法執行失敗，錯誤訊息：" . mysqli_error($_SESSION['link']);
  }

  //回傳結果
  return $result;
}
?>
