<?php
require_once './config/db.php';

$message = '';
$registrationSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if ($password !== $password_confirm) {
        $message = 'As senhas não coincidem.';
    } else {
        try {
            $db = new Database();
            $conn = $db->connect();

            $query = "SELECT COUNT(*) FROM register WHERE email = :email";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $exists = $stmt->fetchColumn();

            if ($exists > 0) {
                $message = 'O email já está cadastrado.';
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $query = "INSERT INTO register (username, email, password_hash) VALUES (:username, :email, :password)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $hashed_password);

                if ($stmt->execute()) {
                    $message = 'Usuário cadastrado com sucesso!';
                    $registrationSuccess = true;
                } else {
                    $message = 'Erro ao cadastrar o usuário.';
                }
            }

            $db->close();
        } catch (Exception $e) {
            $message = 'Erro: ' . $e->getMessage();
        }
    }
}
?>

<?php include './includes/header.php'; ?>

<div style="height: 86vh;" class="d-flex flex-column justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Cadastro de Usuário</h2>
                <?php if ($message): ?>
                    <div class="alert <?= strpos($message, 'Erro') === false ? 'alert-success' : 'alert-danger' ?>" role="alert">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nome de Usuário</label>
                        <input type="text" id="username" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirmar Senha</label>
                        <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include './includes/footer.php'; ?>