<?php
include('server.php');

if (isset($_SESSION['role'])) {
       header("location: homepage.php");
   }

?>

<body style="background-color: rgb(165, 176, 189);">

    <div class="contain row">

        <div class="com-md-6">
            <hr />
            <h1 class="text-center">LOG IN</h1>
            <hr />
            <form action="server.php" method="POST">
                <?php
                include('includes/messages.php');
                ?>

                <div class="form-group">
                    <label for="username"><strong class="text-info">Username</strong></label>
                    <input type="email" name="username" class="form-control" placeholder="Enter your e-mail here" required>
                </div>

                <div class="form-group">
                    <label for="password"><strong class="text-info">Password</strong></label>
                    <input type="password" name="password" id="password-input" class="form-control" placeholder="Enter your password here" required>
                    <small class="text-info">Password must be between 4 and 10 characters</small>
                </div>

                <div class="form-group">
                    <input type="submit" name="btnLogin" id="submit-button" class="btn btn-outline-success bg-warning" value="   Log in   " style="margin-bottom:50px;">
                    <br>
                    <b>Don't have an account?<a href="signup.php"> <i class="text-info"> Sign up here </i></a> </b>
                </div>

            </form>
            <hr />
        </div>

    </div>

    <script src="bootstrap_4.3.1_dist/js/node_modules/jquery/jquery.min.js"></script>
    <script src="bootstrap_4.3.1_dist/js/node_modules/popper.js/dist/popper.min.js"></script>
    <script src="bootstrap_4.3.1_dist/js/bootstrap.min.js"></script>
    <script src="bootstrap_4.3.1_dist/js/login.js"></script>
    <script src="./node_modules/babel-polyfill/browser.js"></script>

</body>

</html>