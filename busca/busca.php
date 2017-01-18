<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CLARA.CCSP - v0.1 - 2016</title>
    <link href="visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="visual/css/style.css" rel="stylesheet" media="screen">
	<link href="visual/color/default.css" rel="stylesheet" media="screen">
	<script src="visual/js/modernizr.custom.js"></script>
</head>


<body>
<?php 

/*
igSmc v0.1 - 2015
ccsplab.org - centro cultural são paulo
*/

// Esta é a página de login do usuário ou de contato com administrador do sistema.

//Imprime erros com o banco


include "funcoes/funcoesGerais.php";
function bancoMysqli(){ 
	$servidor = 'localhost';
	$usuario = 'root';
	$senha = 'lic54eca';
	$banco = 'discoteca';
	$con = mysqli_connect($servidor,$usuario,$senha,$banco); 
	mysqli_set_charset($con,"utf8");
	return $con;
}

if(isset($_POST['pesquisa'])){
	$con = bancoMysqli();
	$pesquisa = $_POST['pesquisa'];	
	$sql_busca = "SELECT * FROM acervo2 WHERE 
	`autoridades` LIKE '%$pesquisa%' OR
	`titulo_disco` LIKE '%$pesquisa%' OR
	`titulo_faixa` LIKE '%$pesquisa%' OR
	`titulo_uniforme` LIKE '%$pesquisa%' OR
	`conteudo` LIKE '%$pesquisa%' OR
	`resumo_titulo` LIKE '%$pesquisa%' OR
	`forma_genero` LIKE '%$pesquisa%' OR
	`meio_expressao` LIKE '%$pesquisa%' OR
	`assunto` LIKE '%$pesquisa%' OR
	`descritores` LIKE '%$pesquisa%'
	ORDER BY `tombo`";
	 $resultado = mysqli_query($con,$sql_busca);
	 $num = mysqli_num_rows($resultado);
	 if($num == 0){
		$mensagem = "Não foram encontrados resultados";	
	}else{
		$mensagem = "Foram encontrados <strong>$num</strong> resultados para busca por <strong>\"$pesquisa\"</strong>";	
	}
	 
?>
	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h3>Discoteca Oneyda Alvarenga</h3>
                    

					</div>
				  </div>
			  </div>
			  
	        <div class="row">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            <h5><?php if(isset($mensagem)){ echo $mensagem; } ?>
                   

            	</div>
             </div>
				<br />             
				<?php 
				while($res = mysqli_fetch_array($resultado)){
				
				?>
	            <div class="form-group">
		            <div class="col-md-offset-2 col-md-8">
               <div class="left">

				<h6><?php echo $res['resumo_titulo']; ?></h6>
								<strong>Localização/Tombo:</strong> <?php echo $res['tombo']; ?><br />
				<strong>Autor:</strong> <?php 
				//echo $res['autoridades']; 
				echo preg_replace("/($pesquisa)/is", "<i><b>\\1</b></i>", $res['autoridades']);
				
				?><br />
				<strong>Tipo:</strong> <?php echo  preg_replace("/($pesquisa)/is", "<i><b>\\1</b></i>", $res['tipo_especifico']); ?><br />
				<strong>Forma/Gênero:</strong> <?php echo  preg_replace("/($pesquisa)/is", "<i><b>\\1</b></i>", $res['forma_genero']); ?><br />
				<strong>Meio de Expressão:</strong> <?php echo  preg_replace("/($pesquisa)/is", "<i><b>\\1</b></i>", $res['meio_expressao']); ?><br />

				<strong>Assuntos/Descritos:</strong> <?php echo  preg_replace("/($pesquisa)/is", "<i><b>\\1</b></i>", $res['assunto']); ?><br />
				<?php echo  preg_replace("/($pesquisa)/is", "<i><b>\\1</b></i>", $res['descritores']); ?><br />
				<strong>Notas:</strong> <?php echo  preg_replace("/($pesquisa)/is", "<i><b>\\1</b></i>", $res['notas']); ?><br /><br /><br />
               </div>
				</div>		            
        	    </div>
        	    <?php 
        	    } ?>
<div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	           <br /><br />            
            </div>
          </div>    

				<div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <a href="?" class="btn btn-theme btn-lg btn-block">Fazer outra busca</a>                
            </div>
          </div>           	    </div>

            </div>
	</section>





<?php }else{ // caso não tenha enviado dados para pesquisa ?>



	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Discoteca Oneyda Alvarenga</h2>
                     <p>Os campos em que ocorrerá a busca são: título, autor, assunto</p>
                     <p>É possível pesquisar por parte da palavra. Deve-se ter pelo menos 3 caracteres para busca.</p>
                    

					</div>
				  </div>
			  </div>
			  
	        <div class="row">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            <h5><?php if(isset($mensagem)){ echo $mensagem; } ?>
                        <form method="POST" action="?" class="form-horizontal" role="form">
            		<label>Busca por palavras</label>
                    
                    
            		<input type="text" name="pesquisa" class="form-control" id="palavras" placeholder="" ><br />

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

            </div>
	</section>

<?php } 

?>


</body>
</html>
