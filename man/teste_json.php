


<?php 



if(isset($_POST)){
	var_dump($_POST);
}



?>

<form action="?" method="post">
<INPUT TYPE="checkbox" NAME="OPCAO[]" VALUE="op1"> opção1
<INPUT TYPE="checkbox" NAME="OPCAO[]" VALUE="op2"> opção2
<INPUT TYPE="checkbox" NAME="OPCAO[]" VALUE="op3"> opção3
<input type="submit" value="enviar">
</form>