<link rel="stylesheet" type="text/css" href="m_discoteca/includes/autocomplete.css">
<script type="text/javascript" src="m_discoteca/includes/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="m_discoteca/includes/jquery.ui.autocomplete.html.js"></script>
<script type="text/javascript" src="m_discoteca/includes/autocomplete.js"></script>

	  <section id="contact" class="home-section bg-white">
	  	<div class="container">
			  <div class="form-group">
					<h3>Termos</h3>
                    <p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
                    <br />
                    <br />
               </div>

	  		<div class="row">
	  			<div class="col-md-offset-1 col-md-10">

				<form class="form-horizontal" role="form" action="?perfil=discoteca&p=frm_atualiza" method="post">
                  		  

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/>
					<h5>Autoridades</h5>
                      </div>
				  </div>

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">

					  <input type="text" class="form-control" id="topic_title" name="autoridades" >
					</div>
				  </div>

                  <div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/>
					<h5>Assuntos</h5>
                      </div>
				  </div>

				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					  <input type="text" class="form-control" id="topic_title" name="assuntos"   >
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-md-offset-2 col-md-8">
					<br /><br />
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



<script type="text/javascript" src="js/custom.js"></script>