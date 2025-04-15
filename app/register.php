<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/styles.css" rel="stylesheet">
    <title>Register</title>
    <link rel="shortcut icon" href="./images/logo.png" type="image/*">
</head>

<body>
    <div class="min-h-screen flex bg-white lg:flex-row flex-col">
        <section class="flex-grow flex items-center justify-center ">
            <div class=" w-full max-w-xl p-4">
                <h1 class="text-center font-bold text-3xl mb-6 text-black">Add User</h1>
                <section class="mb-4 max-w-sm mx-auto">
                    <label>
                        <?php
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == 'missing_inputs') {
                                echo "<p class='text-red-500 text-sm'>Please fill in all fields.</p>";
                            } elseif ($_GET['error'] == 'user_exists') {
                                echo "<p class='text-red-500 text-sm'>User already exists.</p>";
                            } elseif ($_GET['error'] == 'photo_upload_failed') {
                                echo "<p class='text-red-500 text-sm'>Photo upload failed.</p>";
                            } elseif ($_GET['error'] == 'registration_failed') {
                                echo "<p class='text-red-500 text-sm'>Registration failed. Please try again.</p>";
                            }
                        }
                        ?>
                    </label>
                </section>
                <form action="../api/user_registration.php" method="post" enctype="multipart/form-data" class="max-w-sm mx-auto">
                    <section>
                        <label for="fullname" class="text-sm text-black font-semibold">Fullname</label>
                        <div class="w-full p-1">
                            <input type="text" name="fullname" placeholder="Enter Fullname"
                                class="primary-input">
                        </div>
                    </section>
                    <section class="mt-4">
                        <label for="email" class="text-sm text-black font-semibold">Email</label>
                        <div class="w-full p-1 mb-2">
                            <input type="email" name="email" placeholder="Enter Email"
                                class="primary-input">
                        </div>
                    </section>
                    <section class="mt-4">
                        <label for="Phone" class="text-sm text-black font-semibold">Phone</label>
                        <div class="w-full p-1 mb-2">
                            <input type="text" name="phone" placeholder="Enter Phone"
                                class="primary-input">
                        </div>
                    </section>
                    <section class="mt-4">
                        <label for="username" class="text-sm text-black font-semibold">Username</label>
                        <div class="w-full p-1 mb-2">
                            <input type="text" name="username" placeholder="Enter Username"
                                class="primary-input">
                        </div>
                    </section>
                    <section class="mt-4">
                        <label for="Password" class="text-sm text-black font-semibold">Password</label>
                        <div class="w-full p-1 mb-2">
                            <input type="password" name="password" placeholder="Enter Password"
                                class="primary-input">
                        </div>
                    </section>
                    <section class="mt-4">
                        <label for="Photo" class="text-sm text-black font-semibold">Photo</label>
                        <div class="w-full p-1 mb-2">
                            <input type="file" name="photo" class="primary-input" accept="image/*">
                        </div>
                    </section>
                    <section class="mt-4">
                        <button type="submit" class="px-4 py-3 rounded-2xl w-full font-semibold bg-slate-800 text-white">
                            Register
                        </button>
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
                    <p class="text-white">Sign in to your account to start using our services</p>
                </div>
            </aside>
        </section>
    </div>
</body>

</html>