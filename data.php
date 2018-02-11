<?php
	
	$conn = mysqli_connect("localhost", "root","","clientes");

	$query = "SELECT * FROM `dadoscliente`";

	$result = mysqli_query($conn, $query);



	$data = array();
	while($row = mysqli_fetch_assoc($result)){
		$data[]  = $row;
	}

	echo json_encode($data);
