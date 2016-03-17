<?php

class CLogistique extends CBase {

    public function __construct($appli) {
        parent::__construct($appli);
    }

public function getNivAcces(){
	if(isset($_SESSION['idUser'])){
		$niv=$this->model->nivAcces();
		echo $niv;
	}
	else $this->view->unconnected();
}	

public function home(){
	if(isset($_SESSION['idUser'])){
		$niv=$this->model->nivAcces();
		$this->view->accueil($niv);
	}
	else $this->view->unconnected();
}

public function gestUsers(){
	if((isset($_SESSION['idUser']))&&($_SESSION['appli']=='logistique')&&($_SESSION['acces']=='10')){
		if((!isset($_GET['error']))||($_GET['error']=='0')){
			$droits=$this->model->getDroitsLog();
			$users=$this->model->getUsers();
			$this->view->gestDroits($droits,$users);
		}
		else $this->view->errorRec(2,'gestUsers');
	}
	else $this->view->error();	
}

public function gestArmes(){
	if((isset($_SESSION['idUser']))&&($_SESSION['appli']=='logistique')&&($_SESSION['acces']>='8')){
		$armes=$this->model->getArmes();
		$users=$this->model->getUsers();
		$userarme=$this->model->getUserArme();
		$histoarme=$this->model->getHistoArmes('arme');
		$histouser=$this->model->getHistoArmes('user');
		$this->view->gestArmes($armes,$users,$userarme,$histoarme,$histouser);
	}
	else if(!isset($_SESSION['idUser'])){
		$this->view->unconnected();
	}
	else $this->view->error();
}

public function gestBrassards(){
	if((isset($_SESSION['idUser']))&&($_SESSION['appli']=='logistique')&&($_SESSION['acces']>='8')){
		$brassards=$this->model->getBrassards();
		$users=$this->model->getUsers();
		$userbrassard=$this->model->getUserBrassard();
		$histobrassard=$this->model->getHistoBrassards('brassard');
		$histouser=$this->model->getHistoBrassards('user');
		$this->view->gestBrassards($brassards,$users,$userbrassard,$histobrassard,$histouser);
	}
	else if(!isset($_SESSION['idUser'])){
		$this->view->unconnected();
	}
	else $this->view->error();
}

public function gestRadios(){
	if((isset($_SESSION['idUser']))&&($_SESSION['appli']=='logistique')&&($_SESSION['acces']>='8')){
		$radios=$this->model->getRadios();
		$users=$this->model->getUsers();
		$userradio=$this->model->getUserRadio();
		$historadio=$this->model->getHistoRadios('radio');
		$histouser=$this->model->getHistoRadios('user');
		$this->view->gestRadios($radios,$users,$userradio,$historadio,$histouser);
	}
	else if(!isset($_SESSION['idUser'])){
		$this->view->unconnected();
	}
	else $this->view->error();
}

public function gestBatons(){
	if((isset($_SESSION['idUser']))&&($_SESSION['appli']=='logistique')&&($_SESSION['acces']>='8')){
		$batons=$this->model->getBatons();
		$users=$this->model->getUsers();
		$userbaton=$this->model->getUserBatons();
		$histobaton=$this->model->getHistoBatons('radio');
		$histouser=$this->model->getHistoBatons('user');
		$this->view->gestBatons($batons,$users,$userbaton,$histobaton,$histouser);
	}
	else if(!isset($_SESSION['idUser'])){
		$this->view->unconnected();
	}
	else $this->view->error();
}

public function retour(){
	if((isset($_SESSION['idUser']))&&($_SESSION['appli']=='logistique')&&($_SESSION['acces']>='8')){
		if(!isset($_POST['motif'])){
			$data=$this->model->getInfosRetrait();
			$motifs=$this->model->getMotifs('retrait');
			$this->view->motifRetrait($_GET['subAction'],$data,$motifs);
		}
		else{
			$this->model->retrait();
			header('Location: ?component=logistique&action=gest'.ucfirst($_GET['subAction']).'s&visible=attrib&retrait');
		}
	}
	else $this->view->error();	
}

public function assoc(){
	if((isset($_SESSION['idUser']))&&($_SESSION['appli']=='logistique')&&($_SESSION['acces']>='8')){
		$data=$this->model->getInfosMatos();
		$users=$this->model->getUsersNonEq();
		$logisticien=$this->model->getLogisticiens();
		$motifs=$this->model->getMotifs('attrib');
		$this->view->menuAdd($_GET['type'],$data,$users,$logisticien,$motifs);
	}
	else if(!isset($_SESSION['idUser'])){
		$this->view->unconnected();
	}
	else $this->view->error();	
}

public function addassoc(){
	if((isset($_SESSION['idUser']))&&($_SESSION['appli']=='logistique')&&($_SESSION['acces']>='8')){
		$this->model->attribMat();
		header('Location: ?component=logistique&action=gest'.ucfirst($_GET['type']).'s&visible=attrib&ajout');
	}
	else if(!isset($_SESSION['idUser'])){
		$this->view->unconnected();
	}
	else $this->view->error();		
}

public function restituer(){
	if((isset($_SESSION['idUser']))&&($_SESSION['appli']=='logistique')&&($_SESSION['acces']>='8')){
		if(isset($_GET['record'])){
			$this->model->restitution();
			switch($_GET['subAction']){
				case 'arme':
				header('location: ?component=logistique&action=gestArmes&visible=attrib');
				break;
			}
		}
		else{
			$data=$this->model->getInfoMatByUser();
			$this->view->FormRestitution($data);
		}
	}
	else if(!isset($_SESSION['idUser'])){
	$this->view->unconnected();
	}
	else $this->view->error();	
}

public function addMat(){
	if((isset($_SESSION['idUser']))&&($_SESSION['appli']=='logistique')&&($_SESSION['acces']>='8')){
		if(isset($_GET['record'])){
			$error=$this->model->addMat();
			if($error==1){
				$this->view->errorRec(3,'addMat');
			}
			else{
				header('location: ?component=logistique&action=gest'.ucfirst($_GET['type']).'s&visible='.$_GET['type'].'s');
				}
		}
		else{
			$this->view->formAddMat($_GET['type']);
		}
	}
	else if(!isset($_SESSION['idUser'])){
	$this->view->unconnected();
	}
	else $this->view->error();	
}

public function details(){
	if((isset($_SESSION['idUser']))&&($_SESSION['appli']=='logistique')&&($_SESSION['acces']>='8')){
		$data=$this->model->getFullInfos();
		$this->view->showFullInfos($data);
	}
	else if(!isset($_SESSION['idUser'])){
	$this->view->unconnected();
	}
	else $this->view->error();		
}

public function addDoc(){
	if((isset($_SESSION['idUser']))&&($_SESSION['appli']=='logistique')&&($_SESSION['acces']>='8')){
		$this->model->addDoc();
				header('location: ?component=logistique&action=details&visible='.$_GET['type'].'s&type='.$_GET['type'].'&id='.$_GET['id'].'');	
	}
	else if(!isset($_SESSION['idUser'])){
	$this->view->unconnected();
	}
	else $this->view->error();		
}

public function gestETTs(){
	if((isset($_SESSION['idUser']))&&($_SESSION['appli']=='logistique')&&($_SESSION['acces']>='8')){
		$data=$this->model->getETT();
		$this->view->gestETT($data);
	}
}

public function gestPMB(){
	if((isset($_SESSION['idUser']))&&($_SESSION['appli']=='logistique')&&($_SESSION['acces']>='8')){
		$articles=$this->model->getArticles();
		$categories=$this->model->getCategories();
		$mesures=$this->model->getMesures();
		$fournisseurs=$this->model->getFournisseurs();
		$matos=$this->model->matos();
		$this->view->gestArticles($articles,$categories,$mesures,$fournisseurs,$matos);
	}
}

}
?>