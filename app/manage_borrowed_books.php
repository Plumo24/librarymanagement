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
    <title>Manage Borrowed Books</title>
    <link rel="shortcut icon" href="./images/logo.png" type="image/*">

    <?php
    include_once('../api/db_connect.php');

    // Fetch All borrowed books from the database
    $borrowedBooksQuery = "SELECT r.id, r.user_id, r.book_id, r.date_out, r.date_in, r.status, r.return_date, r.issuance_status, b.title, b.cover_photo, u.fullname, u.email, u.phone
                            FROM rentals r
                            INNER JOIN books b ON r.book_id = b.id
                            INNER JOIN users u ON r.user_id = u.id
                            ";
    $borrowedBooksResult = $conn->query($borrowedBooksQuery);
    $borrowedBooks = $borrowedBooksResult->fetch_all(MYSQLI_ASSOC);

    if (isset($_POST['search_btn'])) {
        $searchVal = $_POST['search_input'];
        $borrowedBooksQuery = "SELECT r.id, r.user_id, r.book_id, r.date_out, r.date_in, r.status, r.return_date, r.issuance_status, b.title, b.cover_photo, u.fullname, u.email, u.phone
                                FROM rentals r
                                INNER JOIN books b ON r.book_id = b.id
                                INNER JOIN users u ON r.user_id = u.id
                                 AND b.title LIKE '%$searchVal%' OR u.fullname LIKE '%$searchVal%' OR u.email LIKE '%$searchVal%' OR u.phone LIKE '%$searchVal%'";
        $borrowedBooksResult = $conn->query($borrowedBooksQuery);
        $borrowedBooks = $borrowedBooksResult->fetch_all(MYSQLI_ASSOC);
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
                        <input type="text" name="search_input" id="search_input" placeholder="search user by name, email, phone......" class=" w-[95%] py-3 rounded-3xl outline-hidden px-4 placeholder-text-lg" value="<?php echo isset($_POST['search_input']) ? htmlspecialchars($_POST['search_input']) : ''; ?>">
                        <button type="submit" class="px-3" name="search_btn"><i class="fa-solid fa-magnifying-glass  text-xl cursor-pointer"></i></button>
                    </form>
                    <div>
                        <?php
                        if (isset($_GET['success'])) {
                            if ($_GET['success'] == 'update_successful') {
                                echo "<p class='text-green-500 text-sm'>Book updated successfully.</p>";
                            } elseif ($_GET['success'] == 'delete_successfull') {
                                echo "<p class='text-green-500 text-sm'>Book deleted successfully.</p>";
                            } elseif ($_GET['success'] == 'book_deleted') {
                                echo "<p class='text-red-500 text-sm'>Book deleted successfully.</p>";
                            } elseif ($_GET['success'] == 'rental_acknowledged') {
                                echo "<p class='text-green-500 text-sm'>Book rental acknowledged successfully.</p>";
                            } elseif ($_GET['success'] == 'rental_returned') {
                                echo "<p class='text-green-500 text-sm'>Book rental returned successfully.</p>";
                            }
                        }
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == 'Book_not_found') {
                                echo "<p class='text-red-500 text-sm'>Book not found.</p>";
                            } elseif ($_GET['error'] == 'book_delete_failed') {
                                echo "<p class='text-red-500 text-sm'>Book deletion failed. Please try again.</p>";
                            } elseif ($_GET['error'] == 'rental_acknowledged_failed') {
                                echo "<p class='text-red-500 text-sm'>Book rental acknowledgement failed. Please try again.</p>";
                            } elseif ($_GET['error'] == 'rental_returned_failed') {
                                echo "<p class='text-red-500 text-sm'>Book rental return failed. Please try again.</p>";
                            }
                        }
                        ?>
                    </div>

                    <div class=" flex items-center justify-between mb-3">
                        <h1 class="font-semibold text-lg"> Manage Borrowed Books</h1>
                    </div>
                    <div class="lg:overflow-auto overflow-x-scroll">
                        <table class="mx-auto w-full">
                            <thead class="bg-primary text-white text-left">
                                <tr>
                                    <th class="px-3 py-2 min-w-[20%]">Book</th>
                                    <th class="px-3 py-2 min-w-[15%]">User</th>
                                    <th class="px-3 py-2 min-w-[15%]">Date Out</th>
                                    <th class="px-3 py-2 min-w-[15%]">Date In</th>
                                    <th class="px-3 py-2 min-w-[15%]">Return Date</th>
                                    <th class="px-3 py-2 min-w-[10%]">Status</th>
                                    <th class="px-3 py-2 min-w-[10%]">Issuance Status</th>
                                    <th class="px-3 py-2 min-w-[10%]">Action</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white text-left text-sm">
                                <?php foreach ($borrowedBooks as $borrowedBook): ?>
                                    <tr class="border-b border-gray-200">
                                        <td class="px-3 py-2 min-w-[20%] whitespace-nowrap">
                                            <div class="flex items-center justify-start text-left gap-x-2">
                                                <img src="../api/uploads/books/<?php echo $borrowedBook['cover_photo']; ?>" alt="Book Photo" class="w-9 h-9 bg-primary/50 text-xs">
                                                <span>
                                                    <?php echo $borrowedBook['title']; ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 min-w-[15%] whitespace-nowrap"><?php echo $borrowedBook['fullname']; ?></td>
                                        <td class="px-3 py-2 min-w-[15%] whitespace-nowrap"><?php echo $borrowedBook['date_out'] ?? ' - '; ?></td>
                                        <td class="px-3 py-2 min-w-[15%] whitespace-nowrap"><?php echo $borrowedBook['date_in'] ?? ' - '; ?></td>
                                        <td class="px-3 py-2 min-w-[15%] whitespace-nowrap"><?php echo $borrowedBook['return_date']; ?></td>
                                        <td class="px-3 py-2 min-w-[10%] whitespace-nowrap">
                                            <span class="text-sm font-semibold <?php echo strtolower($borrowedBook['status']) == 'borrowed' ? 'text-green-500' : (strtolower($borrowedBook['status']) == 'cancelled' ? 'text-red-500' : 'text-gray-500'); ?>">
                                                <?php echo $borrowedBook['status']; ?>
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 min-w-[10%] whitespace-nowrap">
                                            <span class="text-sm font-semibold <?php echo (strtolower($borrowedBook['issuance_status']) == 'approved' || strtolower($borrowedBook['issuance_status']) == 'returned') ? 'text-green-500' : 'text-red-500'; ?>">
                                                <?php echo $borrowedBook['issuance_status']; ?>
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 min-w-[10%] whitespace-nowrap">
                                            <div class="flex gap-2">
                                                <button type="button" class="px-2 py-1 bg-secondary <?php echo (strtolower($borrowedBook['issuance_status']) == 'approved' || strtolower($borrowedBook['issuance_status']) == 'returned') ? 'hidden' : ''; ?>" onclick="acknowledgeRental(<?php echo $borrowedBook['id']; ?>)">Acknowledge</button>
                                                <button type="button" class="px-2 py-1 <?php echo (strtolower($borrowedBook['issuance_status']) == 'approved' || strtolower($borrowedBook['issuance_status']) == 'returned') ? 'border border-primary text-primary' : 'bg-tertiary'; ?>" onclick="returnBook(<?php echo $borrowedBook['id']; ?>)" <?php echo ((strtolower($borrowedBook['issuance_status']) == 'approved' || strtolower($borrowedBook['issuance_status']) == 'returned') && strtolower($borrowedBook['issuance_status']) == 'returned') ? 'disabled' : ''; ?>>
                                                    <?php echo (strtolower($borrowedBook['issuance_status']) == 'approved' && strtolower($borrowedBook['issuance_status']) == 'returned') ? 'Returned' : 'Return'; ?>
                                                </button>
                                            </div>
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
        document.querySelector('#manage_borrowed_books_link').classList.add('active');
        document.querySelector('#page_title').textContent = "Manage Borrowed Books";

        function acknowledgeRental(rentalId) {
            if (confirm("Are you sure you want to acknowledge this rental? \nKindly make sure the book have been issued to the user before acknowledging.")) {
                window.location.href = '../api/acknowledge_rental.php?rental_id=' + rentalId;
            }
        }

        function returnBook(rentalId) {
            if (confirm("Are you sure you want to return this book? \nKindly make sure the book have been returned by the user before confirming.")) {
                window.location.href = '../api/confirm_return_book.php?rental_id=' + rentalId;
            }
        }
    </script>
</body>

</html>
