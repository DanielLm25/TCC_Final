<?php
require_once './config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'] ?? null;
    $email = $_POST['email'] ?? null;
    $telefone = $_POST['telefone'] ?? null;

    if (!$nome || !$email || !$telefone) {
        echo json_encode(["success" => false, "message" => "Todos os campos são obrigatórios."]);
        exit;
    }


    try {
        $database = new Database();
        $conn = $database->connect();
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Erro ao conectar ao banco de dados.", "error" => $e->getMessage()]);
        exit;
    }

    $database = new Database();
    $conn = $database->connect();

    if ($conn) {
        $sql = "INSERT INTO usuarios (nome, email, telefone) VALUES (:nome, :email, :telefone)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Formulário enviado com sucesso!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao enviar os dados.", "error" => $stmt->errorInfo()]);
        }

        $database->close();
    } else {
        echo json_encode(["success" => false, "message" => "Erro na conexão com o banco de dados.", "error" => $conn->errorInfo()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Nenhum dado foi enviado."]);
}
