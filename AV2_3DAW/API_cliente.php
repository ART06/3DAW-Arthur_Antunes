<?php
header('Content-Type: application/json');
require_once "conexao.php";

$dados = json_decode(file_get_contents("php://input"), true);

if (!$dados || !isset($dados['acao'])) {
    echo json_encode(["sucesso" => false, "mensagem" => "Requisição inválida."]);
    exit;
}

$acao = $dados['acao'];

try {
    if ($acao == 'cadastrar') {
        $sql = "INSERT INTO clientes (nome, email, telefone, nascimento, senha) VALUES (:nome, :email, :telefone, :nascimento, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $dados['nome'],
            ':email' => $dados['email'],
            ':telefone' => $dados['telefone'],
            ':nascimento' => $dados['nascimento'],
            ':senha' => $dados['senha']
        ]);
        echo json_encode(["sucesso" => true, "mensagem" => "Cadastro realizado com sucesso."]);
    }elseif ($acao == 'login') {
        $stmt = $pdo->prepare("SELECT id, nome FROM clientes WHERE email = :email AND senha = :senha");
        $stmt->execute([':email' => $dados['email'], ':senha' => $dados['senha']]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($cliente) {
            echo json_encode(["sucesso" => true, "cliente_id" => $cliente['id'], "nome" => $cliente['nome']]);
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Senha incorreta."]);
        }
    }elseif ($acao == 'carregar_dados_agendamento') {
        $servicos = $pdo->query("SELECT * FROM servicos")->fetchAll(PDO::FETCH_ASSOC);
        $profissionais = $pdo->query("SELECT * FROM profissionais")->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["sucesso" => true, "servicos" => $servicos, "profissionais" => $profissionais]);
    }elseif ($acao == 'agendar') {
        $stmtCli = $pdo->prepare("SELECT nascimento FROM clientes WHERE id = :id");
        $stmtCli->execute([':id' => $dados['cliente_id']]);
        $nascimento = $stmtCli->fetchColumn();

        $stmtServ = $pdo->prepare("SELECT preco FROM servicos WHERE id = :id");
        $stmtServ->execute([':id' => $dados['servico_id']]);
        $preco = $stmtServ->fetchColumn();

        $mesDiaNascimento = date('m-d', strtotime($nascimento));
        $mesDiaAgendamento = date('m-d', strtotime($dados['data_hora']));
        
        $valorFinal = $preco;
        $teveDesconto = false;
        if ($mesDiaNascimento == $mesDiaAgendamento) {
            $valorFinal = $preco * 0.80;
            $teveDesconto = true;
        }

        $sql = "INSERT INTO agendamentos (cliente_id, profissional_id, servico_id, data_hora, valor_final) 
                VALUES (:cli, :prof, :serv, :data, :valor)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':cli' => $dados['cliente_id'],
            ':prof' => $dados['profissional_id'],
            ':serv' => $dados['servico_id'],
            ':data' => $dados['data_hora'],
            ':valor' => $valorFinal
        ]);

        $agendamentoId = $pdo->lastInsertId();
        echo json_encode([
            "sucesso" => true, 
            "agendamento_id" => $agendamentoId, 
            "valor" => $valorFinal, 
            "desconto_aplicado" => $teveDesconto
        ]);
    }elseif ($acao == 'pagar') {
        $stmt = $pdo->prepare("UPDATE agendamentos SET status = 'Confirmado' WHERE id = :id");
        $stmt->execute([':id' => $dados['agendamento_id']]);
        echo json_encode(["sucesso" => true, "mensagem" => "Pagamento aprovado. Agendamento confirmado."]);
    }elseif ($acao == 'historico') {
        $sql = "SELECT a.data_hora, a.valor_final, a.status, s.nome as servico, p.nome as profissional 
                FROM agendamentos a 
                JOIN servicos s ON a.servico_id = s.id 
                JOIN profissionais p ON a.profissional_id = p.id 
                WHERE a.cliente_id = :cli ORDER BY a.data_hora DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':cli' => $dados['cliente_id']]);
        $historico = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(["sucesso" => true, "dados" => $historico]);
    }
}catch (PDOException $e) {
    echo json_encode(["sucesso" => false, "mensagem" => "Erro interno: " . $e->getMessage()]);
}
?>