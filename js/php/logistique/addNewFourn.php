
<?php

if(isset($_GET['denNewFourn'])){
	include ('../connect.php');
	$art=new Fournisseurs($pdo);
	$art->addNewFourn($_GET);
}

?>
