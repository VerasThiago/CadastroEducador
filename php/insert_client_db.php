<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
	$conn = mysqli_connect("localhost", "root","","clientes");

	$nome = $_POST["nome"];
	$mes = $_POST["mes"];
	$dia = $_POST["dia"];
	$ano = $_POST["ano"];
	$address = $_POST["address"];
	$fone = $_POST["fone"];
	$rg = $_POST["rg"];
	$cpf = $_POST["cpf"];
	$email = $_POST["email"];
	$data = $dia."-".$mes."-".$ano;

	if(mysqli_connect_errno($conn)){
		echo "failed to connect";
	}
	else{
		echo "connection successul<br>";
	}

	$sql = "INSERT INTO `dadoscliente`(`nome`, `nascimento`, `endereco`, `fone`, `rg`, `cpf`, `email`) VALUES ('$nome','$data','$address','$fone','$rg','$cpf','$email')";

	if(mysqli_query($conn,$sql)){
		echo "<script>alert('Dados salvos com sucesso!');</script>";
	}
	else{
		echo "<script type='javascript'>alert('Erro ao salvar os dados.');</script>";

	}
	echo "<script>window.history.back();</script>";
?>

</body>

</html>
