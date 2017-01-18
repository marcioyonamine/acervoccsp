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
	

	case "planilha":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Criando os registros...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	
	function recuperaMatriz($tombo){
		$sql = "SELECT idDisco FROM acervo_discoteca WHERE tombo = '$tombo' AND planilha = '17' LIMIT 0,1";
		$query = mysqli_query($con,$query);
		$x = mysqli_fetch_array($query);
		return $x['idDisco'];
	}
	
	
	$sql_lista = "SELECT idDisco, tombo, resumo_tombo, planilha FROM temp_discoteca WHERE planilha = '18'";
	$query_lista = mysqli_query($con,$sql_lista);
	while($x = mysqli_fetch_array($query_lista)){
		
		$tombo = retiraTombo($x['tombo']);
		$resumo = retiraTombo($x['resumo_tombo']);
		$id = $x['idDisco'];

		$lado = 0;
		if(stripos($resumo, "Lado 1")=== true){
			$lado = 1;
		}
		if(stripos($resumo, "Lado 2")=== true){
			$lado = 2;
		}
		
		
		$faixa = 0;
		if(stripos($resumo, "Faixa 01")=== true){
			$faixa = 1;
		}
		if(stripos($resumo, "Faixa 02")=== true){
			$faixa = 2;
		}
		if(stripos($resumo, "Faixa 03")=== true){
			$faixa = 3;
		}
		if(stripos($resumo, "Faixa 04")=== true){
			$faixa = 4;
		}
		if(stripos($resumo, "Faixa 05")=== true){
			$faixa = 5;
		}
		if(stripos($resumo, "Faixa 06")=== true){
			$faixa = 6;
		}
		if(stripos($resumo, "Faixa 07")=== true){
			$faixa = 7;
		}
		if(stripos($resumo, "Faixa 08")=== true){
			$faixa = 8;
		}
		if(stripos($resumo, "Faixa 09")=== true){
			$faixa = 9;
		}
		if(stripos($resumo, "Faixa 10")=== true){
			$faixa = 10;
		}
		if(stripos($resumo, "Faixa 11")=== true){
			$faixa = 11;
		}
		if(stripos($resumo, "Faixa 12")=== true){
			$faixa = 12;
		}
		if(stripos($resumo, "Faixa 13")=== true){
			$faixa = 13;
		}
		if(stripos($resumo, "Faixa 14")=== true){
			$faixa = 14;
		}
		if(stripos($resumo, "Faixa 15")=== true){
			$faixa = 15;
		}
		if(stripos($resumo, "Faixa 16")=== true){
			$faixa = 16;
		}
		if(stripos($resumo, "Faixa 17")=== true){
			$faixa = 17;
		}
		if(stripos($resumo, "Faixa 18")=== true){
			$faixa = 18;
		}
		if(stripos($resumo, "Faixa 19")=== true){
			$faixa = 19;
		}
		if(stripos($resumo, "Faixa 20")=== true){
			$faixa = 20;
		}

		if($tombo != NULL AND $tombo != ""){
			$tombo_final = substr($tombo, 0,5);
		}else{
			$tombo_final = substr($resumo, 0,5);
		}
		
		$matriz = recuperaMatriz($tombo_final);
		$sql_atualiza = "UPDATE acervo_discoteca SET 
		lado = '$lado',
		faixa = '$faixa',
		matriz = '$matriz'
		WHERE idTemp = '$id'";
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

	case "modelo":
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
	
	
	
	case "inicio":
?>
<h1>Importação dos termos para a base</h1>
<!--
<a href="?action=titulos">Migrar titulos</a><br />
<br />
<a href="?action=registros">Criar registros</a><br />
<br />
-->

<a href="?action=ids">Criar IDs</a><br />
<br />
<a href="?action=relacao_autoridades">Relações de Autoridades</a><br />
<br />

<a href="?action=titulos">Migração de Titulos</a><br />
<br />

<a href="?action=tombo">Tombo</a><br />
<br />

<a href="?action=planilha">Planilha</a><br />
<br />

<?php 
break;

} ?>
