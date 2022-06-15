<?php 

function checkQuery($result){
    
    global $connection;
    if(!$result){
        die("Failed".mysqli_error($connection));
    }
}

function insert_categories(){
$submit = isset($_POST['submit']);
global $connection;

if($submit){
    $cat_title = $_POST["cat_title"];
    $cat_title = mysqli_real_escape_string($connection, $cat_title);
    if($cat_title == "" || empty($cat_title) || strlen($cat_title) < 4){
        echo "Must be longer than 4";
    } else {
        $query = "INSERT INTO categories(cat_title) ";
        $query .= "VALUES ('$cat_title') ";
        $create_cat_title = mysqli_query($connection, $query);

        if(!$create_cat_title){
            die('Query Failed' . mysqli_error($connection));
        }
    }
}
}

function showAllCategories(){
    global $connection;
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);

    $i = 1;
    while($row = mysqli_fetch_assoc($select_categories)){
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];
    
        echo "<tr>";
            echo "<td>{$i}</td>";
            echo "<td>{$cat_title}</td>";
            echo "<td><a href='./categories.php?delete={$cat_id}'>Delete</a></td>";
            echo "<td><a href='./categories.php?update={$cat_id}'>Update</a></td>";
        echo "</tr>";
    
    $i++;
    } 
}

function delete_categories(){
    global $connection;

    if(isset($_GET['delete'])){
        $cat_delete = $_GET['delete'];

        $query = "DELETE FROM categories WHERE cat_id = {$cat_delete}";
        $delete_query = mysqli_query($connection, $query);
        header("location: ./categories.php");
    }
    
}

?>