<?php
	// receber o nome do cliente mandado por ajax para buscar todos seus dados
		
	$conn = mysqli_connect("localhost", "root","","clientes");

	$query = "SELECT * FROM entrevistacliente,dadoscliente ..."; //completara sql

	$result = mysqli_query($conn, $query);



	$data = array();
	while($row = mysqli_fetch_assoc($result)){
		$data[]  = $row;
	}
	echo json_encode($data);
