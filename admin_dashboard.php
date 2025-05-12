<?php
include 'db.php';
session_start();

// Ensure only admins can access this page
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all users with role 'user' for task assignment
$users = $conn->query("SELECT * FROM users WHERE role='user'");

// Handle task assignment form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];
    $assigned_to = $_POST['assigned_to'];
    $assigned_by = $_SESSION['user_id'];

    $sql = "INSERT INTO tasks (assigned_by, assigned_to, title, description, deadline, status) 
            VALUES ('$assigned_by', '$assigned_to', '$title', '$description', '$deadline', 'pending')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Task assigned successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}

// Display tasks assigned by the admin and their status
echo "<h1>Assigned Tasks</h1>";
$result = $conn->query("SELECT tasks.*, users.username AS assigned_user 
                        FROM tasks 
                        JOIN users ON tasks.assigned_to = users.id 
                        WHERE tasks.assigned_by = '{$_SESSION['user_id']}'");

while ($task = $result->fetch_assoc()) {
    echo "<p>
            <strong>Task:</strong> {$task['title']}<br>
            <strong>Description:</strong> {$task['description']}<br>
            <strong>Assigned To:</strong> {$task['assigned_user']}<br>
            <strong>Deadline:</strong> {$task['deadline']}<br>
            <strong>Status:</strong> 
            <span style='color: " . ($task['status'] === 'completed' ? 'green' : 'red') . "'>
            {$task['status']}</span>
          </p>";
}
?>

<!-- Task assignment form -->
<h2>Assign a New Task</h2>
<form method="post">
    Title: <input type="text" name="title" required><br>
    Description: <textarea name="description" required></textarea><br>
    Deadline: <input type="date" name="deadline" required><br>
    Assign to: 
    <select name="assigned_to">
        <?php 
        while ($user = $users->fetch_assoc()) {
            echo "<option value='{$user['id']}'>{$user['username']}</option>";
        }
        ?>
    </select><br>
    <input type="submit" value="Assign Task">
</form>

<!-- Logout link -->
<a href="logout.php">Logout</a>
