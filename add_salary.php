<?php
require_once './includes/header.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once './config/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $salario_bruto = $_POST['salario_bruto'] ?? '';
    $desconto_imposto = $_POST['desconto_imposto'] ?? '';
    $user_id = $_SESSION['user_id'];

    $salario_liquido = $salario_bruto - $desconto_imposto;

    try {
        if ($salario_bruto && $desconto_imposto) {
            $db = new Database();
            $conn = $db->connect();

            $query = "INSERT INTO salaries (user_id, salario_bruto, desconto_imposto, salario_liquido) 
                      VALUES (:user_id, :salario_bruto, :desconto_imposto, :salario_liquido)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':salario_bruto', $salario_bruto);
            $stmt->bindParam(':desconto_imposto', $desconto_imposto);
            $stmt->bindParam(':salario_liquido', $salario_liquido);

            if ($stmt->execute()) {
                $message = "Salário adicionado com sucesso!";
            } else {
                $message = "Erro ao adicionar o salário.";
            }
        } else {
            $message = "Por favor, preencha todos os campos.";
        }
    } catch (Exception $e) {
        $message = 'Erro: ' . $e->getMessage();
    }
}
?>

<?php if ($message): ?>
    <div class="alert alert-info"><?php echo $message; ?></div>
<?php endif; ?>

<div class="container-salary">
    <h2>Adicionar Salário</h2>
    <form action="add_salary.php" method="POST">
        <div class="form-group">
            <label for="salario_bruto">Salário Bruto</label>
            <input type="number" class="form-control" id="salario_bruto" name="salario_bruto" required step="0.01">
        </div>
        <div class="form-group">
            <label for="desconto_imposto">Desconto Imposto</label>
            <input type="number" class="form-control" id="desconto_imposto" name="desconto_imposto" required step="0.01">
        </div>
        <button type="submit" class="btn btn-primary">Adicionar Salário</button>
    </form>
</div>

<?php require_once './includes/footer.php';
?>