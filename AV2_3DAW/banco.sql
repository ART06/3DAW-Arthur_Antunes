CREATE DATABASE IF NOT EXISTS salao_de_beleza;
USE salao_de_beleza;

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    nascimento DATE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE profissionais (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    especialidade VARCHAR(50) NOT NULL
);

CREATE TABLE servicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    duracao_minutos INT NOT NULL,
    preco DECIMAL(10,2) NOT NULL
);

CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    profissional_id INT NOT NULL,
    servico_id INT NOT NULL,
    data_hora DATETIME NOT NULL,
    valor_final DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) DEFAULT 'Aguardando pagamento',
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (profissional_id) REFERENCES profissionais(id),
    FOREIGN KEY (servico_id) REFERENCES servicos(id)
);

-- inserindo dados de teste
INSERT INTO profissionais (nome, especialidade) VALUES ('Ana', 'Cabelereira'), ('Maria', 'Manicure'), ('Bia', 'Maquiadora');
INSERT INTO servicos (nome, duracao_minutos, preco) VALUES ('Corte', 45, 60.00), ('Pintura', 90, 150.00), ('Maquiagem', 60, 100.00);