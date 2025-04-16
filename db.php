<?php
$conn = mysqli_connect("localhost", "root", "", "todo_db");

if (!$conn) {
    die("connection error " . mysqli_connect_error());
}
?>
