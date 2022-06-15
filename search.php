<?php 
include "./includes/db.php";
global $connection;
include "./includes/header.php";


?>

    <!-- Navigation -->
<?php
include "./includes/navigation.php";

?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <?php 

                if(isset($_POST['submit'])){
                $search = $_POST['search'];

                $query = "SELECT * FROM posts WHERE post_title LIKE '%$search%' ";
                $query .= "|| post_tag LIKE '%$search%'";
                $result = mysqli_query($connection, $query);
                if(!$result){
                    die (mysqli_error($connection));
                }

                $count = mysqli_num_rows($result);

                if($count == 0){
                    echo "<h1>Not Found</h1>";
                } else {
    
                    while($row = mysqli_fetch_assoc($result)){
                        $show_post_title = $row['post_title'];
                        $show_post_author = $row['post_author'];
                        $show_post_date = $row['post_date'];
                        $show_post_content = $row['post_content'];
                    ?>
    
                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>
    
                    <!-- First Blog Post -->
                    <h2>
                        <a href="#"><?php echo $show_post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $show_post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?php echo $show_post_date ?></p>
                    <hr>
                    <img class="img-responsive" src="http://placehold.it/900x300" alt="">
                    <hr>
                    <p><?php echo $show_post_content ?></p>
                    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>                   
                   <?php
                    }
    
                }
            }
                   
                    ?>






                </div>


            <!-- Blog Sidebar Widgets Column -->
<?php 
include "./includes/sidebar.php"

?>

        </div>
        <!-- /.row -->

        <hr>

<?php
include "./includes/footer.php";

?>
