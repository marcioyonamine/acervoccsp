<?php 
// reseta todas as sessions
if(isset($_SESSION['idDisco'])){
	unset($_SESSION['idDisco']);	
}

if(isset($_SESSION['idFaixa'])){
	unset($_SESSION['idFaixa']);	
}

if(isset($_SESSION['tabela'])){
	unset($_SESSION['tabela']);	
}


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
    

