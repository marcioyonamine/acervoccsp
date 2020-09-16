<?php
//include para Coleção de Artes da Cidade



if(isset($_GET['p'])){
	$p = $_GET['p'];	
}else{
	$p = "index";
	}
include "m_man/".$p.".php";
?>