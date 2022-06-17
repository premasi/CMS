<?php
include "./includes/admin_header.php";

if (isset($_SESSION['user_id'])) {
    $user_id = escape($_SESSION['user_id']);

    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $select_user = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_user)) {
        $user_firstname = escape($row['user_firstname']);
        $user_lastname = escape($row['user_lastname']);
        $user_email = escape($row['user_email']);
        $username = escape($row['username']);
        $user_password = escape($row['user_password']);
        $user_image = escape($row['user_image']);
    }
}
?>





?>

<div id="wrapper">

    <!-- Navigation -->
    <?php
    include "./includes/admin_navigation.php";
    ?>

    <?php
    if (isset($_POST['update_user'])) {

        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $user_email = escape($_POST['user_email']);

        //upload file
        $user_image = $_FILES['image']['name'];
        $user_image_temp = $_FILES['image']['tmp_name']; //diupload melalui temporary setelah disimpin di temp

        $username = escape($_POST['username']);
        $user_password = escape($_POST['user_password']);

        //tanggal
        //$post_date = date('d-m-y');
        //$comment_count = 4;

        move_uploaded_file($user_image_temp, "../images/$user_image");

        if (empty($user_image)) {
            $query = "SELECT * FROM users WHERE user_id = $user_id ";

            $select_image = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_array($select_image)) {

                $user_image = $row['user_image'];
            }

            if (!$select_image) {
                die("Query" . mysqli_error($connection));
            }
        }

        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_image = '{$user_image}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_password = '{$user_password}' ";
        $query .= "WHERE user_id = '{$user_id}' ";

        $update_user = mysqli_query($connection, $query);

        if (!$update_user) {
            die("failed" . mysqli_error($connection));
        }

        echo "<p class='bg-success'>Profile Updated!</p>";
        // header("location: ./users.php");
    }
    ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome back!
                        <small>Subheading</small>
                    </h1>
                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="title">First Name</label>
                            <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
                        </div>

                        <div class="form-group">
                            <label for="title">Last Name</label>
                            <input type="text" class="form-control" name="user_lastname" value="<?php echo  $user_lastname; ?>">
                        </div>

                        <!-- <div class="form-group">
    <select name="category_id" id="category_id"> -->
                        <?php
                        // $query = "SELECT * FROM categories ";
                        // $select_categories_edit = mysqli_query($connection, $query);

                        // //checkQuery($select_categories_edit);

                        // while($row = mysqli_fetch_assoc($select_categories_edit)){
                        //     $cat_id = $row['cat_id'];
                        //     $cat_title = $row['cat_title'];

                        //     echo "<option value='$cat_id'>$cat_title</option>";

                        // }


                        ?>
                        <!-- </select>
</div> -->

                        <div class="form-group">
                            <label for="author">Email</label>
                            <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
                        </div>

                        <div class="form-group">
                            <img width="100" height="100" src="../images/<?php echo $user_image; ?>" alt="">
                            <input type="file" name="image">
                        </div>

                        <div class="form-group">
                            <label for="status">Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                        </div>

                        <div class="form-group">
                            <label for="tags">Password</label>
                            <input autocomplete="off" type="password" class="form-control" name="user_password">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
                        </div>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php
    include "./includes/admin_footer.php";
    ?>