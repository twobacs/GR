<?php

if(isset($_GET['art'])){
	include ('../autoload.php');
	$html='<div class="form-inline" style="padding-top:5px;padding-bottom:5px;">';
	$panier=new Panier($pdo);
	$data=$panier->getInfosLignePanier($_GET['art']);
	while($row=$data->fetch()){
		$html.='
		<div class="form-group">
			<div class="input-group-addon" style="width:135px;">Quantit&eacute; livr&eacute;e</div>
			<div class="input-group-addon" style="width:25px;cursor:pointer;"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></div>
			<div class="input-group-addon" style="width:25px;">'.$row['quantite_livree'].'</div>
			<div class="input-group-addon" style="width:25px;cursor:pointer;"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></div>
			<div class="input-group-addon" style="width:125px;">Date livraison</div>
			<div class="input-group-addon" style="width:140px;">';
			$html.=($row['date_livraison']=='0000-00-00') ? 'Non livr&eacute' : dateHrfr($row['date_livraison'],1);
			$html.='</div>
			<div class="input-group-addon" style="width:40px;">par</div>
			<div class="input-group-addon" style="width:158px;">';
			if($row['idLog_livraison']!=0){
				$html.=ucfirst($row['nom']).' '.ucfirst($row['prenom']);
			}
			else{
				$users = new Users($pdo);
				$logisticiens = $users->
				$html.='&Agrave; d&eacute;terminer';
			}
			$html.='</div>			
			<div class="input-group-addon" style="width:30px;" onclick="closeRow(\''.$_GET['i'].'\');"><span class="glyphicon glyphicon-collapse-up" aria-hidden="true"></span></div>
		</div>
		';
	}
	$html.='</div>';
	echo $html;
}
?>