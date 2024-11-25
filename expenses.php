<?php
require_once './includes/header.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once './config/db.php';
$user_id = $_SESSION['user_id'];
$expenses = [];
$labels = [];
$data = [];
$background_colors = [];

try {
    $db = new Database();
    $conn = $db->connect();

    $query = "
        SELECT e.amount, e.description, e.expense_type_id, e.date, et.name AS expense_type
        FROM expenses e
        JOIN expense_types et ON e.expense_type_id = et.id
        WHERE e.user_id = :user_id
        ORDER BY e.date DESC
    ";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($expenses) {
        $category_colors = [
            'Lazer' => 'rgba(255, 99, 132, 0.2)',
            'Investimento' => 'rgba(54, 162, 235, 0.2)',
            'Estudos' => 'rgba(75, 192, 192, 0.2)',
            'Despesas mensais' => 'rgba(153, 102, 255, 0.2)',
            'Educação' => 'rgba(255, 159, 64, 0.2)',
            'Outros' => 'rgba(201, 203, 207, 0.2)'
        ];

        foreach ($expenses as $expense) {
            $formatted_date = date('d/m/Y', strtotime($expense['date']));

            $label = $formatted_date . ' - ' . $expense['expense_type'];
            $labels[] = $label;
            $data[] = (float)$expense['amount'];


            $background_colors[] = isset($category_colors[$expense['expense_type']])
                ? $category_colors[$expense['expense_type']]
                : 'rgba(0, 0, 0, 0.2)';
        }
    } else {
        $error_message = 'Nenhum gasto encontrado.';
    }
} catch (Exception $e) {
    $error_message = 'Erro ao carregar gastos: ' . $e->getMessage();
}

?>

<div class="container-expenses-geral">
    <h2>Gráfico de Gastos</h2>

    <canvas id="expensesChart" width="400" height="300" style="margin-left: 420px;"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('expensesChart').getContext('2d');
    const expensesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Gastos',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: <?php echo json_encode($background_colors); ?>,
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toFixed(2);
                        }
                    }
                }
            }
        }
    });
</script>

<?php require_once './includes/footer.php';
?>