<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "INSERT INTO quizzes (title, description) VALUES ('$title', '$description')";
    if ($conn->query($sql) === TRUE) {
        $quiz_id = $conn->insert_id;
        header("Location: add_questions.php?quiz_id=$quiz_id");
        exit();
    } else {
        echo "Błąd podczas tworzenia quizu: " . $conn->error;
    }
}
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
        <h1>Dodaj Quiz</h1>
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
        <form action="add_quiz.php" method="post">
            <label for="title">Tytuł Quizu:</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Opis:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <input type="submit" value="Dodaj Pytania">
        </form>
    </main>
</body>
</html>

<?php
$conn->close();
?>
