<?php 
$con = bancoMysqli();
include 'includes/menu.php';

if(isset($_GET['pag'])){
	$pag = $_GET['pag'];
}else{
	$pag = "busca";	
}

switch($pag){
case "insere":

if(isset($_POST['termo'])){
	$hoje = date('Y-m-d H:i:s');
	$termo = $_POST['termo'];
	$sql_insere = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
	VALUES ('$termo', '', '12', '', '', '1', '$hoje', '1')";
	$query_insere = mysqli_query($con,$sql_insere);
	if($query_insere){
		$mensagem = "$termo inserido como Gravadora!";	
	}else{
		$mensagem = "Erro ao inserir. Tente novamente.";	
	}	
	
}else{
	$mensagem = "Erro ao inserir gravadora";	
}
?>

	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h4>Gravadora</h4>
                    <br />
                    <br />
               </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">
<p><?php echo $mensagem; ?></p>

                  		  

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/>
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
					<h4>Gravadora</h4>
                    <br />
                    <br />
               </div>

	  		<div class="row">
            <p>Digite o nome da gravadora</p>
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=discoteca&p=frm_insere_gravadora&pag=resultado" method="post">
                  		  

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
$busca = "SELECT * FROM acervo_termo WHERE termo LIKE '%$termo%' AND tipo = '12' ORDER BY termo ASC";
$query = mysqli_query($con,$busca);
$num = mysqli_num_rows($query);


?>
	 <section id="services" class="home-section bg-white">
		<div class="container">
        			  <div class="form-group">
					<h2>Gravadora</h2>
					<br />
                    <br />
               </div>
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h4>Resultados para "<i><?php echo $termo; ?></i>"</h4>
					</div>
				  </div>
			  </div>

        <?php if($num > 0){ ?>
            <div class="form-group">
			<div class="col-md-offset-2 col-md-8">
<?php while($resultado = mysqli_fetch_array($query)){?>
<?php echo $resultado['termo']; 
if($resultado['adotado'] == 0){ echo "(Adotado)";}
?><?php } ?>
</div>
			</div>
            <?php }else{
				?>
            <div class="form-group">
			<div class="col-md-offset-2 col-md-8">
			<p>Não foram encontrados nenhuma Gravadora com o termo <?php echo $termo; ?></p>	
			</div>
			</div>
                
                <?php
				
				} ?>
            <div class="form-group">
			<div class="col-md-offset-2 col-md-8">
			<p>Inserir o <?php echo "<i>$termo</i>"; ?> como Gravadora?</p>	
			<form method='POST' action='?perfil=discoteca&p=frm_insere_gravadora&pag=insere'>
			<input type='hidden' name='termo' value='<?php echo $termo; ?>'>
			<input type ='submit' class='btn btn-theme btn-md btn-block' value='inserir'></form>
			</div>
			</div>

            		</div>
	</section>
	

<?php break; ?>

<?php } ?>