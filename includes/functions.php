<?php
// Inclui o arquivo responsável por estabelecer a conexão com o banco de dados usando PDO
require_once '../database/connect.php';

/**
 * Insere um novo usuário de sistema na tabela 'login'.
 *
 * @param PDO    $conexao Instância da conexão ativa com o banco de dados.
 * @param string $email   Endereço de e-mail do usuário.
 * @param string $senha   Senha de acesso do usuário.
 * @param string $nome    Nome completo do usuário.
 * @param string $cpf     Número do CPF do usuário.
 * @return void
 */
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

/**
 * Realiza a consulta de credenciais para autenticação na tela de login.
 *
 * @param PDO    $conexao Instância da conexão ativa com o banco de dados.
 * @param string $email   E-mail informado no formulário de login.
 * @param string $senha   Senha informada no formulário de login.
 * @return array|false Retorna os dados do usuário em array associativo ou false em caso de insucesso.
 */
function consulta_user($conexao, $email, $senha)
{
    $sql = "SELECT id, email, senha FROM login WHERE email = :email AND senha = :senha";

    try {
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
        $stmt->execute();

        // Retorna a linha encontrada em formato de array associativo
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

/**
 * Cadastra um novo produto na tabela 'produtos'.
 * Trata exceções de violação de chave única (código 23505 para duplicidade de SKU/EAN no PostgreSQL).
 *
 * @param PDO    $conexao      Instância da conexão com o banco de dados.
 * @param string $sku          Código único SKU do produto.
 * @param string $nome_produto Nome do produto.
 * @param float  $valor_final  Valor de venda do produto.
 * @param float  $valor_entrada Valor de custo/compra do produto.
 * @param string $descricao    Descrição detalhada do produto.
 * @param string $codigo_barra Código de barras (EAN).
 * @return bool Retorna true se cadastrado com sucesso ou false em caso de erro.
 */
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
        // Trata erro de violação de unicidade (SKU ou Código de barras duplicado)
        if ($e->getCode() == '23505') {
            echo "Erro: O SKU ou Código de barras já está cadastrado em outro produto.<br>";
        } else {
            echo "Erro ao cadastrar produto: " . $e->getMessage() . "<br>";
        }
        return false;
    }
}

/**
 * Registra a quantidade inicial de estoque e fornecedor vinculados ao SKU/EAN do produto.
 *
 * @param PDO    $conexao            Instância da conexão com o banco de dados.
 * @param int    $quantidade_estoque Quantidade física inicial em estoque.
 * @param string $fornecedor         Nome do fornecedor do produto.
 * @param string $sku                SKU correspondente ao produto cadastrado.
 * @param string $codigo_barra       Código de barras (EAN) correspondente.
 * @return void
 */
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

/**
 * Exclui um registro de produto da tabela 'produtos' com base no seu SKU.
 *
 * @param PDO    $conexao Instância da conexão com o banco de dados.
 * @param string $sku     Código SKU do produto a ser removido.
 * @return void
 */
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

/**
 * Gera um relatório completo cruzando os dados das tabelas 'produtos' e 'estoque' via INNER JOIN.
 *
 * @param PDO $conexao Instância da conexão com o banco de dados.
 * @return void
 */
function relatorio($conexao)
{
    $sql = "SELECT p.id, p.sku, p.nome_produto, p.valor_final, p.valor_entrada, p.descricao, e.codigo_barra, e.quantidade_estoque, e.fornecedor 
            FROM produtos AS p 
            INNER JOIN estoque AS e ON p.sku = e.sku";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $estoque = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Percorre e exibe cada item retornado da consulta
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

/**
 * Consulta e exibe as informações detalhadas de um produto específico buscando pelo Código de Barras.
 *
 * @param PDO    $conexao      Instância da conexão com o banco de dados.
 * @param string $codigo_barra Código de barras (EAN) pesquisado.
 * @return void
 */
function consultar($conexao, $codigo_barra)
{
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
            echo "Fornecedor: " . $produtos['fornecedor'] . "<br><br>";
        } else {
            echo "Nenhum produto encontrado com o Código de barras: " . htmlspecialchars((string) $codigo_barra) . "<br><br>";
        }
    } catch (PDOException $e) {
        echo "Erro na consulta: " . $e->getMessage();
    }
}

/**
 * Atualiza os campos cadastrais do produto na tabela 'produtos' identificando-o pelo ID.
 *
 * @param PDO    $conexao      Instância da conexão com o banco de dados.
 * @param int    $id           ID primário do produto.
 * @param string $sku          Novo ou atual SKU.
 * @param string $nome_produto Novo ou atual nome.
 * @param float  $valor_final  Novo ou atual valor de venda.
 * @param float  $valor_entrada Novo ou atual valor de compra.
 * @param string $descricao    Nova ou atual descrição.
 * @param string $codigo_barra Novo ou atual código de barras.
 * @return void
 */
function atualizar_produto($conexao, $id, $sku, $nome_produto, $valor_final, $valor_entrada, $descricao, $codigo_barra)
{
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

/**
 * Atualiza os dados de quantidade e fornecedor na tabela 'estoque' pelo código de barras.
 *
 * @param PDO    $conexao            Instância da conexão com o banco de dados.
 * @param int    $quantidade_estoque Nova quantidade em estoque.
 * @param string $fornecedor         Nome do fornecedor.
 * @param string $codigo_barra       Código de barras (EAN) do produto.
 * @return void
 */
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

        $stmt->execute();

        echo "Estoque atualizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

/**
 * Insere um novo registro de vendedor na tabela 'vendedor'.
 *
 * @param PDO    $conexao       Instância da conexão com o banco de dados.
 * @param string $nome_vendedor Nome completo do vendedor.
 * @param string $cpf           CPF do vendedor.
 * @return void
 */
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

/**
 * Consulta e exibe a lista de todos os vendedores cadastrados no sistema.
 *
 * @param PDO $conexao Instância da conexão com o banco de dados.
 * @return void
 */
function relatorio_vendedor($conexao)
{
    $sql = "SELECT * FROM vendedor";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $vendedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($vendedores as $v) {
            echo "ID: {$v['id']} <br>";
            echo "Nome: {$v['nome_vendedor']}<br>";
            echo "CPF: {$v['cpf']}<br>";
            echo "<hr>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

/**
 * Insere um novo registro de cliente na tabela 'cliente'.
 *
 * @param PDO    $conexao      Instância da conexão com o banco de dados.
 * @param string $nome_cliente Nome completo do cliente.
 * @param string $cpf          CPF do cliente.
 * @param string $telefone     Número de telefone/contato.
 * @param string $endereco     Endereço do cliente.
 * @return void
 */
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

/**
 * Consulta e exibe a listagem completa de todos os clientes cadastrados.
 *
 * @param PDO $conexao Instância da conexão com o banco de dados.
 * @return void
 */
function relatorio_cliente($conexao)
{
    $sql = "SELECT * FROM cliente";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($clientes as $c) {
            echo "ID: {$c['id']}<br>";
            echo "Nome: {$c['nome_cliente']}<br>";
            echo "CPF: {$c['cpf']}<br>";
            echo "Telefone: {$c['telefone']}<br>";
            echo "Endereço: {$c['endereco']}<br>";
            echo "<hr>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

/**
 * Busca e retorna a lista de nomes dos clientes ordenados alfabeticamente para preencher o <datalist>.
 *
 * @param PDO $conexao Instância da conexão com o banco de dados.
 * @return array Array de arrays associativos com os nomes dos clientes.
 */
function vendas_cliente($conexao)
{
    $sql = "SELECT nome_cliente FROM cliente ORDER BY nome_cliente ASC";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro ao buscar Clientes: " . $e->getMessage();
        return [];
    }
}

/**
 * Busca e retorna a lista de nomes dos vendedores ordenados alfabeticamente para preencher o <datalist>.
 *
 * @param PDO $conexao Instância da conexão com o banco de dados.
 * @return array Array de arrays associativos com os nomes dos vendedores.
 */
function vendas_vendedor($conexao)
{
    $sql = "SELECT nome_vendedor FROM vendedor ORDER BY nome_vendedor ASC";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro ao buscar Vendedor: " . $e->getMessage();
        return [];
    }
}

/**
 * Busca e retorna a lista de nomes dos produtos ordenados alfabeticamente para preencher o <datalist>.
 *
 * @param PDO $conexao Instância da conexão com o banco de dados.
 * @return array Array de arrays associativos com os nomes dos produtos.
 */
function vendas_produto($conexao)
{
    $sql = "SELECT nome_produto FROM produtos ORDER BY nome_produto ASC";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erro ao buscar Produto: " . $e->getMessage();
        return [];
    }
}

/**
 * Localiza o SKU correspondente ao nome do produto e subtrai a quantidade especificada no estoque.
 *
 * @param PDO    $conexao      Instância da conexão com o banco de dados.
 * @param string $nome_produto Nome do produto vendido.
 * @param int    $quantidade   Quantidade de unidades a abater do estoque.
 * @throws Exception Em caso de falha na atualização PDO.
 * @return bool Retorna true se atualizado com sucesso ou false se o produto não for localizado.
 */
function vendas_estoque($conexao, $nome_produto, $quantidade)
{
    try {
        // Busca o SKU na tabela de produtos pelo nome (tratando case-insensitive e espaços)
        $sqlBusca = "SELECT sku FROM produtos WHERE LOWER(TRIM(nome_produto)) = LOWER(TRIM(:nome_produto))";
        $stmtBusca = $conexao->prepare($sqlBusca);
        $stmtBusca->execute([':nome_produto' => $nome_produto]);
        $produto = $stmtBusca->fetch(PDO::FETCH_ASSOC);

        if ($produto && !empty($produto['sku'])) {
            $sku = $produto['sku'];

            // Abate a quantidade vendida da coluna quantidade_estoque
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

/**
 * Consulta e devolve a quantidade exata disponível no estoque pesquisando pelo nome do produto.
 *
 * @param PDO    $conexao      Instância da conexão com o banco de dados.
 * @param string $nome_produto Nome do produto consultado.
 * @return int Retorna o número de unidades no estoque ou 0 caso não seja encontrado.
 */
function buscar_quantidade_estoque($conexao, $nome_produto)
{
    try {
        $sql = "SELECT e.quantidade_estoque 
                FROM estoque e 
                JOIN produtos p ON e.sku = p.sku 
                WHERE LOWER(TRIM(p.nome_produto)) = LOWER(TRIM(:nome_produto))";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([':nome_produto' => $nome_produto]);

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            return (int) $resultado['quantidade_estoque'];
        } else {
            return 0;
        }
    } catch (PDOException $e) {
        return 0;
    }
}

/**
 * Registra a transação de venda na tabela 'vendas'.
 *
 * @param PDO    $conexao       Instância da conexão com o banco de dados.
 * @param string $nome_cliente  Nome do cliente da venda.
 * @param string $nome_vendedor Nome do vendedor responsável.
 * @param string $nome_produtos Nome do produto comercializado.
 * @param int    $quantidade    Quantidade vendida.
 * @return bool Retorna true em caso de sucesso na execução.
 */
function registrar_venda($conexao, $nome_cliente, $nome_vendedor, $nome_produtos, $quantidade)
{
    try {
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
        die("Erro do Banco de Dados: " . $e->getMessage());
    }
}

/**
 * Atualiza o nome e o CPF de um vendedor cadastrado filtrando pelo ID.
 *
 * @param PDO    $conexao       Instância da conexão com o banco de dados.
 * @param int    $id            ID primário do vendedor.
 * @param string $nome_vendedor Novo ou atual nome do vendedor.
 * @param string $cpf           Novo ou atual CPF.
 * @return void
 */
function atualizar_vendedor($conexao, $id, $nome_vendedor, $cpf)
{
    $sql = "UPDATE vendedor SET nome_vendedor = :nome_vendedor, cpf = :cpf
            WHERE id = :id";

    try {
        $stmt = $conexao->prepare($sql);

        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":nome_vendedor", $nome_vendedor);
        $stmt->bindValue(":cpf", $cpf);
        $stmt->execute();
        echo "Vendedor atualizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

/**
 * Atualiza os dados cadastrais de um cliente filtrando pelo ID.
 *
 * @param PDO    $conexao      Instância da conexão com o banco de dados.
 * @param int    $id           ID primário do cliente.
 * @param string $nome_cliente Novo ou atual nome.
 * @param string $cpf          Novo ou atual CPF.
 * @param string $telefone     Novo ou atual telefone.
 * @param string $endereco     Novo ou atual endereço.
 * @return void
 */
function atualizar_cliente($conexao, $id, $nome_cliente, $cpf, $telefone, $endereco)
{
    $sql = "UPDATE cliente SET nome_cliente = :nome_cliente, cpf = :cpf, telefone = :telefone, endereco = :endereco
            WHERE id = :id";

    try {
        $stmt = $conexao->prepare($sql);

        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":nome_cliente", $nome_cliente);
        $stmt->bindValue(":cpf", $cpf);
        $stmt->bindValue(":telefone", $telefone);
        $stmt->bindValue(":endereco", $endereco);
        $stmt->execute();
        echo "Cliente atualizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

/**
 * Busca e exibe os dados cadastrais de um cliente especificando seu CPF.
 *
 * @param PDO    $conexao Instância da conexão com o banco de dados.
 * @param string $cpf     Número de CPF a consultar.
 * @return void
 */
function consultar_cliente($conexao, $cpf)
{
    $sql = "SELECT * FROM cliente WHERE cpf = :cpf";

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
            echo "Nenhum cliente encontrado com o CPF: " . htmlspecialchars((string) $cpf) . "<br><br>";
        }
    } catch (PDOException $e) {
        echo "Erro na consulta: " . $e->getMessage();
    }
}

/**
 * Busca e exibe os dados cadastrais de um vendedor especificando seu CPF.
 *
 * @param PDO    $conexao Instância da conexão com o banco de dados.
 * @param string $cpf     Número de CPF a consultar.
 * @return void
 */
function consultar_vendedor($conexao, $cpf)
{
    $sql = "SELECT * FROM vendedor WHERE cpf = :cpf";

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

/**
 * Deleta um registro de vendedor da tabela 'vendedor' filtrando pelo CPF.
 *
 * @param PDO    $conexao Instância da conexão com o banco de dados.
 * @param string $cpf     CPF do vendedor a ser apagado.
 * @return void
 */
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

/**
 * Deleta um registro de cliente da tabela 'cliente' filtrando pelo CPF.
 *
 * @param PDO    $conexao Instância da conexão com o banco de dados.
 * @param string $cpf     CPF do cliente a ser apagado.
 * @return void
 */
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

/**
 * Consulta e lista o histórico de todas as vendas cadastradas na tabela 'vendas'.
 *
 * @param PDO $conexao Instância da conexão com o banco de dados.
 * @return void
 */
function relatorio_vendas($conexao)
{
    $sql = "SELECT * FROM vendas";
    try {
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($vendas as $v) {
            echo "ID: {$v['id']}<br>";
            echo "Cliente: {$v['nome_cliente']}<br>";
            echo "Vendedor: {$v['nome_vendedor']}<br>";
            echo "Produto: {$v['nome_produtos']}<br>";
            echo "Quantidade: {$v['quantidade']}<br>";
            echo "Data: {$v['data_venda']}<br>";
            echo "<hr>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}