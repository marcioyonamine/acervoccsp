<?php 
$n_faixas = $_GET['f'];

?>
	 <section id="services" class="home-section bg-white">
		<div class="container">
        			  <div class="form-group">
					<h4>Analítica</h4>
					<h3><?php //echo $registro['titulo']; ?></h3>
                    <br />
                    <br />
               </div>
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Resultados</h2>
                    

					</div>
				  </div>
			  </div>
              	<section id="list_items" class="home-section bg-white">
		<div class="container">
<div class="table-responsive list_info">
				<table class="table table-condensed">
					<thead>
						<tr class="list_menu">
                        	<td width="10%">Faixa</td>
							<td>Título</td>
                            <td width="10%">L</td>
                            <td width="10%">F</td>
                            <td width="15%"></td>
                            <td width="15%"></td>
						</tr>
					</thead>
					<tbody>
		
<?php 
for($i = 1; $i <= $n_faixas; $i++){
?>
	<tr>
<td class='list_description'><?php echo $i ?></td>

<td class='list_description'><input type='text'  name="valor<?php echo $i; ?>" id='valor' class='form-control valor' value=""></td>
<td class='list_description'><input type='text'  name="valor<?php echo $i; ?>" id='valor' class='form-control valor' value=""></td>
<td class='list_description'><input type='text'  name="valor<?php echo $i; ?>" id='valor' class='form-control valor' value=""></td>
<td class='list_description'>
			<form method='POST' action='?perfil=contratados&p=lista'>
			<input type='hidden' name='insereJuridica' value='".$descricao['Id_PessoaJuridica']."'>
			<input type ='submit' class='btn btn-theme btn-md btn-block' value='Autoridade'></td></form>
<td class='list_description'>
			<form method='POST' action='?perfil=contratados&p=lista'>
			<input type='hidden' name='insereJuridica' value='".$descricao['Id_PessoaJuridica']."'>
			<input type ='submit' class='btn btn-theme btn-md btn-block' value='Assuntos'></td></form>
</tr>
<?php } ?>
						
					</tbody>
				</table>
                				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="atualizar" value="1" />
                    <input type="hidden" name="idPedidoContratacao" value="" />
					 <input type="submit" alt="" name="GRAVAR" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
                    
				  </div>
			</div>
            		</div>
	</section>
