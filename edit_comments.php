<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include_once("db_conn.php");
include_once("admin/data/Post.php");
include_once("admin/data/Comment.php");

$user_id = $_SESSION['user_id'];
$comments = getCommentsByUserID($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Comments</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #c9d6ff, #e2e2e2);
      font-family: 'Segoe UI', sans-serif;
      padding-bottom: 50px;
    }

    .container {
      margin-top: 60px;
    }

    h3 {
      color: #2c3e50;
      font-weight: 600;
    }

    .comment-box {
      background: #ffffff;
      padding: 20px;
      border-radius: 12px;
      margin-bottom: 20px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      transition: 0.3s ease;
    }

    .comment-box:hover {
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      transform: translateY(-2px);
    }

    .comment-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .comment-header h6 {
      font-size: 1rem;
      color: #34495e;
    }

    .comment-header small {
      color: #888;
    }

    .comment-actions {
      margin-top: 12px;
    }

    .btn-sm {
      padding: 5px 12px;
      font-size: 0.875rem;
    }

    textarea.form-control {
      resize: none;
    }

    .modal-header {
      background-color: #f7f7f7;
    }

    .btn-warning {
      background-color: #f39c12;
      border-color: #e67e22;
      color: white;
    }

    .btn-danger {
      background-color: #e74c3c;
      border-color: #c0392b;
      color: white;
    }

    .btn-primary {
      background-color: #3498db;
      border-color: #2980b9;
    }

    .text-muted {
      color: #7f8c8d !important;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3>My Comments</h3>
    <a href="blog.php" class="btn btn-secondary">← Back to Blog</a>
  </div>

  <?php if ($comments && count($comments) > 0): ?>
    <?php foreach ($comments as $comment): 
      $post = getById($conn, $comment['post_id']);
    ?>
      <div class="comment-box">
        <div class="comment-header">
          <h6>On: <strong><?= htmlspecialchars($post['post_title']) ?></strong></h6>
          <small class="text-muted"><?= htmlspecialchars($comment['edited_at'] ?? $comment['created_at'] ?? '') ?></small>
        </div>
        <p class="mt-2"><?= htmlspecialchars($comment['comment']) ?></p>
        <div class="comment-actions">
          <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $comment['comment_id'] ?>">Edit</button>
          <a href="delete_comments.php?id=<?= $comment['comment_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this comment?')">Delete</a>
        </div>
      </div>

      <!-- Edit Modal -->
      <div class="modal fade" id="editModal<?= $comment['comment_id'] ?>" tabindex="-1">
        <div class="modal-dialog">
          <form action="update_comment.php" method="post" class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Comment</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <textarea name="comment" class="form-control" rows="3" required><?= htmlspecialchars($comment['comment']) ?></textarea>
              <input type="hidden" name="id" value="<?= $comment['comment_id'] ?>">
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" type="submit">Update</button>
            </div>
          </form>
        </div>
      </div>
    <?php endforeach ?>
  <?php else: ?>
    <p class="text-muted">You haven't posted any comments yet.</p>
  <?php endif ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
