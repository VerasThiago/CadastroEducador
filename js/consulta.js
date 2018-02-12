var ajax =  new XMLHttpRequest();
var method = "GET";
var url = "consulta.php";
var asynchronous = true;
ajax.open(method, url, asynchronous);
ajax.send();

ajax.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
        var data = JSON.parse(this.responseText);
        var html = '<table id="myTable" style = "width : 100%;" ><tr class="header"><th style="width:20px; height: 20px; ">CPF</th><th style="width:20px;">Nome</th><th style="width:20px;">Nota</th></tr>'
        //var html = ' <table id="myTable" style = "width: 100%; height: 400px; overflow: auto">';
        for(var i = 0; i < data.length; i++){
            var firstName = data[i].nome;
            var cpf = data[i].cpf
            var nota = data[i].nota;
            html = html + '<tr><td><a onclick = "interview(&#39;' + firstName +  '&#39;)" href = "#">' + cpf + '</a></td> <td>' + firstName + '</td><td>' + nota + '</td></tr>';
        }
        html = html + '</table>'
        document.getElementById("data").innerHTML= html;
    }    
}

function filtroCPF() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
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