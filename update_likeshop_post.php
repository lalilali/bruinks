<?php
	//假設的有效會員帳號
	require_once 'php/db.php';
	require_once 'php/function.php';

$result=update_user_likeshop($_POST['likeshop']);
	if($result)
	{
		echo "yes";
	}
	else 
	{
		echo 'no';
	}
?>