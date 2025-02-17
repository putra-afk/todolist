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
$result_get = mysqli_query($conn, $query_get);

// [POST] Form process to add new todo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_todo'])) {
    $todos = mysqli_real_escape_string($conn, $_POST['todos']);

    if (!empty($todos)) {
        $query_insert = "INSERT INTO todos (todos_name) VALUES ('$todos')";
        $result_insert = mysqli_query($conn, $query_insert);

        if ($result_insert) {
            $msg = 'Todo berhasil ditambahkan';
            $type = 'green';
        } else {
            $msg = 'Todo gagal ditambahkan';
            $type = 'red';
        }
    } else {
        $msg = 'Todo tidak boleh kosong';
        $type = 'red';
    }
}

// [PUT] Form process to update new todo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_todo'])) {
    $id = isset($_POST['todo_id']) ? (int) $_POST['todo_id'] : 0;
    $todos = mysqli_real_escape_string($conn, $_POST['todos']);

    if (!empty($todos) && $id > 0) {
        $query_update = "UPDATE todos SET todos_name = '$todos' WHERE todo_id = $id";
        $result_update = mysqli_query($conn, $query_update);

        if ($result_update) {
            $msg = 'Todo berhasil diupdate';
            $type = 'green';
        } else {
            $msg = 'Todo gagal diupdate';
            $type = 'red';
        }
    } else {
        $msg = 'Todo tidak boleh kosong atau ID tidak valid';
        $type = 'red';
    }
}

// [DELETE] Form process to update new todo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_todo'])) {
    $id = isset($_POST['todo_id']) ? (int) $_POST['todo_id'] : 0;

    if ($id > 0) {
        $query_delete = "DELETE FROM todos WHERE todo_id = $id";
        $result_delete = mysqli_query($conn, $query_delete);

        if ($result_delete) {
            $msg = 'Todo berhasil dihapus';
            $type = 'green';
        } else {
            $msg = 'Todo gagal dihapus';
            $type = 'red';
        }
    } else {
        $msg = 'ID tidak valid';
        $type = 'red';
    }
}
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

</head>

<body class="bg-gray-100">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />
    <nav class="fixed top-0 left-0 w-full bg-white shadow-md border-b border-gray-300 z-50">
        <div
            class="w-full text-gray-700 bg-white h-16 fixed top-0 animated z-40"
            x-data="{ atTop: true }"
            x-on:scroll.window="atTop = (window.pageYOffset > 10) ? false : true"
            x-bind:class='{ "bg-black shadow-lg": !atTop }'>
            <div class="flex flex-col max-w-screen-xl px-2 mx-auto md:items-center md:justify-between md:flex-row">
                <div class="p-4 flex flex-row items-center justify-between">
                    <a href="#" class="tracking-widest text-xl font-bold text-black-600 rounded-lg focus:outline-none focus:shadow-outline">ToDoList</a>
                    <button class="md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
                        <span class="text-lg text-primary"><i class="fas fa-bell"></i></span>
                    </button>
                </div>


                <div class="flex-col flex-grow pb-4 md:pb-0 hidden md:flex md:justify-end md:flex-row">
                    <a class="flex items-center px-3 py-1 mt-2 text-lg font-semibold text-primary rounded-lg md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200" href="#">
                        <i class="fas fa-envelope"></i>
                    </a>

                    <div @click.away="open = false" class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex flex-row items-center w-full px-2 py-2 mt-2 text-sm font-semibold text-left bg-transparent rounded-lg md:w-auto md:mt-0 md:ml-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200">
                            <span class="text-lg text-primary"><i class="fas fa-bell"></i></span>
                        </button>
                        <div x-show="open" class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-48">
                            <div class="px-2 py-2 bg-white rounded-md shadow">
                                <a class="block px-4 py-2 mt-2 bg-transparent rounded-lg text-sm font-semibold hover:text-gray-900 hover:bg-gray-200" href="#">Notifikasi 1</a>
                                <a class="block px-4 py-2 mt-2 bg-transparent rounded-lg text-sm font-semibold hover:text-gray-900 hover:bg-gray-200" href="#">Notifikasi #2</a>
                                <a class="block px-4 py-2 mt-2 bg-transparent rounded-lg text-sm font-semibold hover:text-gray-900 hover:bg-gray-200" href="#">Notifikasi #3</a>
                            </div>
                        </div>
                    </div>

                    <div @click.away="open = false" class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex flex-row items-center w-full px-1 py-1 mt-2 text-sm font-semibold text-left bg-shadow shadow-lg rounded-full md:w-auto md:mt-0 md:ml-2 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200">
                            <img src="assets/image/image2.png" class="w-auto h-6 rounded-full border-2 border-white" alt="" />
                        </button>
                        <div x-show="open" class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg md:w-48">
                            <div class="px-2 py-2 bg-white rounded-md shadow">
                                <a class="block px-4 py-2 mt-2 bg-transparent rounded-lg text-sm font-semibold hover:text-gray-900 hover:bg-gray-200" href="#">Forum</a>
                                <a class="block px-4 py-2 mt-2 bg-transparent rounded-lg text-sm font-semibold hover:text-gray-900 hover:bg-gray-200" href="#">Chat</a>
                                <?php if (isset($_SESSION['user'])): ?>
                                    <a class="block px-4 py-2 mt-2 bg-transparent rounded-lg text-sm font-semibold hover:text-red-600 hover:bg-gray-200" herf="./index.php">Logout</a>
                                <?php else: ?>
                                    <a class="block px-4 py-2 mt-2 bg-transparent rounded-lg text-sm font-semibold hover:text-green-600 hover:bg-gray-200" href="./index.php">Login</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->

    <div class="container mx-auto px-4 mt-20">
        <div class="flex justify-center">
            <div class="w-1/2 bg-white p-4 rounded-lg shadow-lg">
                <h1 class="text-2xl font-bold text-center">To Do List</h1>
                <form action="todos.php" method="POST" class="mt-4">
                    <div class="flex items-center">
                        <input type="text" name="todos" class="w-full p-2 border rounded-lg" placeholder="Add new todo">
                        <button type="submit" class="p-2 bg-blue-500 text-white rounded-lg ml-2">Add</button>
                    </div>
                </form>
                <?php if (!empty($msg)): ?>
                    <div class="mt-4 p-2 bg-<?php echo $type; ?>-200 text-<?php echo $type; ?>-800 rounded-lg">
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>
                <div class="mt-4">
                    <ul>
                        <?php while ($row = mysqli_fetch_assoc($result_get)): ?>
                            <li class="flex items-center justify-between p-2 border-b">
                                <span><?php echo htmlspecialchars($row['todos_name']); ?></span>

                                <div class="flex items-center">
                                    <button onclick="openEditModal(<?php echo $row['todo_id']; ?>, '<?php echo htmlspecialchars($row['todos_name']); ?>')" class="p-2 bg-green-500 text-white rounded-lg ml-2">Edit</button>
                                    <form action="todos.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="todo_id" value="<?php echo $row['todo_id']; ?>">
                                        <form action="todos.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="todo_id" value="<?php echo $row['todo_id']; ?>">
                                            <button type="submit" name="delete_todo" class="p-2 bg-red-500 text-white rounded-lg ml-2">Delete</button>
                                        </form>
                                    </form>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
                <div id="editModal" class="hidden fixed inset-0 bg-white bg-opacity-50 flex justify-center items-center">
                    <div class="bg-white p-4 rounded-lg shadow-lg w-1/3">
                        <h2 class="text-xl font-bold">Edit Todo</h2>
                        <form action="todos.php" method="POST">
                            <input type="hidden" name="todo_id" id="edit_todo_id">
                            <input type="text" name="todos" id="edit_todo_name" class="w-full p-2 border rounded-lg mt-2">
                            <div class="flex justify-end mt-4">
                                <button type="button" name="closeEditModal" class="p-2 bg-gray-500 text-white rounded-lg">Cancel</button>
                                <button type="submit" name="update_todo" class="p-2 bg-blue-500 text-white rounded-lg ml-2">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openEditModal(id, name) {
            document.getElementById('edit_todo_id').value = id;
            document.getElementById('edit_todo_name').value = name;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</body>

</html>