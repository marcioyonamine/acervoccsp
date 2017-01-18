<?php
//Exibe erros PHP
@ini_set('display_errors', '1');
error_reporting(E_ALL); 
require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php";
$con = bancoMysqli();

/*

migração de tipos
tipo_geral
tipo_especifico




*/
// funcao que cria relacionamentos entre tabelas
function relacionaTabela($tabela01, $tabela02, $campo,$descricao){
	$con = bancoMysqli();
	$sql = "SELECT DISTINCT $campo FROM $tabela01";
	$query = mysqli_query($con,$sql);
	
	//tipo da primeira tabela
	while($tipo = mysqli_fetch_array($query)){
		$x = $tipo[$campo];
		//faz uma pesquisa na tabela disco_tipo
		$sql_existe = "SELECT tipo FROM disco_tipo WHERE tipo = '$x'";
		$query_existe = mysqli_query($con,$sql_existe);
		$num_existe = mysqli_num_rows($query_existe);
		// se não existir, insere.
		if($num_existe == 0){
			$sql_insere = "INSERT INTO `disco_tipo` (`idTipo`, `tipo`, `descricao`, `abreviatura`) VALUES (NULL, '$x', '', '$descricao')";
			$query_insere = mysqli_query($con,$sql_insere);
			if($query_insere){
				echo "$x inserido na tabela disco_tipo.<br />";
			}else{
				echo "Erro ao inserir $x (1)<br />";
			}
		}

	}
	
	//cria relacionamento na segunda tabela
	$sql_sel = "SELECT idTipo,tipo FROM disco_tipo WHERE abreviatura = '$descricao'";
	$query_sel = mysqli_query($con,$sql_sel);
	while($atualiza = mysqli_fetch_array($query_sel)){
		$id = $atualiza['idTipo'];
		$x = $atualiza['tipo'];
	
		$sql_relaciona = "UPDATE $tabela02 SET $campo = $id WHERE $campo = '$x'";
		$query_relaciona = mysqli_query($con,$sql_relaciona);
		if($query_relaciona){
			echo "Campo $campo atualizado na tabela $tabela02 <br />";
		}else{
			echo "Erro(2)<br />";	
		}
	}
	
	
}

relacionaTabela("acervo","acervo_novo",$_GET['a'],$_GET['b']);




?>

