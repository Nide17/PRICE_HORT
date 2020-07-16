<?php
require_once('dbconnect.php');
require_once('dbposts.php');

//Database connection variables;
include('includes/dbvariables.php');

//for msg display
session_start();

if (!isset($_SESSION['role'])) {
    header("location: logout.php");
    exit;
}

if ($_SESSION['role'] != 'Admin') {
    if ($_SESSION['role'] != 'Manager') {
        if ($_SESSION['role'] != 'Employee') {
            header("location: logout.php");
            exit;
        }
    }
}

include('includes/head.php');
?>

<body>

    <div class="container">
        <?php include('includes/jumbotron.php') ?>

        <div class="row">
            <div class="col-12 top-buttons">
                <?php if ($_SESSION['role'] == 'Admin') {  ?>
                    <a href="admin.php"><button id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
                    <a href="homepage.php"><button id="" type="button" class="btn-success btn-sm">Homepage</button></a>
                    <a href="newpost.php"><button id="" type="button" class="btn-success btn-sm">Add Post</button></a>
                    <a href="notified.php"><button id="" type="button" class="btn-success btn-sm">Granted</button></a>
                    <br>
                <?php } elseif ($_SESSION['role'] == 'Manager') { ?>
                    <a href="admin.php"><button id="backHome" type="button" class="btn-success btn-sm">Back Home</button></a>
                    <a href="homepage.php"><button id="" type="button" class="btn-success btn-sm">Homepage</button></a>
                    <a href="newpost.php"><button id="" type="button" class="btn-success btn-sm">Add Post</button></a>
                    <a href="notified.php"><button id="" type="button" class="btn-success btn-sm">Granted</button></a>
                    <br>
                <?php } else { ?>
                    <a href="notified.php"><button id="backHome" type="button" class="btn-success btn-sm">Granted</button></a>
                    <a href="all.php"><button id="" type="button" class="btn-success btn-sm">All Applicants</button></a>
                    <a href="homepage.php"><button id="" type="button" class="btn-success btn-sm">Homepage</button></a>
                <?php } ?>
            </div>
        </div>

        <h3 class="titles">POSTS</h3>

        <?php
        include('includes/messages.php');
        ?>

        <main id="posts-content" class="row mt-4">
            <section class="col-sm-10 offset-sm-1 list-group">

                <?php
                // RETRIEVE DATA FROM posts
                $sqlRetrievePosts = "SELECT * FROM posts ORDER BY postTime DESC LIMIT 8;";
                $result = $conn->query($sqlRetrievePosts);

                if ($result->num_rows > 0) {
                    //output data 50 rows (query from dbposts.php)
                    while ($row = $result->fetch_assoc()) { ?>

                        <article class="list-group-item" style="margin-bottom: 5px;">
                            <h5><?php echo $row['title']; ?></h5>
                            <p><?php echo $row['content']; ?></p>
                        </article>

                        <?php if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Manager') :  ?>
                            <div class="row" style="margin-bottom: 5px;">
                                <div class="col-sm-11 offset-sm-1 text-right">
                                    <small style="margin:0px 50px 10px 0px;"><?php echo $row['postTime']; ?> : <?php echo $row['postCreator']; ?></small>
                                    <a href="newpost.php?edit=<?php echo $row['postID'];  ?>"> <button class="btn btn-warning" id="edit-post">Edit</button></a>
                                    <a href="dbposts.php?del=<?php echo $row['postID'];  ?>"> <button class="btn btn-danger" id="remove-post">Delete</button></a>
                                </div>
                            </div>
                        <?php else :  ?>
                            <small style="margin-bottom: 10px;"><?php echo $row['postTime']; ?> : <?php echo $row['postCreator']; ?></small>
                        <?php endif  ?>
                <?php }
                }
                ?>
            </section>
        </main>

        <button id="allPosts" type="button" class="btn btn-primary btn-sm">All posts</button>
        <script>
            jQuery("#allPosts").on('click', function(e) {
                e.preventDefault();
                jQuery("#posts-content").html('<b style="color: green;">Loading...<b>');
                jQuery(this).addClass('danger');
                jQuery("#posts-content").load("allposts.php");
                jQuery("#allPosts").hide();
            });
        </script>
        <?php
        include('includes/footer.php');
        ?>
    </div>

</body>

</html>