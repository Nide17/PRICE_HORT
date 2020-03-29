<?php
require_once('server.php');
//CONNECT TO THE hort_db

require_once('includes/head.php');
?>

<body style="background-color: rgb(165, 176, 189);">

    <div class="contain row">
        <div class="com-md-6">
            <hr />
            <h1 class="text-center">SIGN UP</h1>
            <hr />
            <form action="server.php" method="POST">

                <?php
                include('includes/messages.php');
                ?>

                <div class="form-group">
                    <input type="text" name="firstname" id="" class="form-control" placeholder="Enter your firstname" required>
                </div>
                <div class="form-group">
                    <input type="text" name="lastname" id="" class="form-control" placeholder="Enter your lastname" required>
                </div>
                <div class="form-group">
                    <input type="email" name="username" id="" class="form-control" placeholder="Enter your e-mail" required>
                </div>

                <div class="form-group">
                    <input type="password" name="password" id="password-input" class="form-control" placeholder="Enter your password" required>
                    <small class="text-info">Password must be between 4 and 10 characters</small>
                </div>
                <div class="form-group">
                    <input type="password" name="password1" id="confirm-password" class="form-control" placeholder="Verify your password" required>
                    <small id="error-message" class="text-danger"></small>
                </div>

                <div class="form-group">
                    <input type="submit" name="btnSignup" id="signup-button" class="btn btn-outline-success bg-warning" value="  Signup  ">
                    <br>
                    <b>Have an account?<a href="index.php"> <i class="text-info"> Log in here</i></a> </b>
                </div>

            </form>
            <hr />
        </div>

    </div>

    <script src="bootstrap_4.3.1_dist/js/node_modules/jquery/jquery.min.js"></script>
    <script src="bootstrap_4.3.1_dist/js/node_modules/popper.js/dist/popper.min.js"></script>
    <script src="bootstrap_4.3.1_dist/js/bootstrap.min.js"></script>
    <script src="bootstrap_4.3.1_dist/js/signup.js"></script>
    <script src="./node_modules/babel-polyfill/browser.js"></script>
</body>

</html>