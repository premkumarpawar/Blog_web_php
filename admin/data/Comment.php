<?php 

// Get All Comments
function getAllComment($conn){
   $sql = "SELECT * FROM comment";
   $stmt = $conn->prepare($sql);
   $stmt->execute();

   if($stmt->rowCount() >= 1){
       return $stmt->fetchAll();
   } else {
       return 0;
   }
}

// Get Comment by ID
function getCommentById($conn, $id){
   $sql = "SELECT * FROM comment WHERE comment_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$id]);

   if($stmt->rowCount() >= 1){
       return $stmt->fetch();
   } else {
       return 0;
   }
}

// Count Comments by Post ID
function CountByPostID($conn, $id){
   $sql = "SELECT * FROM comment WHERE post_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$id]);

   return $stmt->rowCount();
}

// Like Count by Post ID
function likeCountByPostID($conn, $id){
   $sql = "SELECT * FROM post_like WHERE post_id=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$id]);

   return $stmt->rowCount();
}

// Is Liked by User
function isLikedByUserID($conn, $post_id, $user_id){
   $sql = "SELECT * FROM post_like WHERE post_id=? AND liked_by=?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$post_id, $user_id]);

   return $stmt->rowCount() > 0 ? 1 : 0;
}

// Get Comments by Post ID
function getCommentsByPostID($conn, $id){
   $sql = "SELECT * FROM comment WHERE post_id=? ORDER BY comment_id DESC";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$id]);

   if($stmt->rowCount() >= 1){
      return $stmt->fetchAll();
   } else {
      return 0;
   }
}

// Delete Comment by ID
function deleteCommentById($conn, $id){
   $sql = "DELETE FROM comment WHERE comment_id=?";
   $stmt = $conn->prepare($sql);
   return $stmt->execute([$id]) ? 1 : 0;
}

// Delete Comments by Post ID
function deleteCommentByPostId($conn, $id){
   $sql = "DELETE FROM comment WHERE post_id=?";
   $stmt = $conn->prepare($sql);
   return $stmt->execute([$id]) ? 1 : 0;
}

// Delete Likes by Post ID
function deleteLikeByPostId($conn, $id){
   $sql = "DELETE FROM post_like WHERE post_id=?";
   $stmt = $conn->prepare($sql);
   return $stmt->execute([$id]) ? 1 : 0;
}

//  NEW: Get Comments by User ID
function getCommentsByUserID($conn, $user_id){
   $sql = "SELECT * FROM comment WHERE user_id = ? ORDER BY crated_at DESC";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$user_id]);

   if($stmt->rowCount() > 0){
      return $stmt->fetchAll();
   } else {
      return 0;
   }
}
