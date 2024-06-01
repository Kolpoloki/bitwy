<?php
include 'db.php';

$name = $_POST['name'];
$date = $_POST['date'];
$location = $_POST['location'];
$description = $_POST['description'];
$context = $_POST['context'];
$causes = $_POST['causes'];
$effects = $_POST['effects'];
$key_moments = $_POST['key_moments'];

$sql = "INSERT INTO battles (name, date, location, description, context, causes, effects, key_moments) 
        VALUES ('$name', '$date', '$location', '$description', '$context', '$causes', '$effects', '$key_moments')";
$conn->query($sql);

$battle_id = $conn->insert_id;

$sides = $_POST['sides'];
$commanders = $_POST['commanders'];
$motives = $_POST['motives'];
$total_troops = $_POST['total_troops'];
$casualties = $_POST['casualties'];
$wounded = $_POST['wounded'];
$prisoners = $_POST['prisoners'];
$material_losses = $_POST['material_losses'];
$troops = $_POST['troops'];
$strategies = $_POST['strategy'];

for ($i = 0; $i < count($sides); $i++) {
    $side_name = $sides[$i];
    $commander = $commanders[$i];
    $motive = $motives[$i];
    $total_army = $total_troops[$i];
    $casualty = $casualties[$i];
    $wound = $wounded[$i];
    $prisoner = $prisoners[$i];
    $material_loss = $material_losses[$i];
    $army = $troops[$i];
    $strategy = $strategies[$i];

    $sql = "INSERT INTO battle_sides (battle_id, side_name, commanders, motives, total_troops, casualties, wounded, prisoners, material_losses, troops, strategy) 
            VALUES ('$battle_id', '$side_name', '$commander', '$motive','$total_army', '$casualty', '$wound', '$prisoner', '$material_loss', '$army', '$strategy')";
    $conn->query($sql);
}

$conn->close();

header("Location: battle_list.php");
?>
