<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
	$conn = mysqli_connect("localhost", "root","","clientes");
	$bolsa = $_POST["programa"];
	$volun = $_POST["expVolun"];

	echo $bolsa . ' ' . $volun;

	$query = "SELECT nome FROM dadoscliente,entrevistacliente WHERE entrevistacliente.escrito_programa = '$bolsa' AND entrevistacliente.expVolun = '$volun'";

	$result = mysqli_query($conn, $query);



	$data = array();
	while($row = mysqli_fetch_assoc($result)){
		$data[]  = $row;
	}
	echo $bolsa . ' ' . $volun;

	echo json_encode($data);
	echo $bolsa . ' ' . $volun;

	
?>

</body>

</html>
