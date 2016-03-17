<?php

if(isset($_GET['newCateg'])){
	include ('../connect.php');
	include('../../../class/articles.class.php');
	$art=new Articles($pdo);
	$art->addCateg($_GET['newCateg']);
}

?>