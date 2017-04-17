<?php
//Exibe erros PHP
@ini_set('display_errors', '1');
error_reporting(E_ALL); 
require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php";

$con = bancoMysqli();
set_time_limit(0);
//$teste = " LIMIT 0,100";
$teste = "";

if(isset($_GET['action'])){
	$action = $_GET['action'];
}else{
	$action = "inicio";
}

function autoridade($idReg,$idTemp){
	$con = bancoMysqli();
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
	id
	FROM temp_partituras WHERE id = $idTemp"; 
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		for($i = 1; $i <= 10; $i++){
			
			if($i == 10){
				$termo = $x['autoridade10'];
				$categoria = retiraParenteses($x['categoria10']);
			}else{
				$termo = $x['autoridade0'.$i.''];
				$categoria = retiraParenteses($x['categoria0'.$i.'']);
			}
			if($termo != "" AND $termo != NULL AND $termo != "."){	
				
				
						
				$idTermo = recuperaIdTermo($termo,1);
				$idCat = recuperaIdTermo($categoria,78);
				

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

				$sql_insert = "INSERT INTO `acervo`.`acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) 
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
}


switch($action){

	/////////// Autoridades
	case "titulos":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando as IDs...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT id, planilha, tipo_geral, tombo_antigo, editora, n_chapa, fisica, paginas, medida, titulo_partitura, titulo_uniforme, titulo_analitica, conteudo, resumo_titulo, resumo_notas, obs FROM temp_partituras $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$id = $x['id'];
		$planilha = $x['planilha'];
		$tipo_geral = $x['tipo_geral'];
		$tombo_antigo = $x['tombo_antigo']; 
		$editora = $x['editora']; //tratar
		$idEditora = recuperaIdTermo($editora,100);
		$n_chapa = $x['n_chapa'];
		$fisica = $x['fisica'];
		$paginas = soNumero($x['paginas']); //tratar
		$medida = soNumero($x['medida']); //tratar
		$titulo_partitura = addslashes(retiraTitulo($x['titulo_partitura']));
		$titulo_uniforme = addslashes(retiraTitulo($x['titulo_uniforme']));//tratar
		$titulo_analitica = addslashes(retiraTitulo($x['titulo_analitica']));//tratar
		if($planilha == 17){
			$titulo = $titulo_partitura;	
		}else{
			$titulo = $titulo_analitica;	
		}
		
		
		
		$conteudo = addslashes($x['conteudo']);
		$resumo_titulo = addslashes($x['resumo_titulo']);
		$resumo_notas = addslashes($x['resumo_notas']);
		$obs = addslashes($x['obs']);
/*		$sql_atualiza = "UPDATE acervo_partituras SET 
		planilha = '$planilha',
		tipo_geral = '$tipo_geral',
		tombo_antigo = '$tombo_antigo', 
		editora = '$idEditora',
		descricao_fisica = '$fisica',
		paginas = '$paginas',
		medidas = '$medida',
		titulo_disco = '$titulo', 
		titulo_uniforme = '$titulo_uniforme',
		titulo_faixa = '$titulo_analitica',
		conteudo = '$conteudo',
		notas = '$resumo_notas',
		obs = '$obs'
		WHERE idTemp = '$id'";
		$query_atualiza = mysqli_query($con,$sql_atualiza);
*/
		$sql_atualiza = "UPDATE acervo_partituras 
		SET titulo_disco = '$titulo'
		WHERE idTemp = '$id'"; 
		$query_atualiza = mysqli_query($con,$sql_atualiza);
		if($query_atualiza){
			echo "$id (tabela partituras) atualizado com sucesso<br />";
			$sql_atualiza_registro = "UPDATE acervo_registro SET titulo = '$titulo' WHERE id_tabela = '$id' AND tabela = '97'";
			$query_atualiza_registro = mysqli_query($con,$sql_atualiza_registro);
			if($query_atualiza_registro){
				echo "$id (tabela registros) atualizado com sucesso<br />";
			}
		}else{
			echo "Erro ao atualizar $id<br />";
			echo $sql_atualiza."<br />";
			
		}
	}
	

	
	
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	
break;


	case "registros":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando os registros...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT idDisco, titulo_disco FROM acervo_partituras $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$idDisco = $x['idDisco'];
		$titulo = addslashes($x['titulo_disco']);
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
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";

	break;
	
	case "registros_atualizar":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando os registros...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT * FROM `acervo_partituras` WHERE idDisco NOT IN (SELECT id_tabela FROM acervo_registro WHERE tabela = 97)";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$idDisco = $x['idDisco'];
		$titulo = addslashes($x['titulo_disco']);
		$sql_update = "INSERT INTO`acervo_registro` 
		(`titulo`, `id_acervo`, `id_tabela`, `publicado`, `tabela`, `data_catalogacao`, `idUsuario`) 
		VALUES ('$titulo', '7', '$idDisco', '1', '97', '$hoje', '1');";
		$query_update = mysqli_query($con,$sql_update);
		if($query_update){
			echo "Registro $titulo inserido. (1) <br />";
			//$idReg = mysqli_insert_id($con);
			//echo autoridade($idReg,$x['idTemp']);	
		}else{
			echo "Erro ao inserir $titulo (2) <br />";
			echo $sql_update."<br />";
			
		}
		
		
		
	}
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";

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
	id
	FROM temp_partituras $teste"; 
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		for($i = 1; $i <= 10; $i++){
			
			if($i == 10){
				$termo = $x['autoridade10'];
				$categoria = retiraParenteses($x['categoria10']);
			}else{
				$termo = $x['autoridade0'.$i.''];
				$categoria = retiraParenteses($x['categoria0'.$i.'']);
			}
			if($termo != "" AND $termo != NULL AND $termo != "."){	
				
				
						
				$idTermo = recuperaIdTermo($termo,1);
				$idCat = recuperaIdTermo($categoria,78);
				$idReg = idReg($x['id'],97);

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

				$sql_insert = "INSERT INTO `acervo`.`acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) 
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
	
		case "tombo_update":
	
	//Sistema de controle de tempo
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Atualizando tombos...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$i = 0;	
	$sql = "SELECT id, tombo_antigo, resumo_tombo FROM temp_partituras $teste"; //seleciona o idDisco e o tombo da tabela antiga
	$query = mysqli_query($con,$sql); //roda  query
	while($disco = mysqli_fetch_array($query)){
		$idDisco = $disco['id'];
		
		$tombo = $disco['resumo_tombo'];
		$tombo_antigo = $disco['tombo_antigo'];
		$sql_update = "UPDATE acervo_partituras SET tombo = '$tombo', tombo_antigo = '$tombo_antigo' WHERE idTemp = '$idDisco'";
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

	case "instrumentacao":
	
	function verificaExistencia($termo){
		$con = bancoMysqli();
		$sql = "SELECT id_termo FROM acervo_termo WHERE termo LIKE '$termo' AND tipo = '121' LIMIT 0,1";
		$query = mysqli_query($con,$sql);
		$num = mysqli_num_rows($query);
		if($num > 0){
			$termo = mysqli_fetch_array($query);
			return $termo['id_termo'];		
		}else{
			return NULL;	
		}

			
	}

	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Atualizando tombos...</h1><br />";
	$hoje = date('Y-m-d H:i:s');

	//seleciona termos distintos adotados 
	$sql_select = "SELECT DISTINCT adotar FROM temp_thesauros_instrumentacao";
	$query_select = mysqli_query($con,$sql_select); 
	while($termo = mysqli_fetch_array($query_select)){
		$adotar = addslashes($termo['adotar']);	
		$sql_insert = "INSERT INTO `acervo_termo` (`termo`, `tipo`, `id_usuario`, `data_update`, `publicado`) VALUES ('$adotar', '121',  '1', '$hoje', '1')";
		$query_insert = mysqli_query($con,$sql_insert);
		if($query_insert){
			echo "O termo $adotar foi inserido como instrumentação.<br />";	
		}else{
			echo "Erro ao inserir o termo $adotar . <br />";
		}
	}

	$sql_select = "SELECT DISTINCT termo FROM temp_thesauros_instrumentacao WHERE termo <> adotar";
	$query_select = mysqli_query($con,$sql_select); 
	while($termo = mysqli_fetch_array($query_select)){
		$adotar = addslashes($termo['termo']);
		$verifica = verificaExistencia($adotar);
		if($verifica != NULL){
			$sql_insert = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `id_usuario`, `data_update`, `publicado`) VALUES ('$adotar', '$verifica', '121',  '1', '$hoje', '1')";
			$query_insert = mysqli_query($con,$sql_insert);
			if($query_insert){
				echo "O termo $adotar foi inserido como instrumentação.<br />";	
			}else{
				echo "Erro ao inserir o termo $adotar . <br />";
			}
		}
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
-->
<a href="?action=registros">Criar registros</a><br />
<br />


<a href="?action=relacao_autoridades">Relações de Autoridades</a><br />
<br />

<a href="?action=tombo_update">Atualiza os tombos novos e antigos.</a><br />
<br />
<a href="?action=instrumentacao">Insere atualização na tabela termos.</a><br />
<br />
<a href="?action=registros_atualizar">Atualizar registros com addslashes</a><br />
<br />

<?php 
break;

} ?>
