

<?php
$con = bancoMysqli();
if(isset($_SESSION['idDisco'])){
	unset($_SESSION['idDisco']);
	
}

if(isset($_SESSION['idReg'])){
	unset($_SESSION['idReg']);
	
}

if(isset($_SESSION['idFaixa'])){
	unset($_SESSION['idFaixa']);
	
}

if(isset($_POST['apaga'])){
	$id = $_POST['idDisco'];
	$sql_apaga = "UPDATE acervo_registro SET publicado = '0' WHERE id_tabela = '$id' AND tabela = '87'";
	$query_apaga = mysqli_query($con,$sql_apaga);
	if($query_apaga){
		$mensagem = "Apagado com sucesso.";
	}else{
		$mensagem = "Erro ao apagar.";
	}
}

 include 'includes/menu.php';?>
<br />
<br />
<br />
<br />

	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                
                <h2>Últimos registros inseridos</h2>
			<h3>Registros Sonoros / Fonogramas</h3>
            <br />
           
            </div>
            <div></div>
			<div class="table-responsive list_info">
           			 
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>

            		<thead>
						<tr class="list_menu">
							<td width="5%">Tombo</td>
							<td width="20%">Título</td>
							<td width="30%">Autoridades</td>
							<td width="10%">Coleção</td>
							<td width="10%">Responsável</td>
							<td width="10%"></td>

						</tr>
						<?php 
						$idUsuario = $_SESSION['idUsuario'];
						if(isset($_GET['user'])){
							$filtro = " AND acervo_registro.idUsuario = '$idUsuario' ";
						}else{
							$filtro = "";
						}
						$sql_lista = "SELECT acervo_registro.titulo,acervo_registro.id_tabela, acervo_discoteca.tombo, acervo_registro.id_acervo,acervo_registro.idUsuario FROM acervo_registro,acervo_discoteca WHERE acervo_discoteca.planilha = '17' AND acervo_registro.id_tabela = acervo_discoteca.idDisco and acervo_registro.publicado = '1' AND acervo_registro.tabela = '87' $filtro ORDER BY data_catalogacao DESC LIMIT 0,20";
						$query_lista = mysqli_query($con,$sql_lista);
						
						while($x = mysqli_fetch_array($query_lista)){
							$autoridades = retornaAutoridades(idReg($x['id_tabela'],87));
							$colecao = recuperaDados("acervo_acervos",$x['id_acervo'],"id_acervo")
						?>
					<tr>
					<td class="list_description"><?php echo $x['tombo'];?></td>	
					<td class="list_description"><?php echo $x['titulo'];?></td>
					<td class="list_description">
                    <?php 
					if($autoridades['total'] > 0){
						echo $autoridades['string'];
					}
					?>
                    <td class="list_description"><?php echo $colecao['acervo'];?></td>	
                    <td class="list_description"><?php
					 $user = recuperaDados("ig_usuario",$x['idUsuario'],"idUsuario");
					 echo $user['nomeCompleto'];
					 
					 ?></td>	


					<td class="list_description">
					<form action="?perfil=discoteca&p=frm_atualiza_sonoro" method="post">
<input type="hidden" name="idDisco" value="<?php echo $x['id_tabela']?>" />
<input type="hidden" name="valor" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Editar' name='enviar'></form></td>
					<!--<td class="list_description">
					<form action="?perfil=discoteca&p=frm_lista_sonoro" method="post">
<input type="hidden" name="idDisco" value="<?php echo $x['id_tabela']?>" />
<input type="hidden" name="apaga" value="1">
<input type="submit" class="btn btn-theme btn-block" value='apagar' name='apagar'></form></td>-->

					</tr>
						<?php } ?>
						</tbody>

                    </thead>
                    </table>
                    </div>
					                                <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
            <h3>Partituras</h3>
	              
            </div>
 			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
							<td width="5%">Tombo/Antigo</td>
							<td width="20%">Título</td>
							<td width="30%">Autoridades</td>
							<td width="10%">Responsável</td>
							<td width="10%"></td>
						</tr>
						
						<?php 
						$idUsuario = $_SESSION['idUsuario'];
						if(isset($_GET['user'])){
							$filtro = " AND acervo_registro.idUsuario = '$idUsuario' ";
						}else{
							$filtro = "";
						}
						$sql_lista = "SELECT acervo_registro.titulo,acervo_registro.id_tabela,acervo_registro.id_registro, acervo_partituras.tombo, acervo_partituras.tombo_antigo, acervo_registro.idUsuario  FROM acervo_registro,acervo_partituras WHERE acervo_partituras.planilha = '17' AND acervo_registro.id_tabela = acervo_partituras.idDisco and acervo_registro.publicado = '1' AND acervo_registro.tabela = '97' $filtro ORDER BY data_catalogacao DESC LIMIT 0,20";
						$query_lista = mysqli_query($con,$sql_lista);
													//paginacao

						while($x = mysqli_fetch_array($query_lista)){
							$autoridades = retornaAutoridades($x['id_registro']);
						?>
					<tr>
					<td class="list_description"><?php echo $x['tombo'];?> / <?php echo $x['tombo_antigo'];?> </td>
					<td class="list_description"><?php echo $x['titulo'];?></td>
					<td class="list_description">
                    <?php 
					if($autoridades['total'] > 0){
						echo $autoridades['string'];
					}
					?>
                    
                    </td>
 <td class="list_description"><?php
					 $user = recuperaDados("ig_usuario",$x['idUsuario'],"idUsuario");
					 echo $user['nomeCompleto'];
					 
					 ?></td>	
					<td class="list_description">
					<form action="?perfil=discoteca&p=frm_atualiza_partitura" method="post">
<input type="hidden" name="idDisco" value="<?php echo $x['id_tabela']?>" />
<input type="hidden" name="valor" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Editar' name='enviar'></form></td>
				<!--	<td class="list_description">
					<form action="?perfil=discoteca&p=frm_lista_partitura" method="post">
<input type="hidden" name="idDisco" value="<?php echo $x['id_tabela']?>" />
<input type="hidden" name="apaga" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Apagar' name='Apagar'></form></td>-->

					</tr>
						<?php } ?>
						</tbody>
                    </thead>
                    </table>
                                        </div>
                                <div class="form-group">
            <div class="col-md-offset-2 col-md-8">

            </div>
          </div>    	



					                                <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
            <h3>Autoridades</h3>
	              
            </div>
 			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
							<td width="30%">Autoridade</td>
							<td width="20%">Adotado</td>
							<td width="10%"></td>
							<td width="10%"></td>
						</tr>
						
						<?php 
						$sql_lista = "SELECT * FROM acervo_termo WHERE tipo = '1' ORDER BY data_update DESC LIMIT 0,20";
						$query_lista = mysqli_query($con,$sql_lista);

						while($x = mysqli_fetch_array($query_lista)){
						
						?>
					<tr>
					<td class="list_description"><?php echo $x['termo'];?> </td>
					<td class="list_description">
					<?php 
					if($x['adotado'] != 0){
						$adotado = recuperaDados("acervo_termo",$x['adotado'],"id_termo");
						echo $adotado['termo'];
					}
					?>
                    </td>
 <td class="list_description"><?php
					 $user = recuperaDados("ig_usuario",$x['id_usuario'],"idUsuario");
					 echo $user['nomeCompleto'];
					 
					 ?></td>	
					<td class="list_description">
					<form action="?perfil=discoteca&p=frm_atualiza_partitura" method="post">
<input type="hidden" name="idDisco" value="<?php echo $x['id_tabela']?>" />
<input type="hidden" name="valor" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Editar' name='enviar'></form></td>
					<!--<td class="list_description">
					<form action="?perfil=discoteca&p=frm_lista_partitura" method="post">
<input type="hidden" name="idDisco" value="<?php echo $x['id_tabela']?>" />
<input type="hidden" name="apaga" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Apagar' name='Apagar'></form></td>-->

					</tr>
						<?php } ?>
						</tbody>
                    </thead>
                    </table>                    </div>
                                <div class="form-group">
            <div class="col-md-offset-2 col-md-8">

            </div>
          </div>    	

					                                <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
            <h3>Termos</h3>
	              
            </div>
 			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
							<td width="30%">Termo</td>
							<td width="20%">Adotado</td>
							<td width="10%">Tipo</td>
							<td width="10%"></td>
							<td width="10%"></td>

						</tr>
						
						<?php 
						$sql_lista = "SELECT * FROM acervo_termo WHERE tipo IN(".$GLOBALS['acervo_tipo'].") ORDER BY data_update DESC LIMIT 0,20";
						$query_lista = mysqli_query($con,$sql_lista);

						while($x = mysqli_fetch_array($query_lista)){
						
						?>
					<tr>
					<td class="list_description"><?php echo $x['termo'];?> </td>
					<td class="list_description">
					<?php 
					if($x['adotado'] != 0){
						$adotado = recuperaDados("acervo_termo",$x['adotado'],"id_termo");
						echo $adotado['termo'];
					}
					?>
                    
                    </td>
					<td class="list_description">
					<?php 
						$tipo = recuperaDados("acervo_tipo",$x['tipo'],"id_tipo");
						echo $tipo['tipo'];
					
					?>
                     <td class="list_description"><?php
					 $user = recuperaDados("ig_usuario",$x['id_usuario'],"idUsuario");
					 echo $user['nomeCompleto'];
					 
					 ?></td>	
                    
                    </td>

					<td class="list_description">
					<form action="?perfil=discoteca&p=frm_atualiza_partitura" method="post">
<input type="hidden" name="idDisco" value="<?php echo $x['id_tabela']?>" />
<input type="hidden" name="valor" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Editar' name='enviar'></form></td>
					<!--<td class="list_description">
					<form action="?perfil=discoteca&p=frm_lista_partitura" method="post">
<input type="hidden" name="idDisco" value="<?php echo $x['id_tabela']?>" />
<input type="hidden" name="apaga" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Apagar' name='Apagar'></form></td>-->

					</tr>
						<?php } ?>
						</tbody>
                    </thead>
                    </table>                    </div>
                                <div class="form-group">
            <div class="col-md-offset-2 col-md-8">

            </div>
          </div>    





</div>
		</section>
