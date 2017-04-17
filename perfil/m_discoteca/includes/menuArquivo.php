<?php
//geram o insert pro framework da igsis
$pasta = "?perfil=discoteca&p=";


?>


	<div class="menu-area">
			<div id="dl-menu" class="dl-menuwrapper">
						<button class="dl-trigger">Open Menu</button>
						<ul class="dl-menu">
                                               <?php 
                        if($_SESSION['idTabela'] == 87){
							if(!isset($_SESSION['idFaixa']) OR $_SESSION['idFaixa'] == 0 ){ ?>
							<li><a href="<?php echo $pasta."frm_atualiza_sonoro"; ?>">Voltar</a></li>
							
							<?php 
							}else{
							?>
							<li><a href="<?php echo $pasta."frm_analiticas_sonoro&pag=edita"; ?>">Voltar</a></li>
							
							<?php 	
							}
						}
                        ?>
                        
                        <?php 
                        if($_SESSION['idTabela'] == 97){
							if(!isset($_SESSION['idFaixa'])  OR $_SESSION['idFaixa'] == 0 ){ ?>
							<li><a href="<?php echo $pasta."frm_atualiza_partitura"; ?>">Voltar</a></li>
							
							<?php 
							}else{
							?>
							<li><a href="<?php echo $pasta."frm_analiticas_partitura&pag=edita"; ?>">Voltar</a></li>
							
							<?php 	
							}
						}
                        ?>
                       </ul>
					</div><!-- /dl-menuwrapper -->
	</div>	
    
