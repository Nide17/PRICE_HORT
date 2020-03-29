<?php
require_once('dbposts.php');
require_once('server.php');


if (!isset($_SESSION['role'])) {
    header("location: logout.php");
    exit;
}

if ($_SESSION['role'] != 'Admin') {
    if ($_SESSION['role'] != 'Manager') {
        header("location: logout.php");
        exit;
    }
}

//fetch record to be edited
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_state = true;

    $sqlEditPost = "SELECT * FROM posts WHERE postID=$id;";

    //Store retrieved post
    $resul = $conn->query($sqlEditPost);
    $record = $resul->fetch_array();

    $pCreator = $record['postCreator'];
    $Ptime = $record['postTime'];
    $Ptitle = $record['title'];
    $pContent = $record['content'];

    $id = $record['postID'];
}

require_once('includes/head.php');
?>

<body>

    <div class="container">

        <?php require_once('includes/jumbotron.php') ?>

        <a href="admin.php"><button id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
        <a href="posts.php"><button id="backHome" type="button" class="btn-success btn-sm">See Posts</button></a>

        <div class="row">
            <div class="col-sm-12">
                <form method="POST" action="dbposts.php" id="">

                    <h3 style="text-align: center;">HORTICULTURE DATABASE</h3><br>

                    <input type="hidden" name="postId" value="<?php echo $id; ?>">

                    <div class="form-group row">
                        <Label class="col-sm-3 col-form-label">Post Title</Label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="PTitle" id="" value="<?php echo $Ptitle; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <Label class="col-sm-3 col-form-label">Content</Label>
                        <div class="col-sm-6">
                            <textarea class="form-control" name="Content" id="" rows="5"><?php echo $pContent; ?></textarea>
                        </div>
                    </div>

                    <div class="input-group">
                        <?php if ($edit_state == false) :  ?>
                            <button type="submit" name="createpost" class="btn-success">Create</button>

                        <?php else :  ?>
                            <button type="submit" name="correctpost" class="btn btn-success">Correct</button>

                        <?php endif  ?>
                    </div>
                </form>
            </div>
        </div>
        <?php

        include('includes/footer.php');
        ?>
    </div>

</body>

</html>