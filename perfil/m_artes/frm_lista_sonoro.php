

<?php
$con = bancoMysqli();
// zerar SESSIONS
$_SESSION['idTabela'] = 87;
$_SESSION['idDisco'] = 0;	
$_SESSION['idFaixa'] = 0;	
$_SESSION['idReg'] = 0;	
$_SESSION['idAnalitica'] = 0;




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

if(isset($_POST['duplica'])){
	$dup = duplicarReg($_POST['idReg']);
	$mensagem = $dup['mensagem'];
	
	$reg_ant = recuperaDados("acervo_registro",$_POST['idReg'],"id_registro");
	var_dump($reg_ant);
	$id_ana = reAnaliticas($_POST['idReg']);
	if($id_ana['num'] > 0){
		for($i = 0; $i < $id_ana['num'] ; $i++){
			duplicarReg(idReg($id_ana['idDisco'][$i],$id_ana['idTabela']));
				
		}
		echo "id_tabela ".$reg_ant['id_tabela'];
		$sql_update = "UPDATE acervo_discoteca SET matriz = '".$dup['idDisco']."' WHERE matriz = '".$reg_ant['id_tabela']."' AND idDisco NOT IN(".$id_ana['string'].")";
		echo $sql_update;
		$query_update = mysqli_query($con,$sql_update);
		if($query_update){
			$mensagem .= "<br />Atualizado com sucesso";
			echo  "<br />Atualizado com sucesso";
				
		}else{
			$mensagem .= "<br />Erro";	
			echo "<br />Erro";	
		}	
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
				<?php if(isset($mensagem)){echo $mensagem;} ?>
	                <h5>Por ordem decrescente de data de início</h5>
					<?php
					if($filtro == "user")
					{ ?>
						<h5><a href="?perfil=discoteca&p=frm_lista_sonoro">Sem filtro</a></h5>
					<?php 
					}
					else
					{ ?>
						<h5><a href="?perfil=discoteca&p=frm_lista_sonoro&user=<?php echo $_SESSION['idUsuario'] ?>">Mostrar os registros editados por <?php echo $_SESSION['nomeCompleto']; ?></a></h5>
			  <?php } ?>	
					</div>
            </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed"><script type=text/javascript language=JavaScript src=../js/find2.js> </script>
					<thead>
						<tr class="list_menu">
   							<td width="3%"></td>
							<td width="5%">Tombo</td>
							<td width="20%">Título</td>
							<td width="30%">Autoridades</td>
							<td width="10%">Coleção</td>
							<td width="10%"></td>
							<td width="10%"></td>
   							<td width="10%"></td>

						</tr>
						<?php 
						$idUsuario = $_SESSION['idUsuario'];
						if(isset($_GET['user'])){
							$filtro = " AND acervo_registro.idUsuario = '$idUsuario' ";
						}else{
							$filtro = "";
						}
						$sql_lista = "SELECT acervo_registro.titulo,acervo_registro.id_tabela, acervo_discoteca.tombo, acervo_registro.id_acervo, acervo_discoteca.fim FROM acervo_registro,acervo_discoteca WHERE acervo_discoteca.planilha = '17' AND acervo_registro.id_tabela = acervo_discoteca.idDisco and acervo_registro.publicado = '1' AND acervo_registro.tabela = '87' $filtro ORDER BY acervo_registro.data_catalogacao DESC";
						$query_lista = mysqli_query($con,$sql_lista);
						$total_pagina = 50;	
						if(isset($_GET['n_pag'])){
							$pc = $_GET['n_pag'];	
						}else{
							$pc = "1";	
						}
						$inicio = $pc - 1;
						$inicio = $inicio*$total_pagina;
						$limite = mysqli_query($con,"$sql_lista LIMIT $inicio,$total_pagina");
						$total = mysqli_num_rows($query_lista);
	
						$tp = $total/$total_pagina;
						while($x = mysqli_fetch_array($limite)){
							$autoridades = retornaAutoridades(idReg($x['id_tabela'],87));
							$colecao = recuperaDados("acervo_acervos",$x['id_acervo'],"id_acervo")
						?>
					<tr>
                    <td class="list_description"><?php if($x['fim'] == 1){echo "OK"; }?></td>
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
<input type="submit" class="btn btn-theme btn-block" value='apagar' name='apagar'></form></td>

					<td class="list_description">
                   	<form action="?perfil=discoteca&p=frm_lista_sonoro" method="post">
<input type="hidden" name="idReg" value="<?php echo idReg($x['id_tabela'],$_SESSION['idTabela']); ?>" />
<input type="hidden" name="duplica" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Duplicar' name='apagar'></form></td>

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
					echo "<a href='?perfil=discoteca&p=frm_lista_sonoro&n_pag=$anterior'><- Anterior</a>";
				}
				echo " | ";
				if($pc < $tp) {
 				 echo " <a href='?perfil=discoteca&p=frm_lista_sonoro&n_pag=$proximo'>Próxima -></a>";
 				 }
				?>            
            </div>
          </div>   
			</div>
		</section>
