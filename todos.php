<?php
require_once 'config/connection.php';

/**
 * Method Request itu ada 4
 * 
 * 1. GET -> Mengambil data
 * 2. POST -> Menambah data
 * 3. PUT / PATCH -> Mengubah Data
 * 4. DELETE -> Menghapus Data
 */

session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ./index.php');
}

$msg = '';
$type = '';

// [GET] Get all todos
$query_get = "SELECT * FROM todos";
$result_get = mysqli_query($conn, $query_get) or die(mysqli_error($conn));

// [POST] Form process to add new todo
if (isset($_POST['add_todo'])) {
    $todos = $_POST['todos'];
    $desc = $_POST['description'];
    $is_done = $_POST['is_done'] ?? 0;

    if ($todos && $desc) {
        mysqli_query($conn, "INSERT INTO todos (todos_name, description, is_done) VALUES ('$todos', '$desc', $is_done)");
        $msg = 'Todo berhasil ditambahkan';
    } else {
        $msg = 'Todo dan deskripsi wajib diisi!';
    }
}

// [PUT] Form process to update new todo
if (isset($_POST['update_todo'])) {
    var_dump($_POST);
    $id = $_POST['todo_id'];
    $todos = $_POST['todos'];
    $desc = $_POST['description'] ?? '';
    $is_done = $_POST['is_done'] ?? 0;

    if ($id && $todos && $desc) {
        mysqli_query($conn, "UPDATE todos SET todos_name='$todos', description='$desc', is_done=$is_done WHERE todo_id=$id");
        $msg = 'Todo berhasil diupdate';
    } else {
        $msg = 'Data tidak lengkap!';
    }
}

// [DELETE] Form process to update new todo
if (isset($_POST['delete_todo'])) {
    $id = $_POST['todo_id'];

    if ($id) {
        mysqli_query($conn, "DELETE FROM todos WHERE todo_id=$id");
        $msg = 'Todo berhasil dihapus';
    } else {
        $msg = 'ID tidak valid!';
    }
}
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.5/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <script>
        function toggleDropdown(dropdown) {
            document.getElementById(dropdown).classList.toggle("hidden");
        }
    </script>

</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full bg-white shadow-md border-b border-gray-300 z-50">
        <div class="max-w-screen-xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="#" class="text-xl font-bold text-gray-700">ToDoList</a>
            <div class="flex items-center space-x-4">
                <button class="text-gray-700 text-lg" onclick="toggleDropdown('notifDropdown')">
                    <i class="fas fa-bell"></i>
                </button>
                <div id="notifDropdown" class="absolute right-10 mt-2 w-48 bg-white shadow-lg rounded-md hidden">
                    <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-200">Notifikasi 1</a>
                    <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-200">Notifikasi 2</a>
                    <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-200">Notifikasi 3</a>
                </div>
                <button class="relative" onclick="toggleDropdown('userDropdown')">
                    <img src="assets/image/image2.png" class="h-8 w-8 rounded-full border-2 border-gray-300" alt="User">
                </button>
                <div id="userDropdown" class="absolute right-10 mt-2 w-48 bg-white shadow-lg rounded-md hidden">
                    <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-200">Forum</a>
                    <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-200">Chat</a>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="./index.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-200">Logout</a>
                    <?php else: ?>
                        <a href="./index.php" class="block px-4 py-2 text-sm text-green-600 hover:bg-gray-200">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="mt-20 max-w-4xl mx-auto p-4 bg-white shadow rounded-lg">
        <form action="" method="POST" class="mb-6 flex gap-2">
            <input type="text" name="todos" class="flex-1 p-2 border rounded-lg" placeholder="To-Do" required>
            <input type="text" name="description" class="flex-1 p-2 border rounded-lg" placeholder="Description" required>
            <button type="submit" name="add_todo" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add</button>
        </form>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">No</th>
                    <th class="border border-gray-300 px-4 py-2">To-Do</th>
                    <th class="border border-gray-300 px-4 py-2">Description</th>
                    <th class="border border-gray-300 px-4 py-2">Status</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                while ($row = mysqli_fetch_assoc($result_get)): ?>
                    <tr class="text-center">
                        <td class="border border-gray-300 px-4 py-2"><?php echo $no++; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($row['todos_name']); ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?php echo htmlspecialchars($row['description']); ?></td>
                        <td class="border border-gray-300 px-4 py-2">
                            <form action="" method="POST">
                                <input type="hidden" name="todo_id" value="<?php echo $row['todo_id']; ?>">
                                <button type="submit" name="update_todo" class="px-3 py-1 <?php echo $row['is_done'] ? 'bg-green-500' : 'bg-gray-500'; ?> text-white rounded-lg">
                                    <?php echo $row['is_done'] ? 'Undo' : 'Done'; ?>
                                </button>
                            </form>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <form action="" method="POST">
                                <input type="hidden" name="todo_id" value="<?php echo $row['todo_id']; ?>">
                                <button type="submit" name="delete_todo" class="px-3 py-1 bg-red-500 text-white rounded-lg">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>