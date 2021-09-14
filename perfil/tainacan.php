<?php
   @ini_set('display_errors', '1');
	error_reporting(E_ALL); 
	set_time_limit(0);

include "../funcoes/funcoesGerais.php";
include "../funcoes/funcoesConecta.php";

if(isset($_GET['teste'])){
	$teste = " LIMIT 0, ".$_GET['teste'];
}else{
	$teste = "";
}

$con = bancoMysqli();

// limpa tabela
$sql_limpa = "TRUNCATE TABLE `acervo_tainacan`";
$query_limpa = mysqli_query($con,$sql_limpa);


function recuperaTainacan($id){
	
	/*
	15 Forma Genero 
	13 Meio de Expressão
	119 Descritor Geográfico
	121 Instrumentação
	78 Categoria
	*/
	$con = bancoMysqli();
	$sql = "SELECT * FROM acervo_relacao_termo WHERE idReg = '$id' AND publicado = '1'";
	$x['sql'] = $sql;
	
	$query = mysqli_query($con,$sql);
	$x['instrumentacao'] = "";
	$x['forma'] = "";
	$x['categoria'] = "";
	$x['descritores'] = "";
	$x['meio'] = "";
	while ($res = mysqli_fetch_array($query)){
		switch($res['idTipo']){
			case 15: // Forma Genero
				$x['forma'] .= retornaTermo($res['idTermo'])." || ";
			break;
			
			case 13: // Meio de Expressão
				$x['meio'] .= retornaTermo($res['idTermo'])." || ";
			break;

			case 119: // Descritor Geográfico
				$x['descritores'] .= retornaTermo($res['idTermo'])." || ";
			break;

			case 121: // Descritor Geográfico
				$x['instrumentcao'] .= retornaTermo($res['idTermo'])." || ";
			break;

			case 78: // Descritor Geográfico
				$x['categoria'] .= retornaTermo($res['idTermo'])." || ";
			break;
		}	
	
	return $x;
		
	}
	
	
}



?>

	 <section id="services" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h1>Gera tabela/migração Tainacan</h1>
					<h3>Partituras</h3> 
					<?php
					//limpa a tabela


					$sql_busca = "SELECT * FROM acervo_registro INNER JOIN acervo_partituras ON acervo_registro.id_tabela = acervo_partituras.idDisco AND acervo_registro.tabela = '97' AND acervo_registro.publicado = '1' AND acervo_partituras.planilha = '17' $teste";
					$query_busca = mysqli_query($con,$sql_busca);
					$i = 0;
					$j = 0;
					while($res = mysqli_fetch_array($query_busca)){
						//echo "<pre>";
						//var_dump($res);	
						//echo "</pre>";

						$colecao = reColecao($res['id_acervo']);
						$tombo = $res['tombo']." ".$res['tombo_antigo'];
						if($res['planilha'] == '17'){
							$catalogacao = "Matriz";
						}else{
							$catalogacao = "Analítica";
						}
						$gravadora = retornaTermo($res['editora']);
						if($gravadora == ""){$gravadora = "vzo";}
						//if($res['medidas'] == 0 ){$medida = "vzo ";}else{$medida = $res['medidas']." cm / ";}
						if($res['paginas'] == 0 ){$medida = "vzo ";}else{$medida = $res['paginas']." página(s)";}
						$data = $res['data_gravacao'];
						$titulo = $res['titulo'];
						$autor = retornaAutoridades($res['id_registro']);
						$autoridade = $autor['palavra']; //$res[''];
						
						$descricao = $res['conteudo']."<br /> ".$res['notas']; //$res[''];
						$descricao = str_replace("CONTEÚDO:", "", $descricao);
						$descricao = str_replace("TÍTULO DA PARTITURA:", "", $descricao);
						$descricao = trim(str_replace("--  -- -- --", "", $descricao));
						$descricao = trim(str_replace("--", "-", $descricao));
						$descricao = trim(str_replace("-  -", "", $descricao));
						
						
						$tainacan = recuperaTainacan($res['id_registro']);
						echo "<pre>";
						var_dump($tainacan);
						echo "<pre>";
						$forma_genero = $tainacan['forma']; // $res[''];
						$instrumentacao = $tainacan['instrumentacao']; //$res[''];
						$descritores = $tainacan['descritores']; //$res[''];



	$sql_insert = "INSERT INTO `acervo_tainacan` (`id`, `colecao`, `tombo`, `catalogacao`, `gravadora`, `medida`, `data`, `titulo`, `autoridade`, `descricao`, `forma_genero`, `instrumentacao`, `descritores`) VALUES (NULL, '$colecao', '$tombo', '$catalogacao', '$gravadora', '$medida', '$data', '$titulo', '$autoridade', '$descricao', '$forma_genero', '$instrumentacao', '$descritores')";
	if(mysqli_query($con,$sql_insert)){
		echo $titulo." inserido<br />";
		$i++;
	}else{
		echo $titulo." erro ao inserir<br />";
		$j++;
	}
	

}

echo "$i inseridos.<br />";
echo "$j com erros.<br />";

					?>



					</div>
				  </div>
			  </div>
			  
		</div>
	</section>