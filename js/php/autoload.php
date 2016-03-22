<?php

$pdo = new PDO('mysql:host=localhost;dbname=','','');
-include('../../../class/armes.class.php');
-include('../../../class/articles.class.php');
-include('../../../class/articles.class.php');
-include('../../../class/batons.class.php');
-include('../../../class/brassards.class.php');
-include('../../../class/ett.class.php');
-include('../../../class/fournisseurs.class.php');
-include('../../../class/grades.class.php');
-include('../../../class/nivacces.class.php');
-include('../../../class/pers_contact.class.php');
-include('../../../class/services.class.php');
-include('../../../class/users.class.php');

function htmltosql($text)
	{
	$rep=htmlentities($text,ENT_QUOTES, "UTF-8");
	return $rep;
	}
	
function dateHrfr($date,$dateonly=0) 
	{
    $split = explode(" ",$date);
    $jour = $split[0];
	$heure = $split[1];
	
	$split2 = explode("-",$jour);	
	$annee = $split2[0];
    $mois = $split2[1];
    $jour = $split2[2];
	if ($dateonly==0)
		{
		return $jour."-".$mois."-".$annee." &agrave; ".$heure;
		}
	if ($dateonly==1)
		{
		return $jour."-".$mois."-".$annee;
		}
	}
	
function stripAccents($str) {
    return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}

function splitDateTime($date)
	{
	$split=explode("T",$date);
	$jour=$split[0];
	$heure=$split[1];
	return $jour.' '.$heure;
	}
	
function getDateFromDateTime($date)
	{
	$split=explode(" ",$date);
	$jour=$split[0];
	return $jour;
	}

?>
