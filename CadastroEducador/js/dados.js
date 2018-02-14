var ajax =  new XMLHttpRequest();
var method = "GET";
var url = "dados.php";
var asynchronous = true;
ajax.open(method, url, asynchronous);
ajax.send();

ajax.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
        var data = JSON.parse(this.responseText);
        var html = '<table id="myTable" style = "width : 100%;" ><tr class="header"><th  height: 20px; >CPF</th><th>Nome</th><th>Nota Experiência</th><th>Nota Formação</th><th>Nota Entrevista</th><th>Nota Total</th></tr>'
        for(var i = 0; i < data.length; i++){
          var total = parseInt(data[i].notaExperiencia) + parseInt(data[i].notaFormacao) + parseInt(data[i].notaEntrevista);
          html = html + '<tr><td><a onclick = "dados(&#39;' + data[i].user_id +  '&#39;)" href = "#">' + data[i].cpf + '</a></td> <td>' + data[i].nome + '</td><td>' + data[i].notaExperiencia + '</td><td>' + data[i].notaFormacao + '</td><td>' + data[i].notaEntrevista + '</td><td>' + (total) + '</td></tr>';
        }
        html = html + '</table>'
        document.getElementById("data").innerHTML= html;
    }    
}