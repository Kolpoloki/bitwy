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
    <script>
        function addConflictSide() {
            const container = document.getElementById('conflict-sides-container');
            const sideCount = container.children.length + 1;
            const sideDiv = document.createElement('div');
            sideDiv.className = 'conflict-side';
            sideDiv.innerHTML = `
                <h3>Strona ${sideCount}</h3>
                <label for="side${sideCount}_name">Nazwa strony ${sideCount}:</label>
                <input type="text" id="side${sideCount}_name" name="sides[]" required><br>
                <label for="side${sideCount}_commanders">Dowódcy strony ${sideCount}:</label>
                <input type="text" id="side${sideCount}_commanders" name="commanders[]" required><br>
                <label for="side${sideCount}_motives">Motywy strony ${sideCount}:</label>
                <textarea id="side${sideCount}_motives" name="motives[]" required></textarea><br>
                <label for="side${sideCount}_total_troops">Wystawione wojska strony ${sideCount}:</label>
                <input type="number" id="side${sideCount}_total_troops" name="total_troops[]" required><br>
                <label for="side${sideCount}_casualties">Polegli strony ${sideCount}:</label>
                <input type="number" id="side${sideCount}_casualties" name="casualties[]" required><br>
                <label for="side${sideCount}_wounded">Ranni strony ${sideCount}:</label>
                <input type="number" id="side${sideCount}_wounded" name="wounded[]" required><br>
                <label for="side${sideCount}_prisoners">Jeńcy strony ${sideCount}:</label>
                <input type="number" id="side${sideCount}_prisoners" name="prisoners[]" required><br>
                <label for="side${sideCount}_material_losses">Straty materialne strony ${sideCount}:</label>
                <textarea id="side${sideCount}_material_losses" name="material_losses[]" required></textarea><br>
                <label for="side${sideCount}_troops">Jednostki wojenne strony ${sideCount}:</label>
                <textarea id="side${sideCount}_troops" name="troops[]" required></textarea><br>
                <label for="side${sideCount}_strategy">Strategia strony ${sideCount}:</label>
                <textarea id="side${sideCount}_strategy" name="strategy[]" required></textarea><br>
                <hr>
            `;
            container.appendChild(sideDiv);
        }
    </script>
</head>
<body>
    <header>
        <h1>Edytuj Bitwę</h1>
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
        <form action="update_battle.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($battle['id']); ?>">
            <label for="name">Nazwa bitwy:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($battle['name']); ?>" required><br>
            <label for="date">Data:</label>
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($battle['date']); ?>" required><br>
            <label for="location">Lokalizacja:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($battle['location']); ?>" required><br>
            <label for="description">Opis:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($battle['description']); ?></textarea><br>
            <label for="context">Kontekst historyczny:</label>
            <textarea id="context" name="context" required><?php echo htmlspecialchars($battle['context']); ?></textarea><br>
            <label for="causes">Przyczyny:</label>
            <textarea id="causes" name="causes" required><?php echo htmlspecialchars($battle['causes']); ?></textarea><br>
            <label for="effects">Skutki:</label>
            <textarea id="effects" name="effects" required><?php echo htmlspecialchars($battle['effects']); ?></textarea><br>
            <label for="key_moments">Skutki:</label>
            <textarea id="key_moments" name="key_moments" required><?php echo htmlspecialchars($battle['key_moments']); ?></textarea><br>
            <hr>
            <div id="conflict-sides-container">
                <?php foreach ($sides as $index => $side): ?>
                    <div class="conflict-side">
                        <h3>Strona <?php echo $index + 1; ?></h3>
                        <label for="side<?php echo $index + 1; ?>_name">Nazwa strony <?php echo $index + 1; ?>:</label>
                        <input type="text" id="side<?php echo $index + 1; ?>_name" name="sides[]" value="<?php echo htmlspecialchars($side['side_name']); ?>" required><br>
                        <label for="side<?php echo $index + 1; ?>_commanders">Dowódcy strony <?php echo $index + 1; ?>:</label>
                        <input type="text" id="side<?php echo $index + 1; ?>_commanders" name="commanders[]" value="<?php echo htmlspecialchars($side['commanders']); ?>" required><br>
                        <label for="side<?php echo $index + 1; ?>_motives">Motywy strony <?php echo $index + 1; ?>:</label>
                        <textarea id="side<?php echo $index + 1; ?>_motives" name="motives[]" required><?php echo htmlspecialchars($side['motives']); ?></textarea><br>
                        <label for="side<?php echo $index + 1; ?>_total_troops">Wystawione wojska strony <?php echo $index + 1; ?>:</label>
                        <input type="number" id="side<?php echo $index + 1; ?>_total_troops" name="total_troops[]" value="<?php echo htmlspecialchars($side['total_troops']); ?>" required><br>
                        <label for="side<?php echo $index + 1; ?>_casualties">Polegli strony <?php echo $index + 1; ?>:</label>
                        <input type="number" id="side<?php echo $index + 1; ?>_casualties" name="casualties[]" value="<?php echo htmlspecialchars($side['casualties']); ?>" required><br>
                        <label for="side<?php echo $index + 1; ?>_wounded">Ranni strony <?php echo $index + 1; ?>:</label>
                        <input type="number" id="side<?php echo $index + 1; ?>_wounded" name="wounded[]" value="<?php echo htmlspecialchars($side['wounded']); ?>" required><br>
                        <label for="side<?php echo $index + 1; ?>_prisoners">Jeńcy strony <?php echo $index + 1; ?>:</label>
                        <input type="number" id="side<?php echo $index + 1; ?>_prisoners" name="prisoners[]" value="<?php echo htmlspecialchars($side['prisoners']); ?>" required><br>
                        <label for="side<?php echo $index + 1; ?>_material_losses">Straty materialne strony <?php echo $index + 1; ?>:</label>
                        <textarea id="side<?php echo $index + 1; ?>_material_losses" name="material_losses[]" required><?php echo htmlspecialchars($side['material_losses']); ?></textarea><br>
                        <label for="side<?php echo $index + 1; ?>_troops">Jednostki wojenne strony <?php echo $index + 1; ?>:</label>
                        <textarea id="side<?php echo $index + 1; ?>_troops" name="troops[]" required><?php echo htmlspecialchars($side['troops']); ?></textarea><br>
                        <label for="side<?php echo $index + 1; ?>_strategy">Strategia strony <?php echo $index + 1; ?>:</label>
                        <textarea id="side<?php echo $index + 1; ?>_strategy" name="strategy[]" required><?php echo htmlspecialchars($side['strategy']); ?></textarea><br>
                        <hr>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" onclick="addConflictSide()">Dodaj stronę konfliktu</button><br><br>
            <input type="submit" value="Zaktualizuj Bitwę">
        </form>
    </main>
</body>
</html>
