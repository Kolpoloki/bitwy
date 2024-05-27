<?php
include 'db.php';

// Sprawdzenie czy quiz_id jest ustawione
if (!isset($_GET['quiz_id'])) {
    die("Brak quiz_id");
}

$quiz_id = $_GET['quiz_id'];

// Pobieranie wyników quizu dla konkretnego quizu
$sql_results = "SELECT * FROM quiz_results WHERE quiz_id = $quiz_id ORDER BY date_taken DESC";
$result_results = $conn->query($sql_results);

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platforma do Analizy Historycznych Bitew</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Wyniki Quizu</h1>
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
        <h2>Wyniki użytkowników</h2>
        <table>
            <thead>
                <tr>
                    <th>Nazwa użytkownika</th>
                    <th>Wynik</th>
                    <th>Poprawne odpowiedzi</th>
                    <th>Łączna liczba pytań</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_results->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo  $row['username'] ; ?></td>
                        <td><?php echo $row['score']; ?>%</td>
                        <td><?php echo $row['correct_answers']; ?></td>
                        <td><?php echo $row['total_questions']; ?></td>
                        <td><?php echo $row['date_taken']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>

<?php
$conn->close();
?>
