<?php

if(isset($_GET['newMesure'])){
	include ('../connect.php');
	include('../../../class/articles.class.php');
	$art=new Articles($pdo);
	$art->addUMesure($_GET['newMesure']);
}

?>