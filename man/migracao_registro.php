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
	case "registros":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando os registros...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT idDisco, titulo_disco FROM acervo_discoteca $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$idDisco = $x['idDisco'];
		$titulo = $x['titulo_disco'];
		$sql_update = "INSERT INTO `acervo`.`acervo_registro` 
		(`titulo`, `id_acervo`, `id_tabela`, `publicado`, `tabela`, `data_catalogacao`, `idUsuario`) 
		VALUES ('$titulo', '6', '$idDisco', '1', '87', '$hoje', '1');";
		$query_update = mysqli_query($con,$sql_update);
		if($query_update){
			echo "Registro $titulo inserido. (1) <br />";	
		}else{
			echo "Erro ao inserir $titulo (2) <br />";
			
		}
	}
	/*
	echo "<h1>Importando os demais termos...</h1>";
	
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT Termo FROM `acervo_autoridades` $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['Termo']);
		$sql_busca = "SELECT * FROM acervo_termo WHERE termo LIKE '$gravadora' AND tipo = '1'";
		$query_busca = mysqli_query($con,$sql_busca);
		$num_busca = mysqli_num_rows($query_busca);

		if($num_busca == 0){
			$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
			VALUES ('$gravadora', '', '1', '', 'Base antiga', '1', '$hoje', '1')";
			$query_update = mysqli_query($con,$sql_update);
			if($query_update){
				echo "Autoridade $gravadora inserido. (3) <br />";	
			}else{
				echo "Erro ao importar $gravadora (4) <br /> ";
			}
	
		}
	}
	echo "<h1>Atualizando os termos preteridos</h1>";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT Termo,Adotar FROM acervo_autoridades $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$termo = $x['Termo'];
		$adotar = $x['Adotar'];
		if($termo != $adotar){
			$adotar = addslashes($x['Adotar']);
			$sql_busca = "SELECT id_termo FROM acervo_termo WHERE termo LIKE '$adotar' AND tipo ='1'";
			$query_busca = mysqli_query($con,$sql_busca);
			$y = mysqli_fetch_array($query_busca);
			$id = $y['id_termo'];
			$sql_atualiza = "UPDATE acervo_termo SET adotado = '$id' WHERE termo LIKE '$termo'";
			$query_atualiza = mysqli_query($con,$sql_atualiza);
			if($query_atualiza){
				echo "Autoridade $termo adota o termo $adotar(5)<br />";	
			}else{
				echo "Erro ao atualizar o termo $termo / $adotar(6)<br />";	
			}
		}	
	
	
	}*/
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	
break;









case "inicio":
?>
<h1>Importação dos termos para a base</h1>

<a href="?action=registros">Criar registros</a><br />
<br />




<?php 
break;

} ?>
