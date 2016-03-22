function slide(part,other){
	var display=($('#'+part).css('display'));
	if(display=='block'){
		$('#'+part).hide(1200);
	}
	else{
		if(typeof(other) == 'undefined'){
			$('#'+part).slideToggle(500);
		}
		else{
			$('#slide1').hide(500);
			$('#slide2').hide(500);
			$('#slide3').hide(500);
			$('#slide4').hide(500);
			$('#'+part).slideToggle(500);
			
			$('#addUMesure').hide(500);
			$('#addCateg').hide(500);
			$('#addFournisseur').hide(500);
			document.getElementById('bAddCateg').value='Ajouter';
			document.getElementById('bAddUM').value='Ajouter';
			document.getElementById('bAddFourn').value='Ajouter';
			
		}
	}	
}

function slide2(part,other){
	var display=($('#'+part).css('display'));
	if(display=='block'){
		$('#'+part).hide(1200);
		document.getElementById('bAddCateg').value='Ajouter';
		document.getElementById('bAddUM').value='Ajouter';
		document.getElementById('bAddFourn').value='Ajouter';
	}
	else{
		if(typeof(other) == 'undefined'){
			$('#'+part).slideToggle(500);
			document.getElementById('bAddCateg').value='Fermer ce menu';
			document.getElementById('bAddUM').value='Fermer ce menu';
			document.getElementById('bAddFourn').value='Fermer ce menu';
		}
	}
}

function searchUser(type){
	var element = document.getElementById("resultSearch");
	var entry = document.getElementById(type).value;
	$.ajax(
			{
			type: "GET",
			url: "js/php/users/searchUser.php",
			data:
				{
				type : type,
				entry : entry,
				},
			success:function(retour){element.innerHTML = retour;},
			});	

}

function resetMDP(id){
	var ok=confirm('Etes-vous certain de vouloir faire ça ?');
	if(ok){
		$.ajax(
			{
			type: "GET",
			url: "js/php/users/resetMDP.php",
			data:
				{
				id : id,
				},
			success : function(){alert('Mot de passe réinitialisé (azerty)');},
			});
	}
	else{
		alert('Action annulée');
	}
}
function autocompleteRRN(){
	var RRN = document.getElementById('rrn').value;
	if(RRN.length!=11){
		var naissance=document.getElementById('naissance').value;
		var a=naissance.substr(2, 2);
		var m=naissance.substr(5, 2);
		var j=naissance.substr(8, 2);
		document.getElementById('rrn').value=a+m+j;
	}
}
function verifMat(){
	var matricule=document.getElementById('matricule').value;
	var controle = matricule.substr(7, 2);
	var enTete = matricule.substr(0, 7);
	if(controle!=(enTete % 97)){document.getElementById('tdMat').style.backgroundColor = 'red';document.getElementById('matricule').value='';}
	else{document.getElementById('tdMat').style.backgroundColor = 'green';}
}

function verifRRN(){
	var RRN=document.getElementById('rrn').value;
	var naissance=document.getElementById('naissance').value;
	var annee = naissance.substr(0, 4);	
	if(annee<2000){
		var enTete = RRN.substr(0, 9);		
	}
	else{
		var enTete = '2'+(RRN.substr(0, 9));
	}
	var controle = RRN.substr(9, 2);
	if(controle!=(97-(enTete % 97))){document.getElementById('tdRRN').style.backgroundColor = 'red'; var error='Erreur ! Le numéro national ne semble pas correct.';}
	else{document.getElementById('tdRRN').style.backgroundColor = 'green';}
	var a=naissance.substr(2, 2);
	var m=naissance.substr(5, 2);
	var j=naissance.substr(8, 2);
	var ar=RRN.substr(0, 2);
	var mr=RRN.substr(2, 2);
	var jr=RRN.substr(4, 2);
	if((a!=ar)||(m!=mr)||(j!=jr)){
		var error='Erreur ! Les 6 premiers chiffres doivent correspondre à la date de naissance inversée.';
	}
	if(RRN.length!=11){
		var error='Erreur ! Le numéro national doit comporter 11 chiffres.';
	}
	if(error){
		alert(error);
	}
}

function verifLogin(){
	var login=document.getElementById('login').value;
	$.ajax({
		type:"GET",
		url:"js/php/users/verifLogin.php",
		data:{
			login:login,
		},
		success : function(retour){
			if(retour=='1'){
				alert('Erreur ! Cette valeur est déjà utilisée.');
				document.getElementById('login').value='';
			}
		},
	});
}

function recNewMotif(objet,motif){
	var cause=document.getElementById('newMotif').value;
	var i;
	var tab = document.getElementsByName('dispo');
	for (i=0;i<tab.length;i++)
		{
			if(tab[i].checked)
			{
				var dispo = tab[i].value;
				break;
			}
		}
	$.ajax({
		type:"GET",
		url:"js/php/logistique/addMotif.php",
		data:{
			objet:objet,
			motif:motif,
			cause:cause,
			dispo:dispo,
		},
		success : function(){
			alert('Valeur ajoutée');
			window.location.reload();
		},
	});
}

function updateField(objet,field,id){
	var value=document.getElementById(field).value;
	$.ajax({
		type:"GET",
		url:"js/php/updateField.php",
		data:{
			objet:objet,
			field:field,
			id:id,
			value:value,
		},
		// success:function(html){alert(html);},
	});	
}

function modifField(source,field,id,valeur){
	switch(source){
		case 'Categ':
			var elem='denCategArticle';
			break;
		case 'Mesure':
			var elem='denUMesure';
			break;
        case 'Fournisseur':
            var elem='denFournisseur';
			break;
			
	}
	if(source==='Fournisseur'){
		document.getElementById('bModifFournisseur'+id).innerHTML='<input type="button" value="Modifications en cours" style="cursor:not-allowed">';
		$.ajax({
			type:"GET",
			url:"js/php/logistique/formModifFournById.php",
			data:{
				idFourn:id,
			},
			success:function(retour){document.getElementById('msgSlide4').innerHTML=retour;}
		});
		// document.getElementById('msgSlide4').innerHTML='coucou';
	}
	else{
		document.getElementById(field).innerHTML='<input type="text" id="new'+field+'" value="'+valeur+'" autofocus>';
		document.getElementById('bModif'+source+id).innerHTML='<input type="button" value="Enregistrer" onclick="recModifField(\''+elem+'\',\'new'+field+'\',\''+id+'\');" id="bEnregistrer">';
	}
}

function recModifField(objet,field,id){
	switch(objet){
		case 'denCategArticle':
			var ok=confirm('Ceci changera la dénomination pour tous les objets de cette catégorie.  Voulez-vous continuer ?');
			var bouton='Categ';
			var td='idCateg';
			break;
		case 'denUMesure':
			var ok=confirm('Ceci changera l\'unité de mesure pour tous les objets l\'ayant.  Voulez-vous continuer ?');
			var bouton='Mesure';
			var td='idMesure';
			break;
		case 'denFournisseur':
			var ok=confirm('Ceci changera le fournisseur pour tous les objets s\'y référant.  Voulez-vous continuer ?');
			var bouton='Fournisseur';
			var td='idFournisseur';
			break;
	}
	if(ok){
		var value=document.getElementById(field).value;
		$.ajax({
			type:"GET",
			url:"js/php/updateField.php",
			data:{
				objet:objet,
				field:field,
				id:id,
				value:value,
			},
			success:function(html){
				document.getElementById(td+id).innerHTML=html;
				document.getElementById('bModif'+bouton+id).innerHTML='<input type="button" value="Enregistrement Ok" style="cursor:not-allowed;">';
			},
		});
	}
}

function delCategArt(id, denom){
	var ok=confirm('Voulez-vous supprimer cette catégorie d\'articles ? ('+denom+')');
	if (ok){
		$.ajax({
			type:"GET",
			url:"js/php/logistique/delCategArt.php",
		data:{
			id:id,
		},
		success:function(retour){
			if(retour==0){
				window.location.href="?component=logistique&action=gestPMB&visible=categ";
			}
			else{
				$.ajax({
					type:"GET",
					url:"js/php/logistique/selectArtByCateg.php",
					data:{
						id:id,
					},
					success:function(retour){
						alert('Des articles sont encore liés à cette catégorie, veuillez apporter les modifications préalables.');
						document.getElementById('msgSlide2').innerHTML=retour;
						var display=($('#msgSlide2').css('display'));
							if(display=='none'){
							$('#msgSlide2').slideToggle(500);
						}
					},
				});
			}
			},
		});
	}
}

function delUMesure(id, denom){
	var ok=confirm('Voulez-vous supprimer cette unité de mesure ? ('+denom+')');
	if (ok){
		$.ajax({
			type:"GET",
			url:"js/php/logistique/delUMesure.php",
		data:{
			id:id,
		},
		success:function(retour){
			if(retour==0){
				window.location.href="?component=logistique&action=gestPMB&visible=categ";
			}
			else{
				$.ajax({
					type:"GET",
					url:"js/php/logistique/selectArtByUMesure.php",
					data:{
						id:id,
					},
					success:function(retour){
						alert('Des articles sont encore liés à cette catégorie, veuillez apporter les modifications préalables.');
						document.getElementById('msgSlide3').innerHTML=retour;
						var display=($('#msgSlide3').css('display'));
							if(display=='none'){
							$('#msgSlide3').slideToggle(500);
						}
					},
				});
			}
			},
		});
	}
}

function updateCategByIdArt(idArt){
	var newCateg=(document.getElementById('newCategArt_'+idArt).value);
	$.ajax({
		type:"GET",
		url:"js/php/logistique/updateCategByIdArt.php",
		data:{
			idArt:idArt,
			idCateg:newCateg,
		},
		success:function(){document.getElementById('confirmSpace_'+idArt).innerHTML="<img src=\"./media/icons/valid.gif\">";}
	});
}

function updateUMesureByIdArt(idArt){
	var newUmesure=(document.getElementById('newUmesure_'+idArt).value);
	$.ajax({
		type:"GET",
		url:"js/php/logistique/updateUMesureByIdArt.php",
		data:{
			idArt:idArt,
			idMesure:newUmesure,
		},
		success:function(){document.getElementById('confirmSpace_'+idArt).innerHTML="<img src=\"./media/icons/valid.gif\">";}
	});
}

function addCategArt(){
	var newCateg=document.getElementById('denNewCateg').value;
	if(newCateg!=''){
		$.ajax({
			type:"GET",
			url:"js/php/logistique/addCategArt.php",
			data:{
				newCateg:newCateg,
			},
			success:function(){document.getElementById('confirmSpaceAddArt').innerHTML="<img src=\"./media/icons/wait.gif\" height=\"20\">";
			setTimeout(function(){
				window.location.href="?component=logistique&action=gestPMB&visible=categ";
			},
			2000);
			},
			
		});
	}	
	else{
		document.getElementById('confirmSpaceAddArt').innerHTML="<img src=\"./media/icons/delete.gif\">";
	}
}

function addNewUMesure(){
	var newMesure=document.getElementById('denNewUMesure').value;
	if(newMesure!=''){
		$.ajax({
			type:"GET",
			url:"js/php/logistique/addNewMesure.php",
			data:{
				newMesure:newMesure,
			},
			success:function(){document.getElementById('confirmSpaceAddUMesure').innerHTML="<img src=\"./media/icons/wait2.gif\" height=\"20\">";
			setTimeout(function(){
				window.location.href="?component=logistique&action=gestPMB&visible=mesures";
			},
			2000);
			},
			
		});
	}	
	else{
		document.getElementById('confirmSpaceAddArt').innerHTML="<img src=\"./media/icons/delete.gif\">";
	}
}


function showPic(){
	document.getElementById('pop_picture').innerHTML="<img src=\"./media/icons/more_icon.png\">";
	slidePop();
}

function slidePop(){
	$('#pop_picture').slideToggle(200);
}
// onmouseover="showPic();" onmouseout="hidePic();"
function hidePic(){
	// document.getElementById('pop_picture').innerHTML="";
	$('#pop_picture').hide(200);
}

function addNewFourn(){
	var denNewFourn=document.getElementById('denNewFourn').value;
	var numEntr=document.getElementById('numEntr').value;
	var descFourn=document.getElementById('descFourn').value;
	var rueFourn=document.getElementById('rueFourn').value;
	var numRueFourn=document.getElementById('numRueFourn').value;
	var cpFourn=document.getElementById('cpFourn').value;
	var villeFourn=document.getElementById('villeFourn').value;
	var paysFourn=document.getElementById('paysFourn').value;
	var telFourn=document.getElementById('telFourn').value;
	var faxFourn=document.getElementById('faxFourn').value;
	var mailFourn=document.getElementById('mailFourn').value;

	
	if((denNewFourn!='')){
		document.getElementById('main').style.cursor="wait";
		$.ajax({
			type:"GET",
			url:"js/php/logistique/addNewFourn.php",
			data:{
				denNewFourn:denNewFourn,
				numEntr:numEntr,
				descFourn:descFourn,
				rueFourn:rueFourn,
				numRueFourn:numRueFourn,
				cpFourn:cpFourn,
				villeFourn:villeFourn,
				paysFourn:paysFourn,
				telFourn:telFourn,
				faxFourn:faxFourn,
				mailFourn:mailFourn,
			},
			// success:function(retour){alert(retour);},
			success:setTimeout(function(){
				window.location.href="?component=logistique&action=gestPMB&visible=fournisseurs";
			},
			2000),

		});

	}
	else{
		alert('Les champs obligatoires ne sont pas remplis');
	}

	
}

function delFournisseur(id,nom){

	var ok = confirm('Voulez-vous supprimer '+nom+' ?');
	if(ok){
		document.getElementById('main').style.cursor="wait";
		$.ajax({
			type:"GET",
			url:"js/php/logistique/desactFourn.php",
			data:{
				id:id,
				

			},
			success:setTimeout(function(){
				window.location.href="?component=logistique&action=gestPMB&visible=fournisseurs";
				document.getElementById('main').style.cursor="wait";				
			},
			2000),

		});

	}
	else{
		window.location.href="?component=logistique&action=gestPMB&visible=fournisseurs";
	}
}

function updateFourn(id){
	var denNewFourn=document.getElementById('newNomFourn'+id).value;
	var numEntr=document.getElementById('newNumEntreprise'+id).value;
	var descFourn=document.getElementById('newDescFourn'+id).value;
	var rueFourn=document.getElementById('newRueFourn'+id).value;
	var numRueFourn=document.getElementById('newNumFourn'+id).value;
	var cpFourn=document.getElementById('newCPFourn'+id).value;
	var villeFourn=document.getElementById('newVilleFourn'+id).value;
	var paysFourn=document.getElementById('newPaysFourn'+id).value;
	var telFourn=document.getElementById('newTelFourn'+id).value;
	var faxFourn=document.getElementById('newFaxFourn'+id).value;
	var mailFourn=document.getElementById('newMailFourn'+id).value;
	if((denNewFourn!='')){
		document.getElementById('main').style.cursor="wait";
		$.ajax({
			type:"GET",
			url:"js/php/logistique/UpdateFourn.php",
			data:{
				idFourn:id,
				denNewFourn:denNewFourn,
				numEntr:numEntr,
				descFourn:descFourn,
				rueFourn:rueFourn,
				numRueFourn:numRueFourn,
				cpFourn:cpFourn,
				villeFourn:villeFourn,
				paysFourn:paysFourn,
				telFourn:telFourn,
				faxFourn:faxFourn,
				mailFourn:mailFourn,
			},
			success:setTimeout(function(){
				window.location.href="?component=logistique&action=gestPMB&visible=fournisseurs";
			},
			2000),
			// success:function(retour){alert(retour);},

		});

	}
	else{
		alert('Veuillez compléter au moins le nom du fournisseur !');
	}	
}

function deleteArtById(idArt,denomArt){
	var ok = confirm('Etes-vous sûr de vouloir supprimer cet article ? ('+denomArt+')');
	if(ok){
		document.getElementById('main').style.cursor="wait";
		$.ajax({
			type:"GET",
			url:"js/php/logistique/delArticleById.php",
			data:{
				idArt:idArt,
			},
			success:function(retour){
				if(retour==0){
					alert('Une erreur s\'est produite');
					document.getElementById('main').style.cursor="default";
				}
				else{
					setTimeout(function(){window.location.href="?component=logistique&action=gestPMB&visible=articles"},2000);
				}
				},
			
		});
	}
}

function modifArtById(id,denom){
	var ok = confirm ('Etes-vous sûr de vouloir modifier cet article ? ('+denom+')');
	var tableInit=document.getElementById('tableArt'+id).innerHTML;
	$.ajax({
		type:"GET",
		url:"js/php/logistique/formModifArtById.php",
		data:{
			idArt:id,
		},
		success:function(retour){
			alert(retour);
			// document.getElementById('formModifArt'+id).innerHTML=tableInit;
		}
	});
	document.getElementById('tableArt'+id).innerHTML=tableInit;
}