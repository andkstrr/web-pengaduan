<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9e9e9;
        }

        .chart-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 800px;
            margin: auto;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 2rem;
        }

        canvas {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Navbar -->
        <nav class="navbar mb-5 p-4 rounded-3 bg-white">
            <div class="container">
                <a class="navbar-brand" href="{{ route('headstaff.account-staff') }}">
                    <i class="fas fa-circle-info text-underline"> </i> Kelola Akun
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary px-5 py-3">Logout</button>
                </form>
            </div>
        </nav>

        <!-- Chart Section -->
        <div class="chart-card">
            <h5 class="text-center">Laporan Pengaduan dan Tanggapan</h5>
            <canvas id="myChart"></canvas>
        </div>
    </div>

    <script>
        const labels = ['Pengaduan'];
        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Pengaduan',
                    data: [{{ $value1 }}],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                },
                {
                    label: 'Tanggapan',
                    data: [{{ $value2 }}],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                }
            ]
        };

        const config = {
            type: 'bar',
            data: data,
        };

        new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
</body>
</html>
