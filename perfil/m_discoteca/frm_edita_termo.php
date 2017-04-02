<?php
$con = bancoMysqli();
include 'includes/menu.php';

$id="";
//carrega vazio para inserir



if(isset($_POST['idTermo']) AND (!isset($_POST['insere']) OR !isset($_POST['atualiza']))){
	$termo = recuperaDados("acervo_termo",$_POST['idTermo'],"id_termo");
	$action = "atualiza";
	$id = $_POST['idTermo'];
}else{
	$termo = array();
	$id = "";
	$termo['termo'] = "";	
	$termo['adotado'] = "";	
	$termo['tipo'] = "";	
	$mensagem = ' <p>Antes de inserir um novo termo na base, verifique se já não há termo semelhante e adotado <a href="frm_busca_termo">clicando aqui.</a></p>';
	$action = "insere";
}

if(isset($_POST['termo_insere'])){
	$termo = array();
	$termo['termo'] = $_POST['termo_insere'];
	$termo['tipo'] = $_POST['tipo_insere'];
	$termo['adotado'] = "";
	$action = "insere";
}

// insere
if(isset($_POST['insere'])){
	$termo = addslashes($_POST['termo']);
	$tipo = $_POST['tipo'];
	$user = $_SESSION["idUsuario"];
	$hoje = date("Y-m-d H:i:s");
	//primeiro verifica se o termo já existe na base
	$sql_busca = "SELECT * FROM acervo_termo WHERE termo = '$termo' AND tipo = '$tipo'";
	$query_busca = mysqli_query($con,$sql_busca);
	$num = mysqli_num_rows($query_busca);
	$mensagem = $num;
	if($num > 0){
		$mensagem = "O termo <strong>$termo</strong> já existe na base. Tente novamente.";
		$termo = array();
		$termo['termo'] = $termo;	
		
		$termo['adotado'] = "";	
		$termo['tipo'] = $tipo;
		$action = "insere";
		$id = "";		
	}else{
		$sql_insere = "INSERT INTO `acervo_termo` (`termo`, `tipo`, `id_usuario`, `data_update`, `publicado`) VALUES ('$termo', '$tipo', '$user', '', '1' )";
		$query_insere = mysqli_query($con,$sql_insere);
		if($query_insere){
			$id = mysqli_insert_id($con);
			$termo = recuperaDados("acervo_termo", $id,"id_termo");
			$mensagem = "Termo adicionado com sucesso!";
			$action = "atualiza";
		}else{
			$termo = array();
			$termo['termo'] = "";	
			$termo['adotado'] = "";	
			$termo['tipo'] = "";	
			$mensagem = ' <p>Erro! Tente novamente.</p>';
			$action = "insere";
			$id = "";		

		}
	}
}


//atualiza
if(isset($_POST['atualiza'])){
	$termo = addslashes($_POST['termo']);
	$tipo = $_POST['tipo'];
	$user = $_SESSION["idUsuario"];
	$hoje = date("Y-m-d H:i:s");
	$action = "atualiza";
	$id = $_POST['id'];
	$sql_atualiza = "UPDATE `acervo_termo` SET
	 `termo` = '$termo',
	 `tipo` = '$tipo', 
	 `id_usuario` = '$user',
	  `data_update` = '$hoje'
	   WHERE id_termo = '$id'";
	$query_atualiza = mysqli_query($con,$sql_atualiza);
	if($query_atualiza){
		$termo = recuperaDados("acervo_termo", $id,"id_termo");
		$mensagem = "Termo atualizado com sucesso!";
		$action = "atualiza";
		
	}else{
		
	}
}

if($termo['tipo'] == 1){
	$titulo = "Autoridade";	
}else{
	$titulo = "Termo";	
	
}

?>


	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3><?php echo $titulo; ?></h3>
                    <?php if(isset($mensagem)){echo $mensagem;} ?>
                                        
                    <br />
                    <br />
               </div>
			   				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
				
                  </div>
				  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				
            	<form class="form-horizontal" role="form" action="?perfil=discoteca&p=frm_edita_termo" method="post">
            
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Termo</strong><br/>
					  <input type="text" class="form-control"  name="termo"  value="<?php echo $termo['termo']; ?>" >
                      </div>
				  </div>
				<?php if($termo['tipo'] != '1'){ ?>                  	
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Tipo</strong><br/>
                	  <select class="form-control" id="tipoDocumento" name="tipo" >
					   <?php
							geraTipoOpcaoTermo($GLOBALS['acervo_tipo'],$termo['tipo']);
						?>
					  </select>
                      <br /><Br />
                      </div>
				  </div>	
				<?php }else{ ?>                  	
                   <input type="hidden" name="tipo" value="1" />
 				<?php }?>                  	

				
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="<?php echo $action; ?>" value="1" />
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <?php  if($action == "insere"){?>
 					 <input type="submit" value="Inserir na base" class="btn btn-theme btn-lg btn-block">
					<?php }else{ ?>
 					 <input type="submit" value="Atualizar na base" class="btn btn-theme btn-lg btn-block">
					<?php } ?>

					</div>
				  </div>

				 
                </form>
            <?php if($_SESSION['idReg'] != 0 AND $action == "atualiza"){ ?>    
            	<form class="form-horizontal" role="form" action="?perfil=discoteca&p=frm_termos" method="post">                

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="insereTermo" value="1"/>
                    <input type="hidden" name="termo" value="<?php echo $id; ?>" />
                    <input type="hidden" name="tipo" value="<?php echo $termo['tipo']; ?>" />
                    <input type="hidden" name="id_registro" value="<?php echo $_SESSION['idReg']; ?>" />
 
 					 <input type="submit" value="Inserir no registro" class="btn btn-theme btn-lg btn-block">
					</div>
    			  </div>
				</form>
		  <?php } ?>                     
				  
                

    
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  
