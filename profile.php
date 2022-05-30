<?php
session_start();
$pageTitle="Profile";
include 'init.php';

if(!isset($_SESSION['user'])){
    header("Location:login.php"); // redirect to Home page
}
$getUser = $con->prepare("SELECT * FROM users WHERE username=? ");
$getUser->execute(array($sessionUser));
$info= $getUser->fetch();

$itemsQuery = "WHERE Member_ID=".$info['userid'];
$items = getData('*', 'items', 1000,'item_ID', 'DESC',$itemsQuery);
$commentsQuery = "INNER JOIN  items  ON  items.Item_ID = comments.item_id WHERE user_id=".$info['userid'];
$comments = getData('comments.*, items.Name', 'comments', 1000,'item_ID', 'DESC',$commentsQuery);

?>
<h1 class="text-center">My Profile</h1>

<div id="my-profile" class="information block">
    <div class="container">
    <div class="panel panel-primary card">
        <div class="panel-heading card-header ">  My Information </div>
        <div class="panel-body card-body">
            <ul class="list-unstyled">
                <li>
                <i class="fa fa-unlock-alt fa-fw"></i>
                <span>Username : </span>
                <?php echo $info['username'];?> 
            </li>
            <li>
                    <i class="fa fa-envelope-open fa-fw"></i>
                    <span>Email : </span>
                    <?php echo $info['email'];?> 
                </li>
                <li>
                    <i class="fa fa-user fa-fw"></i>
                    <span>Full Name : </span>
                    <?php echo $info['fullName'];?> 
                </li>
                <li>
                    <i class="fa fa-calendar fa-fw"></i>
                    <span>Register Date : </span>
                    <?php echo $info['regDate'];?> 
                </li>
                <li>
                    <i class="fa fa-tags fa-fw"></i>
                    <span>Favourite Category : </span>
                    <?php echo $info['fullName'];?> 
                </li>
            </ul> 
            <a class="btn btn-secondary container info-edit" href="#"> Edit Information</a>
        </div>
    </div>
    </div>
</div>
<div id="my-items" class="ads block">
    <div class="container">
        <div class="panel card-primary card my-items">
            <div class="panel-heading btn-primary card-header ">  My Items </div>
            <div class="panel-body card-body">
                <div class="row">
                    <?php
                if(!empty($items)){
                    foreach($items as $item){ ?>
                            <div class="col col-sm-6 col-md-3">
                                <div class="card h-100">
                                    <div class="card card-title">
                                        <div class="img-thumbnail item-box <?php if($item['regStatus'] == 0){ echo"approve-effect";} ?>">
                                            <span class="price-tag">
                                                <?php echo  $item['Price']; ?>
                                                SR
                                            </span>
                                            <img class="img-responsive img-fluid img-thumbnail" src="images/avatar2.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="panel-body card-body">
                                    <div class="caption <?php if($item['regStatus'] == 0){echo "approve-effect";} ?>">
                                        <h3> 
                                            <span class="item-label">
                                                <a class = "d-block text-center <?php
                                                    if($item['regStatus'] == 0){ echo"disabled-btn";} ?>" href="items.php?Item_ID=<?php
                                                    echo $item['Item_ID']; ?> "> <?php echo $item['Name']; ?>
                                                </a>
                                            </span>
                                        <?php
                                        if($item['regStatus'] == 0){
                                                echo"<span class='approve-status d-block text-center'>NOT APPROVED </span>";
                                                } ?>
                                        </h3>
                                        <p class="card-text text-wrap item-desc">
                                            <?php  echo $item['Description']; ?>
                                        </p>
                                        <div class="add-dated card-footer text-center link-dark">
                                            <?php  echo $item['Add_Date']; ?>
                                        </div>
                                </div>
                                </div>
                                </div>
                            </div>
                            <?php
                                        }
                                    }else{
                                        echo " <div class='container btn'> There are No items to show !!</div>";
                                        echo " <div><a class='container btn btn-secondary'href='#'>Add Item </a></div>";
                                    }
                                    ?>
            </div>
        </div>
    </div>
</div>
<div id="my-comments" class="latest-comments block">
    <div class="container">
    <div class="panel panel-primary card">
        <div class="panel-heading card-header  mb-3">  My Comments </div>
        <div class="panel-body card-body">
            <?php
                if(!empty($comments)){
                    foreach($comments as $comment){ ?>
                            <div class="comment-box">
                                <div class="row">
                                <div class="col-sm-3 text-center">
                                    <div class="comment-title">
                                        <img class="img-responsive img-thumbnail center-block rounded-circle" src="images/avatar.jpg" alt="User Image">
                                        <h4>
                                            <a class='btn btn-light' href="items.php?Item_ID=<?php echo $comment['item_id']; ?>">
                                                <?php  echo $comment['Name']; ?>
                                            </a>
                                        </h4>
                                        <?php echo $comment['comment_date']; ?>
                                    </div>
                                </div>
                                <div class="col-sm-9 d-flex justify-content align-items-center">
                                    <div class="caption">
                                        <p class="lead">
                                            <?php echo $comment['comment']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                                        <hr class="custom-hr">
                    <?php
                    }
                }else{
                    echo " <div class='container btn empty-msg'> There are No Comments to show !!</div>";
                    echo " <div><a class='container btn btn-secondary'href='#'>Add Comment </a></div>";
                } 
                ?>
        </div>
    </div>
</div>
</div>













<?php
include $tpl. "footer.php";
?>