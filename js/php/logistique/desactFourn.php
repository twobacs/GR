<?php

if(isset($_GET['id'])){
	include ('../connect.php');
	include('../../../class/articles.class.php');
	$art=new Articles($pdo);
	$art->desactFourn($_GET['id']);
}
?>