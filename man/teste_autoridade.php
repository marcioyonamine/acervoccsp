<?php 

function retiraParenteses($string){
	$pontos = array("(", ")");
	$result = str_replace($pontos, "", $string);
	return $result;

}

function resumoAutoridades($string){
	$array = explode('/', $string);
	$i = 0;
	foreach($array as $valores){
		preg_match('#\((.*)\)#',$valores, $match);
		$categoria = $match[0];	
		$y = explode("(", $valores);
		$termo = $y[0];
		$retorno[$i]['categoria'] = trim(retiraParenteses($categoria));
		$retorno[$i]['termo'] = trim($termo);
		$i++;
	}
	return $retorno;	
	
}



$string = "[sem indicação] (Intérprete: ) / Corelli, Arcangelo, 1653-1713 (Compositor)";
$x = resumoAutoridades($string);
echo "<pre>";
var_dump($x);
echo "</pre>";

?>