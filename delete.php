<?php
require 'config.php';

$id = $_GET['id'] ?? null;
if ($id) {
  $stmt = $pdo->prepare("DELETE FROM agendamentos WHERE id = ?");
  $stmt->execute([$id]);
}

header("Location: index.php?msg=" . urlencode("Agendamento excluído com sucesso."));
exit;
