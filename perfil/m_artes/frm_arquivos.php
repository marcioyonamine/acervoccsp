<?php
$con = bancoMysqli();

if(isset($_POST['apagar'])){
	$con = bancoMysqli();
	$idArquivo = $_POST['apagar'];
	$sql_apagar_arquivo = "UPDATE acervo_arquivos SET publicado = '0' WHERE idArquivo = '$idArquivo'";
	if(mysqli_query($con,$sql_apagar_arquivo)){
		$arq = recuperaDados("acervo_arquivos",$idArquivo,"idArquivo");
		$mensagem =	"Arquivo ".$arq['arquivo']."apagado com sucesso!";
		//gravarLog($sql_apagar_arquivo);
	}else{
		$mensagem = "Erro ao apagar o arquivo. Tente novamente!";
	}
}
if(isset($_SESSION['idFaixa'])){
	$idDisco = $_SESSION['idFaixa'];
}else{
	$idDisco = $_SESSION['idDisco'];
}

if($_SESSION['idTabela'] == 87){
$disco = recuperaDados("acervo_discoteca",$idDisco,"idDisco");
}elseif($_SESSION['idTabela'] == 97){
$disco = recuperaDados("acervo_partituras",$idDisco,"idDisco");
	
}

$rec_reg = idReg($idDisco,$_SESSION['idTabela']);
$_SESSION['idReg'] = $rec_reg;
$registro = recuperaDados("acervo_registro",$rec_reg,"id_registro");

?>
<?php include "includes/menuArquivo.php" ?>


<section id="enviar" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">
				<div class="section-heading">
                                        <h1><?php echo $registro["titulo"] ?>  </h1>
<p><?php if(isset($mensagem)){echo $mensagem;} ?></p>
					 <h3>Envio de Arquivos</h3>
<p>Nesta página, você envia os arquivos como o rider, mapas de cenas e luz, logos de parceiros, programação de filmes de mostras de cinema, etc. O tamanho máximo do arquivo deve ser 60MB.</p>
				</div>


<?php
if( isset( $_POST['enviar'] ) ) {
    $pathToSave = '../uploads/';
    // A variavel $_FILES é uma variável do PHP, e é ela a responsável
    // por tratar arquivos que sejam enviados em um formulário
    // Nesse caso agora, a nossa variável $_FILES é um array com 3 dimensoes
    // e teremos de trata-lo, para realizar o upload dos arquivos
    // Quando é definido o nome de um campo no form html, terminado por []
    // ele é tratado como se fosse um array, e por isso podemos ter varios
    // campos com o mesmo nome
    $i = 0;
    $msg = array( );
    $arquivos = array( array( ) );
    foreach(  $_FILES as $key=>$info ) {
        foreach( $info as $key=>$dados ) {
            for( $i = 0; $i < sizeof( $dados ); $i++ ) {
                // Aqui, transformamos o array $_FILES de:
                // $_FILES["arquivo"]["name"][0]
                // $_FILES["arquivo"]["name"][1]
                // $_FILES["arquivo"]["name"][2]
                // $_FILES["arquivo"]["name"][3]
                // para
                // $arquivo[0]["name"]
                // $arquivo[1]["name"]
                // $arquivo[2]["name"]
                // $arquivo[3]["name"]
                // Dessa forma, fica mais facil trabalharmos o array depois, para salvar
                // o arquivo
                $arquivos[$i][$key] = $info[$key][$i];
            }
        }
    }
    $i = 1;
    // Fazemos o upload normalmente, igual no exemplo anterior
    foreach( $arquivos as $file ) {
        // Verificar se o campo do arquivo foi preenchido
        if( $file['name'] != '' ) {
			$con = bancoMysqli();
			$tipo = strtolower(extensaoArquivo($file['name']));
			$dataUnique = date('YmdHis');
            $arquivoTmp = $file['tmp_name'];
            $arquivo = $pathToSave.$dataUnique."_".semAcento($file['name']);
			$arquivo_base = $dataUnique."_".semAcento($file['name']);
			if(file_exists($arquivo)){
				echo "O arquivo ".$arquivo_base." já existe! Renomeie e tente novamente<br />";
			}else{
				//$idEvento = $_SESSION['idEvento'];
			//include "../include/conecta_mysql.php";
			$idReg = $_SESSION['idReg'];
			$sql = "INSERT INTO `acervo_arquivos` (`idArquivo`, `idReg`, `nome`, `tipo`, `publicado`, `destaque`) 
											VALUES (NULL, '$idReg', '$arquivo_base', '$tipo', '1', '0')";
											
			//$sql = "INSERT INTO ig_arquivo (idArquivo , arquivo , ig_evento_idEvento, publicado) VALUES( NULL , '$arquivo_base' , '$idEvento', '1' );";
			if(mysqli_query($con,$sql)){
				$men = "Bd ok";
					
			}
			/*
			else{
				$men = "Erro Bd - $sql";	
			}
			*/
			//gravarLog($sql);
			
            if( !move_uploaded_file( $arquivoTmp, $arquivo ) ) {
                $msg[$i] = 'Erro no upload do arquivo '.$i;
            } else {
                $msg[$i] = sprintf('Upload do arquivo %s foi um sucesso!',$i);
            }
			}
       } 
        $i++;
    }
    // Imprimimos as mensagens geradas pelo sistema
 foreach( $msg as $e ) {
	 	echo " <div id = 'mensagem_upload'>";
        printf('%s<br>', $e);
		echo " </div>";
    }
}
?>

<br />
<div class = "center">
<form method='POST' action="?perfil=discoteca&p=frm_arquivos" enctype='multipart/form-data'>
<p><input type='file' name='arquivo[]'></p>
<p><input type='file' name='arquivo[]'></p>
 <p><input type='file' name='arquivo[]'></p>
 <p><input type='file' name='arquivo[]'></p>
 <p><input type='file' name='arquivo[]'></p>
 <p><input type='file' name='arquivo[]'></p>
 <p><input type='file' name='arquivo[]'></p>
  <p><input type='file' name='arquivo[]'></p>
  <p><input type='file' name='arquivo[]'></p>
    <br>
    <input type="submit" class="btn btn-theme btn-lg btn-block" value='Enviar' name='enviar'>
</form>



                 </div> 
			  </div>
			  
		</div>
		</div>
	</section>

<section id="list_items" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">
				<div class="section-heading">
 <h2>Arquivos anexados</h2>
<h5>Se na lista abaixo, o seu arquivo começar com "http://", por favor, clique, grave em seu computador, faça o upload novamente e apague a ocorrência citada.</h5>
				</div>
					<div class="table-responsive list_info">
                         <?php listaArquivosRegistro($_SESSION['idReg']); ?>
					</div>
		  </div>
	</div>  
	</div>
</section>
