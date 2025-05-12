<?php
include 'db.php';
session_start();

if ($_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM tasks WHERE assigned_to='$user_id'");

echo "<h1>Your Tasks</h1>";
while ($task = $result->fetch_assoc()) {
    echo "<p><strong>{$task['title']}</strong><br>{$task['description']}<br>Status: {$task['status']}<br>
          <a href='complete_task.php?id={$task['id']}'>Mark Complete</a></p>";
}
?>
<a href="logout.php">Logout</a>
