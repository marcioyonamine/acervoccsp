<?php
$con = bancoMysqli();
include 'includes/menuAv.php';


?>


	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>Audiovisual - MATRIZ</h3>
                    <br />
                    <br />
               </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=discoteca&p=frm_atualiza_sonoro" method="post">
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Coleção</strong><br/>
                	  <select class="form-control" id="tipoDocumento" name="colecao" >
					   <?php
						 geraAcervoOpcao(15);
						?>
					  </select>
                      </div>
				  </div>	
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Número do registro:</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="registro"  value="" >

					</div>				  
					<div class=" col-md-6"><strong>Número do tombo:</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="tombo"  value="" >
					</div>
				  </div>
				   <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Ano inicial ou único:</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="ano_inicio"  value="" >

					</div>				  
					<div class=" col-md-6"><strong>Ano Final:</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="ano_final"  value="" >
					</div>
				  </div>
			 
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Duração (em minutos):</strong><br/>
					  <input type="text" class="form-control" id="CCM" name="duracao"  value="" >
					</div>				  
					<div class=" col-md-6"><strong>Padrão de cor:</strong><br/>
					 			                	  <select class="form-control" id="tipoDocumento" name="cromia" >
					   <option></option>

					  <?php
						geraTipoOpcao("cromia");
						?>  
					  </select>
					</div>
				  </div>


                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Local da gravação:</strong><br/>
					                	  <select class="form-control" id="tipoDocumento" name="local" >
					   <option>Selecione o local da gravação</option>

					  <?php
						opcaoTermo(14);;
						?>  
					  </select>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Procedência:</strong><br/>
					                	  <select class="form-control" id="tipoDocumento" name="procedencia" >
					   <option></option>

					  <?php
						geraTipoOpcao("aquisicao");
						?>  
					  </select>
					</div>
				  </div>
				  
				    <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Suporte:</strong><br/>
							           	  <select class="form-control" id="tipoDocumento" name="suporte" >
					   <option></option>

					  <?php
						geraTipoOpcao("av_suporte");
						?>  
					  </select>
					</div>				  
					<div class=" col-md-6"><strong>Sistema de cor:</strong><br/>
					 			                	  <select class="form-control" id="tipoDocumento" name="sistema" >
					   <option></option>

					  <?php
						geraTipoOpcao("av_sistema");
						?>  
					  </select>
					</div>
				  </div>
				  	<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Número de cópias:</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="copias"  value="" >

					</div>				  
					<div class=" col-md-6"><strong>Estado de conservação:</strong><br/>
					 					 			                	  <select class="form-control" id="tipoDocumento" name="conservacao" >
					   <option></option>

					  <?php
						geraTipoOpcao("estado_conservacao");
						?>  
					  </select>
					</div>
				  </div>


				  

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/>
					<h5>Título</h5>
                      </div>
				  </div>
                  
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Título *:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="titulo"  value="" >
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Título Uniforme *:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="titulo_uniforme" value="" >
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Conteúdo:</strong><br/>
					 <textarea name="conteudo" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Notas:</strong><br/>
					 <textarea name="notas" class="form-control" rows="10" placeholder=""></textarea>
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Observações:</strong><br/>
					 <textarea name="obs" class="form-control" rows="10" placeholder=""></textarea>
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
