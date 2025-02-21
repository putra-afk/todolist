<?php
require_once '../config/connection.php';

// [PUT] Form process to update new todo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['todo_id'];
    $is_done = 1;

    if ($id) {
        mysqli_query($conn, "UPDATE todos SET is_done=$is_done WHERE todo_id=$id");
        $msg = 'Todo berhasil diupdate';
        header('Location: ../todos.php');
    } else {
        $msg = 'Data tidak lengkap!';
    }
}
