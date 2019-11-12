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

	/////////// Instrumentação e Meio de expressão
	case "insere":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando os registros...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT id, res_instr FROM temp_partituras $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$idDisco = $x['id'];
		$string = $x['res_instr'];
		$string = str_replace("INSTRUMENTAÇÃO:", "", $string); 
		$string = str_replace(" e ", " ; ", $string); 
		$pieces = explode(";", $string);
		$idReg = idReg($x['id'],97);
		
		
		for($i = 0; $i < sizeof($pieces); $i++){
		$idTermo = recuperaIdTermo(trim($pieces[$i]),121);
		$idCat = 121;
		if($idTermo == NULL){
			$idTermo = recuperaIdTermo(trim($pieces[$i]),13);
			$idCat = 13;
		}
		if(trim($pieces[$i]) != "" AND trim($pieces[$i]) != NULL AND trim($pieces[$i]) != "." AND $idTermo != NULL){
			$sql_insert = "INSERT INTO acervo_relacao_termo (idReg,idTermo,idTipo,publicado) 
			VALUES ( '$idReg','$idTermo','$idCat','1')";
			$query_insert = mysqli_query($con,$sql_insert);
			if($query_insert){
				echo "<p>Termo ".trim($pieces[$i])." associado ao registro $idReg;</p>";
			}else{
				echo "<p>Erro ao associar termo ".trim($pieces[$i])." ao registro $idReg</p>";
				
			}
		}
						
		}		
	}

	break;

	/////////// Forma Genero
	case "forma_genero":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando os registros...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT id, forma_genero FROM temp_partituras $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$idDisco = $x['id'];
		$desc_geo = $x['forma_genero'];
		$idReg = idReg($x['id'],97);
		$idTermo = recuperaIdTermo($x['forma_genero'],15);
		if(trim($desc_geo) != "" AND $desc_geo != NULL){
			$sql_insert = "INSERT INTO acervo_relacao_termo (idReg,idTermo,idTipo,publicado) 
			VALUES ( '$idReg','$idTermo','15','1')";
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
<h1>Importação dos termos para a base</h1>

<a href="?action=insere">Insere Instrumentação (não esqueça de mudar o nome do campo para res_instr)</a><br />
<br />
<a href="?action=forma_genero">Insere Forma/Gênero (não esqueça de mudar o nome do campo para forma_genero)</a><br />
<br />
<a href="?action=registro">Insere Registro, Local e Data (não esqueça de mudar o nome do campo para local, data)</a><br />
<br />
<a href="?action=fix_analiticas">Despublica as analíticas das cópias/exemplares</a><br />
<br />

<?php 
break;

} ?>
