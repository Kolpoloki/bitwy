<?php
include 'db.php';

$id = $_GET['id'];

$sql = "DELETE FROM battles WHERE id = $id";
$conn->query($sql);

$conn->close();
header("Location: battle_list.php");
exit();
?>
