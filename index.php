<!-- dont forget database -->
<!-- CREATE DATABASE todo_db;
USE todo_db;

CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); -->


<?php
include 'db.php';

// Add task
if (isset($_POST['add'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $query = "INSERT INTO tasks (title) VALUES ('$title')";
    mysqli_query($conn, $query);
    header("Location: index.php");
    exit;
}

// Delete task
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $query = "DELETE FROM tasks WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: index.php");
    exit;
}

// Edit task
if (isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $query = "UPDATE tasks SET title = '$title' WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>To-Do List</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f9f9f9;
            padding: 40px;
            max-width: 600px;
            margin: auto;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-right: 10px;
        }

        button {
            padding: 10px 18px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            transition: background 0.2s;
        }

        button:hover {
            background-color: #218838;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background: #fff;
            margin-bottom: 10px;
            padding: 12px 15px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        li span {
            flex: 1;
        }

        li a {
            margin-left: 10px;
            text-decoration: none;
            font-size: 16px;
            color: #007bff;
        }

        li a:hover {
            color: #0056b3;
        }

        .edit-form {
            display: flex;
            margin-top: 20px;
        }

        .edit-form input[type="text"] {
            flex: 1;
        }

        .edit-form button {
            background-color: #ffc107;
        }

        .edit-form button:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>

<h2>To-Do List</h2>

<!-- Add Task Form -->
<form method="POST">
    <input type="text" name="title" placeholder="Enter new task" required>
    <button type="submit" name="add">Add</button>
</form>

<!-- Task List -->
<ul>
<?php
$result = mysqli_query($conn, "SELECT * FROM tasks ORDER BY created_at DESC");
while ($row = mysqli_fetch_assoc($result)):
?>
    <li>
        <?= htmlspecialchars($row['title']) ?>
        <a href="?edit=<?= $row['id'] ?>">Edit</a>
        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
    </li>
<?php endwhile; ?>
</ul>

<!-- Edit Task Form -->
<?php if (isset($_GET['edit'])): 
    $id = (int)$_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM tasks WHERE id = $id");
    $task = mysqli_fetch_assoc($res);
?>
<form method="POST">
    <input type="hidden" name="id" value="<?= $task['id'] ?>">
    <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>
    <button type="submit" name="edit">Save</button>
</form>
<?php endif; ?>

</body>
</html>
