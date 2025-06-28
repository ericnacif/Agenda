<?php
require 'config.php';

$id = $_GET['id'] ?? null;

if ($id) {
  $stmt = $pdo->prepare("SELECT * FROM agendamentos WHERE id = ?");
  $stmt->execute([$id]);
  $agendamento = $stmt->fetch();
  if (!$agendamento) die("Agendamento não encontrado.");
} else {
  $agendamento = ['data_inicial' => '', 'data_final' => '', 'titulo' => '', 'descricao' => '', 'nome_cliente' => ''];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data_inicial = $_POST['data_inicial'];
  $data_final = $_POST['data_final'];
  $titulo = trim($_POST['titulo']);
  $descricao = trim($_POST['descricao']);
  $cliente = trim($_POST['nome_cliente']);

  if ($id) {
    $stmt = $pdo->prepare("UPDATE agendamentos SET data_inicial=?, data_final=?, titulo=?, descricao=?, nome_cliente=? WHERE id=?");
    $stmt->execute([$data_inicial, $data_final, $titulo, $descricao, $cliente, $id]);
    header("Location: index.php?msg=" . urlencode("Agendamento atualizado com sucesso."));
  } else {
    $stmt = $pdo->prepare("INSERT INTO agendamentos (data_inicial, data_final, titulo, descricao, nome_cliente) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$data_inicial, $data_final, $titulo, $descricao, $cliente]);
    header("Location: index.php?msg=" . urlencode("Agendamento criado com sucesso."));
  }
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title><?= $id ? "Editar" : "Novo" ?> Agendamento</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <h1><?= $id ? "Editar" : "Novo" ?> Agendamento</h1>

  <form method="post">
    <label>Data Inicial*</label>
    <input type="date" name="data_inicial" value="<?= $agendamento['data_inicial'] ?>" required>

    <label>Data Final*</label>
    <input type="date" name="data_final" value="<?= $agendamento['data_final'] ?>" required>

    <label>Título*</label>
    <input type="text" name="titulo" value="<?= htmlspecialchars($agendamento['titulo']) ?>" required>

    <label>Descrição</label>
    <textarea name="descricao"><?= htmlspecialchars($agendamento['descricao']) ?></textarea>

    <label>Nome do Cliente*</label>
    <input type="text" name="nome_cliente" value="<?= htmlspecialchars($agendamento['nome_cliente']) ?>" required>

    <button type="submit">Salvar</button>
    <a class="button-link" href="index.php">Cancelar</a>
  </form>
</body>
</html>
