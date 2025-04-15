<?php
session_start();
include_once('../api/db_connect.php');

if (!isset($_SESSION['user'])) {
    header('Location: login.php?error=unauthorized_access');
    exit;
}

if (!isset($_GET['book_id'])) {
    header('Location: manage_books.php?error=book_not_found');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="./css/styles.css" rel="stylesheet">
    <title>Update Books</title>
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
                            <h1 class="text-center font-bold text-3xl mb-6 text-black">Update Books</h1>
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
                            <?php 
                            $bookId = $_GET['book_id'];
                            $bookQuery = "SELECT * FROM books WHERE id = $bookId";
                            $bookResult = $conn->query($bookQuery);
                            $selectedBook = $bookResult->fetch_assoc();

                            
                            
                            if (!$selectedBook) {
                                header('Location: manage_books.php?error=book_not_found');
                                exit;
                            }
                            ?>
                            <form action="../api/update_book_record.php" method="post" enctype="multipart/form-data" class="max-w-sm mx-auto">
                                <input type="hidden" name="book_id" value="<?php echo $selectedBook['id']; ?>">
                                <section>
                                    <label for="fullname" class="text-sm text-black font-semibold">Title</label>
                                    <div class="w-full p-1">
                                        <input type="text" name="title" value="<?php echo $selectedBook['title']; ?>" placeholder="Enter Title"
                                            class="primary-input">
                                    </div>
                                </section>
                                <section class="mt-4">
                                    <label for="author" class="text-sm text-black font-semibold">Author</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="text" name="author" value="<?php echo $selectedBook['author']; ?>" placeholder="Enter Author"
                                            class="primary-input">
                                    </div>
                                </section>
                                <section class="mt-4">
                                    <label for="Phone" class="text-sm text-black font-semibold">Isbn</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="text" name="isbn" value="<?php echo $selectedBook['isbn']; ?>" placeholder="Enter Isbn"
                                            class="primary-input">
                                    </div>
                                </section>
                                <section class="mt-4">
                                    <label for="username" class="text-sm text-black font-semibold">Genre</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="text" name="genre" value="<?php echo $selectedBook['genre']; ?>" placeholder="Enter Genre"
                                            class="primary-input">
                                    </div>
                                </section>
                                <section class="mt-4">
                                    <label for="Password" class="text-sm text-black font-semibold">Publisher</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="text" name="publisher" value="<?php echo $selectedBook['publisher']; ?>" placeholder="Enter Publisher"
                                            class="primary-input">
                                    </div>
                                </section>
                                <section class="mt-4">
                                    <label for="role" class="text-sm text-black font-semibold">Published Date</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="date" name="published_date" value="<?php echo $selectedBook['published_date']; ?>" placeholder="Enter Published Date"
                                            class="primary-input">
                                    </div>
                                </section>
                                <!-- <section class="mt-4">
                                    <label for="role" class="text-sm text-black font-semibold"> Status</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="text" name="status" value="<?php echo $selectedBook['status']; ?>" placeholder="Enter status"
                                            class="primary-input">
                                    </div>
                                </section> -->
                                <section class="mt-4">
                                    <label for="role" class="text-sm text-black font-semibold"> Quantity Available</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="text" name="qyt_available" value="<?php echo $selectedBook['qty_available']; ?>" placeholder="Enter Quantity Available"
                                            class="primary-input">
                                    </div>
                                </section>
                                <section class="mt-4">
                                    <label for="role" class="text-sm text-black font-semibold">Total Quantity</label>
                                    <div class="w-full p-1 mb-2">
                                        <input type="text" name="total_qty" value="<?php echo $selectedBook['total_qty']; ?>" placeholder="Enter Total Quantity"
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
                                        Update Book
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
        document.querySelector('#page_title').textContent = "Edit Book";
    </script>
</body>

</html>