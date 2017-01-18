<?php
//Exibe erros PHP
@ini_set('display_errors', '1');
error_reporting(E_ALL); 
require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php";

$con = bancoMysqli();
set_time_limit(0);
//$teste = " LIMIT 0,1000";
$teste = "";

	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando os registros...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	
	$sql = "SELECT autoridade01, categoria01,
	autoridade02, categoria02,
	autoridade03, categoria03, 
	autoridade04, categoria04, 
	autoridade05, categoria05, 
	autoridade06, categoria06, 
	autoridade07, categoria07, 
	autoridade08, categoria08, 
	autoridade09, categoria09, 
	autoridade10, categoria10,
	resumo_autoridades,
	idDisco
	FROM temp_discoteca"; 
	
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
	
		if($x['autoridade01'] == NULL OR trim($x['autoridade01']) == "." OR trim($x['autoridade01']) == "" )
		
		{
			$termo = resumoAutoridades($x['resumo_autoridades']);	
				for($j = 0; $j <= count($termo); $j++){
					$idTermo = recuperaIdTermo($termo[$j]['termo'],1);
					$idCat = recuperaIdTermo($termo[$j]['categoria'],78);
					$idNovo = recuperaIdTemp($x['idDisco'],87);
					$idReg = idReg($idNovo,87);
					
					/*
					if($idTermo == NULL OR $idTermo == 0){
						$sql_insere = "INSERT INTO acervo_termo (termo, tipo, id_usuario, data_update, publicado)
						VALUES ('$termo','1','1','$hoje','1')";	
						$query_insere = mysqli_query($con,$sql_insere);
						if($query_insere){
							$idTermo = mysqli_insert_id($con);
							echo "$termo inserido na base termos<br />";	
						}else{
							echo "Erro ao inserir o $termo<br />";
							}
					}

					$sql_insert = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) 
					VALUES ('', '$idReg', '$idTermo', '1', '$idCat', '1')";
					$query_insert = mysqli_query($con,$sql_insert);
					
					if($query_insert){
						echo "Termo $termo inserido em ID $idReg<br />";
					}else{
						echo "Erro.<br />";	
					}
					*/
					
					echo $idTermo." - ".$idCat." - ".$idReg." <br />";
				}
			echo "Há nulidade<br />";
		}else{
			echo "Não há nulidade<br />";
		}
	}
	
	
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	break;

	case "tombo":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando os registros...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	
	$sql_lista = "SELECT idDisco, tombo, resumo_tombo FROM temp_discoteca";
	$query_lista = mysqli_query($con,$sql_lista);
	while($x = mysqli_fetch_array($query_lista)){
		$tombo = retiraTombo($x['tombo']);
		$resumo = retiraTombo($x['resumo_tombo']);
		$id = $x['idDisco'];
		if($tombo != NULL AND $tombo != ""){
			$tombo_final = substr($tombo, 0,5);
		}else{
			$tombo_final = substr($resumo, 0,5);
		}
		
		$sql_atualiza = "UPDATE acervo_discoteca SET tombo = '$tombo_final' WHERE idTemp = '$id'";
		$query_atualiza = mysqli_query($con,$sql_atualiza);
		if($query_atualiza){
			echo "Tombo atualizado $id.<br />";
		}else{
			echo "Erro ao atulizar tombo ($id).<br />";
		}
		
		
		
	}
	
	
	
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	?>