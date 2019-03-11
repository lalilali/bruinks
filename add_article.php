<?php
	//假設的有效會員帳號
	require_once 'php/db.php';
	require_once 'php/function.php';

$add_result=add_user_article($_POST['title'],$_POST['type'],$_POST['content'],$_POST['address']);
	if($add_result)
	{
		echo "yes";
	}
	else 
	{
		echo 'no';
	}
?>