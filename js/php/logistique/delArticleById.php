<?php

if(isset($_GET['idArt'])){
	include('../connect.php');
	$art=new Articles($pdo);
	echo $art->delArticlesById($_GET['idArt']);
	// echo $_GET['idArt'];
}

?>