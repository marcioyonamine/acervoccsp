
<?php 
$con = bancoMysqli();
$idDisco = $_SESSION['idDisco'];
$_SESSION['idReg'] = idReg($_SESSION['idDisco'],$_SESSION['idTabela']);
$disco = recuperaDados("acervo_discoteca",$idDisco,"idDisco");
$registro = recuperaDados("acervo_registro",$idDisco,"id_tabela");

if(isset($_POST['apagar'])){
	$idApagar = $_POST['apagar'];
	$sql_registro =	"UPDATE acervo_registro SET publicado = '0' WHERE id_tabela = '$idApagar' AND tabela = '87'";
	$query_registro = mysqli_query($con,$sql_registro);
	if($query_registro){
		$mensagem = "Apagado com sucesso.";	
	}else{
		$mensagem = "Erro (1).";	
	}
}


if(isset($_POST['duplicar'])){
	$id = idReg($_POST['duplicar'],87);
	$dup = duplicarReg($id);
	$mensagem = $dup['mensagem'];	
}

$sql_faixas = "SELECT * FROM acervo_discoteca WHERE matriz = $idDisco AND idDisco IN(SELECT id_tabela FROM acervo_registro WHERE tabela = 87 AND publicado = '1' ) ORDER BY lado, faixa";
$query_faixas = mysqli_query($con,$sql_faixas);
$num_faixas = mysqli_num_rows($query_faixas);

if(isset($_GET['pag'])){
	$pag = $_GET['pag'];	
}else{
	$pag = "inicio";
}
include 'includes/menuFaixa.php';

switch($pag){
case "inicio":


$_SESSION['idAnalitica'] = 0;




	if(isset($_SESSION['idFaixa'])){
		unset($_SESSION['idFaixa']);
	}
	
?>
	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					<h3>REGISTRO SONORO - ANALÍTICA</h3>
                     <p>Você está inserindo faixas para a Matriz <strong><?php  echo $registro['titulo']; ?></strong></p>
                    
                     <p><?php if(isset($mensagem)){ echo $mensagem; } ?></p>
<p></p>

					</div>
				  </div>
			  </div>
              	<section id="list_items" class="home-section bg-white">
			<div class="table-responsive list_info">
            <?php 
			if($num_faixas >  0){
			?>
				<table class="table table-condensed">
					<thead>
						<tr class='list_menu'>
						<td>Faixa</td>
						<td>Título</td>
   						<td>Autoridades</td>
							<td width="10%"></td>
  							<td width="10%"></td>
							<td width="10%"></td>
						</tr>
					</thead>
                    					<tbody>
				<?php while($fax = mysqli_fetch_array($query_faixas)){ ?>
					<tr>
					<td class='list_description'><?php echo $fax['lado']." - ".$fax['faixa'] ?></td>
					<td class='list_description'><?php echo $fax['titulo_disco'] ?></td>
					<td class='list_description'>
					<?php 
					$autoridades = retornaAutoridades(idReg($fax['idDisco'],87));
					
					
					if($autoridades['total'] > 0){
						echo $autoridades['string'];	
					}else{
						
						$autoridades_matriz = retornaAutoridades(idReg($disco['idDisco'],87));
						echo "Matriz: ".$autoridades_matriz['string'];
					} 
					?>
                    </td>


						<td class='list_description'>
						<form method='POST' action='?perfil=discoteca&p=frm_analiticas_sonoro&pag=edita'>
						<input type='hidden' name='idFaixa' value='<?php echo $fax['idDisco']; ?>'>
						<input type ='submit' class='btn btn-theme btn-sm btn-block' value='editar'></form></td>
       					<td class='list_description'>
						<form method='POST' action='?perfil=discoteca&p=frm_analiticas_sonoro'>
						<input type='hidden' name='apagar' value='<?php echo $fax['idDisco']; ?>'>
						<input type ='submit' class='btn btn-theme btn-sm btn-block' value='apagar'></form></td>

       					<td class='list_description'>
						<form method='POST' action='?perfil=discoteca&p=frm_analiticas_sonoro'>
						<input type='hidden' name='duplicar' value='<?php echo $fax['idDisco']; ?>'>
						<input type ='submit' class='btn btn-theme btn-sm btn-block' value='Duplicar'></form></td>

					</tr>
                   <?php } ?>
					</tbody>
				</table>
                
                <?php }else{  ?>
                <h5> Não há faixa cadastrada. </h5>

                <?php } ?>
   <div class="form-group">
            <div class="col-md-offset-2 col-md-8"><br /><br />
	            <a href="?perfil=discoteca&p=frm_analiticas_sonoro&pag=insere" class="btn btn-theme btn-lg btn-block">Inserir faixa</a>
            </div>
          </div>
             	  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
          <br /><br />
					</div>
				  </div>
   				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
 <a href="?perfil=discoteca&p=frm_atualiza_sonoro" class="btn btn-theme btn-block" >Voltar a Matriz</a>
					</div>
				  </div>	


		  </div>
        </div>
	</section>
    
    <?php
	break;  
	case "insere":
	if(isset($_SESSION['idFaixa'])){
		unset($_SESSION['idFaixa']);
	}
	?>
    	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>REGISTRO SONORO - ANALÍTICA</h3>
                    <p>Você está inserindo faixas para a Matriz <strong><?php  echo $registro['titulo']; ?></strong></p>
                    <br />
                    <br />
               </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=discoteca&p=frm_analiticas_sonoro&pag=edita" method="post">
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Lado:</strong><br/>
					    <input type="text" class="form-control" id="Nome" name="lado"  value="" >

					</div>				  
					<div class=" col-md-6"><strong>Número da Faixa:</strong><br/>
                	    <input type="text" class="form-control" id="Nome" name="faixa"  value="" >
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Título da faixa*:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="titulo"  value="" >
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Título Uniforme *:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="titulo_uniforme" value="" >
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Notas:</strong><br/>
					 <textarea name="notas" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observações:</strong><br/>
					 <textarea name="obs" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="cadastraRegistro" value="1" />
 					 <input type="submit" value="inserir" class="btn btn-theme btn-lg btn-block">
					</div>
				  </div>
				</form>
				  
                

    
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  

    <?php
	break;  
	case "edita":
	$_SESSION['idReg'] = idReg($_SESSION['idFaixa'],$_SESSION['idTabela']);
	
	
	if(isset($_POST['cadastraRegistro']) OR isset($_POST['atualizaRegistro'])){
	$planilha = 18;
		$hoje = date("Y-m-d H:i:s");
$lado = $_POST['lado'];
$faixa = $_POST['faixa'];
$titulo = addslashes($_POST['titulo']);
$titulo_uniforme = addslashes($_POST['titulo_uniforme']);
$conteudo = addslashes($_POST['conteudo']);
$notas = addslashes($_POST['notas']);
$obs = addslashes($_POST['obs']);
$publicado = 1;
$catalogador = $_SESSION['idUsuario'];
$colecao = $registro['id_acervo'];
$matriz = $_SESSION['idDisco'];
}
if(isset($_POST['cadastraRegistro'])){

	$sql_insere = "INSERT INTO `acervo_discoteca` 
	(`planilha`, `catalogador`, `lado`, `faixa`, `matriz`,  `titulo_disco`, `titulo_uniforme`, `conteudo`, `notas`, `obs`) 
	VALUES ('$planilha', '$catalogador', '$lado', '$faixa', '$matriz',   '$titulo', '$titulo_uniforme', '$conteudo', '$notas', '$obs');";
	$query_insere = mysqli_query($con,$sql_insere);
	if($query_insere){
		$ultimo = mysqli_insert_id($con);
		$sql_insert_registro = "INSERT INTO `acervo`.`acervo_registro` (`id_registro`, `titulo`, `id_autoridade`, `id_acervo`, `id_tabela`, `publicado`, `tabela`, `data_catalogacao`,`idUsuario`) 
		VALUES (NULL, '$titulo', '', '$colecao', '$ultimo', '1','87','$hoje','$catalogador')";
		$query_insert_registro = mysqli_query($con,$sql_insert_registro);
		if($query_insert_registro){
			$mensagem = "Inserido com sucesso(1)";
		}else{
			$mensagem = "Erro ao inserir(2)";	
		}
	}else{
		$mensagem = "Erro ao inserir(3)";	
	}
$_SESSION['idFaixa'] = $ultimo;
}

if(isset($_POST['atualizaRegistro'])){
	$ultimo = $_POST['idFaixa'];
	$sql_atualiza = "UPDATE `acervo_discoteca` SET 
	`lado` = '$lado', 
	`faixa` = '$faixa', 
	`titulo_disco` = '$titulo', 
	`titulo_uniforme` =  '$titulo_uniforme', 
	`conteudo` = '$conteudo', 
	`notas` = '$notas', 
	`obs` = '$obs' 
	 WHERE `idDisco` = '$ultimo'";
	$query_atualiza = mysqli_query($con,$sql_atualiza);
	if($query_atualiza){
		$sql_update_registro = "UPDATE `acervo_registro` SET
		`titulo` = '$titulo',
		`idUsuario` = '$catalogador',
		`data_catalogacao` = '$hoje'
		WHERE `id_tabela` = '$ultimo' AND `tabela` = '87'";
		$query_update_registro = mysqli_query($con,$sql_update_registro);
		if($query_update_registro){
			$mensagem = "Atualizado com sucesso(1)";
		}else{
			$mensagem = "Erro ao atualizar(2)";	
		}
	}else{
		$mensagem = "Erro ao atualizar(3)";	
	}
}

if(!isset($ultimo)){
	if(isset($_SESSION['idFaixa'])){
		$ultimo = $_SESSION['idFaixa'];
	}else{
		$ultimo = $_POST['idFaixa'];	
	}
	$_SESSION['idFaixa'] = $ultimo;
}
$faixa = recuperaDados("acervo_discoteca",$ultimo,"idDisco");
$regfaixa = recuperaDados("acervo_registro",$ultimo,"id_tabela");

	
	?>
        	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>REGISTRO SONORO - ANALÍTICA</h3>
                    <p>Você está inserindo faixas para a Matriz <strong><?php  echo $registro['titulo']; ?></strong></p>
                    <p>Faixa <?php  echo $regfaixa['titulo']; ?>
					<p><?php if(isset($mensagem)){echo $mensagem;}?></p>
                    <br />
                    <br />
               </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=discoteca&p=frm_analiticas_sonoro&pag=edita" method="post">
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Lado:</strong><br/>
					    <input type="text" class="form-control" id="Nome" name="lado"  value="<?php  echo $faixa['lado']; ?>" >

					</div>				  
					<div class=" col-md-6"><strong>Número da Faixa:</strong><br/>
                	    <input type="text" class="form-control" id="Nome" name="faixa"  value="<?php  echo $faixa['faixa']; ?>" >
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Título da faixa*:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="titulo"  value="<?php  echo $regfaixa['titulo']; ?>" >
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Título Uniforme *:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="titulo_uniforme" value="<?php  echo $faixa['titulo_uniforme']; ?>" >
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Notas:</strong><br/>
					 <textarea name="notas" class="form-control" rows="10" placeholder=""><?php  echo $faixa['notas']; ?></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observações:</strong><br/>
					 <textarea name="obs" class="form-control" rows="10" placeholder=""><?php  echo $faixa['obs']; ?></textarea>
					</div>
				  </div>

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="atualizaRegistro" value="1" />
                    <input type="hidden" name="idFaixa" value="<?php echo $_POST['idFaixa']?>" />
 					 <input type="submit" value="Atualizar" class="btn btn-theme btn-lg btn-block">
					</div>
				  </div>
				</form>
                  				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <br />
					</div>
				  </div>	 
   				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
 <a href="?perfil=discoteca&p=frm_arquivos" class="btn btn-theme btn-block"  >Arquivos / Anexos</a>
					</div>
				  </div>	
             	  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
          <br /><br />
					</div>
				  </div>
   				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
 <a href="?perfil=discoteca&p=frm_analiticas_sonoro" class="btn btn-theme btn-block"  >Voltar para lista</a>
					</div>
				  </div>	
             	  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
          <br /><br />
					</div>
				  </div>
   				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
 <a href="?perfil=discoteca&p=frm_analiticas_sonoro&pag=insere" class="btn btn-theme btn-block" >Inserir outra faixa</a>
					</div>
				  </div>	
             	  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
          <br /><br />
					</div>
				  </div>
   				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
 <a href="?perfil=discoteca&p=frm_termos" class="btn btn-theme btn-block"  >Autoridades / Assuntos</a>
					</div>
				  </div>	
                

    
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  
    
    <?php 
	break;
	} 
	?>