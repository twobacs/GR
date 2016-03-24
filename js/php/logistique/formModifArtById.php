<?php

if(isset($_GET['idArt'])){
	include('../autoload.php');
	$id=$_GET['idArt'];
	$article=new Articles($pdo);
	$art=$article->getInfosArticles($_GET['idArt']);
	$categs=$article->getCategories();
	$mesu=$article->getMesures();
	$f=new Fournisseurs($pdo);
	$fourn=$f->getFournisseurs();
	$html='<hr>';

	$html.='
	<form class="form-inline">
	  <div class="form-group">
		<label class="sr-only" for="newDenomArt'.$id.'">D&eacute;nomination</label>
		<div class="input-group">
		  <div class="input-group-addon" style="width:120px">D&eacute;nomination</div>
		  <input style="width:200px;" type="text" class="form-control" id="newDenomArt'.$id.'" placeholder="D&eacute;nomination" value="'.$art[0]['denomination'].'">
		</div>
		<div class="input-group">
		  <label class="sr-only" for="newCategArt'.$id.'">Cat&eacute;gorie</label>
		  <div class="input-group-addon" style="width:120px">Cat&eacute;gorie</div>
		  <select style="width:200px;" class="form-control" id="newCategArt'.$id.'" name="newCategArt'.$i.'"><option disabled></option>';
			while($row=$categs->fetch()){
				$html.='<option value="'.$row['id_categorie'].'"';
				$html.=($row['id_categorie']==$art[0]['id_categorie']) ? ' selected' : '';
				$html.='>'.ucfirst($row['denomination']).'</option>';
			}		  
		  $html.='</select>
		</div>
	  </div><br />
	  <div class="form-group">
		<label class="sr-only" for="newStockArt'.$id.'">Stock</label>
		<div class="input-group">
		  <div class="input-group-addon" style="width:120px">Stock actuel</div>
		  <input style="width:200px;" type="text" class="form-control" id="newStockArt'.$id.'" placeholder="Stock" value="'.$art[0]['stock'].'">
		 
		</div>		
		<label class="sr-only" for="newUMesureArt'.$id.'">Unit&eacute; mesure</label>
		<div class="input-group">
			<div class="input-group-addon" style="width:120px">Unit&eacute; mesure</div>
		<select style="width:200px;" class="form-control" id="newUMesureArt'.$id.'" name="newUMesureArt'.$id.'"><option disabled></option>';
			while($row=$mesu->fetch()){
				$html.='<option value="'.$row['id_uMesure'].'"';
				$html.=($row['id_uMesure']==$art[0]['id_mesure']) ? ' selected' : '';
				$html.='>'.ucfirst($row['denomination']).'</option>';
			}			
		$html.='</select>
	  </div><br />
	 <div class="form-group">
		<label class="sr-only" for="newComArt'.$id.'">Commentaire</label>
		<div class="input-group">
		  <div class="input-group-addon" style="width:120px">Commentaire</div>
		  <input style="width:200px;" type="text" class="form-control" id="newComArt'.$id.'" placeholder="Commentaire" value="'.$art[0]['commentaire'].'">
		</div>		
		<label class="sr-only" for="newFournArt'.$id.'">Fournisseur</label>
		<div class="input-group">
			<div class="input-group-addon" style="width:120px">Fournisseur</div>
		<select style="width:200px;" class="form-control" id="newFournArt'.$id.'" name="newFournArt'.$id.'"><option disabled></option>';
			while($row=$fourn->fetch()){
				$html.='<option value="'.$row['id_fournisseur'].'"';
				$html.=($row['id_fournisseur']==$art[0]['id_fournisseur']) ? ' selected' : '';
				$html.='>'.ucfirst($row['nom']).'</option>';
			}			
		$html.='</select>
	 </div><br />
	 <div class="form-group">
		<label class="sr-only" for="newQMinArt'.$id.'">Quantit&eacute, min.</label>
		<div class="input-group">
			<div class="input-group-addon"" style="width:120px">Stock mini</div>
			<input type="text" style="width:200px" class="form-control" id="newQminArt'.$id.'" placeHolder:"Quantit&eacute; minimale" value="'.$art[0]['q_min'].'">
		</div>
		<label class="sr-only" for="newPaArt'.$id.'">Prix d\'achat</label>
		<div class="input-group">
			<div class="input-group-addon" style="width:120px">Prix d\'achat</div>
			<input type="text" style="width:167px" class="form-control" id="newPaArt'.$id.'" name="newPaArt'.$id.'" placeholder="Prix d\'achat" value="'.$art[0]['prix_achat' ].'">
			<dic class="input-group-addon" style="width:20px">€</div>
		</div>
	 </div><br />
	 <div class="form-group">
	 <div class="input-group">
	 <button style="width:646px" type="submit" class="btn btn-primary">Enregistrer les modifications</button>
	 </div>
	 </div>
	</form>';
	echo $html;
	
}

?>