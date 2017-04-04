<?php

if(isset($_GET['evento'])){
	$idEvento = $_GET['evento'];	
}

if(isset($_GET['registro'])){
	
}

?>

	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h3>Teste</h3>
					<?php
					
					/*
					$con = bancoMysqli();
					$sql = "SELECT * FROM igsis_pedido_contratacao WHERE publicado = '1'";
					$query = mysqli_query($con,$sql);
					while($pedido = mysqli_fetch_array($query)){
						$idPedido = $pedido['idPedidoContratacao'];
						echo "O pedido $idPedido tem o estado ".$pedido['estado'].".<br />";
						$txt = atualizaStatus($idPedido);
						echo $txt."<br /><br />";
					}
					*/
					$x = reAnaliticas(1);
					echo "<pre>";
					var_dump($x);					
					echo "</pre>";

					?>



					</div>
				  </div>
			  </div>
			  
		</div>
	</section>