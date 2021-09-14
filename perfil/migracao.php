<section id="services" class="home-section bg-white">
	<div class="container">
		<div class="row">
			 <div class="col-md-offset-2 col-md-8">
				<div class="section-heading">
                     <h2>Módulo Discoteca Oneyda Alvarenga</h2>
					<p><a href="?perfil=man">Retornar a página inicial</a>
				</div>
			</div>
		</div>
	</div>
</section>



<?php
   @ini_set('display_errors', '1');
	error_reporting(E_ALL); 

include "../funcoes/funcoesGerais.php";
include "../funcoes/funcoesConecta.php";
$con = bancoMysqli();


?>

	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h1>Migração</h1>
					 
					<?php

					
					
					
					
					
					
					
					/*
					$sql = "SELECT * FROM acervo_discoteca WHERE planilha = '18' AND matriz = '0'";
					$query = mysqli_query($con,$sql);
					while($reg = mysqli_fetch_array($query)){
						echo $reg['titulo_disco']." - ". $reg['tombo'];
						switch($reg['tipo_especifico']){
							case 37:
								$c = 7;
							break;

							case 38:
								$c = 9;							
							break;

							case 39:
								$c = 8;							
							break;
							
						}
						$tombo = substr($reg['tombo'],0,$c);
						
						$sql_atua = "SELECT idDisco FROM acervo_discoteca WHERE tombo = '$tombo' AND planilha = '17'";
						$query2 = mysqli_query($con,$sql_atua);
						$reg2 = mysqli_fetch_array($query2);
						$sql_update = "UPDATE acervo_discoteca SET matriz = '".$reg2['idDisco']."' WHERE idDisco ='".$reg['idDisco']."'"; 
						$update = mysqli_query($con,$sql_update);
						if($update == TRUE){
							echo "Atualizado<br />";
						}else{
							echo "Erro<br />";
						}
					}
					*/
					switch($_GET['p']){

						case "abrir_analitica":
						
						$sql = "SELECT DISTINCT matriz FROM acervo_partituras WHERE planilha = '18' AND matriz <> 0";
						$query = mysqli_query($con,$sql);
						while($matriz = mysqli_fetch_array($query)){
							$m = $matriz['matriz'];
							$sql_update = "UPDATE acervo_partituras SET faixas = '2' WHERE idDisco = '$m'";
							$query_update = mysqli_query($con,$sql_update);
							if($query_update){
								echo "Atualizado.  $m <br />";
							}else{
								echo "Erro. <br />";
							}
						}
						
						
						break;
						
						case "instrumentacao":
						echo "<h3>Instrumentação</h3>";

					$con = bancoMysqli();
					$string = "INSTRUMENTAÇÃO: Voz Solista ; Piano ; . ; . ; . ; . ; . ; . ; . ; .";
					$string = str_replace("INSTRUMENTAÇÃO:", "", $string); 
					$string = str_replace(" e ", " ; ", $string); 
					$pieces = explode(";", $string);
					
					
					echo $string."<br />";
					
					for($i = 0; $i < sizeof($pieces); $i++){
						echo trim($pieces[$i])."<br />";
						
					}							
						
						
						break;
						
					
					}

					?>



					</div>
				  </div>
			  </div>
			  
		</div>
	</section>