<?php
require_once './config/connection.php';

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

</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 w-full bg-white shadow-md border-b border-gray-300 z-50">
        <div class="max-w-screen-xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="#" class="text-xl font-bold text-gray-700">ToDoList</a>
            <div class="flex items-center space-x-4">
                <a href="./process/logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-200">Logout</a>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="mt-20 max-w-4xl mx-auto p-4 bg-white shadow rounded-lg">
        <form action="./process/add.php" method="POST" name="add_todo" id="add_todo" class="mb-6 flex gap-2">
            <input type="text" name="todos" class="flex-1 p-2 border rounded-lg" placeholder="To-Do" required>
            <input type="text" name="description" class="flex-1 p-2 border rounded-lg" placeholder="Description" required>
            <input type="hidden" name="add" value="add">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add</button>
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
                            <form action="./process/update.php" method="POST" id="update_todo" name="update_todo">
                                <input type="hidden" name="todo_id" value="<?php echo $row['todo_id']; ?>">
                                <button type="submit" class="px-3 py-1 <?php echo $row['is_done'] ? 'bg-green-500' : 'bg-gray-500'; ?> text-white rounded-lg">
                                    <?php echo $row['is_done'] ? 'Done' : 'Not Done'; ?>
                                </button>
                            </form>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <form action="./process/delete.php" method="POST" name="delete_todo" id="delete_todo">
                                <input type="hidden" name="todo_id" value="<?php echo $row['todo_id']; ?>">
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>