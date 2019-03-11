<?php
	//假設的有效會員帳號
	require_once 'php/db.php';
	require_once 'php/function.php';

//echo $account;
$result=good($_POST['value']);
	if($result)
	{
		echo good_count($_POST['article_ID']);
	}
	else 
	{
		echo 'no';
	}
?>