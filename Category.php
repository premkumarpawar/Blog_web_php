<?php 
session_start();
$logged = false;
if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
    $logged = true;
    $user_id = $_SESSION['user_id'];
}

include_once("db_conn.php");
include_once("admin/data/Post.php");
include_once("admin/data/Comment.php");

$categories = getAllCategories($conn);
$categories5 = get5Categoies($conn); 
$category = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>
    <?php 
      if (isset($_GET['category_id'])){
          $c_id = $_GET['category_id'];
          $category = getCategoryById($conn, $c_id); 
          echo ($category == 0) ? "Blog Category Page" : "Blog | ".$category['category'];
      } else {
          echo "Blog Category Page";
      }
    ?>
  </title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background-color:rgb(149, 136, 231);
      color: #333;
    }

    .main-blog {
      flex: 3;
      margin-right: 20px;
    }

    .main-blog-card {
      border-radius: 15px;
      background-color: #fff;
      box-shadow: 0 5px 18px rgba(0, 0, 0, 0.07);
      border: none;
      overflow: hidden;
      transition: transform 0.2s ease;
    }

    .main-blog-card:hover {
      transform: translateY(-5px);
    }

    .card-title {
      font-size: 22px;
      font-weight: 600;
      color: #2c3e50;
    }

    .card-text {
      font-size: 15px;
      color: #555;
    }

    .btn-primary {
      background-color: #007bff;
      border: none;
      padding: 8px 18px;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .react-btns {
      font-size: 14px;
      color: #333;
    }

    .react-btns i {
      cursor: pointer;
      margin-right: 5px;
      transition: color 0.3s;
    }

    .react-btns i:hover {
      color: #007bff;
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
      box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
      overflow: hidden;
    }

    .category-aside a {
      border: none;
      padding: 12px 18px;
      color: #333;
      font-weight: 500;
    }

    .category-aside a:hover {
      background-color:rgb(186, 225, 156);
      color: #007bff;
    }

    .category-aside a.active {
      background-color: #007bff;
      color: white !important;
    }

    .card-img-top {
      max-height: 300px;
      object-fit: cover;
    }

    .text-body-secondary {
      color: #666 !important;
    }

    @media (max-width: 768px) {
      section.d-flex {
        flex-direction: column;
      }

      .main-blog {
        margin-right: 0;
      }

      .aside-main {
        margin-top: 20px;
      }
    }
  </style>
</head>
<body>

<?php include 'inc/NavBar.php'; ?>

<div class="container mt-5">
  <h1 class="display-4 mb-4 fs-3">
    <?php 
    if ($category != 0)
      echo "Articles about '".$category['category']."'";  
    else 
      echo "Articles"; 
    ?>
  </h1>

  <section class="d-flex">

    <?php if (!isset($_GET['category_id'])) { ?>
      <main class="main-blog p-2">
        <div class="list-group category-aside">
          <?php foreach ($categories as $category) { ?>
            <a href="category.php?category_id=<?= $category['id'] ?>" class="list-group-item list-group-item-action">
              <?= $category['category']; ?>
            </a>
          <?php } ?>
        </div>
      </main>

    <?php } else {
      $cId = $_GET['category_id'];
      $posts = getAllPostsByCategory($conn, $cId);
    ?>

    <?php if ($posts != 0) { ?>
      <main class="main-blog">
        <?php foreach ($posts as $post) { ?>
          <div class="card main-blog-card mb-5">
            <img src="upload/blog/<?= $post['cover_url'] ?>" class="card-img-top" alt="Blog Image">
            <div class="card-body">
              <h5 class="card-title"><?= $post['post_title'] ?></h5>
              <?php 
                $p = strip_tags($post['post_text']); 
                $p = substr($p, 0, 200); 
              ?>
              <p class="card-text"><?= $p ?>...</p>
              <a href="blog-view.php?post_id=<?= $post['post_id'] ?>" class="btn btn-primary">Read more</a>
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
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                  <?php } ?>
                  Likes (<span><?= likeCountByPostID($conn, $post['post_id']) ?></span>)
                  <a href="blog-view.php?post_id=<?= $post['post_id'] ?>#comments">
                    <i class="fa fa-comment" aria-hidden="true"></i> Comments (<?= CountByPostID($conn, $post['post_id']) ?>)
                  </a>
                </div>
                <small class="text-body-secondary"><?= $post['crated_at'] ?></small>
              </div>
            </div>
          </div>
        <?php } ?>
      </main>
    <?php } else { ?>
      <main class="main-blog p-2">
        <div class="alert alert-warning">No posts yet.</div>
      </main>
    <?php } } ?>

    <aside class="aside-main">
      <div class="list-group category-aside">
        <a href="#" class="list-group-item list-group-item-action active">Category</a>
        <?php foreach ($categories5 as $category) { ?>
          <a href="category.php?category_id=<?= $category['id'] ?>" class="list-group-item list-group-item-action">
            <?= $category['category']; ?>
          </a>
        <?php } ?>
      </div>
    </aside>

  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
