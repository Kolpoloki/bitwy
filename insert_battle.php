<?php
include 'db.php';

$name = $_POST['name'];
$date = $_POST['date'];
$location = $_POST['location'];
$description = $_POST['description'];
$context = $_POST['context'];
$causes = $_POST['causes'];
$effects = $_POST['effects'];

$sql = "INSERT INTO battles (name, date, location, description, context, causes, effects) 
        VALUES ('$name', '$date', '$location', '$description', '$context', '$causes', '$effects')";
$conn->query($sql);

$battle_id = $conn->insert_id;

$sides = $_POST['sides'];
$commanders = $_POST['commanders'];
$motives = $_POST['motives'];
$casualties = $_POST['casualties'];
$wounded = $_POST['wounded'];
$prisoners = $_POST['prisoners'];
$material_losses = $_POST['material_losses'];

for ($i = 0; $i < count($sides); $i++) {
    $side_name = $sides[$i];
    $commander = $commanders[$i];
    $motive = $motives[$i];
    $casualty = $casualties[$i];
    $wound = $wounded[$i];
    $prisoner = $prisoners[$i];
    $material_loss = $material_losses[$i];

    $sql = "INSERT INTO battle_sides (battle_id, side_name, commanders, motives, casualties, wounded, prisoners, material_losses) 
            VALUES ('$battle_id', '$side_name', '$commander', '$motive', '$casualty', '$wound', '$prisoner', '$material_loss')";
    $conn->query($sql);
}

$conn->close();

header("Location: battle_list.php");
?>
