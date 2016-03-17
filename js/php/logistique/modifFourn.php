<?php

if(isset($_GET['id'])){
	var_dump($_GET['id']);
	include ('../connect.php');
	include('../../../class/articles.class.php');
	$art=new Articles($pdo);
	$art->modifFourn($_GET);
}
?>