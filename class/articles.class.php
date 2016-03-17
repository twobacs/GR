<?php

class Articles{
private $pdo;
public $id_article;
public $id_categorie;
public $denomination;
public $id_fournisseur;
public $stock;
public $commentaire;
public $id_mesure;
public $prix_achat;
public $q_min;

public function __construct($dbPdo){
	$this->pdo=$dbPdo;
}

function htmltosql($text)
	{
	$rep=htmlentities($text,ENT_QUOTES, "UTF-8");
	return $rep;
	}

public function getInfosArticles($id=0){
	$i=0;
	$sql='SELECT
	a.id_article, a.id_categorie, a.denomination, a.id_fournisseur, a.stock, a.commentaire, a.id_mesure, a.prix_achat, a.q_min,
	b.denomination AS denCateg,
	c.id_fournisseur, c.nom AS nomFourn,
	d.denomination AS uMesure
	FROM articles a
	LEFT JOIN categories_articles b ON b.id_categorie=a.id_categorie
	LEFT JOIN fournisseurs c ON c.id_fournisseur=a.id_fournisseur
	LEFT JOIN unite_mesure d ON d.id_uMesure = a.id_mesure
	WHERE id_article=:id';
	$req=$this->pdo->prepare($sql);
	$req->execute(array('id'=>($id!=0) ? $id : '"*"'));
	while($row=$req->fetch()){
		$data[$i]['id_article']=$row['id_article'];
		$data[$i]['id_categorie']=$row['id_categorie'];
		$data[$i]['denomination']=$row['denomination'];
		$data[$i]['id_fournisseur']=$row['id_fournisseur'];
		$data[$i]['stock']=$row['stock'];
		$data[$i]['commentaire']=$row['commentaire'];
		$data[$i]['id_mesure']=$row['id_mesure'];
		$data[$i]['prix_achat']=$row['prix_achat'];
		$data[$i]['q_min']=$row['q_min'];
		$data[$i]['denCateg']=$row['denCateg'];
		$data[$i]['id_fournisseur']=$row['id_fournisseur'];
		$data[$i]['nomFourn']=$row['nomFourn'];
		$data[$i]['uMesure']=$row['uMesure'];
		$j=0;
		$sqlDocs='SELECT id_doc, nom_doc, nom_fichier FROM documents_articles WHERE id_article=:idArt';
		$reqDocs=$this->pdo->prepare($sqlDocs);
		$reqDocs->execute(array('idArt'=>$data[$i]['id_article']));
		while($rowDocs=$reqDocs->fetch()){
			$data[$i][$j]['id_doc']=$rowDocs['id_doc'];
			$data[$i][$j]['nom_doc']=$rowDocs['nom_doc'];
			$data[$i][$j]['nom_fichier_doc']=$rowDocs['nom_fichier'];
			$j++;
		}
		$data[$i]['nbDocs']=$j;
		$j=0;
		$sqlPhotos='SELECT id_photo, nom_fichier FROM photos_articles WHERE id_article=:idArt';
		$reqPhotos=$this->pdo->prepare($sql);
		$reqPhotos->execute(array('idArt'=>$data[$i]['id_article']));
		while($row=$reqPhotos->fetch()){
			$data[$i][$j]['id_photo']=$reqPhotos['id_photo'];
			$data[$i][$j]['nom_fichier_photo']=$reqPhotos['nom_ficher'];
			$j++;
		}
		$i++;
	}
}

public function getCategories(){
	$sql='SELECT id_categorie, denomination FROM categories_articles ORDER BY denomination';
	return $this->pdo->query($sql);
}

public function getArticlesByIdCateg($idCateg){
	$sql='SELECT a.id_article, a.denomination, a.id_fournisseur, a.stock, a.commentaire, a.id_mesure, a.prix_achat, a.q_min,
	b.nom, b.num_entreprise, b.description,
	c.denomination AS mesure,
	d.denomination AS categorie
	FROM articles a
	LEFT JOIN fournisseurs b ON b.id_fournisseur=a.id_fournisseur
	LEFT JOIN unite_mesure c ON c.id_uMesure=a.id_mesure
	LEFT JOIN categories_articles d ON d.id_categorie=a.id_categorie
	WHERE a.id_categorie=:idCateg
	ORDER BY a.denomination';
	$req=$this->pdo->prepare($sql);
	$req->execute(array('idCateg'=>$idCateg));
	return $req;
}

public function getArticlesByIdMesure($idMesure){
	$sql='SELECT a.id_article, a.denomination, a.id_fournisseur, a.stock, a.commentaire, a.id_mesure, a.prix_achat, a.q_min,
	b.nom, b.num_entreprise, b.description,
	c.denomination AS mesure,
	d.denomination AS categorie
	FROM articles a
	LEFT JOIN fournisseurs b ON b.id_fournisseur=a.id_fournisseur
	LEFT JOIN unite_mesure c ON c.id_uMesure=a.id_mesure
	LEFT JOIN categories_articles d ON d.id_categorie=a.id_categorie
	WHERE a.id_mesure=:idMesure
	ORDER BY a.denomination';
	$req=$this->pdo->prepare($sql);
	$req->execute(array('idMesure'=>$idMesure));
	return $req;
}

public function addCateg($newCateg){
	$sql='INSERT INTO categories_articles (denomination) VALUES (:newCateg)';
	$req=$this->pdo->prepare($sql);
	$req->execute(array('newCateg'=>$this->htmltosql($newCateg)));
}

public function addUMesure($newUMesure){
	$sql='INSERT INTO unite_mesure (denomination) VALUES (:newUMesure)';
	$req=$this->pdo->prepare($sql);
	$req->execute(array('newUMesure'=>$this->htmltosql($newUMesure)));
}

public function getMesures(){
	$sql='SELECT id_uMesure, denomination FROM unite_mesure ORDER BY denomination';
	return $this->pdo->query($sql);
}

public function desactFourn($id){
	
	$req=$this->pdo->exec('UPDATE fournisseurs SET actif="N" WHERE id_fournisseur="'.$id.'"');


}
public function modifFourn($tab){
	$req=$this->pdo->prepare('UPDATE fournisseurs SET (nom) WHERE (:nom)');
	$req->bindParam(':nom',$tab['nom'],PDO::PARAM_STR);

	$req->execute();
}

public function matos(){
	$sql=('SELECT id_materiels,den_matos FROM materiel');
	return $this->pdo->query($sql);
}
}
?>