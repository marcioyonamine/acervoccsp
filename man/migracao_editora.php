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

	/////// Editoras
	case "editoras":
	
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Importando os termos adotados para editoras...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	
	$sql = "SELECT DISTINCT Adotar FROM temp_editoras $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['Adotar']);
		
		$sql_pesquisa = "SELECT termo FROM acervo_termo WHERE termo = '$gravadora' AND tipo = '100'";
		$query_pesquisa = mysqli_query($con,$sql_pesquisa);
		$num_pesquisa = mysqli_num_rows($query_pesquisa);
		if($num_pesquisa == 0){
			$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
			VALUES ('$gravadora', '', '100', '', 'Base antiga', '1', '$hoje', '1')";
			$query_update = mysqli_query($con,$sql_update);
			if($query_update){
				echo "Gravadora $gravadora inserida. (1) <br />";	
			}else{
				echo "Erro ao importar $gravadora (2) <br />";
			
			}
		}
	}

	$sql = "SELECT DISTINCT Termo FROM temp_editoras $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['Termo']);
		
		$sql_pesquisa = "SELECT termo FROM acervo_termo WHERE termo = '$gravadora' AND tipo = '100'";
		$query_pesquisa = mysqli_query($con,$sql_pesquisa);
		$num_pesquisa = mysqli_num_rows($query_pesquisa);
		if($num_pesquisa == 0){
			$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
			VALUES ('$gravadora', '', '100', '', 'Base antiga', '1', '$hoje', '1')";
			$query_update = mysqli_query($con,$sql_update);
			if($query_update){
				echo "Gravadora $gravadora inserida. (1) <br />";	
			}else{
				echo "Erro ao importar $gravadora (2) <br />";
			
			}
		}
	}
	
	
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	
	break;

	// Atualiza as editoras das partituras
	case "editoras_base":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Importando os termos adotados para editoras...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	
	
	
	
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	break;




case "inicio":
?>
<h1>Importação dos termos para a base</h1>

<a href="?action=editoras">Importar as editoras para a tabela "termos"</a><br />
<br />

<a href="?action=editoras_base">Atualizar as editoras nas partituras"</a><br />
<br />


<?php 
break;

} ?>
