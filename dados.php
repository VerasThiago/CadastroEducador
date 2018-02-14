<?php
	
	$conn = mysqli_connect("localhost", "root","","clientes");

	$query = "SELECT * FROM entrevistacliente,dadoscliente WHERE entrevistacliente.user_id = dadoscliente.id ORDER BY (notaExperiencia+notaFormacao+notaEntrevista) DESC";

	$result = mysqli_query($conn, $query);



	$data = array();
	while($row = mysqli_fetch_assoc($result)){
		$data[]  = $row;
	}
	echo json_encode($data);
