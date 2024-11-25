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
$renda_mensal = '';
$renda_acumulada = '';

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

    $query_salary = "SELECT salario_liquido, created_at FROM salaries WHERE user_id = :user_id ORDER BY created_at DESC LIMIT 1";
    $stmt_salary = $conn->prepare($query_salary);
    $stmt_salary->bindParam(':user_id', $user_id);
    $stmt_salary->execute();

    $salary = $stmt_salary->fetch(PDO::FETCH_ASSOC);

    if ($salary) {
        $balance = $salary['salario_liquido'];
        $created_at = $salary['created_at'];
        $renda_mensal = number_format($balance, 2, ',', '.');
    } else {
        $balance = 'Não disponível';
        $renda_mensal = 'Não disponível';
    }

    foreach ($expenses as $expense) {
        $formatted_date = date('d/m/Y', strtotime($expense['date']));
        $label = $formatted_date . ' - ' . $expense['expense_type'];
        $labels[] = $label;
        $data[] = (float)$expense['amount'];
        $background_colors[] = 'rgba(0, 123, 255, 0.2)';  // Cor padrão
    }
} catch (Exception $e) {
    $error_message = 'Erro ao carregar dados: ' . $e->getMessage();
}
?>

<div class="container">
    <h2>Comparativo: Renda vs Gastos</h2>

    <div class="row">
        <div class="col-md-6">
            <p><strong>Renda Mensal:</strong> R$ <?php echo $renda_mensal; ?></p>
        </div>
    </div>

    <h3>Gráfico de Barras</h3>
    <canvas id="expensesBarChart" width="400" height="200"></canvas>

    <h3>Gráfico de Linha</h3>
    <canvas id="expensesLineChart" width="400" height="200"></canvas>

    <h3>Gráfico de Pizza</h3>
    <canvas id="expensesPieChart" width="400" height="200"></canvas>

    <h3>Gráfico Radar</h3>
    <canvas id="expensesRadarChart" width="400" height="200"></canvas>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxBar = document.getElementById('expensesBarChart').getContext('2d');
    const expensesBarChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Gastos',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: <?php echo json_encode($background_colors); ?>,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctxLine = document.getElementById('expensesLineChart').getContext('2d');
    const expensesLineChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Gastos',
                data: <?php echo json_encode($data); ?>,
                fill: false,
                borderColor: 'rgba(75, 192, 192, 1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctxPie = document.getElementById('expensesPieChart').getContext('2d');
    const expensesPieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Gastos',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: <?php echo json_encode($background_colors); ?>,
            }]
        }
    });

    const ctxRadar = document.getElementById('expensesRadarChart').getContext('2d');
    const expensesRadarChart = new Chart(ctxRadar, {
        type: 'radar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Gastos',
                data: <?php echo json_encode($data); ?>,
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                pointBackgroundColor: 'rgba(255, 159, 64, 1)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgba(255, 159, 64, 1)'
            }]
        },
        options: {
            responsive: true,
            scale: {
                ticks: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php require_once './includes/footer.php'; ?>