<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
	$conn = mysqli_connect("localhost", "root","","clientes");
	
	if( !(isset($_POST["integral"]) && isset($_POST["especializado"]) && isset($_POST["programa"])  && (isset($_POST["mat"]) || isset($_POST["vesp"]) ||isset($_POST["not"])))){
		echo "<script>alert('Preencha todos os campos!');</script>";
		echo "<script>window.history.back();</script>";
		die();		
	}
	$integral = $_POST["integral"];
	$especializado = $_POST["especializado"];
	$programa = $_POST["programa"];
	$nomeResp = $_POST["nomeResp"];
	$habArte = $_POST["habArte"];
	$habEsporte = $_POST["habEsporte"];
	$mat =  isset($_POST["mat"]) ? $_POST["mat"]:0;
	$vesp = isset($_POST["vesp"]) ? $_POST["vesp"]:0;
	$not = isset($_POST["not"]) ? $_POST["not"]:0;
	$unidadeEscolar = isset($_POST["unidadeEscolar"]) ? $_POST["unidadeEscolar"]:"";
	$habExtra = $_POST["habExtra"];
	$nome = $_POST["nome"];
	$disponibilidade = $mat . '-' . $vesp . '-' . $not;


	if(mysqli_connect_errno($conn)){
		echo "failed to connect";
	}
	else{
		echo "connection successul<br>";
	}


	$query = "SELECT id FROM dadoscliente WHERE dadoscliente.nome = '$nome'";

	$result = mysqli_query($conn, $query);
	$row=mysqli_fetch_assoc($result);
	date_default_timezone_set("America/Sao_Paulo");
	$tempo = date("Y/m/d") . " " .  date("h:i:sa");
	$id = $row["id"];

	$sql = "INSERT INTO `entrevistacliente`(`user_id`, `data/hora`, `educ_integral`, `atend_especi`, `escrito_programa`, `nome_responsavel`, `hab_cultura&arte`, `hab_esporte&lazer`, `disponibilidade`, `unidade_escolar`, `outras_habilidades`) VALUES ('$id','$tempo','$integral','$especializado','$programa','$nomeResp','$habArte','$habEsporte','$disponibilidade','$unidadeEscolar','$habExtra')";

	if(mysqli_query($conn,$sql)){
		echo "<script>alert('Dados salvos com sucesso!');</script>";
		echo "<script>window.history.back();</script>";
	}
	else{
		echo "<script type='javascript'>alert('Erro ao salvar os dados.');</script>";
	}

?>
</body>
</html>
