<?php

if (isset($_GET['u_id'])) {
    $user_id_get = escape($_GET['u_id']);

    $query = "SELECT * FROM users WHERE user_id = $user_id_get ";
    $select_user_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_user_id)) {
        $user_id =  escape($row['user_id']);
        $username =  escape($row['username']);
        $userpass =  escape($row['user_password']);
        $userfirst =  escape($row['user_firstname']);
        $userlast =  escape($row['user_lastname']);
        $user_email =  escape($row['user_email']);
        $user_image =  escape($row['user_image']);
        $role =  escape($row['role']);
    }



    if (isset($_POST['update_user'])) {

        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $role = escape($_POST['role']);
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
            $query = "SELECT * FROM users WHERE user_id = $user_id_get ";

            $select_image = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_array($select_image)) {

                $user_image = $row['user_image'];
            }

            if (!$select_image) {
                die("Query" . mysqli_error($connection));
            }
        }

        if (empty($user_password)) {
            echo "<script>alert('Password field cannot be empty')</script>";
            // header("location: ./users.php");
        } else {

            // verifikasi cara 1
            // $query = "SELECT randsalt FROM users";
            // $select_randsalt = mysqli_query($connection, $query);
            // $row = mysqli_fetch_array($select_randsalt);
            // $salt = $row['randsalt'];
            // $password = crypt($user_password, $salt);

            $password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));


            $query = "UPDATE users SET ";
            $query .= "user_firstname = '{$user_firstname}', ";
            $query .= "user_lastname = '{$user_lastname}', ";
            $query .= "role = '{$role}', ";
            $query .= "user_email = '{$user_email}', ";
            $query .= "user_image = '{$user_image}', ";
            $query .= "username = '{$username}', ";
            $query .= "user_password = '{$password}' ";
            $query .= "WHERE user_id = '{$user_id_get}' ";

            $update_user = mysqli_query($connection, $query);

            if (!$update_user) {
                die("failed" . mysqli_error($connection));
            }
            echo "<p class='bg-success'>Account Updated : <a href='users.php'>Edit More Account</a></p>";
            //header("location: ./users.php");
        }
    }
}


?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">First Name</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $userfirst; ?>">
    </div>

    <div class="form-group">
        <label for="title">Last Name</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $userlast; ?>">
    </div>

    <div class="form-group">
        <select name="role" id="">
            <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
            <?php
            if ($role == "admin") {
            ?>
                <option value="subscriber">Subscriber</option>
            <?php    } else if ($role == "subscriber") {
            ?>
                <option value="admin">admin</option>
            <?php }

            ?>


        </select>
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
        <input autocomplete="off" type="password" class="form-control" name="user_password" value="">
        <label for="tags"><small>Input new password</small></label>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
    </div>



</form>