Bom dia para executar o sistema, terão que ser criadas 5 novas tabelas, 

Tabela:  fornecedor
Colunas: id(PK)
	   nome(varchar(200))

Tabela:  produto
Colunas: id(PK)
	   nome(varchar(80))	
	   referencia(varchar(20))
	   preco(decimal(5,2))

Tabela:  venda
Colunas: id(pk)
	   nome_cliente(varchar(200))
	   cep(varchar(9))
	   logradouro(varchar(70))
	   numero(varchar(7))
	   complemento(varchar(20))
	   bairro(varchar(70))
	   cidade(varchar(70))
	   uf(varchar(2))
	   total_venda(varchar(15))
	   data(varchar(20))

Tabela:  rl_produto_fornecedor
Colunas: id(pk)
	   produto(int) - FK Apontando para id da tabela produto
	   fornecedor(int) - FK Apontando para id da tabela fornecedor

Tabela:  rl_produto_venda
Colunas: id(pk)
	   produto(int) - FK Apontando para id da tabela produto
	   venda(int) - FK Apontando para id da tabela venda
	   valor_produto(decimal(5,2))
	   quantidade(int(11))