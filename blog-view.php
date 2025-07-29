<?php 
session_start();
$logged = false;
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    $logged = true;
    $user_id = $_SESSION['user_id'];
}

if (isset($_GET['post_id'])) {

    include_once("admin/data/Post.php");
    include_once("admin/data/Comment.php");
    include_once("db_conn.php");
    $id = $_GET['post_id'];
    $post = getById($conn, $id);
    $comments = getCommentsByPostID($conn, $id);
    $categories = get5Categoies($conn); 

    if ($post == 0) {
        header("Location: blog.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Blog - <?= $post['post_title'] ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    body {
      background:rgb(129, 167, 216);
      font-family: 'Segoe UI', Tahoma, sans-serif;
      color: #333;
    }

    .main-blog {
      flex: 3;
      margin-right: 20px;
    }

    .main-blog-card {
      background: #fff;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .main-blog-card img {
      width: 100%;
      height: auto;
      border-radius: 12px;
      margin-bottom: 20px;
    }

    .card-title {
      font-size: 26px;
      font-weight: 600;
      color: #2c3e50;
    }

    .card-text {
      font-size: 16px;
      color: #444;
      line-height: 1.6;
    }

    .btn-primary {
      background-color: #007bff;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .react-btns i {
      margin-right: 6px;
      cursor: pointer;
    }

    .react-btns .liked {
      color: #007bff;
    }

    .aside-main {
      flex: 1;
    }

    .category-aside {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
      padding: 0;
    }

    .category-aside .list-group-item {
      border: none;
      padding: 12px 18px;
      color: #333;
    }

    .category-aside .list-group-item:hover {
      background-color:rgb(162, 184, 223);
      color:rgb(85, 103, 123);
    }

    .category-aside .active {
      background-color: #007bff;
      color: #fff !important;
    }

    form#comments {
      background-color:rgb(223, 176, 176);
      padding: 15px;
      border-radius: 10px;
      margin-top: 20px;
    }

    .comments .comment {
      background:rgb(218, 195, 195);
      padding: 12px 15px;
      border-radius: 10px;
      margin-bottom: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .comments .comment img {
      border-radius: 50%;
      margin-right: 10px;
    }

    .comments .comment span {
      font-weight: 600;
    }

    @media (max-width: 768px) {
      section.d-flex {
        flex-direction: column;
      }

      .main-blog {
        margin-right: 0;
        margin-bottom: 20px;
      }
    }
  </style>
</head>
<body>

<?php include 'inc/NavBar.php'; ?>

<div class="container mt-5">
  <section class="d-flex">

    <main class="main-blog">
      <div class="card main-blog-card mb-5">
        <img src="upload/blog/<?= $post['cover_url'] ?>" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title"><?= $post['post_title'] ?></h5>
          <p class="card-text"><?= $post['post_text'] ?></p>
          <hr>
          <div class="d-flex justify-content-between">
            <div class="react-btns">
              <?php 
              $post_id = $post['post_id'];
              if ($logged) {
                  $liked = isLikedByUserID($conn, $post_id, $user_id);
                  if ($liked) { ?>
                    <i class="fa fa-thumbs-up liked like-btn" post-id="<?= $post_id ?>" liked="1"></i>
                  <?php } else { ?>
                    <i class="fa fa-thumbs-up like like-btn" post-id="<?= $post_id ?>" liked="0"></i>
                  <?php } 
              } else { ?>
                  <i class="fa fa-thumbs-up"></i>
              <?php } ?>
              Likes (<span><?= likeCountByPostID($conn, $post['post_id']) ?></span>) 
              <i class="fa fa-comment"></i> Comments (<?= CountByPostID($conn, $post['post_id']) ?>)
            </div>
            <small class="text-body-secondary"><?= $post['crated_at'] ?></small>
          </div>

          <!-- Comment Form -->
          <form action="php/comment.php" method="post" id="comments">
            <h5 class="mt-4 text-secondary">Add Comment</h5>
            <?php if(isset($_GET['error'])){ ?>
              <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']); ?></div>
            <?php } ?>
            <?php if(isset($_GET['success'])){ ?>
              <div class="alert alert-success"><?= htmlspecialchars($_GET['success']); ?></div>
            <?php } ?>
            <div class="mb-3">
              <input type="text" class="form-control" name="comment" placeholder="Write a comment..." required>
              <input type="hidden" name="post_id" value="<?= $id ?>">
            </div>
            <button type="submit" class="btn btn-primary">Comment</button>
          </form>

		  

          <!-- Comments -->
          <hr>
          <div class="comments mt-3">
            <?php if ($comments != 0) { 
              foreach ($comments as $comment) {
                $u = getUserByID($conn, $comment['user_id']);
            ?>
              <div class="comment d-flex align-items-start">
                
                <div>
                  <span>@<?= $u['username'] ?></span>
                  <p><?= $comment['comment'] ?></p>
                  <small class="text-body-secondary"><?= $comment['crated_at'] ?></small>
                </div>
              </div>
            <?php }} ?>
          </div>

        </div>
      </div>
    </main>

    <!-- Sidebar -->
    <aside class="aside-main">
      <div class="list-group category-aside">
        <a href="#" class="list-group-item list-group-item-action active">Category</a>
        <?php foreach ($categories as $category) { ?>
          <a href="category.php?category_id=<?= $category['id'] ?>" class="list-group-item list-group-item-action">
            <?= $category['category']; ?>
          </a>
        <?php } ?>
      </div>
    </aside>

  </section>
</div>

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){
    $(".like-btn").click(function(){
      var post_id = $(this).attr('post-id');
      var liked = $(this).attr('liked');

      if (liked == 1) {
        $(this).attr('liked', '0');
        $(this).removeClass('liked');
      } else {
        $(this).attr('liked', '1');
        $(this).addClass('liked');
      }
      $(this).next().load("ajax/like-unlike.php", { post_id: post_id });
    });
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } else {
    header("Location: blog.php");
    exit;
} ?>
