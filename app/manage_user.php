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
    <link href="./css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Manage Users</title>
    <?php
    include_once('../api/db_connect.php');

    // Fetch All Users from the database
    $user = unserialize($_SESSION['user']);
    $userId = $user['id'];
    $usersQuery = "SELECT * FROM users WHERE id != $userId";
    $usersResult = $conn->query($usersQuery);
    $users = $usersResult->fetch_all(MYSQLI_ASSOC);

    if (isset($_POST['search_btn'])) {
        $searchVal = $_POST['search_input'];
        $usersQuery = "SELECT * FROM users WHERE id != $userId AND (fullname LIKE '%$searchVal%' OR username LIKE '%$searchVal%' OR email LIKE '%$searchVal%')";
        $usersResult = $conn->query($usersQuery);
        $users = $usersResult->fetch_all(MYSQLI_ASSOC);
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
                <div class="top-20 px-8 w-full">
                    <form method="post" class="bg-white mb-16 max-w-sm w-full  mx-auto rounded-3xl flex items-center gap-2 border border-transparent focus-within:border-gray-400">
                        <input type="text" name="search_input" id="search_input" placeholder="search user by name, email, registerd day......" class=" w-[95%] py-3 rounded-3xl outline-hidden px-4 placeholder-text-lg" value="<?php echo isset($_POST['search_input']) ? htmlspecialchars($_POST['search_input']) : ''; ?>">
                        <button type="submit" class="px-3" name="search_btn"><i class="fa-solid fa-magnifying-glass  text-xl cursor-pointer"></i></button>
                    </form>
                    <div>
                        <?php
                        if (isset($_GET['success'])) {
                            if ($_GET['success'] == 'update_successful') {
                                echo "<p class='text-green-500 text-sm'>User updated successfully.</p>";
                            } elseif ($_GET['success'] == 'delete_successfull') {
                                echo "<p class='text-green-500 text-sm'>User deleted successfully.</p>";
                            } elseif ($_GET['success'] == 'user_deleted') {
                                echo "<p class='text-red-500 text-sm'>User deleted successfully.</p>";
                            }
                        }
                        if (isset($_GET['error'])) {
                            if ($_GET['error'] == 'user_not_found') {
                                echo "<p class='text-red-500 text-sm'>User not found.</p>";
                            } elseif ($_GET['error'] == 'user_delete_failed') {
                                echo "<p class='text-red-500 text-sm'>User deletion failed. Please try again.</p>";
                            }
                        }
                        ?>
                    </div>
                    <div class=" flex items-center justify-between mb-3">
                        <h1 class="font-semibold text-lg">USERS</h1>
                        <a href="add_users.php" class="bg-primary text-white italic font-semibold block py-1 px-3 rounded-lg">Add User</a>
                    </div>
                    <div class="lg:overflow-auto overflow-x-scroll">
                        <table class="mx-auto w-full">
                            <thead class="bg-primary text-white text-left text-sm">
                                <tr>
                                    <th class="px-1 py-2">Fullname</th>
                                    <th class="px-1 py-2">Phone Number</th>
                                    <th class="px-3 py-2">Email</th>
                                    <th class="px-1 py-2">Username</th>
                                    <th class="px-4 py-2">Role</th>
                                    <th class="px-4 py-2">Account Status</th>
                                    <th class="px-1 py-2">Action</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white text-left text-sm">
                                <?php foreach ($users as $user): ?>
                                    <tr class="border-b border-gray-200">
                                        <td class="px-3 py-2 min-w-[20%] whitespace-nowrap">
                                            <div class="flex items-center justify-start text-left gap-x-2">
                                                <img src="../api/uploads/<?php echo $user['photo']; ?>" alt="User Photo" class="w-7 h-7 rounded-full bg-primary/50 text-xs">
                                                <span class="block">
                                                    <?php echo $user['fullname']; ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2 min-w-[10%] whitespace-nowrap"><?php echo $user['phone']; ?></td>
                                        <td class="px-3 py-2 min-w-[10%] whitespace-nowrap"><?php echo $user['email']; ?></td>
                                        <td class="px-3 py-2 min-w-[10%] whitespace-nowrap"><?php echo $user['username']; ?></td>
                                        <td class="px-3 py-2"><?php echo $user['role']; ?></td>
                                        <td class="px-3 py-2"><?php echo $user['status']; ?></td>
                                        <td class="px-3 py-2 flex gap-2">
                                            <a href="update_user.php?user_id=<?php echo $user['id']; ?>" class="px-2 py-1 bg-secondary">Edit</a>
                                            <button type="button" class="px-2 py-1 bg-tertiary" onclick="deleteUser(<?php echo $user['id']; ?>)">Delete</button>
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
        document.querySelector('#manage_users_link').classList.add('active');
        document.querySelector('#page_title').textContent = "Manage Users";

        function deleteUser(user_id) {
            if (confirm('Are you sure you want to delete this record?'))
                window.location.href = '../api/delete_user.php?user_id=' + user_id;
        }
    </script>
</body>

</html>