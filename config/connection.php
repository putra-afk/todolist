<?php
$conn = mysqli_connect('localhost', 'root', '', 'todolist');

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
