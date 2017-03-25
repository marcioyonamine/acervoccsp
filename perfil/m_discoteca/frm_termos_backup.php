<?php 



if(isset($_SESSION['idDisco'])){
	$ultimo = $_SESSION['idDisco'];
}

if(isset($_SESSION['idFaixa'])){
	$ultimo = $_SESSION['idFaixa'];
}

include 'includes/menuTermos.php';

if(isset($_POST['id_registro'])){
	$rec_reg = $_POST['id_registro'];
}else{
	$rec_reg = idReg($ultimo,$_SESSION['tabela']);
}
$registro = recuperaDados("acervo_registro",$rec_reg,"id_registro"); 
$con = bancoMysqli();

if(isset($_GET['pag'])){
	$pag = $_GET['pag'];
}else{
	$pag = "inicio";	
}

switch($pag){
case "inicio":

if(isset($_GET['tipo']) || isset($_POST['tipo'])){


if(isset($_POST['adicionaTermo'])){
	$tipo = $_GET['tipo'];
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
	$idreg = $registro['id_registro'];
	$idtermo = $_POST['termo'];
	$idtipo = $_POST['tipo'];
	$sql_insere = "INSERT INTO `acervo_relacao_termo` (`idRel`, `idReg`, `idTermo`, `idTipo`, `idCat`, `publicado`) 
			VALUES (NULL, '$idreg', '$idtermo', '$idtipo', '', '1')";
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

switch($_GET['tipo'] || $_GET['tipo']){
	case 1:
	$tipo_str = "Autoridades";
	$cat = 78;
	break;
	
	case 15:
	$tipo_str = "Forma / Gênero";
	$cat = 0;
	break;
	
	case 85:
	$tipo_str = "Série";
	$cat = 0;
	break;	

	case 13:
	$tipo_str = "Meio de Expressão";
	$cat = 0;
	break;	

}

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
		<?php 
        $autoridade = listaTermos($registro['id_registro'],$_GET['tipo']);
        
        if($autoridade['total'] > 0){
        ?>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Termo</td>
							<td>Categoria</td>
   							<td></td>
   							<td></td>
							</tr>

                            
                            
                            
						<?php 

							for($i = 0; $i < $autoridade['total'];$i++){
						?>
					<tr>
					<td class="list_description"><?php echo $autoridade[$i]['termo'];?></td>
									<?php if($cat != 0){ ?>
					<td><form action="?perfil=discoteca&p=frm_termos&tipo=<?php echo $_GET['tipo'] ?>" method="post">
					<select name = "categoria">
					<?php 
					opcaoTermoCat($cat,$autoridade[$i]['idCat']);
					?>
					</select></td>
					<td class="list_description">
<input type="hidden" name="idTermoRelacao" value="<?php echo $autoridade[$i]['idRel']?>" />
<input type="hidden" name="atualizar" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Atualizar' name='enviar'></form></td>
					<?php }else{?>
                    <td class="list_description"></td>
                    <td class="list_description"></td>
					<?php }?>

					<td class="list_description">
					<form action="?perfil=discoteca&p=frm_termos&tipo=<?php echo $_GET['tipo'] ?>" method="post">
<input type="hidden" name="idTermoRelacao" value="<?php echo $autoridade[$i]['idRel']?>" />
<input type="hidden" name="apagar" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Apagar' name='enviar'></form></td>



					</tr>
						<?php } ?>
						</tbody>
					</table> 	
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
                    <?php if($tipo == 1){ ?>
<a href="?perfil=discoteca&p=frm_insere_autoridade" class="btn btn-theme btn-block" >Inserir <?php echo $tipo_str; ?></a>
<?php }else{ ?>
<a href="?perfil=discoteca&p=frm_edita_termo" class="btn btn-theme btn-block" >Inserir <?php echo $tipo_str; ?></a>
<?php } ?>		</div>
			  </div>	
				
	<?php }else{ ?>		
  			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
                    <p>Não foi encontrada nenhuma autoridade. Clique no botão abaixo para inserir.</p>
<a href="?perfil=discoteca&p=frm_edita_termo" class="btn btn-theme btn-block" >Inserir <?php echo $tipo_str; ?></a>
				</div>
			</div>	

<?php  } ?>

		</div>
	</div>
</section>  
      
<?php 
}else{
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
<?php	
}
break;
case "busca":
	switch($_GET['tipo']){
	case 1:
		$tipo = "Autoridades";
	break;
	
	case 15:
		$tipo = "Forma / Gênero";
	break;
	
	case 85:
			$tipo = "Série";
	break;
	
	case 13:
			$tipo = "Meio de Expressão";
	break;
	
	}

?>
      	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h4>Termos</h4>
					<h3><?php echo $registro['titulo']; ?></h3>
                    <br />
                    <br />
               </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=discoteca&p=frm_termos&pag=resultado" method="post">
                  		  

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/>
					<h5><?php echo $tipo;?></h5>
                      </div>
				  </div>



				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="tipo" value='<?php echo $_GET['tipo']?>'  />
					  <input type="text" class="form-control" id="topic_title" name="busca"   >
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<br /><br />
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="cadastraRegistro" value="1" />
 					 <input type="submit" value="Buscar" class="btn btn-theme btn-lg btn-block">
					</div>
				  </div>
				</form>
				      
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  

<?php 
break;
case "resultado":
$termo = $_POST['busca'];
$tipo = $_POST['tipo'];
$con = bancoMysqli();
$busca = "SELECT * FROM acervo_termo WHERE termo LIKE '%$termo%' AND tipo = '$tipo' ORDER BY termo ASC";
$query = mysqli_query($con,$busca);
$num_resultado = mysqli_num_rows($query);


?>
<section id="services" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
					<h4>Termos</h4>
					<h3><?php echo $registro['titulo']; ?></h3>
                    <br />
                    <br />
        </div>
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			<div class="section-heading">
					 <h2>Resultados</h2>
                    

			</div>
	  </div>

  </div>
		<div class="container">
		<?php if($num_resultado > 0){ //01?>
<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Termo</td>
                            <td width="15%"></td>
						</tr>
					</thead>
					<tbody>

                    
                    
		
<?php while($resultado = mysqli_fetch_array($query)){ //02?>
	<tr>
<td class='list_description'><?php echo $resultado['termo']; 
if($resultado['adotado'] == 0){//03
	 echo "(Adotado)";} //03

?></td>
<td class='list_description'>
			<form method='POST' action='?perfil=discoteca&p=frm_termos&tipo=<?php echo $tipo; ?>'>
			<input type='hidden' name='insereTermo' value='1'>
			<input type='hidden' name='termo' value='<?php echo $resultado['id_termo']; ?>'>
			
			<input type='hidden' name='tipo' value='<?php echo $_POST['tipo']; ?>'>
			<input type ='submit' class='btn btn-theme btn-md btn-block' value='inserir'></td></form>
</tr>
<?php } // 02?>
						
					</tbody>
				</table>
			</div>
            <p>Não existe na base o termo que procurava? Quer incluí-lo?</p>
            				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<form method='POST' action='?perfil=discoteca&p=frm_edita_termpo'>
                    <input type="hidden" name="adicionaTermo" value="1" />
                    <input type="hidden" name="termo_insere" value="<?php echo $termo; ?>" />
                    <input type="hidden" name="termo_insere" value="<?php echo $tipo; ?>" />
 					 <input type="submit" value="Adicionar <?php echo $termo; ?>" class="btn btn-theme btn-lg btn-block">
					 </form>
					</div>
				  </div>

		<?php }else{ //01 ?>
					  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<h4>Nenhum resultado encontrado. Inserir <i><?php echo $termo ?></i></h4>
					<br /><br />
					</div>
				  </div>

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<form method='POST' action='?perfil=discoteca&p=frm_edita_termpo'>
                    <input type="hidden" name="adicionaTermo" value="1" />
                    <input type="hidden" name="termo_insere" value="<?php echo $termo; ?>" />
                    <input type="hidden" name="termo_insere" value="<?php echo $tipo; ?>" />
 					 <input type="submit" value="Adicionar <?php echo $termo; ?>" class="btn btn-theme btn-lg btn-block">
					 </form>
					</div>
				  </div>	
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<br />
					</div>
				  </div>	
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
 <a href="?perfil=discoteca&p=frm_termos&pag=busca&tipo=<?php echo $tipo; ?>" class="btn btn-theme btn-block"  >Fazer outra busca</a>
					</div>
				  </div>	
						
									  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<br />
					</div>
				  </div>					  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<br />
					</div>
				  </div>	
					
			
		<? } //01 ?>
</div>		

	</section>
	

<?php break; ?>

<?php  }
}?>
