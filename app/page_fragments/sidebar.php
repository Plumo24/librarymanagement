<!-- Sidebar -->
<section class="flex h-screen w-52 bg-slate-800 text-white fixed top-0 left-0">
    <div class="flex flex-col h-full w-full">
        <section class="flex gap-4 items-center justify-center px-4 py-2 w-full bg-gradient-to-tl from-primary to-secondary/70 min-h-10">
            <img src="./images/logo.png" alt="logo" class="w-10 mx-auto">
            <span>
                <h1 class="text-lg font-semibold">Library Mgt. System</h1>
            </span>
        </section>

        <section class="flex flex-col flex-grow w-full overflow-y-auto py-5">
            <ul class="p-2">
                <li>
                    <a id="dashboard_link" href="admin.php" class="font-medium py-2 px-4 text-sm rounded-lg flex items-center gap-2">
                        <i class="fas fa-tachometer-alt"></i> 
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a id="manage_books_link" href="manage_books.php" class="font-medium py-2 px-4 text-sm rounded-lg flex items-center gap-2">
                        <i class="fas fa-book"></i> 
                        <span>Manage Books</span>
                    </a>
                </li>
                <li>
                    <a id="manage_users_link" href="manage_user.php" class="font-medium py-2 px-4 text-sm rounded-lg flex items-center gap-2">
                        <i class="fas fa-users"></i> 
                        <span>Manage Users</span>
                    </a>
                </li>
                <li>
                    <a id="manage_borrowed_books_link" href="manage_borrowed_books.php" class="font-medium py-2 px-4 text-sm rounded-lg flex items-center gap-2">
                        <i class="fas fa-exchange-alt"></i> 
                        <span>Borrowing & Returns</span>
                    </a>
                </li>
            </ul>
        </section>

        <section class="flex items-center justify-center w-full py-3 px-4">
            <a href="../api/logout.php" class="font-medium py-2 px-4 text-sm rounded-lg flex w-full items-center gap-2 active">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </section>
    </div>
</section>