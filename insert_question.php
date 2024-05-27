<?php
include 'db.php';

$quiz_id = $_POST['quiz_id'];
$question = $_POST['question'];
$question_type = $_POST['question_type'];

if ($question_type == 'multiple_choice') {
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $correct_option = $_POST['correct_option'];
    if ($correct_option == 1) $correct_option = $option1;
    if ($correct_option == 2) $correct_option = $option2;
    if ($correct_option == 3) $correct_option = $option3;
    if ($correct_option == 4) $correct_option = $option4;
    $sql = "INSERT INTO questions (quiz_id, question, question_type, option1, option2, option3, option4, correct_option) VALUES ('$quiz_id', '$question', '$question_type', '$option1', '$option2', '$option3', '$option4', '$correct_option')";
} else if ($question_type == 'true_false') {
    $correct_option = $_POST['correct_tf'];
    $sql = "INSERT INTO questions (quiz_id, question, question_type, correct_option) VALUES ('$quiz_id', '$question', '$question_type', '$correct_option')";
} else if ($question_type == 'open_ended') {
    $correct_option = $_POST['correct_open_ended'];
    $sql = "INSERT INTO questions (quiz_id, question, question_type, correct_option) VALUES ('$quiz_id', '$question', '$question_type', '$correct_option')";
}

if ($conn->query($sql) === TRUE) {
    echo "Nowe pytanie zostało dodane pomyślnie";
} else {
    echo "Błąd: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header("Location: add_questions.php?quiz_id=$quiz_id");
exit();
?>
