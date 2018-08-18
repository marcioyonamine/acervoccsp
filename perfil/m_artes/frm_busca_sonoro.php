<?php  
include 'includes/menuSonoro.php';
?>

<?php
$con = bancoMysqli();
if(isset($_GET['b'])){
	$b = $_GET['b'];	
}else{
	$b = 'inicial';
}

switch($b){
case 'inicial':
if(isset($_POST['pesquisar'])){
	$titulo = trim($_POST['titulo']);
	$tombo = trim($_POST['tombo']);
	$tipo = $_POST['tipo'];
	if($tipo == 0){
		$filtro_tipo = "";	
	}else{
		$filtro_tipo = " AND acervo_discoteca.tipo_especifico = '".$tipo."'";
	}
	$colecao = $_POST['colecao'];	
	if($colecao == 0){
		$filtro_colecao = "";	
	}else{
		$filtro_colecao = "AND acervo_registro.id_acervo = '$colecao' ";	
	}	
	if($titulo == "" AND $tombo == "" AND $tipo == 0 AND $colecao == 0){ ?>
		 <section id="services" class="home-section bg-white">
			<div class="container">
				  <div class="row">
					  <div class="col-md-offset-2 col-md-8">
						<div class="section-heading">
						 <h2>Busca</h2>
						

						</div>
					  </div>
				  </div>
				  
				<div class="row">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
				<h5>É preciso que o título ou o número de tombo seja inserido.</h5>
							<form method="POST" action="?perfil=discoteca&p=frm_busca_sonoro" class="form-horizontal" role="form">
						<label>Título</label>
						<input type="text" name="titulo" class="form-control" id="titulo" placeholder="Insira o titulo por parte dele" ><br />
						<label>Tombo</label>
						<input type="text" name="tombo" class="form-control" id="tombo" placeholder="Insira o número de tombo ou parte dele" ><br />

		 
									  
						<br />
						 <label>Tipo</label>
						<select class="form-control" name="tipo" id="inputSubject" >
						<option value="0"></option>		                
												  <?php
							geraTipoOpcao("especifico");
							?>  
						</select>	
						<br />
						 <label>Coleção</label>
						<select class="form-control" name="colecao" id="inputSubject" >
						<option value="0"></option>
						<?php
							 geraAcervoOpcao(6,$registro['id_acervo']);
							?>
						</select>	
						<br /> 					  
					<br />             
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="pesquisar" value="1" />
						<input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
						</form>
						</div>
					</div>
				 </div>
		</section>   
<?php
}else{
	
	if(strlen($tombo) == 0){
	$sql_busca = "SELECT DISTINCT idDisco FROM acervo_discoteca,acervo_registro WHERE 
	planilha = 17 AND (
	titulo_disco LIKE '%$titulo%' OR
	titulo_faixa LIKE '%$titulo%' OR
	titulo_uniforme LIKE '%$titulo%'OR
	conteudo LIKE '%$titulo%')
	AND acervo_registro.tabela = 87 
	AND	acervo_registro.id_tabela = acervo_discoteca.idDisco
	$filtro_tipo
	$filtro_colecao
	AND acervo_registro.publicado = 1

	ORDER BY idDisco DESC 
	";
	}else{
		$sql_busca = "SELECT DISTINCT acervo_discoteca.idDisco FROM acervo_discoteca,acervo_registro WHERE 
		acervo_discoteca.planilha = 17
		AND (tombo LIKE '%$tombo%' OR
		registro LIKE '%$tombo%')
		AND acervo_registro.tabela = 87 
		AND	acervo_registro.id_tabela = acervo_discoteca.idDisco
		AND acervo_registro.publicado = 1
		$filtro_tipo
	$filtro_colecao

		ORDER BY idDisco DESC 
		";	
		
	}
$query_busca = mysqli_query($con,$sql_busca);
$num = mysqli_num_rows($query_busca);
//echo $sql_busca;

?>
<br />
<br />
	<section id="list_items">
		<div class="container">
			 <h3>Resultado da busca</3>
             <h5>Foram encontrados <?php echo $num; ?> registros.</h5>
               <h5><a href="?perfil=discoteca&p=frm_busca_sonoro">Fazer outra busca</a></h5>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td width="5%">Tombo</td>
							<td width="20%">Título</td>
							<td width="30%">Autoridades</td>
							<td width="10%">Coleção</td>
							<td width="10%"></td>
							<td width="10%"></td>
						</tr>
						
					</thead>
					<tbody>

<?php //echo $sql_busca;

						while($y = mysqli_fetch_array($query_busca)){
							$x = recuperaDados("acervo_discoteca",$y['idDisco'],"idDisco");
							$idReg = idReg($y['idDisco'],87);
							$reg = recuperaDados("acervo_registro",$idReg,"id_registro");
							$autoridades = retornaAutoridades($idReg);
							$colecao = recuperaDados("acervo_acervos",$reg['id_acervo'],"id_acervo");
							if(trim($x['titulo_disco']) == ""){
								if(trim($x['titulo_faixa']) == ""){
									if(trim($x['titulo_uniforme']) == ""){
										$titulo = $x['conteudo'];
									}else{
										$titulo = trim($x['titulo_uniforme']);
									}	
								}else{
									$titulo = trim($x['titulo_faixa']);	
								}
								
							}else{
								$titulo = trim($x['titulo_disco']);
							}
						?>
					<tr>
					<td class="list_description"><?php echo $x['tombo'];?> </td>
					<td class="list_description"><?php echo $titulo;?></td>
					<td class="list_description">
                    <?php 
					if($autoridades['total'] > 0){
						echo $autoridades['string'];
					}
					?>
                    
                    </td>
					<td class="list_description"><?php echo $colecao['acervo'];?></td>
					<td class="list_description">
					<form action="?perfil=discoteca&p=frm_atualiza_sonoro" method="post">
<input type="hidden" name="idDisco" value="<?php echo $y['idDisco']?>" />
<input type="hidden" name="valor" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Editar' name='enviar'></form></td>
					<td class="list_description">
					<form action="?perfil=discoteca&p=frm_lista_sonoro" method="post">
<input type="hidden" name="idDisco" value="<?php echo $y['idDisco']?>" />
<input type="hidden" name="apaga" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Apagar' name='Apagar'></form></td>

					</tr>
						<?php } ?>

	
					
					</tbody>
				</table>
			<?php } ?>		
            <?php 
			if($_SESSION['perfil'] == 1){
				//var_dump($x);	
			}
			?>
		</div>
					<?php if($num > 30){?>
               <h5><a href="?perfil=discoteca&p=frm_busca_sonoro">Fazer outra busca</a></h5>
			<?php } ?>
		</div>
	</section>


<?php

}else{
?>
	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Busca</h2>
                    

					</div>
				  </div>
			  </div>
			  
	        <div class="row">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            <h5><?php if(isset($mensagem)){ echo $mensagem; } ?>
                        <form method="POST" action="?perfil=discoteca&p=frm_busca_sonoro" class="form-horizontal" role="form">
            		<label>Título</label>
            		<input type="text" name="titulo" class="form-control" id="titulo" placeholder="Insira o titulo por parte dele" ><br />
            		<label>Tombo</label>
            		<input type="text" name="tombo" class="form-control" id="tombo" placeholder="Insira o número de tombo ou parte dele" ><br />

     
            			          
                    <br />
                     <label>Tipo</label>
                    <select class="form-control" name="tipo" id="inputSubject" >
					<option value="0"></option>		                
											  <?php
						geraTipoOpcao("especifico");
						?>  
                    </select>	
                    <br />
                     <label>Coleção</label>
                    <select class="form-control" name="colecao" id="inputSubject" >
					<option value="0"></option>
					<?php
						 geraAcervoOpcao(6,$registro['id_acervo']);
						?>
                    </select>	
                    <br /> 					  
				<br />             
	            <div class="form-group">
		            <div class="col-md-offset-2 col-md-8">
                	<input type="hidden" name="pesquisar" value="1" />
    		        <input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
                    </form>
        	    	</div>
        	    </div>
             </div>
	</section>               


<?php } ?>

<?php
break;




} // fim da switch

 ?>





