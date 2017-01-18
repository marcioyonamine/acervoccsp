<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CLARA.CCSP - v0.1 - 2016</title>
    <link href="visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="visual/css/style.css" rel="stylesheet" media="screen">
	<link href="visual/color/default.css" rel="stylesheet" media="screen">
	<script src="visual/js/modernizr.custom.js"></script>
</head>


<body>
<?php 

/*
igSmc v0.1 - 2015
ccsplab.org - centro cultural são paulo
*/

// Esta é a página de login do usuário ou de contato com administrador do sistema.

//Imprime erros com o banco
   @ini_set('display_errors', '1');
	error_reporting(E_ALL); 

include "funcoes/funcoesGerais.php";
function bancoMysqli(){ 
	$servidor = '200.237.5.34';
	$usuario = 'root';
	$senha = 'lic54eca';
	$banco = 'acervo';
	$con = mysqli_connect($servidor,$usuario,$senha,$banco); 
	mysqli_set_charset($con,"utf8");
	return $con;
}



if(isset($_GET['pesquisa'])){
	$con = bancoMysqli();
	$pesquisa = $_GET['pesquisa'];	
	
	// roda a tabela registro pela palavra
	
	//$sql_busca_registro = "SELECT DISTINCT id_registro FROM acervo_registro WHERE titulo LIKE '%$pesquisa%' OR id_registro IN (SELECT DISTINCT idReg FROM acervo_relacao_termo, acervo_termo WHERE acervo_termo.termo LIKE '%$pesquisa%' AND acervo_relacao_termo.idTermo = acervo_termo.id_termo)";
	
	//$sql_busca_registro = "SELECT DISTINCT id_registro FROM acervo_registro WHERE titulo LIKE '%$pesquisa%'";
	
	$sql_busca_registro = "SELECT DISTINCT id_registro FROM acervo_registro,acervo_relacao_termo  WHERE acervo_relacao_termo.idReg = acervo_registro.id_registro AND (acervo_registro.titulo LIKE '%$pesquisa%' OR acervo_registro.id_registro IN (SELECT DISTINCT idRel FROM acervo_termo WHERE termo LIKE '%$pesquisa%')) ";
	
	
	$query_registro = mysqli_query($con,$sql_busca_registro);

	//paginacao
	$num01 = mysqli_num_rows($query_registro);
	$total_pagina = 100;	
	if(isset($_GET['n_pag'])){
		$pc = $_GET['n_pag'];	
	}else{
		$pc = "1";	
	}
	$inicio = $pc - 1;
	$inicio = $inicio*$total_pagina;
	$limite = mysqli_query($con,"$sql_busca_registro LIMIT $inicio,$total_pagina");
	$total = $num01;
	
	$tp = $total/$total_pagina;
	 
	
	
	

	 
 
?>
	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h3>Acervos CCSP</h3>
                    

					</div>
				  </div>
			  </div>
			  
	        <div class="row">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            <h5><?php if(isset($mensagem)){ echo $mensagem; } ?></h5>
                         

            	</div>
             </div>
				<br />             
				<?php 
				while($res = mysqli_fetch_array($limite)){
					$reg = recuperaDados("acervo_registro",$res['id_registro'],"id_registro");
				
				?>
	            <div class="form-group">
		            <div class="col-md-offset-2 col-md-8">
               <div class="left">

				<h6><?php echo $reg['titulo']; ?></h6>
                <p><?php 
				var_dump(retornaAutoridades($reg['id_registro']));
				?></p>
                			    </div>
				</div>		            
        	    </div>
        	    <?php 
        	    } ?>
								
<div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	           <br /><br />            
            </div>
          </div>   				<div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <?php 
				$anterior = $pc - 1;
				$proximo = $pc + 1;
				if($pc > 1){
					echo "<a href='?pesquisa=$pesquisa&n_pagina=$anterior'><- Anterior</a>";
				}
				echo " | ";
				if($pc < $tp) {
 				 echo " <a href='?pesquisa=$pesquisa&n_pag=$proximo'>Próxima -></a>";
 				 }
				?>            
            </div>
          </div>      

				<div class="form-group">
            <div class="col-md-offset-2 col-md-8">
	            <a href="?" class="btn btn-theme btn-lg btn-block">Fazer outra busca</a>                
            </div>
          </div>           	    </div>

            </div>
	</section>





<?php }else{ // caso não tenha enviado dados para pesquisa ?>



	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Acervos CCSP</h2>
                     <p>Os campos em que ocorrerá a busca são: título, autor, assunto</p>
                     <p>É possível pesquisar por parte da palavra. Deve-se ter pelo menos 3 caracteres para busca.</p>
                    

					</div>
				  </div>
			  </div>
			  
	        <div class="row">
            <div class="form-group">
            	<div class="col-md-offset-2 col-md-8">
            <h5><?php if(isset($mensagem)){ echo $mensagem; } ?>
                        <form method="GET" action="?" class="form-horizontal" role="form">
            		<label>Busca por palavras</label>
                    
                    
            		<input type="text" name="pesquisa" class="form-control" id="palavras" placeholder="" ><br />

            	</div>
             </div>
				<br />             
	            <div class="form-group">
		            <div class="col-md-offset-2 col-md-8">

    		        <input type="submit" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
                    </form>
        	    	</div>
        	    </div>

            </div>
	</section>

<?php } 

?>


</body>
</html>
