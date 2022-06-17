<?php

if (isset($_GET['p_id'])) {
    $post_id_get = $_GET['p_id'];

    $query = "SELECT * FROM posts WHERE post_id = $post_id_get ";
    $select_posts_id = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_posts_id)) {
        $post_id =  escape($row['post_id']);
        $post_title =  escape($row['post_title']);
        $post_author =  escape($row['post_author']);
        $post_cat =  escape($row['post_category_id']);
        $post_status =  escape($row['post_status']);
        $post_images =  escape($row['post_images']);
        $post_tags =  escape($row['post_tag']);
        $post_comment =  escape($row['post_comment_count']);
        $post_date =  escape($row['post_date']);
        $post_content =  escape($row['post_content']);
    }

    if (isset($_POST['update_post'])) {

        $post_title = escape($_POST['title']);
        $post_cat_id = escape($_POST['post_category']);
        $post_author = escape($_POST['author']);
        $post_status = escape($_POST['status']);

        //upload file
        $post_images = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name']; //diupload melalui temporary setelah disimpin di temp

        $post_tags = escape($_POST['tags']);
        $post_content = escape($_POST['content']);

        $post_date = date('d-m-y');
        //$comment_count = 4;


        move_uploaded_file($post_image_temp, "../images/$post_images");

        if (empty($post_images)) {
            $query = "SELECT * FROM posts WHERE post_id = $post_id_get ";

            $select_image = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_array($select_image)) {

                $post_images = $row['post_images'];
            }

            if (!$select_image) {
                die("Query" . mysqli_error($connection));
            }
        }

        if (empty($post_title) || empty($post_status)) {
            echo "<p class='bg-danger'>Title and status cannot be empty</p>";
        } else {

            $query = "UPDATE posts SET ";
            $query .= "post_title = '{$post_title}', ";
            $query .= "post_category_id = '{$post_cat_id}', ";
            $query .= "post_date = now(), ";
            $query .= "post_author = '{$post_author}', ";
            $query .= "post_images = '{$post_images}', ";
            $query .= "post_tag = '{$post_tags}', ";
            $query .= "post_content = '{$post_content}', ";
            $query .= "post_status = '{$post_status}' WHERE post_id = '{$post_id_get}' ";

            $update_post = mysqli_query($connection, $query);

            if (!$update_post) {
                die("failed" . mysqli_error($connection));
            }

            echo "<p class='bg-success'>Post Updated : <a href='../post.php?p_id={$post_id_get}'>View Post</a> or <a href='posts.php'>Edit More Post</a></p>";
            // header("location: ./posts.php");
        }
    }
}


?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <select name="post_category" id="post_category">
            <?php
            $query = "SELECT * FROM categories ";
            $select_categories_edit = mysqli_query($connection, $query);

            //checkQuery($select_categories_edit);

            while ($row = mysqli_fetch_assoc($select_categories_edit)) {
                $cat_id =  escape($row['cat_id']);
                $cat_title =  escape($row['cat_title']);

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
            <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>

            <?php
            if ($post_status === "draft") {
                echo "<option value='published'>publish</option>";
            } else {
                echo "<option value='draft'>draft</option>";
            }


            ?>

        </select>
    </div>

    <div class="form-group">
        <img width="100" height="100" src="../images/<?php echo $post_images; ?>" alt="">
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="tags">
    </div>

    <div class="form-group">
        <label for="content">Description</label>
        <textarea class="form-control" name="content" id="summernote" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update">
    </div>



</form>