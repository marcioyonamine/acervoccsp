<?php
//geram o insert pro framework da igsis
$pasta = "?perfil=discoteca&p=";
?>


	<div class="menu-area">
			<div id="dl-menu" class="dl-menuwrapper">
						<button class="dl-trigger">Open Menu</button>
						<ul class="dl-menu">
						<li><a href="<?php echo $pasta."frm_analiticas_partitura"; ?>">Listar analíticas</a></li>
						<li><a href="<?php echo $pasta."frm_analiticas_partitura&pag=insere"; ?>">Inserir analíticas</a></li>
						<li><a href="<?php echo $pasta."frm_atualiza_partitura"; ?>">Voltar a matriz</a></li>


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
    
