<?php
$user = unserialize($_SESSION['user']) ?? null;
?>
<header class="bg-gradient-to-br from-primary to-secondary min-h-10 px-6 sticky top-0 z-10">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <aside class="py-2 font-semibold text-xl text-white">
            <span id="page_title">Dashboard</span>
        </aside>

        <aside>
            <div class="flex items-center gap-2">
                <div class="text-slate-100 w-7 h-7 text-center rounded-full flex items-center justify-center">
                    <i class="fa-regular fa-bell text-lg"></i>
                </div>
                <div class="text-slate-100 text-sm font-semibold ml-3 capitalize">
                    <span>
                        <?php
                        if ($user) {
                            echo $user['username'] ?? 'User';
                        } else {
                            echo 'Guest';
                        }
                        ?>
                    </span>
                </div>
                <div class="bg-slate-100 w-9 h-9 text-center rounded-full flex items-center justify-center">
                    <?php
                    if ($user) {
                        $photo = $user['photo'] ?? 'default.webp';
                        echo '<img src="../api/uploads/' . $photo . '" alt="User Photo" class="w-8 h-8 rounded-full">';
                    } else {
                        echo '<img src="../api/uploads/default.webp" alt="User Photo" class="w-8 h-8 rounded-full">';
                    }
                    ?>
                </div>
            </div>
        </aside>
    </div>
</header>