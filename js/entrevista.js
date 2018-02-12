function passingName(){
    if(localStorage.getItem("data")){
        data = localStorage.getItem("data");
        var aux = data.split(" ");
        var nome = aux[0];
        
	    if(aux.length >= 2){
	    	nome = nome + " " + aux[1];
	    	if(aux[1].toLowerCase() == 'da') nome = nome + " " + aux[2];
	    }
        document.getElementById("teste").innerHTML  = '<h2>Entrevista:<br> ' + nome + '</h2>';
        document.getElementById("element_14").value = data;
    }
}