<?php
//geram o insert pro framework da igsis
$pasta = "?perfil=discoteca&p=";
$tab = recuperaDados("acervo_registro",$_SESSION['idReg'],"id_registro");
?>


	<div class="menu-area">
			<div id="dl-menu" class="dl-menuwrapper">
						<button class="dl-trigger">Open Menu</button>
 
						<ul class="dl-menu">						<li><a href="#">Autoridades</a> 
	                        <ul class="dl-submenu">
                                <li><a href="<?php echo $pasta ?>frm_termos&tipo=1">Listar </a></li>
								<li><a href="<?php echo $pasta ?>frm_insere_autoridade">Buscar</a></li>
                             </ul>
                        </li>
						<li><a href="#">Termos</a> 
	                        <ul class="dl-submenu">
                                <li><a href="<?php echo $pasta ?>frm_termos&tipo=0">Listar </a></li>
								<li><a href="<?php echo $pasta ?>frm_insere_termo">Buscar</a></li>
                             </ul>
                        </li>
						
                        <?php 
                        if($tab['tabela'] == 87){
							if($_SESSION['idAnalitica'] == 0 OR $_SESSION['idAnalitica'] == ""){ ?>
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
                        if($tab['tabela'] == 97){
							if($_SESSION['idAnalitica'] == 0 OR $_SESSION['idAnalitica'] == ""){ ?>
							<li><a href="<?php echo $pasta."frm_atualiza_partitura"; ?>">Voltar</a></li>
							
							<?php 
							}else{
							?>
							<li><a href="<?php echo $pasta."frm_analiticas_partitura&pag=edita"; ?>">Voltar</a></li>
							
							<?php 	
							}
						}
                        ?>
                        
                        
                               
						



						<li><a href="#">Outras Opções</a> 
    
                                    <ul class="dl-submenu">
                                        <li><a href="?perfil=discoteca">Voltar </a></li>
										<li><a href="?secao=perfil">Carregar Módulos</a></li>
                                       <li><a href="?perfil=inicio">Voltar a Página Inicial</a></li>
                                        <li><a href="../include/logoff.php">Sair do Sistema</a></li>
                                    </ul>
                                </li>
                       </ul>
					</div><!-- /dl-menuwrapper -->
	</div>	
    
