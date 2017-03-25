<?php
$con = bancoMysqli();
include 'includes/menu.php';


?>


	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>Termo</h3>
                    <p>Antes de inserir um novo termo na base, verifique se já não há termo semelhante e adotado <a href="frm_busca_termo">clicando aqui.</a></p>
               </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=discoteca&p=frm_edita_termo" method="post">
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Termo</strong><br/>
					  <input type="text" class="form-control " id="duracao" name="termo"  value="" >
                      </div>
				  </div>	
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Tipo</strong><br/>
                	  <select class="form-control" id="tipoDocumento" name="tipo" >
					   <?php

							geraTipoOpcaoTermo($GLOBALS['acervo_tipo']);

						?>
					  </select>
                      <br /><Br />
                      </div>
				  </div>	

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="insere" value="1" />
 					 <input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				  </div>
				</form>
				  
                

    
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  
