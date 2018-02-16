<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
	$conn = mysqli_connect("localhost", "root","","clientes");
	
	if( !( isset($_POST["expLei"]) && isset($_POST["merenda"]) && isset($_POST["expVolun"]) && isset($_POST["expDesenvolvida"]) && isset($_POST["uism"]) && isset($_POST["integral"]) && isset($_POST["especializado"]) && isset($_POST["programa"])  && (isset($_POST["mat"]) || isset($_POST["vesp"]) ||isset($_POST["not"])))){
		echo "<script>alert('Preencha todos os campos!');</script>";
		echo "<script>window.history.back();</script>";
		die();		
	}
	$integral = $_POST["integral"];
	$especializado = $_POST["especializado"];
	$programa = $_POST["programa"];
	$uism = $_POST["uism"];
	$merenda = $_POST["merenda"];
	$nomeResp = $_POST["nomeResp"];
	$habArte = isset($_POST["arte0"]) ? 1:0;
	$expVolun = $_POST["expVolun"];
	$anosExp = $_POST["anosExp"];
	if(!is_numeric($anosExp)){
		echo "<script>alert('Anos de Experiência inválido');</script>";
		echo "<script>window.history.back();</script>";
		die();
	}
	$expDesenvolvida = $_POST["expDesenvolvida"];
	$expLei	 = $_POST["expLei"];
	$habEsporte = isset($_POST["esporte0"]) ? 1:0;
	$cursoSU = $_POST["cursoSU"];
	$cursoEM = $_POST["cursoEM"];

	$notaExperiencia =  0;
	$notaExperiencia +=  (5*$programa);
	$notaExperiencia +=  (5*$expVolun) + $anosExp;
	$notaExperiencia +=  (5*$expDesenvolvida);
	$notaExperiencia +=  (5*$expLei);

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


	


	$mat =  isset($_POST["mat"]) ? 1:0;
	$vesp = isset($_POST["vesp"]) ? 1:0;
	$not = isset($_POST["not"]) ? 1:0;


	$unidadeEscolar = isset($_POST["unidadeEscolar"]) ? $_POST["unidadeEscolar"]:"";

	$nome = $_POST["nome"];

	$disponibilidade = $mat . '-' . $vesp . '-' . $not;

	$notaEntrevista	= 0;
	$notaFormacao = 0;
	if(mysqli_connect_errno($conn)){
		echo "failed to connect";
		die();
	}
	else{
		echo "connection successul<br>";
	}

	$outrasHab	= "";
	$query = "SELECT id FROM dadoscliente WHERE dadoscliente.nome = '$nome'";
	$result = mysqli_query($conn, $query);
	$row=mysqli_fetch_assoc($result);
	date_default_timezone_set("America/Sao_Paulo");
	$tempo = date("Y/m/d") . " " .  date("h:i:sa");
	$id = $row["id"];
	echo "id = " . $id . "<br>";

	$apresentacao = array();
	$apresentacao[0] = isset($_POST["apreRuim"]) ? 1:0;
	$apresentacao[1] = isset($_POST["apreRegular"]) ? 1:0;
	$apresentacao[2] = isset($_POST["apreBoa"]) ? 1:0;
	$apresentacao[3] = isset($_POST["apreExcelente"]) ? 1:0;

	$comunicacao = array();
	$comunicacao[0] = isset($_POST["comuRuim"]) ? 1:0;
	$comunicacao[1] = isset($_POST["comuRegular"]) ? 1:0;
	$comunicacao[2] = isset($_POST["comuBoa"]) ? 1:0;
	$comunicacao[3] = isset($_POST["comuExcelente"]) ? 1:0;

	$demonstracao = array();
	$demonstracao[0] = isset($_POST["demoRuim"]) ? 1:0;
	$demonstracao[1] = isset($_POST["demoRegular"]) ? 1:0;
	$demonstracao[2] = isset($_POST["demoBoa"]) ? 1:0;
	$demonstracao[3] = isset($_POST["demoExcelente"]) ? 1:0;

	$dispo = array();
	$dispo[0] = isset($_POST["dispoRuim"]) ? 1:0;
	$dispo[1] = isset($_POST["dispoRegular"]) ? 1:0;
	$dispo[2] = isset($_POST["dispoBoa"]) ? 1:0;
	$dispo[3] = isset($_POST["dispoExcelente"]) ? 1:0;

	$superior = array();
	$superior[0] = isset($_POST["superiorComp"]) ? 1:0;
	$superior[1] = isset($_POST["superiorIncom"]) ? 1:0;
	$superior[2] = isset($_POST["superiorNulo"]) ? 1:0;

	$ensinoMedio = array();
	$ensinoMedio[0] = isset($_POST["ensinomComp"]) ? 1:0;
	$ensinoMedio[1] = isset($_POST["ensinomIncom"]) ? 1:0;
	$ensinoMedio[2] = isset($_POST["ensinomNulo"]) ? 1:0;

	$check = 0;
	$respSuperior = 0;
	$respEnsinoMedio = 0;
	for($i = 0; $i < 3; $i++){
		echo "sup = " . $superior[$i] . " medio = " . $ensinoMedio[$i] . "<br>";
		$check += $superior[$i];
		$check += $ensinoMedio[$i];
		if($superior[$i] == 1) $respSuperior = $i;
		if($ensinoMedio[$i] == 1) $respEnsinoMedio = $i;
	}
	if($check != 2){
		echo "<script>alert('Dados sobre formação incorreto!');</script>";
		echo "<script>window.history.back();</script>";
		die();
	}
	if($superior[0] == 1) $notaFormacao	+= 10;
	if($superior[1] == 1) $notaFormacao	+= 6;
	if($ensinoMedio[0] == 1) $notaFormacao+= 5;
	if($ensinoMedio[1] == 1) $notaFormacao+= 3;


	$check = 0;

	for($i = 0; $i < 4; $i++){
		$check += $apresentacao[$i];
		$check += $comunicacao[$i];
		$check += $demonstracao[$i];
		$check += $dispo[$i];
	}
	if($check != 4){
		echo "<script>alert('Dados da entrevista incorreto!');</script>";
		echo "<script>window.history.back();</script>";
		die();
	}
	for($i = 1; $i < 4; $i++){
		$notaEntrevista	 += (pow(2, $i)*$apresentacao[$i]);
		$notaEntrevista	 += (pow(2, $i)*$comunicacao[$i]);
		$notaEntrevista	 += (pow(2, $i)*$demonstracao[$i]);
		$notaEntrevista	 += (pow(2, $i)*$dispo[$i]);
	}
	if($dispo[3] == 1) $notaEntrevista-=2;

	
	
	$sql = "INSERT INTO `entrevistacliente`(`user_id`, `data/hora`, `educ_integral`, `superior`, `ensinoMedio`, `atend_especi`, `escrito_programa`, `nome_responsavel`, `cursoSU`, `cursoEM`, `hab_cultura&arte`, `outroArte`, `hab_esporte&lazer`, `outroEsporte`, `expVolun`, `anosExp`, `disponibilidade`, `unidade_escolar`, `expLei`, `expDesenvolvida`, `notaExperiencia`, `notaFormacao`, `notaEntrevista`) VALUES ('$id','$tempo','$integral','$respSuperior','$respEnsinoMedio','$especializado','$programa','$nomeResp','$cursoSU','$cursoEM','$habArte','$outroArte','$habEsporte','$outroEsporte','$expVolun','$anosExp','$disponibilidade','$unidadeEscolar','$expLei','$expDesenvolvida','$notaExperiencia','$notaFormacao','$notaEntrevista')";
	if(mysqli_query($conn,$sql)){
		echo "<script>alert('Dados salvos com sucesso!');</script>";
		echo "<script>window.location='http://localhost/CadastroEducador';</script>";
	}
	else{
		echo "<script>alert('Error ao salvar os dados222!');</script>";

	}

?>
</body>
</html>
