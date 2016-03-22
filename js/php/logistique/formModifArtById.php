<?php

if(isset($_GET['idArt'])){
	include('../autoload.php');
	$art=new Articles($pdo);
	$data=$art->getInfosArticles($_GET['idArt']);
	print_r($data);
	// echo 'pouet';
}

?>