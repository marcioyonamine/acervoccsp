<?php 

/*
igSmc v0.1 - 2015
ccsplab.org - centro cultural são paulo
*/

// Esta é a página de login do usuário ou de contato com administrador do sistema.

//Imprime erros com o banco


	include "funcoes/funcoesGerais.php";
	require "funcoes/funcoesConecta.php";

if(isset($_POST['usuario'])){

	$usuario = $_POST['usuario'];
	$senha = $_POST['senha'];
	autenticaUsuario($usuario,$senha);	

}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ACERVOS.CCSP - v0.1 - 2016</title>
    <link href="visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="visual/css/style.css" rel="stylesheet" media="screen">
	<link href="visual/color/default.css" rel="stylesheet" media="screen">
	<script src="visual/js/modernizr.custom.js"></script>
</head>


<body>
	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="text-hide">
					 <h2>ACERVOS - CCSP</h2>
					 <p>É preciso ter um login válido. Dúdivas: marcioyonamine@gmail.com </p>
					</div>
				  </div>
			  </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form method="POST" action="index.php"class="form-horizontal" role="form">
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6">
					  <input type="text" name="usuario" class="form-control" id="inputName" placeholder="Usuário">
					</div>
				  
					<div class=" col-md-6">
					  <input type="password" name="senha" class="form-control" id="inputEmail" placeholder="Senha">
					</div>
				  </div>

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					 <button type="submit" class="btn btn-theme btn-lg btn-block">Entrar</button>
					</div>
				  </div>
				</form>
				<br />
                <br />
				<br />
                

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6">
					 <a href="busca/index.php" class="btn btn-theme btn-lg btn-block">Busca</a>
					</div>
				  </div>
				  </div>




	
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  


	 
<?php include "visual/rodape.php" ?>
    


</body>
</html>
