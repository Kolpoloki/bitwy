<?php
include 'db.php';

// Zapytanie SQL do pobierania quizów i liczby pytań
$sql = "SELECT quizzes.id, quizzes.title, quizzes.description, COUNT(questions.id) AS question_count
        FROM quizzes
        LEFT JOIN questions ON quizzes.id = questions.quiz_id
        GROUP BY quizzes.id, quizzes.title";
$result = $conn->query($sql);
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
        <h1>Lista Quizów</h1>
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
        <table>
            <thead>
                <tr>
                    <th>Nazwa Quizu</th>
                    <th>Opis Quizu</th>
                    <th>Liczba Pytań</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["title"] . "</td>";
                        echo "<td>" . $row["description"] . "</td>";
                        echo "<td>" . $row["question_count"] . "</td>";
                        echo "<td>";
                        echo "<a class='button' href='solve_quiz.php?id=" . $row["id"] . "'>Rozwiąż</a> ";
                        echo "<a class='button' href='user_results.php?quiz_id=" . $row["id"] . "')'>Wyniki użytkowników</a>";
                        echo "<a class='button' href='delete_quiz.php?id=" . $row["id"] . "' onclick='return confirmDelete()' style='margin-left:5px;'>Usuń</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Brak quizów do wyświetlenia</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
    <script>
        function confirmDelete() {
            var code = prompt("Proszę wprowadzić kod potwierdzenia(1234567890):");
            return code === "1234567890"
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>