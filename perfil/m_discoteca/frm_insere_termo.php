<?php 
$con = bancoMysqli();


include 'includes/menuTermos.php';

if(isset($_GET['pag'])){
	$pag = $_GET['pag'];
}else{
	$pag = "busca";	
}

if(isset($_SESSION['idDisco'])){
	$dis = recuperaDados("acervo_registro",$_SESSION['idReg'],"id_registro");
	$disco = $dis['titulo'];
	$mensagem = "Você está inserindo autoridades/termos para o registro <strong>$disco</strong>.<br />";	
}else{
	$mensagem = "";	
}

switch($pag){
case "insere":

if(isset($_POST['termo'])){
	$hoje = date('Y-m-d H:i:s');
	$termo = $_POST['termo'];
	$sql_insere = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
	VALUES ('$termo', '', '1', '', '', '1', '$hoje', '1')";
	$query_insere = mysqli_query($con,$sql_insere);
	if($query_insere){
		$mensagem .= "$termo inserido como Autoridade!";	
	}else{
		$mensagem .= "Erro ao inserir. Tente novamente.";	
	}	
	
}else{
	$mensagem .= "Erro ao inserir gravadora";	
}
?>

	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h4>Autoridade</h4>
                    <br />
                    <br />
               </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">
<p><?php echo idReg($_SESSION['idDisco'],87); ?></p>

                  		  

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/>
	              </div>
				  </div>
			
				
	  		</div>
			</div>

	  	</div>
	  </section>  
<?php  
break;
case "busca":

?>
      	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h4>Termos</h4>
                    <?php echo $mensagem; ?>
                    <br />
                    <br />
               </div>

	  		<div class="row">
            <p>Digite o termo que deseja inserir.</p>
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=discoteca&p=frm_insere_termo&pag=resultado" method="post">
                  		  

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/>
                      </div>
				  </div>



				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
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
$con = bancoMysqli();
$busca = "SELECT * FROM acervo_termo WHERE termo LIKE '%$termo%' AND tipo IN(".$GLOBALS['acervo_tipo'].") ORDER BY termo ASC";
$query = mysqli_query($con,$busca);
$num = mysqli_num_rows($query);


?>
<br /><br /><br />
	<section id="list_items">


	<div class="container">
        	<div class="form-group">
					<h4>Termos</h4>
                    <?php echo $mensagem; ?>

               </div>
               <div class="row">
		<?php if($num > 0){ //01?>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Termo</td>
							<td>Tipo</td>
                            <td width="15%"></td>
						</tr>
					</thead>
					<tbody>

                    
                    
		
<?php while($resultado = mysqli_fetch_array($query)){ //02
		$tipo = recuperaDados("acervo_tipo",$resultado['tipo'],"id_tipo");
?>
	<tr>
<td class='list_description'><?php echo $resultado['termo']; 
if($resultado['adotado'] == 0){//03
	 echo " (Adotado)";} //03

?></td>
<td class='list_description'>
<?php echo $tipo['tipo']; ?>
</td>
<td class='list_description'>
			<form method='POST' action='?perfil=discoteca&p=frm_termos'>
			<input type='hidden' name='insereTermo' value='1'>
			<input type='hidden' name='termo' value='<?php echo $resultado['id_termo']; ?>'>
			<input type='hidden' name='tipo' value='<?php echo $resultado['tipo']; ?>'>
			<input type='hidden' name='id_registro' value='<?php echo $_SESSION['idReg']; ?>'>
            
			<input type ='submit' class='btn btn-theme btn-md btn-block' value='inserir ao registro'></form></td>
</tr>
<?php } // 02?>
						
					</tbody>
				</table>
</div>
<?php if(isset($_SESSION['idDisco'])){ // insere na base e no registro?>
            <p>Gostaria de incluir <strong><?php echo $termo; ?></strong> ao registro <strong> <?php echo $disco ?></strong>?</p>
            <p> Lembre-se que essa ação insere o termo na base comum de termos do sistema.</p>
	  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<form method='POST' action='?perfil=discoteca&p=frm_edita_termo'>
                    <input type="hidden" name="adicionaTermo" value="1" />
                    <input type="hidden" name="termo_insere" value="<?php echo $termo; ?>" />
                    <input type="hidden" name="tipo_insere" value="0" />
 					 <input type="submit" value="Adicionar <?php echo $termo; ?>" class="btn btn-theme btn-lg btn-block">
					 </form>
					</div>
				  </div>
                  <br />

                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<br />
                    <a href="??perfil=discoteca&p=frm_insere_termo" class="btn btn-theme lg btn-block"  >Fazer outra busca</a>
					
					</div>
				  </div>     
<?php }else{ ?>
            <p>Gostaria de incluir <strong><?php echo $termo; // insere só na base ?></strong> na base comum de termos do sistema?</p>
	  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<form method='POST' action='?perfil=discoteca&p=frm_edita_termo'>
                    <input type="hidden" name="adicionaTermo" value="1" />
                    <input type="hidden" name="termo_insere" value="<?php echo $termo; ?>" />
                    <input type="hidden" name="tipo_insere" value="<?php echo $tipo; ?>" />
 					 <input type="submit" value="Adicionar <?php echo $termo; ?>" class="btn btn-theme btn-lg btn-block">
					 </form>
					</div>
				  </div>
                  <br />
                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<br />
                    <a href="?perfil=discoteca&p=frm_insere_termo" class="btn btn-theme lg btn-block"  >Fazer outra busca</a>
					
					</div>
				  </div>                     
                  
                  
<?php } ?>
            			
<?php  }else{ ?>
<h3> Não foram encontrados termos  "<?php echo $termo; ?>" como termo válido.</h3>

<?php if(isset($_SESSION['idDisco'])){ // insere na base e no registro?>
            <p>Gostaria de incluir <strong><?php echo $termo; ?></strong> ao registro <strong> <?php echo $disco ?></strong>?</p>
            <p> Lembre-se que essa ação insere o termo na base comum de termos do sistema.</p>
	  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<form method='POST' action='?perfil=discoteca&p=frm_edita_termo'>
                    <input type="hidden" name="adicionaTermo" value="1" />
                    <input type="hidden" name="termo_insere" value="<?php echo $termo; ?>" />
                    <input type="hidden" name="tipo_insere" value="0" />
 					 <input type="submit" value="Adicionar <?php echo $termo; ?>" class="btn btn-theme btn-lg btn-block">
					 </form>
					</div>
				  </div>
                                      <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<br />
                    <a href="?perfil=discoteca&p=frm_insere_termo" class="btn btn-theme lg btn-block"  >Fazer outra busca</a>
					
					</div>
				  </div>    
                  <br />
<?php }else{ ?>
            <p>Gostaria de incluir <strong><?php echo $termo; // insere só na base ?></strong> na base comum de termos do sistema?</p>
	  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<form method='POST' action='?perfil=discoteca&p=frm_edita_termo'>
                    <input type="hidden" name="adicionaTermo" value="1" />
                    <input type="hidden" name="termo_insere" value="<?php echo $termo; ?>" />
                    <input type="hidden" name="tipo_insere" value="<?php echo $tipo; ?>" />
 					 <input type="submit" value="Adicionar <?php echo $termo; ?>" class="btn btn-theme btn-lg btn-block">
					 </form>
					</div>
				  </div>
                    <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<br />
                    <a href="?perfil=discoteca&p=frm_insere_termo" class="btn btn-theme lg btn-block"  >Fazer outra busca</a>
					
					</div>
				  </div>       
                  <br />
<?php } ?>


<?php } ?>
<?php break; ?>

<?php } ?>
<br /><br /><br /><br />

	
            		</div>
                    </div>
	</section>