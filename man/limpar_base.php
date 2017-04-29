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


	case "limpar_base_relacao":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Limpar base...</h1><br />";
	$hoje = date('Y-m-d H:i:s');

	$sql_del = "DELETE FROM acervo_relacao_termo WHERE idReg = 0 OR idTermo = 0";
	$query_del = mysqli_query($con,$sql_del);
	if($query_del){
		echo "Base acervo_relacao_termo limpa";
	}else{
		echo "Erro ao limpar Base acervo_relacao_termo";
	}

	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Limpeza de base executada em $tempo segundos";
	
	break;









case "inicio":
?>
<h1>Importação dos termos para a base</h1>

<a href="?action=limpar_base_relacao">Limpar base relação termos</a><br />
<br />




<?php 
break;

} ?>
