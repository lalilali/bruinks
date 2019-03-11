<?php
	//假設的有效會員帳號
	require_once 'php/db.php';
	require_once 'php/function.php';
$year = $_POST["bd_y"]; 
$month = $_POST["bd_m"]; 
$day = $_POST["bd_d"]; 
$birthday = $year."-".$month."-".$day;

$add_result=add_user_data($_POST['account'],$_POST['password'],$_POST['nickname'],$birthday);
	if($add_result)
	{
		echo "yes";
	}
	else 
	{
		echo 'no';
	}
?>