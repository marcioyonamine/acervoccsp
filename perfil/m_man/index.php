<?php 
// reseta todas as sessions

if (!isset($_SESSION)) {

// server should keep session data for AT LEAST 24 hour
ini_set('session.gc_maxlifetime', 60 * 60 * 24);

// each client should remember their session id for EXACTLY 24 hour
session_set_cookie_params(60 * 60 * 24);
session_start();
}

	$_SESSION['idDisco'] = 0;	
	$_SESSION['idFaixa'] = 0;	
	$_SESSION['idTabela'] = 0;	
	$_SESSION['idReg'] = 0;	
	$_SESSION['idAnalitica'] = 0;


?>


<?php include 'includes/menu.php';?>

<section id="services" class="home-section bg-white">
	<div class="container">
		<div class="row">
			 <div class="col-md-offset-2 col-md-8">
				<div class="section-heading">
                     <h2>Módulo Discoteca Oneyda Alvarenga</h2>
       
				</div>
			</div>
		</div>
	</div>
</section>
 
	<section id="list_items">
		<div class="container">
             <div class="col-md-offset-2 col-md-8">
            </div>
			<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
							<td>Tarefa</td>
							<td>Descrição</td>

						</tr>
					</thead>
					<tbody>
						<tr>
							<td><a href="?perfil=man&p=tarefas&action=partitura">Gera Indexado Partituras</td>
							<td>Varre os registros de partitura para gerar tabela para busca indexada.</td>
						</tr>
						<tr>
							<td><a href="?perfil=man&p=tarefas&action=registro_sonoro">Gera Indexado Registro Sonoro</td>
							<td>Varre os registros de registros sonoros para gerar tabela para busca indexada.</td>
						</tr>
						<tr>
							<td><a href="?perfil=man&p=tarefas&action=limpatabela">Limpa tabela indexado</td>
							<td>Limpa a tabela indexado. Utilize se for gerar uma indexação do zero.</td>
						</tr>					
						<tr>
							<td><a href="?perfil=man&p=migracao&action=termos_partituras">Migração Termos - partituras</td>
							<td>Migra o campo instrumentação, meio de expressão, forma/gênero, descritor geográfico e descritor cronológico da base antiga de partituras para a base nova.</td>
						</tr>
						<tr>
							<td><a href="?perfil=man&p=migracao&action=termos_fonogramas">Migração Termos - partituras</td>
							<td>Migra o campo instrumentação, meio de expressão, forma/gênero, descritor geográfico e descritor cronológico da base antiga de partituras para a base nova.</td>
						</tr>					
						<tr>
							<td><a href="?perfil=man&p=migracao&action=limpa_termos">Limpa termos</td>
							<td>Deleta registros com termos vazios.</td>
						</tr>	

					</tbody>
					</table> 	
				</div>
			</div>
		</section>
 

