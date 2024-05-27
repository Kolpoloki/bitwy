<?php
include 'db.php';

$id = $_POST['id'];
$name = $_POST['name'];
$date = $_POST['date'];
$location = $_POST['location'];
$description = $_POST['description'];
$context = $_POST['context'];
$causes = $_POST['causes'];
$effects = $_POST['effects'];

$sql = "UPDATE battles SET name='$name', date='$date', location='$location', description='$description', context='$context', causes='$causes', effects='$effects' WHERE id=$id";
$conn->query($sql);

// Usuń stare dane stron konfliktu
$sql = "DELETE FROM battle_sides WHERE battle_id=$id";
$conn->query($sql);

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
            VALUES ('$id', '$side_name', '$commander', '$motive', '$casualty', '$wound', '$prisoner', '$material_loss')";
    $conn->query($sql);
}

$conn->close();

header("Location: battle_list.php?id=$id");
?>
