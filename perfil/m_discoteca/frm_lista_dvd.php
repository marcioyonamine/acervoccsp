

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
	$sql_apaga = "UPDATE acervo_registro SET publicado = '0' WHERE id_registro = '$id' AND tabela = '87'";
	$query_apaga = mysqli_query($con,$sql_apaga);
	if($query_apaga){
		$mensagem = "Apagado com sucesso.";
	}else{
		$mensagem = "Erro ao apagar.";
	}
}

 include 'includes/menuSonoro.php';?>
<br />
<br />
<br />
<br />

	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
                <h2>Registros Sonoros / Matriz</h2>
	                <h5>Por ordem decrescente de data de início</h5>
					<?php
					if($ordem == "dataEnvio")
					{ ?>
						<h5><a href="?perfil=producao&p=lista&order=dataInicio">Ordenar por período de realização</a></h5>
					<?php 
					}
					else
					{ ?>
						<h5><a href="?perfil=producao&p=lista&order=dataEnvio">Ordenar por envio</a></h5>
			  <?php } ?>	
					</div>
            </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
							<td width="5%">Tombo</td>
							<td width="20%">Título</td>
							<td width="30%">Autoridades</td>
							<td width="10%">Coleção</td>
							<td width="10%"></td>
							<td width="10%"></td>

						</tr>
						<?php 
						$sql_lista = "SELECT acervo_registro.titulo,acervo_registro.id_tabela, acervo_discoteca.tombo, acervo_registro.id_acervo FROM acervo_registro,acervo_discoteca WHERE acervo_discoteca.planilha = '17' AND acervo_registro.id_tabela = acervo_discoteca.idDisco and acervo_registro.publicado = '1' AND acervo_registro.tabela = '87' ORDER BY acervo_discoteca.tombo DESC";
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
                    </td>

					<td class="list_description">
					<form action="?perfil=discoteca&p=frm_atualiza_sonoro" method="post">
<input type="hidden" name="idDisco" value="<?php echo $x['id_tabela']?>" />
<input type="hidden" name="valor" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Editar' name='enviar'></form></td>
					<td class="list_description">
					<form action="?perfil=discoteca&p=frm_lista_sonoro" method="post">
<input type="hidden" name="idDisco" value="<?php echo $x['id_tabela']?>" />
<input type="hidden" name="apaga" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Apagar' name='Apagar'></form></td>

					</tr>
						<?php } ?>
						</tbody>
					</table> 	
				</div>
			</div>
		</section>
