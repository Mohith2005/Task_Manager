<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn->query("UPDATE tasks SET status='completed' WHERE id='$id'");
    header("Location: user_dashboard.php");
}
?>
