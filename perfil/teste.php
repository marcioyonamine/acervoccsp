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
					$string = "INSTRUMENTAÇÃO: Voz Solista ; Piano ; . ; . ; . ; . ; . ; . ; . ; .";
					$string = str_replace("INSTRUMENTAÇÃO:", "", $string); 
					$string = str_replace(" e ", " ; ", $string); 
					$pieces = explode(";", $string);
					
					
					echo $string."<br />";
					
					for($i = 0; $i < sizeof($pieces); $i++){
						echo trim($pieces[$i])."<br />";
						
					}					



					?>



					</div>
				  </div>
			  </div>
			  
		</div>
	</section>