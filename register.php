<?php
require_once 'config/connection.php';

session_start();

if (isset($_SESSION['user'])) {
    header('Location: ./todos.php');
    exit();
}

$msg = '';
$type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($name) || empty($username) || empty($password)) {
        $msg = 'All fields are required';
        $type = 'error';
    } else if (strlen($password) < 8) {
        $msg = 'Password must be at least 8 characters long';
        $type = 'error';
    } else {
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $msg = 'Username already exists';
            $type = 'error';
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);

            $query_input = "INSERT INTO users (name, username, password) VALUES ('$name', '$username', '$password')";
            $result = mysqli_query($conn, $query_input);

            if ($result) {
                $msg = 'User registered successfully';
                $type = 'success';
                header('Location: ./index.php');
            } else {
                $msg = 'Failed to register user';
                $type = 'error';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body class="min-h-screen bg-cover bg-center" style="background-image: url('assets/image/image1.jpg');">
    <div class="flex items-center justify-center min-h-screen">
        <div class="flex flex-col items-center justify-center min-h-screen">
            <h2 class="mb-4 text-center text-3xl font-bold text-black bg-opacity-50 px-6 py-2 rounded-lg">Register To Do List</h2>
            <div class="bg-white bg-opacity-90 p-1 rounded-lg shadow-lg">
                <form class="mx-auto max-w-lg rounded-lg border" action="./register.php" method="post">
                    <div class="flex flex-col gap-4 p-4 md:p-8">
                        <?php if ($msg) : ?>
                            <div class="<?= $type === 'error' ? 'bg-red-100 border-red-400 text-red-700' : 'bg-green-100 border-green-400 text-green-700' ?> border px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">
                                    <?= $type === 'error' ? 'Oops!' : 'Success!' ?>
                                </strong>
                                <span class="block sm:inline"><?= htmlspecialchars($msg) ?></span>
                            </div>
                        <?php endif; ?>

                        <div>
                            <label for="name" class="mb-2 inline-block text-sm text-gray-800 sm:text-base">Name</label>
                            <input name="name" id="name" class="w-full rounded border bg-gray-50 px-3 py-2 text-gray-800 outline-none ring-indigo-300 transition duration-100 focus:ring" required value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" />
                        </div>

                        <div>
                            <label for="username" class="mb-2 inline-block text-sm text-gray-800 sm:text-base">Username</label>
                            <input name="username" id="username" class="w-full rounded border bg-gray-50 px-3 py-2 text-gray-800 outline-none ring-indigo-300 transition duration-100 focus:ring" required value="<?= isset($username) ? htmlspecialchars($username) : '' ?>" />
                        </div>

                        <div>
                            <label for="password" class="mb-2 inline-block text-sm text-gray-800 sm:text-base">Password</label>
                            <input type="password" name="password" id="password" class="w-full rounded border bg-gray-50 px-3 py-2 text-gray-800 outline-none ring-indigo-300 transition duration-100 focus:ring" required />
                        </div>

                        <button type="submit" class="block rounded-lg bg-gray-800 px-8 py-3 text-center text-sm font-semibold text-white outline-none ring-gray-300 transition duration-100 hover:bg-gray-700 focus-visible:ring active:bg-gray-600 md:text-base">Register</button>
                    </div>

                    <div class="flex items-center justify-center bg-gray-100 p-4">
                        <p class="text-center text-sm text-gray-500">Have an account? <a href="./index.php" class="text-indigo-500 transition duration-100 hover:text-indigo-600 active:text-indigo-700">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
</body>

</html>