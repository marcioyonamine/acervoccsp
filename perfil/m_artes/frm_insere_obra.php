<?php
$con = bancoMysqli();
include 'includes/menuObra.php';


?>


	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>Obra de arte</h3>
                    <br />
                    <br />
               </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=artes&p=frm_atualiza_obra" method="post">
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Coleção</strong><br/>
                	  <select class="form-control" id="tipoDocumento" name="colecao" >
					   <?php
						 geraAcervoOpcao(16);
						?>
					  </select>
                      </div>
				  </div>	
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Título</strong><br/>
					  <input type="text" class="form-control" id="tombo" name="titulo"  value="" >
                      </div>
				  </div>	
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Categoria</strong><br/>
					    <select class="form-control" id="tipoDocumento" name="categoria" >
					   <?php
						geraTipoOpcao("cat_artes");
						?> 
                        </select> 
                      </div>
				  </div>
				   <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Tombo:</strong><br/>
					  <input type="text" class="form-control soNumero" id="" name="tombo"  value="" >

					</div>				  
					<div class=" col-md-6"><strong>Tombo provisório:</strong><br/>
					  <input type="text" class="form-control soNumero" id="" name="tombo_provisorio"  value="" >
					</div>
				  </div>

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Descrição:</strong><br/>
					 <textarea name="descricao" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observação Geral:</strong><br/>
					 <textarea name="observacao_geral" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Dúvidas:</strong><br/>
					 <textarea name="duvidas" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                    <input type="hidden" name="cadastraRegistro" value="1" />
 					 <input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				  </div>
				</form>
				  
                

    
	  			</div>
			
				
	  		</div>
			

	  	</div>
	  </section>  
