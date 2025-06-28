-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS agenda_db;
USE agenda_db;

-- Criação da tabela de agendamentos
CREATE TABLE IF NOT EXISTS agendamentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  data_inicial DATE NOT NULL,
  data_final DATE NOT NULL,
  titulo VARCHAR(255) NOT NULL,
  descricao TEXT,
  nome_cliente VARCHAR(255) NOT NULL
);
