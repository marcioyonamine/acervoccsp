<?php
$con = bancoMysqli();
include 'includes/menuPartitura.php';


?>


	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>Partitura - MATRIZ</h3>
                    <br />
                    <br />
               </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=discoteca&p=frm_atualiza_partitura" method="post">
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Coleção</strong><br/>
                	  <select class="form-control" id="tipoDocumento" name="colecao" >
					   <?php
						 geraAcervoOpcao(7);
						?>
					  </select>
                      </div>
				  </div>	
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Tombo / Localização</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="tombo"  value="" >
                      </div>
				  </div>	
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Tombo Antigo</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="tombo_antigo"  value="" >
                      </div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Tipo Geral:</strong><br/>
					  <select class="form-control" id="planilha" name="geral" >
					   <?php
						geraTipoOpcao("geral_partitura");
						?>  
					  </select>

					</div>				  
					<div class=" col-md-6"><strong>Tipo Específico:</strong><br/>
                	  <select class="form-control" id="geral" name="especifico" >
					   <?php
						geraTipoOpcao("especifico_partitura");
						?>  
					  </select>
					</div>
				  </div>
				   <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Número de Partituras:</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="faixas"  value="" >

					</div>				  
					<div class=" col-md-6"><strong>Exemplares:</strong><br/>
					  <input type="text" class="form-control soNumero" id="duracao" name="exemplares"  value="" >
					</div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/>
					<h5>Imprenta</h5>
                      </div>
				  </div>
			 
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Editora</strong><br/>
                	  <select class="form-control" id="tipoDocumento" name="editora" >
					   <?php
						opcaoTermo(100);
						?>  
					  </select>
                      </div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Registro:</strong><br/>
					  <input type="text" class="form-control soNumero" id="Nome" name="registro"  value="" >
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Tipo de data:</strong><br/>
                    <select class="form-control" id="tipoDocumento" name="tipo_data" >
					   <?php
						geraTipoOpcao("data");
						?> 
                        </select> 
					</div>				  
					<div class=" col-md-6"><strong>Data da gravação:</strong><br/>
					  <input type="text" class="form-control" id="CCM" name="data_gravacao"  value="" >
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
					<div class="col-md-offset-2 col-md-8"><br/>
					<h5>Descrição Física</h5>
                      </div>
				  </div>
                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Tipo:</strong><br/>
					                	  <select class="form-control" id="tipoDocumento" name="fisico" >
					   <?php
						geraTipoOpcao("fisico_partitura");
						?>  
					  </select>
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Páginas</strong><br/>
					<input type="text" class="form-control soNumero" id="Nome" name="paginas"  value="" >
			</div>				  
					<div class=" col-md-6"><strong>Medida (em cm):</strong><br/>
					                	 <input type="text" class="form-control soNumero" id="Nome" name="medidas"  value="" >			</div>
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
					<div class="col-md-offset-2 col-md-8"><strong>Título da Obra *:</strong><br/>
					  <input type="text" class="form-control" id="Nome" name="titulo_geral" value="" >
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
