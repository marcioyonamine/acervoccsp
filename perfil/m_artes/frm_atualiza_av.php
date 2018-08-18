<?php
$con = bancoMysqli();
include 'includes/menuAv.php';
/*
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
$planilha = 17;
$hoje = date("Y-m-d H:i:s");
$colecao = $_POST['colecao'];
$tombo = $_POST['tombo'];
$geral = $_POST['geral'];
$especifico = $_POST['especifico'];
$faixas = $_POST['faixas'];
$exemplares = $_POST['exemplares'];
$gravadora = $_POST['gravadora'];
$registro = $_POST['registro'];
$tipo_data = $_POST['tipo_data'];
$data_gravacao = $_POST['data_gravacao'];
$local = $_POST['local'];
$fisico = $_POST['fisico'];
$estereo = $_POST['estereo'];
$polegadas = $_POST['polegadas'];
$titulo = $_POST['titulo'];
$titulo_uniforme = $_POST['titulo_uniforme'];
$conteudo = $_POST['conteudo'];
$notas = $_POST['notas'];
$obs = $_POST['obs'];
$publicado = 1;
$catalogador = $_SESSION['idUsuario'];
}

if(isset($_POST['cadastraRegistro'])){
	$sql_insere = "INSERT INTO `acervo_discoteca` 
	(`planilha`, `catalogador`, `tipo_geral`, `tipo_especifico`, `tombo`, `gravadora`, `registro`, `tipo_data`, `data_gravacao`, `local_gravacao`, `descricao_fisica`, `polegadas`, `faixas`, `titulo_disco`, `titulo_uniforme`, `conteudo`, `notas`, `obs`, `exemplares`) 
	VALUES ('$planilha', '$catalogador', '$geral', '$especifico', '$tombo', '$gravadora', '$registro', '$tipo_data', '$data_gravacao', '$local', '$fisico', '$polegadas', '$faixas', '$titulo', '$titulo_uniforme', '$conteudo', '$notas', '$obs', '$exemplares');";
	$query_insere = mysqli_query($con,$sql_insere);
	if($query_insere){
		$ultimo = mysqli_insert_id($con);
		$sql_insert_registro = "INSERT INTO `acervo`.`acervo_registro` (`id_registro`, `titulo`, `id_autoridade`, `id_acervo`, `id_tabela`, `publicado`, `tabela`, `data_catalogacao`, `idUsuario`) 
		VALUES (NULL, '$titulo', '', '$colecao', '$ultimo', '1','87','$hoje','$catalogador')";
		$query_insert_registro = mysqli_query($con,$sql_insert_registro);
		
		if($query_insert_registro){
			$mensagem = "Inserido com sucesso(1)";
		}else{
			$mensagem = "Erro ao inserir(2)";	
		}
	}else{
		$mensagem = "Erro ao inserir(3)";	
	}
$_SESSION['idDisco'] = $ultimo;
}

if(isset($_POST['atualizaRegistro'])){
	$ultimo = $_SESSION['idDisco'];
	$sql_atualiza = "UPDATE `acervo_discoteca` SET 
	`planilha` = '$planilha', 
	`catalogador` = '$catalogador', 
	`tipo_geral` =  '$geral', 
	`tipo_especifico` = '$especifico', 
	`tombo` = '$tombo', 
	`gravadora` = '$gravadora', 
	`registro` = '$registro', 
	`tipo_data` = '$tipo_data', 
	`data_gravacao` = '$data_gravacao', 
	`local_gravacao` = '$local', 
	`descricao_fisica` = '$fisico', 
	`polegadas` = '$polegadas', 
	`faixas` = '$faixas', 
	`titulo_disco` = '$titulo', 
	`titulo_uniforme` =  '$titulo_uniforme', 
	`conteudo` = '$conteudo', 
	`notas` = '$notas', 
	`obs` = '$obs', 
	`exemplares` = '$exemplares'
	 WHERE idDisco = '$ultimo'";
	$query_atualiza = mysqli_query($con,$sql_atualiza);
	if($query_atualiza){
		$sql_update_registro = "UPDATE `acervo_registro` SET
		`id_acervo` = '$colecao',
		`titulo` = '$titulo',
		`idUsuario` = '$catalogador', 
		`data_catalogacao` = '$hoje'
		WHERE id_tabela = '$ultimo' AND tabela = '87'";
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

if(!isset($ultimo)){
	if(isset($_POST['idDisco'])){
		$ultimo = $_POST['idDisco'];
		$_SESSION['idDisco'] = $ultimo;
		
	}else{
		$ultimo = $_SESSION['idDisco'];	
	}
}
$disco = recuperaDados("acervo_discoteca",$ultimo,"idDisco");
$registro = recuperaDados("acervo_registro",$ultimo,"id_tabela");

// Define as sessions

*/

?>

	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h4>Audiovisual - MATRIZ</h4>
					<h3><?php echo $registro['titulo'];?></h3>

                    <p><?php if(isset($mensagem)){ echo $mensagem; } ?></p>
                    <br />
                    <br />
               </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=discoteca&p=frm_atualiza_av" method="post">
                   <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Coleção</strong><br/>
                	  <select class="form-control" id="tipoDocumento" name="colecao" >
					   <?php
						 geraAcervoOpcao(15);
						?>
					  </select>
                      </div>
				  </div>	
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Número do registro:</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="registro"  value="" >

					</div>				  
					<div class=" col-md-6"><strong>Número do tombo:</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="tombo"  value="" >
					</div>
				  </div>
				   <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Ano inicial ou único:</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="ano_inicio"  value="" >

					</div>				  
					<div class=" col-md-6"><strong>Ano Final:</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="ano_final"  value="" >
					</div>
				  </div>
			 
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Duração (em minutos):</strong><br/>
					  <input type="text" class="form-control" id="CCM" name="duracao"  value="" >
					</div>				  
					<div class=" col-md-6"><strong>Padrão de cor:</strong><br/>
					 			                	  <select class="form-control" id="tipoDocumento" name="cromia" >
					   <option></option>

					  <?php
						geraTipoOpcao("cromia");
						?>  
					  </select>
					</div>
				  </div>


                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Local da gravação:</strong><br/>
					                	  <select class="form-control" id="tipoDocumento" name="local" >
					   <option>Selecione o local da gravação</option>

					  <?php
						opcaoTermo(14);;
						?>  
					  </select>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Procedência:</strong><br/>
					                	  <select class="form-control" id="tipoDocumento" name="procedencia" >
					   <option></option>

					  <?php
						geraTipoOpcao("aquisicao");
						?>  
					  </select>
					</div>
				  </div>
				  
				    <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Suporte:</strong><br/>
							           	  <select class="form-control" id="tipoDocumento" name="suporte" >
					   <option></option>

					  <?php
						geraTipoOpcao("av_suporte");
						?>  
					  </select>
					</div>				  
					<div class=" col-md-6"><strong>Sistema de cor:</strong><br/>
					 			                	  <select class="form-control" id="tipoDocumento" name="sistema" >
					   <option></option>

					  <?php
						geraTipoOpcao("av_sistema");
						?>  
					  </select>
					</div>
				  </div>
				  	<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Número de cópias:</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="copias"  value="" >

					</div>				  
					<div class=" col-md-6"><strong>Estado de conservação:</strong><br/>
					 					 			                	  <select class="form-control" id="tipoDocumento" name="conservacao" >
					   <option></option>

					  <?php
						geraTipoOpcao("estado_conservacao");
						?>  
					  </select>
					</div>
				  </div>


				  

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/>
					<h5>Título</h5>
                      </div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Título *:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="titulo"  value="" >
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Título Uniforme *:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="titulo_uniforme" value="" >
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Conteúdo:</strong><br/>
					 <textarea name="conteudo" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Notas:</strong><br/>
					 <textarea name="notas" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observações:</strong><br/>
					 <textarea name="obs" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="cadastraRegistro" value="1" />
 					 <input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
				</form>
					 </div>
				  </div>

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
<a href="?perfil=discoteca&p=frm_analiticas_sonoro" class="btn btn-theme btn-block" >Faixas (Analítica)</a>
					</div>
				  </div>				  
<?php } ?>


    
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  

