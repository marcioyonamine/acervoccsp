<?php
if(isset($_SESSION['tabela'])){
	unset($_SESSION['tabela']);	
	
}
//geram o insert pro framework da igsis
$pasta = "?perfil=man&p=";
?>


	<div class="menu-area">
			<div id="dl-menu" class="dl-menuwrapper">
						<button class="dl-trigger">Open Menu</button>
						<ul class="dl-menu">


                                        <li><a href="?perfil=discoteca">Voltar </a></li>
										<li><a href="?secao=perfil">Carregar Módulos</a></li>
                                       <li><a href="?perfil=inicio">Voltar a Página Inicial</a></li>
                                        <li><a href="../include/logoff.php">Sair do Sistema</a></li>
                       </ul>
					</div><!-- /dl-menuwrapper -->
	</div>	
    
