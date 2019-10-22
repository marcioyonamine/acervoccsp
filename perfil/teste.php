<?php
   @ini_set('display_errors', '1');
	error_reporting(E_ALL); 

include "../funcoes/funcoesGerais.php";
include "../funcoes/funcoesConecta.php";

?>

	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h3>Teste</h3>
					<?php
					$con = bancoMysqli();
					var_dump(idReg($_GET['disco'],$_GET['tabela']));
					

					?>



					</div>
				  </div>
			  </div>
			  
		</div>
	</section>