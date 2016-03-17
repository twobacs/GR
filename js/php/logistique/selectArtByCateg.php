<?php

if(isset($_GET['id'])){
	include ('../connect.php');
	include('../../../class/articles.class.php');
	$art=new Articles($pdo);
	$articles=$art->getArticlesByIdCateg($_GET['id']);
	$categories=$art->getCategories();
	$html='<hr><h4>Modification d\'articles avant suppression cat&eacute;gorie</h4>';
	$html.='<table><td><input type="button" value="Fermer ce menu" onclick="slide2(\'msgSlide2\');"></td></table>';
	$html.='<table>';
	$html.='<tr><th>Article</th><th>Commentaire</th><th>Cat&eacute;gorie actuelle</th><th colspan="2" style="width:25%;">Nouvelle cat&eacute;gorie</th></tr>';
	while($row=$articles->fetch()){
		$html.='<tr><td>'.ucfirst($row['denomination']).'</td><td>'.ucfirst($row['commentaire']).'</td><td>'.ucfirst($row['categorie']).'</td><td><select name="newCateg" id="newCategArt_'.$row['id_article'].'" onchange="updateCategByIdArt(\''.$row['id_article'].'\');"><option></option>';
		while($rowCat=$categories->fetch()){
			if($rowCat['id_categorie']!=$_GET['id']){
				$html.='<option value="'.$rowCat['id_categorie'].'">'.ucfirst($rowCat['denomination']).'</option>';
			}
		}
		$html.='</select></td><td id="confirmSpace_'.$row['id_article'].'"></td></tr>';
	}
	$html.='</table>';
	echo $html;
}
?>