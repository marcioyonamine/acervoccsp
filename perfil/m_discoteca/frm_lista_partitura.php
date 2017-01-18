

<?php
$con = bancoMysqli();
if(isset($_SESSION['idDisco'])){
	unset($_SESSION['idDisco']);
}
if(isset($_SESSION['idReg'])){
	unset($_SESSION['idReg']);		
}

if(isset($_POST['apaga'])){
	$id = $_POST['idDisco'];
	$sql_apaga = "UPDATE acervo_registro SET publicado = '0' WHERE id_tabela = '$id' AND tabela = '97'";
	$query_apaga = mysqli_query($con,$sql_apaga);
	if($query_apaga){
		$mensagem = "Apagado com sucesso.";
	}else{
		$mensagem = "Erro ao apagar.";
	}
}

 include 'includes/menuPartitura.php';?>
<br />
<br />
<br />
<br />

	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
                <div class="text-hide">
                <h2>Partituras / Matriz</h2>
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
							<td width="30%">Título</td>
							<td width="20%">Autoridades</td>
							<td width="20%"></td>
							<td width="20%"></td>
   							<td>Status</td>
						</tr>
						<?php 
						$sql_lista = "SELECT acervo_registro.titulo,acervo_registro.id_tabela,acervo_registro.id_registro FROM acervo_registro,acervo_partituras WHERE acervo_partituras.planilha = '17' AND acervo_registro.id_tabela = acervo_partituras.idDisco and acervo_registro.publicado = '1' AND acervo_registro.tabela = '97' ORDER BY idDisco DESC";
						$query_lista = mysqli_query($con,$sql_lista);
													//paginacao
	$num01 = mysqli_num_rows($query_lista);
	$total_pagina = 50;	
	if(isset($_GET['n_pag'])){
		$pc = $_GET['n_pag'];	
	}else{
		$pc = "1";	
	}
	$inicio = $pc - 1;
	$inicio = $inicio*$total_pagina;
	$limite = mysqli_query($con,"$sql_lista LIMIT $inicio,$total_pagina");
	$total = $num01;
	
	$tp = $total/$total_pagina;
						while($x = mysqli_fetch_array($limite)){
							$autoridades = retornaAutoridades($x['id_registro']);
						?>
					<tr>
					<td class="list_description"><?php echo $x['titulo'];?></td>
					<td class="list_description">
                    <?php 
					if($autoridades['total'] > 0){
						echo $autoridades['string'];
					}
					?>
                    
                    </td>
					<td class="list_description"></td>
					<td class="list_description">
					<form action="?perfil=discoteca&p=frm_atualiza_partitura" method="post">
<input type="hidden" name="idDisco" value="<?php echo $x['id_tabela']?>" />
<input type="hidden" name="valor" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Editar' name='enviar'></form></td>
					<td class="list_description">
					<form action="?perfil=discoteca&p=frm_lista_partitura" method="post">
<input type="hidden" name="idDisco" value="<?php echo $x['id_tabela']?>" />
<input type="hidden" name="apaga" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Apagar' name='Apagar'></form></td>

					</tr>
						<?php } ?>
						</tbody>
					</table>
                                <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <?php 
				$anterior = $pc - 1;
				$proximo = $pc + 1;
				if($pc > 1){
					echo "<a href='?perfil=discoteca&p=frm_lista_partitura&n_pag=$anterior'><- Anterior</a>";
				}
				echo " | ";
				if($pc < $tp) {
 				 echo " <a href='?perfil=discoteca&p=frm_lista_partitura&n_pag=$proximo'>Próxima -></a>";
 				 }
				?>            
            </div>
          </div>    	
				</div>
			</div>
		</section>
