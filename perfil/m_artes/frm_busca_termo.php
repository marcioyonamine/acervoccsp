<?php  
include 'includes/menu.php';
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
if(isset($_POST['pesquisar'])){ // 0
	$titulo = trim($_POST['titulo']);
	if($_POST['tipo'] == 0){ //1

		$filtro = "AND tipo IN(".$GLOBALS['acervo_tipo'].")";	
	}else{ //1
		$filtro = "AND tipo = '".$_POST['tipo']."' ";
		$tipo = $_POST['tipo'];
	} //1
	if($titulo == "" AND $tombo == "" AND $tipo == 0 AND $colecao == 0){  //2 ?>
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

							<form method="POST" action="?perfil=discoteca&p=frm_busca_termo" class="form-horizontal" role="form">
						<label>Termo</label>
						<input type="text" name="titulo" class="form-control" id="titulo" placeholder="Insira o titulo por parte dele" ><br />
						
						<br />
						 <label>Tipo</label>
						<select class="form-control" name="tipo" id="inputSubject" >
						<option value="0"></option>		                
						  <?php
							geraTipoOpcaoTermo($GLOBALS['acervo_tipo']);
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
	}else{ //2
	$sql_busca = "SELECT * FROM acervo_termo WHERE 
		termo LIKE '%$titulo%' $filtro 
		ORDER BY termo ASC 
		";
	$query_busca = mysqli_query($con,$sql_busca);
	$num = mysqli_num_rows($query_busca);
	echo $sql_busca;

?>
<br />
<br />
	<section id="list_items">
		<div class="container">
			 <h3>Resultado da busca</h3>
             <h5>Foram encontrados <?php echo $num; ?> registros.</h5>
                             <?php 		//echo $GLOBALS['acervo_tipo'];?>
                             
                             
           <?php if($num > 0){?>                  
               <h5><a href="?perfil=discoteca&p=frm_busca_termo">Fazer outra busca</a></h5>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td width="30%">Termo</td>
							<td width="20%">Adotado</td>
							<td width="20%">Tipo</td>
							<td width="10%"></td>
							<td width="10%"></td>
						</tr>
						
					</thead>
					<tbody>

<?php 

						while($y = mysqli_fetch_array($query_busca)){
						?>
					<tr>
					<td class="list_description"><?php echo $y['termo'];?> </td>
					<td class="list_description">
                     <?php 
					if($y['adotado'] != 0){
						$adotado = recuperaDados("acervo_termo",$y['adotado'],"id_termo");
						echo $adotado['termo'];
					}
					?>
                    </td>
					<td class="list_description">
                    <?php 
					$rectipo = recuperaDados("acervo_tipo",$y['tipo'],"id_tipo");
					echo $rectipo['tipo'];
					?>
                    
                    </td>
					<td class="list_description">
					<form action="?perfil=discoteca&p=frm_edita_termo" method="post">
<input type="hidden" name="idTermo" value="<?php echo $y['id_termo']?>" />
<input type="submit" class="btn btn-theme btn-block" value='Editar' name='enviar'></form></td>
					<td class="list_description">
					<form action="?perfil=discoteca&p=frm_busca_termo" method="post">
<input type="hidden" name="idTermo" value="<?php echo $y['id_termo']?>" />
<input type="hidden" name="apaga" value="1">
<input type="submit" class="btn btn-theme btn-block" value='Apagar' name='Apagar'></form></td>

					</tr>
						<?php } ?>

	
					
					</tbody>
				</table>
                </div>
	
            <?php 
			if($_SESSION['perfil'] == 1){
				//var_dump($x);	
			}
			?>

        <?php }else{ //2 ?>
			<p>O termo <?php echo $titulo ?> não existe na base. Gostaria de incluí-lo?</p>
            <form action="?perfil=discoteca&p=frm_edita_termo" method="post">
<input type="hidden" name="termo_insere" value="<?php echo $titulo; ?>" />
<input type="hidden" name="tipo_insere" value="<?php echo $tipo; ?>" />
<input type="submit" class="btn btn-theme btn-group-sm" value='Inserir termo' name='enviar'></form>
					

        <?php } 
		   } //2
			?>
            <br /><br />
		</div>
	</section>


<?php

}else{
if(isset($_POST['apagar'])){
	$idTermo = $_POST['idTermo'];
	
}

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
				<h5>É preciso que o título ou o número de tombo seja inserido.</h5>
							<form method="POST" action="?perfil=discoteca&p=frm_busca_termo" class="form-horizontal" role="form">
						<label>Termo</label>
						<input type="text" name="titulo" class="form-control" id="titulo" placeholder="Insira o titulo por parte dele" ><br />
						
						<br />
						 <label>Tipo</label>
						<select class="form-control" name="tipo" id="inputSubject" >
						<option value="0">Todos os tipos</option>		                
						  <?php
							geraTipoOpcaoTermo($GLOBALS['acervo_tipo']);
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
case 'periodo': //
?>
<?php


	if($_POST['inicio'] == "" OR $_POST['final'] == ""){ ?>
	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Busca por pedido</h2>
                    <p>É preciso ao menos um critério de busca ou você pesquisou por um pedido inexistente. Tente novamente.</p>

					</div>
				  </div>
			  </div>
			  
	        <div class="row">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            <h5><?php if(isset($mensagem)){ echo $mensagem; } ?>
                      <form method="POST" action="?perfil=contratos&p=frm_busca" class="form-horizontal" role="form">
            		<label>Código do Pedido</label>
            		<input type="text" name="id" class="form-control" id="palavras" placeholder="Insira o Código do Pedido" ><br />
            		<label>Objeto/Evento</label>
            		<input type="text" name="evento" class="form-control" id="palavras" placeholder="Insira o objeto" ><br />

     
            			          
    	        <label>Fiscal, suplente ou usuário que cadastrou o evento</label>
					<select class="form-control" name="fiscal" id="inputSubject" >
					<option value="0"></option>	
					<?php echo opcaoUsuario($_SESSION['idInstituicao'],"") ?>
                    </select>
                    <br />
                     <label>Tipo de evento</label>
                    <select class="form-control" name="tipo" id="inputSubject" >
					<option value="0"></option>		                
						<?php echo geraOpcao("ig_tipo_evento","","") ?>
                    </select>	
                    <br />
                    <label>Instituição</label>
                    <select class="form-control" name="instituicao" id="inputSubject" >
                   <option value="0"></option>
						<?php echo geraOpcao("ig_instituicao","","") ?>
                    </select>		
                    <br />
                    <label>Status do pedido</label>
                    <select class="form-control" name="estado" id="inputSubject" >
                   <option value='0'></option>


		<?php echo geraOpcao("sis_estado","","") ?>
                    </select>	
                    
                    <label>Operador do Contrato</label>
                    <select class="form-control" name="operador" id="inputSubject" >
                   <option value='0'></option>
	<?php  geraOpcaoContrato(""); ?>
                    </select>	
     <label>Tipo de Relação Jurídica</label>
                    <select class="form-control" name="juridico" id="inputSubject" >
                   <option value='0'></option>
	<?php  geraOpcao("ig_modalidade","",""); ?>
                    </select>	


            	</div>
             </div>
				<br />             
	            <div class="form-group">
		            <div class="col-md-offset-2 col-md-8">
                	<input type="hidden" name="pesquisar" value="1" />
    		        <input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
                    </form>
        	    	</div>
        	    </div>
                
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Busca por periodo</h2>
                                        <p>O sistema varre os pedidos de contratação e informa quais terão início no período da busca.<br />
                    É preciso definir o início e o fim do período a se fazer a busca. <br /> Não funciona combinado com a busca acima.</p>


					</div>
				  </div>
			  </div>
			  
	        <div class="row">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            <h5><?php if(isset($mensagem)){ echo $mensagem; } ?>
            <form method="POST" action="?perfil=contratos&p=frm_busca&b=periodo" class="form-horizontal" role="form">
                <div class="form-group">
                	<div class="col-md-offset-2 col-md-6">
               			 <label>Data início *</label>
                		<input type="text" name="inicio" class="form-control" id="datepicker01" placeholder="">
               		 </div>
                	<div class=" col-md-6">
                		<label>Data encerramento *</label>
                		<input type="text" name="final" class="form-control" id="datepicker02"  placeholder="">
               		</div>
                </div>
                            

            	</div>
             </div>
				<br />             
	            <div class="form-group">
		            <div class="col-md-offset-2 col-md-8">
                	<input type="hidden" name="periodo" value="1" />
    		        <input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
                    </form>
        	    	</div>
        	    </div>


            </div>
	</section>
<?php
		
	}else{ // Caso as datas seja válidas
		$inicio = exibirDataMysql($_POST['inicio']);
		$final = exibirDataMysql($_POST['final']);	
		$con = bancoMysqli();
		$sql_evento = "SELECT DISTINCT idEvento FROM ig_ocorrencia WHERE dataInicio >= '$inicio' AND dataInicio <= '$final' AND publicado = '1' ORDER BY dataInicio ASC ";
		$query_evento = mysqli_query($con,$sql_evento);
		$i = 0;
		while($evento = mysqli_fetch_array($query_evento)){
			
			$idEvento = $evento['idEvento'];
			$evento = recuperaDados("ig_evento",$evento['idEvento'],"idEvento");
			if($evento['dataEnvio'] != NULL){	
			$sql_existe = "SELECT idPedidoContratacao,idEvento,estado FROM igsis_pedido_contratacao WHERE idEvento = '$idEvento' AND publicado = '1'";
			$query_existe = mysqli_query($con, $sql_existe);
			if(mysqli_num_rows($query_existe) > 0)
			{
//$tabela,$idEvento,$campo
			$usuario = recuperaDados("ig_usuario",$evento['idUsuario'],"idUsuario");
			$instituicao = recuperaDados("ig_instituicao",$evento['idInstituicao'],"idInstituicao");
			$fiscal = recuperaUsuario($evento['idResponsavel']);
			$suplente = recuperaUsuario($evento['suplente']);
			$protocolo = ""; //recuperaDados("sis_protocolo",$pedido['idEvento'],"idEvento");

			$sql_pedido = "SELECT * FROM igsis_pedido_contratacao WHERE publicado = '1' AND idEvento = '$idEvento'";
			$query_pedido = mysqli_query($con,$sql_pedido);
			while($ped = mysqli_fetch_array($query_pedido)){
				
			$pedido = recuperaDados("igsis_pedido_contratacao",$ped['idPedidoContratacao'],"idEvento");
			if($pedido['estado'] != NULL){
			$local = listaLocais($pedido['idEvento']);
			$periodo = retornaPeriodo($pedido['idEvento']);
			$duracao = retornaDuracao($pedido['idEvento']);
			$pessoa = recuperaPessoa($pedido['idPessoa'],$pedido['tipoPessoa']);
			$operador = recuperaUsuario($pedido['idContratos']);
			if($pedido['parcelas'] > 1){
				$valorTotal = somaParcela($pedido['idPedidoContratacao'],$pedido['parcelas']);
				$formaPagamento = txtParcelas($pedido['idPedidoContratacao'],$pedido['parcelas']);	
			}else{
				$valorTotal = $pedido['valor'];
				$formaPagamento = $pedido['formaPagamento'];
			}

			$x[$i]['id']= $pedido['idPedidoContratacao'];
			$x[$i]['objeto'] = retornaTipo($evento['ig_tipo_evento_idTipoEvento'])." - ".$evento['nomeEvento'];
			if($pedido['tipoPessoa'] == 1){
				$pessoa = recuperaDados("sis_pessoa_fisica",$pedido['idPessoa'],"Id_PessoaFisica");
				$x[$i]['proponente'] = $pessoa['Nome'];
				$x[$i]['tipo'] = "Física";
			}else{
				$pessoa = recuperaDados("sis_pessoa_juridica",$pedido['idPessoa'],"Id_PessoaJuridica");
				$x[$i]['proponente'] = $pessoa['RazaoSocial'];
				$x[$i]['tipo'] = "Jurídica";

			}
			$x[$i]['local'] = substr($local,1);
			$x[$i]['instituicao'] = $instituicao['sigla'];
			$x[$i]['periodo'] = $periodo;
			$x[$i]['status'] = $pedido['estado'];	
			$x[$i]['operador'] = $operador['nomeCompleto'];		
			$i++;
			}
			}
			}
		}
		}
		$x['num'] = $i;
		



$mensagem = "Foram encontradas ".$x['num']." pedido(s) de contratação.";
?>
<br />
<br />
	<section id="list_items">
		<div class="container">
			 <h3>Resultado da busca</3>
             <h5>Foram encontrados <?php echo $x['num']; ?> pedidos de contratação.</h5>
             <h5><a href="?perfil=contratos&p=frm_busca">Fazer outra busca</a></h5>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Codigo do Pedido</td>
							<td>Proponente</td>
							<td>Tipo</td>
							<td>Objeto</td>
							<td width="20%">Local</td>
                            <td>Instituição</td>
							<td>Periodo</td>
							<td>Status</td>
   							<td>Operador</td>
						</tr>
					</thead>
					<tbody>
<?php

$data=date('Y');
for($h = 0; $h < $x['num']; $h++)
 {
	 $status = recuperaDados("sis_estado",$x[$h]['status'],"idEstado");
	if($x[$h]['tipo'] == 'Física'){
		echo "<tr><td class='lista'> <a href='?perfil=contratos&p=frm_edita_propostapf&id_ped=".$x[$h]['id']."'>".$x[$h]['id']."</a></td>";
	}else{
		echo "<tr><td class='lista'> <a href='?perfil=contratos&p=frm_edita_propostapj&id_ped=".$x[$h]['id']."'>".$x[$h]['id']."</a></td>";
		
	}
	echo '<td class="list_description">'.$x[$h]['proponente'].					'</td> ';
	echo '<td class="list_description">'.$x[$h]['tipo'].					'</td> ';
	echo '<td class="list_description">'.$x[$h]['objeto'].						'</td> ';
	echo '<td class="list_description">'.$x[$h]['local'].				'</td> ';
	echo '<td class="list_description">'.$x[$h]['instituicao'].				'</td> ';
	echo '<td class="list_description">'.$x[$h]['periodo'].						'</td> ';
	echo '<td class="list_description">'.$status['estado'].						'</td> ';
	echo '<td class="list_description">'.$x[$h]['operador'].						'</td> </tr>';

	}
?>
	
					
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<?php
}


break;

} // fim da switch

 ?>





