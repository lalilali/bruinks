<?php
	//假設的有效會員帳號
	require_once 'php/db.php';
	require_once 'php/function.php';

$result=articlelist($_POST['sql']);
	if($result)
	{
		echo $result;
	}
	else 
	{
		echo 'no';
	}
?>