function todos(){
    document.getElementById("todos").style.display = "block";
    var ajax =  new XMLHttpRequest();
    var method = "GET";
    var url = "consulta.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.send();

    ajax.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var data = JSON.parse(this.responseText);
            var html = '<table id="myTable2" style = "width : 100%;" ><tr class="header"><th  height: 20px; >CPF</th><th>Nome</th><th>Nota Experi&#234;ncia</th><th>Nota Forma&#231;&#227;o</th><th>Nota Entrevista</th><th>Total</th></tr>'
            for(var i = 0; i < data.length; i++){
              var total = parseInt(data[i].nota_experiencia) + parseInt(data[i].nota_formacao) + parseInt(data[i].nota_entrevista);
              html = html + '<tr><td>' + data[i].cpf + '</td> <td>' + data[i].nome + '</td><td>' + data[i].nota_experiencia + '</td><td>' + data[i].nota_formacao + '</td><td>' + data[i].nota_entrevista + '</td><td>' + (total) + '</td></tr>';
            }
            html = html + '</table>'
            document.getElementById("todos").innerHTML= html;
        }    
    }
}

function voltar(){
    document.getElementById("data").style.display = "none";
    document.getElementById("todos").style.display = "block";

}

function printando(filters){
    document.getElementById("data").style.display = "block";
    document.getElementById("todos").style.display = "none";

    console.log('CHEGOU O TESTE ' + filters[1]);
    var ajax =  new XMLHttpRequest();
    var method = "POST";
    var url = "filtro.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/json")
    ajax.send(JSON.stringify(filters));
    ajax.onreadystatechange = function(){
    	if(this.readyState == 4 && this.status == 200){
        	var data = JSON.parse(this.responseText);
            var html = '<table id="myTable" style = "width : 100%;" ><tr class="header"><th  height: 20px; >CPF</th><th>Nome</th><th>Nota Experi&#234;ncia</th><th>Nota Forma&#231;&#227;o</th><th>Nota Entrevista</th><th>Total</th></tr>'
            for(var i = 0; i < data.length; i++){
              var total = parseInt(data[i].nota_experiencia) + parseInt(data[i].nota_formacao) + parseInt(data[i].nota_entrevista);
              html = html + '<tr><td>' + data[i].cpf + '</td> <td>' + data[i].nome + '</td><td>' + data[i].nota_experiencia + '</td><td>' + data[i].nota_formacao + '</td><td>' + data[i].nota_entrevista + '</td><td>' + (total) + '</td></tr>';
            }
            html = html + '</table>'
            document.getElementById("data").innerHTML= html;
        }
    }
}
function filtroCPF() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  var id = document.getElementById("todos").style.display == "block" ? "myTable2":"myTable";
  table = document.getElementById(id);
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}



$(document).ready(function(){
  $('#framework').multiselect({
    nonSelectedText: 'Escolha os filtros',
    enableFiltering: true,
    enableCaseInsensitiveFiltering: true,
    buttonWidth:'800px'
  });

  $('#framework_form').on('submit', function(event){
    event.preventDefault();
    var form_data = $(this).serialize();
    var aux = form_data.split('framework%5B%5D=');
    for(var i = 0; i < aux.length; i++){
      aux[i] = aux[i].replace("&","");
    }
    var n = [37,25,5];
    for(var i = 1; i < aux.length; i++){
      var pos = parseInt(aux[i].slice(0,-1));
      if(aux[i][aux[i].length - 1] == '0' || aux[i][aux[i].length - 1] == '1' || aux[i][aux[i].length - 1] == '2'){
        var num = parseInt(aux[i][aux[i].length - 1]);
        var string = "";
        for(var j = 0; j < n[num] ; j++){
          if(j == pos){
            string += '1';
          }
          else if(j%2==0){
            string += '_%';
          }
          else{
            string += '-';
          }
        }
        string += aux[i][aux[i].length - 1];
        aux[i] = string;
      }
    }
    printando(aux);
  });
});
