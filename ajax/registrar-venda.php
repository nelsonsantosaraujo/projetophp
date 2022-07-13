<?php
  
  include("../conexao/conexao.php");
  // DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
  date_default_timezone_set('America/Sao_Paulo');
  // CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
  $dataLocal = date('d/m/Y H:i:s', time());
  
  $data = $_POST['data'];
  $items = json_decode($data,true);

  $query_inserir_venda = "
    INSERT INTO venda (nome_cliente, cep, logradouro,
    numero,complemento,bairro,cidade,uf,total_venda,data) 
    VALUES(
      '".$items[0]['nome_cliente']."',
      '".$items[0]['cep']."',
      '".$items[0]['logradouro']."',
      '".$items[0]['numero']."',
      '".$items[0]['complemento']."',
      '".$items[0]['bairro']."',
      '".$items[0]['cidade']."',
      '".$items[0]['estado']."',
      '".$items[0]['valor_total']."',
      '".$dataLocal."'
    )";
  $sql_inserir_venda = mysqli_query($conn, $query_inserir_venda);
  if(!$sql_inserir_venda){
    $retorno = 'Ocorreu um erro ao inserir sua venda.';
    echo $retorno;
    return;
  }else{
    $id_vendas = mysqli_insert_id($conn);

    $query_inserir_produtos_venda = "
      INSERT INTO rl_produto_venda (produto, venda, quantidade, valor_produto) 
      VALUES";
    for($i=0; $i<sizeof($items); $i++){
      $query_inserir_produtos_venda .= "(
        '".$items[$i]['id']."',
        '".$id_vendas."',
        '".$items[$i]['quantidade']."',
        '".$items[$i]['valor']/$items[$i]['quantidade']."'
      ),";
    }
    $sql_inserir_produtos_venda = mysqli_query($conn, substr($query_inserir_produtos_venda, 0, -1));
    if(!$sql_inserir_produtos_venda){
      $retorno = 'Ocorreu um erro ao inserir um produto nas vendas';
      echo $retorno;
      return;
    }
  }
  $retorno = "Venda cadastrada com sucesso!";
  echo $retorno;
?>