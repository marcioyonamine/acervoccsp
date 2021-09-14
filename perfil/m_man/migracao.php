<?php
   @ini_set('display_errors', '1');
	error_reporting(E_ALL); 

$con = bancoMysqli();
$teste = "3";
//$limite = " LIMIT 0,200";
$limite = "";
set_time_limit(0);



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
							
							$sql_busca_temp = "SELECT * FROM temp_discoteca WHERE idDisco = '".$res['idDisco']."'";		
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
						
						$update_busca_termos = "UPDATE acervo_relacao_termo SET publicado = 0 WHERE idTermo IN(SELECT id_termo FROM acervo_termo WHERE termo = '')";
						$query_busca_termos = mysqli_query($con,$update_busca_termos);
						echo "<pre>";
						var_dump($query_busca_termos);
						echo "</pre>";
						
						

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