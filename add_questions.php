<?php
include 'db.php';

$quiz_id = $_GET['quiz_id'];
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
        <h1>Dodaj Pytanie do Quizu</h1>
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
        <form action="insert_question.php" method="post">
            <input class="multiple" type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
            <label for="question">Pytanie:</label>
            <textarea name="question" id="question" required></textarea><br>

            <label for="question_type">Typ Pytania:</label>
            <select name="question_type" id="question_type" required>
                <option value="multiple_choice">Wielokrotnego wyboru</option>
                <option value="true_false">Prawda/Fałsz</option>
                <option value="open_ended">Otwarte</option>
            </select><br>

            <div id="multiple_choice_options">
                <label>Opcje odpowiedzi:</label><br>
                <input class="multiple" type="text" name="option1" placeholder="Opcja 1" required><br>
                <input class="multiple" type="text" name="option2" placeholder="Opcja 2" required><br>
                <input class="multiple" type="text" name="option3" placeholder="Opcja 3" required><br>
                <input class="multiple" type="text" name="option4" placeholder="Opcja 4" required><br>
                <label for="correct_option">Poprawna Opcja:</label>
                <select name="correct_option" id="correct_option">
                    <option value="1">Opcja 1</option>
                    <option value="2">Opcja 2</option>
                    <option value="3">Opcja 3</option>
                    <option value="4">Opcja 4</option>
                </select><br>
            </div>

            <div id="true_false_options" style="display: none;">
                <label>Poprawna Odpowiedź:</label>
                <select name="correct_tf">
                    <option value="Prawda">Prawda</option>
                    <option value="Fałsz">Fałsz</option>
                </select><br>
            </div>
            
            <div id="open_ended_options" style="display: none;">
                <label>Poprawna Odpowiedź:</label>
                <input id="open_ended" type="text" name="correct_open_ended" placeholder="Poprawna odpowiedź"><br>
            </div>

            <button type="submit">Dodaj Pytanie</button>
        </form>
        <a href="quiz_list.php">Ukończ Tworzenie</a>
    </main>

    <script>
        document.getElementById('question_type').addEventListener('change', function () {
            var type = this.value;
            if (type === 'multiple_choice') {
                document.getElementById('multiple_choice_options').style.display = 'block';
                document.getElementById('true_false_options').style.display = 'none';
                document.getElementById('open_ended_options').style.display = 'none';
                inputs = document.getElementsByClassName('multiple');
                for(i=0;i<inputs.length;i++){inputs[i].required=true};
            } else if (type === 'true_false') {
                document.getElementById('multiple_choice_options').style.display = 'none';
                document.getElementById('true_false_options').style.display = 'block';
                document.getElementById('open_ended_options').style.display = 'none';
                inputs = document.getElementsByClassName('multiple');
                for(i=0;i<inputs.length;i++){inputs[i].required=false};
            } else if (type === 'open_ended') {
                document.getElementById('multiple_choice_options').style.display = 'none';
                document.getElementById('true_false_options').style.display = 'none';
                document.getElementById('open_ended_options').style.display = 'block';
                inputs = document.getElementsByClassName('multiple');
                for(i=0;i<inputs.length;i++){inputs[i].required=false};
            }
        });
    </script>
</body>
</html>
