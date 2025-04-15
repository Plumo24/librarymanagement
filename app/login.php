<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/styles.css" rel="stylesheet">
    <title>Login</title>
    <link rel="shortcut icon" href="./images/logo.png" type="image/*">
</head>

<body>
    <div class="min-h-screen flex bg-white lg:flex-row flex-col">
        <section class="flex-grow flex items-center justify-center">
            <div class=" w-full max-w-xl p-4">
                <h1 class="text-center font-bold text-3xl mb-6 text-black">Login Here</h1>
                <section class="mb-4 max-w-sm mx-auto">
                    <label>
                        <?php
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == 'invalid_credentials') {
                                echo "<p class='text-red-500 text-sm'>Invalid username or password.</p>";
                            } elseif ($_GET['error'] == 'role_missmatch') {
                                echo "<p class='text-red-500 text-sm'>Role mismatch. Please select the correct role.</p>";
                            }
                        }

                        if (isset($_GET['success'])) {
                            if ($_GET['success'] == 'registration_successful') {
                                echo "<p class='text-green-500 text-sm'>Registration successful. You can now login.</p>";
                            }
                        }
                        ?>
                    </label>
                </section>
                <form action="../api/user_login.php" method="post" class="max-w-sm mx-auto">
                    <section>
                        <label for="username" class="text-sm text-black font-semibold">Username</label>
                        <div class="w-full p-1">
                            <input type="text" name="username" placeholder="Enter Username"
                                class="primary-input">
                        </div>
                    </section>
                    <section class="mt-4">
                        <label for="password" class="text-sm text-black font-semibold">Password</label>
                        <div class="w-full p-1 mb-2">
                            <input type="password" name="password" placeholder="Enter Password"
                                class="primary-input">
                        </div>
                    </section>
                    <section class="mt-4">
                        <label for="password" class="text-sm text-black font-semibold">Role</label>
                        <div class="w-full p-1 mb-4">
                            <select name="role" id="" class="primary-input">
                                <option value="">Select Role</option>
                                <option value="admin" class="text-black">Admin</option>
                                <option value="user" class="text-black">User</option>
                            </select>
                        </div>
                    </section>
                    <div class="mb-5 text-right">
                        <a href="" class="text-blue-600 text-sm hover:underline font-semibold">Forgot Password?</a>
                    </div>
                    <section class="mt-4">
                        <button class="px-4 py-3 rounded-2xl w-full font-semibold bg-slate-800 text-white">
                            Login
                        </button>
                    </section>
                    <section class="mt-4">
                        <p class="text-center text-sm">Don't have an account? <a href="register.php"
                                class="text-blue-600 hover:underline font-semibold">Register</a></p>
                    </section>
                </form>
            </div>
        </section>

        <section class="flex-grow max-w-sm relative bg-[url('../images/rgu_library_image.jpg')]">
            <div class="bg-gradient-to-br from-primary/70 to-black/70 absolute top-0 left-0 w-full h-full z-10"></div>
            <aside class="h-full w-full flex items-center justify-center relative z-20">
                <div>
                    <img src="./images/logo.png" alt="logo" class="w-20 mx-auto">
                    <h1 class="text-3xl font-bold text-white mb-2">Welcome to RGU Library</h1>
                    <p class="text-white">Sign in to your account and explore our services</p>
                </div>
            </aside>
        </section>
    </div>
</body>

</html>