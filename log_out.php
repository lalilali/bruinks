<?php
@session_start();
	//假設的有效會員帳號
	require_once 'php/db.php';
	require_once 'php/function.php';
$_SESSION['login_user']="log_out";
$_SESSION['is_login']=null;

echo $_SESSION['login_user'];
	
?>
