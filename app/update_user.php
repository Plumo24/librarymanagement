<?php
session_start();
include_once('../api/db_connect.php');

if (!isset($_SESSION['user'])) {
    header('Location: login.php?error=unauthorized_access');
    exit;
}

if (!isset($_GET['user_id'])) {
    header('Location: manage_user.php?error=user_not_found');
    exit;
}

$userId = $_GET['user_id'];
$userQuery = "SELECT * FROM users WHERE id = $userId";
$userResult = $conn->query($userQuery);
$selectedUser = $userResult->fetch_assoc();


if (!$selectedUser) {
    header('Location: manage_user.php?error=user_not_found');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link href="./css/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-slate-100">
    <div>
        <?php include_once('page_fragments/sidebar.php'); ?>

        <section class="ml-52">
            <?php include_once('page_fragments/page_header.php'); ?>

            <main class="py-5 px-6">
                <section class="">
                    <?php include_once('page_fragments/page_header.php'); ?>

                    <div class="mt-4 max-w-sm mx-auto">
                        <h1 class="text-lg font-semibold text-center">Update User</h1>

                        <form action="../api/update_user_records.php" method="post" enctype="multipart/form-data" class="mt-4">
                            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">

                            <section class="mt-4">
                                <label for="fullname" class="text-sm text-black font-semibold">Fullname</label>
                                <div class="w-full p-1 mb-2">
                                    <input type="text" name="fullname" id="fullname" class="primary-input" value="<?php echo $selectedUser['fullname']; ?>" required>
                                </div>
                            </section>

                            <section class="mt-4">
                                <label for="email" class="text-sm text-black font-semibold">Email</label>
                                <div class="w-full p-1 mb-2">
                                    <input type="email" name="email" id="email" class="primary-input" value="<?php echo $selectedUser['email']; ?>" required>
                                </div>
                            </section>

                            <section class="mt-4">
                                <label for="phone" class="text-sm text-black font-semibold">Phone Number</label>
                                <div class="w-full p-1 mb-2">
                                    <input type="text" name="phone" id="phone" class="primary-input" value="<?php echo $selectedUser['phone']; ?>">
                                </div>
                            </section>

                            <section class="mt-4">
                                <label for="username" class="text-sm text-black font-semibold">Username</label>
                                <div class="w-full p-1 mb-2">
                                    <input type="text" name="username" id="username" class="primary-input" value="<?php echo $selectedUser['username']; ?>" required>
                                </div>
                            </section>

                            <section class="mt-4">
                                <label for="password" class="text-sm text-black font-semibold">Password</label>
                                <div class="w-full p-1 mb-2">
                                    <input type="password" name="password" id="password" class="primary-input">
                                </div>
                            </section>

                            <section class="mt-4">
                                <label for="role" class="text-sm text-black font-semibold">Role</label>
                                <div class="w-full p-1 mb-2">
                                    <select name="role" class="primary-input">
                                        <option value="" selected disabled>Select Role</option>
                                        <option value="admin" <?php echo $selectedUser['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                        <option value="user" <?php echo $selectedUser['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                                    </select>
                                </div>
                            </section>

                            <section class="mt-4">
                                <label for="status" class="text-sm text-black font-semibold">Status</label>
                                <div class="w-full p-1 mb-2">
                                    <select name="status" class="primary-input">
                                        <option value="" selected disabled>Select Status</option>
                                        <option value="active" <?php echo $selectedUser['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                        <option value="in_review" <?php echo $selectedUser['status'] == 'in_review' ? 'selected' : ''; ?>>In Review</option>
                                        <option value="banned" <?php echo $selectedUser['status'] == 'banned' ? 'selected' : ''; ?>>Banned</option>
                                    </select>
                                </div>
                            </section>

                            <button type="submit" name="update_user" class="bg-primary text-white px-4 py-1 rounded-lg">Update</button>
                        </form>
                    </div>
                </section>
            </main>

</body>

</html>