<?php
include 'db.php';

$quiz_id = $_GET['id'];

// Zapytanie SQL do pobierania quizu i jego pytań
$sql_quiz = "SELECT title FROM quizzes WHERE id = $quiz_id";
$result_quiz = $conn->query($sql_quiz);
$quiz = $result_quiz->fetch_assoc();

$sql_questions = "SELECT * FROM questions WHERE quiz_id = $quiz_id";
$result_questions = $conn->query($sql_questions);
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
        <h1>Rozwiąż Quiz: <?php echo $quiz['title']; ?></h1>
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
        <?php if ($result_questions->num_rows > 0): ?>
            <form action="submit_quiz.php" method="post">
                <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
                <label for="username">Nazwa użytkownika:</label>
                <input type="text" id="username" name="username" required>
                <?php while ($row = $result_questions->fetch_assoc()): ?>
                    <div class="question">
                        <p><?php echo $row['question']; ?></p>
                        <div class="options">
                            <?php if ($row['question_type'] == 'multiple_choice'): ?>
                                <?php for ($i = 1; $i <= 4; $i++): ?>
                                    <?php if (!empty($row["option$i"])): ?>
                                        <label>
                                            <input type="radio" name="question_<?php echo $row['id']; ?>" value="<?php echo $row["option$i"]; ?>" required>
                                            <?php echo $row["option$i"]; ?>
                                        </label><br>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            <?php elseif ($row['question_type'] == 'true_false'): ?>
                                <label>
                                    <input type="radio" name="question_<?php echo $row['id']; ?>" value="Prawda" required> Prawda
                                </label><br>
                                <label>
                                    <input type="radio" name="question_<?php echo $row['id']; ?>" value="Fałsz" required> Fałsz
                                </label><br>
                            <?php elseif ($row['question_type'] == 'open_ended'): ?>
                                <label>
                                    <input type="text" name="question_<?php echo $row['id']; ?>" required>
                                </label><br>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
                <button type="submit">Zakończ Quiz</button>
            </form>
        <?php else: ?>
            <p>Brak pytań w tym quizie.</p>
        <?php endif; ?>
    </main>
</body>
</html>
<?php
$conn->close();
?>
