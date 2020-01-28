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

include "../funcoes/funcoesGerais.php";
include "../funcoes/funcoesConecta.php";



if(isset($_GET['pesquisa'])){
	$con = bancoMysqli();
	$pesquisa = $_GET['pesquisa'];	
	
	$sql_busca_registro = "SELECT * FROM acervo_busca WHERE indexado LIKE '%$pesquisa%'";
	
	
	
	
	$qStart = microtime(true);
	$query_registro = mysqli_query($con,$sql_busca_registro);
	$qEnd = microtime(true);
	$tempo = $qEnd-$qStart;
	
	//paginacao
	$num01 = mysqli_num_rows($query_registro);
	$total_pagina = 50;	
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
	 
	$mensagem = "Foram encontrados $num01 registros para '$pesquisa' em $tempo s.";
	
	

	 
 
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
            <h5><?php if(isset($_GET['query'])){echo $sql_busca_registro;} ?></h5>
                         

            	</div>
             </div>
				<br />             
				<?php 
				while($res = mysqli_fetch_array($limite)){
				?>

	            <div class="form-group">
		            <div class="col-md-offset-2 col-md-8">
               <div class="left">

				<h6><?php echo $res['titulo']; ?> </h6>
               
				<p>Autoridades: <?php echo $res['autor']; ?> </p>
                <p>Assuntos:<?php echo $res['assunto']; ?> </p>
				 <p>Coleção: <?php echo $res['colecao']; ?></p>
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
					<select name="tipo" class="form-control">
					<option value="todo">Todo acervo</option>
					<option value="disco">Disco</option>
					<option value="partitura">Partitura</option>
					</select>
					<br />
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
