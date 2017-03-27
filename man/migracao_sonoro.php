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

if(isset($_GET['action'])){
	$action = $_GET['action'];
}else{
	$action = "inicio";
}


switch($action){

	/////////// Autoridades
	case "titulos":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando as IDs...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	//$sql = "SELECT id, planilha, tipo_geral, tombo_antigo, editora, n_chapa, fisica, paginas, medida, titulo_partitura, titulo_uniforme, titulo_analitica, conteudo, resumo_titulo, resumo_notas, obs FROM temp_partituras $teste";
	$sql = "SELECT * FROM temp_acervo_discoteca $teste";

	$query = mysqli_query($con,$sql);

	while($x = mysqli_fetch_array($query)){

		$id = $x['idDisco'];
		$planilha = $x['planilha'];
		$tipo_geral = $x['tipo_geral'];
		$tipo_especifico = $x['tipo_especifico'];
		$gravadora = $x['gravadora']; //tratar
		$idGravadora = recuperaIdTermo($gravadora,12);
		$fisica = addslashes($x['descricao_fisica']);
		$titulo_disco = addslashes(retiraTitulo($x['titulo_disco']));
		$titulo_uniforme = addslashes(retiraTitulo($x['titulo_uniforme']));//tratar
		$titulo_faixa = addslashes(retiraTitulo($x['titulo_faixa']));//tratar
		$titulo_resumo = addslashes(retiraTitulo($x['titulo_resumo']));//tratar
	
		if($titulo_disco != NULL AND $titulo_disco != ""){
			$titulo = $titulo_disco;	
		}else{
			if($titulo_faixa != NULL AND $titulo_faixa != "" ){
				$titulo = $titulo_faixa;
				
			}else{
				$titulo = $titulo_resumo;
				
			}
			
		}

		$conteudo = addslashes($x['conteudo']);
		$resumo_notas = addslashes($x['resumo_notas']);
		$obs = addslashes($x['obs']);
		$sql_atualiza = "UPDATE acervo_discoteca SET 
		planilha = '$planilha',
		tipo_geral = '$tipo_geral',
		tipo_especifico = '$tipo_especifico',
		gravadora = '$idGravadora',
		descricao_fisica = '$fisica',
		titulo_disco = '$titulo', 
		titulo_uniforme = '$titulo_uniforme',
		conteudo = '$conteudo',
		notas = '$resumo_notas',
		obs = '$obs'
		WHERE idTemp = '$id'";
		$query_atualiza = mysqli_query($con,$sql_atualiza);
		if($query_atualiza){
			echo "$id atualizado com sucesso<br />";
		}else{
			echo "Erro ao atualizar $id<br />";
			echo $sql_atualiza."<br />";
			
		}

	}
	

	
	
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	
break;





	/////////// Autoridades
	case "ids":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando as IDs...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT idDisco FROM temp_acervo_discoteca $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$idDisco = $x['idDisco'];
		$sql_update = "INSERT INTO `acervo_discoteca` 
		(`idTemp`) 
		VALUES ('$idDisco');";
		$query_update = mysqli_query($con,$sql_update);
		if($query_update){
			echo "Registro $idDisco inserido. (1) <br />";	
		}else{
			echo "Erro ao inserir $idDisco (2) <br />";
			
		}
	}
	break;

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
		VALUES ('$titulo', '7', '$idDisco', '1', '97', '$hoje', '1');";
		$query_update = mysqli_query($con,$sql_update);
		if($query_update){
			echo "Registro $titulo inserido. (1) <br />";	
		}else{
			echo "Erro ao inserir $titulo (2) <br />";
			
		}
	}


	break;

	
	case "relacao_autoridades":
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
	idDisco
	FROM temp_acervo_discoteca $teste"; 
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		for($i = 1; $i <= 10; $i++){
			
			if($i == 10){
				$termo =  addslashes($x['autoridade10']);
				$categoria = retiraParenteses($x['categoria10']);
			}else{
				$termo =  addslashes($x['autoridade0'.$i.'']);
				$categoria = retiraParenteses($x['categoria0'.$i.'']);
			}
			if($termo != "" AND $termo != NULL AND $termo != "."){	
				
				
						
				$idTermo = recuperaIdTermo($termo,1);
				$idCat = recuperaIdTermo($categoria,78);
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

				//echo var_dump($idTermo)."<br />";
			}

		}
	}
	
	
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	break;	
	
	case "relacao_sem_autoridades":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando os registros...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	
	function verificaNulidade($x){
		return TRUE;
		if($x == NULL OR $x == "" OR $x == "." ){
			return NULL;	
		}
			
	}

	
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
	break;
	
	
	case "tombo_update":
	
	//Sistema de controle de tempo
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Atualizando tombos...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$i = 0;	
	$sql = "SELECT idDisco, tombo, resumo_tombo FROM temp_discoteca $teste"; //seleciona o idDisco e o tombo da tabela antiga
	$query = mysqli_query($con,$sql); //roda  query
	while($disco = mysqli_fetch_array($query)){
		$idDisco = $disco['idDisco'];
		
		$tombo = $disco['resumo_tombo'];
		$sql_update = "UPDATE acervo_discoteca SET tombo = '$tombo' WHERE idTemp = '$idDisco'";
		$query_update = mysqli_query($con,$sql_update);
		if($query_update){
			echo $i." Tombo $tombo atualizado com sucesso.<br />";	
		}else{
			echo $i." Erro ao atualizar tombo $tombo.<br />";	
		}
		$i++;
	}

	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	
	
	break;

	
	
	case "inicio":
?>
<h1>Importação dos termos para a base</h1>
<!--
<a href="?action=titulos">Migrar titulos</a><br />
<br />
<a href="?action=registros">Criar registros</a><br />
<br />
-->

<a href="?action=ids">Criar IDs (INSERT)</a><br />
<br />
<a href="?action=titulos">Migração de Titulos (UPDATE)</a><br />
<br />
<a href="?action=tombo">Tombo (INSERT)</a><br />
<br />
<a href="?action=relacao_autoridades">Relações de Autoridades (INSERT)</a><br />
<br />
<a href="?action=relacao_sem_autoridades">Relações SEM Autoridades (INSERT)</a><br />
<br />
<a href="?action=analitica">Criar relações Matriz / Analítica (UPDATE)</a><br />
<br />

<a href="?action=tombo_update">Atualizao tombo antigo na base nova (UPDATE)</a><br />
<br />

<?php 
break;

} ?>
