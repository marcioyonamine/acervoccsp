<?php
//geram o insert pro framework da igsis
$pasta = "?perfil=discoteca&p=";
?>


	<div class="menu-area">
			<div id="dl-menu" class="dl-menuwrapper">
						<button class="dl-trigger">Open Menu</button>
						<ul class="dl-menu">
                        <li><a href="<?php echo $pasta."frm_atualiza_sonoro"; ?>">Voltar</a></li>
						<li><a href="#">Registros Sonoros</a>	
								<ul class="dl-submenu">
									<li><a href="<?php echo $pasta."frm_lista_sonoro"; ?>">Listar registros</a></li>
									<li><a href="<?php echo $pasta."frm_insere_sonoro"; ?>">Inserir registro</a></li>
   									<li><a href="<?php echo $pasta."frm_insere_gravadora"; ?>">Inserir gravadora</a></li>
							</ul>
						</li>
						<li><a href="#">Partituras</a>	
								<ul class="dl-submenu">
									<li><a href="?perfil=evento&p=internos">Listar</a></li>
									<li><a href="?perfil=evento&p=externos">Inserir</a></li>
									</ul>
						</li>
                       	<li><a href="#">Campos controlados</a>	
								<ul class="dl-submenu">
									<li><a href="?perfil=evento&p=internos">Serviços Internos</a></li>
									<li><a href="?perfil=evento&p=externos">Serviços Externos</a></li>
									</ul>
						</li>
                        <li><a href="#">Busca</a></li>
                        <li><a href="#">Últimos registros inseridos</a></li>
 							<li><a href="#">Outras Opções</a> 
    
                                    <ul class="dl-submenu">
                                        <li><a href="?perfil=evento">Voltar </a></li>
										<li><a href="?secao=perfil">Carregar Módulos</a></li>
                                       <li><a href="?perfil=inicio">Voltar a Página Inicial</a></li>
                                        <li><a href="../include/logoff.php">Sair do Sistema</a></li>
                                    </ul>
                                </li>
                       </ul>
					</div><!-- /dl-menuwrapper -->
	</div>	
    