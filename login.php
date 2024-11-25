<?php
require_once './config/db.php';

$message = '';
$loginSuccess = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        $db = new Database();
        $conn = $db->connect();

        $query = "SELECT id, password_hash FROM register WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            $message = 'Login realizado com sucesso!';
            $loginSuccess = true;

            session_set_cookie_params(48 * 60 * 60);
            session_start();

            if (isset($_POST['remember'])) {
                setcookie('remember_user', $user['id'], time() + 48 * 60 * 60, "/");
            }

            if (isset($_COOKIE['remember_user'])) {
                $user_id = $_COOKIE['remember_user'];

                $db = new Database();
                $conn = $db->connect();
                $query = "SELECT id FROM register WHERE id = :user_id";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                } else {
                    setcookie('remember_user', '', time() - 3600, "/");
                }
            }

            $_SESSION['user_id'] = $user['id'];
            header('Location: home.php');
        } else {
            $message = 'Email ou senha inválidos.';
        }

        $db->close();
    } catch (Exception $e) {
        $message = 'Erro: ' . $e->getMessage();
    }
}
?>


<?php include './includes/header.php'; ?>

<div style="height: 93vh;" class="d-flex flex-column justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Login</h2>
                <?php if ($message): ?>
                    <div class="alert <?= strpos($message, 'Erro') === false && strpos($message, 'inválidos') === false ? 'alert-success' : 'alert-danger' ?>" role="alert">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Lembrar-me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Sucesso -->
<?php if ($loginSuccess): ?>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Login Realizado</h5>
                </div>
                <div class="modal-body">
                    <p>Login realizado com sucesso! Você será redirecionado para a página inicial.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const successModal = new bootstrap.Modal(document.getElementById('successModal'), {
            backdrop: 'static',
            keyboard: false
        });
        successModal.show();

        setTimeout(() => {
            window.location.href = "home.php";
        }, 3000);
    </script>
<?php endif; ?>