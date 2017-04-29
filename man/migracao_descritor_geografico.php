<?php
//Exibe erros PHP
@ini_set('display_errors', '1');
error_reporting(E_ALL); 
require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php";

$con = bancoMysqli();
set_time_limit(0);
$teste = "";

if(isset($_GET['action'])){
	$action = $_GET['action'];
}else{
	$action = "inicio";
}




switch($action){

	/////////// Autoridades
	case "insere":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando os registros...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT idDisco, desc_geo FROM temp_acervo_discoteca $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$idDisco = $x['idDisco'];
		$desc_geo = $x['desc_geo'];
		$idReg = idReg($x['idDisco'],87);
		$idTermo = recuperaIdTermo($x['desc_geo'],119);
		if(trim($desc_geo) != "" AND $desc_geo != NULL){
			$sql_insert = "INSERT INTO acervo_relacao_termo (idReg,idTermo,idTipo,publicado) 
			VALUES ( '$idReg','$idTermo','119','1')";
			$query_insert = mysqli_query($con,$sql_insert);
			if($query_insert){
				echo "<p>Termo $desc_geo associado ao registro $idReg;</p>";
			}else{
				echo "<p>Erro ao associar termo $desc_geo ao registro $idReg</p>";
				
			}
		}
			
		
	}

	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	
	break;

	/////////// Autoridades
	case "insere_fora":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Importando registros</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT desc_geo FROM `temp_acervo_discoteca` WHERE desc_geo NOT IN(SELECT Termo FROM temp_descritor_geografico)";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$registro = $x['desc_geo'];
		$sql_insert = "INSERT INTO acervo_termo (termo, tipo, id_usuario, data_update, publicado)
		VALUES ('$registro','119','1','$hoje','1')";
		$query_insert = mysqli_query($con,$sql_insert);
		if($query_insert){
			echo "<p>Termo $registro inserido com sucesso";
		}else{
			echo "<p>Erro ao inserir termo $registro.</p>";	
		}				
	}
	
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	
	break;








case "inicio":
?>
<h1>Importação dos termos para a base</h1>

<a href="?action=insere">Insere Descritor Geográfico</a><br />
<br />
<a href="?action=insere_fora">Insere Descritor Geográfico da tabela temp_acervo_discoteca</a><br />
<br />



<?php 
break;

} ?>
