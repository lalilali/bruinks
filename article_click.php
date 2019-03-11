<?php
@session_start();
	//假設的有效會員帳號
	require_once 'php/db.php';
	require_once 'php/function.php';
$result=article($_POST['article_ID']);
//commentlist($_POST['article_ID']);
	if($result)
	{
		echo "yes";
	}
	else 
	{
		echo 'No';
	}
	
?>
