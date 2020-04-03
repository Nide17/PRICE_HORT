<?php
//DB
include('includes/dbvariables.php');

//initialize post variable to be used in edit fields
$pID = "";
$pCreator = "";
$pTime = "";
$Ptitle = "";
$pContent = "";
$id = 0;

$edit_state = false;

// if save post button is clicked (new post)! "Avoid using ' and " in the post content
if (isset ($_POST['createpost'])) {

	session_start();

    $pCreator = $_SESSION['role'];
    $Ptitle = $conn->real_escape_string($_POST['PTitle']);
    $pContent = $conn->real_escape_string($_POST['Content']);

    $sqlSavePost = "INSERT INTO posts (postCreator, postTime, title, content) 
    VALUES ('$pCreator', NOW(), '$Ptitle', '$pContent')";
     
if ($conn->query($sqlSavePost) === TRUE) {
    $_SESSION['postAdded'] = "New post created!";
    header ('location: posts.php');
} else {
    echo $_SESSION['msg'] = "Error occured. $sqlSavePost .$conn->error";
}

}
 
// if update post button is clicked (update post)!
// UPDATE DATA IN THE DB
if (isset($_POST['correctpost'])) {
    session_start();

    $Ptitle = mysqli_real_escape_string($conn, $_POST['PTitle']);
    $pContent = mysqli_real_escape_string($conn,$_POST['Content']);
    
    $id = mysqli_real_escape_string($conn, $_POST['postId']);
    $sqlUpdatePost = "UPDATE posts SET postTime = NOW(), title = '$Ptitle', content = '$pContent' WHERE postID = $id";
    
if ($conn->query($sqlUpdatePost) === TRUE) {
    $_SESSION['postAdded'] = "Post updated successfully!";
    header ('location: posts.php');
} else {
    echo $_SESSION['msg'] = "Error updating post:" .$conn->error;
}

}

//Delete post records
if (isset($_GET['del'])) {
    session_start();
    
    $id = $_GET['del'];
    $sqlDeletePost = "DELETE FROM posts WHERE postID=$id";
    
    if ($conn->query($sqlDeletePost) === TRUE) {
        $_SESSION['postDel'] = "Post deleted!";
    header ('location: posts.php');
    } else {
        echo $_SESSION['msg'] = "Error deleting post:" .$conn->error;
    }
    
}

$conn->close();
