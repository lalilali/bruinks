<?php
	//假設的有效會員帳號
	require_once 'php/db.php';
	require_once 'php/function.php';

$search_article=find_search($_POST['search'],$_POST['option']);
	if($search_article)
	{
		echo "yes";
	}
	else 
	{
		echo 'no';
	}
?>