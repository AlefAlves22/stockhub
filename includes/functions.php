<?php
require_once '../database/connect.php';

function cadastrar_user($conexao, $email, $senha, $nome, $cpf)
{
    $sql = "INSERT INTO login(email, senha, nome, cpf) VALUES (:email, :senha, :nome, :cpf)";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":cpf", $cpf);

        $stmt->execute();
        echo "Usuário inserido com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar usuário: " . $e->getMessage();
    }
}

function consulta_user($conexao, $email, $senha)
{
    $sql = "SELECT id, email, senha FROM login WHERE email = :email AND senha = :senha";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function cadastrar_produto($conexao, $sku, $nome_produto, $valor_final, $valor_entrada, $descricao, $codigo_barra)
{
    $sql = "INSERT INTO produtos (sku, nome_produto, valor_final, valor_entrada, descricao, codigo_barra) 
            VALUES (:sku, :nome_produto, :valor_final, :valor_entrada, :descricao, :codigo_barra)";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":sku", $sku);
        $stmt->bindParam(":nome_produto", $nome_produto);
        $stmt->bindParam(":valor_final", $valor_final);
        $stmt->bindParam(":valor_entrada", $valor_entrada);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":codigo_barra", $codigo_barra);

        $stmt->execute();
        echo "Produto cadastrado com sucesso!<br>";
        return true;
    } catch (PDOException $e) {
        if ($e->getCode() == '23505') {
            echo "Erro: O SKU ou Código de barras já está cadastrado em outro produto.<br>";
        } else {
            echo "Erro ao cadastrar produto: " . $e->getMessage() . "<br>";
        }
        return false;
    }
}

function estoque_produto($conexao, $quantidade_estoque, $fornecedor, $sku, $codigo_barra)
{
    $sql = "INSERT INTO estoque (quantidade_estoque, fornecedor, sku, codigo_barra) 
            VALUES (:quantidade_estoque, :fornecedor, :sku, :codigo_barra)";

    try {
        $stmt = $conexao->prepare($sql);

        $stmt->bindParam(":quantidade_estoque", $quantidade_estoque);
        $stmt->bindParam(":fornecedor", $fornecedor);
        $stmt->bindParam(":sku", $sku);
        $stmt->bindParam(":codigo_barra", $codigo_barra);

        $stmt->execute();
        echo "Estoque inserido com sucesso!<br>";
    } catch (PDOException $e) {
        echo "Erro ao inserir no estoque: " . $e->getMessage() . "<br>";
    }
}

function apagar($conexao, $sku)
{
    $sql = "DELETE FROM produtos WHERE sku = :sku";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":sku", $sku);
        $stmt->execute();
        echo "Registro deletado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function relatorio($conexao)
{
    $sql = "SELECT p.id,p.sku, p.nome_produto, p.valor_final, p.valor_entrada, p.descricao, e.codigo_barra, e.quantidade_estoque, e.fornecedor 
            FROM produtos AS p 
            INNER JOIN estoque AS e ON p.sku = e.sku";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $estoque = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($estoque as $item) {
            echo "ID: {$item['id']}<br>";
            echo "SKU: {$item['sku']}<br>";
            echo "Nome: {$item['nome_produto']}<br>";
            echo "Valor final: {$item['valor_final']}<br>";
            echo "Valor de compra: {$item['valor_entrada']}<br>";
            echo "Descrição: {$item['descricao']}<br>";
            echo "Estoque: {$item['quantidade_estoque']}<br>";
            echo "Fornecedor: {$item['fornecedor']}<br>";
            echo "Código de Barras: {$item['codigo_barra']}<br>";
            echo "<hr>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function consultar($conexao, $codigo_barra)
{
    // Removido o ponto final após 'estoque.codigo_barra'
    $sql = "SELECT * FROM produtos 
            INNER JOIN estoque ON produtos.codigo_barra = estoque.codigo_barra 
            WHERE produtos.codigo_barra = :codigo_barra";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":codigo_barra", $codigo_barra);
        $stmt->execute();

        $produtos = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produtos) {
            echo "ID : " . $produtos['id'] . "<br>";
            echo "SKU: " . $produtos['sku'] . "<br>";
            echo "Nome: " . $produtos['nome_produto'] . "<br>";
            echo "Valor de Venda: " . $produtos['valor_final'] . "<br>";
            echo "Valor de compra: " . $produtos['valor_entrada'] . "<br>";
            echo "Descrição: " . $produtos['descricao'] . "<br>";
            echo "Código de barras: " . $produtos['codigo_barra'] . "<br>";
            echo "Estoque: " . $produtos['quantidade_estoque'] . "<br>";
            echo "Fornecedor: " . $produtos['fornecedor'] . "<br>";
            echo "Código de barras: " . $produtos['codigo_barra'] . "<br><br>";
        } else {
            echo "Nenhum produto encontrado com o Código de barras: " . htmlspecialchars((string) $codigo_barra) . "<br><br>";
        }
    } catch (PDOException $e) {
        echo "Erro na consulta: " . $e->getMessage();
    }
}

function atualizar_produto($conexao, $id, $sku, $nome_produto, $valor_final, $valor_entrada, $descricao, $codigo_barra)
{
    // O 'id' fica APENAS no WHERE, garantindo que a Chave Primária nunca seja alterada
    $sql = "UPDATE produtos SET 
                sku = :sku, 
                nome_produto = :nome_produto, 
                valor_final = :valor_final, 
                valor_entrada = :valor_entrada, 
                descricao = :descricao, 
                codigo_barra = :codigo_barra 
            WHERE id = :id";

    try {
        $stmt = $conexao->prepare($sql);

        // Passa o ID apenas para identificar o registo correto no banco
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":sku", $sku);
        $stmt->bindValue(":nome_produto", $nome_produto);
        $stmt->bindValue(":valor_final", $valor_final);
        $stmt->bindValue(":valor_entrada", $valor_entrada);
        $stmt->bindValue(":descricao", $descricao);
        $stmt->bindValue(":codigo_barra", $codigo_barra);

        $stmt->execute();
        echo "Produto atualizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
function atualizar_estoque($conexao, $quantidade_estoque, $fornecedor, $codigo_barra)
{
    $sql = "UPDATE estoque SET 
                quantidade_estoque = :quantidade_estoque,
                fornecedor = :fornecedor
            WHERE codigo_barra = :codigo_barra";

    try {
        $stmt = $conexao->prepare($sql);

        $stmt->bindValue(":quantidade_estoque", $quantidade_estoque);
        $stmt->bindValue(":fornecedor", $fornecedor);
        $stmt->bindValue(":codigo_barra", $codigo_barra);

        // Executado apenas UMA vez
        $stmt->execute();

        echo "Produto atualizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function cadastrar_vendedor($conexao, $nome_vendedor, $cpf)
{
    $sql = "INSERT INTO vendedor(nome_vendedor, cpf) VALUES (:nome_vendedor, :cpf)";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":nome_vendedor", $nome_vendedor);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->execute();

        echo "Vendedor inserido com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar vendedor: " . $e->getMessage();
    }
}

function relatorio_vendedor($conexao)
{
    $sql = "SELECT * FROM vendedor";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $vendedor = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($vendedor as $vendedor) {
            echo "ID: {$vendedor['id']} <br>";
            echo "Nome: {$vendedor['nome_vendedor']}<br>";
            echo "CPF: {$vendedor['cpf']}<br>";
            echo "<hr>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function cadastrar_cliente($conexao, $nome_cliente, $cpf, $telefone, $endereco)
{
    $sql = "INSERT INTO cliente(nome_cliente, cpf, telefone, endereco) VALUES (:nome_cliente, :cpf, :telefone, :endereco)";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":nome_cliente", $nome_cliente);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":endereco", $endereco);
        $stmt->execute();

        echo "Cliente inserido com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar Cliente: " . $e->getMessage();
    }
}


function relatorio_cliente($conexao)
{
    $sql = "SELECT * FROM cliente";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $cliente = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($cliente as $cliente) {
            echo "ID: {$cliente['id']}<br>";
            echo "Nome: {$cliente['nome_cliente']}<br>";
            echo "CPF: {$cliente['cpf']}<br>";
            echo "Telefone: {$cliente['telefone']}<br>";
            echo "Endereço: {$cliente['endereco']}<br>";
            echo "<hr>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function vendas_cliente($conexao)
{
    $sql = "SELECT nome_cliente FROM cliente ORDER BY nome_cliente ASC";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        // Retorna todos os clientes cadastrados em forma de array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro ao buscar Clientes: " . $e->getMessage();
        return [];
    }
}


function vendas_vendedor($conexao)
{
    $sql = "SELECT nome_vendedor FROM vendedor ORDER BY nome_vendedor ASC";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        // Retorna todos os clientes cadastrados em forma de array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro ao buscar Vendedor: " . $e->getMessage();
        return [];
    }
}

function vendas_produto($conexao)
{
    $sql = "SELECT nome_produto FROM produtos ORDER BY nome_produto ASC";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        // Retorna todos os clientes cadastrados em forma de array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro ao buscar Produto: " . $e->getMessage();
        return [];
    }
}

function vendas_estoque($conexao, $nome_produto, $quantidade)
{
    try {
        // Busca o sku na tabela estoque pelo nome digitado
        $sqlBusca = "SELECT sku FROM produtos WHERE LOWER(TRIM(nome_produto)) = LOWER(TRIM(:nome_produto))";
        $stmtBusca = $conexao->prepare($sqlBusca);
        $stmtBusca->execute([':nome_produto' => $nome_produto]);
        $produto = $stmtBusca->fetch(PDO::FETCH_ASSOC);

        // Se encontrou o SKU correspondente no cadastro de produtos
        if ($produto && !empty($produto['sku'])) {
            $sku = $produto['sku'];

            // 2. Abate a quantidade na tabela 'estoque' usando a coluna 'sku'
            $sqlEstoque = "UPDATE estoque 
                           SET quantidade_estoque = quantidade_estoque - :quantidade 
                           WHERE LOWER(TRIM(sku)) = LOWER(TRIM(:sku))";

            $stmtEstoque = $conexao->prepare($sqlEstoque);
            return $stmtEstoque->execute([
                ':quantidade' => $quantidade,
                ':sku'        => $sku
            ]);
        }

        return false;
    } catch (PDOException $e) {
        throw new Exception("Erro ao atualizar estoque do produto $nome_produto: " . $e->getMessage());
    }
}

// Função que busca a quantidade em estoque digitando o nome do produto
function buscar_quantidade_estoque($conexao, $nome_produto)
{
    try {
        $sql = "SELECT e.quantidade_estoque 
                FROM estoque e 
                JOIN produtos p ON e.sku = p.sku 
                WHERE LOWER(TRIM(p.nome_produto)) = LOWER(TRIM(:nome_produto))";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([':nome_produto' => $nome_produto]);

        // Pega o resultado do banco
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se achou o produto, devolve a quantidade. Se não achou, devolve 0
        if ($resultado) {
            return $resultado['quantidade_estoque'];
        } else {
            return 0;
        }
    } catch (PDOException $e) {
        return 0;
    }
}

function registrar_venda($conexao, $nome_cliente, $nome_vendedor, $nome_produtos, $quantidade)
{
    try {
        // Registra a venda na tabela vendas
        $sql = "INSERT INTO vendas (nome_cliente, nome_vendedor, nome_produtos, quantidade) 
                VALUES (:nome_cliente, :nome_vendedor, :nome_produtos, :quantidade)";

        $stmt = $conexao->prepare($sql);
        return $stmt->execute([
            ':nome_cliente'  => $nome_cliente,
            ':nome_vendedor' => $nome_vendedor,
            ':nome_produtos' => $nome_produtos,
            ':quantidade'    => $quantidade
        ]);
    } catch (PDOException $e) {
        // Mostra a mensagem de erro exata vinda do banco de dados para diagnosticar
        die("Erro do Banco de Dados: " . $e->getMessage());
    }
}

function atualizar_vendedor($conexao, $id, $nome_vendedor, $cpf)
{
    // O 'id' fica APENAS no WHERE, garantindo que a Chave Primária nunca seja alterada
    $sql = "UPDATE vendedor SET nome_vendedor = :nome_vendedor, cpf = :cpf
            WHERE id = :id";

    try {
        $stmt = $conexao->prepare($sql);

        // Passa o ID apenas para identificar o registo correto no banco
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":nome_vendedor", $nome_vendedor);
        $stmt->bindValue(":cpf", $cpf);
        $stmt->execute();
        echo "Produto atualizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function atualizar_cliente($conexao, $id, $nome_cliente, $cpf, $telefone, $endereco)
{
    // O 'id' fica APENAS no WHERE, garantindo que a Chave Primária nunca seja alterada
    $sql = "UPDATE cliente SET nome_cliente = :nome_cliente, cpf = :cpf, telefone = :telefone, endereco = :endereco
    WHERE id = :id";

    try {
        $stmt = $conexao->prepare($sql);

        // Passa o ID apenas para identificar o registo correto no banco
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":nome_cliente", $nome_cliente);
        $stmt->bindValue(":cpf", $cpf);
        $stmt->bindValue(":telefone", $telefone);
        $stmt->bindValue(":endereco", $endereco);
        $stmt->execute();
        echo "Produto atualizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function consultar_cliente($conexao, $cpf)
{
    // Removido o ponto final após 'estoque.codigo_barra'
    $sql = "SELECT * FROM cliente 
            WHERE cpf = :cpf";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":cpf", $cpf);
        $stmt->execute();

        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente) {
            echo "ID : " . $cliente['id'] . "<br>";
            echo "Nome: " . $cliente['nome_cliente'] . "<br>";
            echo "CPF: " . $cliente['cpf'] . "<br>";
            echo "Telefone: " . $cliente['telefone'] . "<br>";
            echo "Endereço: " . $cliente['endereco'] . "<br>";
        } else {
            echo "Nenhum produto encontrado com o Código de barras: " . htmlspecialchars((string) $cpf) . "<br><br>";
        }
    } catch (PDOException $e) {
        echo "Erro na consulta: " . $e->getMessage();
    }
}

function consultar_vendedor($conexao, $cpf)
{
    // Removido o ponto final após 'estoque.codigo_barra'
    $sql = "SELECT * FROM vendedor
            WHERE cpf = :cpf";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":cpf", $cpf);
        $stmt->execute();

        $vendedor = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($vendedor) {
            echo "ID : " . $vendedor['id'] . "<br>";
            echo "Nome: " . $vendedor['nome_vendedor'] . "<br>";
            echo "CPF: " . $vendedor['cpf'] . "<br>";

        } else {
            echo "Nenhum vendedor encontrado com o CPF: " . htmlspecialchars((string) $cpf) . "<br><br>";
        }
    } catch (PDOException $e) {
        echo "Erro na consulta: " . $e->getMessage();
    }
}

function apagar_vendedor($conexao, $cpf)
{
    $sql = "DELETE FROM vendedor WHERE cpf = :cpf";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->execute();
        echo "Registro deletado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function apagar_cliente($conexao, $cpf)
{
    $sql = "DELETE FROM cliente WHERE cpf = :cpf";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->execute();
        echo "Registro deletado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

function relatorio_vendas($conexao)
{
    $sql = "SELECT * FROM vendas";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($vendas as $vendas) {
            echo "ID: {$vendas['id']}<br>";
            echo "Cliente: {$vendas['nome_cliente']}<br>";
            echo "Vendedor: {$vendas['nome_vendedor']}<br>";
            echo "Produto: {$vendas['nome_produtos']}<br>";
            echo "Quantidade: {$vendas['quantidade']}<br>";
            echo "Data: {$vendas['data_venda']}<br>";
            echo "<hr>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}