<?php
$servername = "localhost";  
$username = "root";      
$password = "";         
$dbname = "voluntarios";   

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $acao = $_POST['acao'] ?? '';

    if ($acao == "criar") {

        $nome = htmlspecialchars($_POST['nome']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $telefone = htmlspecialchars($_POST['telefone']);
        $disponibilidade = htmlspecialchars($_POST['disponibilidade']);

        if (!empty($nome) && !empty($email) && !empty($telefone) && !empty($disponibilidade)) {
            $sql = "INSERT INTO voluntarios (nome, email, telefone, disponibilidade) 
                    VALUES ('$nome', '$email', '$telefone', '$disponibilidade')";
            if ($conn->query($sql) === TRUE) {
                echo "Voluntário cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar voluntário: " . $conn->error;
            }
        } else {
            echo "Todos os campos são obrigatórios.";
        }
    } elseif ($acao == "editar") {

        $id = intval($_POST['id']);
        $nome = htmlspecialchars($_POST['nome']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $telefone = htmlspecialchars($_POST['telefone']);
        $disponibilidade = htmlspecialchars($_POST['disponibilidade']);

        if (!empty($id) && !empty($nome) && !empty($email) && !empty($telefone) && !empty($disponibilidade)) {
            $sql = "UPDATE voluntarios 
                    SET nome='$nome', email='$email', telefone='$telefone', disponibilidade='$disponibilidade'
                    WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                echo "Voluntário atualizado com sucesso!";
            } else {
                echo "Erro ao atualizar voluntário: " . $conn->error;
            }
        } else {
            echo "Todos os campos são obrigatórios.";
        }
    } elseif ($acao == "deletar") {
    
        $id = intval($_POST['id']);
        if (!empty($id)) {
            $sql = "DELETE FROM voluntarios WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                echo "Voluntário excluído com sucesso!";
            } else {
                echo "Erro ao excluir voluntário: " . $conn->error;
            }
        } else {
            echo "ID inválido.";
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {

    $sql = "SELECT * FROM voluntarios";
    $result = $conn->query($sql);

    $voluntarios = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $voluntarios[] = $row;
        }
    }
    echo json_encode($voluntarios);
}

$conn->close();
?>
