<?php
include 'db.php';

if (isset($_GET['id'])) {
    $quiz_id = $_GET['id'];

    // Najpierw usuwamy wszystkie pytania powiązane z quizem
    $sql_delete_questions = "DELETE FROM questions WHERE quiz_id = $quiz_id";
    if ($conn->query($sql_delete_questions) === TRUE) {
        // Następnie usuwamy sam quiz
        $sql_delete_quiz = "DELETE FROM quizzes WHERE id = $quiz_id";
        if ($conn->query($sql_delete_quiz) === TRUE) {
            echo "Quiz i powiązane pytania zostały pomyślnie usunięte.";
        } else {
            echo "Błąd podczas usuwania quizu: " . $conn->error;
        }
    } else {
        echo "Błąd podczas usuwania pytań quizu: " . $conn->error;
    }
} else {
    echo "Nieprawidłowe żądanie.";
}

$conn->close();

// Przekierowanie z powrotem do listy quizów
header("Location: quiz_list.php");
exit();
?>
