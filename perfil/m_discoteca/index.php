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
					 <h3>Bem-vindo(a)!</h3>
                     <p>&nbsp;</p>
                     <h2>Módulo Discoteca Oneyda Alvarenga</h2>
                     <p>&nbsp;</p>
                     <p>Navegue pelo menu localizado na área superior a esquerda.</p>
				</div>
			</div>
		</div>
	</div>
</section>
    

