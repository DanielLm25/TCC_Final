<?php
require_once './includes/header.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once './config/db.php';

$balance = '';
$renda_mensal = '';
$renda_acumulada = '';
$new_salary = '';
$salary_message = '';

try {
    $user_id = $_SESSION['user_id'];
    $db = new Database();
    $conn = $db->connect();

    $query = "SELECT salario_liquido, created_at FROM salaries WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $salary = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($salary) {
        $balance = $salary['salario_liquido'];
        $created_at = $salary['created_at'];
    } else {
        $balance = 'Não disponível';
        $created_at = null;
    }

    if ($created_at && $balance !== 'Não disponível') {
        $date_created = new DateTime($created_at);
        $date_now = new DateTime();

        $interval = $date_created->diff($date_now);
        $months = $interval->y * 12 + $interval->m;

        if ($months == 0) {
            $renda_acumulada = $balance;
        } else {
            $renda_acumulada = $balance * $months;
        }

        $renda_mensal = number_format($balance, 2, ',', '.');
    } else {
        $renda_mensal = 'Não disponível';
        $renda_acumulada = 'Não disponível';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['salary']) && is_numeric($_POST['salary']) && $_POST['salary'] > 0) {
            $new_salary = $_POST['salary'];

            if ($balance !== 'Não disponível') {
                $update_query = "UPDATE salaries SET salario_liquido = :salary WHERE user_id = :user_id";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bindParam(':salary', $new_salary);
                $update_stmt->bindParam(':user_id', $user_id);

                if ($update_stmt->execute()) {
                    $salary_message = 'Salário atualizado com sucesso!';
                    $balance = $new_salary;
                } else {
                    $salary_message = 'Erro ao atualizar o salário. Tente novamente.';
                }
            } else {
                $insert_query = "INSERT INTO salaries (user_id, salario_liquido) VALUES (:user_id, :salary)";
                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bindParam(':user_id', $user_id);
                $insert_stmt->bindParam(':salary', $new_salary);

                if ($insert_stmt->execute()) {
                    $salary_message = 'Salário adicionado com sucesso!';
                    $balance = $new_salary;
                } else {
                    $salary_message = 'Erro ao adicionar o salário. Tente novamente.';
                }
            }
        } else {
            $salary_message = 'Por favor, insira um valor válido para o salário.';
        }
    }
} catch (Exception $e) {
    $balance = 'Erro ao carregar saldo: ' . $e->getMessage();
    $renda_mensal = 'Erro';
    $renda_acumulada = 'Erro';
}
?>

<div class="container-gastos">
    <h2>Detalhes da Renda</h2>

    <div class="row">
        <div class="col-md-6">
            <p><strong>Renda Mensal:</strong> R$ <?php echo $renda_mensal; ?></p>
        </div>

        <div class="col-md-6">
            <p><strong>Renda Acumulada:</strong> R$ <?php echo number_format($renda_acumulada, 2, ',', '.'); ?></p>
        </div>
    </div>

    <?php if ($salary_message): ?>
        <div class="alert alert-info"><?php echo $salary_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="salary">Salário:</label>
            <input type="number" step="0.01" class="form-control" id="salary" name="salary"
                value="<?php echo $balance !== 'Não disponível' ? $balance : ''; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Salário</button>
    </form>
</div>

<?php require_once './includes/footer.php';
?>