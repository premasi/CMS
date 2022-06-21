<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/course/CMS/index">Start Bootstrap</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                $user_id = $_SESSION['user_id'];

                $regis_class = "";
                $login_class = "";
                $contact_class = "";
                $pagename = basename($_SERVER['PHP_SELF']);
                $contact = "contact.php";
                $login = "login.php";
                $registration = "registration.php";

                if ($pagename == $contact) {
                    $contact_class = "active";
                } else if ($pagename == $login) {
                    $login_class = "active";
                } else if ($pagename == $registration) {
                    $regis_class = "active";
                }

                ?>
                
                <li>
                    <a href="#">Services</a>
                </li>
                <li class="<?php echo $contact_class; ?>">
                    <a href="/course/CMS/contact">Contact</a>
                </li>

                <?php if (checkLogin()) : ?>
                    <?php if (usersRole($user_id)) : ?>
                        <li>
                            <a href="admin">Admin</a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="./includes/logout.php">Logout</a>
                    </li>
                <?php else : ?>
                    </li>
                    <li class="<?php echo $login_class; ?>">
                        <a href="/course/CMS/login">Login</a>
                    </li>
                    <li class="<?php echo $regis_class; ?>">
                        <a href="/course/CMS/registration">Registration</a>
                    </li>
                <?php endif; ?>

                <!-- <li class="<?php echo $login_class; ?>">
                    <a href="/course/CMS/login">Login</a>
                </li>
                <li class="<?php echo $regis_class; ?>">
                    <a href="/course/CMS/registration">Registration</a>
                </li> -->
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>