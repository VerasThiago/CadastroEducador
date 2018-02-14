<?php
	$conn = mysqli_connect("localhost", "root","","clientes");

	if(mysqli_connect_errno($conn)){
		echo "<script>alert('Failed to connect');</script>";
	}
	else{
		echo "<script>alert('Conection success!');</script>";
	}
	$query = "SELECT * FROM dadoscliente";
	$result = mysqli_query($conn,$query);
	if (!$result) {
		echo "<script>alert('Invalid query:');</script>";
		die('Invalid query: ' . mysql_error());
	}
	else{
		echo "<script>alert('Query success:');</script>";
	}
	header("Content-type: text/xml");

	echo '<dadoscliente>';

	while ($row = mysql_fetch_assoc($result)){
	  // Add to XML document node
	  echo '<dado ';
	  echo 'nome="' . $row['nome'] . '" ';
	  echo '/>';
	}
	// End XML file
	echo '</dadoscliente>';
?>