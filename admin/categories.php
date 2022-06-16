<?php 
include "./includes/admin_header.php";

?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php 
        include "./includes/admin_navigation.php";
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

                        <!-- content -->
                        <div class="col-xs-6">
                            <?php 
                            insert_categories();
                            ?>
                            <form action="./categories.php" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="cat_title" placeholder="New category">
                                </div>
                                <input type="submit" class="btn btn-primary" name="submit" value="Add Category">
                            </form> <br>

                        <?php //update query and include function
                        if(isset($_GET['update'])){
                            $cat_id = $_GET['update'];

                            include "./includes/update_categories.php";
                        }

                        ?>

                        </div>
                        <div class="col-xs-6">
                            <table class="table table-hover">
                                <thread>
                                    <tr>
                                        <th>No</th>
                                        <th>Category Title</th>
                                    </tr>
                                </thread>
                                <tbody>

                                <?php //show categories 
                                showAllCategories();
                                ?>

                                <?php //delete categories
                                delete_categories();
                                ?>

                                </tbody>
                            </table>
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
