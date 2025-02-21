<?php
require_once '../config/connection.php';

// [DELETE] Form process to update new todo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['todo_id'];

    if ($id) {
        mysqli_query($conn, "DELETE FROM todos WHERE todo_id=$id");
        $msg = 'Todo berhasil dihapus';
        header('Location: ../todos.php');
    } else {
        $msg = 'ID tidak valid!';
    }
}
