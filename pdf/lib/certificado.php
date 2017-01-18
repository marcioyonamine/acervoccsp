<?php 
   
   // INSTALAÇÃO DA CLASSE NA PASTA FPDF.
	require_once("lib/fpdf/fpdf.php");
    require_once("funcoesConecta.php");


   //CONEXÃO COM BANCO DE DADOS 
   $con = bancoMysqli(); 
   
// logo da instituição 

$evento = recuperaDados("evento",$_GET['evento'],"idEvento");
$participante = recuperaDados("participantes",$_GET['participante'],"idParticipante");

  
class PDF extends FPDF
{
// Page header
function Header()
{	
    // Logo
//    $this->Image('fundo.jpg');
  $this->Image('fundo.jpg',0,0,297);
    
    // Line break
    $this->Ln(20);
}

}



//CONSULTA 



// GERANDO O PDF:
$pdf = new PDF('L','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

   
$x=20;
$l=7; //DEFINE A ALTURA DA LINHA   
   
   $pdf->SetXY( $x , 40 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

   $pdf->SetXY($x, 40);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(53,$l,htmlentities($evento['evento']),0,0,'L');
   
   $pdf->SetXY($x, 55);
   $pdf->SetFont('Arial','', 10);
   $pdf->Cell(160,$l,"teste6",0,0,'L');
   

$pdf->Output();


?>