<?php

if(isset($_GET['denNewFourn'])){
	include ('../connect.php');
	$fourn = new Fournisseurs($pdo);
	$fourn->updateFourn($_GET);
}

?>