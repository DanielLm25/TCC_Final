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
    $amount = $_POST['amount'] ?? '';
    $description = $_POST['description'] ?? '';
    $expense_type_id = $_POST['expense_type_id'] ?? '';
    $user_id = $_SESSION['user_id'];

    try {
        if ($amount && $description && $expense_type_id) {
            $db = new Database();
            $conn = $db->connect();

            $query = "INSERT INTO expenses (user_id, amount, description, expense_type_id) 
                      VALUES (:user_id, :amount, :description, :expense_type_id)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':expense_type_id', $expense_type_id);

            if ($stmt->execute()) {
                $message = "Gasto adicionado com sucesso!";
            } else {
                $message = "Erro ao adicionar o gasto.";
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

<div class="container-expenses">
    <h2>Adicionar Gasto</h2>
    <form action="add_expense.php" method="POST">
        <div class="form-group">
            <label for="amount">Valor</label>
            <input type="number" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="form-group">
            <label for="description">Descrição</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>
        <div class="form-group">
            <label for="expense_type_id">Categoria</label>
            <select class="form-control" id="expense_type_id" name="expense_type_id" required>
                <option value="">Selecione uma categoria</option>
                <?php
                try {
                    $db = new Database();
                    $conn = $db->connect();

                    $query = "SELECT id, name FROM expense_types";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();

                    $expense_types = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($expense_types as $type) {
                        echo "<option value='{$type['id']}'>{$type['name']}</option>";
                    }
                } catch (Exception $e) {
                    echo "<option disabled>Erro ao carregar categorias</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Adicionar Gasto</button>
    </form>
</div>

<?php require_once './includes/footer.php';
?>