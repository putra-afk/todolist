<?php
require_once '../config/connection.php';

// [POST] Form process to add new todo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $todos = $_POST['todos'];
    $desc = $_POST['description'];
    $is_done = 0;

    if ($todos && $desc) {
        mysqli_query($conn, "INSERT INTO todos (todos_name, description, is_done) VALUES ('$todos', '$desc', $is_done)");
        $msg = 'Todo berhasil ditambahkan';
        header('Location: ../todos.php');
    } else {
        $msg = 'Todo dan deskripsi wajib diisi!';
    }
}
