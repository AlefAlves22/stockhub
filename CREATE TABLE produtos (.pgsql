CREATE TABLE produtos (
    id SERIAL PRIMARY KEY,
    sku VARCHAR(50) NOT NULL UNIQUE,
    nome_produto VARCHAR(200) NOT NULL,
    valor_final DECIMAL(10,2) NOT NULL,
    valor_entrada DECIMAL(10,2) NOT NULL
);

CREATE TABLE estoque (
    id SERIAL PRIMARY KEY,
    quantidade_estoque int,
    fornecedor VARCHAR(150)
);

CREATE TABLE login (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(200),
    email VARCHAR(255),
    cpf VARCHAR(14),
    senha VARCHAR(255)
);


SELECT * FROM produtos;
SELECT * FROM estoque;
SELECT * FROM login;
