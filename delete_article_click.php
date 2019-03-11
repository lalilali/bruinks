<?php
@session_start();
	//假設的有效會員帳號
	require_once 'php/db.php';
	require_once 'php/function.php';
$result=delete($_POST['article_ID']);
//commentlist($_POST['article_ID']);
	if($result)
	{
			$sql="SELECT * FROM `article` natural join `user` WHERE account='{$_SESSION['login_user'][account]}' ORDER BY `article_ID`";
		echo delete_articlelist($sql);
	}
	else 
	{
		echo 'No';
	}
	
?>