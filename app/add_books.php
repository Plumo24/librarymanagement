<?php
    session_start();
    // Restrict access to this page to logged-in users only
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="./css/styles.css" rel="stylesheet">
    <title>Add Books</title>
</head>

<body class="bg-slate-100">
    <div>
        <?php include_once('page_fragments/sidebar.php'); ?>

        <section class="ml-52">
            <?php include_once('page_fragments/page_header.php'); ?>

            <main class="py-5 px-6">
                <div class="mx-8">
                    <div class="mb-6 pt-6">
                        <a href="manage_books.php"><i class="fa-solid fa-circle-arrow-left text-xl px-5"></i> Back </a>
                    </div>
                    <section class="flex-grow flex items-center justify-center bg-white rounded-lg shadow-lg">
                        <div class=" w-full max-w-xl p-4">
                            <h1 class="text-center font-bold text-3xl mb-6 text-black">Add Books</h1>
                            <section class="mb-4 max-w-sm mx-auto">
                                <label>
                                    <?php
                                    if (isset($_GET['error'])) {
                                        if ($_GET['error'] == 'missing_inputs') {
                                            echo "<p class='text-red-500 text-sm'>Please fill in all fields.</p>";
                                        } elseif ($_GET['error'] == 'book_exists') {
                                            echo "<p class='text-red-500 text-sm'>book already exists.</p>";
                                        } elseif ($_GET['error'] == 'photo_upload_failed') {
                                            echo "<p class='text-red-500 text-sm'>Photo upload failed.</p>";
                                        } elseif ($_GET['error'] == 'registration_failed') {
                                            echo "<p class='text-red-500 text-sm'>Registration failed. Please try again.</p>";
                                        }
                                    }
                                    ?>
                                </label>
                            </section>
                            <form action="../api/add_new_book.php" method="post" enctype="multipart/form-data" class="max-w-sm mx-auto">
                                <section>
                                    <label for="fullname" class="text-sm text-black font-semibold">Title</label>
                                    <div class="w-full p-1">
                                        <input type="text" name="title" placeholder="Enter Title"
                                            class="primary-input">
                                    </div>
                                </section>
                                <section class="mt-4">
                                    <label for="author" class="text-sm text-black font-semibold">Author</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="text" name="author" placeholder="Enter Author"
                                            class="primary-input">
                                    </div>
                                </section>
                                <section class="mt-4">
                                    <label for="Phone" class="text-sm text-black font-semibold">Isbn</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="text" name="isbn" placeholder="Enter Isbn"
                                            class="primary-input">
                                    </div>
                                </section>
                                <section class="mt-4">
                                    <label for="username" class="text-sm text-black font-semibold">Genre</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="text" name="genre" placeholder="Enter Genre"
                                            class="primary-input">
                                    </div>
                                </section>
                                <section class="mt-4">
                                    <label for="Password" class="text-sm text-black font-semibold">Publisher</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="text" name="publisher" placeholder="Enter Publisher"
                                            class="primary-input">
                                    </div>
                                </section>
                                <section class="mt-4">
                                    <label for="role" class="text-sm text-black font-semibold">Published Date</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="date" name="published_date" placeholder="Enter Published Date"
                                            class="primary-input">
                                    </div>
                                </section>
                                <!-- <section class="mt-4">
                                    <label for="role" class="text-sm text-black font-semibold"> Status</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="text" name="status" placeholder="Enter status"
                                            class="primary-input">
                                    </div>
                                </section> -->
                                <section class="mt-4">
                                    <label for="role" class="text-sm text-black font-semibold"> Quantity Available</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="text" name="qty_available" placeholder="Enter Quantity Available"
                                            class="primary-input">
                                    </div>
                                </section>
                                <section class="mt-4">
                                    <label for="role" class="text-sm text-black font-semibold">Total Quantity</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="text" name="total_qty" placeholder="Enter Total Quantity"
                                            class="primary-input">
                                    </div>
                                </section>
                                <section class="mt-4">
                                    <label for="Photo" class="text-sm text-black font-semibold"> Cover Photo</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="file" name="cover_photo" class="primary-input" accept="image/*">
                                    </div>
                                </section>
                                <section class="mt-4">
                                    <button type="submit" class="px-4 py-3 rounded-2xl w-full font-semibold bg-slate-800 text-white cursor-pointer">
                                        Add Book
                                    </button>
                                </section>
                            </form>
                        </div>
                    </section>
                </div>
            </main>
        </section>
    </div>


    <script>
        document.querySelector('#manage_books_link').classList.add('active');
        document.querySelector('#page_title').textContent = "Add Book";
    </script>
</body>

</html>