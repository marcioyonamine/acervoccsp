<?php
$_SESSION['tabela'] = 97;
//geram o insert pro framework da igsis
$pasta = "?perfil=discoteca&p=";
?>


	<div class="menu-area">
			<div id="dl-menu" class="dl-menuwrapper">
						<button class="dl-trigger">Open Menu</button>
						<ul class="dl-menu">
						<li><a href="<?php echo $pasta."frm_lista_partitura"; ?>">Listar partituras</a></li>
									<li><a href="<?php echo $pasta."frm_insere_partitura"; ?>">Inserir partitura</a></li>
   									<li><a href="<?php echo $pasta."frm_busca_partitura"; ?>">Busca partitura</a></li>


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
    
