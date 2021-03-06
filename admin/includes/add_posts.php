<?php
if (isset($_POST['create_post'])) {
    $post_title = escape($_POST['title']);
    $post_cat_id = escape($_POST['category_id']);
    $post_author = escape($_POST['author']);
    $post_status = escape($_POST['status']);

    //upload file
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name']; //diupload melalui temporary setelah disimpin di temp

    $post_tags = escape($_POST['tags']);
    $post_content = escape($_POST['content']);

    //tanggal
    $post_date = date('d-m-y');
    //$comment_count = 4;

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if (empty($post_title) || empty($post_status)) {
        echo "<p class='bg-danger'>Title and status cannot be empty</p>";
    } else {

        $query = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_images, post_content, post_tag, post_status) ";
        $query .= "VALUES({$post_cat_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";

        $create_post_query = mysqli_query($connection, $query);

        #check query
        checkQuery($create_post_query);

        //berfungsi untuk mengambil id terakhir yang dibuat pada database
        $post_id_get = mysqli_insert_id($connection);

        echo "<p class='bg-success'>Post Created : <a href='../post.php?p_id={$post_id_get}'>View Post</a> or <a href='posts.php'>Add More Post</a></p>";
    }
}


?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id">
            <option value=''>Select Category</option>
            <?php
            $query = "SELECT * FROM categories ";
            $select_categories_edit = mysqli_query($connection, $query);

            //checkQuery($select_categories_edit);

            while ($row = mysqli_fetch_assoc($select_categories_edit)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<option value='$cat_id'>$cat_title</option>";
            }


            ?>
        </select>
    </div>

    <?php
    $user_id = $_SESSION['user_id'];
    $query = "SELECT username FROM users WHERE user_id = $user_id";
    $get_query = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($get_query);
    $username = $row['username'];


    ?>

    <div class="form-group">
        <label for="author">Author</label>
        <input type="text" class="form-control" name="author" value="<?php echo $username; ?>" readonly>
    </div>

    <div class="form-group">
        <select name="status" id="">
            <option value="">Select Option</option>
            <option value='published'>publish</option>
            <option value='draft'>draft</option>
        </select>
    </div>

    <div class="form-group">
        <label for="image">Images</label>
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input type="text" class="form-control" name="tags">
    </div>

    <div class="form-group">
        <label for="content">Description</label>
        <textarea class="form-control" name="content" id="summernote" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish">
    </div>



</form>