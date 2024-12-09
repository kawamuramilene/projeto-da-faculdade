<?php
$servername = "localhost"; 
$username = "root";      
$password = "";     
$dbname = "doe"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    $nome = trim(htmlspecialchars($_POST['nome']));
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $valor = floatval($_POST['valor']);
    $mensagem = trim(htmlspecialchars($_POST['mensagem']));


    $erros = [];

    if (empty($nome)) {
        $erros[] = "O campo Nome é obrigatório.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "O campo E-mail é inválido ou está vazio.";
    }

    if ($valor < 5) {
        $erros[] = "O valor da doação deve ser de no mínimo R$5.";
    }

    if (!empty($erros)) {
        echo "<h3>Erros encontrados:</h3><ul>";
        foreach ($erros as $erro) {
            echo "<li>$erro</li>";
        }
        echo "</ul>";
    } else {
        $sql = "INSERT INTO doacoes (nome, email, valor, mensagem, data_doacao) 
                VALUES (?, ?, ?, ?, NOW())";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssds", $nome, $email, $valor, $mensagem);

            if ($stmt->execute()) {
                echo "<h2>Obrigado pela sua doação, $nome!</h2>";
                echo "<p>Seu apoio faz a diferença para os gatinhos.</p>";
            } else {
                echo "Erro ao registrar a doação: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Erro na preparação da consulta: " . $conn->error;
        }
    }
} else {
    echo "Acesso inválido ao arquivo.";
}

$conn->close();
?>
