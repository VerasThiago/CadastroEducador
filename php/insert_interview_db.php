<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
	$conn = mysqli_connect("localhost", "root","","clientes");
	
	// verificando se o usuário nao esqueceu de marcar alguma das opções
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
	$expDesenvolvida = $_POST["expDesenvolvida"];
	$expLei	 = $_POST["expLei"];
	$habEsporte = isset($_POST["esporte0"]) ? 1:0;
	$cursoSU = $_POST["cursoSU"];
	$cursoEM = $_POST["cursoEM"];
	$outroEsporte = isset($_POST["esporte19"]) ? $_POST["esporte19"]:"";
	$outroArte = isset($_POST["arte13"]) ? $_POST["arte13"]:"";
	$mat =  isset($_POST["mat"]) ? 1:0;
	$vesp = isset($_POST["vesp"]) ? 1:0;
	$not = isset($_POST["not"]) ? 1:0;
	$nome = $_POST["nome"];
	$disponibilidade = $mat . '-' . $vesp . '-' . $not; //formato do turno 1-0-1 onde numero 1 significa que marcou e 0 nao, nas posições mat, vesp, not
	$unidadeEscolar = isset($_POST["unidadeEscolar"]) ? $_POST["unidadeEscolar"]:"";


	
	// nota da experiência de acordo com o edital
	$notaExperiencia =  0;
	$notaExperiencia +=  (5*$programa);
	$notaExperiencia +=  (5*$expVolun) + $anosExp;
	$notaExperiencia +=  (5*$expDesenvolvida);
	$notaExperiencia +=  (5*$expLei);

	
	//gerando a string para salvar todas as habilidades de arte e esporte no formar 1-0-0-1-1-0 ... onde 1 na posição x = habilidade x foi marcada
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
	$idx = "esporte";
	for($i = 1; $i < 19; $i++){
		$aux = isset($_POST[$idx.$i]) ? 1:0;
		$habEsporte = $habEsporte . "-" . $aux;
		if($aux == 1) $ok2 = 1;
	}



	if($ok1 == 0 || $ok2 == 0){ //verificando se marcou pelo menos 1 habilidade
		echo "<script>alert('Preencha todos os campos!');</script>";
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


	// Pegando o ID do usuário que será salvo a entrevista, o nome dele veio do js que alterou o valor de um botão que estava com diplay : none
	$query = "SELECT id FROM dadoscliente WHERE dadoscliente.nome = '$nome'"; /
	$result = mysqli_query($conn, $query);
	$row=mysqli_fetch_assoc($result);
	$id = $row["id"];


	//Setando a função para armazenar a hora do cadastro no tempo do Brasil
	date_default_timezone_set("America/Sao_Paulo");
	$tempo = date("Y/m/d") . " " .  date("h:i:sa");

	$apresentacao = array(); //REFAZER todos esses botões de check box para type="radio" e trocar o value de cada botao para a nota que ele mesmo representa para depois facilitar na soma da nota
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
	$superior[0] = isset($_POST["superiorNulo"]) ? 1:0;
	$superior[1] = isset($_POST["superiorComp"]) ? 1:0;
	$superior[2] = isset($_POST["superiorIncom"]) ? 1:0;

	$ensinoMedio = array();
	$ensinoMedio[0] = isset($_POST["ensinomNulo"]) ? 1:0;
	$ensinoMedio[1] = isset($_POST["ensinomIncom"]) ? 1:0;
	$ensinoMedio[2] = isset($_POST["ensinomComp"]) ? 1:0;



	//Checkando se marcou mais de 1 opções ou deixou de marcar alguma
	$check = 0;
	$respSuperior = 0;
	$respEnsinoMedio = 0;
	for($i = 0; $i < 3; $i++){ //Depois trocar a caixa sobre o ensino para uma de somente 1 escolha
		$check += $superior[$i];
		$check += $ensinoMedio[$i];
		if($superior[$i] == 1) $respSuperior = $i; //armazenando a resposta marcada nas opções 0,1,2
		if($ensinoMedio[$i] == 1) $respEnsinoMedio = $i;
	}
	if($check != 2){ 
		echo "<script>alert('Dados sobre formação incorreto!');</script>";
		echo "<script>window.history.back();</script>";
		die();
	}


	// calculando nota sobre formação
	$notaFormacao = 0;
	if($superior[1] == 1) 			$notaFormacao+= 10;
	else if($superior[2] == 1)  	$notaFormacao+= 6;
	if($ensinoMedio[1] == 1) 		$notaFormacao+= 5;
	else if($ensinoMedio[2] == 1) 	$notaFormacao+= 3;



	//checando se marcou mais de 1 opção na entrevista
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



	//calculando nota da entrevista
	$notaEntrevista	= 0;
	for($i = 1; $i < 4; $i++){
		$notaEntrevista	 += (pow(2, $i)*$apresentacao[$i]);
		$notaEntrevista	 += (pow(2, $i)*$comunicacao[$i]);
		$notaEntrevista	 += (pow(2, $i)*$demonstracao[$i]);
		$notaEntrevista	 += (pow(2, $i)*$dispo[$i]);
	}
	if($dispo[3] == 1) $notaEntrevista-=2; // -=2 pois a melhor nota pra disponibilidade da entrevista vale 6 e nao 8


	
	if(!is_numeric($anosExp)){ //Checando se digitou alguma letra
		echo "<script>alert('Anos de Experiência inválido');</script>";
		echo "<script>window.history.back();</script>";
		die();
	}
	
	
	//códido sql para inserir tudo
	$sql = "INSERT INTO `entrevistacliente`(`user_id`, `data_hora`, `educ_integral`, `atend_especi`, `uism`, `merenda`, `superior`, `ensino_medio`, `escrito_programa`, `nome_responsavel`, `curso_su`, `curso_em`, `hab_cultura_arte`, `outro_arte`, `hab_esporte_lazer`, `outro_esporte`, `exp_volun`, `anos_exp`, `disponibilidade`, `unidade_escolar`, `exp_lei`, `exp_desenvolvida`, `nota_experiencia`, `nota_formacao`, `nota_entrevista`)	VALUES('$id','$tempo','$integral','$especializado','$uism','$merenda','$respSuperior','$respEnsinoMedio','$programa','$nomeResp','$cursoSU','$cursoEM','$habArte','$outroArte','$habEsporte','$outroEsporte','$expVolun','$anosExp','$disponibilidade','$unidadeEscolar','$expLei','$expDesenvolvida','$notaExperiencia','$notaFormacao','$notaEntrevista')";
	
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
