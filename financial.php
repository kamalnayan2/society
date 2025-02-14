<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Overview</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .container {
            margin-top: 50px;
        }
        body{
            background-color: #BDCE6FFF;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Financial Overview</h2>
        <canvas id="financialChart" width="400" height="200"></canvas>

        <?php
        // Database connection parameters
        include 'partials/db_connect.php';

        // Fetch financial data
        $query = "SELECT EXTRACT(MONTH FROM created_at) AS month, SUM(amount) AS total_amount 
                  FROM transactions 
                  WHERE status = 'Success' 
                  GROUP BY month 
                  ORDER BY month";
        $result = pg_query($conn, $query);

        $months = [];
        $totals = [];

        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $months[] = (int)$row['month'];
                $totals[] = (float)$row['total_amount'];
            }
        } else {
            echo "<div class='alert alert-danger'>Error fetching financial data: " . pg_last_error() . "</div>";
        }

        pg_close($conn);
        ?>

        <script>
            // Prepare data for the chart
            const months = <?= json_encode($months) ?>;
            const totals = <?= json_encode($totals) ?>;

            // Create the chart
            const ctx = document.getElementById('financialChart').getContext('2d');
            const financialChart = new Chart(ctx, {
                type: 'bar', // Change to 'line' for a line chart
                data: {
                    labels: months.map(month => `Month ${month}`), // Label for each month
                    datasets: [{
                        label: 'Total Amount (₹)',
                        data: totals,
                        backgroundColor: 'rgba(117, 46, 7, 0.8)',
                        borderColor: 'rgba(237, 24, 24, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>
    <div class="text-center">
            <a href="..//login/home.php" class="btn btn-primary">Back to Home</a>
        </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>