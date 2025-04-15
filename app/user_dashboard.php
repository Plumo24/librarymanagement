<?php
session_start();
// restrict access to the page if the user is not logged in
if (!isset($_SESSION['user'])) {
    header('Location: ../app/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>User Dashboard</title>
    <?php
    // Fetch books and borrowed books data from the database
    include_once('../api/db_connect.php');

    $booksQuery = "SELECT * FROM books WHERE status = 'available'";
    if (isset($_POST['search_btn'])) {
        $searchVal = $_POST['search_input'];
        $booksQuery .= " AND (title LIKE '%$searchVal%' OR author LIKE '%$searchVal%' OR genre LIKE '%$searchVal%')";
    }
    $booksResult = $conn->query($booksQuery);
    $books = $booksResult->fetch_all(MYSQLI_ASSOC);

    $user = unserialize($_SESSION['user']);
    $userId = $user['id'];
    ?>
</head>

<body>
    <!--Header-->
    <header class=" h-16 w-full fixed px-8 flex items-center top-0 left-0 bg-white z-10">
        <div class=" flex items-center justify-between w-full">
            <div>
                <h1 class="font-semibold lg:text-xl text-lg">WELCOME <SPan>USER</SPan></h1>
            </div>
            <div class=" flex gap-6 items-center">
                <a href="borrowed_books.php" class="font-semibold">BORROWED BOOKS</a>
                <div class=" bg-slate-100 w-10 h-10 text-center rounded-full pt-2">
                    <i class="fa-regular fa-bell text-xl"></i>
                </div>
                <div class="bg-body px-2 py-2 rounded-lg">
                    <a href="../api/logout.php" class="font-semibold">LOGOUT</a>
                </div>
            </div>
        </div>
    </header>

    <!--Main Content-->
    <main class="bg-slate-100 py-5 px-8 relative top-16">
        <!--Search Bar-->
        <form action="" method="post" class="  mx-auto lg:w-[60%] w-full bg-white mb-16  rounded-3xl flex items-center gap-2 border border-transparent focus-within:border-gray-400">
            <input type="text" name="search_input" id="search_input" placeholder="search book by Title, Author, Genre, Availabilty" class=" w-[95%] py-3 rounded-3xl outline-hidden px-4   placeholder-text-lg">
            <button type="submit" name="search_btn"><i class="fa-solid fa-magnifying-glass  text-xl cursor-pointer px-2"></i></button>
        </form>

        <section>
            <?php
            if (isset($_GET['success'])) {
                if (strtolower($_GET['success']) == 'borrow_successful') {
                    echo "<p class='text-green-500 text-sm'>Book borrowed successfully.</p>";
                } elseif (strtolower($_GET['success']) == 'return_successful') {
                    echo "<p class='text-green-500 text-sm'>Book returned successfully.</p>";
                }
            }
            
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 'book_not_found') {
                    echo "<p class='text-red-500 text-sm'>Book not found.</p>";
                } elseif ($_GET['error'] == 'borrow_failed') {
                    echo "<p class='text-red-500 text-sm'>Book borrowing failed. Please try again.</p>";
                } elseif ($_GET['error'] == 'return_failed') {
                    echo "<p class='text-red-500 text-sm'>Book return failed. Please try again.</p>";
                }
            }
            ?>
        </section>

        <!--Book list-->
        <div class="px-5  grid lg:grid-cols-3 grid-cols-1 mb-14">
            <?php foreach ($books as $book): ?>
                <div class="bg-white lg:w-[350px] w-full mb-7 ">
                    <div class=" overflow-hidden">
                        <img src="../api/uploads/books/<?php echo $book['cover_photo']; ?>" alt="" class="w-full">
                    </div>
                    <div class="px-4 py-2">
                        <p class="font-semibold text-lg">Title: <span class="font-normal"><?php echo $book['title']; ?></span></p>
                        <p class="font-semibold text-lg">Author: <span class="font-normal"><?php echo $book['author']; ?></span></p>
                        <p class="font-semibold text-lg">Published: <span class="font-normal"><?php echo $book['published_date']; ?></span></p>
                        <p class="font-semibold text-lg mb-3">Availabilty: <span class="font-normal"><?php echo strtolower($book['status']) == 'available' ? '<i class="fa-solid fa-check text-green-500 "></i>' : '<i class="fa-solid fa-xmark  text-red-500"></i>'; ?></span></p>
                        <div class="mx-auto">
                            <?php
                            // check if the user already borrowed the book
                            $borrowed = false;
                            $userId = $user['id'];
                            $borrowedQuery = "SELECT * FROM rentals WHERE user_id = '$userId' AND book_id = '{$book['id']}'";
                            $borrowedResult = $conn->query($borrowedQuery);
                            if ($borrowedResult->num_rows > 0) {
                                $borrowed = true;
                            }
                            ?>
                            <button onclick="borrowBook(<?php echo $book['id']; ?>)" class="bg-body px-3 py-2 rounded-lg font-semibold <?php echo $borrowed ? 'cursor-not-allowed opacity-50' : ''; ?>" <?php echo $borrowed ? 'disabled' : ''; ?>>
                                <?php echo $borrowed ? ($borrowedResult->fetch_assoc()['status'] == 'Returned'  ? 'Waiting for Acknowledgement' : 'Already Borrowed') : 'Borrow'; ?>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </main>

    <script>
        let borrowBook = (bookId) => {
            // Redirect to the borrow book API endpoint with the book ID as a query parameter
            window.location.href = "../api/borrow_book.php?book_id=" + bookId;
        }
    </script>

</body>

</html>
<?php
    $conn->close();
?>