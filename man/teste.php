<?php
@ini_set('display_errors', '1');
error_reporting(E_ALL); 
require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php";
$con = bancoMysqli();

$sql_registro = "SELECT idDisco, titulo_disco, titulo_faixa, titulo_uniforme, titulo_resumo FROM temp_acervo_discoteca LIMIT 0,100";
$query_registro = mysqli_query($con,$sql_registro);
while($reg = mysqli_fetch_array($query_registro)){
	$tit = str_replace("TÍTULO DO DISCO:","",$reg['titulo_resumo']);	
	$titulo = str_replace(" TÍTULO DA FAIXA:","",$tit);

	echo "<p>$titulo</p>";
	
}
// Fornece: você comeria pizza, cerveja e sorvete todos os dias
$frase  = "você comeria frutas, vegetais, e fibra todos os dias.";
$saudavel = array("frutas", "vegetais", "fibra");
$saboroso   = array("pizza", "cerveja", "sorvete");

$novafrase = str_replace($saudavel, $saboroso, $frase);

echo $novafrase;
?>