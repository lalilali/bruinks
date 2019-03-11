<?php
	//假設的有效會員帳號
	require_once 'php/db.php';
	require_once 'php/function.php';
	$check = check_has_account($_POST['n']);
	//如果帳號存在
	if($check)
	{
		echo "yes";
	}
	else 
	{
		echo 'no';
	}
//	$db_user = "aa@aa.com";
//	$db_password = '11111';
//	
//	if($_POST['email'] == $db_user && $_POST['password'] == $db_password)
//	{
//		//如果密碼一樣，以及帳號一樣，那就代表正確，所以顯示登入成功
//		//將 session 加入一個已經登入的紀錄
//		$_SESSION['is_login'] = true;
//		//如果密碼一樣，以及帳號一樣，那就代表正確，所以顯示登入成功
//		//使用php header 來轉址 前往後台
//		header('Location: index.php');
//	}
//	else
//	{
//		//要不然就是登入失敗
//		//使用php header 來轉址回 login.php 必加入在網址加入 msg 的 GET 用變數 返回登入頁
//		$_SESSION['is_login'] = false;
//		header('Location: sign in.php?msg=登入失敗，請確認帳號密碼');
//	}
?>
