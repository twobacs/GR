<?php

if(isset($_GET['idArt'])){
	include('../connect.php');
	include('../../../class/articles.class.php');
	$article=new Articles($pdo);
	$sql='UPDATE articles SET id_categorie=:idCateg WHERE id_article=:idArt';
	$req=$pdo->prepare($sql);
	$req->execute(array('idCateg'=>$_GET['idCateg'],'idArt'=>$_GET['idArt']));
}

?>