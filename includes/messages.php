<?php
//MESSAGES FOR PROFILE UPLOADS ADMIN, HOMEPAGE, POSTS, PROFILEUPDATE
if (isset($_SESSION['msgUpload'])) { ?>
    <div class="msg">
        <?php
        //MESSAGE
        echo $_SESSION['msgUpload'];
        unset($_SESSION['msgUpload']);
        ?>
    </div>
<?php } elseif (isset($_SESSION['msgUploadOK'])) { ?>
    <div class="msgOK">
        <?php
        //MESSAGE
        echo $_SESSION['msgUploadOK'];
        unset($_SESSION['msgUploadOK']);
        ?>
    </div>
<?php
}

//MESSAGES FOR SEARCH ADMIN
if (isset($_SESSION['msgSearch'])) { ?>
    <div class="msgOK">
        <?php
        //MESSAGE
        echo $_SESSION['msgSearch'];
        unset($_SESSION['msgSearch']);
        ?>
    </div>
<?php } ?>


<?php
//MESSAGES FOR APPLICANTS CREATION

if (isset($_SESSION['msgAppOK'])) : ?>
    <div class="msgOK">
        <?php
        //MESSAGE
        echo $_SESSION['msgAppOK'];
        unset($_SESSION['msgAppOK']);
        ?>
    </div>
<?php endif ?>

<?php
//UPDATING THE APPLICANT
if (isset($_SESSION['msgAppOK1'])) : ?>
    <div class="msgOK">
        <?php
        //MESSAGE
        echo $_SESSION['msgAppOK1'];
        unset($_SESSION['msgAppOK1']);
        ?>
    </div>
<?php endif ?>

<?php
if (isset($_SESSION['msgApp'])) : ?>
    <div class="msg">
        <?php
        //MESSAGE
        echo $_SESSION['msgApp'];
        unset($_SESSION['msgApp']);
        ?>
    </div>
<?php endif ?>


<?php

//USER CREATION AND AUTHENTICATION
if (isset($_SESSION['msgUser'])) : ?>
    <div class="msg">
        <?php
        //MESSAGE
        echo $_SESSION['msgUser'];
        unset($_SESSION['msgUser']);
        ?>
    </div>
<?php endif ?>

<?php
if (isset($_SESSION['msgUserOK'])) : ?>
    <div class="msgOK">
        <?php
        //MESSAGE
        echo $_SESSION['msgUserOK'];
        unset($_SESSION['msgUserOK']);
        ?>
    </div>
<?php endif ?>

<?php
if (isset($_SESSION['msgDelAppOK'])) : ?>
    <div class="msgOK">
        <?php
        //MESSAGE
        echo $_SESSION['msgDelAppOK'];
        unset($_SESSION['msgDelAppOK']);
        ?>
    </div>
<?php endif ?>

<?php
if (isset($_SESSION['msgDelApp'])) : ?>
    <div class="msg">
        <?php
        //MESSAGE
        echo $_SESSION['msgDelApp'];
        unset($_SESSION['msgDelApp']);
        ?>
    </div>
<?php endif ?>


<?php
//BY LOCATION
if (isset($_SESSION['msgSearchZero'])) : ?>
    <div class="msg">
        <?php
        //MESSAGE
        echo $_SESSION['msgSearchZero'];
        unset($_SESSION['msgSearchZero']);
        ?>
    </div>
<?php endif ?>

<?php
if (isset($_SESSION['msgSearchloc'])) : ?>
    <div class="msgOK">
        <?php
        //MESSAGE
        echo $_SESSION['msgSearchloc'];
        unset($_SESSION['msgSearchloc']);
        ?>
    </div>
<?php endif ?>

<?php
//POSTS
if (isset($_SESSION['postAdded'])) : ?>
    <div class="msgOK">
        <?php
        //MESSAGE
        echo $_SESSION['postAdded'];
        unset($_SESSION['postAdded']);
        ?>
    </div>
<?php endif ?>

<?php
//POSTS
if (isset($_SESSION['postDel'])) : ?>
    <div class="msgOK">
        <?php
        //MESSAGE
        echo $_SESSION['postDel'];
        unset($_SESSION['postDel']);
        ?>
    </div>
<?php endif ?>

<?php
//not found
if (isset($_SESSION['msgZeroNot'])) : ?>
    <div class="msg">
        <?php
        //MESSAGE
        echo $_SESSION['msgZeroNot'];
        unset($_SESSION['msgZeroNot']);
        ?>
    </div>
<?php endif ?>

<?php
//generic
if (isset($_SESSION['msg'])) : ?>
    <div class="msg">
        <?php
        //MESSAGE
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
        ?>
    </div>
<?php endif ?>