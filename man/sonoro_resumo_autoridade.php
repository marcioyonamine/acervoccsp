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
	FROM temp_discoteca WHERE (autoridade01 = '.' OR autoridade01 = '' OR autoridade01 IS NULL) "; 
	
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	echo "<h1>$num registros </h1>";
	while($x = mysqli_fetch_array($query)){
		echo $x['resumo_autoridades']."<br />";
		$termo = resumoAutoridades($x['resumo_autoridades']);	
		echo "<pre>";
		var_dump($termo);
		echo "</pre>";
		$termo = resumoAutoridades($x['resumo_autoridades']);	
		for($j = 0; $j < $termo['total']; $j++){
			$idTermo = recuperaIdTermo($termo[$j]['termo'],1);
			$idCat = recuperaIdTermo($termo[$j]['categoria'],78);
			$idNovo = recuperaIdTemp($x['idDisco'],87);
			$idReg = idReg($idNovo,87);
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
					
			echo $idTermo." - ".$idCat." - ".$idReg." <br />";
		}
	}
	
	
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";

	?>