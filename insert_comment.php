<?php
	//假設的有效會員帳號
	require_once 'php/db.php';
	require_once 'php/function.php';

$result=insert_comment($_POST['comment']);

if($result)
	{
		echo commentlist($_SESSION['article']['article_ID']);//這樣才能及時更新
	}
	else 
	{
		echo 'no';
	}
?>