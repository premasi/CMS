<?php

    if(isset($_GET['u_id'])){
    $user_id_get = $_GET['u_id'];
    
        $query = "SELECT * FROM users WHERE user_id = $user_id_get ";
        $select_user_id = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_user_id)) {
            $user_id = $row['user_id'];
            $username = $row['username'];
            $userpass = $row['user_password'];
            $userfirst = $row['user_firstname'];
            $userlast = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $role = $row['role'];
        }
        
        if(isset($_POST['update_user'])){

            $user_firstname = $_POST['user_firstname'];
            $user_lastname = $_POST['user_lastname'];
            $role = $_POST['role'];
            $user_email = $_POST['user_email'];
        
            //upload file
            $user_image = $_FILES['image']['name']; 
            $user_image_temp = $_FILES['image']['tmp_name']; //diupload melalui temporary setelah disimpin di temp
        
            $username = $_POST['username'];
            $user_password = $_POST['user_password'];
            
            //tanggal
            //$post_date = date('d-m-y');
            //$comment_count = 4;
        
            move_uploaded_file($user_image_temp, "../images/$user_image");

            if(empty($user_image)){
                $query = "SELECT * FROM users WHERE user_id = $user_id_get ";

                $select_image = mysqli_query($connection,$query);

                while ($row = mysqli_fetch_array($select_image)){

                    $user_image = $row['user_image'];
                }

                if(!$select_image){
                    die("Query".mysqli_error($connection));
                }
           }

            $query = "UPDATE users SET ";
            $query .= "user_firstname = '{$user_firstname}', ";
            $query .= "user_lastname = '{$user_lastname}', ";
            $query .= "role = '{$role}', ";
            $query .= "user_email = '{$user_email}', ";
            $query .= "user_image = '{$user_image}', ";
            $query .= "username = '{$username}', ";
            $query .= "user_password = '{$user_password}' ";
            $query .= "WHERE user_id = '{$user_id_get}' ";

            $update_user = mysqli_query($connection, $query);

            if(!$update_user){
                die("failed".mysqli_error($connection));
            }

            header("location: ./users.php");

        }

    }


?>

<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
    <label for="title">First Name</label>
    <input type="text" class="form-control" name="user_firstname" value="<?php echo $userfirst;?>">
</div>

<div class="form-group">
    <label for="title">Last Name</label>
    <input type="text" class="form-control" name="user_lastname" value="<?php echo $userlast;?>">
</div>

<div class="form-group">
    <select name="role" id="">
        <option value="subscriber">Select Role</option>
        <option value="admin">Admin</option>
        <option value="subscriber">Subscriber</option>

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
    <input type="email" class="form-control" name="user_email" value="<?php echo $user_email;?>">
</div>

<div class="form-group">
        <img width="100" height="100" src="../images/<?php echo $user_image; ?>" alt="">
        <input type="file" name="image">
</div>

<div class="form-group">
    <label for="status">Username</label>
    <input type="text" class="form-control" name="username" value="<?php echo $username;?>">
</div>

<div class="form-group">
    <label for="tags">Password</label>
    <input type="password" class="form-control" name="user_password" value="<?php echo $user_password;?>">
</div>

<div class="form-group">
    <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
</div>



</form>