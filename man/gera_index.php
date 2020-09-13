<?php
//Exibe erros PHP
@ini_set('display_errors', '1');
error_reporting(E_ALL); 
require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php";

$con = bancoMysqli();
set_time_limit(0);
if(isset($_GET['teste'])){
	$teste = " LIMIT 0,100";
	
}else{
	$teste = "";
}


//$teste = "";

if(isset($_GET['action'])){
	$action = $_GET['action'];
}else{
	$action = "inicio";
}




switch($action){

	/////////// partitura
	case "partitura":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando index...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql_delete = "DELETE FROM `acervo_busca` WHERE colecao = 'Partitura' ";
	$query = mysqli_query($con,$sql_delete);
	
	
	$sql = "SELECT id_registro, titulo, id_tabela FROM acervo_registro WHERE tabela = '97' AND publicado = '1' $teste";
	$query = mysqli_query($con,$sql);
	
	
	
	while($x = mysqli_fetch_array($query)){
		$id_registro = $x['id_registro'];
		$titulo = $x['titulo'];
		$autoridades = retornaAutoridades($x['id_registro']);
		$autores = $autoridades['string'];
		$as = retornaTermos($id_registro);
		$assunto = $as['string'];
		$id_tabela = $x['id_tabela'];
		
		$sql_conteudo = "SELECT conteudo FROM acervo_partituras WHERE idDisco = '$id_tabela'";
		$query_conteudo = mysqli_query($con,$sql_conteudo);
		$c = mysqli_fetch_array($query_conteudo);
		$conteudo = $c['conteudo'];
		$conteudo = str_replace("CONTEÚDO:", "", $string); 
		$conteudo = str_replace("--", "", $string); 		
		
		
		$indexado = $titulo." ".$autores." ".$assunto." ".$conteudo;
		$sql_insert = "INSERT INTO `acervo_busca` (`id`, `id_registro`, `titulo`, `autor`, `assunto`, `colecao`, `indexado`, `matriz_analitica`) VALUES (NULL, '$id_registro', '$titulo', '$autores', '$assunto','Partitura' , '$indexado',  '')";
		$insere = mysqli_query($con,$sql_insert);
		if($insere){
			echo "$titulo inserido.<br />";
		}else{
			echo "Erro ao inserir $titulo. <br />";
		}
	}

	break;

	/////////// Registro Sonoro
	case "registro_sonoro":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando index...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql_delete = "DELETE FROM `acervo_busca` WHERE colecao = 'Partitura' ";
	$query = mysqli_query($con,$sql_delete);
	
	
	$sql = "SELECT id_registro, titulo, id_tabela FROM acervo_registro WHERE tabela = '97' AND publicado = '1' $teste";
	$query = mysqli_query($con,$sql);
	
	
	
	while($x = mysqli_fetch_array($query)){
		$id_registro = $x['id_registro'];
		$titulo = $x['titulo'];
		$autoridades = retornaAutoridades($x['id_registro']);
		$autores = $autoridades['string'];
		$as = retornaTermos($id_registro);
		$assunto = $as['string'];
		$id_tabela = $x['id_tabela'];
		
		$sql_conteudo = "SELECT conteudo FROM acervo_partituras WHERE idDisco = '$id_tabela'";
		$query_conteudo = mysqli_query($con,$sql_conteudo);
		$c = mysqli_fetch_array($query_conteudo);
		$conteudo = $c['conteudo'];
		$conteudo = str_replace("CONTEÚDO:", "", $string); 
		$conteudo = str_replace("--", "", $string); 		
		
		
		$indexado = $titulo." ".$autores." ".$assunto." ".$conteudo;
		$sql_insert = "INSERT INTO `acervo_busca` (`id`, `id_registro`, `titulo`, `autor`, `assunto`, `colecao`, `indexado`, `matriz_analitica`) VALUES (NULL, '$id_registro', '$titulo', '$autores', '$assunto','Partitura' , '$indexado',  '')";
		$insere = mysqli_query($con,$sql_insert);
		if($insere){
			echo "$titulo inserido.<br />";
		}else{
			echo "Erro ao inserir $titulo. <br />";
		}
	}
	
	break;


	/////////// Registro
	case "registro":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando os registros...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT id, n_chapa, data, local  FROM temp_partituras $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$id = $x['id'];
		$n_chapa = $x['n_chapa'];
		$data = $x['data'];
		$idTermo = recuperaIdTermo($x['local'],14);	
		$sql_update = "UPDATE acervo_partituras SET 
		data_gravacao = '$data',
		local_gravacao = '$idTermo',
		registro = '$n_chapa'
		WHERE idTemp = '$id'";
		
		$query_update = mysqli_query($con,$sql_update);
			if($query_update){
				echo "Registro $id atualizado.<br />";
			}else{
				echo "Erro ao atualizar $id.<br />";
			}		
		
		
		
	}
	
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	
	break;

	/////////// Arruma analíticas
	case "fix_analiticas":
	
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando os registros...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT idDisco  FROM acervo_partituras WHERE `planilha` = 18 AND `tombo` LIKE '%Ex%'";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$id = $x['idDisco'];
		$sql_update = "UPDATE acervo_registro SET publicado = 0
					WHERE tabela = 97 AND
					id_tabela = '$id'";
		
		$query_update = mysqli_query($con,$sql_update);
			if($query_update){
				echo "Registro $id atualizado.<br />";
			}else{
				echo "Erro ao atualizar $id.<br />";
			}		
		
		
		
	}

	$sql = "SELECT idDisco  FROM acervo_partituras WHERE `planilha` = 18 AND `tombo` LIKE '%copia%'";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$id = $x['idDisco'];
		$sql_update = "UPDATE acervo_registro SET publicado = 0
					WHERE tabela = 97 AND
					id_tabela = '$id'";
		
		$query_update = mysqli_query($con,$sql_update);
			if($query_update){
				echo "Registro $id atualizado.<br />";
			}else{
				echo "Erro ao atualizar $id.<br />";
			}		
		
		
		
	}
	
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	
	break;

case "inicio":
?>
<h1>Gera Index</h1>

<a href="?action=partitura">Partitura</a><br />
<br />
<a href="?action=partitura&teste">Partitura Teste</a><br />
<br />
<a href="?action=registro_sonoro">Registro Sonoro</a><br />
<br />


<?php 
break;

} ?>
