<?php 
require "../config/connect_db.php";
require "../helpers/view_helper.php";

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../app/login.php');
    exit;
}

$fetchTodos = "SELECT t.*, 
    (SELECT COUNT(*) FROM comments c WHERE c.todo_id = t.id) as comment_count 
    FROM todos t 
    WHERE t.user_id = {$_SESSION['user_id']}
    ORDER BY t.created_at DESC";

$result = mysqli_query($conn, $fetchTodos);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlentities($_POST['title']);
    $description = htmlentities($_POST['description']);
    $user_id = $_SESSION['user_id'];
    
    $sql = "INSERT INTO todos (title, description, user_id) VALUES ('$title', '$description', '$user_id')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

ob_start(); ?>

<main class="bg-white rounded-lg shadow-md p-6 max-w-2xl mx-auto">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="mb-6">
        <div class="flex flex-col gap-4">
            <div>
                <input type="text" name="title" placeholder="Enter your todo title" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <textarea name="description" placeholder="Enter todo description (optional)" rows="3"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"></textarea>
            </div>
            <div>
                <button type="submit"
                    class="w-full bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                    Add Todo
                </button>
            </div>
        </div>
    </form>

    <!-- Todo list display -->
    <?php if (mysqli_num_rows($result) > 0) : ?>
        <ul class="space-y-4">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <li class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($row['title']); ?></h3>
                            <?php if (!empty($row['description'])) : ?>
                                <p class="text-gray-600 mt-1"><?php echo htmlspecialchars($row['description']); ?></p>
                            <?php endif; ?>
                            <div class="mt-2 text-sm text-gray-500">
                                <?php echo date('M j, Y g:i A', strtotime($row['created_at'])); ?>
                            </div>
                        </div>
                        <div class="ml-4">
                            <form action="delete_todo.php" method="POST" class="inline">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="mt-4">
                        <div class="flex items-center gap-2 mb-3">
                            <button onclick="toggleComments(<?php echo $row['id']; ?>)" 
                                class="flex items-center gap-2 text-sm text-gray-600 hover:text-blue-600 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <span class="comment-count"><?php echo $row['comment_count']; ?></span>
                            </button>
                        </div>
                        
                        <div id="comments-<?php echo $row['id']; ?>" class="hidden">
                            <!-- Add Comment Form -->
                            <form action="comment_actions.php" method="POST" class="mb-4">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="todo_id" value="<?php echo $row['id']; ?>">
                                <div class="flex items-center gap-2 bg-gray-50 p-2 rounded-lg">
                                    <input type="text" name="content" placeholder="Write a comment..." required
                                        class="flex-1 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                    <button type="submit" 
                                        class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                    </button>
                                </div>
                            </form>

                            <?php
                            $commentsSql = "SELECT c.*, u.fullname 
                                          FROM comments c 
                                          JOIN users u ON c.user_id = u.id 
                                          WHERE c.todo_id = {$row['id']} 
                                          ORDER BY c.created_at DESC";
                            $commentsResult = mysqli_query($conn, $commentsSql);
                            ?>
                            
                            <div class="space-y-3">
                                <?php while ($comment = mysqli_fetch_assoc($commentsResult)) : ?>
                                    <div class="bg-gray-50 rounded-lg p-3 hover:bg-gray-100 transition-colors duration-200">
                                        <div class="flex justify-between items-start gap-2">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="font-medium text-sm text-gray-900">
                                                        <?php echo htmlspecialchars($comment['fullname']); ?>
                                                    </span>
                                                    <span class="text-xs text-gray-500">
                                                        <?php echo date('M j, Y g:i A', strtotime($comment['created_at'])); ?>
                                                    </span>
                                                </div>
                                                <p class="text-gray-700 text-sm"><?php echo htmlspecialchars($comment['content']); ?></p>
                                            </div>
                                            <?php if ($comment['user_id'] == $_SESSION['user_id']) : ?>
                                                <form action="comment_actions.php" method="POST">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                                    <button type="submit" 
                                                        class="text-gray-400 hover:text-red-500 transition-colors duration-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p class="text-gray-600 text-center">No todos yet. Add one above!</p>
    <?php endif; ?>
</main>

<script>
function toggleComments(todoId) {
    const commentsDiv = document.getElementById(`comments-${todoId}`);
    commentsDiv.classList.toggle('hidden');
}
</script>

<?php 
$content = ob_get_clean();
render_page($content);
?>
