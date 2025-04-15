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
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" href="./images/logo.png" type="image/*">
    <?php
        include_once('../api/db_connect.php');

        // Fetch Dashboard data from the database
        $totalBooksQuery = "SELECT COUNT(*) as total_books FROM books";
        $totalUsersQuery = "SELECT COUNT(*) as total_users FROM users";
        $totalBorrowedBooksQuery = "SELECT COUNT(*) as total_borrowed_books FROM rentals";
        // Fetch top 5 users in the system
        $user = unserialize($_SESSION['user']);
        $userId = $user['id'];
        $topUsersQuery = "SELECT * FROM users WHERE id != $userId ORDER BY id DESC LIMIT 5";
        $topUsersResult = $conn->query($topUsersQuery);

        $totalBooksResult = $conn->query($totalBooksQuery);
        $totalUsersResult = $conn->query($totalUsersQuery);
        $totalBorrowedBooksResult = $conn->query($totalBorrowedBooksQuery);

        $totalBooks = $totalBooksResult->fetch_assoc()['total_books'];
        $totalUsers = $totalUsersResult->fetch_assoc()['total_users'];
        $totalBorrowedBooks = $totalBorrowedBooksResult->fetch_assoc()['total_borrowed_books'];
        $topUsers = $topUsersResult->fetch_all(MYSQLI_ASSOC);
        $conn->close();
    ?>
</head>

<body class="bg-slate-100">
    <div>
        <?php include_once('page_fragments/sidebar.php'); ?>

        <section class="ml-52">
            <?php include_once('page_fragments/page_header.php'); ?>

            <main class="py-5 px-6">
                <section>
                    <div class="grid lg:grid-cols-3 grid-cols-1 gap-5">
                        <div class="bg-primary px-4 py-4 rounded-lg ">
                            <h1 class="text-lg font-semibold text-white">Total Books Availabe</h1>
                            <p class="font-bold text-5xl"><?php echo $totalBooks; ?></p>
                            <small>
                                <a href="manage_books.php" class="text-white italic font-semibold underline">Manage Books</a>
                            </small>
                        </div>
                        <div class="bg-secondary p-4 rounded-lg">
                            <h1 class="text-lg font-semibold text-white">Total Registered Users</h1>
                            <p class="font-bold text-5xl"><?php echo $totalUsers; ?></p>
                            <small>
                                <a href="manage_user.php" class="text-white italic font-semibold underline">Manage Library Users</a>
                            </small>
                        </div>
                        <div class="bg-body p-4 rounded-lg">
                            <h1 class="text-lg font-semibold text-blue-950">Total Borowed Books</h1>
                            <p class="font-bold text-5xl"><?php echo $totalBorrowedBooks; ?></p>
                            <small>
                                <a href="" class="text-blue-800 italic font-semibold underline">See Borrowed Books</a>
                            </small>
                        </div>
                    </div>
                </section>

                <section class="mt-12">
                    <div class="relative">
                        <div class="flex justify-between items-center">
                            <h1 class="text-lg font-semibold">Library Users</h1>
                            <a href="manage_user.php" class="text-blue-800 italic font-semibold underline text-sm"> View & Manage Users</a>
                        </div>
                        <div class="lg:overflow-auto overflow-x-scroll py-3">
                            <table class="mx-auto w-full">
                                <thead class="bg-primary text-white text-left">
                                    <tr>
                                        <th class="px-4 py-2">Photo</th>
                                        <th class="px-4 py-2">Fullname</th>
                                        <th class="px-4 py-2">Email</th>
                                        <th class="px-4 py-2">Phone</th>
                                        <th class="px-4 py-2">Username</th>
                                        <th class="px-4 py-2">Role</th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white">
                                    <?php foreach ($topUsers as $user): ?>
                                        <tr class="border-b border-gray-200">
                                            <td class="px-4 py-2 text-center text-xs">
                                                <img src="../api/uploads/<?php echo $user['photo']; ?>" alt="User Photo" class="w-10 h-10 rounded-full bg-primary/50 mx-auto text-xs">
                                            </td>
                                            <td class="px-4 py-2"><?php echo $user['fullname']; ?></td>
                                            <td class="px-4 py-2"><?php echo $user['email']; ?></td>
                                            <td class="px-4 py-2"><?php echo $user['phone']; ?></td>
                                            <td class="px-4 py-2"><?php echo $user['username']; ?></td>
                                            <td class="px-4 py-2"><?php echo $user['role']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </main>
        </section>
    </div>

    <script>
        document.querySelector('#dashboard_link').classList.add('active');
        document.querySelector('#page_title').textContent = "Admin Dashboard";
    </script>
</body>

</html>