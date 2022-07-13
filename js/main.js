var produto_global = "";

function limpa_formulário_cep() {
  //Limpa valores do formulário de cep.
  document.getElementById('logradouro').value = ("");
  document.getElementById('bairro').value = ("");
  document.getElementById('cidade').value = ("");
  document.getElementById('estado').value = ("");
}

function meu_callback(conteudo) {
  if (!("erro" in conteudo)) {
    //Atualiza os campos com os valores.
    document.getElementById('logradouro').value = (conteudo.logradouro);
    document.getElementById('bairro').value = (conteudo.bairro);
    document.getElementById('cidade').value = (conteudo.localidade);
    document.getElementById('estado').value = (conteudo.uf);
  } //end if.
  else {
    //CEP não Encontrado.
    limpa_formulário_cep();
    alert("CEP não encontrado.");
  }
}

function pesquisacep() {

  //Nova variável "cep" somente com dígitos.
  var cep = (document.getElementById('cep').value).replace(/\D/g, '');

  //Verifica se campo cep possui valor informado.
  if (cep != "") {

    //Expressão regular para validar o CEP.
    var validacep = /^[0-9]{8}$/;

    //Valida o formato do CEP.
    if (validacep.test(cep)) {

      //Preenche os campos com "..." enquanto consulta webservice.
      document.getElementById('logradouro').value = "...";
      document.getElementById('bairro').value = "...";
      document.getElementById('cidade').value = "...";
      document.getElementById('estado').value = "...";

      //Cria um elemento javascript.
      var script = document.createElement('script');

      //Sincroniza com o callback.
      script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

      //Insere script no documento e carrega o conteúdo.
      document.body.appendChild(script);

    } //end if.
    else {
      //cep é inválido.
      limpa_formulário_cep();
      alert("Formato de CEP inválido.");
    }
  } //end if.
  else {
    //cep sem valor, limpa formulário.
    limpa_formulário_cep();
  }
}

function abrirModal() {

  produto = document.getElementById("produto").value;

  const xmlhttp = new XMLHttpRequest();
  xmlhttp.onload = function () {
    response = JSON.parse(this.responseText);
    if (response.length) {
      html = "";
      response.forEach(produto => {
        html += `<tr>
              <th scope="row">${produto['nome']}</th>
              <td>${produto['referencia']}</td>
              <td>${produto['fornecedor']}</td>
              <td>R$`+ produto['preco'].replace('.', ',') + `</td>
              <td>
                <button onclick="
                selecionarProduto('${produto['id']}','${produto['nome']}','${produto['preco']}')
                " class="btn btn-outline-success">
                  <i class="fas fa-check icon-cursor"></i>
                </button>
              </td>
            </tr>`;
      });
      document.getElementById('mostrar-produtos').innerHTML = html;

      modal_produtos = new bootstrap.Modal('#modal-produtos', {
        keyboard: false
      })
      modal_produtos.show();
    }
    else {
      alert('Não existe produtos com essa referência ou esse nome.')
    }
  }
  xmlhttp.open("GET", "ajax/buscar-produtos.php?produto=" + produto);
  xmlhttp.send();

}

function selecionarProduto(id, nome, preco) {

  produto_global = nome;
  document.getElementById('id-produto').value = id;
  document.getElementById('produto').value = nome;
  document.getElementById('valor').value = 'R$' + preco.replace('.', ',');
  modal_produtos.hide();
}

var list = [];
//validando e printando erros
function validation() {

  var produto = document.getElementById("produto").value;
  var quantidade = document.getElementById("quantidade").value;
  var errors = "";
  document.getElementById("errors").style.display = "none";
  if (produto_global != produto) {
    errors += '<p>Nome do produto inválido.</p>';
  }
  if (!quantidade || quantidade == 0) {
    errors += '<p>Preencha o campo de quantidade</p>';
  }
  if (errors != "") {
    document.getElementById("errors").style.display = "block";
    document.getElementById("errors").innerHTML = "<h5>Aconteceu esse(s) erro(s):</h5>" + errors;
    return 0;
  } else {
    return 1;
  }
}

//adicionar novo produto
function addProduto() {

  if (!validation()) {
    return;
  }
  var id = document.getElementById("id-produto").value;
  var produto = document.getElementById("produto").value;
  var quantidade = document.getElementById("quantidade").value;
  var valor = document.getElementById("valor").value;


  list.unshift({
    "id": id, "produto": produto,
    "quantidade": quantidade,
    "valor": quantidade * (valor.replace(',', '.')).substring(2, 10)
  });
  setList(list);
  document.getElementById('id-produto').value = '';
  document.getElementById('produto').value = '';
  document.getElementById('valor').value = '';
}

//deletando os dados
function deleteData(id) {
  if (confirm("Gostaria de deletar esse produto?")) {
    if (id === list.length - 1) {
      list.pop();
    } else if (id === 0) {
      list.shift();
    } else {
      var arrAuxIni = list.slice(0, id);
      var arrAuxEnd = list.slice(id + 1);
      list = arrAuxIni.concat(arrAuxEnd);
    }
    setList(list);
  }
}

//criando a tabela
function setList(list) {
  var lista = '';
  for (var key in list) {
    lista += '<tr><td>' + list[key].produto + '</td><td>' + list[key].quantidade + '</td><td>' + formatValue(list[key].valor) + '</td><td> <button class="btn btn-outline-secondary" onclick="deleteData(' + key + ');">Delete</button></td></tr>';
  }

  document.getElementById('mostrar-lista').innerHTML = lista;
  getTotal(list);
  saveListStorage(list);
}

function formatValue(value) {
  var str = parseFloat(value).toFixed(2) + "";
  str = str.replace(".", ",");
  return 'R$' + str;
}

//salvando em storage
function saveListStorage(list) {
  var jsonStr = JSON.stringify(list);
  localStorage.setItem("list", jsonStr);
}

//somando total
function getTotal(list) {
  var total = 0;
  for (var key in list) {
    total += list[key].valor * list[key].quantidade;
  }
  document.getElementById("totalValue").innerHTML = formatValue(total);
}

function concluirVenda() {

  var errors = "";
  document.getElementById("errors-venda").style.display = "none";
  if (!list.length) {

    errors += '<p>Selecione ao menos um produto</p>';
  } else if (!document.getElementById("nome_cliente").value) {

    errors += '<p>Preencha o campo do nome do cliente</p>';
  } else if (
    !document.getElementById("cep").value ||
    !document.getElementById("logradouro").value ||
    !document.getElementById("num").value ||
    !document.getElementById("comp").value ||
    !document.getElementById("bairro").value ||
    !document.getElementById("cidade").value ||
    !document.getElementById("estado").value
  ) {

    errors += '<p>Preencha o endereço completo do cliente</p>';
  }
  if (errors != "") {

    document.getElementById("errors-venda").style.display = "block";
    document.getElementById("errors-venda").innerHTML = errors;
    return 0;
  } else {

    list[0]['nome_cliente'] = document.getElementById("nome_cliente").value;
    list[0]['cep'] = document.getElementById("cep").value;
    list[0]['logradouro'] = document.getElementById("logradouro").value;
    list[0]['numero'] = document.getElementById("num").value;
    list[0]['complemento'] = document.getElementById("comp").value;
    list[0]['bairro'] = document.getElementById("bairro").value;
    list[0]['cidade'] = document.getElementById("cidade").value;
    list[0]['estado'] = document.getElementById("estado").value;
    list[0]['valor_total'] = document.getElementById("totalValue").innerHTML;

    const json_data = JSON.stringify(list);
    //console.log(json_data);

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

        response = xmlhttp.responseText;
        alert(response);
        document.location.reload();
      }
    }
    xmlhttp.open("POST", "ajax/registrar-venda.php", true);
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlhttp.send("data=" + json_data);
  }
}