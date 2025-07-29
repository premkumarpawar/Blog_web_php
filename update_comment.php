<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_POST['id']) || !isset($_POST['comment'])) {
    header("Location: edit_comments.php?error=unauthorized");
    exit;
}

$user_id = $_SESSION['user_id'];
$comment_id = $_POST['id'];
$comment_text = trim($_POST['comment']);

include_once("db_conn.php");

try {
    // Check ownership
    $stmt = $conn->prepare("SELECT * FROM comments WHERE comment_id = :id AND user_id = :uid");
    $stmt->execute(['id' => $comment_id, 'uid' => $user_id]);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($comment) {
        // Update comment
        $update = $conn->prepare("UPDATE comments SET comment = :comment, edited_at = NOW() WHERE comment_id = :id");
        $update->execute([
            'comment' => $comment_text,
            'id' => $comment_id
        ]);
        header("Location: edit_comments.php?success=updated");
        exit;
    } else {
        header("Location: edit_comments.php?error=unauthorized_comment");
        exit;
    }

} catch (PDOException $e) {
    header("Location: edit_comments.php?error=server_error");
    exit;
}
