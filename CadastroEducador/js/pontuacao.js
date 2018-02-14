var ajax =  new XMLHttpRequest();
var method = "GET";
var url = "pontuacao.php";
var asynchronous = true;
ajax.open(method, url, asynchronous);
ajax.send();

ajax.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
        var data = JSON.parse(this.responseText);
        var html = '<table id="myTable" style = "width : 100%;" ><tr class="header"><th ">Nota Experência</th><th ">Nota Formação</th></tr>'
        var i;
        for(i = 0; i < data.length; i++){
            console('nome = ' + data[i].nome);
        }
        html = html + '<tr><td>' + 0 + '</td> <td> ' + 0 + '</td></tr>';
        html = html + '</table>'
        document.getElementById("resultado").innerHTML= html;
    }    
}
