function integral(){
	document.getElementById("about").style.display = "none";
	document.getElementById("penes").style.display = "block";
}
function volta(){
	document.getElementById("about").style.display = "block";
	document.getElementById("penes").style.display = "none";
}

function printando(){
	var ajax =  new XMLHttpRequest();
	var method = "GET";
	var url = "teste.php";
	var asynchronous = true;
	ajax.open(method, url, asynchronous);
	ajax.send();
	ajax.onreadystatechange = function(){
	    if(this.readyState == 4 && this.status == 200){
	    	console.log('OLAAAA');
	        var data = JSON.parse(this.responseText);
	        for(var i = 0; i < data.length; i++){
	        	console.log('nomeeeeee = ' + data[i].nome + ' cpf = ' + data[i].cpf);
	        }
	    }    
	}
}