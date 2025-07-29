<?php 
session_start();
$logged = false;
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    $logged = true;
    $user_id = $_SESSION['user_id'];
}
$notFound = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    <?php 
    if (isset($_GET['search'])) {
        echo "Search '".htmlspecialchars($_GET['search'])."'"; 
    } else {
        echo "Blog Page";
    } ?>
  </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color:rgb(140, 209, 232);
      color: #2d2d2d;
    }
    .main-blog {
      flex: 3;
      margin-right: 20px;
    }
    .aside-main {
      flex: 1;
    }
    .main-blog-card {
      border-radius: 15px;
      background-color:rgb(183, 206, 230);
      box-shadow: 0 5px 20px rgba(0,0,0,0.06);
      border: none;
      overflow: hidden;
    }
    .card-title {
      font-size: 22px;
      font-weight: 600;
      color: #333;
    }
    .card-text {
      color: #555;
      font-size: 15px;
    }
    .btn-primary {
      background-color: #0066cc;
      border: none;
      font-weight: 500;
    }
    .btn-primary:hover {
      background-color: #004c99;
    }
    .react-btns {
      color: #333;
      font-size: 15px;
    }
    .react-btns i {
      cursor: pointer;
      margin-right: 5px;
      transition: 0.3s;
    }
    .react-btns i:hover {
      color: #0066cc;
    }
    .react-btns .liked {
      color: #0066cc;
    }
    .category-aside .list-group-item.active {
      background-color: #0066cc;
      color: white;
      border: none;
    }
    .category-aside .list-group-item {
      border: none;
      color: #333;
      font-weight: 500;
    }
    .category-aside .list-group-item:hover {
      background-color:rgb(215, 193, 230);
      color:rgb(159, 184, 209);
    }
    small.text-body-secondary {
      color: #666 !important;
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
    .card-img-top {
      max-height: 280px;
      object-fit: cover;
    }
    .alert-warning {
      background-color:rgb(161, 137, 57);
      color:rgb(207, 196, 163);
      border: 1px solid rgb(186, 230, 255);
    }
  </style>
</head>
<body>

<?php 
  include 'inc/NavBar.php';
  include_once("admin/data/Post.php");
  include_once("admin/data/Comment.php");
  include_once("db_conn.php");

  if (isset($_GET['search'])) {
    $key = $_GET['search'];
    $posts = serach($conn, $key);
    if ($posts == 0) {
      $notFound = 1;
    }
  } else {
    $posts = getAll($conn);
  }
  $categories = get5Categoies($conn); 
?>

<div class="container mt-5">
  <section class="d-flex">

    <?php if ($posts != 0) { ?>
    <main class="main-blog">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fs-3 m-0">
          <?php if (isset($_GET['search'])) { echo "Search <b>'".htmlspecialchars($_GET['search'])."'</b>"; } ?>
          <?php if (!isset($_GET['search'])) { echo "All Blog Posts"; } ?>
        </h1>
        <?php if ($logged) { ?>

        <?php } ?>
      </div>

      <?php foreach ($posts as $post) { ?>
      <div class="card main-blog-card mb-5">
        <img src="upload/blog/<?=$post['cover_url']?>" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title"><?=$post['post_title']?></h5>
          <?php 
            $p = strip_tags($post['post_text']); 
            $p = substr($p, 0, 200);               
          ?>
          <p class="card-text"><?=$p?>...</p>
          <a href="blog-view.php?post_id=<?=$post['post_id']?>" class="btn btn-primary">Read more</a>
          <hr>
          <div class="d-flex justify-content-between">
            <div class="react-btns">
              <?php 
              $post_id = $post['post_id'];
              if ($logged) {
                $liked = isLikedByUserID($conn, $post_id, $user_id);
                if ($liked) {
              ?>
                <i class="fa fa-thumbs-up liked like-btn" post-id="<?=$post_id?>" liked="1" aria-hidden="true"></i>
              <?php } else { ?>
                <i class="fa fa-thumbs-up like like-btn" post-id="<?=$post_id?>" liked="0" aria-hidden="true"></i>
              <?php } 
              } else { ?>
                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
              <?php } ?>
              Likes (<span><?= likeCountByPostID($conn, $post_id); ?></span>)
              <a href="blog-view.php?post_id=<?=$post['post_id']?>#comments">    
                <i class="fa fa-comment" aria-hidden="true"></i> Comments (<?= CountByPostID($conn, $post['post_id']); ?>)
              </a>  
            </div>  
            <small class="text-body-secondary"><?=$post['crated_at']?></small>
          </div>
        </div>
      </div>
      <?php } ?>
    </main>
    <?php } else { ?>
    <main class="main-blog p-2">
      <?php if ($notFound) { ?>
      <div class="alert alert-warning"> 
        No search results found - <b>'<?= htmlspecialchars($_GET['search']) ?>'</b>
      </div>
      <?php } else { ?>
      <div class="alert alert-warning">No posts yet.</div>
      <?php } ?>
    </main>
    <?php } ?>

    <aside class="aside-main">
      <div class="list-group category-aside">
        <a href="#" class="list-group-item list-group-item-action active">Category</a>
        <?php foreach ($categories as $category) { ?>
        <a href="category.php?category_id=<?=$category['id']?>" class="list-group-item list-group-item-action">
          <?= $category['category']; ?>
        </a>
        <?php } ?>
      </div>
    </aside>

  </section>
</div>

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

      $(this).next().load("ajax/like-unlike.php", {
        post_id: post_id
      });
    });
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
