<?php
/*
    ================================================
    = All about:                                   =
    =           Users                              =
    =           Login                              =
    =           Sessions                           =
    =           Signup                             =     
    = @Niyomwnugeri Parmenide Ishimwe              = 
    ================================================
*/

session_start();
//CONNECT TO THE hort_db
//Database connection variables;
require('includes/dbvariables.php');

//-------IF LOGIN BUTTON IS PRESSED------//
if (isset($_POST["btnLogin"])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // RETRIEVE DATA FROM DB
    $sqlUser = "SELECT * FROM tblUser
                WHERE Username = '$username' 
                AND Password = '$password'";

    //STORE THE RESULT OF QUERY
    $result = $conn->query($sqlUser);

    //COUNTING THE NUMBER OF ROWS RETURNED
    if ($result->num_rows == 1) {

        //output data of each row
        while ($row = $result->fetch_assoc()) {

            if (isset($row['u_id'])) {
                $uid = $row['u_id'];
            }
            if (isset($row['profile_image'])) {
                $img = $row['profile_image'];
            }

            if ($row["Role"] == "Admin") {

                $_SESSION['LoginAdmin'] = $row["Firstname"] . " " . $row["Lastname"];
                $_SESSION['role'] = $row["Role"];
                $_SESSION['user'] = $row["Username"];
                $_SESSION['useridentity'] = $row["u_id"];
                $_SESSION['profilepic'] = $row["profile_image"];
                $_SESSION['first'] = $row["Firstname"];
                header('Location: admin.php');
            } elseif ($row["Role"] == "Manager") {

                $_SESSION['LoginManager'] = $row["Firstname"] . " " . $row["Lastname"];
                $_SESSION['role'] = $row["Role"];
                $_SESSION['user'] = $row["Username"];
                $_SESSION['useridentity'] = $row["u_id"];
                $_SESSION['profilepic'] = $row["profile_image"];
                $_SESSION['first'] = $row["Firstname"];
                header('Location: admin.php');
            } elseif ($row["Role"] == "Employee") {

                $_SESSION['LoginEmployee'] = $row["Firstname"] . " " . $row["Lastname"];
                $_SESSION['role'] = $row["Role"];
                $_SESSION['user'] = $row["Username"];
                $_SESSION['useridentity'] = $row["u_id"];
                $_SESSION['profilepic'] = $row["profile_image"];
                $_SESSION['first'] = $row["Firstname"];
                header('Location: posts.php');
            } else {

                $_SESSION['LoginUser'] = $row["Firstname"] . " " . $row["Lastname"];
                $_SESSION['role'] = $row["Role"];
                $_SESSION['user'] = $row["Username"];
                $_SESSION['useridentity'] = $row["u_id"];
                $_SESSION['profilepic'] = $row["profile_image"];
                $_SESSION['first'] = $row["Firstname"];
                header('Location: homepage.php');
            }
        }
    } else {
        $_SESSION['msgUser'] = "Error! Wrong credentials";
        header('Location: index.php');
    }
    $conn->close();
}


//-------CREATING A NEW USER---------//
if (isset($_POST["btnSignup"])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password1 = $_POST['password1'];

    // VERIFY IF PASSWORDS MATCH

    if ($password == $password1) {

        //Verify if username exist in DB
        $checkDB = "SELECT Username FROM tblUser WHERE Username = '$username'";
        $checkResult = $conn->query($checkDB);

        if ($checkResult->num_rows > 0) {
            $_SESSION['msgUser'] = "Email exists! try another.";
            //REDIRECTS BACK TO THE PREVIOUS PAGE
            header("location:" . $_SERVER['HTTP_REFERER']);
        } else {

            // if email is unique, SEND TO THE DB
            $sqlSignup = "INSERT INTO tblUser(Username, Password, Role, Firstname, Lastname)
        VALUES ('$username', '$password', 'User', '$firstname', '$lastname')";

            if ($conn->query($sqlSignup) === true) {
                $_SESSION['msgUserOK'] = "User created successfully, Login!";
                header('location: index.php');
            } else {
                $_SESSION['msgUser'] = "Error" . $sqlSignup . $conn->error;
                header("location:" . $_SERVER['HTTP_REFERER']);
            }
        }
    }

    $conn->close();
}



//--------UPDATE DATA IN THE DB-----//
if (isset($_POST['updateP'])) {
    //    session_start();

    $finame = mysqli_real_escape_string($conn, $_POST['fname']);
    $laname = mysqli_real_escape_string($conn, $_POST['lname']);

    $id = mysqli_real_escape_string($conn, $_POST['user_Id']);

    // Image data
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    // Select file type
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    //Valid file extensions
    $extensions_arr = array("jpg", "jpeg", "png", "gif");

    //check extension
    if (in_array($imageFileType, $extensions_arr)) {

        //Check file size
        if ($_FILES["fileToUpload"]["size"] > 1000000) {
            echo "Sorry, your file is too large.";
            $_SESSION['msgUpload'] = "Error! Image is too large, it must be less than 1MB.";

            header("location:" . $_SERVER['HTTP_REFERER']);
            $uploadOk = 0;
        } else {

            //convert to base64
            $image_base64 = addslashes(file_get_contents($_FILES['fileToUpload']['tmp_name']));

            //Updating the database
            $sqlUpdateP = "UPDATE tblUser SET Firstname='$finame', Lastname='$laname', profile_image='$image_base64' WHERE u_id=$id";

            if ($conn->query($sqlUpdateP) === TRUE) {

                //uploading to the uploads folder
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                $_SESSION['msgUploadOK'] = "Profile updated successfully!";

                if ($_SESSION['role'] == 'Admin') {
                    header('location: admin.php');
                } elseif ($_SESSION['role'] == 'Manager') {
                    header('location: admin.php');
                } elseif ($_SESSION['role'] == 'Employee') {
                    header('location: posts.php');
                } else {
                    header('location: homepage.php');
                }
            } else {
                echo "Error updating:" . $conn->error;
                $_SESSION['msgUpload'] = "Failed to update!";

                header("location:" . $_SERVER['HTTP_REFERER']);
            }
        }
    } else {
        echo "Error:" . $conn->error;
        $_SESSION['msgUpload'] = "Failed! Please upload a picture";

        header("location:" . $_SERVER['HTTP_REFERER']);
    }
}
