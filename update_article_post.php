<?php
	//假設的有效會員帳號
	require_once 'php/db.php';
	require_once 'php/function.php';

$result=update_article($_POST['title'],$_POST['type'],$_POST['content'],$_POST['address']);
	if($result)
	{
		echo "yes";
	}
	else 
	{
		echo 'no';
	}
?>