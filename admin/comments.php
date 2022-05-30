<?php

// Manage Categories Page
ob_start();

session_start();
if (isset($_SESSION['username'])) {
    $pageTitle = 'Comments';
    include 'init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] :"Manage";
    if($do == "Manage"){
    
        //Select all NORMAL users NOT ADMINs
        $stmt = $con->prepare(
                "SELECT comments.*, items.Name , users.username
                FROM 
                    comments
                INNER JOIN
                    items
                ON
                    items.Item_ID = comments.item_id
                   INNER JOIN 
                   users
                  ON
                  items.Member_ID = users.userid
                    ");
        $stmt->execute();
        //Assign to variables
        $rows= $stmt->fetchAll();
        ?>
        <h1 class="text-center"> Manage Comments</h1>
        <div class="container">
            <div class="card group-header">
                <h2 class="text-center ">Comments</h2>
            </div>
            <div class="table-responsive">
                <table class="main-table text-center table table-bordered table-striped table-hover">
                    <tr>
                        <td>#</td>
                        <td>#ID</td>
                        <td>Comment</td>
                        <td>Item Name</td>
                        <td>Username</td>
                        <td>Date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                    foreach ($rows as $row) {
                        $i = array_search($row, $rows) + 1;
                        echo '<tr>';
                        echo '<td>' . $i . '</td>';
                        echo '<td>' . $row['c_id'] . '</td>';
                        echo '<td>' . $row['comment'] . '</td>';
                        echo '<td>' . $row['Name'] . '</td>';
                        echo '<td>' . $row['username'] . '</td>';
                        echo '<td>' . $row['comment_date'] . '</td>';
                        echo '<td>';
                        echo '<div class= " d-flex">';
                            if ($row['status'] == 0) {echo "<a href='comments.php?do=Approve&c_id=" . $row['c_id'] . "' class='btn btn-info activate'><i class='fa-solid fa-check'></i></a> ";}
                            echo "<a href='comments.php?do=Edit&c_id=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i></a> ";
                            echo "<a href='comments.php?do=Delete&c_id=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i></a>";
                        echo '</div>';
                        echo '</td></tr>';
                        $i += 1;
                    }
                    ?>
                </table>
            </div>
        </div>
        
<?php

    }elseif ($do == 'pending') {  //Manage comments Page
    
    }elseif($do == "Add"){
    
    
    }elseif($do == "Insert"){
    
    }elseif($do == "Edit"){
    
      //check id Get request userId is Numeric & Get the Integer Value of it
        $c_id = isset($_GET['c_id']) && is_numeric($_GET['c_id']) ? intval($_GET['c_id']) : 0;
        // Select all data on this id
        $stmt = $con->prepare("SELECT * FROM  comments  WHERE c_id=? ");
        //execute query
        $stmt->execute(array($c_id));
        //fetch data
        $row = $stmt->fetch();
        // the row count
        $count = $stmt->rowCount();
        // if there is such id show the form
        if ($stmt->rowCount() > 0) { 
            //apply the code if there is Id with input data.
            ?>

<h1 class="text-content text-center">Edit Comment</h1>
<div class="container">
    <form action="?do=Update" class="form-horizontal" method="POST">
        <input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
        <!-- Start Comment Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Comment</span>
            <textarea class="form-control input-lg "  name="comment" required="required">
                <?php echo $row['comment'] ; ?>
                </textarea>
        </div>
        <!-- End Username Field -->
        <!-- Start Button Field -->
        <div class="input-group mb-3">
            <input class="btn btn-primary form-control" type="submit" value="Save">
        </div>
        <!-- End Button Field -->
    </form>
</div>
<?php
              }      // if there is no such id show error message
    
    
    }elseif($do == "Update"){
    
      echo " <h1 class='text-content text-center'>Edit Comment</h1>";
    echo " <div class='container'>";
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Get variables from Form
                    $c_id = $_POST['c_id'];
                    $comment = $_POST['comment'];
                    
                    $stmt= $con->prepare("UPDATE comments SET  comment=? WHERE c_id=?");
                    $stmt->execute(array($comment,$c_id));
                    if($stmt->rowCount() == 0){
                                // $errMsg= "You can't be here directly";
                                // redirectToHome($errMsg, 4,"info",'members');
                                $errMsg= "No records have been updated";
                                redirectToHome($errMsg, 7, 'danger','comments');
                            }else{
                                $errMsg= "<strong>".$stmt->rowCount(). "</strong> record have been updated.";
                                redirectToHome($errMsg, 5,"success",'comments');
                    }
            } else {
                            $errMsg= "You can't be here directly";
                            redirectToHome($errMsg, 60,"danger",'back');
                        }
    echo "</div>";
    }elseif($do == "Delete"){
    
     //check id Get request userId is Numeric & Get the Integer Value of it
            $c_id = isset($_GET['c_id']) && is_numeric($_GET['c_id']) ? intval($_GET['c_id']) : 0;
            // Select all data on this id
            $stmt = $con->prepare("SELECT * FROM  comments  WHERE c_id=? ");
            //execute query
            $stmt->execute(array($c_id));
            // the row count
            $count = $stmt->rowCount();
            // if there is such id show the form
            if ($stmt->rowCount() > 0) {//apply the code if there is Id with input data.
                $stmt = $con->prepare("DELETE FROM comments WHERE c_id= :Ic_id");
                $stmt->bindParam(":Ic_id",$c_id);
                $stmt->execute();
                echo '<div class="container">';
                    $errMsg="Comment has been Deleted";
                    redirectToHome($errMsg, 3,"danger",'comments');
                    echo '</div>';
        } // if there is no such id show error message
    
    
    
    }elseif($do == "Approve"){
     echo '<div class="container">
        <h1 class="text-center">Activate Comment</h1>
    </div>';
        echo '<div class="container">';
        
        //check id Get request userId is Numeric & Get the Integer Value of it
        $c_id = isset($_GET['c_id']) && is_numeric($_GET['c_id']) ? intval($_GET['c_id']) : 0;

        $check= checkItem('c_id', 'comments', $c_id); // check if comment exists

        if ($check > 0){
        $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id=?");
        //execute query
        $stmt->execute(array($c_id));
        $errMsg= 'Comment has been Activated Successfuly';
        redirectToHome($errMsg, 2,"success",'back');
    }else{
        $errMsg= 'Member is Not found !!';
        redirectToHome($errMsg, 3,"danger",'back');
    }
    echo '</div>';
    }
    include $tpl . 'footer.php';
} else {
    header('Location:index.php'); // redirect to dashboard page
    exit();
}
ob_end_flush();
?>