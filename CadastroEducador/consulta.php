<?php
	
	$conn = mysqli_connect("localhost", "root","","clientes");

	$query = "SELECT nome,cpf,nota FROM entrevistacliente,dadoscliente WHERE entrevistacliente.user_id = dadoscliente.id ORDER BY nota DESC";

	$result = mysqli_query($conn, $query);



	$data = array();
	while($row = mysqli_fetch_assoc($result)){
		$data[]  = $row;
	}
	echo json_encode($data);
