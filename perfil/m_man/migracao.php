<?php
   @ini_set('display_errors', '1');
	error_reporting(E_ALL); 

$con = bancoMysqli();
$teste = "3";
//$limite = " LIMIT 0,2000";
$limite = "";
set_time_limit(0);
$semdata = array("sem data",NULL,"NÃO DELETAR ESTE REGISTRO","c [sem data]","sem data sp","","NÃO DELETAR ESTE REGISTRO","[sem data]","[s.d]");



function existeTermo($termo,$tipo){
	$con = bancoMysqli();
	$sql_busca = "SELECT id_termo FROM acervo_termo WHERE termo LIKE '$termo' AND tipo = '$tipo'";
	$query_busca = mysqli_query($con,$sql_busca);

	if($query_busca->num_rows > 0){
		//var_dump($res);
		$res = mysqli_fetch_array($query_busca);
		if(trim($res['id_termo']) == ""){
			return NULL;
		}else{
			return $res['id_termo'];
		}
		
		
	}else{
		return NULL;
	}
}


function termosRuins($termo){
	$termos_ruins = array('TÍTULO DA OBRA:','TÍTULO DA PARTITURA:','FORMA/GÊNERO:','TÍTULO DA OBRA:','MEIO DE EXPRESSÃO:','CONTEÚDO:','DESCRITOR GEOGRÁFICO:','DESCRITOR CRONOLÓGICO:','INSTRUMENTAÇÃO:','Descritor Cronológico:');
	return addslashes(str_replace($termos_ruins,"",trim($termo)));
	
}


?>

	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h1>Migração</h1>
					 
					<?php


							
					
					
					
					
					
					
					/*
					$sql = "SELECT * FROM acervo_discoteca WHERE planilha = '18' AND matriz = '0'";
					$query = mysqli_query($con,$sql);
					while($reg = mysqli_fetch_array($query)){
						echo $reg['titulo_disco']." - ". $reg['tombo'];
						switch($reg['tipo_especifico']){
							case 37:
								$c = 7;
							break;

							case 38:
								$c = 9;							
							break;

							case 39:
								$c = 8;							
							break;
							
						}
						$tombo = substr($reg['tombo'],0,$c);
						
						$sql_atua = "SELECT idDisco FROM acervo_discoteca WHERE tombo = '$tombo' AND planilha = '17'";
						$query2 = mysqli_query($con,$sql_atua);
						$reg2 = mysqli_fetch_array($query2);
						$sql_update = "UPDATE acervo_discoteca SET matriz = '".$reg2['idDisco']."' WHERE idDisco ='".$reg['idDisco']."'"; 
						$update = mysqli_query($con,$sql_update);
						if($update == TRUE){
							echo "Atualizado<br />";
						}else{
							echo "Erro<br />";
						}
					}
					*/
					switch($_GET['action']){

						case "abrir_analitica":
						
						$sql = "SELECT DISTINCT matriz FROM acervo_partituras WHERE planilha = '18' AND matriz <> 0";
						$query = mysqli_query($con,$sql);
						while($matriz = mysqli_fetch_array($query)){
							$m = $matriz['matriz'];
							$sql_update = "UPDATE acervo_partituras SET faixas = '2' WHERE idDisco = '$m'";
							$query_update = mysqli_query($con,$sql_update);
							if($query_update){
								echo "Atualizado.  $m <br />";
							}else{
								echo "Erro. <br />";
							}
						}
						
						
						break;
						
						case "termos_partituras":
						
						
						
						
						echo "<h3>Termos Partituras</h3>";
						$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
						echo "<h1>Criando os registros...</h1><br />";
						$hoje = date('Y-m-d H:i:s');
						
						// recupera os ids
						$sql_busca = "SELECT idTemp,idDisco,id_registro FROM `acervo_registro` INNER JOIN `acervo_partituras` ON acervo_registro.id_tabela = acervo_partituras.idDisco WHERE acervo_registro.tabela = '97' AND acervo_registro.publicado = '1' AND idTemp <> '0' $limite";
						
						$query_busca = mysqli_query($con,$sql_busca);
						//echo $sql_busca;
						while($res = mysqli_fetch_array($query_busca)){
							
							$sql_busca_temp = "SELECT * FROM temp_partituras WHERE id = '".$res['idDisco']."'";		
							$query_busca_temp = mysqli_query($con,$sql_busca_temp);
							
							while($res_temp = mysqli_fetch_array($query_busca_temp)){ // while 2
								$forma_genero = termosRuins($res_temp["Forma/Gênero"]);
								$descritor_geografico = termosRuins($res_temp["Descritor Geográfico"]);					$descritor_cronologico = termosRuins($res_temp["Descritor Cronológico"]);

								$meio_expressao = array();
								$instrumentacao = array();
								// recupera a instrumentação da tabela temp_partituras
								
								array_push($meio_expressao,termosRuins($res_temp["Meio de Expressão"]));
								array_push($meio_expressao,termosRuins($res_temp["Meio de Expressão 2"]));
								array_push($meio_expressao,termosRuins($res_temp["Meio de Expressão 3"]));
								array_push($instrumentacao,termosRuins($res_temp["inst01"]));
								array_push($instrumentacao,termosRuins($res_temp["inst02"]));
								array_push($instrumentacao,termosRuins($res_temp["inst03"]));
								array_push($instrumentacao,termosRuins($res_temp["inst04"]));
								array_push($instrumentacao,termosRuins($res_temp["inst05"]));
								array_push($instrumentacao,termosRuins($res_temp["inst06"]));
								array_push($instrumentacao,termosRuins($res_temp["inst07"]));
								array_push($instrumentacao,termosRuins($res_temp["inst08"]));
								array_push($instrumentacao,termosRuins($res_temp["inst09"]));
								array_push($instrumentacao,termosRuins($res_temp["inst10"]));
								$hoje = date("Y-m-d H:i:s");
								
								if(count($instrumentacao) == 0){
									$instrumentacao = array_push(str_replace("INSTRUMENTAÇÃO:","",termosRuins($res_temp['Resumo Instrumentação'])));
								}

								// Forma Gênero

								// verifica se a forma/genero termo já existe na base
								if($forma_genero != NULL AND $forma_genero != "." ){
									$forma_genero_existe = existeTermo($forma_genero,15);
									if($forma_genero_existe == NULL){ // se não existe, insere
										$sql_insere_termo = "INSERT INTO `acervo_termo` (`id_termo`, `termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`, `abreviatura`) VALUES (NULL, '$forma_genero', '0', '15', '', '', '1', '$hoje', '1', '')";
										$query_insere_termo = mysqli_query($con,$sql_insere_termo);
										$id_ultimo = mysqli_insert_id($con);
										if($id_ultimo > 0){ // se foi inserido, relaciona com o termo
											echo "O termo $forma_genero foi inserido na base como Forma/Gênero.<br />";
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '$id_ultimo', '15', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo $forma_genero foi relacionado com o registro ".$res['id_registro']." como Forma/Gênero.<br />"; 
											}else{
												echo "Erro ao relacionar o termo $forma_genero ao termo ".$res['id_registro']."<br />";
											}
										
											
										}else{
											echo "Erro ao inserir o termo $forma_genero na cabase com o Forma/Gênero.<br />";
										}

										
									}else{ // se existe, verifica se já está associado
										$sql_busca_relacao = "SELECT * FROM acervo_relacao_termo WHERE idReg = '".$res['id_registro']."' AND idTermo = '".$forma_genero_existe."' AND idTipo = '15'";
										$res_busca_relacao = mysqli_query($con, $sql_busca_relacao);
										
										if( $res_busca_relacao->num_rows == 0){
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '".$forma_genero_existe."', '15', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo $forma_genero foi relacionado com o registro ".$res['id_registro']." como Forma/Gênero.<br />"; 
											}else{
												echo "Erro ao relacionar o termo $forma_genero ao termo ".$res['id_registro']."<br />";
											}
											
										}else{
											echo "O termo $forma_genero já está relacionado ao registro ".$res['id_registro']."<br />";
										}		
										

									
									}
								
								}

								// Descritor Geográfico

								// verifica se a forma/genero termo já existe na base
								if($descritor_geografico != NULL AND $descritor_geografico != "." ){
									$descritor_geografico_existe = existeTermo($descritor_geografico,119);
									if($descritor_geografico_existe == NULL){ // se não existe, insere
										$sql_insere_termo = "INSERT INTO `acervo_termo` (`id_termo`, `termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`, `abreviatura`) VALUES (NULL, '$descritor_geografico', '0', '119', '', '', '1', '$hoje', '1', '')";
										$query_insere_termo = mysqli_query($con,$sql_insere_termo);
										$id_ultimo = mysqli_insert_id($con);
										if($id_ultimo > 0){ // se foi inserido, relaciona com o termo
											echo "O termo $descritor_geografico foi inserido na base como Descritor Geográfico.<br />";
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '$id_ultimo', '119', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo $descritor_geografico foi relacionado com o registro ".$res['id_registro']." como Forma/Gênero.<br />"; 
											}else{
												echo "Erro ao relacionar o termo $descritor_geografico ao termo ".$res['id_registro']."<br />";
											}
										
											
										}else{
											echo "Erro ao inserir o termo $descritor_geografico na cabase com o Descritor Geográfico´.<br />";
										}

										
									}else{ // se existe, verifica se já está associado
										$sql_busca_relacao = "SELECT * FROM acervo_relacao_termo WHERE idReg = '".$res['id_registro']."' AND idTermo = '".$descritor_geografico_existe."' AND idTipo = '119'";
										$res_busca_relacao = mysqli_query($con, $sql_busca_relacao);
										
										if( $res_busca_relacao->num_rows == 0){
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '".$descritor_geografico_existe."', '119', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo $descritor_geografico foi relacionado com o registro ".$res['id_registro']." como Descritor Geográfico.<br />"; 
											}else{
												echo "Erro ao relacionar o termo $descritor_geografico ao termo ".$res['id_registro']."<br />";
											}
											
										}else{
											echo "O termo $descritor_geografico já está relacionado ao registro ".$res['id_registro']."<br />";
										}		
										

									
									}
								
								}
								// Descritor Cronológico

								// verifica se a forma/genero termo já existe na base
								if($descritor_cronologico != NULL AND $descritor_cronologico != "." ){
									$descritor_cronologico_existe = existeTermo($descritor_cronologico,122);
									if($descritor_cronologico_existe == NULL){ // se não existe, insere
										$sql_insere_termo = "INSERT INTO `acervo_termo` (`id_termo`, `termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`, `abreviatura`) VALUES (NULL, '$descritor_cronologico', '0', '122', '', '', '1', '$hoje', '1', '')";
										$query_insere_termo = mysqli_query($con,$sql_insere_termo);
										$id_ultimo = mysqli_insert_id($con);
										if($id_ultimo > 0){ // se foi inserido, relaciona com o termo
											echo "O termo $descritor_cronologico foi inserido na base como Descritor Cronológico.<br />";
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '$id_ultimo', '122', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo $descritor_cronologico foi relacionado com o registro ".$res['id_registro']." como Descritor Cronológico.<br />"; 
											}else{
												echo "Erro ao relacionar o termo $descritor_cronologico ao termo ".$res['id_registro']."<br />";
											}
										
											
										}else{
											echo "Erro ao inserir o termo $descritor_cronologico na cabase com o Forma/Gênero.<br />";
										}

										
									}else{ // se existe, verifica se já está associado
										$sql_busca_relacao = "SELECT * FROM acervo_relacao_termo WHERE idReg = '".$res['id_registro']."' AND idTermo = '".$descritor_cronologico_existe."' AND idTipo = '122'";
										$res_busca_relacao = mysqli_query($con, $sql_busca_relacao);
										
										if( $res_busca_relacao->num_rows == 0){
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '".$descritor_cronologico_existe."', '122', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo $descritor_cronologico foi relacionado com o registro ".$res['id_registro']." como Descritor Cronológico.<br />"; 
											}else{
												echo "Erro ao relacionar o termo $descritor_cronologico ao termo ".$res['id_registro']."<br />";
											}
											
										}else{
											echo "O termo $descritor_cronologico já está relacionado ao registro ".$res['id_registro']."<br />";
										}		
										

									
									}
								
								}

								// 	Meio de expressão
								
								//echo "<pre>";
								//var_dump($meio_expressao);
								//echo "</pre>";
								
								
								for($i = 0; $i < count($meio_expressao); $i++){
									if($meio_expressao[$i] != "."){
										$meio_expressao_existe = existeTermo($meio_expressao[$i],13);

									if($meio_expressao_existe == NULL){ // se não existe, insere
										$sql_insere_termo = "INSERT INTO `acervo_termo` (`id_termo`, `termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`, `abreviatura`) VALUES (NULL, '".$meio_expressao_existe."', '0', '13', '', '', '1', '$hoje', '1', '')";
										$query_insere_termo = mysqli_query($con,$sql_insere_termo);
										$id_ultimo = mysqli_insert_id($con);
										if($id_ultimo > 0){ // se foi inserido, relaciona com o termo
											echo "O termo ".$meio_expressao[$i]." foi inserido na base como Meio de Expressão.<br />";
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '$id_ultimo', '13', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo ".$meio_expressao[$i]." foi relacionado com o registro ".$res['id_registro']." como Meio de Expressão.<br />"; 
											}else{
												echo "Erro ao relacionar o termo ".$meio_expressao[$i]." ao termo ".$res['id_registro']."<br />";
											}
										
											
										}else{
											echo "Erro ao inserir o termo ".$meio_expressao[$i]." na base como Meio de Expressão.<br />";
										}

										
									}else{ // se existe, verifica se já está associado
										$sql_busca_relacao = "SELECT * FROM acervo_relacao_termo WHERE idReg = '".$res['id_registro']."' AND idTermo = '".$meio_expressao_existe."' AND idTipo = '13'";
										$res_busca_relacao = mysqli_query($con, $sql_busca_relacao);
										
										if( $res_busca_relacao->num_rows == 0){
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '".$meio_expressao_existe."', '13', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo ".$meio_expressao[$i]." foi relacionado com o registro ".$res['id_registro']." como Meio de Expressão.<br />"; 
											}else{
												echo "Erro ao relacionar o termo ".$meio_expressao[$i]." ao termo ".$res['id_registro']."<br />";
											}
											
										}else{
											echo "O termo ".$meio_expressao[$i]." já está relacionado ao registro ".$res['id_registro']."<br />";
										}		
									}										
										
									}
								}

								
								// instrumentação
								//echo "<pre>";
								//var_dump($instrumentacao);
								//echo "</pre>";

								for($i = 0; $i < count($instrumentacao); $i++){
									if($instrumentacao[$i] != "." ){
										$instrumentacao_existe = existeTermo($instrumentacao[$i],121);

									if($instrumentacao_existe == NULL){ // se não existe, insere
										$sql_insere_termo = "INSERT INTO `acervo_termo` (`id_termo`, `termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`, `abreviatura`) VALUES (NULL, '".$instrumentacao[$i]."', '0', '121', '', '', '1', '$hoje', '1', '')";
										$query_insere_termo = mysqli_query($con,$sql_insere_termo);
										$id_ultimo = mysqli_insert_id($con);
										if($id_ultimo > 0){ // se foi inserido, relaciona com o termo
											echo "O termo ".$instrumentacao[$i]." foi inserido na base como Instrumentação.<br />";
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '$id_ultimo', '121', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo ".$instrumentacao[$i]." foi relacionado com o registro ".$res['id_registro']." como Instrumentação.<br />"; 
											}else{
												echo "Erro ao relacionar o termo ".$instrumentacao[$i]." ao termo ".$res['id_registro']."<br />";
											}
										
											
										}else{
											echo "Erro ao inserir o termo ".$instrumentacao[$i]." na base como Instrumentação.<br />";
										}

										
									}else{ // se existe, verifica se já está associado
										$sql_busca_relacao = "SELECT * FROM acervo_relacao_termo WHERE idReg = '".$res['id_registro']."' AND idTermo = '".$instrumentacao_existe."' AND idTipo = '121'";
										$res_busca_relacao = mysqli_query($con, $sql_busca_relacao);
										
										if( $res_busca_relacao->num_rows == 0){
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '".$instrumentacao_existe."', '121', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo ".$instrumentacao[$i]." foi relacionado com o registro ".$res['id_registro']." como Instrumentação.<br />"; 
											}else{
												echo "Erro ao relacionar o termo ".$instrumentacao[$i]." ao termo ".$res['id_registro']."<br />";
											}
											
										}else{
											echo "O termo ".$instrumentacao[$i]." já está relacionado ao registro ".$res['id_registro']."<br />";
										}		
									}										
										
									}
								}


								
						
							}// fim do while 2
					




						}

						$depois = strtotime(date('Y-m-d H:i:s'));
						$tempo = $depois - $antes;
						echo "<br /><br /> Importação executada em $tempo segundos";

						
						
						
						break;

						case "termos_fonogramas":
						
						
						
						
						echo "<h3>Termos Fonogramas</h3>";
						$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
						echo "<h1>Criando os registros...</h1><br />";
						$hoje = date('Y-m-d H:i:s');
						
						// recupera os ids
						$sql_busca = "SELECT idTemp,idDisco,id_registro FROM `acervo_registro` INNER JOIN `acervo_discoteca` ON acervo_registro.id_tabela = acervo_discoteca.idDisco WHERE acervo_registro.tabela = '87' AND acervo_registro.publicado = '1' AND idTemp <> '0' $limite";
						
						$query_busca = mysqli_query($con,$sql_busca);
						//echo $sql_busca;
						while($res = mysqli_fetch_array($query_busca)){
							
							$sql_busca_temp = "SELECT * FROM temp_discoteca WHERE idDisco = '".$res['idTemp']."'";		
							$query_busca_temp = mysqli_query($con,$sql_busca_temp);
							
							while($res_temp = mysqli_fetch_array($query_busca_temp)){ // while 2
								$forma_genero = termosRuins($res_temp["Forma/Gênero"]);
								$descritor_geografico = termosRuins($res_temp["Resumo Descritor Geográfico"]);				$descritor_cronologico = termosRuins($res_temp["Resumo Descritor Cronológico"]);

								$meio_expressao = array();
								$instrumentacao = array();
								// recupera a instrumentação da tabela temp_partituras
								
								// Fornece: Hll Wrld f PHP
								

								
								array_push($meio_expressao,termosRuins($res_temp["Meio de Expressão"]));
								array_push($meio_expressao,termosRuins($res_temp["Meio de Expressão 2"]));
								array_push($meio_expressao,termosRuins($res_temp["Meio de Expressão 3"]));
								array_push($meio_expressao,termosRuins($res_temp["Resumo Meio de Expressão"]));
								
								//array_push($instrumentacao,termosRuins($res_temp["inst01"]));
								//array_push($instrumentacao,termosRuins($res_temp["inst02"]));
								//array_push($instrumentacao,termosRuins($res_temp["inst03"]));
								//array_push($instrumentacao,termosRuins($res_temp["inst04"]));
								//array_push($instrumentacao,termosRuins($res_temp["inst05"]));
								//array_push($instrumentacao,termosRuins($res_temp["inst06"]));
								//array_push($instrumentacao,termosRuins($res_temp["inst07"]));
								//array_push($instrumentacao,termosRuins($res_temp["inst08"]));
								//array_push($instrumentacao,termosRuins($res_temp["inst09"]));
								//array_push($instrumentacao,termosRuins($res_temp["inst10"]));
								$hoje = date("Y-m-d H:i:s");
								
								//if(count($instrumentacao) == 0){
								//	$instrumentacao = array_push(str_replace("INSTRUMENTAÇÃO:","",termosRuins($res_temp['Resumo Instrumentação'])));
								//}

								// Forma Gênero

								// verifica se a forma/genero termo já existe na base
								if($forma_genero != NULL AND $forma_genero != "." ){
									$forma_genero_existe = existeTermo($forma_genero,15);
									if($forma_genero_existe == NULL){ // se não existe, insere
										$sql_insere_termo = "INSERT INTO `acervo_termo` (`id_termo`, `termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`, `abreviatura`) VALUES (NULL, '$forma_genero', '0', '15', '', '', '1', '$hoje', '1', '')";
										$query_insere_termo = mysqli_query($con,$sql_insere_termo);
										$id_ultimo = mysqli_insert_id($con);
										if($id_ultimo > 0){ // se foi inserido, relaciona com o termo
											echo "O termo $forma_genero foi inserido na base como Forma/Gênero.<br />";
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '$id_ultimo', '15', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo $forma_genero foi relacionado com o registro ".$res['id_registro']." como Forma/Gênero.<br />"; 
											}else{
												echo "Erro ao relacionar o termo $forma_genero ao termo ".$res['id_registro']."<br />";
											}
										
											
										}else{
											echo "Erro ao inserir o termo $forma_genero na cabase com o Forma/Gênero.<br />";
										}

										
									}else{ // se existe, verifica se já está associado
										$sql_busca_relacao = "SELECT * FROM acervo_relacao_termo WHERE idReg = '".$res['id_registro']."' AND idTermo = '".$forma_genero_existe."' AND idTipo = '15'";
										$res_busca_relacao = mysqli_query($con, $sql_busca_relacao);
										
										if( $res_busca_relacao->num_rows == 0){
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '".$forma_genero_existe."', '15', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo $forma_genero foi relacionado com o registro ".$res['id_registro']." como Forma/Gênero.<br />"; 
											}else{
												echo "Erro ao relacionar o termo $forma_genero ao termo ".$res['id_registro']."<br />";
											}
											
										}else{
											echo "O termo $forma_genero já está relacionado ao registro ".$res['id_registro']."<br />";
										}		
										

									
									}
								
								}

								// Descritor Geográfico

								// verifica se a forma/genero termo já existe na base
								if($descritor_geografico != NULL AND $descritor_geografico != "." ){
									$descritor_geografico_existe = existeTermo($descritor_geografico,119);
									if($descritor_geografico_existe == NULL){ // se não existe, insere
										$sql_insere_termo = "INSERT INTO `acervo_termo` (`id_termo`, `termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`, `abreviatura`) VALUES (NULL, '$descritor_geografico', '0', '119', '', '', '1', '$hoje', '1', '')";
										$query_insere_termo = mysqli_query($con,$sql_insere_termo);
										$id_ultimo = mysqli_insert_id($con);
										if($id_ultimo > 0){ // se foi inserido, relaciona com o termo
											echo "O termo $descritor_geografico foi inserido na base como Descritor Geográfico.<br />";
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '$id_ultimo', '119', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo $descritor_geografico foi relacionado com o registro ".$res['id_registro']." como Forma/Gênero.<br />"; 
											}else{
												echo "Erro ao relacionar o termo $descritor_geografico ao termo ".$res['id_registro']."<br />";
											}
										
											
										}else{
											echo "Erro ao inserir o termo $descritor_geografico na cabase com o Descritor Geográfico´.<br />";
										}

										
									}else{ // se existe, verifica se já está associado
										$sql_busca_relacao = "SELECT * FROM acervo_relacao_termo WHERE idReg = '".$res['id_registro']."' AND idTermo = '".$descritor_geografico_existe."' AND idTipo = '119'";
										$res_busca_relacao = mysqli_query($con, $sql_busca_relacao);
										
										if( $res_busca_relacao->num_rows == 0){
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '".$descritor_geografico_existe."', '119', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo $descritor_geografico foi relacionado com o registro ".$res['id_registro']." como Descritor Geográfico.<br />"; 
											}else{
												echo "Erro ao relacionar o termo $descritor_geografico ao termo ".$res['id_registro']."<br />";
											}
											
										}else{
											echo "O termo $descritor_geografico já está relacionado ao registro ".$res['id_registro']."<br />";
										}		
										

									
									}
								
								}
								// Descritor Cronológico

								// verifica se a forma/genero termo já existe na base
								if($descritor_cronologico != NULL AND $descritor_cronologico != "." AND $descritor_cronologico != "Séc."  ){
									$descritor_cronologico_existe = existeTermo($descritor_cronologico,122);
									if($descritor_cronologico_existe == NULL){ // se não existe, insere
										$sql_insere_termo = "INSERT INTO `acervo_termo` (`id_termo`, `termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`, `abreviatura`) VALUES (NULL, '$descritor_cronologico', '0', '122', '', '', '1', '$hoje', '1', '')";
										$query_insere_termo = mysqli_query($con,$sql_insere_termo);
										$id_ultimo = mysqli_insert_id($con);
										if($id_ultimo > 0){ // se foi inserido, relaciona com o termo
											echo "O termo $descritor_cronologico foi inserido na base como Descritor Cronológico.<br />";
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '$id_ultimo', '122', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo $descritor_cronologico foi relacionado com o registro ".$res['id_registro']." como Descritor Cronológico.<br />"; 
											}else{
												echo "Erro ao relacionar o termo $descritor_cronologico ao termo ".$res['id_registro']."<br />";
											}
										
											
										}else{
											echo "Erro ao inserir o termo $descritor_cronologico na cabase com o Forma/Gênero.<br />";
										}

										
									}else{ // se existe, verifica se já está associado
										$sql_busca_relacao = "SELECT * FROM acervo_relacao_termo WHERE idReg = '".$res['id_registro']."' AND idTermo = '".$descritor_cronologico_existe."' AND idTipo = '122'";
										$res_busca_relacao = mysqli_query($con, $sql_busca_relacao);
										
										if( $res_busca_relacao->num_rows == 0){
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '".$descritor_cronologico_existe."', '122', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo $descritor_cronologico foi relacionado com o registro ".$res['id_registro']." como Descritor Cronológico.<br />"; 
											}else{
												echo "Erro ao relacionar o termo $descritor_cronologico ao termo ".$res['id_registro']."<br />";
											}
											
										}else{
											echo "O termo $descritor_cronologico já está relacionado ao registro ".$res['id_registro']."<br />";
										}		
										

									
									}
								
								}

								// 	Meio de expressão
								
								//echo "<pre>";
								//var_dump($meio_expressao);
								//echo "</pre>";
								
								
								for($i = 0; $i < count($meio_expressao); $i++){
									if($meio_expressao[$i] != "." AND $meio_expressao[$i] != "" AND $meio_expressao[$i] != NULL ){
										$meio_expressao_existe = existeTermo($meio_expressao[$i],13);

									if($meio_expressao_existe == NULL){ // se não existe, insere
										$sql_insere_termo = "INSERT INTO `acervo_termo` (`id_termo`, `termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`, `abreviatura`) VALUES (NULL, '".$meio_expressao_existe."', '0', '13', '', '', '1', '$hoje', '1', '')";
										$query_insere_termo = mysqli_query($con,$sql_insere_termo);
										$id_ultimo = mysqli_insert_id($con);
										if($id_ultimo > 0){ // se foi inserido, relaciona com o termo
											echo "O termo ".$meio_expressao[$i]." foi inserido na base como Meio de Expressão.<br />";
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '$id_ultimo', '13', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo ".$meio_expressao[$i]." foi relacionado com o registro ".$res['id_registro']." como Meio de Expressão.<br />"; 
											}else{
												echo "Erro ao relacionar o termo ".$meio_expressao[$i]." ao termo ".$res['id_registro']."<br />";
											}
										
											
										}else{
											echo "Erro ao inserir o termo ".$meio_expressao[$i]." na base como Meio de Expressão.<br />";
										}

										
									}else{ // se existe, verifica se já está associado
										$sql_busca_relacao = "SELECT * FROM acervo_relacao_termo WHERE idReg = '".$res['id_registro']."' AND idTermo = '".$meio_expressao_existe."' AND idTipo = '13'";
										$res_busca_relacao = mysqli_query($con, $sql_busca_relacao);
										
										if( $res_busca_relacao->num_rows == 0){
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '".$meio_expressao_existe."', '13', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo ".$meio_expressao[$i]." foi relacionado com o registro ".$res['id_registro']." como Meio de Expressão.<br />"; 
											}else{
												echo "Erro ao relacionar o termo ".$meio_expressao[$i]." ao termo ".$res['id_registro']."<br />";
											}
											
										}else{
											echo "O termo ".$meio_expressao[$i]." já está relacionado ao registro ".$res['id_registro']."<br />";
										}		
									}										
										
									}
								}

								
								// instrumentação
								//echo "<pre>";
								//var_dump($instrumentacao);
								//echo "</pre>";
								/*	
								for($i = 0; $i < count($instrumentacao); $i++){
									if($instrumentacao[$i] != "." ){
										$instrumentacao_existe = existeTermo($instrumentacao[$i],121);

									if($instrumentacao_existe == NULL){ // se não existe, insere
										$sql_insere_termo = "INSERT INTO `acervo_termo` (`id_termo`, `termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`, `abreviatura`) VALUES (NULL, '".$instrumentacao[$i]."', '0', '121', '', '', '1', '$hoje', '1', '')";
										$query_insere_termo = mysqli_query($con,$sql_insere_termo);
										$id_ultimo = mysqli_insert_id($con);
										if($id_ultimo > 0){ // se foi inserido, relaciona com o termo
											echo "O termo ".$instrumentacao[$i]." foi inserido na base como Instrumentação.<br />";
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '$id_ultimo', '121', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo ".$instrumentacao[$i]." foi relacionado com o registro ".$res['id_registro']." como Instrumentação.<br />"; 
											}else{
												echo "Erro ao relacionar o termo ".$instrumentacao[$i]." ao termo ".$res['id_registro']."<br />";
											}
										
											
										}else{
											echo "Erro ao inserir o termo ".$instrumentacao[$i]." na base como Instrumentação.<br />";
										}

										
									}else{ // se existe, verifica se já está associado
										$sql_busca_relacao = "SELECT * FROM acervo_relacao_termo WHERE idReg = '".$res['id_registro']."' AND idTermo = '".$instrumentacao_existe."' AND idTipo = '121'";
										$res_busca_relacao = mysqli_query($con, $sql_busca_relacao);
										
										if( $res_busca_relacao->num_rows == 0){
											$sql_relaciona = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) VALUES (NULL, '".$res['id_registro']."', '".$instrumentacao_existe."', '121', '$teste', '1')";
											if(mysqli_query($con,$sql_relaciona)){
												echo "O termo ".$instrumentacao[$i]." foi relacionado com o registro ".$res['id_registro']." como Instrumentação.<br />"; 
											}else{
												echo "Erro ao relacionar o termo ".$instrumentacao[$i]." ao termo ".$res['id_registro']."<br />";
											}
											
										}else{
											echo "O termo ".$instrumentacao[$i]." já está relacionado ao registro ".$res['id_registro']."<br />";
										}		
									}										
										
									}
								}
								*/

								
						
							}// fim do while 2
					




						}

						$depois = strtotime(date('Y-m-d H:i:s'));
						$tempo = $depois - $antes;
						echo "<br /><br /> Importação executada em $tempo segundos";

						
						
						
						break;						
						
						
						
						case "limpa_termos":
				
						echo "<h3>Termos Partituras</h3>";
						$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
						echo "<h1>Criando os registros...</h1><br />";
						$hoje = date('Y-m-d H:i:s');
						$i = 0;
						
						$update_busca_termos = "DELETE FROM `acervo_relacao_termo` WHERE idTermo IN(SELECT id_termo FROM acervo_termo WHERE termo = '')";
						$query_busca_termos = mysqli_query($con,$update_busca_termos);

						$delete_termos = "DELETE FROM `acervo_termo` WHERE termo = ''";
						$query_delete_termos = mysqli_query($con,$delete_termos);

						echo "<pre>";
						var_dump($query_busca_termos);
						echo "</pre>";
						
						

						$depois = strtotime(date('Y-m-d H:i:s'));
						$tempo = $depois - $antes;
						echo "<br /><br /> Importação executada em $tempo segundos";						
						
						break;
						


						case "matriz_analiticas_fonogramas":
				
						echo "<h3>Associar Matrizes e Analíticas - Fonogramas</h3>";
						$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
						echo "<h1>Criando os registros...</h1><br />";
						$hoje = date('Y-m-d H:i:s');
						$i = 0;
						
						$sql_busca = "SELECT idDisco,tombo FROM acervo_discoteca WHERE planilha = '18' AND idTemp <> '0' $limite"; // busca todos as analíticas
						//echo $sql_busca;
						$query_busca = mysqli_query($con,$sql_busca);
						while($res = mysqli_fetch_array($query_busca)){
							$id_analitica = $res['idDisco'];
							$tombo = $res['tombo'];
							$id_matriz = retornaMatrizId($tombo);
							if($id_matriz['status'] > 0){
								//atualiza o banco
								$sql_update = "UPDATE acervo_discoteca SET matriz = '".$id_matriz['matriz']."' WHERE idDisco = '$id_analitica'";
								if(mysqli_query($con,$sql_update)){
									//echo $id_analitica." atualizado.<br />";
								}else{
									//echo "erro ao atualizar registro $id_analitica<br />";
								}
							}
							
							if($id_matriz['status'] == 0){
								echo "O $tombo ($id_analitica) não possui matriz.<br />";
							}		
							if($id_matriz['status'] > 1){
								echo "O $tombo está duplicado(".$id_matriz['status'].").<br />";
							}
							
							// número de analíticas
							$sql_conta = "SELECT idDisco FROM acervo_discoteca WHERE planilha = '18' AND tombo LIKE '%$tombo%'";
							$n = mysqli_query($con,$sql_conta);
							if($n->num_rows > 1){
								$update_conta = "UPDATE acervo_discoteca SET faixas = '".$n->num_rows."' WHERE tombo = '$tombo' AND planilha = '17'";
								if(mysqli_query($con,$update_conta)){
									echo "Número de faixas atualizados no tombo $tombo.<br />";
									
								}else{
									echo "Erro ao atualizar múmero de faixas no tombo $tombo.<br />";
								
								}
							}
						
						}

						//echo "<pre>";
						//var_dump($query_busca_termos);
						//echo "</pre>";
						
						

						$depois = strtotime(date('Y-m-d H:i:s'));
						$tempo = $depois - $antes;
						echo "<br /><br /> Importação executada em $tempo segundos";						
						
						break;


						case "matriz_analiticas_partituras":
				
						echo "<h3>Associar Matrizes e Analíticas - Partituras</h3>";
						$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
						echo "<h1>Criando os registros...</h1><br />";
						$hoje = date('Y-m-d H:i:s');
						$i = 0;
						
						$sql_busca = "SELECT idDisco,tombo FROM acervo_partituras WHERE planilha = '18'  AND idTemp <> '0' $limite"; // busca todos as analíticas
						//echo $sql_busca;
						$query_busca = mysqli_query($con,$sql_busca);
						while($res = mysqli_fetch_array($query_busca)){
							$id_analitica = $res['idDisco'];
							$tombo = $res['tombo'];
							$id_matriz = retornaMatrizId($tombo);
							if($id_matriz['status'] > 0){
								//atualiza o banco
								$sql_update = "UPDATE acervo_partituras SET matriz = '".$id_matriz['matriz']."' WHERE idDisco = '$id_analitica'";
								if(mysqli_query($con,$sql_update)){
									//echo $id_analitica." atualizado.<br />";
								}else{
									//echo "erro ao atualizar registro $id_analitica<br />";
								}
							}
							
							if($id_matriz['status'] == 0){
								echo "O $tombo ($id_analitica) não possui matriz.<br />";
							}		
							if($id_matriz['status'] > 1){
								echo "O $tombo está duplicado(".$id_matriz['status'].").<br />";
							}
							
							// número de analíticas
							$sql_conta = "SELECT idDisco FROM acervo_partituras WHERE planilha = '18' AND tombo LIKE '%$tombo%'";
							$n = mysqli_query($con,$sql_conta);
							if($n->num_rows > 1){
								$update_conta = "UPDATE acervo_partituras SET faixas = '".$n->num_rows."' WHERE tombo = '$tombo' AND planilha = '17'";
								if(mysqli_query($con,$update_conta)){
									echo "Número de faixas atualizados no tombo $tombo.<br />";
									
								}else{
									echo "Erro ao atualizar múmero de faixas no tombo $tombo.<br />";
								
								}
							}

							
							
						}
						
						

						//echo "<pre>";
						//var_dump($query_busca_termos);
						//echo "</pre>";
						
						

						$depois = strtotime(date('Y-m-d H:i:s'));
						$tempo = $depois - $antes;
						echo "<br /><br /> Importação executada em $tempo segundos";						
						
						break;						
						
						
						
						
						case "numero_partituras": // numero de partituras, exemplares, registro, data da edição/publicação(21)(cXXXX).
				
				
				
						echo "<h3>Número de partituras, exemplares, registro e data da edição/publicação - Partituras</h3>";
						$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
						echo "<h1>Criando os registros...</h1><br />";
						$hoje = date('Y-m-d H:i:s');
						$i = 0;
						
						$sql_busca = "SELECT id,resumo_tombo FROM temp_partituras WHERE planilha = '18' $limite"; // busca todos as analíticas
						//echo $sql_busca;
						$query_busca = mysqli_query($con,$sql_busca);
						while($res = mysqli_fetch_array($query_busca)){
							$id_analitica = $res['id'];
							$tombo = $res['resumo_tombo'];
							$id_matriz = retornaMatrizId($tombo);
							if($id_matriz['status'] > 0){
								//atualiza o banco
								$sql_update = "UPDATE acervo_partituras SET matriz = '".$id_matriz['matriz']."' WHERE idTemp = '$id_analitica'";
								if(mysqli_query($con,$sql_update)){
									echo $id_analitica." atualizado.<br />";
								}else{
									echo "erro ao atualizar registro $id_analitica<br />";
								}
							}
							
							if($id_matriz['status'] == 0){
								echo "O $tombo não possui matriz.<br />";
							}		
							if($id_matriz['status'] > 1){
								echo "O $tombo está duplicado(".$id_matriz['status'].").<br />";
							}
							
							
							
						}
						
						

						//echo "<pre>";
						//var_dump($query_busca_termos);
						//echo "</pre>";
						
						

						$depois = strtotime(date('Y-m-d H:i:s'));
						$tempo = $depois - $antes;
						echo "<br /><br /> Importação executada em $tempo segundos";						
						
						break;							
						
						case "registro_partituras": // numero de faixas, exemplares, registro, data da edição/publicação(21)(pXXXX).
				
				
				
						echo "<h3>Registro e data da edição/publicação - Partituras</h3>";
						$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
						echo "<h1>Criando os registros...</h1><br />";
						$hoje = date('Y-m-d H:i:s');
						$i = 0;
						

						
						$sql_busca = "SELECT id,Data,n_chapa FROM temp_partituras WHERE planilha = '17' $limite"; // busca todos as matrizes
						//echo $sql_busca;
						$query_busca = mysqli_query($con,$sql_busca);
						while($res = mysqli_fetch_array($query_busca)){
							$idTemp = $res['id'];
							$data = $res['Data'];
							$registro = $res['n_chapa'];
							if(in_array($data,$semdata)){
								$data = '9999';	
							}else{
								$data = preg_replace('/[^0-9]/', '', $data);
							}
						
							$sql_atualiza = "UPDATE `acervo_partituras` SET 
							`tipo_data` = '21',
							`registro` = '$registro',
							`data_gravacao` = '$data'							
							WHERE `acervo_partituras`.`idTemp` = $idTemp;";
							if(mysqli_query($con,$sql_atualiza)){
								echo "Registro $idTemp atualizado com sucesso.<br />";
							}else{
								echo "Erro ao atualizar o regisgro $idTemp. / $sql_atualiza<br />";
								
							}
							
							

						}
						
						

						//echo "<pre>";
						//var_dump($query_busca_termos);
						//echo "</pre>";
						
						

						$depois = strtotime(date('Y-m-d H:i:s'));
						$tempo = $depois - $antes;
						echo "<br /><br /> Importação executada em $tempo segundos";						
						
						break;							

						case "ronoel":
						echo "<h3>Migração da tabela Ronoel</h3>";
						$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
						echo "<h1>Criando os registros...</h1><br />";
						$hoje = date('Y-m-d H:i:s');						
						
						$sql_busca = "SELECT * FROM temp_ronoel ORDER BY id ASC";
						$query_busca = mysqli_query($con,$sql_busca);
						$i = 0;
						$tombo_comp = "teste";
						$fora = array("291490", "69003-D", "24146", "24146", "29320","48.227");
						while($res = mysqli_fetch_array($query_busca)){
							
							// tombo
							$tombo = $res['TOMBO'];
							if(mb_strpos($tombo, 'D78-') !== false){ // verifica se é um tombo válido
								echo $tombo."<br />";
								$tombo_comp = $tombo; // caso não seja
							}else if($tombo == "não tombado"){
								$monta_tombo = explode("-", $tombo_comp);
								$tombo = "D78-".($monta_tombo[1]+1); 
								$tombo_comp = $tombo;	
								echo $tombo."<br />";
							}else if($tombo == NULL){
								echo $tombo_comp."/2 <br />";
							}	

							// Cria a matriz na tabela acervo_discoteca
							// Cria o registro na tabela acervo_registro
							// Relaciona as analíticas às matrizes
							// Relaciona os termos às analíticas (autores, genero);
							
							//Jerezana 291490, 69003-D, 24146, 24146, 29320,48.227 1183, 1184, 1185, 1186, 

							// Cria matriz na tabela acervo_discoteca
							if($res['LADO'] == 'A' AND !in_array($res['N_DISCO'],$fora)){
							$planilha = 17;
							$catalogador = ""; //cod Jefferson
							$tipo_geral = 19;
							$tipo_especifico = 38;
							//$gravadora
							$registro = $res['N_DISCO'];
							$tipo_data = 21;
							$data_gravacao = $res['ANO'];
							$estereo = 29;
							$descricao_fisica = 26;
							$polegadas = 32;
							$faixas = 2;
							$exemplares = $res['QTDE. EXEMPLARES'];
							$titulo_disco = $res['TÍTULO'];

							//$conteudo
							$notas;
							$obs = $res['OBSERVAÇÕES'];
							$idTemp = $res['id'];


								$sql_insere = "INSERT INTO `acervo_discoteca` (`idDisco`, `editado`, `fim`, `planilha`, `matriz`, `catalogador`, `tipo_geral`, `tipo_especifico`, `tombo_tipo`, `lado`, `faixa`, `pag_inicial`, `pag_final`, `tombo`, `gravadora`, `registro`, `comp_registro`, `tipo_data`, `data_gravacao`, `local_gravacao`, `estereo`, `descricao_fisica`, `polegadas`, `faixas`, `duracao`, `exemplares`, `titulo_disco`, `titulo_faixa`, `titulo_uniforme`, `conteudo`, `titulo_resumo`, `serie`, `notas`, `obs`, `disponivel`, `idTemp`) VALUES (NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', '', NULL, NULL, NULL, '', '', NULL, NULL, '', NULL, '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '');";
								
							}
							
							
						
						//insere na tabela acervo_discoteca

							




						}

						
						
						

						$depois = strtotime(date('Y-m-d H:i:s'));
						$tempo = $depois - $antes;
						echo "<br /><br /> Importação executada em $tempo segundos";
						
						break;
						

						case "partituras_paginas": //retirar o número do resumo tombo (depois do p. até o final da string)
						echo "<h3>Default</h3>";
						$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
						echo "<h1>Criando os registros...</h1><br />";
						$hoje = date('Y-m-d H:i:s');						
						

						$depois = strtotime(date('Y-m-d H:i:s'));
						$tempo = $depois - $antes;
						echo "<br /><br /> Importação executada em $tempo segundos";
						
						break;

						case "tainacan_partituras":
						echo "<h3>Gera Tainacan Partituras</h3>";
						$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
						echo "<h1>Criando os registros...</h1><br />";
						$hoje = date('Y-m-d H:i:s');						

						// limpa tabaela acervo_tainacan
						$sql_limpa = "TRUNCATE `acervo_tainacan`";
						$query_limpa = mysqli_query($con,$sql_limpa);
						
						//
						$sql_busca = "SELECT tombo,id_acervo,planilha,editora,medidas,paginas,data_gravacao,titulo,idDisco,id_registro  FROM acervo_registro, acervo_partituras WHERE acervo_registro.id_tabela = acervo_partituras.idDisco AND acervo_registro.publicado = '1' AND acervo_registro.tabela = '97' $limite";
						
						$query_busca = mysqli_query($con,$sql_busca);
						
						while($res = mysqli_fetch_array($query_busca)){
							//echo $res['titulo']."<br />";
							$colecao = reColecao($res['id_acervo']);
							
							//var_dump($col);
							$tombo = $res['tombo'];
							if($res['planilha'] == 17){
								$catalogacao = "Matriz";
							}else if($res['planilha'] == 18){
								$catalogacao = "Analítica";
							}
							$idDisco = $res['idDisco'];
							$grav = recuperaDados("acervo_termo",$res['editora'],"id_termo");
							
							$gravadora = addslashes($grav['termo']);
							$medida = $res['medidas']."cm / ".$res['paginas']."página(s)";
							if($res['data_gravacao'] == '9999'){
								$data = "[ s. d. ]";
							}else{
								$data = $res['data_gravacao'];
							}
							$titulo = addslashes($res['titulo']);
							$autor = retornaAutoridades($res['id_registro']);
							$autoridade = addslashes($autor['string']);
							$descricao = geraConteudo($res['idDisco']);
							
							$forma_genero = "";
							$instrumentacao = "";
							$descritores = "";
							$palavra_chave = "";
							$meio_expressao = "";
							
								/*
								15 // Forma / Gênero
								13 // Meio de Expressão
								85 // Série
								119 // Descritor Geográfico
								121 // Instrumentação
								14 // Local
								78 // Categoria
								12 // Gravadora
								100 // Editora
								122 // Descritor Cronológico
								*/
							
							
							
							$termos = listaTermos($res['id_registro'],"1,15,13,119,121,78,12,100,122");
							
							
							
							for($i = 0; $i < $termos['total']; $i++){
								if($termos[$i]['tipo'] == "Meio de Expressão"){
										$meio_expressao .= $termos[$i]['termo']." || ";
								}else if($termos[$i]['tipo'] == "Forma / Gênero"){
										$forma_genero .= $termos[$i]['termo']." || ";
								}else if($termos[$i]['tipo'] == "Instrumentação"){
										$instrumentacao .= $termos[$i]['termo']." || ";
								}else if($termos[$i]['tipo'] == "Descritor Geográfico"){
										$descritores .= $termos[$i]['termo']." || ";
								}else if($termos[$i]['tipo'] == "Descritor Cronológico"){
										$descritores .= $termos[$i]['termo']." || ";
								}
								$palavra_chave .= $termos[$i]['termo']." || ";
								//echo $termos[$i]['tipo']." / ".$termos[$i]['termo']."<br />";
							}
							
							echo $tombo."<br />";
							//echo $instrumentacao."<br />";
							//echo $descritores."<br />";
							//echo $palavra_chave."<br />";
							//echo $meio_expressao."<br />";	
							echo "<pre>";
							var_dump($res);
							echo "</pre>";				
							
						$sql_insere = "INSERT INTO `acervo_tainacan` (`id`, `colecao`, `tombo`, `catalogacao`, `gravadora`, `medida`, `data`, `titulo`, `autoridade`, `descricao`, `forma_genero`, `instrumentacao`, `meio_expressao`, `descritores`, `palavra-chave`, `idDisco`) VALUES (NULL, '$colecao', '$tombo', '$catalogacao', '$gravadora','$medida', '$data', '$titulo', '$autoridade', '$descricao', '$forma_genero', '$instrumentacao', '$meio_expressao', '$descritores', '$palavra_chave','$idDisco');";
							if(mysqli_query($con,$sql_insere)){
								echo $titulo." inserido com sucesso.<br />";
							}else{
								echo $sql_insere."<br />";
							}							
								
						}
						
						
						// conserta tombo, data
					

						
						

						

						$depois = strtotime(date('Y-m-d H:i:s'));
						$tempo = $depois - $antes;
						echo "<br /><br /> Importação executada em $tempo segundos";
						
						break;


						case "titulos_partituras":
						echo "<h3>Títulos partituras</h3>";
						$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
						echo "<h1>Criando os registros...</h1><br />";
						$hoje = date('Y-m-d H:i:s');	

						$sql_busca = "SELECT conteudo FROM acervo_partituras WHERE (titulo_disco LIKE '' OR titulo_disco LIKE '.')  AND NOT idTemp = '0'" ;
						$query_busca = mysqli_query($con,$sql_busca);
						while($res = mysqli_fetch_array($query_busca)){
							$titulo = str_replace("TÍTULO DA PARTITURA:", "", $res['conteudo']);
							
							
							
						}
						

						$depois = strtotime(date('Y-m-d H:i:s'));
						$tempo = $depois - $antes;
						echo "<br /><br /> Importação executada em $tempo segundos";
						
						break;
						
						default:
						echo "<h3>Default</h3>";
						$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
						echo "<h1>Criando os registros...</h1><br />";
						$hoje = date('Y-m-d H:i:s');	


						

						$depois = strtotime(date('Y-m-d H:i:s'));
						$tempo = $depois - $antes;
						echo "<br /><br /> Importação executada em $tempo segundos";
						
						break;
						
						
						
					
					}

					?>



					</div>
				  </div>
			  </div>
			  
		</div>
	</section>