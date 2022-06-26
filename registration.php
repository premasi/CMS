<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>


<!-- Navigation -->

<?php include "includes/navigation.php"; ?>

<?php

if (isset($_GET['lang']) && !empty($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];

    if (isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']) {
        echo "<script type='text/javascript'>location.reload();</script>";
    }
}

if (isset($_SESSION['lang'])) {
    include "./includes/languages/" . $_SESSION['lang'] . ".php";
} else {
    include "./includes/languages/eng.php";
}

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
    <form action="" class="navbar-form navbar-right" method="get" id="language_form">
        <div class="form-group">
            <select name="lang" class="form-control" onchange="changeLangueage()">
                <option value="eng" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'eng') {
                                        echo "selected";
                                    } ?>>English</option>
                <option value="ind" <?php if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'ind') {
                                        echo "selected";
                                    } ?>>Indonesia</option>
            </select>
        </div>
    </form>

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1><?php echo _REGISTER;?></h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME;?>">
                                <p><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL;?>">
                                <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD;?>">
                                <p><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>

    <script>
        function changeLangueage() {
            document.getElementById('language_form').submit();
        }
    </script>



    <?php include "includes/footer.php"; ?>