<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>


<!-- Navigation -->

<?php include "includes/navigation.php"; ?>

<?php
if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $error = [
        'username' => '',
        'email' => '',
        'password' => ''
    ];

    $valid_username = checkUsername($username);
    $valid_email = checkEmail($email);


    if (empty($username) || empty($email) || empty($password)) {
        // $error['username'] = "Username cannot be empty";
        // $error['email'] = "Email cannot be empty";
        // $error['password'] = "Password cannot be empty";
        echo "<script>alert('Field cannot be empty')</script>";
    } else if (strlen($username) < 4) {
        $error['username'] = "Username must be longer than 4";
        // echo "<script>alert('{$error['username']}')</script>";
    } else if (strlen($password) < 8) {
        $error['password'] = "Password must be longer than 8";
        // echo "<script>alert('{$error['password']}')</script>";
    } else if ($valid_username >= 1) {
        $error['username'] = "Username already been used";
        // echo "<script>alert('{$error['username']}')</script>";
        // echo "<script>alert('Username already been used')</script>";
    } else if ($valid_email >= 1) {
        $error['email'] = "Email already been used, <a href='index.php'>Login</a?";
        // echo "<script>alert('{$error['email']}')</script>";
        // echo "<script>alert('email already been used')</script>";
    } else {
        registration($username, $email, $password);
    }
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
                                <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                                <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                <p><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
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