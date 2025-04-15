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
    <title>Manage Books</title>
    <link rel="shortcut icon" href="./images/logo.png" type="image/*">

    <?php
    include_once('../api/db_connect.php');

    // Fetch All books from the database
    $usersQuery = "SELECT * FROM books";
    $booksResult = $conn->query($usersQuery);
    $books = $booksResult->fetch_all(MYSQLI_ASSOC);

    if (isset($_POST['search_btn'])) {
        $searchVal = $_POST['search_input'];
        $booksQuery = "SELECT * FROM books WHERE title LIKE '%$searchVal%' OR author LIKE '%$searchVal%' OR genre LIKE '%$searchVal%'";
        $booksResult = $conn->query($booksQuery);
        $books = $booksResult->fetch_all(MYSQLI_ASSOC);
    }

    $conn->close();
    ?>
</head>

<body class="bg-slate-100">
    <div>
        <?php include_once('page_fragments/sidebar.php'); ?>

        <section class="ml-52">
            <?php include_once('page_fragments/page_header.php'); ?>

            <main class="py-5 px-6">
                <div class=" mt-12 mb-8">
                    <form method="post" class="bg-white mb-16 max-w-sm w-full  mx-auto rounded-3xl flex items-center gap-2 border border-transparent focus-within:border-gray-400">
                        <input type="text" name="search_input" id="search_input" placeholder="search user by name, email, registerd day......" class=" w-[95%] py-3 rounded-3xl outline-hidden px-4 placeholder-text-lg" value="<?php echo isset($_POST['search_input']) ? htmlspecialchars($_POST['search_input']) : ''; ?>">
                        <button type="submit" class="px-3" name="search_btn"><i class="fa-solid fa-magnifying-glass  text-xl cursor-pointer"></i></button>
                    </form>
                    <div>
                        <?php
                        if (isset($_GET['success'])) {
                            if ($_GET['success'] == 'update_successful') {
                                echo "<p class='text-green-500 text-sm'>book updated successfully.</p>";
                            } elseif ($_GET['success'] == 'delete_successfull') {
                                echo "<p class='text-green-500 text-sm'>book deleted successfully.</p>";
                            } elseif ($_GET['success'] == 'book_deleted') {
                                echo "<p class='text-red-500 text-sm'>book deleted successfully.</p>";
                            } elseif ($_GET['success'] == 'registration_successful') {
                                echo "<p class='text-green-500 text-sm'>Book added successfully.</p>";
                            }
                        }
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == 'Book_not_found') {
                                echo "<p class='text-red-500 text-sm'>Book not found.</p>";
                            } elseif ($_GET['error'] == 'book_delete_failed') {
                                echo "<p class='text-red-500 text-sm'>Book deletion failed. Please try again.</p>";
                            }
                        }
                        ?>
                    </div>

                    <div class=" flex items-center justify-between mb-3">
                        <h1 class="font-semibold text-lg"> Library Books</h1>
                        <a href="add_books.php" class="bg-primary text-white italic font-semibold block py-1 px-3 rounded-lg">Add Book</a>
                    </div>
                    <div class="lg:overflow-auto overflow-x-scroll">
                        <table class="mx-auto w-full">
                            <thead class="bg-primary text-white text-left">
                                <tr>
                                    <th class="px-3 py-2 min-w-[20%]">Title</th>
                                    <th class="px-3 py-2 min-w-[10%]">Author</th>
                                    <th class="px-3 py-2 min-w-[10%]">ISBN</th>
                                    <th class="px-3 py-2">Genre</th>
                                    <th class="px-3 py-2">Quantity Available</th>
                                    <th class="px-3 py-2">Total Quantity</th>
                                    <th class="px-3 py-2">Published Date</th>
                                    <th class="px-3 py-2">Action</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white text-left text-sm">
                                <?php foreach ($books as $book): ?>
                                    <tr class="border-b border-gray-200">
                                        <td class="px-3 py-2 min-w-[20%] whitespace-nowrap">
                                            <div class="flex items-center justify-start text-left gap-x-2">
                                                <img src="../api/uploads/books/<?php echo $book['cover_photo']; ?>" alt="Book Photo" class="w-9 h-9 bg-primary/50 text-xs">
                                                <span>
                                                    <?php echo $book['title']; ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 min-w-[10%] whitespace-nowrap"><?php echo $book['author']; ?></td>
                                        <td class="px-3 py-2 min-w-[10%] whitespace-nowrap"><?php echo $book['isbn']; ?></td>
                                        <td class="px-3 py-2"><?php echo $book['genre']; ?></td>
                                        <td class="px-3 py-2"><?php echo $book['qty_available']; ?></td>
                                        <td class="px-3 py-2"><?php echo $book['total_qty']; ?></td>
                                        <td class="px-3 py-2"><?php echo $book['published_date']; ?></td>
                                        <td class="px-3 py-2 flex gap-2">
                                            <a href="update_books.php?book_id=<?php echo $book['id']; ?>" class="px-2 py-1 bg-secondary">Edit</a>
                                            <button type="button" class="px-2 py-1 bg-tertiary" onclick="deleteBook(<?php echo $book['id']; ?>)">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </section>
    </div>

    <script>
        document.querySelector('#manage_books_link').classList.add('active');
        document.querySelector('#page_title').textContent = "Manage Books";

        function deleteBook(bookId) {
            if (confirm("Are you sure you want to delete this book? \nKindly note that all records of rentals related to this book will also be deleted.")) {
                window.location.href = '../api/delete_book.php?book_id=' + bookId;
            }
        }
    </script>
</body>

</html>