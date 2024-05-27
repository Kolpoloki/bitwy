<?php
include 'db.php';

$sql = "SELECT * FROM battles";
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
        <h1>Lista Bitew</h1>
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
            <th>Nazwa</th>
            <th>Data</th>
            <th>Lokalizacja</th>
            <th>Akcje</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['location']); ?></td>
                <td>
                    <a class='button' href="edit_battle.php?id=<?php echo $row['id']; ?>">Edytuj</a>
                    <a class='button' href="delete_battle.php?id=<?php echo $row['id']; ?>" onclick="return confirmDelete()">Usuń</a>
                    <a class='button' href="battle_details.php?id=<?php echo $row['id']; ?>">Zobacz szczegóły</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Brak dodanych bitew.</td>
            </tr>
        <?php endif; ?>
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
