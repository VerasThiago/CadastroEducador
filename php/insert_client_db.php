<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
	$conn = mysqli_connect("localhost", "root","","clientes"); // Conxão com o banco de dados

	$nome = $_POST["nome"];
	$mes = $_POST["mes"];
	$dia = $_POST["dia"];
	$ano = $_POST["ano"];
	$address = $_POST["address"];
	$fone = $_POST["fone"];
	$rg = $_POST["rg"];
	$cpf = $_POST["cpf"];
	$email = $_POST["email"];
	$data = $dia."-".$mes."-".$ano; //montando data pra dd-mm-aa
	
	if(!is_numeric($cpf)){ // Validando cpf, apenas numeros
		echo "<script>alert('CPF inválido, digite apenas números!');</script>";
		echo "<script>window.history.back();</script>";
		die();
	}
	

	if(mysqli_connect_errno($conn)){//Testando conexão
		echo "failed to connect";
	}
	else{
		echo "connection successul<br>";
	}

	//sql para salvar no banco
	$sql = "INSERT INTO `dadoscliente`(`nome`, `nascimento`, `endereco`, `fone`, `rg`, `cpf`, `email`) VALUES ('$nome','$data','$address','$fone','$rg','$cpf','$email')";

	if(mysqli_query($conn,$sql)){//executa a query e verifica se deu sucesso
		echo "<script>alert('Dados salvos com sucesso!');</script>";
		echo "<script>window.location='http://localhost/CadastroEducador';</script>"; //Volta para a página inicial
	}
	else{
		echo "<script type='javascript'>alert('Erro ao salvar os dados.');</script>";
		echo "<script>window.history.back();</script>";

	}
?>

</body>

</html>
