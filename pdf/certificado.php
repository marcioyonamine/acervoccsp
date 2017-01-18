
<?php 
//Exibe erros PHP
@ini_set('display_errors', '1');
error_reporting(E_ALL); 
   
   // INSTALAÇÃO DA CLASSE NA PASTA FPDF.
	//require_once("lib/fpdf/fpdf.php");
    require_once("../funcoes/funcoesConecta.php");
    require_once("../funcoes/funcoesGerais.php");
	require("cells_bold.php");

   //CONEXÃO COM BANCO DE DADOS 
   $con = bancoMysqli(); 
   
// logo da instituição 

$evento = recuperaDados("cla_evento",$_GET['evento'],"idEvento");
$participante = recuperaDados("cla_participantes",$_GET['participante'],"idParticipante");
$event = utf8_decode($evento['evento']); 

$nome = $participante['nomeCompleto'];
$text1 = $event;
$text_explode = explode('#',$evento['texto1']);
$text2 = utf8_decode($text_explode[0].$nome.$text_explode[2]);
$text3 = utf8_decode($evento['texto2']);





//CONSULTA 



// GERANDO O PDF:
$pdf = new PDF('L','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

 
$x=20;
$l=7; //DEFINE A ALTURA DA LINHA   
   
   $pdf->SetXY( $x , 40 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

	$pdf->SetXY(24, 45);
    $pdf->SetFont('Arial','', 14);
	$pdf->WriteText($text1);   

	$pdf->SetXY(24, 60);
    $pdf->SetFont('Arial','', 12);
	$pdf->MultiCell(180,6,$text2);
	//$pdf->WriteText($text2);   


	$pdf->SetXY(24, 110);
    $pdf->SetFont('Arial','', 10);
	 $pdf->MultiCell(0,5,$text3); 

$pdf->Output();


?>
