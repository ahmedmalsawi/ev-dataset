<?php
ob_start();
session_start();
if (isset($_SESSION['username'])) {
    // echo 'You are not authorized to access this page.';
    $pageTitle = 'Dashboard';
    include 'init.php';
    // Dashboard contents
    $stmt2=$con->prepare('SELECT COUNT(userId) FROM users');
    $stmt2->execute();
    $rwoCount = $stmt2->fetchColumn();
    $usersLimit=5;
    $itemsLimit=5;
    $commentsLimit=10;
    $latestUsers = getLatestRecords('*','users', $usersLimit, 'userId', 'DESC');
    $latestItems = getLatestRecords('*','items', $itemsLimit, 'Item_ID', 'DESC');
    $latestcomments = getLatestRecords('*','comments', $commentsLimit, 'c_id', 'DESC','INNER JOIN items ON items.Item_ID = comments.item_id INNER JOIN users ON items.Member_ID = users.userid');
    ?>
    <div class="container text-center home-stats">
        <h1> Dashboard</h1>  
        <div class="row">
            <div class="col-md-3">
                <div class="stats st-members text-center">
                <i class="fa fa-users icon"></i>
                    <div class="info">
                        Total Members
                        <span ><a  href="members.php"><?php echo countItems('regStatus','users'); ?></a></span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 ">
                <div class="stats st-pending">
                    <i class="fa fa-user-plus icon add"></i>
                    <div class="info">
                        Pending Members
                        <span><a  href="members.php?do=pending"><?php echo countPending('regStatus', 'users','regStatus=0'); ?></a></span>
                    </div>
                </div>
                </div>
                <div class="col-md-3 ">
                    <div class="stats st-cats">
                        <i class="fa fa-users icon"></i>
                        <div class="info">
                            Active Categories
                            <span><a  href="Categories.php?do=Manage"><?php echo countPending('Visibility', 'categories','Visibility=1'); ?></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats st-items">
                        <i class="fa fa-tags icon"></i>
                        <div class="info">
                            Total Items
                            <span><a  href="items.php?do=Manage"><?php echo countPending('Item_ID', 'items','Status>0'); ?></a></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="stats st-pending">
                        <i class="fa fa-tag icon add"></i>
                        <div class="info">
                            Pending Items
                            <span><a  href="items.php?do=pending"><?php echo countPending('regStatus', 'items','regStatus=0'); ?></a></span>
                        </div>
                    </div>
                    </div>
                <div class="col-md-3">
                    <div class="stats st-comments">
                        <i class="fa fa-comments icon"></i>
                        <div class="info">
                            Pending Comments
                            <span><a  href="comments.php?do=Manage"><?php echo countPending('c_id', 'comments','Status=0'); ?></a></span>
                        </div>
                </div>
            </div>
                <div class="col-md-3">
                    <div class="stats st-comments">
                        <i class="fa fa-comments icon"></i>
                        <div class="info">
                            Total Comments
                            <span><a  href="comments.php?do=Manage"><?php echo countPending('c_id', 'comments','Status>0'); ?></a></span>
                        </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container latest2 ">
                <!-- Start Latest items -->
        <div class="row">
            <div class="col-sm-6">
                <div class="panel card ">
                    <div class="card-header title "> 
                        <div class="header pull-right">
                            <i class="fa fa-users"></i>
                            Latest <?php echo $usersLimit; ?> Registered Users 
                        </div>
                        <div class="toggle-info pull-right">
                        <i class="fa fa-plus fa-lg"></i>
                        </div>
                    </div>
                    <div class="card-body body panel-body"> 
                        <ul class="list-unstyled latest-users">
                            <?php  
                                foreach ($latestUsers as $user){ 
                                    echo "<li>";
                                        echo "<div class='container member-container'>"; 
                                                echo "<div class='name'>";
                                                echo $user['fullName']; 
                                                echo "</div>"; 
                                                echo "<div class='buttons'>";
                                                    if ($user['regStatus'] == 0) {
                                                        echo "<a href='members.php?do=Activate&userId=" . $user['userid'] . "' class='btn btn-info activate pull-right'><i class='fa-solid fa-check'></i></a> ";
                                                    } 
                                                    echo "<a href='members.php?do=Edit&userId=" . $user['userid'] . "' class='btn btn-success pull-right'><i class='fa fa-edit'></i></a> ";
                                                    echo "<a href='members.php?do=Delete&userId=" . $user['userid'] . "' class='btn btn-danger confirm pull-right'><i class='fa fa-close'></i></a>";
                                                echo "</div>"; 
                                                echo "</div>"; 
                                            echo "</li>";
                                }
                            ?>
                            </ul>
                            </div>
                </div>
                
            </div>
            
            
        <div class="col-sm-6">
            <div class="panel card">
                <div class="card-header title"> 
                    <div class="header pull-right">
                        <i class="fa fa-tag"></i>
                        Latest  <?php echo $itemsLimit; ?> Items 
                    </div>
                    <div class="toggle-info pull-right">
                        <i class="fa fa-plus fa-lg"></i>
                    </div>
                    </div>
                    <div class="card-body body panel-body"> 
                        <ul class="list-unstyled latest-items">
                            <?php  
                                foreach ($latestItems as $item){ 
                                    echo "<li>";
                                        echo "<div class='container items-container'>"; 
                                                echo "<div class='name'>";
                                                echo $item['Name']; 
                                                echo " <span class='label btn-primary'>".$item['Price']." SAR</span>"; 
                                                echo "</div>"; 
                                                echo "<div class='buttons'>";
                                                    echo " <span class='label btn-info'>".$item['Add_Date']."</span>"; 
                                                    if ($item['regStatus'] == 0) {
                                                        echo "<a href='items.php?do=Approve&Item_ID=" . $item['Item_ID'] . "' class='btn btn-info activate pull-right'><i class='fa-solid fa-check'></i></a> ";
                                                    } 
                                                    echo "<a href='items.php?do=Edit&Item_ID=" . $item['Item_ID'] . "' class='btn btn-success pull-right'><i class='fa fa-edit'></i></a> ";
                                                    echo "<a href='items.php?do=Delete&Item_ID=" . $item['Item_ID'] . "' class='btn btn-danger confirm pull-right'><i class='fa fa-close'></i></a>";
                                                echo "</div>"; 
                                                echo "</div>"; 
                                            echo "</li>";
                                }
                                    ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
                <!-- Start Latest Comments -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel card ">
                    <div class="card-header title "> 
                        <div class="header pull-right">
                            <i class="fa fa-comments"></i>
                            Latest  <?php echo $commentsLimit; ?> Comments 
                        </div>
                        <div class="toggle-info pull-right">
                        <i class="fa fa-plus fa-lg"></i>
                        </div>
                    </div>
                    <div class="card-body body panel-body"> 
                        <?php
                            foreach ($latestcomments as $comment){
                                echo "<div class='comment-box'>";
                                    echo "<span class='member-m'>";
                                        echo $comment['username'];
                                    echo "</span>";
                                    echo "<p class='member-c'>";
                                        echo '[<span class="item">' . $comment['Name'] .'</span>] ';
                                        echo $comment['comment'];
                                        echo "</p>";
                                echo "</div>";
                            }
                            
                        ?>
                    </div>
                </div>
            </div>
            <!-- End Latest Comments -->
    </div>
    <?php

    include $tpl . 'footer.php';
} else {
    header('Location:index.php'); // redirect to dashboard page
    exit();
}

ob_end_flush();