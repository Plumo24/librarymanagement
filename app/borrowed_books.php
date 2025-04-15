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
    <title>Borrowed Books</title>
    <?php
    // Fetch books and borrowed books data from the database
    include_once('../api/db_connect.php');

    $user = unserialize($_SESSION['user']);
    $userId = $user['id'];

    $borrowedQuery = "SELECT * FROM rentals WHERE user_id = '$userId' AND status = 'Borrowed'";
    $borrowedResult = $conn->query($borrowedQuery);
    $borrowedBooks = $borrowedResult->fetch_all(MYSQLI_ASSOC);
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
                <a href="user_dashboard.php" class="font-semibold">DASHBOARD</a>
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

        <?php
        if (isset($_GET['success'])) {
            if ($_GET['success'] == 'return_successful') {
                echo "<p class='text-green-500 text-sm'>Book returned successfully.</p>";
            } elseif ($_GET['success'] == 'request_cancelled') {
                echo "<p class='text-green-500 text-sm'>Request cancelled successfully.</p>";
            }
        }

        if (isset($_GET['error'])) {
            if ($_GET['error'] == 'return_failed') {
                echo "<p class='text-red-500 text-sm'>Failed to return the book.</p>";
            } elseif ($_GET['error'] == 'cancel_failed') {
                echo "<p class='text-red-500 text-sm'>Failed to cancel the request.</p>";
            }
        }
        ?>

        <!--Book list-->
        <div class="px-5  grid lg:grid-cols-3 grid-cols-1 mb-14">
            <?php if (count($borrowedBooks) == 0): ?>
                <p class="text-center mt-10 text-2xl font-semibold">No book borrowed by you yet</p>
                <?php else:
                foreach ($borrowedBooks as $book): ?>
                    <div class="bg-white lg:w-[350px] w-full mb-7 ">
                        <div class=" overflow-hidden">
                            <?php
                            $bookId = $book['book_id'];
                            $bookQuery = "SELECT cover_photo, title, author FROM books WHERE id = '$bookId'";
                            $bookResult = $conn->query($bookQuery);
                            $bookData = $bookResult->fetch_assoc();
                            ?>
                            <img src="../api/uploads/books/<?php echo $bookData['cover_photo']; ?>" alt="" class="w-full">
                        </div>
                        <div class="px-4 py-2">
                            <h1 class="text-lg font-semibold"><?php echo $bookData['title']; ?></h1>
                            <p class="font-semibold text-lg">Author: <span class="font-normal"><?php echo $bookData['author']; ?></span></p>
                            <p class="font-semibold text-lg">Borrowed on: <span class="font-normal"><?php echo $book['date_out']; ?></span></p>
                            <p class="font-semibold text-lg">Due date: <span class="font-normal"><?php echo $book['return_date']; ?></span></p>
                            <p class="font-semibold text-lg mb-3">Insuance Status: <span class="font-normal"><?php echo $book['issuance_status']; ?></span></p>
                            <?php if ($book['issuance_status'] == 'Approved'): ?>
                                <div class="mx-auto">
                                    <button class="bg-body px-3 py-2 rounded-lg font-semibold" onclick="returnBook(<?php echo $bookId; ?>)">Return Book</button>
                                </div>
                            <?php else: ?>
                                <div class="bg-red-500 text-white text-center py-2 rounded-lg font-semibold mb-2">
                                    <p>Book is yet to be released</p>
                                </div>
                                <div class="mx-auto">
                                    <button class="bg-body px-3 py-2 rounded-lg font-semibold" onclick="cancelRequest(<?php echo $bookId; ?>)">Cancel Request</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
            <?php endforeach;
            endif; ?>
        </div>

    </main>

    <script>
        function returnBook(bookId) {
            if (confirm("Are you sure you want to return the book?")) {
                window.location.href = "../api/return_book.php?book_id=" + bookId;
            }
        }

        function cancelRequest(bookId) {
            if (confirm("Are you sure you want to cancel the request?")) {
                window.location.href = "../api/cancel_request.php?book_id=" + bookId;
            }
        }
    </script>

</body>

</html>
<?php
$conn->close();
?>