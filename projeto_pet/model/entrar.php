<?php
$hostname = 'localhost';
$usuario = 'root';
$senha = '';
$bancodedados = 'adoteumpet';
$conexao = new mysqli($hostname, $usuario, $senha, $bancodedados);

if($conexao->connect_error){
    echo "Falha ao conectar: (" . $conexao->connect_error . ") " . $conexao->connect_errno;
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        
        if (password_verify($senha, $usuario['senha'])) {
            session_start();
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            
            header("Location: painel.php");
            exit();
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Email não encontrado!";
    }
    
    $stmt->close();
}
$conexao->close();
?>