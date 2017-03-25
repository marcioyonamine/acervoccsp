<?php
//Exibe erros PHP
@ini_set('display_errors', '1');
error_reporting(E_ALL); 
require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php";

$con = bancoMysqli();
set_time_limit(0);
$teste = "";

if(isset($_GET['action'])){
	$action = $_GET['action'];
}else{
	$action = "inicio";
}

switch($action){

	/////// Editoras
	case "editoras":
	
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Importando os termos adotados para editoras...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT Adotar FROM temp_editoras $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['Adotar']);
		
		$sql_pesquisa = "SELECT termo FROM acervo_termo WHERE termo = '$gravadora' AND tipo = '100'";
		$query_pesquisa = mysqli_query($con,$sql_pesquisa);
		$num_pesquisa = mysqli_num_rows($query_pesquisa);
		if($num_pesquisa == 0){
			$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
			VALUES ('$gravadora', '', '100', '', 'Base antiga', '1', '$hoje', '1')";
			$query_update = mysqli_query($con,$sql_update);
			if($query_update){
				echo "Gravadora $gravadora inserida. (1) <br />";	
			}else{
				echo "Erro ao importar $gravadora (2) <br />";
			
			}
		}
	}

	$sql = "SELECT DISTINCT Termo FROM temp_editoras $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['Termo']);
		
		$sql_pesquisa = "SELECT termo FROM acervo_termo WHERE termo = '$gravadora' AND tipo = '100'";
		$query_pesquisa = mysqli_query($con,$sql_pesquisa);
		$num_pesquisa = mysqli_num_rows($query_pesquisa);
		if($num_pesquisa == 0){
			$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
			VALUES ('$gravadora', '', '100', '', 'Base antiga', '1', '$hoje', '1')";
			$query_update = mysqli_query($con,$sql_update);
			if($query_update){
				echo "Gravadora $gravadora inserida. (1) <br />";	
			}else{
				echo "Erro ao importar $gravadora (2) <br />";
			
			}
		}
	}
	
	
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	
	break;

	
	/////// GRAVADORAS
	case "gravadora":
	
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Importando os termos adotados para gravadoras...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT adotar FROM temp_disco_gravadoras $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['adotar']);
		$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
		VALUES ('$gravadora', '', '12', '', 'Base antiga', '1', '$hoje', '1')";
		$query_update = mysqli_query($con,$sql_update);
		if($query_update){
			echo "Gravadora $gravadora inserida. (1) <br />";	
		}else{
			echo "Erro ao importar $gravadora (2) <br />";
			
		}
	}
	
	echo "<h1>Importando os demais termos...</h1>";
	
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT termo FROM `temp_disco_gravadoras` $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['termo']);
		$sql_busca = "SELECT * FROM acervo_termo WHERE termo LIKE '$gravadora' AND tipo = '12'";
		$query_busca = mysqli_query($con,$sql_busca);
		$num_busca = mysqli_num_rows($query_busca);

		if($num_busca == 0){
			$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
			VALUES ('$gravadora', '', '12', '', 'Base antiga', '1', '$hoje', '1')";
			$query_update = mysqli_query($con,$sql_update);
			if($query_update){
				echo "Gravadora $gravadora inserido. (3) <br />";	
			}else{
				echo "Erro ao importar $gravadora (4) <br /> ";
			}
	
		}
	}
	echo "<h1>Atualizando os termos preteridos</h1>";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT * FROM temp_disco_gravadoras $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$termo = $x['termo'];
		$adotar = $x['adotar'];
		if($termo != $adotar){
			$adotar = addslashes($x['adotar']);
			$sql_busca = "SELECT id_termo FROM acervo_termo WHERE termo LIKE '$adotar' AND tipo ='12'";
			$query_busca = mysqli_query($con,$sql_busca);
			$y = mysqli_fetch_array($query_busca);
			$id = $y['id_termo'];
			$sql_atualiza = "UPDATE acervo_termo SET adotado = '$id' WHERE termo LIKE '$termo'";
			$query_atualiza = mysqli_query($con,$sql_atualiza);
			if($query_atualiza){
				echo "Gravadora $termo adota o termo $adotar(5)<br />";	
			}else{
				echo "Erro ao atualizar o termo $termo / $adotar(6)<br />";	
			}
		}	
		
	}
	
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";


break;

	/////////// Forma e Gênero
	case "forma":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Importando os termos adotados para Meios de expressão...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT Adotar FROM temp_forma $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['Adotar']);
		$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
		VALUES ('$gravadora', '', '15', '', 'Base antiga', '1', '$hoje', '1')";
		$query_update = mysqli_query($con,$sql_update);
		if($query_update){
			echo "Forma e Gênero $gravadora inserida. (1) <br />";	
		}else{
			echo "Erro ao importar $gravadora (2) <br />";
			
		}
	}
	
	echo "<h1>Importando os demais termos...</h1>";
	
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT Termo FROM `temp_forma` $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['Termo']);
		$sql_busca = "SELECT * FROM acervo_termo WHERE termo LIKE '$gravadora' AND tipo = '15'";
		$query_busca = mysqli_query($con,$sql_busca);
		$num_busca = mysqli_num_rows($query_busca);

		if($num_busca == 0){
			$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
			VALUES ('$gravadora', '', '15', '', 'Base antiga', '1', '$hoje', '1')";
			$query_update = mysqli_query($con,$sql_update);
			if($query_update){
				echo "Forma e Gênero $gravadora inserido. (3) <br />";	
			}else{
				echo "Erro ao importar $gravadora (4) <br /> ";
			}
	
		}
	}
	echo "<h1>Atualizando os termos preteridos</h1>";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT * FROM temp_forma $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$termo = $x['Termo'];
		$adotar = $x['Adotar'];
		if($termo != $adotar){
			$adotar = addslashes($x['Adotar']);
			$sql_busca = "SELECT id_termo FROM acervo_termo WHERE termo LIKE '$adotar' AND tipo ='15'";
			$query_busca = mysqli_query($con,$sql_busca);
			$y = mysqli_fetch_array($query_busca);
			$id = $y['id_termo'];
			$sql_atualiza = "UPDATE acervo_termo SET adotado = '$id' WHERE termo LIKE '$termo'";
			$query_atualiza = mysqli_query($con,$sql_atualiza);
			if($query_atualiza){
				echo "Forma e Gênero $termo adota o termo $adotar(5)<br />";	
			}else{
				echo "Forma e Gênero o termo $termo / $adotar(6)<br />";	
			}
		}	
		
	}
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	
	break;

	/////////// Meios de Expressão
	case "meios":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Importando os termos adotados para Meios de expressão...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT Adotar FROM temp_meio $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['Adotar']);
		$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
		VALUES ('$gravadora', '', '13', '', 'Base antiga', '1', '$hoje', '1')";
		$query_update = mysqli_query($con,$sql_update);
		if($query_update){
			echo "Meio de expressão $gravadora inserida. (1) <br />";	
		}else{
			echo "Erro ao importar $gravadora (2) <br />";
			
		}
	}
	
	echo "<h1>Importando os demais termos...</h1>";
	
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT Termo FROM `temp_meio` $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['Termo']);
		$sql_busca = "SELECT * FROM acervo_termo WHERE termo LIKE '$gravadora' AND tipo = '13'";
		$query_busca = mysqli_query($con,$sql_busca);
		$num_busca = mysqli_num_rows($query_busca);

		if($num_busca == 0){
			$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
			VALUES ('$gravadora', '', '13', '', 'Base antiga', '1', '$hoje', '1')";
			$query_update = mysqli_query($con,$sql_update);
			if($query_update){
				echo "Meio de Expressão $gravadora inserido. (3) <br />";	
			}else{
				echo "Erro ao importar $gravadora (4) <br /> ";
			}
	
		}
	}
	echo "<h1>Atualizando os termos preteridos</h1>";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT * FROM temp_meio $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$termo = $x['Termo'];
		$adotar = $x['Adotar'];
		if($termo != $adotar){
			$adotar = addslashes($x['Adotar']);
			$sql_busca = "SELECT id_termo FROM acervo_termo WHERE termo LIKE '$adotar' AND tipo ='13'";
			$query_busca = mysqli_query($con,$sql_busca);
			$y = mysqli_fetch_array($query_busca);
			$id = $y['id_termo'];
			$sql_atualiza = "UPDATE acervo_termo SET adotado = '$id' WHERE termo LIKE '$termo'";
			$query_atualiza = mysqli_query($con,$sql_atualiza);
			if($query_atualiza){
				echo "Meio de expressão $termo adota o termo $adotar(5)<br />";	
			}else{
				echo "Erro ao atualizar o termo $termo / $adotar(6)<br />";	
			}
		}	
		
	}
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	
	break;

	/////////// Autoridades
	case "autoridades":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Importando os termos adotados para Autoridades...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT Adotar FROM acervo_autoridades $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['Adotar']);
		$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
		VALUES ('$gravadora', '', '1', '', 'Base antiga', '1', '$hoje', '1')";
		$query_update = mysqli_query($con,$sql_update);
		if($query_update){
			echo "Autoridade $gravadora inserida. (1) <br />";	
		}else{
			echo "Erro ao importar $gravadora (2) <br />";
			
		}
	}
	
	echo "<h1>Importando os demais termos...</h1>";
	
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT Termo FROM `acervo_autoridades` $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['Termo']);
		$sql_busca = "SELECT * FROM acervo_termo WHERE termo LIKE '$gravadora' AND tipo = '1'";
		$query_busca = mysqli_query($con,$sql_busca);
		$num_busca = mysqli_num_rows($query_busca);

		if($num_busca == 0){
			$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
			VALUES ('$gravadora', '', '1', '', 'Base antiga', '1', '$hoje', '1')";
			$query_update = mysqli_query($con,$sql_update);
			if($query_update){
				echo "Autoridade $gravadora inserido. (3) <br />";	
			}else{
				echo "Erro ao importar $gravadora (4) <br /> ";
			}
	
		}
	}
	echo "<h1>Atualizando os termos preteridos</h1>";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT Termo,Adotar FROM acervo_autoridades $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$termo = $x['Termo'];
		$adotar = $x['Adotar'];
		if($termo != $adotar){
			$adotar = addslashes($x['Adotar']);
			$sql_busca = "SELECT id_termo FROM acervo_termo WHERE termo LIKE '$adotar' AND tipo ='1'";
			$query_busca = mysqli_query($con,$sql_busca);
			$y = mysqli_fetch_array($query_busca);
			$id = $y['id_termo'];
			$sql_atualiza = "UPDATE acervo_termo SET adotado = '$id' WHERE termo LIKE '$termo'";
			$query_atualiza = mysqli_query($con,$sql_atualiza);
			if($query_atualiza){
				echo "Autoridade $termo adota o termo $adotar(5)<br />";	
			}else{
				echo "Erro ao atualizar o termo $termo / $adotar(6)<br />";	
			}
		}	
		
	}
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	
break;



	/////////// Meios de Expressão
	case "meios":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Importando os termos adotados para Meios de expressão...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT Adotar FROM temp_meio $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['Adotar']);
		$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
		VALUES ('$gravadora', '', '13', '', 'Base antiga', '1', '$hoje', '1')";
		$query_update = mysqli_query($con,$sql_update);
		if($query_update){
			echo "Meio de expressão $gravadora inserida. (1) <br />";	
		}else{
			echo "Erro ao importar $gravadora (2) <br />";
			
		}
	}
	
	echo "<h1>Importando os demais termos...</h1>";
	
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT Termo FROM `temp_meio` $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['Termo']);
		$sql_busca = "SELECT * FROM acervo_termo WHERE termo LIKE '$gravadora' AND tipo = '13'";
		$query_busca = mysqli_query($con,$sql_busca);
		$num_busca = mysqli_num_rows($query_busca);

		if($num_busca == 0){
			$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
			VALUES ('$gravadora', '', '13', '', 'Base antiga', '1', '$hoje', '1')";
			$query_update = mysqli_query($con,$sql_update);
			if($query_update){
				echo "Meio de Expressão $gravadora inserido. (3) <br />";	
			}else{
				echo "Erro ao importar $gravadora (4) <br /> ";
			}
	
		}
	}
	echo "<h1>Atualizando os termos preteridos</h1>";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT * FROM temp_meio $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$termo = $x['Termo'];
		$adotar = $x['Adotar'];
		if($termo != $adotar){
			$adotar = addslashes($x['Adotar']);
			$sql_busca = "SELECT id_termo FROM acervo_termo WHERE termo LIKE '$adotar' AND tipo ='13'";
			$query_busca = mysqli_query($con,$sql_busca);
			$y = mysqli_fetch_array($query_busca);
			$id = $y['id_termo'];
			$sql_atualiza = "UPDATE acervo_termo SET adotado = '$id' WHERE termo LIKE '$termo'";
			$query_atualiza = mysqli_query($con,$sql_atualiza);
			if($query_atualiza){
				echo "Meio de expressão $termo adota o termo $adotar(5)<br />";	
			}else{
				echo "Erro ao atualizar o termo $termo / $adotar(6)<br />";	
			}
		}	
		
	}
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	
	break;

	/////////// Autoridades
	case "autoridades":
	$antes = strtotime(date('Y-m-d H:i:s')); // note que usei hífen
	echo "<h1>Importando os termos adotados para Autoridades...</h1><br />";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT Adotar FROM acervo_autoridades $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['Adotar']);
		$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
		VALUES ('$gravadora', '', '1', '', 'Base antiga', '1', '$hoje', '1')";
		$query_update = mysqli_query($con,$sql_update);
		if($query_update){
			echo "Autoridade $gravadora inserida. (1) <br />";	
		}else{
			echo "Erro ao importar $gravadora (2) <br />";
			
		}
	}
	
	echo "<h1>Importando os demais termos...</h1>";
	
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT Termo FROM `acervo_autoridades` $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$gravadora = addslashes($x['Termo']);
		$sql_busca = "SELECT * FROM acervo_termo WHERE termo LIKE '$gravadora' AND tipo = '1'";
		$query_busca = mysqli_query($con,$sql_busca);
		$num_busca = mysqli_num_rows($query_busca);

		if($num_busca == 0){
			$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
			VALUES ('$gravadora', '', '1', '', 'Base antiga', '1', '$hoje', '1')";
			$query_update = mysqli_query($con,$sql_update);
			if($query_update){
				echo "Autoridade $gravadora inserido. (3) <br />";	
			}else{
				echo "Erro ao importar $gravadora (4) <br /> ";
			}
	
		}
	}
	echo "<h1>Atualizando os termos preteridos</h1>";
	$hoje = date('Y-m-d H:i:s');
	$sql = "SELECT Termo,Adotar FROM acervo_autoridades $teste";
	$query = mysqli_query($con,$sql);
	while($x = mysqli_fetch_array($query)){
		$termo = $x['Termo'];
		$adotar = $x['Adotar'];
		if($termo != $adotar){
			$adotar = addslashes($x['Adotar']);
			$sql_busca = "SELECT id_termo FROM acervo_termo WHERE termo LIKE '$adotar' AND tipo ='1'";
			$query_busca = mysqli_query($con,$sql_busca);
			$y = mysqli_fetch_array($query_busca);
			$id = $y['id_termo'];
			$sql_atualiza = "UPDATE acervo_termo SET adotado = '$id' WHERE termo LIKE '$termo'";
			$query_atualiza = mysqli_query($con,$sql_atualiza);
			if($query_atualiza){
				echo "Autoridade $termo adota o termo $adotar(5)<br />";	
			}else{
				echo "Erro ao atualizar o termo $termo / $adotar(6)<br />";	
			}
		}	
		
	}
	$depois = strtotime(date('Y-m-d H:i:s'));
	$tempo = $depois - $antes;
	echo "<br /><br /> Importação executada em $tempo segundos";
	
break;


case "locais":
set_time_limit(0);
echo "Importando Forma Gênero...<br />";
//gravadora
$hoje = date('Y-m-d H:i:s');
$sql = "SELECT DISTINCT Adotar FROM `temp_disco_local`";
$query = mysqli_query($con,$sql);
while($x = mysqli_fetch_array($query)){
	$gravadora = $x['Adotar'];
	$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
	VALUES ('$gravadora', '', '14', '', 'Base antiga', '1', '$hoje', '1')";
	$query_update = mysqli_query($con,$sql_update);
	if($query_update){
		echo "Forma Gênero $gravadora inserido. <br />";	
	}else{
		echo "Erro ao importar<br />";
		
	}
}
break;

case "locaispreteridos":
set_time_limit(0);

$sql = "SELECT * FROM temp_disco_local";
$query = mysqli_query($con,$sql);
while($x = mysqli_fetch_array($query)){
	$preterido = $x['Termo'];
	$adotar = $x['Adotar'];
	$id = $x['idLocal'];
	if($preterido != $adotar){
		$recupera = "SELECT id_termo FROM acervo_termo WHERE tipo = '14' AND termo LIKE '$adotar' LIMIT 0,1";
		$query_recupera = mysqli_query($con,$recupera);
		$num = mysqli_num_rows($query_recupera);
		if($num > 0){
			$pret = mysqli_fetch_array($query_recupera);
			$idpreterido = $pret['id_termo'];
			$sql_update = "UPDATE `acervo_termo` SET adotado = '$idpreterido' WHERE termo = '$preterido'";
			$query_update = mysqli_query($con,$sql_update);
			if($query_update){
				echo "Termo $preterido atualizado. <br />";	
			}else{
				echo "Erro ao atualizar o termo $preterido<br />";
				
			}
		}
	}
}

break;

case "tabelatipo":
set_time_limit(0);
echo "Importando Forma Gênero...<br />";
//gravadora
	$sql_update = "INSERT INTO `acervo_tipo` (`tipo`, `descricao`, `abreviatura`) SELECT tipo, descricao, abreviatura FROM disco_tipo";
	$query_update = mysqli_query($con,$sql_update);
	if($query_update){
		echo "Tipos inseridos. <br />";	
	}else{
		echo "Erro ao importar<br />";
		
	}

break;



case "categorias": //Estudar...
set_time_limit(0);
echo "Importando Categorias...<br />";

function parenteses($string){

$vowels = array("(", ")");
$onlyconsonants = str_replace($vowels, "", $string);
return $onlyconsonants;	
}

$hoje = date('Y-m-d H:i:s');
$sql = "SELECT DISTINCT Adotar FROM `temp_categorias`";
$query = mysqli_query($con,$sql);
while($x = mysqli_fetch_array($query)){
	$gravadora = parenteses($x['Adotar']);
	$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
	VALUES ('$gravadora', '', '78', '', 'Base antiga', '1', '$hoje', '1')";
	$query_update = mysqli_query($con,$sql_update);
	if($query_update){
		echo "Forma Gênero $gravadora inserido. <br />";	
	}else{
		echo "Erro ao importar<br />";
		
	}
}
break;

case "categoriaspreteridos": //Estudar...
set_time_limit(0);
echo "Importando Categorias...<br />";
//gravadora
$hoje = date('Y-m-d H:i:s');
$sql = "SELECT DISTINCT Termo FROM `temp_categorias`";
$query = mysqli_query($con,$sql);
while($x = mysqli_fetch_array($query)){
	$gravadora = $x['Termo'];
	$sql_busca = "SELECT * FROM acervo_termo WHERE termo LIKE '$gravadora' AND categoria = '78' LIMIT 0,1";
	$query_busca = mysqli_query($con,$sql_busca);
	$num_busca = mysqli_num_rows($query_busca);
	if($num_busca > 0){
		$adotar = mysqli_fetch_array($query_busca);
		$idAdotar = $adotar['id_termo']; 
		$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
		VALUES ('$gravadora', '$idAdotar', '78', '', 'Base antiga', '1', '$hoje', '1')";
		$query_update = mysqli_query($con,$sql_update);
		if($query_update){
			echo "Catogria $gravadora inserido. 1<br />";	
		}else{
			echo "Erro ao importar<br /> 2";
		}

	}else{
		$sql_update = "INSERT INTO `acervo_termo` (`termo`, `adotado`, `tipo`, `categoria`, `pesquisa`, `id_usuario`, `data_update`, `publicado`) 
		VALUES ('$gravadora', '', '78', '', 'Base antiga', '1', '$hoje', '1')";
		$query_update = mysqli_query($con,$sql_update);
		if($query_update){
			echo "Forma Gênero $gravadora inserido. 3 <br />";	
		}else{
			echo "Erro ao importar<br /> 4";
		}
	}
}
break;

case "datas": //estudar
set_time_limit(0);
$sql_datas = "SELECT idDisco, data_catalogacao FROM acervo_discoteca WHERE data_catalogacao IS NOT NULL";
$query_datas = mysqli_query($con,$sql_datas);
while($datas = mysqli_fetch_array($query_datas)){
	if($datas['data_catalogacao'] != NULL){
		$id = $datas['idDisco'];
		$data_nova = exibirDataMysql($datas['data_catalogacao']);
		$sql_atualiza = "UPDATE acervo_discoteca SET data_catalogacao = '$data_nova' WHERe idDisco = '$id'";
		$query_atualiza = mysqli_query($con,$sql_atualiza);
		if($query_atualiza){
			echo "Registro $id atualizado.<br />";
		}else{
			echo "Erro ao atualizar registro $id";
			
		}
		
		
	}	
	
}

break;

case "faixas":
set_time_limit(0);
$sql_faixas = "SELECT idDisco, Faixas FROM acervo_discoteca WHERE Faixas IS NOT NULL";
$query_faixas = mysqli_query($con,$sql_faixas);
while($faixas = mysqli_fetch_array($query_faixas)){
	$id = $faixas['idDisco'];
	$faixa_nova = soNumero($faixas['Faixas']);
	$sql_atualiza = "UPDATE acervo_discoteca SET Faixas = '$faixa_nova' WHERE idDisco = '$id'";
	$query_atualiza = mysqli_query($con,$sql_atualiza);
	if($query_atualiza){
		echo "Registro $id atualizado.<br />";
	}else{
		echo "Erro ao atualizar registro $id<br />";
	}

}

break;





case "inicio":
?>
<h1>Importação dos termos para a base</h1>

<a href="?action=gravadora">Importar as gravadoras para a tabela "termos"</a><br />
<br />
<a href="?action=editoras">Importar as editoras para a tabela "termos"</a><br />
<br />
<a href="?action=meios">Importar meios de expressão para a tabela "termos"</a><br />
<br />
<a href="?action=autoridades">Importar autoridades para a tabela "termos"</a><br />
<br />
<a href="?action=forma">Importar Forma e Gênero para a tabela "termos"</a><br />
<a href="?action=formapreteridos">Atualizar Forma e Gênero para autoridades</a><br />
<br />
<a href="?action=locais">Importar locais para a tabela "termos"</a><br />
<a href="?action=locaispreteridos">Atualizar preteridos para locais</a><br />
<br />
<a href="?action=tabelatipo">Importar tabela disco_tipo para acervo_tipo</a><br />
<br />

<a href="?action=categorias">Importar Categorias</a><br />
<a href="?action=categoriaspreteridos">Atualizar Categorias</a><br />

<a href="?action=datas">Atualizar Datas</a><br />



<?php 
break;

} ?>
