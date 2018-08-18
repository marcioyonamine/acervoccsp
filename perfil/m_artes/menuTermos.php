<?php
//geram o insert pro framework da igsis
$pasta = "?perfil=discoteca&p=";
?>


	<div class="menu-area">
			<div id="dl-menu" class="dl-menuwrapper">
						<button class="dl-trigger">Open Menu</button>
 
						<ul class="dl-menu">						<li><a href="#">Autoridades</a> 
	                        <ul class="dl-submenu">
                                <li><a href="<?php echo $pasta ?>frm_termos&tipo=1">Listar </a></li>
								<li><a href="<?php echo $pasta ?>frm_termos&tipo=1&pag=busca">Buscar</a></li>
                             </ul>
                        </li>
						<li><a href="#">Forma / Gênero</a> 
	                        <ul class="dl-submenu">
                                <li><a href="<?php echo $pasta ?>frm_termos&tipo=15">Listar </a></li>
								<li><a href="<?php echo $pasta ?>frm_termos&tipo=15&pag=busca">Buscar</a></li>
                             </ul>
                        </li>
						<li><a href="#">Série</a> 
	                        <ul class="dl-submenu">
                                <li><a href="<?php echo $pasta ?>frm_termos&tipo=85">Listar </a></li>
								<li><a href="<?php echo $pasta ?>frm_termos&tipo=85&pag=busca">Buscar</a></li>
                             </ul>
                        </li>
						<li><a href="#">Meio de Expressão</a> 
	                        <ul class="dl-submenu">
                                <li><a href="<?php echo $pasta ?>frm_termos&tipo=13">Listar </a></li>
								<li><a href="<?php echo $pasta ?>frm_termos&tipo=13&pag=busca">Buscar</a></li>
                             </ul>
                        </li>
						<li><a href="#">Descritor / Assunto</a> 
	                        <ul class="dl-submenu">
                                <li><a href="?perfil=discoteca">Listar </a></li>
								<li><a href="?secao=perfil">Buscar</a></li>
                             </ul>
                        </li>
                               
						<li><a href="<?php echo $pasta."frm_analiticas_sonoro"; ?>">Voltar</a></li>



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
    