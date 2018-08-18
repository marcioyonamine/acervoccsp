<?php 

//var_sistema();
/*
if(isset($_SESSION['idDisco'])){
	$ultimo = $_SESSION['idDisco'];
}

if(isset($_SESSION['idFaixa'])){
	$ultimo = $_SESSION['idFaixa'];
}



if(isset($_POST['id_registro'])){
	$rec_reg = $_POST['id_registro'];
}else{
	if(isset($_SESSION['idFaixa'])){
		
		$rec_reg = idReg($_SESSION['idFaixa'],$_SESSION['tabela']);
	}else{
		$rec_reg = $_SESSION['idReg'];
	}
}
$registro = recuperaDados("acervo_registro",$rec_reg,"id_registro"); 
*/
$con = bancoMysqli();
// SESSIONS

if(isset($_SESSION['idFaixa']) AND ($_SESSION['idFaixa'] != 0 AND $_SESSION['idFaixa'] != "" AND $_SESSION['idFaixa'] != NULL)){
	$_SESSION['idReg'] = idReg($_SESSION['idFaixa'],$_SESSION['idTabela']);
	$_SESSION['idAnalitica'] = $_SESSION['idFaixa'];	
}else{
	$_SESSION['idReg'] = idReg($_SESSION['idDisco'],$_SESSION['idTabela']);	
}


include 'includes/menuTermos.php';
if(isset($_GET['pag'])){
	$pag = $_GET['pag'];
}else{
	$pag = "inicio";	
}

switch($pag){
case "inicio":



if(isset($_GET['tipo']) || isset($_POST['tipo'])){
	if(isset($_GET['tipo'])){
		$tipo = $_GET['tipo'];	
	}else{
		$tipo = $_POST['tipo'];	
	}
	

	if(isset($_POST['adicionaTermo'])){
	
		$termo = $_POST['termo'];
		$user = $_SESSION['idUsuario'];
		$hoje = date('Y-m-d H:s:i');
		$sql_adiciona = "INSERT INTO `acervo`.`acervo_termo` (`id_termo`, `termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
		VALUES (NULL, '$termo', '0', '$tipo', '', '', '$user', '$hoje', '1')";
		$query_adiciona = mysqli_query($con, $sql_adiciona);
		if ($query_adiciona){
			$ultimo = mysqli_insert_id($con);
			$idreg = $registro['id_registro'];
			$idtermo = $ultimo;
			$idtipo = $tipo;
			$sql_insere = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) 
				VALUES (NULL, '$idreg', '$idtermo', '$idtipo', '', '1')";
			$query_insere = mysqli_query($con,$sql_insere);
			if($query_insere){
				$mensagem = "Termo relacionado com sucesso.";
			}else{
				$mensagem = "Erro ao relacionar";
			
			}
		}
	}
	
	
	
	
	if(isset($_POST['insereTermo'])){
		$idreg = $_SESSION['idReg'];
		$idtermo = $_POST['termo'];
		$idtipo = $_POST['tipo'];
		$sql_insere = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) 
				VALUES (NULL, '$idreg', '$idtermo', '$idtipo', '', '1')";
				echo $sql_insere;
		$query_insere = mysqli_query($con,$sql_insere);
		if($query_insere){
			$mensagem = "Termo relacionado com sucesso.";
		}else{
			$mensagem = "Erro ao relacionar";
			
		}
	}
	
	
	if(isset($_POST['atualizar'])){
		$idRel = $_POST['idTermoRelacao'];
		$idCat = $_POST['categoria'];
		$sql = "UPDATE `acervo_relacao_termo` SET idCat = '$idCat' WHERE idRel = '$idRel'";
		$query = mysqli_query($con,$sql);
		if($query){
			$mensagem = "Termo atualizado.";
		}else{
			$mensagem = "Erro ao atualizar.";
		}
		
	}
	
	if(isset($_POST['apagar'])){
		$idRel = $_POST['idTermoRelacao'];
		$sql = "UPDATE `acervo_relacao_termo` SET publicado = '0' WHERE idRel = '$idRel'";
		$query = mysqli_query($con,$sql);
		if($query){
			$mensagem = "Termo apagado.";
		}else{
			$mensagem = "Erro ao apagar.";
		}
	}

	switch($tipo){
		case 1:
		$tipo_str = "Autoridades";
		$cat = 78;
		break;
		
	default:
		$tipo_str = "Termos";
		$cat = 0;
		if(isset($_POST['tipo'])){
			$tipo = $_POST['tipo'];
		}else{
			$tipo = 0;	
		}
	
		break;
	
	}



$registro = recuperaDados("acervo_registro",$_SESSION['idReg'],"id_registro");



?>

<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
					<h4><?php echo $tipo_str; ?></h4>
					<h3><?php echo $registro['titulo']; ?></h3>

                    <p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
                    <br />
		</div>
        <?php 
		if($tipo == 1){
			$autoridade = listaTermos($_SESSION['idReg'],1);
		}else{
			$autoridade = listaTermos($_SESSION['idReg'],$GLOBALS['acervo_tipo']);
			//echo $autoridade['sql'];
			
		}
        if($autoridade['total'] > 0){
        ?>
		<div class="row">
        
	<section id="list_items">
			<div class="table-responsive list_info">

				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Termo</td>
							<td>Tipo</td>
   							<td></td>
   							<td></td>
							</tr>

                            
                            
                            
						<?php 

							for($i = 0; $i < $autoridade['total'];$i++){
						?>
					<tr>
					<td class="list_description"><?php echo $autoridade[$i]['termo'];?></td>
									<?php if($cat != 0){ ?>
					<form action="?perfil=discoteca&p=frm_termos&tipo=<?php echo $tipo ?>" method="post">
                    <td class="list_description">
					<select name = "categoria">
					<?php 
					opcaoTermoCat($cat,$autoridade[$i]['idCat']);
					?>
					</select></td>
					<td class="list_description">
<input type="hidden" name="idTermoRelacao" value="<?php echo $autoridade[$i]['idRel']?>" />
<input type="hidden" name="atualizar" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Atualizar' name='enviar'></td></form>
					<?php }else{?>
					<td class="list_description"><?php echo $autoridade[$i]['tipo']; ?></td>
                    <td class="list_description"></td>
					<?php } ?>
					<td class="list_description">
					<form action="?perfil=discoteca&p=frm_termos&tipo=<?php echo $tipo ?>" method="post">
<input type="hidden" name="idTermoRelacao" value="<?php echo $autoridade[$i]['idRel']?>" />
<input type="hidden" name="apagar" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Apagar' name='enviar'></form></td>



					</tr>
						<?php } ?>
						</tbody>
					</table> 	
			</div>
        <div class="row">
        <div class="form-group">
			<div class="col-md-offset-2 col-md-8">
			<?php if($tipo == 1){ ?>
				<a href="?perfil=discoteca&p=frm_insere_autoridade" class="btn btn-theme btn-block" >Inserir <?php echo $tipo_str; ?></a>
			<?php }else{ ?>
				<a href="?perfil=discoteca&p=frm_insere_termo" class="btn btn-theme btn-block" >Inserir <?php echo $tipo_str; ?></a>
			<?php } ?>
            		</div>
			  </div>	
				
        
        
		</div><!--row-->
		
		<?php } else { // total > 0?>
		
        <div class="row">
		<h5>Não há <?php echo $tipo_str; ?></h5>
        <div class="form-group">
			<div class="col-md-offset-2 col-md-8">
			<?php if($tipo == 1){ ?>
				<a href="?perfil=discoteca&p=frm_insere_autoridade" class="btn btn-theme btn-block" >Inserir <?php echo $tipo_str; ?></a>
			<?php }else{ ?>
				<a href="?perfil=discoteca&p=frm_insere_termo" class="btn btn-theme btn-block" >Inserir <?php echo $tipo_str; ?></a>
			<?php } ?>
            		</div>
			  </div>	
				

		</div><!--row-->

		<?php } //total > 0?>

</div>
	</div> <!-- container-->
</section>

<?php }else{ //se existe categoria selecionada 
$registro = recuperaDados("acervo_registro",$_SESSION['idReg'],"id_registro");
?>
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h4>Termos</h4>
					<h3><?php echo $registro['titulo']; ?></h3>

                    <p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
                    <br />
                    <br />
               </div>

	  		<div class="row">

							  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
<h4>Utilize o menu localizado no lado esquerdo superior.</h4>
					</div>
				  </div>	
				
	  		</div>
			

	  	</div>
	  </section> 


<?php }  ?>
<?php


break;

}

?>
