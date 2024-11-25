</div>

<div class="footer">
    <p>O Gestor Financeiro</p>
    <p>Av. Lorem Ipsum, silor domor 211 - São Paulo SC</p>
</div>

<script src="/js/lpCadastro.js"></script>
<script src="/js/Calc.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var categories = <?php echo json_encode(array_column($expenses, 'category')); ?>;
    var totals = <?php echo json_encode(array_column($expenses, 'total_expense')); ?>;

    var ctx = document.getElementById('expenses-chart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: categories,
            datasets: [{
                label: 'Total de Gastos por Categoria',
                data: totals,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
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
</script>

</body>

</html>