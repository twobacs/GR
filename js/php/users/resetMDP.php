<?php

if(isset($_GET['id'])){
	include('../connect.php');
	$id=$_GET['id'];
	$sql='UPDATE users SET mdp_user=:mdp, log_error="0" WHERE id_user=:id';
	$req=$pdo->prepare($sql);
	$req->execute(array('mdp'=>md5('azerty'), 'id'=>$id));
}

?>