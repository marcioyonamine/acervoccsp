<?php
$con = bancoMysqli();
include 'includes/menuPartitura.php';

function dataAcervo($tipo,$data){
	switch($tipo){
	case 5: //ano
	
	break;
	case 6: //Século
	
	break;
	case 7: // MM/AAAA
	
	break;
	case 8: // DD/MM/AAAA
	
	break;
	
		
	}

	
}



if(isset($_POST['cadastraRegistro']) OR isset($_POST['atualizaRegistro'])){
if(isset($_POST['fim'])){
	$fim = 1;	
}else{
	$fim = 0;	
}
$planilha = 17;
$hoje = date("Y-m-d H:i:s");
$colecao = $_POST['colecao'];
$tombo = $_POST['tombo'];
$tombo_antigo = $_POST['tombo_antigo'];
$geral = $_POST['geral'];
$especifico = $_POST['especifico'];
$n_partituras = $_POST['faixas'];
$exemplares = $_POST['exemplares'];
$editora = $_POST['editora'];
$registro = $_POST['registro'];
$tipo_data = $_POST['tipo_data'];
$data_gravacao = $_POST['data_gravacao'];
$local = $_POST['local'];
$fisico = $_POST['fisico'];
$paginas = $_POST['paginas'];
$medidas = $_POST['medidas'];
$titulo = addslashes($_POST['titulo']);
$titulo_uniforme = addslashes($_POST['titulo_uniforme']);
$titulo_geral = addslashes($_POST['titulo_geral']);
$conteudo = addslashes($_POST['conteudo']);
$notas = addslashes($_POST['notas']);
$obs = addslashes($_POST['obs']);
$publicado = 1;
$catalogador = $_SESSION['idUsuario'];
}

if(isset($_POST['cadastraRegistro'])){
	$sql_insere = "INSERT INTO `acervo_partituras` 
	(`planilha`, `catalogador`, `tipo_geral`, `tipo_especifico`, `tombo`, `tombo_antigo`, `editora`, `registro`, `tipo_data`, `data_gravacao`, `local_gravacao`, `descricao_fisica`, `medidas`, `paginas`, `faixas`, `titulo_disco`, `titulo_uniforme`, `titulo_obra`, `conteudo`, `notas`, `obs`, `exemplares`) 
	VALUES ('$planilha', '$catalogador', '$geral', '$especifico', '$tombo', '$tombo_antigo', '$editora', '$registro', '$tipo_data', '$data_gravacao', '$local', '$fisico', '$medidas', '$paginas', '$n_partituras', '$titulo', '$titulo_uniforme', '$titulo_geral', '$conteudo', '$notas', '$obs', '$exemplares');";
	$query_insere = mysqli_query($con,$sql_insere);
	if($query_insere){
		$ultimo = mysqli_insert_id($con);
		$sql_insert_registro = "INSERT INTO `acervo`.`acervo_registro` (`id_registro`, `titulo`, `id_autoridade`, `id_acervo`, `id_tabela`, `publicado`, `tabela`, `data_catalogacao`, `idUsuario`) 
		VALUES (NULL, '$titulo', '', '$colecao', '$ultimo', '1','97','$hoje','$catalogador')";
		$query_insert_registro = mysqli_query($con,$sql_insert_registro);
		
		if($query_insert_registro){
			$mensagem = "Inserido com sucesso(1)";
			$ultimo_registro = mysqli_insert_id($con);
		}else{
			$mensagem = "Erro ao inserir(2)";	
		}
	}else{
		$mensagem = "Erro ao inserir(3)";	
	}
$_SESSION['idDisco'] = $ultimo;
$_SESSION['idReg'] = $ultimo_registro;
}

if(!isset($ultimo)){
	if(isset($_POST['idDisco'])){
		$ultimo = $_POST['idDisco'];
		$_SESSION['idDisco'] = $ultimo;
		
	}else{
		$ultimo = $_SESSION['idDisco'];	
	}
}

if(!isset($ultimo_registro)){
	if(isset($_POST['idReg'])){
		$_SESSION['idReg'] = $ultimo_registro;
		
	}
}

if(isset($_POST['atualizaRegistro'])){
	$ultimo = $_SESSION['idDisco'];
	$sql_atualiza = "UPDATE `acervo_partituras` SET 
	`planilha` = '$planilha', 
	`catalogador` = '$catalogador', 
	`tipo_geral` =  '$geral', 
	`tipo_especifico` = '$especifico', 
	`tombo` = '$tombo', 
	`tombo_antigo` = '$tombo_antigo', 
	`editora` = '$editora', 
	`registro` = '$registro', 
	`tipo_data` = '$tipo_data', 
	`data_gravacao` = '$data_gravacao', 
	`local_gravacao` = '$local', 
	`descricao_fisica` = '$fisico', 
	`faixas` = '$n_partituras',
	`medidas` = '$medidas', 
	`paginas` = '$paginas', 
	`titulo_disco` = '$titulo', 
	`titulo_uniforme` =  '$titulo_uniforme', 
	`titulo_obra` =  '$titulo_geral', 
	`conteudo` = '$conteudo', 
	`notas` = '$notas', 
	`obs` = '$obs', 
	`fim` = '$fim', 
	`exemplares` = '$exemplares'
	 WHERE idDisco = '$ultimo'";
	$query_atualiza = mysqli_query($con,$sql_atualiza);
	//verificaMysql($sql_atualiza);
	if($query_atualiza){
		$sql_update_registro = "UPDATE `acervo_registro` SET
		`id_acervo` = '$colecao',
		`titulo` = '$titulo',
		`idUsuario` = '$catalogador', 
		`data_catalogacao` = '$hoje'
		WHERE id_tabela = '$ultimo' AND tabela = '97'";
		$query_update_registro = mysqli_query($con,$sql_update_registro);
		if($query_update_registro){
			$mensagem = "Atualizado com sucesso(1)";
		}else{
			$mensagem = "Erro ao atualizar(2)";	
		}
	}else{
		$mensagem = "Erro ao atualizar(3)";	
	}
}



$disco = recuperaDados("acervo_partituras",$ultimo,"idDisco");
$rec_reg = idReg($ultimo,$_SESSION['idTabela']);
$registro = recuperaDados("acervo_registro",$rec_reg,"id_registro");
$_SESSION['idReg'] = $registro['id_registro'];
$_SESSION['idDisco'] = $disco['idDisco'];
$_SESSION['idAnalitica'] = 0;

?>

	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
              		<h4>Partitura - MATRIZ</h4>
					<h3><?php echo $registro['titulo'];?></h3>
					
                    <p><?php if(isset($mensagem)){ echo $mensagem; } ?></p>

                    <br />
                    <br />
               </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=discoteca&p=frm_atualiza_partitura" method="post">
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Coleção</strong><br/>
                	  <select class="form-control" id="tipoDocumento" name="colecao" >
					   <?php
						 geraAcervoOpcao(7,$registro['id_acervo']);
						?>
					  </select>
                      </div>
				  </div>	
                                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Tombo / Localização</strong><br/>
					  <input type="text" class="form-control" id="" name="tombo"  value="<?php echo $disco['tombo']; ?>" >
                      </div>
				  </div>
                                                      <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Tombo Antigo</strong><br/>
					  <input type="text" class="form-control"  id="" name="tombo_antigo"  value="<?php echo $disco['tombo_antigo']; ?>" >
                      </div>
				  </div>	
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Tipo Geral:</strong><br/>
					  <select class="form-control" id="planilha" name="geral" >
					   <?php
						geraTipoOpcao("geral_partitura",$disco['tipo_geral']);
						?>  
					  </select>

					</div>				  
					<div class=" col-md-6"><strong>Tipo Específico:</strong><br/>
                	  <select class="form-control" id="geral" name="especifico" >
					   <?php
						geraTipoOpcao("especifico_partitura",$disco['tipo_especifico']);
						?>  
					  </select>
					</div>
				  </div>
				   <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Número de Partituras:</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="faixas"  value="<?php echo $disco['faixas']; ?>" >

					</div>				  
					<div class=" col-md-6"><strong>Exemplares:</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="exemplares"  value="<?php echo $disco['exemplares']; ?>" >
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/>
					<h5>Imprenta</h5>
                      </div>
				  </div>
			 
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Editora</strong><br/>
                	  <select class="form-control" id="tipoDocumento" name="editora" >

					   <?php
						opcaoTermo(100,$disco['editora']);
						?>  
					  </select>
                      </div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Registro:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="registro"  value="<?php echo $disco['registro']; ?>" >
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Tipo de data:</strong><br/>
                    <select class="form-control" id="tipoDocumento" name="tipo_data" >
					   <?php
						geraTipoOpcao("data",$disco['tipo_data']);
						?> 
                        </select> 
					</div>				  
					<div class=" col-md-6"><strong>Data da edição/publicação:</strong><br/>
					  <input type="text" class="form-control" id="CCM" name="data_gravacao"  value="<?php echo $disco['data_gravacao']; ?>" >
					</div>
				  </div>


                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Local da edição/publicação:</strong><br/>
					                	  <select class="form-control" id="tipoDocumento" name="local" >
					   <option>Selecione o local da gravação</option>

					  <?php
						opcaoTermo(14,$disco['local_gravacao']);;
						?>  
					  </select>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/>
					<h5>Descrição Física</h5>
                      </div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Tipo:</strong><br/>
					                	  <select class="form-control" id="tipoDocumento" name="fisico" >
					   <?php
						geraTipoOpcao("fisico_partitura", $disco['descricao_fisica']);
						?>  
					  </select>
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Páginas:</strong><br/>
					  <input type="text" class="form-control soNumero" id="CCM" name="paginas"  value="<?php echo $disco['paginas']; ?>" >
					  </div>				  
					<div class=" col-md-6"><strong>Medida (em cm)::</strong><br/>
					                	
					  <input type="text" class="form-control soNumero" id="CCM" name="medidas"  value="<?php echo $disco['medidas']; ?>" >			</div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/>
					<h5>Título</h5>
                      </div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Título *:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="titulo"  value="<?php echo $disco['titulo_disco']; ?>" >
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Título Uniforme *:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="titulo_uniforme" value="<?php echo $disco['titulo_uniforme']; ?>" >
					</div>
				  </div>
                  <!--
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Título da Obra *:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="titulo_geral" value="<?php echo $disco['titulo_obra']; ?>" >
					</div>
				  </div>
				-->
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Conteúdo:</strong><br/>
					 <textarea name="conteudo" class="form-control" rows="10" placeholder=""><?php echo $disco['conteudo']; ?></textarea>
					</div>
				  </div>
                                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Notas:</strong><br/>
					 <textarea name="notas" class="form-control" rows="10" placeholder=""><?php echo ($disco['notas']); ?></textarea>
					</div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observações:</strong><br/>
					 <textarea name="obs" class="form-control" rows="10" placeholder=""><?php echo $disco['obs']; ?></textarea>
					</div>
				  </div>

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Finalizado:</strong><br/>
		        <input type="checkbox" class ="checkbox-circle" name="fim" <?php checar($disco['fim']) ?> >
                	
                  </div>
					</div>

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="atualizaRegistro" value="1" />
 					 <input type="submit" value="atualizar" class="btn btn-theme btn-lg btn-block">
					</div>
				  </div>
				</form>

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
 <a href="?perfil=discoteca&p=frm_termos" class="btn btn-theme btn-block"  >Autoridades / Assuntos</a>
					</div>
				  </div>	
                  				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <br />
					</div>
				  </div>	 
   				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
 <a href="?perfil=discoteca&p=frm_arquivos" class="btn btn-theme btn-block"  >Arquivos / Anexos</a>
					</div>
				  </div>	
                  				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <br />
					</div>
				  </div>	                

<?php if($disco['faixas'] > 1){ ?>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
<a href="?perfil=discoteca&p=frm_analiticas_partitura" class="btn btn-theme btn-block" >Partituras/Analítica</a>
					</div>
				  </div>				  
<?php } ?>


    
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  

