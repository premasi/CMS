<div class="col-md-4">


    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="./search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" type="submit" class="btn btn-default">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>

    <!-- Blog Login Well -->
    <div class="well">
        <?php if (isset($_SESSION['user_id'])) : ?>
            <h4>You are already login</h4>
            <a href="./includes/logout.php" class="btn btn-danger">Log Out</a>
        <?php else : ?>
            <h4>Login</h4>
            <form action="./includes/login.php" method="post">
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                </div>
                <div class="form-group">
                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                </div>
                <button type="submit" name="login" class="btn btn-primary" value="Login">Login</button>
                <a href="/course/CMS/registration" class="btn btn-secondary ml-1" value="Registration">Register</a>
            </form>
            <!-- /.input-group -->
        <?php endif; ?>    
    </div>



<!-- Blog Categories Well -->
<div class="well">
    <h4>Blog Categories</h4>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">
                <?php

                $query = "SELECT * FROM categories LIMIT 4";
                $select_all_category = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_all_category)) {
                    $show_id = escape($row['cat_id']);
                    $show_cat = escape($row['cat_title']);

                    echo "<li><a href='/course/CMS/category/{$show_id}'>{$show_cat}</a></li>";
                }


                ?>
            </ul>
        </div>

    </div>
    <!-- /.row -->
</div>

<!-- Side Widget Well -->
<div class="well">
    <h4>Side Widget Well</h4>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
</div>

</div>