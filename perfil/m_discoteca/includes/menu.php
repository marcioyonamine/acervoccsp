<?php
if(isset($_SESSION['tabela'])){
	unset($_SESSION['tabela']);	
	
}
//geram o insert pro framework da igsis
$pasta = "?perfil=discoteca&p=";
?>


	<div class="menu-area">
			<div id="dl-menu" class="dl-menuwrapper">
						<button class="dl-trigger">Open Menu</button>
						<ul class="dl-menu">
						<li><a href="#">Registros Sonoros</a>	
								<ul class="dl-submenu">
									<li><a href="<?php echo $pasta."frm_lista_sonoro"; ?>">Listar registros</a></li>
									<li><a href="<?php echo $pasta."frm_insere_sonoro"; ?>">Inserir registro</a></li>
   									<li><a href="<?php echo $pasta."frm_insere_gravadora"; ?>">Inserir gravadora</a></li>
							</ul>
						</li>
						<li><a href="#">Partituras</a>	
								<ul class="dl-submenu">
									<li><a href="<?php echo $pasta."frm_lista_partitura"; ?>">Listar partituras</a></li>
									<li><a href="<?php echo $pasta."frm_insere_partitura"; ?>">Inserir partitura</a></li>
   									<li><a href="<?php echo $pasta."frm_insere_editora"; ?>">Inserir editora</a></li>
									</ul>
						</li>
						<li><a href="#">Audiovisual</a>	
								<ul class="dl-submenu">
									<li><a href="<?php echo $pasta."frm_lista_av"; ?>">Listar filmes</a></li>
									<li><a href="<?php echo $pasta."frm_insere_av"; ?>">Inserir filme</a></li>
   									<li><a href="<?php echo $pasta."frm_insere_produtora"; ?>">Inserir produtora</a></li>
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
    