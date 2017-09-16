<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Sprays{
private $pdo;

public function __construct($dbPdo){
	$this->pdo=$dbPdo;
}

public function getAllSprays($tri=''){    
	$sql='SELECT id_spray, date_exp, serial, statut FROM z_sprays';
	if($tri!=''){
		switch ($_GET['tri']){
			case 'serASC':
				$sql.=' ORDER BY serial ASC';
				break;
			case 'serDESC':
				$sql.=' ORDER BY serial DESC';
				break;
			case 'validiteASC':
				$sql.=' ORDER BY date_exp ASC';
				break;
			case 'validiteDESC':
				$sql.=' ORDER BY date_exp DESC';
				break;
		}
	}
	return $this->pdo->query($sql);
}
}