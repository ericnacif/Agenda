<?php
require 'config.php';

$hoje = date('Y-m-d');
$msg = $_GET['msg'] ?? '';

$stmtFuturos = $pdo->prepare("SELECT * FROM agendamentos WHERE data_inicial >= ? ORDER BY data_inicial");
$stmtFuturos->execute([$hoje]);
$futuros = $stmtFuturos->fetchAll();

$stmtPassados = $pdo->prepare("SELECT * FROM agendamentos WHERE data_final < ? ORDER BY data_inicial DESC");
$stmtPassados->execute([$hoje]);
$passados = $stmtPassados->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Agenda</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <h1>Agendamentos</h1>

  <?php if ($msg): ?>
    <p class="success-message"><?= htmlspecialchars($msg) ?></p>
  <?php endif; ?>

  <a class="button-link" href="form.php">+ Novo Agendamento</a>

  <h2>Agendamentos Futuros</h2>
  <?php if (!$futuros): ?>
    <p>Nenhum agendamento futuro.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Data Inicial</th>
          <th>Data Final</th>
          <th>Título</th>
          <th>Cliente</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($futuros as $item): ?>
          <tr>
            <td data-label="Data Inicial"><?= $item['data_inicial'] ?></td>
            <td data-label="Data Final"><?= $item['data_final'] ?></td>
            <td data-label="Título"><?= htmlspecialchars($item['titulo']) ?></td>
            <td data-label="Cliente"><?= htmlspecialchars($item['nome_cliente']) ?></td>
            <td data-label="Ações">
              <a class="button-link" href="form.php?id=<?= $item['id'] ?>">Editar</a>
              <a class="button-link" href="delete.php?id=<?= $item['id'] ?>" onclick="return confirm('Confirma a exclusão?');">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <h2>Agendamentos Passados</h2>
  <?php if (!$passados): ?>
    <p>Nenhum agendamento passado.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Data Inicial</th>
          <th>Data Final</th>
          <th>Título</th>
          <th>Cliente</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($passados as $item): ?>
          <tr>
            <td data-label="Data Inicial"><?= $item['data_inicial'] ?></td>
            <td data-label="Data Final"><?= $item['data_final'] ?></td>
            <td data-label="Título"><?= htmlspecialchars($item['titulo']) ?></td>
            <td data-label="Cliente"><?= htmlspecialchars($item['nome_cliente']) ?></td>
            <td data-label="Ações">
              <a class="button-link" href="form.php?id=<?= $item['id'] ?>">Editar</a>
              <a class="button-link" href="delete.php?id=<?= $item['id'] ?>" onclick="return confirm('Confirma a exclusão?');">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</body>
</html>
