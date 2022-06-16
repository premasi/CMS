<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>


<!-- Navigation -->

<?php include "includes/navigation.php"; ?>

<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {
        echo "<script>alert('Field cannot be empty')</script>";
    } else {

        $username = mysqli_real_escape_string($connection, $username);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);

        $query = "SELECT randsalt FROM users";
        $select_randsalt = mysqli_query($connection, $query);
        
        //crypt
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

        //menambil salt dari kolom database
        // $row = mysqli_fetch_assoc($select_randsalt);
        // $salt = $row['randsalt'];
        // $password = crypt($password, $salt);

        //cara lain
        // $hashformat = "2y$10$";
        // $salt = "willyoumarrymeyeahjust";
        // $hash_and_salt = $hashformat . $salt;
        // $password = crypt($password, $hash_and_salt);


        $query = "INSERT INTO users (username, user_email, user_password, role) ";
        $query .= "VALUES('$username', '$email', '$password', 'subscriber')";
        $create_account = mysqli_query($connection, $query);

        if (!$create_account) {
            die("Failed" . mysqli_error($connection));
        }

        echo "<script>alert('Success')</script>";
    }


    //checkQuery($select_randsalt);
}

?>


<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php"; ?>