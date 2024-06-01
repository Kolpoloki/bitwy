<?php
include 'db.php';

$id = $_GET['id'];

$sql = "SELECT * FROM battles WHERE id = $id";
$result = $conn->query($sql);
$battle = $result->fetch_assoc();

if (!$battle) {
    echo "Bitwa nie została znaleziona.";
    exit();
}

// Pobierz dane stron konfliktu
$sql_sides = "SELECT * FROM battle_sides WHERE battle_id = $id";
$result_sides = $conn->query($sql_sides);
$sides = [];
while ($row = $result_sides->fetch_assoc()) {
    $sides[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platforma do Analizy Historycznych Bitew</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            width: 50%;
            margin: 20px auto;
        }
        .chart-container canvas {
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <header>
        <h1>Szczegóły Bitwy</h1>
        <nav>
            <ul>
                <li><a href="index.php">Strona Główna</a></li>
                <li><a href="battle_list.php">Lista Bitew</a></li>
                <li><a href="add_battle.php">Dodaj Bitwę</a></li>
                <li><a href="quiz_list.php">Lista Quizów</a></li>
                <li><a href="add_quiz.php">Dodaj Quiz</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2 style="font-size:40px;">Informacje Ogólne</h2>
        <p><strong>Data:</strong> <?php echo htmlspecialchars($battle['date']); ?></p>
        <p><strong>Lokalizacja:</strong> <?php echo htmlspecialchars($battle['location']); ?></p>
        <p><strong>Opis:</strong> <?php echo nl2br(htmlspecialchars($battle['description'])); ?></p>
        <p><strong>Kontekst Historyczny:</strong> <?php echo nl2br(htmlspecialchars($battle['context'])); ?></p>
        <p><strong>Przyczyny:</strong> <?php echo nl2br(htmlspecialchars($battle['causes'])); ?></p>
        <p><strong>Skutki:</strong> <?php echo nl2br(htmlspecialchars($battle['effects'])); ?></p>
        <p><strong>Kluczowe momenty:</strong> <?php echo nl2br(htmlspecialchars($battle['key_moments'])); ?></p>
        <hr>
        <h2 style="font-size:40px;">Strony Konfliktu</h2>
        <?php foreach ($sides as $index => $side): ?>
            <h3 style="font-size:30px;">Strona <?php echo $index + 1; ?>: <?php echo htmlspecialchars($side['side_name']); ?></h3>
            <p><strong>Dowódcy:</strong> <?php echo htmlspecialchars($side['commanders']); ?></p>
            <p><strong>Straty Materialne:</strong> <?php echo htmlspecialchars($side['material_losses']); ?></p>
            <p><strong>Motywy:</strong> <?php echo htmlspecialchars($side['motives']); ?></p>
            <p><strong>Ilość wystawionych wojsk:</strong> <?php echo htmlspecialchars($side['total_troops']); ?></p>
            <p><strong>Jednostki wojenne:</strong> <?php echo htmlspecialchars($side['troops']); ?></p>
            <p><strong>Strategia:</strong> <?php echo htmlspecialchars($side['strategy']); ?></p>
        <?php endforeach; ?>
        <hr>
        <h2 style="font-size:40px; margin-bottom:50px;">Wykresy Statystyk</h2>
        <div class="chart-container">
            <h3 style="font-size:30px;">Wystawione wojska</h3>
            <canvas id="troopsChart"></canvas>
        </div>
        <div class="chart-container">
            <h3 style="font-size:30px;">Ranni</h3>
            <canvas id="woundedChart"></canvas>
        </div>        
        <div class="chart-container">
            <h3 style="font-size:30px;">Poległych</h3>
            <canvas id="casualtiesChart"></canvas>
        </div>
        <div class="chart-container">
            <h3 style="font-size:30px;">Jeńcy</h3>
            <canvas id="prisonersChart"></canvas>
        </div>
        <hr>
    </main>
    <script>
        const sides = <?php echo json_encode($sides); ?>;
        
        const sideNames = sides.map(side => side.side_name);

        const woundedData = sides.map(side => side.wounded);
        const casualtiesData = sides.map(side => side.casualties);
        const prisonersData = sides.map(side => side.prisoners);
        const troopsData = sides.map(side => side.total_troops);

        const ctxWounded = document.getElementById('woundedChart').getContext('2d');
        const ctxCasualties = document.getElementById('casualtiesChart').getContext('2d');
        const ctxPrisoners = document.getElementById('prisonersChart').getContext('2d');
        const ctxTroops = document.getElementById('troopsChart').getContext('2d');

        new Chart(ctxWounded, {
            type: 'pie',
            data: {
                labels: sideNames,
                datasets: [{
                    data: woundedData,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Ranni'
                    }
                }
            }
        });

        new Chart(ctxCasualties, {
            type: 'pie',
            data: {
                labels: sideNames,
                datasets: [{
                    data: casualtiesData,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Poległych'
                    }
                }
            }
        });

        new Chart(ctxPrisoners, {
            type: 'pie',
            data: {
                labels: sideNames,
                datasets: [{
                    data: prisonersData,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Jeńcy'
                    }
                }
            }
        });

        new Chart(ctxTroops, {
            type: 'pie',
            data: {
                labels: sideNames,
                datasets: [{
                    data: troopsData,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Wojska'
                    }
                }
            }
        });
    </script>
</body>
</html>
