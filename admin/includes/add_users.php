<?php 
if(isset($_POST['create_user'])){
    $user_firstname = escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);
    $role = escape($_POST['role']);
    $user_email = escape($_POST['user_email']);

    //upload file
    $user_image = $_FILES['image']['name']; 
    $user_image_temp = $_FILES['image']['tmp_name']; //diupload melalui temporary setelah disimpin di temp

    $username = escape($_POST['username']);
    $user_password = escape($_POST['user_password']);

    // $hashformat = "2y$10$";
    // $salt = "willyoumarrymeyeahjust";
    // $hash_and_salt = $hashformat . $salt;
    // $password = crypt($user_password, $hash_and_salt);

    $password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12) );
    
    //tanggal
    //$post_date = date('d-m-y');
    //$comment_count = 4;

    move_uploaded_file($user_image_temp, "../images/$user_image");

    $query = "INSERT INTO users (user_firstname, user_lastname, user_email, user_image, username, user_password, role) ";
    $query .= "VALUES('{$user_firstname}', '{$user_lastname}', '{$user_email}', '{$user_image}', '{$username}', '{$password}', '{$role}')";

    $create_user_query = mysqli_query($connection, $query);

    #check query
    checkQuery($create_user_query);

    echo "<p class='bg-success'>Account Created! : <a href='users.php'>View Account</a></p>";
}


?>

<form action="" method="post" enctype="multipart/form-data">

<div class="form-group">
    <label for="title">First Name</label>
    <input type="text" class="form-control" name="user_firstname">
</div>

<div class="form-group">
    <label for="title">Last Name</label>
    <input type="text" class="form-control" name="user_lastname">
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
    <input type="email" class="form-control" name="user_email">
</div>

<div class="form-group">
    <label for="image">Images</label>
    <input type="file" name="image">
</div>

<div class="form-group">
    <label for="status">Username</label>
    <input type="text" class="form-control" name="username">
</div>

<div class="form-group">
    <label for="tags">Password</label>
    <input type="password" class="form-control" name="user_password">
</div>

<div class="form-group">
    <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
</div>



</form>