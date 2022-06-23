<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<!-- Navigation -->

<?php include "includes/navigation.php"; ?>

<?php
$message_validation = "<h4 class='bg-info'>Type your new password</h4>";

if (!isset($_GET['email']) || !isset($_GET['token'])) {
    redirect('index');
} else {
    $email = $_GET['email'];
    $token = $_GET['token'];
    if ($stmt = mysqli_prepare($connection, "SELECT username, user_email FROM users WHERE token = ?")) {
        mysqli_stmt_bind_param($stmt, "s", $token);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $username, $email);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);


        if (isset($_POST['password']) && isset($_POST['repassword'])) {
            $password = $_POST['password'];
            $retype = $_POST['repassword'];

            if ($password === $retype) {
                $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
                
                if($stmt = mysqli_prepare($connection, "UPDATE users SET token = '', user_password = '$password' WHERE user_email = ?")){
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);

                    // if(mysqli_stmt_affected_rows($stmt) >= 1){
                    //     redirect('login');
                    // }

                }

                $message_validation = "<h4 class='bg-success'>Password changed! <a href='login'>Login Here</a></h4>";
            } else {
                $message_validation = "<h4 class='bg-danger'>Password and Re-type Password must be same!</h4>";
            }
        }
    }
}


?>


<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">

                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <label for="password" class="sr-only">Password</label>
                                        <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="repassword" class="sr-only">Re-type Password</label>
                                        <input type="password" name="repassword" id="key" class="form-control" placeholder="Re-type Password">
                                    </div>
                                    <div class="form-group">
                                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>

                            </div><!-- Body-->

                            <?php echo $message_validation; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php"; ?>

</div> <!-- /.container -->