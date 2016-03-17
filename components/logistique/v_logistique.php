<?php

class VLogistique extends VBase {

    function __construct($appli, $model) {
        parent::__construct($appli, $model);
		$this->appli->jscript='<script type="text/javascript" src="/GR/js/logistique.js"></script>';
    }

public function datefr($date){
	$a=explode("-", $date);
	$annee=$a[0];
	$mois=$a[1];
	$jour=$a[2];
	$rep=$jour.'-'.$mois.'-'.$annee;
	return $rep;
}


public function unconnected(){
	$html='<div id="unconnected">';
	$html.='Vous n\'&ecirc;tes pas connect&eacute;(e) ou votre session a expir&eacute;, veuillez vous connecter.';
	$html.='</div>';
	$this->appli->content=$html;
}

public function error(){
	$html='<div id="error">';
	$html.='<h1>Erreur !</h1>';
	$html.='Vous n\'avez pas les droits requis pour arriver ici !';
	$html.='</div>';
	$this->appli->content=$html;
}

public function errorRec($param,$from){
	$html='<div id="error"><h1>Erreur !</h1>';
	switch($param){
		case 1: //Auto-suppression
			$html.='Vous ne pouvez retirer vos propres acc&egrave;s !';
			break;
		case 2: //Ajout personne existante
			$html.='Cet acc&egrave;s est d&eacute;j&agrave exitant.';
			break;
		case 3://Arme existante en bdd		
			$html.='Ce num&eacute;ro existe d&eacute;j&agrave; en base de donn&eacute;es.';
			break;
	}
	$component=$_GET['component'];
	$action=$_GET['action'];
	if($action=='addMat'){
		switch($_GET['type']){
			case 'arme':
				$action='&action=gestArmes&visible=armes';
				break;
		}
	}
	else if($action=='gestUsers'){
		$action='&action=gestUsers';
	}
	$html.='<br /><a href="?component='.$component.$action;
	// $html.=(isset($_GET['module'])) ? '&module='.$_GET['module'] : '' ;
	$html.='">Retour</a>';
	$html.='</div>';
	$this->appli->content=$html;
}

public function accueil($niv){
	$html='<div id="menuAccueil">';
	$html.='<h1>Menu logistique</h1>';
	switch($niv){
		case '0':
			$html.='Vous n\'avez aucun acc&egrave;s &agrave cette application, veuillez vous adresser au service logistique afin d\'en obtenir un.';
			break;
		case '10':
			$html.=$this->menuAdminLog();
			$html.=$this->menuLogisticien();
			$html.=$this->menuOuvrier();
			$html.=$this->menuUser();
			break;
		case '8':
			$html.=$this->menuLogisticien();
			$html.=$this->menuOuvrier();
			$html.=$this->menuUser();
			break;
		case '5':
			$html.=$this->menuOuvrier();
			$html.=$this->menuUser();
			break;
		case '1':
			$html.=$this->menuUser();
			break;
	}
	$html.='</div>';
	$this->appli->content=$html;
}

public function menuAdminLog(){
	$html='<div id="MenuAdmin">';
	$html.='<div id="menuLog"  onclick="slide(\'slide1\',\'0\');">Menu administrateur</div>';
	$html.='<div id="slide1">';
	$html.='<div id="aLog"><a href="?component=logistique&action=gestUsers">Gestion des utilisateurs du module</a><br /><a href="?component=user&action=gestUsers">Gestion des utilisateurs de la plateforme</a></div>';
	$html.='</div>';
	$html.='</div>';
	return $html;
}

public function menuLogisticien(){
	$html='<div id="MenuLogisticien">';
	$html.='<div id="menuLog" onclick="slide(\'slide2\',\'0\');">Menu logisticien</div>';
	$html.='<div id="slide2">';
	$html.='<div id="aLog">';
	$html.='<a href="?component=logistique&action=gestArmes">Gestion des armes</a><br />';
	$html.='<a href="?component=logistique&action=gestBrassards">Gestion des brassards police</a><br />';
	$html.='<a href="?component=logistique&action=gestRadios">Gestion des radios "Astrid"</a><br />';
	$html.='<a href="?component=logistique&action=gestBatons">Gestion des b&acirc;tons de police</a><br />';
	$html.='<a href="?component=logistique&action=gestETTs">Gestion des ETT</a><br />';
	$html.='<a href="?component=logistique&action=gestPMB">Gestion papeterie et mat&eacuteriel de bureau</a><br />';
	$html.='</div>';
	$html.='</div>';
	$html.='</div>';
	return $html;	
}

public function menuOuvrier(){
	$html='<div id="MenuOuvrier">';
	$html.='<div id="menuLog"  onclick="slide(\'slide3\',\'0\');">Menu ouvrier</div>';
	$html.='<div id="slide3">';
	$html.='<div id="aLog"><a href="?component=logistique&action=gestUsers">Exemple lien ouvrier</a></div>';
	$html.='</div>';
	$html.='</div>';
	return $html;
}

public function menuUser(){
	$html='<div id="MenuUser">';
	$html.='<div id="menuLog"  onclick="slide(\'slide4\',\'0\');">Menu utilisateur</div>';
	$html.='<div id="slide4">';
	$html.='<div id="aLog"><a href="?component=logistique&action=gestUsers">Exemple lien utilisateurs</a></div>';
	$html.='</div>';
	$html.='</div>';
	return $html;	
}

public function gestDroits($droits,$users){
	$html='<div id="gestAdminSite">';
	$html.='<h2>Gestion des droits pour le module logistique</h2>';
	$html.='<h3>Utilisateurs actuels</h3>';
	$options='';
	while($row=$users->fetch()){
		$options.='<option value="'.$row['id_user'].'">'.$row['nom'].' '.$row['prenom'].'</option>';
	}
	$html.='<table class="table">';
	$html.='<tr><th>Nom</th><th>Pr&eacute;nom</th><th>Niveau actuel</th><th></th></tr>';
	while($row=$droits->fetch()){
		$html.='<tr><td>'.$row['nom'].'</td><td>'.$row['prenom'].'</td><td>';
		switch($row['niv_acces']){
			case '10':
				$html.='Administrateur';
				break;
			case '8':
				$html.='Logisticien';
				break;
			case '5':
				$html.='Ouvrier';
				break;
			case '1':
				$html.='Utilisateur enregistr&eacute;';
				break;				
		}
		$html.='</td><td><a href="?component=admin&action=delDroitsById&module=logistique&idRow='.$row['id'].'"><input type="button" id="bSupAdmin" value="R&eacute;voquer" /></a></td></tr>';
	}
	$html.='</table><hr><h3>Ajouter un utilisateur</h3>';
	$html.='<form method="POST" action="?component=admin&action=addUserToModule&module=logistique"><table class="table">';
	$html.='<tr><th>Utilisateur :</th><td><select class="form-control" name="selectedUser" required><option></option>'.$options.'</select></td><th>Niveau d\'acc&egrave;s :</th><td><select class="form-control" name="nivAcces"><option value="1">Utilisateur enregistr&eacute;</option><option value="5">Ouvrier</option><option value="8">Logisticien</option><option value="10">Administrateur</option></select></td><td><input type="submit" value="Enregistrer" id="bAddAdmin" /></td></tr>';
	$html.='</table></form>';
	$html.='</div>';
	$this->appli->content=$html;
}

public function gestArmes($armes,$users,$data,$histoarme,$histouser){
	$userarme=$data['userArme'];
	$now=date('y-m-d');
	$visible=(isset($_GET['visible'])) ? $_GET['visible'] : '';
	$html='<div id="gestAdminSite">';
	$html.='<h2>Gestion des armes</h2>';
	$html.='<h3 onclick="slide(\'slide1\',\'0\');">Tableau des attributions</h3>';
	$html.='<div id="slide1" ';
	$html.=($visible=='attrib') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table">';
	$html.='<tr><th onclick="location.href=\'?component=logistique&action=gestArmes&visible=attrib&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='nomDESC')) ? 'nomASC' : 'nomDESC';
	$html.='\'">Nom</th><th onclick="location.href=\'?component=logistique&action=gestArmes&visible=attrib&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='prenomDESC')) ? 'prenomASC' : 'prenomDESC';
	$html.='\'">Prénom</th><th onclick="location.href=\'?component=logistique&action=gestArmes&visible=attrib&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='numArmeDESC')) ? 'numArmeASC' : 'numArmeDESC';
	$html.='\'">Num&eacute;ro d\'arme</th><th onclick="location.href=\'?component=logistique&action=gestArmes&visible=attrib&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='modArmeDESC')) ? 'modArmeASC' : 'modArmeDESC';
	$html.='\'">Mod&egrave;le arme</th><td></td></tr>';
	while($row=$userarme->fetch()){
		$html.='<form><tr><td>'.$row['nom'].'</td><td>'.$row['prenom'].'</td><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=arme&id='.$row['num_arme'].'&visible=attrib\'">'.$row['num_arme'].'</td><td>'.$row['marque_arme'].'</td><td>';
		if($row['coffre']!='O'){
			$html.='<a href=?component=logistique&action=retour&subAction=arme&idUser='.$row['id_user'].'><input type="button" value="Retirer" id="bSupAdmin"></a></td></tr></form>';
		}
		else{
			$html.='<a href=?component=logistique&action=restituer&subAction=arme&idUser='.$row['id_user'].'><input type="button" value="Restituer" id="bAddAdmin"></a></td></tr></form>';
		}
	}
	$html.='</table>';
	$html.='<a href="?component=logistique&action=assoc&type=arme"><input type="button" value="Nouvelle attribution" id="bAddAdmin"></a>';	
	$html.='</div>';
	
	$html.='<h3 onclick="slide(\'slide2\',\'0\');">Tableau des armes</h3>';
	$html.='<div id="slide2"';
	$html.=($visible=='armes') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table" id="tabArmes">';
	$html.='<tr><th  style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestArmes&visible=armes&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='modArmeDESC')) ? 'modArmeASC' : 'modArmeDESC';
	$html.='\'">Marque et mod&egrave;le</th><th  style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestArmes&visible=armes&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='numArmeDESC')) ? 'numArmeASC' : 'numArmeDESC';
	$html.='\'">Num&eacute;ro</th><th  style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestArmes&visible=armes&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='calibreDESC')) ? 'calibreASC' : 'calibreDESC';
	$html.='\'">Calibre</th><th  style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestArmes&visible=armes&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='livraisonDESC')) ? 'livraisonASC' : 'livraisonDESC';
	$html.='\'">Date de livraison</th><th style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestArmes&visible=armes&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='dispoDESC')) ? 'dispoASC' : 'dispoDESC';
	$html.='\'">Disponibilit&eacute;</th><th  style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestArmes&visible=armes&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='ctrlDESC')) ? 'ctrlASC' : 'ctrlDESC';
	$html.='\'">Validit&eacute; contr&ocirc;le</th></tr>';
	while($row=$armes->fetch()){
		$html.='<tr><td>'.$row['marque_arme'].'</td><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=arme&id='.$row['num_arme'].'&visible=armes\'">'.$row['num_arme'].'</td><td>'.$row['calibre'].'</td><td>'.$this->datefr($row['dateLivraison']).'</td><td';
		$html.=($row['disponible']=='O') ? ' bgcolor="#66FF99">Disponible' : ' bgcolor="#ff6666" style="cursor:pointer" onclick="aqui(\'arme\',\''.$row['id_user'].'\');">Attribu&eacute;e';
		$html.='</td><td';
		if(strtotime($now)>strtotime($row['validite_arme'])){
			$html.=' bgcolor="#ff6666">';
		}
		else if(strtotime((date('Y-m-d',strtotime('+1 month')))) > strtotime($row['validite_arme'])){
			$html.=' bgcolor="#ffc266">';
		}
		else $html.=' bgcolor="#66FF99">';
		$html.=$this->datefr($row['validite_arme']).'</td></tr>';
	}
	$html.='</table>';
	$html.='<a href="?component=logistique&action=addMat&type=arme"><input type="button" id="bAddAdmin" value="Ajouter une arme"/></a>';
	$html.='</div>';
	$html.='<h3 onclick="slide(\'slide3\',\'0\');">Historique par arme</h3>';
	$html.='<div id="slide3" ';
	$html.=($visible=='histoArme') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table" id="histoArmes">';
	$html.='<tr><th>Marque et mod&egrave;le</th><th>Num&eacute;ro</th><th>Attribution</th><th>Motif</th><th>Retrait</th><th>Motif</th><th>Utilisateur</th></tr>';
	while($row=$histoarme->fetch()){
		$html.='<tr><td>'.$row['marque_arme'].'</td><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=arme&id='.$row['num_arme'].'&visible=histoArme\'">'.$row['num_arme'].'</td><td>'.$this->datefr($row['dateA']).'</td><td>'.$row['motifA'].'</td><td>'.$this->datefr($row['dateR']).'</td><td>'.$row['motifR'].'</td><td>'.$row['nom'].' '.$row['prenom'].'</td></tr>';
	}
	$html.='</table>';
	$html.='</div>';
	$html.='<h3 onclick="slide(\'slide4\',\'0\');">Historique par utilisateur</h3>';
	$html.='<div id="slide4" ';
	$html.=($visible=='histoUser') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table" id="histoUsers">';
	$html.='<tr><th>Utilisateur</th><th>Marque et mod&egrave;le</th><th>Num&eacute;ro</th><th>Attribution</th><th>Motif</th><th>Retrait</th><th>Motif</th></tr>';
	while($row=$histouser->fetch()){
		$html.='<tr><td>'.$row['nom'].' '.$row['prenom'].'</td><td>'.$row['marque_arme'].'</td><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=arme&id='.$row['num_arme'].'&visible=histoUser\'">'.$row['num_arme'].'</td><td>'.$this->datefr($row['dateA']).'</td><td>'.$row['motifA'].'</td><td>';
		$html.=($row['dateR']=='0000-00-00') ? '' : $this->datefr($row['dateR']);
		$html.='</td><td>'.$row['motifR'].'</td></tr>';
	}
	$html.='</table>';
	$html.='</div>';
	$html.='</div>';
	$this->appli->content=$html;	
}

public function gestBrassards($brassards,$users,$userbrassard,$histobrassard,$histouser){
	$userbrassard=$userbrassard['userbrassard'];
	$now=date('y-m-d');
	$visible=(isset($_GET['visible'])) ? $_GET['visible'] : '';
	$html='<div id="gestAdminSite">';
	$html.='<h2>Gestion des brassards</h2>';
	$html.='<h3 onclick="slide(\'slide1\',\'0\');">Tableau des attributions</h3>';
	$html.='<div id="slide1" ';
	$html.=($visible=='attrib') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table">';
	$html.='<tr><th style="cursor:pointer" onclick="location.href=\'?component=logistique&action=gestBrassards&visible=attrib&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='nomDESC')) ? 'nomASC' : 'nomDESC';
	$html.='\'">Nom</th><th style="cursor:pointer" onclick="location.href=\'?component=logistique&action=gestBrassards&visible=attrib&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='prenomDESC')) ? 'prenomASC' : 'prenomDESC';
	$html.='\'">Prénom</th><th style="cursor:pointer" onclick="location.href=\'?component=logistique&action=gestBrassards&visible=attrib&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='numBrassardDESC')) ? 'numBrassardASC' : 'numBrassardDESC';
	$html.='\'">Num&eacute;ro de brassard</th><td></td></tr>';
	while($row=$userbrassard->fetch()){
		$html.='<form><tr><td>'.$row['nom'].'</td><td>'.$row['prenom'].'</td><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=brassard&id='.$row['num_brassard'].'&visible=attrib\'">'.$row['num_brassard'].'</td><td><a href=?component=logistique&action=retour&subAction=brassard&idUser='.$row['id_user'].'><input type="button" value="Retirer" id="bSupAdmin"></a></td></tr></form>';
	}
	$html.='</table>';
	$html.='<a href="?component=logistique&action=assoc&type=brassard"><input type="button" value="Nouvelle attribution" id="bAddAdmin"></a>';	
	$html.='</div>';
	
	$html.='<h3 onclick="slide(\'slide2\',\'0\');">Tableau des brassards</h3>';
	$html.='<div id="slide2"';
	$html.=($visible=='brassards') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table" id="tabBrassards">';
	$html.='<tr><th  style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestBrassards&visible=brassards&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='numBrassardDESC')) ? 'numBrassardASC' : 'numBrassardDESC';
	$html.='\'">Num&eacute;ro</th><th  style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestBrassards&visible=brassards&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='livraisonDESC')) ? 'livraisonASC' : 'livraisonDESC';
	$html.='\'">Date de livraison</th><th style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestBrassards&visible=brassards&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='dispoDESC')) ? 'dispoASC' : 'dispoDESC';
	$html.='\'">Disponibilit&eacute;</th></tr>';
	while($row=$brassards->fetch()){
		$html.='<tr><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=brassard&id='.$row['num_brassard'].'&visible=brassards\'">'.$row['num_brassard'].'</td><td>'.$this->datefr($row['dateLivraison']).'</td><td';
		switch($row['disponible']){
			case 'O':
				$html.=' bgcolor="#66FF99">Disponible';
				break;
			case 'N':
				$html.=' bgcolor="#ff6666" style="cursor:pointer" onclick="aqui(\'brassard\',\''.$row['id_user'].'\');">Attribu&eacute;';
				break;
			case 'P':
				$html.=' bgcolor="#ffc34d">Perdu';
		}
		$html.='</td></tr>';
	}
	$html.='</table>';
	$html.='<a href="?component=logistique&action=addMat&type=brassard"><input type="button" id="bAddAdmin" value="Ajouter un brassard"/></a>';
	$html.='</div>';
	$html.='<h3 onclick="slide(\'slide3\',\'0\');">Historique par brassard</h3>';
	$html.='<div id="slide3" ';
	$html.=($visible=='histoBrassard') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table" id="histoBrassards">';
	$html.='<tr><th>Num&eacute;ro</th><th>Attribution</th><th>Motif</th><th>Retrait</th><th>Motif</th><th>Utilisateur</th></tr>';
	while($row=$histobrassard->fetch()){
		$html.='<tr><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=brassard&id='.$row['num_brassard'].'&visible=histoArme\'">'.$row['num_brassard'].'</td><td>'.$this->datefr($row['dateA']).'</td><td>'.$row['motifA'].'</td><td>';
		$html.=($row['dateR']!="0000-00-00") ? $this->datefr($row['dateR']) : '';
		$html.='</td><td>'.$row['motifR'].'</td><td>'.$row['nom'].' '.$row['prenom'].'</td></tr>';
	}
	$html.='</table>';
	$html.='</div>';
	$html.='<h3 onclick="slide(\'slide4\',\'0\');">Historique par utilisateur</h3>';
	$html.='<div id="slide4" ';
	$html.=($visible=='histoUser') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table" id="histoUsers">';
	$html.='<tr><th>Utilisateur</th><th>Num&eacute;ro</th><th>Attribution</th><th>Motif</th><th>Retrait</th><th>Motif</th></tr>';
	while($row=$histouser->fetch()){
		$html.='<tr><td>'.$row['nom'].' '.$row['prenom'].'</td><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=brassard&id='.$row['num_brassard'].'&visible=histoUser\'">'.$row['num_brassard'].'</td><td>'.$this->datefr($row['dateA']).'</td><td>'.$row['motifA'].'</td><td>';
		$html.=($row['dateR']=='0000-00-00') ? '' : $this->datefr($row['dateR']);
		$html.='</td><td>'.$row['motifR'].'</td></tr>';
	}
	$html.='</table>';
	$html.='</div>';
	$html.='</div>';
	$this->appli->content=$html;
}

public function gestRadios($radios,$users,$userradio,$histobrassard,$histouser){
	$userradio=$userradio['userradio'];
	$now=date('y-m-d');
	$visible=(isset($_GET['visible'])) ? $_GET['visible'] : '';
	$html='<div id="gestAdminSite">';
	$html.='<h2>Gestion des radios "Astrid"</h2>';
	$html.='<h3 onclick="slide(\'slide1\',\'0\');">Tableau des attributions</h3>';
	$html.='<div id="slide1" ';
	$html.=($visible=='attrib') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table">';
	$html.='<tr><th style="cursor:pointer" onclick="location.href=\'?component=logistique&action=gestRadios&visible=attrib&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='nomDESC')) ? 'nomASC' : 'nomDESC';
	$html.='\'">Nom</th><th style="cursor:pointer" onclick="location.href=\'?component=logistique&action=gestRadios&visible=attrib&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='prenomDESC')) ? 'prenomASC' : 'prenomDESC';
	$html.='\'">Prénom</th><th style="cursor:pointer" onclick="location.href=\'?component=logistique&action=gestRadios&visible=attrib&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='numTEIDESC')) ? 'numTEIASC' : 'numTEIDESC';
	$html.='\'">Num&eacute;ro TEI</th>';
	$html.='<th style="cursor:pointer" onclick="location.href=\'?component=logistique&action=gestRadios&visible=attrib&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='numISSIDESC')) ? 'numISSIASC' : 'numISSIDESC';
	$html.='\'">Num&eacute;ro ISSI</th><td></td></tr>';
	while($row=$userradio->fetch()){
		$html.='<form><tr><td>'.$row['nom'].'</td><td>'.$row['prenom'].'</td><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=radio&id='.$row['num_TEI'].'&visible=attrib\'">'.$row['num_TEI'].'</td><td>'.$row['num_ISSI'].'</td><td><a href=?component=logistique&action=retour&subAction=radio&idUser='.$row['id_user'].'><input type="button" value="Retirer" id="bSupAdmin"></a></td></tr></form>';
	}
	$html.='</table>';
	$html.='<a href="?component=logistique&action=assoc&type=radio"><input type="button" value="Nouvelle attribution" id="bAddAdmin"></a>';	
	$html.='</div>';
	
	$html.='<h3 onclick="slide(\'slide2\',\'0\');">Tableau des radios</h3>';
	$html.='<div id="slide2"';
	$html.=($visible=='radios') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table" id="tabRadios">';
	$html.='<tr><th  style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestRadios&visible=radios&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='numTEIDESC')) ? 'numTEIASC' : 'numTEIDESC';
	$html.='\'">Num&eacute;ro TEI</th><th  style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestRadios&visible=radios&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='numISSIDESC')) ? 'numISSIASC' : 'numISSIDESC';
	$html.='\'">Num&eacute;ro ISSI</th><th  style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestRadios&visible=radios&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='livraisonDESC')) ? 'livraisonASC' : 'livraisonDESC';
	$html.='\'">Date de livraison</th><th style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestRadios&visible=radios&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='dispoDESC')) ? 'dispoASC' : 'dispoDESC';
	$html.='\'">Disponibilit&eacute;</th></tr>';
	while($row=$radios->fetch()){
		$html.='<tr><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=radio&id='.$row['num_TEI'].'&visible=radios\'">'.$row['num_TEI'].'</td><td>'.$row['num_ISSI'].'</td><td>'.$this->datefr($row['dateLivraison']).'</td><td';
		switch($row['disponible']){
			case 'O':
				$html.=' bgcolor="#66FF99">Disponible';
				break;
			case 'N':
				$html.=' bgcolor="#ff6666" style="cursor:pointer" onclick="aqui(\'radio\',\''.$row['id_user'].'\');">Attribu&eacute;';
				break;
			case 'P':
				$html.=' bgcolor="#ffc34d">Perdu';
		}
		$html.='</td></tr>';
	}
	$html.='</table>';
	$html.='<a href="?component=logistique&action=addMat&type=radio"><input type="button" id="bAddAdmin" value="Ajouter une radio"/></a>';
	$html.='</div>';
	$html.='<h3 onclick="slide(\'slide3\',\'0\');">Historique par radio</h3>';
	$html.='<div id="slide3" ';
	$html.=($visible=='histoBrassard') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table" id="histoBrassards">';
	$html.='<tr><th>Num&eacute;ro</th><th>Attribution</th><th>Motif</th><th>Retrait</th><th>Motif</th><th>Utilisateur</th></tr>';
	while($row=$histobrassard->fetch()){
		$html.='<tr><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=radio&id='.$row['num_TEI'].'&visible=histoArme\'">'.$row['num_TEI'].'</td><td>'.$this->datefr($row['dateA']).'</td><td>'.$row['motifA'].'</td><td>';
		$html.=($row['dateR']!="0000-00-00") ? $this->datefr($row['dateR']) : '';
		$html.='</td><td>'.$row['motifR'].'</td><td>'.$row['nom'].' '.$row['prenom'].'</td></tr>';
	}
	$html.='</table>';
	$html.='</div>';
	$html.='<h3 onclick="slide(\'slide4\',\'0\');">Historique par utilisateur</h3>';
	$html.='<div id="slide4" ';
	$html.=($visible=='histoUser') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table" id="histoUsers">';
	$html.='<tr><th>Utilisateur</th><th>Num&eacute;ro</th><th>Attribution</th><th>Motif</th><th>Retrait</th><th>Motif</th></tr>';
	while($row=$histouser->fetch()){
		$html.='<tr><td>'.$row['nom'].' '.$row['prenom'].'</td><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=radio&id='.$row['num_TEI'].'&visible=histoUser\'">'.$row['num_TEI'].'</td><td>'.$this->datefr($row['dateA']).'</td><td>'.$row['motifA'].'</td><td>';
		$html.=($row['dateR']=='0000-00-00') ? '' : $this->datefr($row['dateR']);
		$html.='</td><td>'.$row['motifR'].'</td></tr>';
	}
	$html.='</table>';
	$html.='</div>';
	$html.='</div>';	
	$this->appli->content=$html;
}

public function gestBatons($batons,$users,$userbaton,$histobaton,$histouser){
	$userbaton=$userbaton['userBaton'];
	$now=date('y-m-d');
	$visible=(isset($_GET['visible'])) ? $_GET['visible'] : '';
	$html='<div id="gestAdminSite">';
	$html.='<h2>Gestion des b&acirc;tons de police</h2>';
	$html.='<h3 onclick="slide(\'slide1\',\'0\');">Tableau des attributions</h3>';
	$html.='<div id="slide1" ';
	$html.=($visible=='attrib') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table">';
	$html.='<tr><th style="cursor:pointer" onclick="location.href=\'?component=logistique&action=gestBatons&visible=attrib&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='nomDESC')) ? 'nomASC' : 'nomDESC';
	$html.='\'">Nom</th><th style="cursor:pointer" onclick="location.href=\'?component=logistique&action=gestBatons&visible=attrib&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='prenomDESC')) ? 'prenomASC' : 'prenomDESC';
	$html.='\'">Prénom</th><th style="cursor:pointer" onclick="location.href=\'?component=logistique&action=gestBatons&visible=attrib&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='numBatonDESC')) ? 'numBatonASC' : 'numBatonDESC';
	$html.='\'">Num&eacute;ro</th>';
	$html.='<td></td></tr>';
	while($row=$userbaton->fetch()){
		$html.='<form><tr><td>'.$row['nom'].'</td><td>'.$row['prenom'].'</td><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=baton&id='.$row['num_baton'].'&visible=attrib\'">'.$row['num_baton'].'</td><td><a href=?component=logistique&action=retour&subAction=baton&idUser='.$row['id_user'].'><input type="button" value="Retirer" id="bSupAdmin"></a></td></tr></form>';
	}
	$html.='</table>';
	$html.='<a href="?component=logistique&action=assoc&type=baton"><input type="button" value="Nouvelle attribution" id="bAddAdmin"></a>';	
	$html.='</div>';
	
	$html.='<h3 onclick="slide(\'slide2\',\'0\');">Tableau des b&acirc;tons</h3>';
	$html.='<div id="slide2"';
	$html.=($visible=='batons') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table" id="tabRadios">';
	$html.='<tr><th  style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestBatons&visible=batons&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='numBatonDESC')) ? 'numBatonASC' : 'numBatonDESC';
	$html.='\'">Num&eacute;ro</th><th  style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestBatons&visible=batons&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='livraisonDESC')) ? 'livraisonASC' : 'livraisonDESC';
	$html.='\'">Date de livraison</th><th style="cursor : pointer;" onclick="location.href=\'?component=logistique&action=gestBatons&visible=batons&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='dispoDESC')) ? 'dispoASC' : 'dispoDESC';
	$html.='\'">Disponibilit&eacute;</th></tr>';
	while($row=$batons->fetch()){
		$html.='<tr><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=baton&id='.$row['num_baton'].'&visible=batons\'">'.$row['num_baton'].'</td><td>'.$this->datefr($row['dateLivraison']).'</td><td';
		switch($row['disponible']){
			case 'O':
				$html.=' bgcolor="#66FF99">Disponible';
				break;
			case 'N':
				$html.=' bgcolor="#ff6666" style="cursor:pointer" onclick="aqui(\'baton\',\''.$row['id_user'].'\');">Attribu&eacute;';
				break;
			case 'P':
				$html.=' bgcolor="#ffc34d">Perdu';
		}
		$html.='</td></tr>';
	}
	$html.='</table>';
	$html.='<a href="?component=logistique&action=addMat&type=baton"><input type="button" id="bAddAdmin" value="Ajouter un b&acirc;ton"/></a>';
	$html.='</div>';
	$html.='<h3 onclick="slide(\'slide3\',\'0\');">Historique par b&acirc;ton</h3>';
	$html.='<div id="slide3" ';
	$html.=($visible=='histoBatons') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table" id="histoBaton">';
	$html.='<tr><th>Num&eacute;ro</th><th>Attribution</th><th>Motif</th><th>Retrait</th><th>Motif</th><th>Utilisateur</th></tr>';
	while($row=$histobaton->fetch()){
		$html.='<tr><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=baton&id='.$row['num_baton'].'&visible=histoBaton\'">'.$row['num_baton'].'</td><td>'.$this->datefr($row['dateA']).'</td><td>'.$row['motifA'].'</td><td>';
		$html.=($row['dateR']!="0000-00-00") ? $this->datefr($row['dateR']) : '';
		$html.='</td><td>'.$row['motifR'].'</td><td>'.$row['nom'].' '.$row['prenom'].'</td></tr>';
	}
	$html.='</table>';
	$html.='</div>';
	$html.='<h3 onclick="slide(\'slide4\',\'0\');">Historique par utilisateur</h3>';
	$html.='<div id="slide4" ';
	$html.=($visible=='histoUser') ? 'style="display:block;"' : '' ;
	$html.='>';
	$html.='<table class="table" id="histoUsers">';
	$html.='<tr><th>Utilisateur</th><th>Num&eacute;ro</th><th>Attribution</th><th>Motif</th><th>Retrait</th><th>Motif</th></tr>';
	while($row=$histouser->fetch()){
		$html.='<tr><td>'.$row['nom'].' '.$row['prenom'].'</td><td style="cursor:pointer" onclick="document.location.href=\'?component=logistique&action=details&type=baton&id='.$row['num_baton'].'&visible=histoUser\'">'.$row['num_baton'].'</td><td>'.$this->datefr($row['dateA']).'</td><td>'.$row['motifA'].'</td><td>';
		$html.=($row['dateR']=='0000-00-00') ? '' : $this->datefr($row['dateR']);
		$html.='</td><td>'.$row['motifR'].'</td></tr>';
	}
	$html.='</table>';
	$html.='</div>';
	$html.='</div>';	
	$this->appli->content=$html;
}

public function motifRetrait($mat,$data,$motifs){
	while($row=$data['user']->fetch()){
		$nom=$row['nom'];
		$prenom=$row['prenom'];
	}
	$matos=$data['matos'];
	$motifR='<select class="form-control" name="motif" required><option></option><option value="Maladie longue dur&eacute;e">Maladie longue dur&eacute;e</option><option value="D&eacute;part pension">D&eacute;part pension</option><option value="D&eacute;cision judiciaire">D&eacute;cision judiciaire</option><option value="D&eacute;cision administrative">D&eacute;cision administrative</option><option value="D&eacute;cision SEMESOTRA">D&eacute;cision SEMESOTRA</option><option value="Certificat m&eacute;dical">Certificat m&eacute;dical</option></select>';
	$enTeteForm='<form method="POST" action="?component=logistique&action=retour&subAction='.$mat.'&idRow='.$data['idRow'].'"><table class="table">';
	$html='<div id="gestAdminSite">';
	$html.='<h2>Retrait d';
	switch ($mat){
		case 'arme':
			$html.='\'une arme</h2>';
			$html.=$enTeteForm;
			$html.='<tr><th>Nom</th><th>Pr&eacute;nom</th><th>Mod&egrave;le d\'arme</th><th>Num&eacute;ro d\'arme</th><th>Motif retrait</th></tr>';
			$html.='<tr><td>'.$nom.'</td><td>'.$prenom.'</td><td>'.$matos['modele'].'</td><td>'.$matos['num_arme'].'</td><th>';
			$html.='<select class="form-control" name="motif">';
			while($row=$motifs->fetch()){
				$html.='<option value="'.$row['id'].'">'.$row['cause'].'</option>';
			}
			$html.='</select><br /><img src="./media/icons/more_icon.png" height="20px"  onclick="slide(\'slide1\');"></th></tr>';
			$html.='<tr id="slide1"><th colspan="2">Nouveau motif :<br />Disponible suite &agrave; ce retrait ?</th><td colspan="2"><input type="text" id="newMotif"><br /><input type="radio" id="dispo" name="dispo" value="O">Oui <input type="radio" name="dispo" id="dispo" value="N">Non</td><td><input type="button" id="bAddAdmin" value="Enregistrer motif" onclick="recNewMotif(\'arme\',\'retrait\');"></td></tr>';
			$html.='<tr><th colspan="2">Date retrait : </th><td colspan="2"><input type="date" name="dateRest" required /></td><td><input type="submit" id="bSupAdmin" value="R&eacute;voquer" /></td></tr>';
			break;
		case 'brassard':
			$html.='\'un brassard</h2>';
			$html.=$enTeteForm;
			$html.='<tr><th>Nom</th><th>Pr&eacute;nom</th><th>Num&eacute;ro de brassard</th><th>Motif retrait</th></tr>';
			$html.='<tr><td>'.$nom.'</td><td>'.$prenom.'</td><td>'.$matos['num_brassard'].'</td><th>';
			$html.='<select class="form-control" name="motif">';
			while($row=$motifs->fetch()){
				$html.='<option value="'.$row['id'].'">'.$row['cause'].'</option>';
			}
			$html.='</select><br /><img src="./media/icons/more_icon.png" height="20px"  onclick="slide(\'slide1\');"></th></tr>';
			$html.='<tr id="slide1"><th>Nouveau motif :<br />Disponible suite &agrave; ce retrait ?</th><td colspan="2"><input type="text" id="newMotif"><br /><input type="radio" id="dispo" name="dispo" value="O">Oui <input type="radio" name="dispo" id="dispo" value="N">Non</td><td><input type="button" id="bAddAdmin" value="Enregistrer motif" onclick="recNewMotif(\'brassard\',\'retrait\');"></td></tr>';
			$html.='<tr><td colspan="2">Date retrait : <input type="date" name="dateRest" required /></td><td><input type="submit" id="bSupAdmin" value="R&eacute;voquer" /></td></tr>';
			break;
		case 'radio':
			$html.='\'une radio</h2>';
			$html.=$enTeteForm;
			$html.='<tr><th>Nom</th><th>Pr&eacute;nom</th><th>Num&eacute;ro TEI</th><th>Motif retrait</th></tr>';
			$html.='<tr><td>'.$nom.'</td><td>'.$prenom.'</td><td>'.$matos['num_TEI'].'</td><th>';
			$html.='<select class="form-control" name="motif">';
			while($row=$motifs->fetch()){
				$html.='<option value="'.$row['id'].'">'.$row['cause'].'</option>';
			}
			$html.='</select><br /><img src="./media/icons/more_icon.png" height="20px"  onclick="slide(\'slide1\');"></th></tr>';
			$html.='<tr id="slide1"><th>Nouveau motif :<br />Disponible suite &agrave; ce retrait ?</th><td colspan="2"><input type="text" id="newMotif"><br /><input type="radio" id="dispo" name="dispo" value="O">Oui <input type="radio" name="dispo" id="dispo" value="N">Non</td><td><input type="button" id="bAddAdmin" value="Enregistrer motif" onclick="recNewMotif(\'radio\',\'retrait\');"></td></tr>';			
			$html.='</th></tr>';
			$html.='<tr><td colspan="2">Date retrait : <input type="date" name="dateRest" required /></td><td><input type="submit" id="bSupAdmin" value="R&eacute;voquer" /></td></tr>';
			break;
		case 'baton':
			$html.='\'un b&acirc;ton</h2>';
			$html.=$enTeteForm;
			$html.='<tr><th>Nom</th><th>Pr&eacute;nom</th><th>Num&eacute;ro b&acirc;ton</th><th>Motif retrait</th></tr>';
			$html.='<tr><td>'.$nom.'</td><td>'.$prenom.'</td><td>'.$matos['num_baton'].'</td><th>';
			// .$motifR.
			$html.='<select class="form-control" name="motif">';
			while($row=$motifs->fetch()){
				$html.='<option value="'.$row['id'].'">'.$row['cause'].'</option>';
			}
			$html.='</select><br /><img src="./media/icons/more_icon.png" height="20px"  onclick="slide(\'slide1\');"></th></tr>';
			$html.='<tr id="slide1"><th>Nouveau motif :<br />Disponible suite &agrave; ce retrait ?</th><td colspan="2"><input type="text" id="newMotif"><br /><input type="radio" id="dispo" name="dispo" value="O">Oui <input type="radio" name="dispo" id="dispo" value="N">Non</td><td><input type="button" id="bAddAdmin" value="Enregistrer motif" onclick="recNewMotif(\'baton\',\'retrait\');"></td></tr>';						
			$html.='</th></tr>';
			$html.='<tr><td colspan="2">Date retrait : <input type="date" name="dateRest" required /></td><td><input type="submit" id="bSupAdmin" value="R&eacute;voquer" /></td></tr>';
			break;		
		}
	$html.='</table></form></div>';
	$this->appli->content=$html;
}

public function menuAdd($from,$data,$users,$logisticien,$motifs){
	$selectUser='<select class="form-control" name="id_user" required><option></option>';
	for($i=0;$i<=$users['lastIndex'];$i++){
		if(isset($users[$i]['id_user'])){
			$selectUser.='<option value="'.$users[$i]['id_user'].'">'.strtoupper($users[$i]['nom']).' '.$users[$i]['prenom'].'</option>';
		}
	}
	$selectUser.='</select>';
	
	$selectLog='<select class="form-control" name="logisticien" required><option></option>';
	while($row=$logisticien->fetch()){
		$selectLog.='<option value="'.$row['id_user'].'">'.strtoupper($row['nom']).' '.$row['prenom'].'</option>';
	}
	$selectLog.='</select>';
	
	$html='<div id="gestAdminSite">';
	$html.='<h2>Nouvelle attribution ';
	switch($from){
		case 'arme':
			$select='<select class="form-control" name="objet" required><option></option>';
			while($row=$data->fetch()){
				$select.='<option value="'.$row['num_arme'].'">'.$row['num_arme'].' - '.$row['marque_arme'].'</option>';
			}
			$select.='</select>';
			$html.='d\'arme</h2>';
			break;
		case 'brassard':
			$select='<select class="form-control" name="objet" required><option></option>';
			while($row=$data->fetch()){
				$select.='<option value="'.$row['num_brassard'].'">'.$row['num_brassard'].'</option>';
			}
			$select.='</select>';
			$html.='de brassard</h2>';			
			break;
		case 'radio':
			$select='<select class="form-control" name="objet" required><option></option>';
			while($row=$data->fetch()){
				$select.='<option value="'.$row['num_TEI'].'">'.$row['num_TEI'].'</option>';
			}
			$select.='</select>';
			$html.='de radio</h2>';				
			break;
		case 'baton':
			$select='<select class="form-control" name="objet" required><option></option>';
			while($row=$data->fetch()){
				$select.='<option value="'.$row['num_baton'].'">'.$row['num_baton'].'</option>';
			}
			$select.='</select>';
			$html.='de b&acirc;ton</h2>';				
			break;			
	}
	$html.='<form method="POST" action="?component=logistique&action=addassoc&type='.$from.'"><table class="table">';
	$html.='<tr><th>Utilisateur :</th><td>'.$selectUser.'</td><th>'.ucfirst($from).' :</th><td>'.$select.'</td></tr><tr><th>Date :</th><td><input type="date" name="date"></td><th>En charge :</th><td>'.$selectLog.'</td></tr>';
	$html.='<tr><th colspan="2">Motif :</th><td colspan="2"><select class="form-control" name="motifA" required>';
	while($row=$motifs->fetch()){
		$html.='<option value="'.$row['cause'].'">'.$row['cause'].'</option>';
	}
	$html.='</select><br /><img src="./media/icons/more_icon.png" height="20px"  onclick="slide(\'slide1\');" title="Ajouter un motif"></td></tr>';
	$html.='<tr id="slide1"><td colspan="2"><input placeholder="Nouveau motif" type="text" id="newMotif"></td><td><input type="button" id="bAddAdmin" value="Enregistrer motif" onclick="recNewMotif(\''.$_GET['type'].'\',\'attrib\');"></td></tr>';
	$html.='<tr><td colspan="4"><input type="submit" value="Enregistrer" id="bAddAdmin"></td></tr></table></form>';
	$html.='</div>';
	$this->appli->content=$html;
}

public function FormRestitution($data){
	$date='<input type="date" name="dateRest" required />';
	$motifRest='<select name="motifRest" required><option></option><option value="Certificat m&eacute;dical">Certificat m&eacute;dical</option><option value="D&eacute;cision administrative">D&eacute;cision administrative</option><option value="D&eacute;cision judiciaire">D&eacute;cision judiciaire</option><option value="Retour maladie longue dur&eacute;e">Retour maladie longue dur&eacute;e</option><option value="D&eacute;cision SEMESOTRA">D&eacute;cision SEMESOTRA</option></select>';
	$html='<div id="gestAdminSite">';
	$html.='<h2>Restitution d';
	switch($data['type']){
		case 'arme':
			$html.='\'une arme</h2>';
			$html.='<form method="POST" action="?component=logistique&action=restituer&subAction=arme&idUser='.$data['idUser'].'&row='.$data['idRow'].'&num='.$data['num_arme'].'&record"><table name="restitution">';
			$html.='<tr><th>Nom</th><th>Pr&eacute;nom</th><th>Num. arme</th><th>Mod&egrave;le arme</th></tr>';
			$html.='<tr><td>'.$data['nom'].'</td><td>'.$data['prenom'].'</td><td>'.$data['num_arme'].'</td><td>'.$data['marque_arme'].'</td></tr>';
			$html.='<tr><th>Date retrait</th><th>Motif retrait</th><th>Date restitution</th><th>Motif restitution</th></tr>';
			$html.='<tr><td>'.$this->datefr($data['dateR']).'</td><td>'.$data['motifR'].'</td><td>'.$date.'</td><td>'.$motifRest.'</td></tr>';
			$html.='<tr><td colspan="4"><input type="submit" value="Enregistrer" id="bAddAdmin" /></td></tr>';
			$html.='</table></form>';
			break;
	}
	$html.='</div>';
	$this->appli->content=$html;
}

public function formAddMat($type){
	$html='<div id="gestAdminSite">';
	$html.='<h2>Ajout d';
	switch($type){
		case 'arme':
			$html.='\'une arme</h2>';
			$html.='<form method="POST" action="?component=logistique&action=addMat&type=arme&record" enctype="multipart/form-data"><table class="table">';
			$html.='<tr><th>Marque & mod&egrave;le</th><th>Num&eacute;ro</th><th>Calibre</th><th>Date de livraison</th></tr>';
			$html.='<tr><td><input placeholder="Marque & modèle"type="text" name="modArme" required></td><td><input placeholder="Numéro" type="text" name="numArme" required></td><td><select class="form-control" name="calibre" required><option></option><option value="9 mm">9 mm</option><option value="38 sp">38 sp</option></select></td><td><input type="date" name="dateAcquis" required></td></tr>';
			$html.='<tr><th>Type</th><td><select class="form-control" name="typeArme"><option></option><option value="I">Individuelle</option><option value="C">Collective</td><th>Joindre dossier d\'acquisition (pdf)</th><td><input class="btn btn-default" type="file" name="fileToUpload" id="fileToUpload" required></td></tr>';
			$cols='4';
			break;
		case 'brassard':
			$html.='\'un brassard</h2>';
			$html.='<form method="POST" action="?component=logistique&action=addMat&type=brassard&record" enctype="multipart/form-data"><table class="table">';
			$html.='<tr><th>Num&eacute;ro</th><th>Date de livraison</th></tr>';
			$html.='<tr><td><input placeholder="Numéro" type="text" name="numBrassard" required></td><td><input  type="date" name="dateAcquis" required></td></tr>';
			$html.='<tr><th>Joindre dossier d\'acquisition (pdf)</th><td><input class="btn btn-default" type="file" name="fileToUpload" id="fileToUpload" required></td></tr>';
			$cols='4';
			break;
		case 'radio':
			$html.='\'une radio</h2>';
			$html.='<form method="POST" action="?component=logistique&action=addMat&type=radio&record" enctype="multipart/form-data"><table class="table">';
			$html.='<tr><th>Marque & mod&egrave;le</th><th>Num&eacute;ro TEI</th><th>Num&eacute;ro ISSI</th><th>Date de livraison</th></tr>';
			$html.='<tr><td><input placeholder="Marque & modèle" type="text" name="modRadio" required></td><td><input placeholder="Numéro TEI" type="text" name="numTEI" required></td><td><input placeholder="Numéro ISSI" type="text" name="numISSI" required></td><td><input type="date" name="dateAcquis" required></td></tr>';
			$html.='<tr><th colspan="2">Joindre dossier d\'acquisition (pdf)</th><td colspan="2"><input class="btn btn-default" type="file" name="fileToUpload" id="fileToUpload" required></td></tr>';
			$cols='4';
			break;		
		case 'baton':
			$html.='\'un b&acirc;ton</h2>';
			$html.='<form method="POST" action="?component=logistique&action=addMat&type=baton&record" enctype="multipart/form-data"><table class="table">';
			$html.='<tr><th>Marque & mod&egrave;le</th><th>Num&eacute;ro</th><th>Date de livraison</th></tr>';
			$html.='<tr><td><input placeholder="Marque & modèle"type="text" name="modBaton" required></td><td><input placeholder="Numéro" type="text" name="numBaton" required></td><td><input type="date" name="dateAcquis" required></td></tr>';
			$html.='<tr><th colspan="2">Joindre dossier d\'acquisition (pdf)</th><td colspan="2"><input class="btn btn-default" type="file" name="fileToUpload" id="fileToUpload" required></td></tr>';
			$cols='4';
			break;
		case 'ETT':
			$html.='\'un ETT</h2>';
			$html.='<form method="POST" action="?component=logistique&action=addMat&type=ETT&record" enctype="multipart/form-data"><table class="table">';
			$html.='<tr><th>Marque</th><td><input placeholder="Marque" type="text" name="marque" required autofocus></td><th>Mod&egrave;le</th><td><input placeholder="Modèle" type="text" name="modele" required"></td></tr>';
			$html.='<tr><th>Num&eacute;ro</th><td><input placeholder="Numéro" type="text" name="numero" required"></td><th>Date de livraison</th><td><input type="date" name="dateAcquis" required></td></tr>';
			$html.='<tr><td colspan="2"></td><th>Date de validit&eacute</th><td><input type="date" name="dateVal" required></td></tr>';
			$html.='<tr><th colspan="2">Joindre dossier d\'acquisition (pdf)</th><td colspan="2"><input class="btn btn-default" type="file" name="fileToUpload" id="fileToUpload" required></td></tr>';
			$cols='4';
			break;
	}
	$html.='<tr><td colspan="'.$cols.'"><input type="submit" id="bAddAdmin" value="Enregistrer"></td></tr></table></form></div>';
	$this->appli->content=$html;
}

public function showFullInfos($data){
	$html='<div id="gestAdminSite">';
	switch($_GET['type']){
		case 'arme':
			$html.='<h2>Infos arme num&eacute;ro '.$data['arme']['num_arme'].'</h2>';
			$html.='<h3>Donn&eacute;es techniques</h3>';
			$html.='<table>';
			$html.='<tr><th>Num&eacute;ro de s&eacute;rie</th><td>'.$data['arme']['num_arme'].'</td><th>Mod&egrave;le</th><td>'.$data['arme']['marque_arme'].'</td><th>Calibre</th><td>'.$data['arme']['calibre'].'</td></tr>';
			$html.='<tr><th>Date de livraison</th><td title="L\'enregistrement se fait automatiquement au changement"><input name="newDateL" id="newDateL" type="date" value="'.$data['arme']['dateLivraison'].'"  onchange="updateDate(\'arme\',\''.$data['arme']['num_arme'].'\',\'livraison\');"></td><th>Validit&eacute; contr&ocirc;le armurier</th><td><input name="newDateC" id="newDateC" type="date" value="'.($data['arme']['validite_arme']).'" onchange="updateDate(\'arme\',\''.$data['arme']['num_arme'].'\',\'ctrlArmu\');"></td><th>Type d\'arme</th><td>';
			$html.=($data['arme']['type']=='I') ? 'Individuelle' : 'Collective';
			$html.='</td></tr>';
			$html.='</table>';
			$html.='<hr>';
			$html.='<h3>Utilisateur actuel</h3>';
			$html.='<table><tr><td>';
			$html.=(isset($data['arme']['nom'])) ? $data['arme']['nom'].' '.$data['arme']['prenom'] : 'Arme non attribu&eacute;e';
			$html.='</td></tr></table>';
			$html.='<hr>';
			$html.='<h3>Historique</h3>';
			$html.='<table>';
			for($i=0;$i<$data['histo']['rows'];$i++){
				$html.='<tr><th>Du</th><td>'.$this->datefr($data['histo'][$i]['dateA']).'<br />('.$data['histo'][$i]['motifA'].')</td><th>Au</th><td>';
				$html.=($data['histo'][$i]['dateR']!='0000-00-00') ? $this->datefr($data['histo'][$i]['dateR']).'<br />('.$data['histo'][$i]['motifR'].')' : 'En cours' ;
				$html.='</td><td>'.$data['histo'][$i]['nom'].' '.$data['histo'][$i]['prenom'].'</td></tr>';
				
			}
			$html.='</table>';
			$html.='<hr>';
			$html.='<h3>Documents li&eacute;s</h3>';
			$html.='<table>';
			if($data['histo']['rowsDocs']==0){
				$html.='<tr><th>Aucun document li&eacute;</th></tr>';
			}
			else {
				for($i=0;$i<$data['histo']['rowsDocs'];$i++){
					$html.='<tr><th>'.ucfirst($data['doc'][$i]['type_doc']).'</th><td><a href="./docroom/uploaded_files/armement/'.$data['doc'][$i]['nom_fichier'].'" target="_blank">Ouvrir</a></td></tr>';
				}				
			}
			$html.='</table>';
			$html.='<h3>Ajouter un document</h3>';
			$html.='<form name="formAddDoc" method="POST" action="?component=logistique&action=addDoc&type=arme&id='.$data['arme']['num_arme'].'" enctype="multipart/form-data"><table>';
			$html.='<tr><th>Nom document (pdf) : <br /><input type="text" name="name" required></th><td><input type="file" name="fileToUpload" id="fileToUpload" required></td></tr>';
			$html.='<tr><td colspan="2"><input type="submit" value="Enregistrer le document" id="bAddAdmin"></td></tr>';
			$html.='</table></form>';
			break;
		case 'brassard':
			$html.='<h2>Infos brassard num&eacute;ro '.$data['arme']['num_brassard'].'</h2>';
			$html.='<h3>Donn&eacute;es techniques</h3>';
			$html.='<table>';
			$html.='<tr><th>Num&eacute;ro de s&eacute;rie</th><td>'.$data['arme']['num_brassard'].'</td></tr>';
			$html.='<tr><th>Date de livraison</th><td title="L\'enregistrement se fait automatiquement au changement"><input name="newDateL" id="newDateL" type="date" value="'.$data['arme']['dateLivraison'].'"  onchange="updateDate(\'brassard\',\''.$data['arme']['num_brassard'].'\',\'livraison\');"></td></tr>';
			$html.='</table>';
			$html.='<hr>';
			$html.='<h3>Utilisateur actuel</h3>';
			$html.='<table><tr><td>';
			$html.=(isset($data['arme']['nom'])) ? $data['arme']['nom'].' '.$data['arme']['prenom'] : 'Brassard non attribu&eacute;';
			$html.='</td></tr></table>';
			$html.='<hr>';
			$html.='<h3>Historique</h3>';
			$html.='<table>';
			for($i=0;$i<$data['histo']['rows'];$i++){
				$html.='<tr><th>Du</th><td>'.$this->datefr($data['histo'][$i]['dateA']).'<br />('.$data['histo'][$i]['motifA'].')</td><th>Au</th><td>';
				$html.=($data['histo'][$i]['dateR']!='0000-00-00') ? $this->datefr($data['histo'][$i]['dateR']).'<br />('.$data['histo'][$i]['motifR'].')' : 'En cours' ;
				$html.='</td><td>'.$data['histo'][$i]['nom'].' '.$data['histo'][$i]['prenom'].'</td></tr>';
				
			}
			$html.='</table>';
			$html.='<hr>';
			$html.='<h3>Documents li&eacute;s</h3>';
			$html.='<table>';
			if($data['histo']['rowsDocs']==0){
				$html.='<tr><th>Aucun document li&eacute;</th></tr>';
			}
			else {
				for($i=0;$i<$data['histo']['rowsDocs'];$i++){
					$html.='<tr><th>'.ucfirst($data['doc'][$i]['type_doc']).'</th><td><a href="./docroom/uploaded_files/armement/'.$data['doc'][$i]['nom_fichier'].'" target="_blank">Ouvrir</a></td></tr>';
				}				
			}
			$html.='</table>';
			$html.='<h3>Ajouter un document</h3>';
			$html.='<form name="formAddDoc" method="POST" action="?component=logistique&action=addDoc&type=brassard&id='.$data['arme']['num_brassard'].'" enctype="multipart/form-data"><table>';
			$html.='<tr><th>Nom document (pdf) : <br /><input type="text" name="name" required></th><td><input type="file" name="fileToUpload" id="fileToUpload" required></td></tr>';
			$html.='<tr><td colspan="2"><input type="submit" value="Enregistrer le document" id="bAddAdmin"></td></tr>';
			$html.='</table></form>';			
			break;
	
		case 'radio':
			$html.='<h2>Infos radio num&eacute;ro '.$data['arme']['num_TEI'].'</h2>';
			$html.='<h3>Donn&eacute;es techniques</h3>';
			$html.='<table>';
			$html.='<tr><th>Num&eacute;ro TEI</th><td>'.$data['arme']['num_TEI'].'</td><th>Num&eacutero ISSI</th><td>'.$data['arme']['num_ISSI'].'</td></tr><tr><th>Mod&egrave;le</th><td>'.$data['arme']['marque_radio'].'</td><th>Date de livraison</th><td title="L\'enregistrement se fait automatiquement au changement"><input name="newDateL" id="newDateL" type="date" value="'.$data['arme']['dateLivraison'].'"  onchange="updateDate(\'radio\',\''.$data['arme']['num_TEI'].'\',\'livraison\');"></td></tr>';
			$html.='</table>';
			$html.='<hr>';
			$html.='<h3>Utilisateur actuel</h3>';
			$html.='<table><tr><td>';
			$html.=(isset($data['arme']['nom'])) ? $data['arme']['nom'].' '.$data['arme']['prenom'] : 'Radio non attribu&eacute;e';
			$html.='</td></tr></table>';
			$html.='<hr>';
			$html.='<h3>Historique</h3>';
			$html.='<table>';
			for($i=0;$i<$data['histo']['rows'];$i++){
				$html.='<tr><th>Du</th><td>'.$this->datefr($data['histo'][$i]['dateA']).'<br />('.$data['histo'][$i]['motifA'].')</td><th>Au</th><td>';
				$html.=($data['histo'][$i]['dateR']!='0000-00-00') ? $this->datefr($data['histo'][$i]['dateR']).'<br />('.$data['histo'][$i]['motifR'].')' : 'En cours' ;
				$html.='</td><td>'.$data['histo'][$i]['nom'].' '.$data['histo'][$i]['prenom'].'</td></tr>';
				
			}
			$html.='</table>';
			$html.='<hr>';
			$html.='<h3>Documents li&eacute;s</h3>';
			$html.='<table>';
			if($data['histo']['rowsDocs']==0){
				$html.='<tr><th>Aucun document li&eacute;</th></tr>';
			}
			else {
				for($i=0;$i<$data['histo']['rowsDocs'];$i++){
					$html.='<tr><th>'.ucfirst($data['doc'][$i]['type_doc']).'</th><td><a href="./docroom/uploaded_files/armement/'.$data['doc'][$i]['nom_fichier'].'" target="_blank">Ouvrir</a></td></tr>';
				}				
			}
			$html.='</table>';
			$html.='<h3>Ajouter un document</h3>';
			$html.='<form name="formAddDoc" method="POST" action="?component=logistique&action=addDoc&type=radio&id='.$data['arme']['num_TEI'].'" enctype="multipart/form-data"><table>';
			$html.='<tr><th>Nom document (pdf) : <br /><input type="text" name="name" required></th><td><input type="file" name="fileToUpload" id="fileToUpload" required></td></tr>';
			$html.='<tr><td colspan="2"><input type="submit" value="Enregistrer le document" id="bAddAdmin"></td></tr>';
			$html.='</table></form>';
			break;	

		case 'baton':
			$html.='<h2>Infos b&acirc;ton num&eacute;ro '.$data['arme']['num_baton'].'</h2>';
			$html.='<h3>Donn&eacute;es techniques</h3>';
			$html.='<table>';
			$html.='<tr><th>Num&eacute;ro</th><td>'.$data['arme']['num_baton'].'</td></tr><tr><th>Marque</th><td>'.$data['arme']['marque_baton'].'</td><th>Date de livraison</th><td title="L\'enregistrement se fait automatiquement au changement"><input name="newDateL" id="newDateL" type="date" value="'.$data['arme']['dateLivraison'].'"  onchange="updateDate(\'baton\',\''.$data['arme']['num_baton'].'\',\'livraison\');"></td></tr>';
			$html.='</table>';
			$html.='<hr>';
			$html.='<h3>Utilisateur actuel</h3>';
			$html.='<table><tr><td>';
			$html.=(isset($data['arme']['nom'])) ? $data['arme']['nom'].' '.$data['arme']['prenom'] : 'B&acirc;ton non attribu&eacute;';
			$html.='</td></tr></table>';
			$html.='<hr>';
			$html.='<h3>Historique</h3>';
			$html.='<table>';
			for($i=0;$i<$data['histo']['rows'];$i++){
				$html.='<tr><th>Du</th><td>'.$this->datefr($data['histo'][$i]['dateA']).'<br />('.$data['histo'][$i]['motifA'].')</td><th>Au</th><td>';
				$html.=($data['histo'][$i]['dateR']!='0000-00-00') ? $this->datefr($data['histo'][$i]['dateR']).'<br />('.$data['histo'][$i]['motifR'].')' : 'En cours' ;
				$html.='</td><td>'.$data['histo'][$i]['nom'].' '.$data['histo'][$i]['prenom'].'</td></tr>';
				
			}
			$html.='</table>';
			$html.='<hr>';
			$html.='<h3>Documents li&eacute;s</h3>';
			$html.='<table>';
			if($data['histo']['rowsDocs']==0){
				$html.='<tr><th>Aucun document li&eacute;</th></tr>';
			}
			else {
				for($i=0;$i<$data['histo']['rowsDocs'];$i++){
					$html.='<tr><th>'.ucfirst($data['doc'][$i]['type_doc']).'</th><td><a href="./docroom/uploaded_files/armement/'.$data['doc'][$i]['nom_fichier'].'" target="_blank">Ouvrir</a></td></tr>';
				}				
			}
			$html.='</table>';
			$html.='<h3>Ajouter un document</h3>';
			$html.='<form name="formAddDoc" method="POST" action="?component=logistique&action=addDoc&type=baton&id='.$data['arme']['num_baton'].'" enctype="multipart/form-data"><table>';
			$html.='<tr><th>Nom document (pdf) : <br /><input type="text" name="name" required></th><td><input type="file" name="fileToUpload" id="fileToUpload" required></td></tr>';
			$html.='<tr><td colspan="2"><input type="submit" value="Enregistrer le document" id="bAddAdmin"></td></tr>';
			$html.='</table></form>';
			break;
			
		case 'ETT':
			$html.='<h2>Infos ETT num&eacute;ro '.$data['id'].'</h2>';
			$html.='<h3>Donn&eacute;es techniques</h3>';
			$html.='<table>';
			$html.='<tr><th>Num&eacute;ro</th><td>'.$data['id'].'</td><th>Marque</th><td title="L\'enregistrement se fait automatiquement au changement"><input type="text" name="marque" id=marque value="'.$data['marque'].'" onkeyup="updateField(\'ETT\',\'marque\',\''.$data['id'].'\');"></td></tr><tr><th>Mod&egrave;le</th><td title="L\'enregistrement se fait automatiquement au changement"><input type="text" name="modele" id="modele" value="'.$data['modele'].'" onkeyup="updateField(\'ETT\',\'modele\',\''.$data['id'].'\');"></td><th>Date de livraison</th><td title="L\'enregistrement se fait automatiquement au changement"><input name="newDateL" id="newDateL" type="date" value="'.$data['dateL'].'"  onchange="updateDate(\'ETT_L\',\''.$data['id'].'\',\'livraison\');"></td></tr>';
			$html.='</table>';
			$html.='<hr>';
			$html.='<h3>Documents li&eacute;s</h3>';
			$html.='<table>';
			if($data['nbDocs']==0){
				$html.='<tr><th>Aucun document li&eacute;</th></tr>';
			}
			else {
				for($i=0;$i<$data['nbDocs'];$i++){
					$html.='<tr><th>'.ucfirst($data[$i]['type_doc']).'</th><td><a href="./docroom/uploaded_files/armement/'.$data[$i]['nom_fichier'].'" target="_blank">Ouvrir</a></td></tr>';
				}				
			}
			$html.='</table>';
			$html.='<hr>';
			$html.='<h3>Ajouter un document</h3>';
			$html.='<form name="formAddDoc" method="POST" action="?component=logistique&action=addDoc&type=ETT&id='.$data['id'].'" enctype="multipart/form-data"><table>';
			$html.='<tr><th>Nom document (pdf) : <br /><input type="text" name="name" required></th><td><input type="file" name="fileToUpload" id="fileToUpload" required></td></tr>';
			$html.='<tr><td colspan="2"><input type="submit" value="Enregistrer le document" id="bAddAdmin"></td></tr>';
			$html.='</table></form>';			
			break;
	}
	$html.='</div>';
	$this->appli->content=$html;
}

public function gestETT($data){
	$now=date('y-m-d');
	$html='<div id="gestAdminSite">';
	$html.='<h2>Gestion des ETT</h2>';
	$html.='<table class="table">';
	$html.='<tr><th style="cursor:pointer;" onclick="document.location.href=\'?component=logistique&action=gestETTs&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='numASC'))? 'numDESC' : 'numASC';
	$html.='\'">Num&eacute;ro de s&eacute;rie</th><th style="cursor:pointer;" onclick="document.location.href=\'?component=logistique&action=gestETTs&tri=';
	$html.=((isset($_GET['tri']))&&($_GET['tri']=='validiteASC'))? 'validiteDESC' : 'validiteASC';
	$html.='\'">Date de validit&eacute;</th></tr>';
	while($row=$data->fetch()){
		$html.='<tr><td style="cursor:pointer;" onclick="document.location.href=\'?component=logistique&action=details&type=ETT&id='.$row['id_ETT'].'\'">'.$row['id_ETT'].'</td><td';
		if(strtotime($now)>strtotime($row['date_validite'])){
			$html.=' bgcolor="#ff6666">';
		}
		else if(strtotime((date('Y-m-d',strtotime('+1 month')))) > strtotime($row['date_validite'])){
			$html.=' bgcolor="#ffc266">';
		}
		else $html.=' bgcolor="#66FF99">';
		$html.='<input type="date" id="newDate'.$row['id_ETT'].'" value="'.$row['date_validite'].'" onchange=updateDate(\'ETT_V\',\''.$row['id_ETT'].'\',\'validite\'); title="Enregistrement automatique"></td></tr>';
	}
	$html.='<tr><td colspan="2"><a href="?component=logistique&action=addMat&type=ETT"><input type="button" id="bAddAdmin" value="Ajouter un ETT"></a></td></tr>';
	$html.='</table>';
	$html.='</div>';
	$this->appli->content=$html;
}

public function gestArticles($articles,$categories,$mesures,$fournisseurs,$matos){

	$html='<div id="gestAdminSite">';
	$html.='<h2>Gestion du petit mat&eacute;riel de bureau</h2>';
	$html.='<ul style="list-style: none;" id="adminModules">';
	$html.='<li style="list-style: none;" onclick="slide(\'slide1\',\'0\');">Mat&eacute;riel</li><li onclick="slide(\'slide2\',\'0\');">Cat&eacute;gories</li><li onclick="slide(\'slide3\',\'0\');">Mesures</li><li onclick="slide(\'slide4\',\'0\');">Fournisseurs</li>';
	/*$html.='<div id="slide1"><h3>Mat&eacute;riel</h3>';  //Modifs @Clem//
		$html.='
			<table class="table">

			<tr><td>Type de matériel <select class="form-control" name="matos" id="matos">
			<option value="" selected></option>';
			$i=0;
			while($row=$matos->fetch()){

              		$html.='<option value='.$row['id_materiels'].'> '.$row['den_matos'].'</option>';
        					
       						
       						$i++;
       				}
       		$html.='</select></td></tr>

       		<tr><td>categories <select class="form-control" name="categ" id="categ">
       		<option value="" selected></option>';
      		 $i=0;
       		while($row=$categories->fetch()){

       		$html.='<option value ='.$row['id_categorie'].'>'.$row['denomination'].'</option>';
       		$i++;
      		 }

       		$html.='</select></td><tr>

       		<tr><td>Mesures <select class="form-control" name="mesure" id="mesure">
       		<option value="" selected></option>';
       		$i=0;
      		 while($row=$mesures->fetch()){

       		$html.='<option value ='.$row['id_uMesure'].'>'.$row['denomination'].'</option>';
       		$i++;
      		 }

       		$html.='</select></td></tr>

       		<tr><td>Fournisseurs <select class="form-control" name="fournisseurs" id="fournisseurs">
       		<option value="" selected></option>';
      		 $i=0;
       		while($row=$fournisseurs->fetch()){

       		$html.='<option value ='.$row['id_fournisseur'].'>'.$row['nom'].'</option>';
       		$i++;
      		 }
      		$html.='</select></td></tr>
      		<tr><td><input type="button" value="Enregistrer" name="bAddMatos" id="bAddMatos" onclick="addMatos"></td><tr>
      		<tr><td><input type="button" value="Ajouter un matériel" name="addMateriel" id="bAddMateriel" onclick="addMateriel"></td></tr>
      		<tr><td><input type="text" name="newMatos" id="newMatos" placeholder="Matériel"></td>
      		<td><input type="button" value="Enregistrer" name="newMatos" id="newMatos" onclick="newMatos"></td></tr>';
			$html.=	'</table></div>';*/
	//END MODIFS @CLem

	$html.='<div id="slide1"><h3>Mat&eacute;riel</h3></div>';
	$html.='<div id="slide2"';
	$html.=((isset($_GET['visible']))&&($_GET['visible']=='categ')) ? ' style="display:block";' : '';
	$html.='><h3>Cat&eacute;gories</h3>';
	$html.='<input type="button" id="bAddCateg" value="Ajouter" onclick="slide2(\'addCateg\');">';
	$html.='<div id="addCateg" style="display:none;"><table class="table"><tr><td style="width:68%;"><input placeholder="D&eacute;nomination nouvelle cat&eacute;gorie" type="text" name="denNewCateg" id="denNewCateg"></td><td style="width:32%;"><input type="button" value="Enregistrer" id="bAdd" onclick="addCategArt();"></td><td id="confirmSpaceAddArt"></td></tr></table><hr></div>';
	$i=0;
	$html.='<table class="table">';
	while($row=$categories->fetch()){
		$html.='<tr><th>D&eacute;nomination cat&eacute;gorie :</th><td id="idCateg'.$row['id_categorie'].'">'.ucfirst($row['denomination']).'</td><td id="bModifCateg'.$row['id_categorie'].'"><input type="button" value="Modifier" onclick="modifField(\'Categ\',\'idCateg'.$row['id_categorie'].'\',\''.$row['id_categorie'].'\',\''.ucfirst($row['denomination']).'\');" id="bEdit"></td><td><input type="button" value="Supprimer" id="bSupp" onclick="delCategArt(\''.$row['id_categorie'].'\',\''.$row['denomination'].'\');"></td></tr>';
		$i++;
	}
	$html.='</table>';
	$html.=($i==0) ? '<h4>Aucune cat&eacute;gorie n\'est encod&eacute;e</h4>' : '';
	$html.='<div id="msgSlide2" style="display=none;"></div>';
	$html.='</div>';
	
	$html.='<div id="slide3"';
	$html.=((isset($_GET['visible']))&&($_GET['visible']=='mesures')) ? ' style="display:block";' : '';
	$html.='><h3>Unit&eacute;s de mesure</h3>';
	$html.='<input type="button" id="bAddUM" value="Ajouter" onclick="slide2(\'addUMesure\');">';
	$html.='<div id="addUMesure" style="display:none;"><table class="table"><tr><td style="width:68%;"><input placeholder="D&eacute;nomination nouvelle unité de mesure" type="text" name="denNewUMesure" id="denNewUMesure"></td><td style="width:32%;"><input type="button" value="Enregistrer" id="bAddUM" onclick="addNewUMesure();"></td><td id="confirmSpaceAddUMesure"></td></tr></table><hr></div>';
	$i=0;
	$html.='<table class="table">';
	while($row=$mesures->fetch()){
		$html.='<tr><th>D&eacute;nomination mesure :</th><td id="idMesure'.$row['id_uMesure'].'">'.ucfirst($row['denomination']).'</td><td id="bModifMesure'.$row['id_uMesure'].'"><input type="button" value="Modifier" onclick="modifField(\'Mesure\',\'idMesure'.$row['id_uMesure'].'\',\''.$row['id_uMesure'].'\',\''.ucfirst($row['denomination']).'\');" id="bEdit"></td><td><input type="button" value="Supprimer" id="bSupp" onclick="delUMesure(\''.$row['id_uMesure'].'\',\''.$row['denomination'].'\');"></td></tr>';
		$i++;
	}
	$html.='</table>';
	$html.=($i==0) ? '<h4>Aucune unit&eacute; de mesure n\'est encod&eacute;e</h4>' : '';
	$html.='<div id="msgSlide3" style="display=none;"></div>';	
	$html.='</div>';
	
	$html.='<div id="slide4"';
	$html.=((isset($_GET['visible']))&&($_GET['visible']=='fournisseurs')) ? ' style="display:block";' : '';
	$html.='><h3>Fournisseurs</h3>';
	$html.='<input type="button" id="bAddFourn" value="Ajouter" onclick="slide2(\'addFournisseur\');">';
	$html.='<div id="addFournisseur" style="display:none;"><table class="table">';
	$html.='<tr><td style="width:50%;"><input placeholder="Nom fournisseur" type="text" name="denNewFourn" id="denNewFourn" autofocus ></td><td style="width:50%;" colspan="2"><input type="text" placeholder="Num&eacute;ro d\'entreprise" name="numEntr" id="numEntr">';
	$html.='<tr><td style="width:50%;"><input placeholder="Description" type="text" name="descFourn" id="descFourn"></td><td style="width:30%;"><input type="text" placeholder="Rue" name="rueFourn" id="rueFourn"><td style="width:20%"><input type="text" placeholder="Num&eacute;ro" name="numRueFourn" id="numRueFourn"></td></tr> 

		<tr><td><input type="text" placeholder="Ville" name="villeFourn" id="villeFourn"></td> 
		<td><input type="text" placeholder="Code postal" name="cpFourn" id="cpFourn"></td>
		<td><input type="text" placeholder="Pays" name="paysFourn" id="paysFourn"></td></tr>

		<tr><td><input type="text" placeholder="Mail" name="mailFourn" id="mailFourn"></td>
		<td><input type="text" placeholder="T&eacute;l&eacute;phone" name="telFourn" id="telFourn"></td>
		<td><input type="email" placeholder="Fax" name="faxFourn" id="faxFourn"></td></tr>';


	$html.='<tr><td colspan="3"><input type="button" value="Enregistrer" id="bAddFourn" onclick="addNewFourn();"></td><td id="confirmSpaceAddUMesure"></td></tr></table><hr></div>';
	$i=0;
	$html.='<table class="table">';
	while($row=$fournisseurs->fetch()){
		$html.='<tr id="trModifFournisseur'.$row['id_fournisseur'].'"><th>Nom fournisseur :</th><td id="idFournisseur'.$row['id_fournisseur'].'">'.ucfirst($row['nom']).'</td><td>'.$row['ville'].'</td><td id="bModifFournisseur'.$row['id_fournisseur'].'"><input type="button" value="Modifier" onclick="modifField(\'Fournisseur\',\'idFournisseur'.$row['id_fournisseur'].'\',\''.$row['id_fournisseur'].'\',\''.ucfirst($row['nom']).'\');" id="bEdit"></td><td><input type="button" value="Supprimer" id="bSupp" onclick="delFournisseur(\''.$row['id_fournisseur'].'\',\''.$row['nom'].'\');"></td></tr>';
		$i++;
	}
	$html.='</table>';
	$html.=($i==0) ? '<h4>Aucun fournisseur n\'est encod&eacute;</h4>' : '';
	$html.='<div id="msgSlide4" style="display=none;"></div>';	
	$html.='</div>';
	
	$html.='</div>';
	$this->appli->content=$html; 
}
}
?>