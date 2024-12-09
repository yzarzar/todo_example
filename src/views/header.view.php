<header class="bg-white shadow-md fixed top-0 left-0 right-0 z-50">
    <nav class="container mx-auto px-4 py-2 flex justify-between">
        <a href="dashboard.php" class="text-lg font-bold text-gray-800">My Todo List</a>
        <div class="space-x-2">
            <span class="text-sm text-gray-600 mr-4">Welcome, <?php echo $_SESSION['fullname']; ?></span>
            <a href="logout.php" class="text-sm text-red-600 hover:text-red-800">Logout</a>
        </div>
    </nav>
</header>
