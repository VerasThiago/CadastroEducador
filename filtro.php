
<?php
    $conn = mysqli_connect("localhost", "root","","clientes");
   
    $filters = json_decode(file_get_contents('php://input'));


    // query base
    $query = "SELECT dadoscliente.nome, dadoscliente.cpf, entrevistacliente.nota_experiencia, entrevistacliente.nota_formacao, entrevistacliente.nota_entrevista
	FROM dadoscliente
	INNER JOIN entrevistacliente
	ON dadoscliente.id = entrevistacliente.user_id
	WHERE ";

    // pra cada chave dos filtros, adiciona como condições no WHERE
    for($i = 1; $i < count($filters); $i++) {
    	$pos = strlen($filters[$i]);
    	if($filters[$i][$pos-1] == '0'){
    		$filters[$i] = rtrim($filters[$i], '0');
    		$query .= 'hab_esporte_lazer ' . 'LIKE  ' . "'$filters[$i]'" . 'AND ';
    	}
    	else if($filters[$i][$pos-1] == '1'){
    		$filters[$i] = rtrim($filters[$i], '1');
    		$query .= 'hab_cultura_arte ' . 'LIKE  ' . "'$filters[$i]'" . 'AND ';
    	}
    	else if($filters[$i][$pos-1] == '2'){
    		$filters[$i] = rtrim($filters[$i], '2');
    		$query .= 'disponibilidade ' . 'LIKE  ' . "'$filters[$i]'" . 'AND ';
    	}
    	else $query .= $filters[$i] . ' = 1 ' . 'AND ';
    }
    // remove o ultimo AND 

    $query = rtrim($query, 'AND ');

    $query = $query . " ORDER BY (nota_experiencia+nota_formacao+nota_entrevista) DESC";
    
    // faz a query
    $result = mysqli_query($conn, $query);

 
    // adiciona em data
    $data = array();
    while($row = mysqli_fetch_assoc($result)){
        $data[]  = $row;
    }
 
    // retorna pro javascript as rows selecionadas
    echo json_encode($data);
?>

