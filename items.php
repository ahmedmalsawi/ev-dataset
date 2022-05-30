<?php
session_start();
$pageTitle="Show Item";
include 'init.php';





//check id Get request userId is Numeric & Get the Integer Value of it
$Item_ID = isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID']) ? intval($_GET['Item_ID']) : 0;
// Select all data on this id
$stmt = $con->prepare("SELECT 
                        *, categories.Name As catName, users.username, items.name AS itemName, items.Description AS itemDesc
                        
                    FROM  
                        items
                    INNER JOIN
                        categories
                    ON
                       categories.ID = items.Cat_ID
                    INNER JOIN 
                        users
                    ON
                         users.userid=items.Member_ID
                       
                    WHERE Item_ID=? 
                    AND items.regStatus =1
                    ");
//execute query
$stmt->execute(array($Item_ID));
//fetch data
$item = $stmt->fetch();
// if there is such id show the form
$count = $stmt->rowCount();
//apply the code if there is Id with input data.
if ($count > 0) { ?>
<h1 class="text-center"><?php echo $item['itemName']; ?></h1>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <img class="img-responsive img-thumbnail img-fluid center-block" src="images/avatar2.jpg" alt="">
        </div>
        <div class="col-md-9 item-info">
            <h2 class=""><?php echo $item['itemName']; ?></h2>
            <p class=""><?php echo $item['itemDesc']; ?></p>
            <ul class="list-unstyled">
                <li>
                    <i class="fa fa-calendar fa-fw"></i>
                    <span class="">Add Date : </span>
                    <?php echo $item['Add_Date']; ?>
                </li>
                <li>
                    <i class="fa fa-money-bill fa-fw"></i>
                    <span class="">Price : </span>
                    <?php echo $item['Price']; ?>
                </li>
                <li>
                    <i class="fa fa-tags fa-fw"></i>
                    <span class="">Category : </span>
                    <a href="categories.php?pageid=<?php echo $item['Cat_ID']; ?>">
                        <?php echo $item['catName']; ?>
                    </a>
                </li>
                <li>
                    <i class="fa fa-building fa-fw"></i>
                    <span class="">Made In : </span>
                    <?php echo $item['Country_Origin']; ?>
                </li>
                <li>
                    <i class="fa fa-user fa-fw"></i>
                    <span class="">Added by: </span>
                    <a href="">
                        <?php echo $item['username']; ?>
                    </a>
                </li>
                <li class="tags-items">
                    <i class="fa fa-user fa-fw"></i>
                    <span class="">Tags: </span>
                    <?php
                    $allTags = explode(',', $item['tags']);
                    foreach ($allTags as $tag) {
                        $tag = trim($tag);
                        $tag = str_replace(' ', '_', $tag);
                        $tag = str_replace('__', '_', $tag);
                        $tag = str_replace('__', '_', $tag);
                        $tag = str_replace('__', '_', $tag);
                        $tag = str_replace('__', '_', $tag);
                        if(!empty($tag)){
                            echo "<a href='tags.php?name=" . $tag . "'>" . strtoupper($tag) . '</a>';
                        }
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
    <hr class="custom-hr">
    <?php if (isset($_SESSION['user'])){ ?>
    <!-- Start Add Comment-->
    <div class="row">
        <div class="col-md-9 offset-3">
            <div class="add-comment">
                <h3>Add your comment</h3>
                <form action="<?php echo $_SERVER['PHP_SELF'] . '?Item_ID=' . $item['Item_ID']; ?>" method="post">
                    <textarea required class="form-control" name="comment" id="" cols="30" rows="4"></textarea>
                    <input class="btn btn-secondary accordion-button" type="submit" value="Add Comment">
                </form>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // $comment        = filter_content($_POST['comment']);
                    $comment = filter_string($_POST['comment']);
                    $Item_ID = $item['Item_ID'];
                    $userid = $_SESSION['uid'];
                    echo $comment;
                    if (!empty($comment)) {
                        $stmt = $con->prepare("INSERT INTO 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                comments 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                (comment, status, comment_date, item_id, user_id)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                values 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                (:zcomment, 0, now(), :zitem_id, :zuser_id)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                ");
                        $stmt->execute([
                            'zcomment' => $comment,
                            'zitem_id' => $Item_ID,
                            'zuser_id' => $userid,
                        ]);
                
                        if ($stmt) {
                            echo '<div class="alert alert-success text-center"> <i class="fa-solid fa-thumbs-up"></i> Comment Added  <i class="fa-solid fa-check"></i></div>';
                        }
                    }
                }
                
                ?>
            </div>
        </div>
    </div>
    <!-- End Add Comment-->
    <?php }else{ 
    echo "<a href='login.php'>Login</a> or <a href='login.php'>Register</a> to add comment";
    } ?>
    <hr class="custom-hr">

    <?php 
                    //Select all Comments for this item
        $stmt = $con->prepare(
                "SELECT comments.*, users.username AS Member
                FROM 
                    comments
                INNER JOIN 
                    users
                ON
                    users.userid = comments.user_id
                WHERE
                    item_id=?
                AND
                    status=1
                ORDER BY
                    c_id DESC
                    ");
        $stmt->execute(array($Item_ID));
        //Assign to variables
        $comments= $stmt->fetchAll();
                        foreach ($comments as $comment) { ?>
    <div class="comment-box">
        <div class="row">
            <div class="col-sm-2 text-center">
                <img class="img-responsive img-thumbnail center-block rounded-circle" src="images/avatar.jpg"
                    alt="User Image">
                <?php echo $comment['Member']; ?>
            </div>
            <div class="col-sm-10 d-flex justify-content align-items-center">
                <p class="lead">
                    <?php echo $comment['comment']; ?>
                </p>
            </div>
        </div>
    </div>
    <hr class="custom-hr">
    <?php } ?>
</div>
<?php
}else{
    
    echo'<div class="container">';
    $errMsg= "No Item with this ID Or waiting for Approval";
    redirectToHome($errMsg, 6,"danger",'back');        
    echo '</div>';
}
include $tpl. "footer.php";
?>
