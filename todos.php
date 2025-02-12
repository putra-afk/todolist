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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //
}

// [PUT] Form process to update new todo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //
}

// [DELETE] Form process to update new todo
function delete_todo($conn, $id)
{
    $id = ''; // perlu sesuaikan lagi
    $query_check = "SELECT * FROM todos WHERE id = $id";
    $result_check = mysqli_query($conn, $query_check);

    if (mysqli_num_rows($result_check)) {
        $query_delete = "DELETE FROM todos WHERE id = $id";
        $result_delete = mysqli_query($conn, $query_delete);

        if ($result_delete) {
            // logika jika berhasil

        } else {
            // logika jika gagal
        }
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

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</body>

</html>