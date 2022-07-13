<?php
	include("conexao/conexao.php");
	$query = "SELECT * FROM produto WHERE id=7";
	$sql = mysqli_query($conn, $query);
	// $dados = mysqli_fetch_array($sql);
	// echo $dados['nome'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">	
</head>
<body>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <h1>Vendas</h1>
	    </div>
	  </div>
	</nav>

	<div class="container-fluid">
		<div class="row g-3 mb-3">
			<input type="text" class="form-control" id="id-produto" hidden>	
			<div class="form-group col-auto d-flex align-items-center gap-2">
				<input type="text" class="form-control" id="produto" placeholder="Produto">						
				<button onclick="abrirModal()" >
					<i class="fas fa-search icon-cursor"></i>
				</button>
			</div>			
			<div class="form-group col-auto">
				<input type="text" class="form-control" id="valor" placeholder="Valor" readonly>
			</div>
			<div class="form-group col-auto">
				<input type="number" class="form-control" id="quantidade" placeholder="Quantidade">
			</div>
			<span id="btnAdd" class="col-auto">
				<button onclick="addProduto();" class="btn btn-outline-secondary">Adicionar produto</button>
			</span>
		</div>
		<div id="errors" style="display: none;"></div>

		<table class="table">
			<thead>
				<tr>
					<th scope="col">Produto</th>
					<th scope="col">Quantidade</th>
					<th scope="col">Valor Un</th>
					<th scope="col">Valor</th>
					<th scope="col"></th>
				</tr>
			</thead>
			<tbody id="mostrar-lista">
			</tbody>
    </table>
	</div>

	<div class="container">
		<h4 class="text-left text-success">Total: <span id="totalValue">R$ 0,00</span></h4>
	</div>

	<div class="container-fluid mt-3">
		<div class="row g-3 mb-3">
			<div class="form-group col-12 col-lg-9">
				<input type="text" class="form-control" id="nome_cliente" placeholder="Nome do cliente">
			</div>
			<div class="form-group col-3">
				<input type="text" class="form-control" id="cep" onchange="pesquisacep()" placeholder="CEP">
			</div>
			<div class="form-group col-9 col-lg-6">
				<input type="text" class="form-control" id="logradouro" placeholder="Logradouro">
			</div>
			<div class="form-group col-3 col-lg-1">
				<input type="text" class="form-control" id="num" placeholder="Nº">
			</div>
			<div class="form-group col-3 col-lg-5">
				<input type="text" class="form-control" id="comp" placeholder="Comp">
			</div>
			<div class="form-group col-6 col-lg-5">
				<input type="text" class="form-control" id="bairro" placeholder="Bairro">
			</div>
			<div class="form-group col-8 col-lg-5">
				<input type="text" class="form-control" id="cidade" placeholder="Cidade">
			</div>
			<div class="form-group col-4 col-lg-2">
				<input type="text" class="form-control" id="estado" placeholder="Estado">
			</div>
		</div>
		<div class="text-danger" id="errors-venda" style="display: none;"></div>
		<span>
				<button onclick="concluirVenda()" class="btn btn-outline-secondary">Concluir venda</button>
		</span>
	</div>


	<?php include("modal.php");?>
	<script type="text/javascript" src="js/main.js"></script>
</body>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
</html>