<form action="" method="post">
    <div class="form-group">
    <?php 
                                
    if(isset($_GET['update'])){
        $cat_id = $_GET['update'];
        $query = "SELECT * FROM categories WHERE cat_id = $cat_id ";
        $select_categories_id = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_categories_id)){
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
    ?>
        <input value="<?php if(isset($cat_title)){echo $cat_title;}   ?>" type="text" class="form-control" name="cat_title">
    <?php
        }
    }
                                
                                
    ?>

    <?php 
    //update categories

    if(isset($_POST['update_cat'])){
        $cat_update = $_POST['cat_title'];

        $query = "UPDATE categories SET cat_title = '{$cat_update}' WHERE cat_id = {$cat_id} ";
        $update_query = mysqli_query($connection, $query);
        if(!$update_query){
            die('query failed'.mysqli_error($connection));
            }
    }
                                
                                
    ?>
                                    
        </div>
        <input type="submit" class="btn btn-primary" name="update_cat" value="Update Category">
    </form>
