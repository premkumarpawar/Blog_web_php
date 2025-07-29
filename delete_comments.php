<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: edit_comments.php?error=unauthorized");
    exit;
}

$user_id = $_SESSION['user_id'];
$comment_id = $_GET['id'];

include_once("db_conn.php");

try {
    // Check if the comment belongs to the logged-in user
    $stmt = $conn->prepare("SELECT * FROM comments WHERE comment_id = :id AND user_id = :uid");
    $stmt->execute(['id' => $comment_id, 'uid' => $user_id]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($comment) {
        // Delete the comment
        $delete = $conn->prepare("DELETE FROM comments WHERE comment_id = :id");
        $delete->execute(['id' => $comment_id]);

        header("Location: edit_comments.php?success=deleted");
        exit;
    } else {
        header("Location: edit_comments.php?error=unauthorized_comment");
        exit;
    }
} catch (PDOException $e) {
    header("Location: edit_comments.php?error=server_error");
    exit;
}
