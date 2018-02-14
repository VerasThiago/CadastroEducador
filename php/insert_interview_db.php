<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
	$conn = mysqli_connect("localhost", "root","","clientes");
	
	if( !(isset($_POST["integral"]) && isset($_POST["notaEntrevista"]) && isset($_POST["especializado"]) && isset($_POST["programa"])  && (isset($_POST["mat"]) || isset($_POST["vesp"]) ||isset($_POST["not"])))){
		echo "<script>alert('Preencha todos os campos!');</script>";
		echo "<script>window.history.back();</script>";
		die();		
	}
	$nota = 0;
	$integral = $_POST["integral"] == 2 ? 0:1;
	$nota +=  $integral == 1 ? 5:0;
	$especializado = $_POST["especializado"] == 2 ? 0:1;
	$nota +=  $especializado == 1 ? 5:0;
	$programa = $_POST["programa"] == 2 ? 0:1;
	$nota +=  $programa == 1 ? 5:0;

	$nomeResp = $_POST["nomeResp"];
	$habArte = isset($_POST["arte0"]) ? 1:0;
	$habEsporte = isset($_POST["esporte0"]) ? 1:0;
	if( !isset($_POST["arte12"]) || !isset($_POST["esporte18"])) $nota += 5;
	$idx = "arte";
	$ok1 = 0;
	$ok2 = 0;
	if($habArte == 1 )$ok1 = 1;
	if($habEsporte == 1)$ok2 = 1;
	for($i = 1; $i < 13; $i++){
		$aux = isset($_POST[$idx.$i]) ? 1:0;
		$habArte = $habArte . "-" . $aux;
		if($aux == 1) $ok1 = 1;
	}
	$outroArte = isset($_POST["arte13"]) ? $_POST["arte13"]:"";
	$idx = "esporte";
	for($i = 1; $i < 19; $i++){
		$aux = isset($_POST[$idx.$i]) ? 1:0;
		$habEsporte = $habEsporte . "-" . $aux;
		if($aux == 1) $ok2 = 1;
	}

	if($ok1 == 0 || $ok2 == 0){
		echo "<script>alert('Preencha todos os campos!');</script>";
		echo "<script>window.history.back();</script>";
		die();		
	}
	$outroEsporte = isset($_POST["esporte19"]) ? $_POST["esporte19"]:"";

	$outrasHab = isset($_POST["nadaOutrasHab"]) ? "":0;

	if($outrasHab == 0){
		$outrasHab = "";
		$merendeiro = isset($_POST["merend"]) ? "Merendeiro, ":"";
		$resto = $_POST["outrasHab"];
		$outrasHab = $outrasHab .  $merendeiro . $resto;
		$nota += 5;
	}


	$mat =  isset($_POST["mat"]) ? 1:0;
	$vesp = isset($_POST["vesp"]) ? 1:0;
	$not = isset($_POST["not"]) ? 1:0;

	if($mat + $vesp + $not > 1) $nota += 5 * ($mat + $vesp + $not - 1);

	$unidadeEscolar = isset($_POST["unidadeEscolar"]) ? $_POST["unidadeEscolar"]:"";

	$nome = $_POST["nome"];

	$disponibilidade = $mat . '-' . $vesp . '-' . $not;

	$notaEntrevista = $_POST["notaEntrevista"];

	if(!is_numeric($notaEntrevista)){
		echo "<script>alert('Nota para entrevista incorreta!');</script>";
		echo "<script>window.history.back();</script>";
		die();		
	}

	if(mysqli_connect_errno($conn)){
		echo "failed to connect";
		die();
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
	echo "id = " . $id;
	$sql = "INSERT INTO `entrevistacliente`(`user_id`, `data/hora`, `educ_integral`, `atend_especi`, `escrito_programa`, `nome_responsavel`, `hab_cultura&arte`, `outroArte`, `hab_esporte&lazer`, `outroEsporte`, `disponibilidade`, `unidade_escolar`, `outras_habilidades`, `notaExperiencia`, `notaFormacao`, `notaEntrevista`) VALUES ('$id','$tempo','$integral','$especializado','$programa','$nomeResp','$habArte','$outroArte', '$habEsporte', '$outroEsporte', '$disponibilidade','$unidadeEscolar','$outrasHab', '$nota', '0', '$notaEntrevista')";
	if(mysqli_query($conn,$sql)){
		echo "<script>alert('Dados salvos com sucesso!');</script>";
		echo "<script>window.location='http://localhost/CadastroEducador';</script>";
	}
	else{
		echo "<script>alert('Deu merda!');</script>";

	}

?>
</body>
</html>
