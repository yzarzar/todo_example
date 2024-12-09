<?php
require "../config/connect_db.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../app/login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        switch ($action) {
            case 'add':
                if (isset($_POST['todo_id']) && isset($_POST['content'])) {
                    $todo_id = mysqli_real_escape_string($conn, $_POST['todo_id']);
                    $content = htmlentities($_POST['content']);
                    $user_id = $_SESSION['user_id'];
                    
                    $sql = "INSERT INTO comments (todo_id, user_id, content) VALUES (?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "iis", $todo_id, $user_id, $content);
                    
                    if (mysqli_stmt_execute($stmt)) {
                        header("Location: dashboard.php");
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                }
                break;
                
            case 'delete':
                if (isset($_POST['comment_id'])) {
                    $comment_id = mysqli_real_escape_string($conn, $_POST['comment_id']);
                    $user_id = $_SESSION['user_id'];
                    
                    // Only allow deletion if the user owns the comment
                    $sql = "DELETE FROM comments WHERE id = ? AND user_id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "ii", $comment_id, $user_id);
                    
                    if (mysqli_stmt_execute($stmt)) {
                        header("Location: dashboard.php");
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                }
                break;
        }
    }
}

header("Location: dashboard.php");
exit;
?>
