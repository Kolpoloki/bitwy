<?php
include 'db.php';

$quiz_id = $_POST['quiz_id'];

// Pobieranie pytań z quizu
$sql_questions = "SELECT * FROM questions WHERE quiz_id = $quiz_id";
$result_questions = $conn->query($sql_questions);
$username = $_POST['username'];
$correct_answers = 0;
$total_questions = $result_questions->num_rows;

$correct_tf = 0;
$incorrect_tf = 0;
$total_tf = 0;

$correct_open_ended = 0;
$incorrect_open_ended = 0;
$total_open_ended = 0;

$correct_mc = 0;
$incorrect_mc = 0;
$total_mc = 0;

$user_answers = [];
// $num = 1;
while ($row = $result_questions->fetch_assoc()) {
    $question_id = $row['id'];
    $question_type = $row['question_type'];
    $correct_option = $row['correct_option'];
    $user_answer = $_POST["question_$question_id"];
    
    $is_correct = false;

    if ($question_type == 'multiple_choice') {
        $total_mc++;
        if ($user_answer == $correct_option) {
            $correct_mc++;
            $is_correct = true;
        } else {
            $incorrect_mc++;
        }
    } elseif ($question_type == 'true_false') {
        $total_tf++;
        if ($user_answer == $correct_option) {
            $correct_tf++;
            $is_correct = true;
        } else {
            $incorrect_tf++;
        }
    } elseif ($question_type == 'open_ended') {
        $total_open_ended++;
        if (strcasecmp(trim($user_answer), trim($correct_option)) == 0) {
            $correct_open_ended++;
            $is_correct = true;
        } else {
            $incorrect_open_ended++;
        }
    }
    
    $user_answers[] = [
        'question' => $row['question'],
        'type' => $question_type,
        'user_answer' => $user_answer,
        'correct_answer' => $correct_option,
        'is_correct' => $is_correct
    ];
    // $num++;
}

$correct_answers = $correct_tf + $correct_open_ended + $correct_mc;
$incorrect_answers = $total_questions - $correct_answers;
$score = ($correct_answers / $total_questions) * 100;

$sql_insert_result = "INSERT INTO quiz_results (quiz_id, username, score, correct_answers, total_questions)
                      VALUES ($quiz_id, '$username', $score, $correct_answers, $total_questions)";
$conn->query($sql_insert_result);

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
</head>
<body>
    <header>
        <h1>Twój Wynik</h1>
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
        <h1 style="font-size:40px;">Twój wynik: <?php echo $correct_answers; ?> / <?php echo $total_questions; ?> (<?php echo round($score, 2); ?>%)</h1><hr>
        <!-- <div style="width: 40%; margin: auto;">
            <canvas id="resultChart"></canvas>
        </div> -->
        <h3>Podsumowanie odpowiedzi:</h3>
        <table>
            <thead>
                <tr>
                    <th>Pytanie</th>
                    <th>Twoja odpowiedź</th>
                    <th>Poprawna odpowiedź</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user_answers as $answer) : ?>
                    <tr>
                        <td><?php echo $answer['question']; ?></td>
                        <td><?php echo htmlspecialchars($answer['user_answer']); ?></td>
                        <td><?php echo htmlspecialchars($answer['correct_answer']); ?></td>
                        <td><?php echo $answer['is_correct'] ? 'Poprawna' : 'Niepoprawna'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <hr>

        <h2>Podsumowanie pytań prawda/fałsz:</h2>
        <div style="width: 40%; margin: auto;">
            <canvas id="tfChart"></canvas>
        </div><hr>
        <h2>Podsumowanie pytań otwartych:</h2>
        <div style="width: 40%; margin: auto;">
            <canvas id="openEndedChart"></canvas>
        </div><hr>
        <h2>Podsumowanie pytań wielokrotnego wyboru:</h2>
        <div style="width: 40%; margin: auto;">
            <canvas id="mcChart"></canvas>
        </div><hr>
        <script>
            // const ctxResult = document.getElementById('resultChart').getContext('2d');
            // const resultChart = new Chart(ctxResult, {
            //     type: 'pie',
            //     data: {
            //         labels: ['Poprawne', 'Niepoprawne'],
            //         datasets: [{
            //             data: [<?php echo $correct_answers; ?>, <?php echo $incorrect_answers; ?>],
            //             backgroundColor: ['#4caf50', '#f44336']
            //         }]
            //     },
            //     options: {
            //         responsive: true,
            //         plugins: {
            //             legend: {
            //                 position: 'right',
            //             },
            //             tooltip: {
            //                 callbacks: {
            //                     label: function(context) {
            //                         let label = context.label || '';
            //                         if (label) {
            //                             label += ': ';
            //                         }
            //                         points = context.raw;
            //                         label += points + " (" + Math.round(points / <?php echo $total_questions;?> * 100) +'%' + ")";
            //                         return label;
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // });
            if (<?php echo $total_tf; ?> == 0) {
                ctxTf = document.getElementById('tfChart')
                ctxTf.outerHTML = "Brak Danych"                
            } else {
                ctxTf = document.getElementById('tfChart').getContext('2d');
                const tfChart = new Chart(ctxTf, {
                    type: 'pie',
                    data: {
                        labels: ['Poprawne', 'Niepoprawne'],
                        datasets: [{
                            data: [<?php echo $correct_tf; ?>, <?php echo $incorrect_tf; ?>],
                            backgroundColor: ['#4caf50', '#f44336']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        points = context.raw;
                                        label += points + " (" + Math.round(points / <?php echo $total_tf;?> * 100) +'%' + ")";
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            }    

            if (<?php echo $total_open_ended; ?> == 0) {
                ctxOpenEnded = document.getElementById('openEndedChart')
                ctxOpenEnded.outerHTML = "Brak Danych"                
            } else {
                ctxOpenEnded = document.getElementById('openEndedChart').getContext('2d');
                const openEndedChart = new Chart(ctxOpenEnded, {
                    type: 'pie',
                    data: {
                        labels: ['Poprawne', 'Niepoprawne'],
                        datasets: [{
                            data: [<?php echo $correct_open_ended; ?>, <?php echo $incorrect_open_ended; ?>],
                            backgroundColor: ['#4caf50', '#f44336']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        points = context.raw;
                                        label += points + " (" + Math.round(points / <?php echo $total_open_ended;?> * 100) +'%' + ")";
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });                
            }

            if (<?php echo $total_mc; ?> == 0) {
                ctxMc = document.getElementById('mcChart')
                ctxMc.outerHTML = "Brak Danych"                
            } else {
                
            }
                ctxMc = document.getElementById('mcChart')                
                const mcChart = new Chart(ctxMc, {
                    type: 'pie',
                    data: {
                        labels: ['Poprawne', 'Niepoprawne'],
                        datasets: [{
                            data: [<?php echo $correct_mc; ?>, <?php echo $incorrect_mc; ?>],
                            backgroundColor: ['#4caf50', '#f44336']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        points = context.raw;
                                        label += points + " (" + Math.round(points / <?php echo $total_mc;?> * 100) +'%' + ")";
                                        return label;
                                    }
                                }
                            }
                        }
                    }
            });
        </script>
    </main>
</body>
</html>
