<?php
$con = bancoMysqli();
include 'includes/menuObraEdita.php';




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



if(isset($_POST['cadastraRegistro'])){
	if(isset($_POST['fim'])){
		$fim = 1;	
	}else{
		$fim = 0;	
	}
	$planilha = 17;
	$hoje = date("Y-m-d H:i:s");
	$colecao = $_POST['colecao'];
	$tombo = $_POST['tombo'];	
	$tombo_provisorio = $_POST['tombo_provisorio'];	
	$titulo = addslashes($_POST['titulo']);
	$descricao = addslashes($_POST["descricao"]);
	$observacao_geral = addslashes($_POST["observacao_geral"]);
	$duvidas = addslashes($_POST['duvidas']);
	$catalogador = $_SESSION['idUsuario'];
	$categoria = $_POST['categoria'];
	
	$sql_insere = "INSERT INTO `acervo_artes` (`id`, `tombo`, `tombo_provisorio`, `titulo`, `tipo_data`, `data`, `categoria`, `partes`, `descricao`, `observacao_geral`, `duvidas`, `direitos_autorais`, `finalizado`, `publicado`) VALUES (NULL, '$tombo', '$tombo_provisorio', '$titulo', '', '', '$categoria', '', '$descricao', '$observacao_geral', '$duvidas', '', '', '1')";
	$query_insere = mysqli_query($con,$sql_insere);

	if($query_insere){
		$ultimo = mysqli_insert_id($con);
		$sql_insert_registro = "INSERT INTO `acervo_registro` (`id_registro`, `titulo`, `id_autoridade`, `id_acervo`, `id_tabela`, `publicado`, `tabela`, `data_catalogacao`, `idUsuario`) 
		VALUES (NULL, '$titulo', '', '$colecao', '$ultimo', '1','123','$hoje','$catalogador')";
		$query_insert_registro = mysqli_query($con,$sql_insert_registro);
		
		if($query_insert_registro){
			$mensagem = "Inserido com sucesso(1)";
		}else{
			$mensagem = "Erro ao inserir(2)";	
		}
	}else{
		$mensagem = "Erro ao inserir(3)";	
	}
$_SESSION['idObra'] = $ultimo;


}


if(isset($_POST['atualizaRegistro'])){
	$ultimo = $_SESSION['idDisco'];
	$sql_atualiza = "UPDATE `acervo_discoteca` SET 
	`planilha` = '$planilha', 
	`catalogador` = '$catalogador', 
	`tipo_geral` =  '$geral', 
	`tipo_especifico` = '$especifico', 
	`tombo` = '$tombo', 
	`estereo` = '$estereo', 
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
		`fim` = '$fim', 
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
	if(isset($_POST['idObra'])){
		$ultimo = $_POST['idObra'];
		$_SESSION['idObra'] = $ultimo;
		
	}else{
		$ultimo = $_SESSION['idObra'];	
	}
}
$obra = recuperaDados("acervo_artes",$ultimo,"id");
$id_reg = idReg($ultimo,123);
$registro = recuperaDados("acervo_registro",$id_reg,"id_registro");

$_SESSION['idReg'] = $registro['id_registro'];
$_SESSION['idObra'] = $obra['id'];
$_SESSION['idPartes'] = 0;

// Define as sessions



?>

	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h4>Obra de arte</h4>
					<h3><?php echo $registro['titulo'];?></h3>

                    <p><?php if(isset($mensagem)){ echo $mensagem; } ?></p>
                    <br />
                    <br />
               </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=artes&p=frm_atualiza_artes" method="post">
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Coleção</strong><br/>
                	  <select class="form-control" id="tipoDocumento" name="colecao" >
					   <?php
						 geraAcervoOpcao(16,$registro['id_acervo']);
						?>
					  </select>
                      </div>
				  </div>	
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Título</strong><br/>
					  <input type="text" class="form-control" id="tombo" name="titulo"  value="<?php echo $obra['titulo'] ?>" >
                      </div>
				  </div>	
				                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Título</strong><br/>
					    <select class="form-control" id="tipoDocumento" name="categoria" >
					   <?php
						geraTipoOpcao("cat_artes",$obra['categoria']);
						?> 
                        </select> 
                      </div>
				  </div>
				  
				  
				   <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Tombo:</strong><br/>
					  <input type="text" class="form-control soNumero" id="" name="tombo"  value="<?php echo $obra['tombo'] ?>" >

					</div>				  
					<div class=" col-md-6"><strong>Tombo provisório:</strong><br/>
					  <input type="text" class="form-control soNumero" id="" name="tombo_provisorio"  value="<?php echo $obra['tombo_provisorio'] ?>" >
					</div>
				  </div>

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Descrição:</strong><br/>
					 <textarea name="descricao" class="form-control" rows="10" placeholder=""><?php echo $obra['descricao'] ?></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observação Geral:</strong><br/>
					 <textarea name="observacao_geral" class="form-control" rows="10" placeholder=""><?php echo $obra['observacao_geral'] ?></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Dúvidas:</strong><br/>
					 <textarea name="duvidas" class="form-control" rows="10" placeholder=""><?php echo $obra['duvidas'] ?></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Finalizado:</strong><br/>
		        <input type="checkbox" class ="checkbox-circle" name="fim" <?php checar($obra['finalizado']) ?> >
                	
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

<?php if($obra['partes'] > 1){ ?>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
<a href="?perfil=discoteca&p=frm_analiticas_sonoro" class="btn btn-theme btn-block" >Partes</a>
					</div>
				  </div>				  
<?php } ?>


    
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  

