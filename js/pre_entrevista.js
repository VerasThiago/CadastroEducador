var ajax =  new XMLHttpRequest(); //Mostrar todos os contratados
var method = "GET";
var url = "pre_entrevista.php";
var asynchronous = true;
ajax.open(method, url, asynchronous);
ajax.send();

ajax.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
        var data = JSON.parse(this.responseText);
        var html = '<table id="myTable" style = "width : 100%;" ><tr class="header"><th style="width:20px; height: 20px; ">CPF</th><th style="width:20px;">Nome</th></tr>'
        //var html = ' <table id="myTable" style = "width: 100%; height: 400px; overflow: auto">';
        for(var i = 0; i < data.length; i++){
            var firstName = data[i].nome;
            var cpf = data[i].cpf
            html = html + '<tr><td><a onclick = "interview(&#39;' + firstName +  '&#39;)" href = "#">' + cpf + '</a></td> <td><a onclick = "interview(&#39;' + firstName +  '&#39;)" href = "#">' + firstName + '</a></td></tr>';
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

function interview(name){ // Aqui onde salvo na web o nome do cliente para poder pegar na outra página e conseguir salvar no banco de dados linkado com seu nome
    if(typeof(Storage) !== "undefined") {
        localStorage.setItem("data",name);
    }
    window.location='http://localhost/CadastroEducador/entrevista.html';
}