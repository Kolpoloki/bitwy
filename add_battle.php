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
        <h1>Dodaj Bitwę</h1>
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
        <form action="insert_battle.php" method="POST">
            <label for="name">Nazwa bitwy:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="date">Data:</label>
            <input type="date" id="date" name="date" required><br>
            <label for="location">Lokalizacja:</label>
            <input type="text" id="location" name="location" required><br>
            <label for="description">Opis:</label>
            <textarea id="description" name="description" required></textarea><br>
            <label for="context">Kontekst historyczny:</label>
            <textarea id="context" name="context" required></textarea><br>
            <label for="causes">Przyczyny:</label>
            <textarea id="causes" name="causes" required></textarea><br>
            <label for="effects">Skutki:</label>
            <textarea id="effects" name="effects" required></textarea><br>
            <label for="key_moments">Kluczowe momenty:</label>
            <textarea id="key_moments" name="key_moments" required></textarea><br>
            <hr>
            <div id="conflict-sides-container">
                <div class="conflict-side">
                    <h3>Strona 1</h3>
                    <label for="side1_name">Nazwa strony 1:</label>
                    <input type="text" id="side1_name" name="sides[]" required><br>
                    <label for="side1_commanders">Dowódcy strony 1:</label>
                    <input type="text" id="side1_commanders" name="commanders[]" required><br>
                    <label for="side1_motives">Motywy strony 1:</label>
                    <textarea id="side1_motives" name="motives[]" required></textarea><br>
                    <label for="side1_total_troops">Ilość wystawionych wojsk strony 1:</label>
                    <input type="number" id="side1_total_troops" name="total_troops[]" required><br>
                    <label for="side1_casualties">Polegli strony 1:</label>
                    <input type="number" id="side1_casualties" name="casualties[]" required><br>
                    <label for="side1_wounded">Ranni strony 1:</label>
                    <input type="number" id="side1_wounded" name="wounded[]" required><br>
                    <label for="side1_prisoners">Jeńcy strony 1:</label>
                    <input type="number" id="side1_prisoners" name="prisoners[]" required><br>
                    <label for="side1_material_losses">Straty materialne strony 1:</label>
                    <textarea id="side1_material_losses" name="material_losses[]" required></textarea><br>
                    <label for="side1_troops">Jednostki wojenne strony 1:</label>
                    <textarea id="side1_troops" name="troops[]" required></textarea><br>
                    <label for="side1_strategy">Strategia strony 1:</label>
                    <textarea id="side1_strategy" name="strategy[]" required></textarea><br>
                    <hr>
                </div>
                <div class="conflict-side">
                    <h3>Strona 2</h3>
                    <label for="side2_name">Nazwa strony 2:</label>
                    <input type="text" id="side2_name" name="sides[]" required><br>
                    <label for="side2_commanders">Dowódcy strony 2:</label>
                    <input type="text" id="side2_commanders" name="commanders[]" required><br>
                    <label for="side2_motives">Motywy strony 2:</label>
                    <textarea id="side2_motives" name="motives[]" required></textarea><br>
                    <label for="side2_total_troops">Ilość wystawionych wojsk strony 2:</label>
                    <input type="number" id="side2_total_troops" name="total_troops[]" required><br>
                    <label for="side2_casualties">Polegli strony 2:</label>
                    <input type="number" id="side2_casualties" name="casualties[]" required><br>
                    <label for="side2_wounded">Ranni strony 2:</label>
                    <input type="number" id="side2_wounded" name="wounded[]" required><br>
                    <label for="side2_prisoners">Jeńcy strony 2:</label>
                    <input type="number" id="side2_prisoners" name="prisoners[]" required><br>
                    <label for="side2_material_losses">Straty materialne strony 2:</label>
                    <textarea id="side2_material_losses" name="material_losses[]" required></textarea><br>
                    <label for="side2_troops">Jednostki wojenne strony 2:</label>
                    <textarea id="side2_troops" name="troops[]" required></textarea><br>
                    <label for="side2_strategy">Strategia strony 2:</label>
                    <textarea id="side2_strategy" name="strategy[]" required></textarea><br>
                    <hr>
                </div>
            </div>
            <button type="button" onclick="addConflictSide()">Dodaj stronę konfliktu</button><br><br>
            <input type="submit" value="Dodaj Bitwę">
        </form>
    </main>
</body>
</html>
