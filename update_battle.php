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
$key_moments = $_POST['key_moments'];

$sql = "UPDATE battles SET name='$name', date='$date', location='$location', description='$description', context='$context', causes='$causes', effects='$effects', key_moments='$key_moments' WHERE id=$id";
$conn->query($sql);

// Usuń stare dane stron konfliktu
$sql = "DELETE FROM battle_sides WHERE battle_id=$id";
$conn->query($sql);

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
            VALUES ('$id', '$side_name', '$commander', '$motive', '$total_army', '$casualty', '$wound', '$prisoner', '$material_loss', '$army', '$strategy')";
    $conn->query($sql);
}

$conn->close();

header("Location: battle_list.php?id=$id");
?>
