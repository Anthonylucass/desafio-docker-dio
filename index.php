<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/html; charset=UTF-8');

$dbHost = '54.234.153.24';
$dbUser = 'root';
$dbPass = 'Senha123';
$dbName = 'meubanco';

/**
 * Conexão com o banco
 */
$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($mysqli->connect_error) {
    die('Erro de conexão: ' . $mysqli->connect_error);
}

$mysqli->set_charset('utf8mb4');

/**
 * Dados gerados
 */
$alunoId   = random_int(1, 999);
$valorRand = strtoupper(bin2hex(random_bytes(4)));
$hostName  = gethostname();


$sql = "INSERT INTO dados 
        (AlunoID, Nome, Sobrenome, Endereco, Cidade, Host)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die('Erro ao preparar a query: ' . $mysqli->error);
}

$stmt->bind_param(
    'isssss',
    $alunoId,
    $valorRand,
    $valorRand,
    $valorRand,
    $valorRand,
    $hostName
);

/**
 * Execução
 */
$resultado = $stmt->execute();

/**
 * Fechamento de recursos
 */
$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Exemplo PHP Melhorado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
        }
        .box {
            background: #fff;
            padding: 20px;
            border-radius: 6px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .success {
            color: #2e7d32;
        }
        .error {
            color: #c62828;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Resultado</h2>

    <?php if ($resultado): ?>
        <p class="success">✅ Registro inserido com sucesso!</p>
    <?php else: ?>
        <p class="error">❌ Erro ao inserir registro.</p>
    <?php endif; ?>

    <hr>

    <p><strong>Versão do PHP:</strong> <?= phpversion(); ?></p>
    <p><strong>Host:</strong> <?= htmlspecialchars($hostName); ?></p>
    <p><strong>ID do Aluno:</strong> <?= $alunoId; ?></p>
</div>

</body>
</html>
