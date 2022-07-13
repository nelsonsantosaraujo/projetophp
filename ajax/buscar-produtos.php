<?php
	include("../conexao/conexao.php");
  // Array de produtos
  $produtos = array();

  // Pegando o parâmetro da URL
  $nome_ref_produto = $_REQUEST["produto"];

	$query_busca_produtos = "SELECT * FROM produto 
            WHERE nome LIKE '%".$nome_ref_produto."%'
            OR referencia LIKE '%".$nome_ref_produto."%'
            ORDER by nome";
	$sql_busca_produtos = mysqli_query($conn, $query_busca_produtos);
  $aux = 0;
  $aux2 = 0;
  while($dados_produtos = mysqli_fetch_array($sql_busca_produtos)){
    $id_produto = $dados_produtos['id'];
    $produtos[$aux]['id'] = $id_produto;
    $produtos[$aux]['nome'] = $dados_produtos['nome'];
    $produtos[$aux]['referencia'] = $dados_produtos['referencia'];
    $produtos[$aux]['preco'] = $dados_produtos['preco'];
    $query_busca_fornecedores = "SELECT f.nome FROM fornecedor as f
                            inner join rl_produto_fornecedor rl on(rl.fornecedor = f.id)
                            inner join produto p on(p.id = rl.produto)
                            WHERE p.id = '".$id_produto."'
                            ORDER by f.id";
    $sql_busca_fornecedores = mysqli_query($conn, $query_busca_fornecedores);
    while($dados_fornecedores = mysqli_fetch_array($sql_busca_fornecedores)){
      if($aux2 == 0){
        $produtos[$aux]['fornecedor'] = $dados_fornecedores['nome'];
      }else{
        $produtos[$aux]['fornecedor'] .= ', '.$dados_fornecedores['nome'];
      }
      $aux2++;
    }
    $aux2 = 0;
    $aux++;
  }
  
  echo json_encode($produtos);
?>