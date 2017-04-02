<?php
//geram o insert pro framework da igsis
$pasta = "?perfil=discoteca&p=";
?>


	<div class="menu-area">
			<div id="dl-menu" class="dl-menuwrapper">
						<button class="dl-trigger">Open Menu</button>
						<ul class="dl-menu">
						<li><a href="<?php echo $pasta."frm_lista_sonoro"; ?>">Listar registros</a></li>
						<li><a href="<?php echo $pasta."frm_insere_sonoro"; ?>">Inserir registro</a></li>
						<li><a href="<?php echo $pasta."frm_busca_sonoro"; ?>">Busca registro</a></li>
                      	<!--<li><a href="#">Autoridades</a>	
								<ul class="dl-submenu">
									<li><a href="<?php echo $pasta."frm_busca_autoridades"; ?>">Buscar Autoridades</a></li>
									<li><a href="<?php echo $pasta."frm_insere_autoridade"; ?>">Inserir Autoridades</a></li>
									</ul>
						</li>
                       	<li><a href="#">Termos</a>	
								<ul class="dl-submenu">
									<li><a href="<?php echo $pasta."frm_lista_av"; ?>">Buscar termo</a></li>
									<li><a href="<?php echo $pasta."frm_insere_av"; ?>">Inserir termo</a></li>
									</ul>
						</li>-->
                            <li><a href="?perfil=discoteca">Inicio</a></li>
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
    
