<?php
session_start();
if (isset($_SESSION['username'])) {
    $pageTitle = 'Members';
    include 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    //Start Manage Page
    if ($do == 'Manage') {  //Manage Members Page
            // $query="";
        if(isset($_GET['pending'])){
            // $query="AND regStatus =0";
            $members=getSqlData('*', 'users', "where groupID !=1 AND regStatus !=1", 'userid', 'ASC');
        }else{
            $members=getSqlData('*', 'users', 'where groupID !=1', 'userid', 'ASC');
        }
        
        //Select all NORMAL users NOT ADMINs
        // $stmt = $con->prepare("SELECT * FROM users WHERE groupID !=1 $query");
        // $stmt->execute();
        //Assign to variables
        // $rows= $stmt->fetchAll();
        ?>
<h1 class="text-center"> Manage Members</h1>
<div class="container">
    <a href="members.php?do=Add" class="btn btn-primary form-control"> <i class="fa fa-plus"></i> New Member</a>
    <div class="card group-header">
        <h2 class="text-center ">Members</h2>
    </div>
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered table-striped table-hover">
            <tr>
                <td>#</td>
                <td>#ID</td>
                <td>Avatar</td>
                <td>Username</td>
                <td>Email</td>
                <td>Full Name</td>
                <td>Register Date</td>
                <td>Control</td>
            </tr>
            <?php
            foreach ($members as $member) {
                $i = array_search($member, $members) + 1;
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td>' . $member['userid'] . '</td>';
                echo '<td>' . $member['username'] . '</td>';
                if(empty($member['avatar'])){
                    echo'<td><img class="img-responsive img-fluid img-thumbnail" src="uploads/avatars/avatar.jpg" alt="avatar"></td>';
                }else{
                    echo'<td><img class="img-responsive img-fluid img-thumbnail" src="uploads/avatars/'. $member['avatar'] . '" alt="avatar"></td>';
                }
                echo '<td>' . $member['email'] . '</td>';
                echo '<td>' . $member['fullName'] . '</td>';
                echo '<td>' . $member['regDate'] . '</td>';
                echo '<td>';
                if ($member['regStatus'] == 0) {
                    echo "<a href='members.php?do=Activate&userId=" . $member['userid'] . "' class='btn btn-info activate'><i class='fa-solid fa-check'></i> </a> ";
                } 
                echo "<a href='members.php?do=Edit&userId=" . $member['userid'] . "' class='btn btn-success'><i class='fa fa-edit'></i> </a> ";
                echo "<a href='members.php?do=Delete&userId=" . $member['userid'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> </a>";
                echo '</td></tr>';
                $i += 1;
            }
            ?>
        </table>
    </div>
</div>

<?php
$admins=getSqlData('*', 'users', 'where groupID =1', 'userid', 'ASC');
// $stmt_ad = $con->prepare('SELECT * FROM users WHERE groupID =1');
// $stmt_ad->execute();
//Assign to variables
// $rows_ad = $stmt_ad->fetchAll();
?>

<div class="container">
    <div class="card group-header">
        <h3 class="text-center card-header">Admins</h3>
    </div>
    <div class="table-responsive ">
        <table class="main-table text-center table table-bordered table-striped table-hover">
            <tr>
                <td>#</td>
                <td>#ID</td>
                <td>Username</td>
                <td>Avatar</td>
                <td>Email</td>
                <td>Full Name</td>
                <td>Register Date</td>
                <td>Control</td>
            </tr>
            <?php
            foreach ($admins as $admin) {
                $i = array_search($admin, $admins) + 1;
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td>' . $admin['userid'] . '</td>';
                echo '<td>' . $admin['username'] . '</td>';
                if(empty($admin['avatar'])){
                    echo'<td><img class="img-responsive img-fluid img-thumbnail" src="uploads/avatars/avatar.jpg" alt="avatar"></td>';
                }else{
                    echo'<td><img class="img-responsive img-fluid img-thumbnail" src="uploads/avatars/'. $admin['avatar'] . '" alt="avatar"></td>';
                }
                echo '<td>' . $admin['email'] . '</td>';
                echo '<td>' . $admin['fullName'] . '</td>';
                echo '<td>' . $admin['regDate'] . '</td>';
                echo '<td>';
                if ($admin['regStatus'] == 0) {
                    echo "<a href='members.php?do=Activate&userId=" . $admin['userid'] . "' class='btn btn-info activate'><i class='fa-solid fa-check'></i> </a> ";
                }
                echo "<a href='members.php?do=Edit&userId=" . $admin['userid'] . "' class='btn btn-success'><i class='fa fa-edit'></i> </a> ";
                echo "<a href='members.php?do=Delete&userId=" . $admin['userid'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> </a>";
                echo '</td></tr>';
                $i += 1;
            }
            ?>
        </table>
    </div>
</div>
<?php

    }elseif ($do == 'pending') {  //Manage Members Page
        //Select all NORMAL users NOT ADMINs
        $stmt = $con->prepare("SELECT * FROM users WHERE regStatus !=1");
        $stmt->execute();
        //Assign to variables
        $rows= $stmt->fetchAll();
        ?>
<h1 class="text-center"> Pending Members</h1>
<div class="container">
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered table-striped table-hover">
            <tr>
                <td>#</td>
                <td>#ID</td>
                <td>Username</td>
                <td>Avatar</td>
                <td>Email</td>
                <td>Full Name</td>
                <td>Register Date</td>
                <td>Control</td>
            </tr>
            <?php
            foreach ($rows as $row) {
                $i = array_search($row, $rows) + 1;
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td>' . $row['userid'] . '</td>';
                echo '<td>' . $row['username'] . '</td>';
                if(empty($row['avatar'])){
                    echo'<td><img class="img-responsive img-fluid img-thumbnail" src="uploads/avatars/avatar.jpg" alt="avatar"></td>';
                }else{
                    echo'<td><img class="img-responsive img-fluid img-thumbnail" src="uploads/avatars/'. $row['avatar'] . '" alt="avatar"></td>';
                }
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['fullName'] . '</td>';
                echo '<td>' . $row['regDate'] . '</td>';
                echo '<td>';
                if ($row['regStatus'] == 0) {
                    echo "<a href='members.php?do=Activate&userId=" . $row['userid'] . "' class='btn btn-info activate'><i class='fa-solid fa-check'></i> Activate</a> ";
                } else {
                    echo "<a  disabled  class='btn btn-secondary ' disabled><i class='fa-solid fa-check'></i> Activated</a> ";
                }
                echo "<a href='members.php?do=Edit&userId=" . $row['userid'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a> ";
                echo "<a href='members.php?do=Delete&userId=" . $row['userid'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                echo '</td></tr>';
                $i += 1;
            }
            ?>
        </table>
    </div>
</div>

<?php









    } elseif ($do == 'Add'){   // Add Members Page
        ?>
<h1 class="text-content text-center"><?php echo lang('Add Member'); ?></h1>
<div class="container">
    <form action="?do=Insert" class="form-horizontal" method="POST" enctype="multipart/form-data">
        <!-- Start Username Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><?php echo lang('username'); ?></span>
            <input class="form-control input-lg" type="text" name="username" required="required" 
                placeholder="Enter your Username for login">
        </div>
        <!-- End Username Field -->
        <!-- Start Password Field -->
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><?php echo lang('password'); ?></span>
            <input class="form-control input-lg password" type="password" name="password" autocomplete="off"
                placeholder="Enter your password (Must be complex)" required="required">
            <i class="show-pass fa fa-eye"></i>
        </div>
        <!-- End Password Field -->
        <!-- Start Email Field -->
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><?php echo lang('email'); ?></span>
            <input class="form-control input-lg" type="email" name="email" required="required"
                placeholder="name@example.com - (Must be Valid)">
        </div>
        <!-- End Email Field -->
        <!-- Start Full Name Field -->
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><?php echo lang('fullName'); ?></span>
            <input class="form-control input-lg" type="text" name="fullName" required="required"
                placeholder="Your Full Name (Will appear in all pages.)">
        </div>
        <!-- End Full Name Field -->
        <!-- Start Picture Field -->
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Picture</span>
            <input class="form-control input-lg" type="file" name="avatar" required="required">
        </div>
        <!-- End Picture Field -->
        <!-- Start Button Field -->
        <div class="input-group mb-3">
            <input class="btn btn-primary form-control" type="submit" value="Submit Data">
        </div>
        <!-- End Button Field -->
    </form>
</div>
<?php
    
} elseif ($do == 'Insert') { //Insert Page

    echo " <h1 class='text-content text-center'>". lang('Update Member'). "</h1>";
    echo " <div class='container'>";
    //Avatar Upload Variables
    $avatarName =$_FILES['avatar']['name'];
    $avatarName = trim(                     $avatarName);
    $avatarName = str_replace(' ', '_',     $avatarName);
    $avatarName = str_replace('__', '_',    $avatarName);
    $avatarName = str_replace('__', '_',    $avatarName);
    $avatarName = str_replace('__', '_',    $avatarName);
    $avatarName = str_replace('__', '_',    $avatarName);
    
    $avatarSize =$_FILES['avatar']['size'];
    $avatarTmp  =$_FILES['avatar']['tmp_name'];
    $avatarType =$_FILES['avatar']['type'];
    // allowed avatar extensions
    $tmp = explode('.', $avatarName);
    $file_extension = end($tmp);
    $avatarAllowedExtensions=array("jpg","png","gif","jpeg");
    $avatarExtension=strtolower($file_extension);
    // $avatarExtension=strtolower(end(explode('.',$avatarName)));
    
    
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {   // Get variables from Form
        $user = $_POST['username'];
        $email = $_POST['email'];
        $fullName = $_POST['fullName'];
        $password = $_POST['password'];
        $check = checkItem("username", "users", $user);
        
        if($check > 0){
            $errMsg= '<strong>'.$check. '</strong> Record with same username already exists.';
            redirectToHome($errMsg, 4,"info",'back');
            $errMsg='No records have been updated';
            redirectToHome($errMsg, 4,"danger",'back');
        }else{
            $formErrors=array();
            if(empty($user))  {$formErrors[]  ='Username Can not be empty';}
            if(empty($email)) {$formErrors[]  ='Email Can not be empty';}
            if(empty($fullName)) {$formErrors[]  ='Full Name Can not be empty';}
            if(!empty($avatarName)&& !in_array($avatarExtension,$avatarAllowedExtensions)){$formErrors[]  ='Not Allowed Extension';}
            if(empty($avatarName)){$formErrors[]  ='No Picture uploaded';}
            if($avatarSize>4194304){$formErrors[]  ='File is larger than 4 MB';}
                
            foreach($formErrors as $error){echo '<div class="alert alert-danger">'. $error . '</div>';}
            if(empty($formErrors)){
                $avatar = $user."_" .date('_Y_m_d_H_i_s.').$avatarExtension;
                // echo $avatar;
                move_uploaded_file($avatarTmp,"uploads\avatars\\".$avatar);
                //Insert New user in database 
                
                $password = sha1($_POST['password']);
                $stmt= $con->prepare("  INSERT INTO 
                                        users (username, password, email, fullName,avatar) 
                                        VALUES(:Iusername, :Ipassword, :Iemail, :IfullName, :Iavatar)");
                $stmt->execute(array(
                    'Iusername'     =>$user      ,
                    'Ipassword'     =>$password  ,
                    'Iemail'        =>$email     ,
                    'IfullName'     =>$fullName,
                    'Iavatar'       =>$avatar,
                    
                ));
                $errMsg= "<strong>".$stmt->rowCount(). "</strong> record have been updated.";
                redirectToHome($errMsg, 5,"success",'members');
                
            }
        }
    } else {
                $errMsg= "You can't be here directly";
                redirectToHome($errMsg, 400,"danger",'members');
            }
        echo "</div>" ;
            
} elseif ($do == 'Edit') { //Edit Page
        //check id Get request userId is Numeric & Get the Integer Value of it
        $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0;
        // Select all data on this id
        $stmt = $con->prepare("SELECT * FROM  users  WHERE userId=?   LIMIT 1");
        //execute query
        $stmt->execute(array($userId));
        //fetch data
        $row = $stmt->fetch();
        // the row count
        $count = $stmt->rowCount();
        // if there is such id show the form
        if ($stmt->rowCount() > 0) { 
            //apply the code if there is Id with input data.
            ?>

<h1 class="text-content text-center"><?php echo lang('Edit Member'); ?></h1>
<div class="container">
    <form action="?do=Update" class="form-horizontal" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="userId" value="<?php echo $userId; ?>">
        <!-- Start Username Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><?php echo lang('username'); ?></span>
            <input class="form-control input-lg disable" type="text" name="username" required="required" autocomplete="off"
                value="<?php echo $row['username']; ?> ">
        </div>
        <!-- End Username Field -->
        <!-- Start Password Field -->
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><?php echo lang('password'); ?></span>
            <input class="form-control input-lg" type="password" name="password" autocomplete="off"
                placeholder="Leave Blank if you don't want to change." value="">
            <input type="hidden" name="oldpassword" value="<?php echo $row['password']; ?>">
        </div>

        <!-- End Password Field -->
        <!-- Start Email Field -->
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><?php echo lang('email'); ?></span>
            <input class="form-control input-lg" type="email" name="email" required="required"
                placeholder="name@example.com" value="<?php echo $row['email']; ?>">
        </div>
        <!-- End Email Field -->
        <!-- Start Full Name Field -->
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1"><?php echo lang('fullName'); ?></span>
            <input class="form-control input-lg" type="text" name="fullName" value="<?php echo $row['fullName']; ?>">
        </div>
        <!-- End Full Name Field -->
                <!-- Start Picture Field -->
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Picture</span>
            <input class="form-control input-lg" type="file" name="avatar">
        </div>
        <!-- End Picture Field -->
        <!-- Start Button Field -->
        <div class="input-group mb-3">
            <input class="btn btn-primary form-control" type="submit" value="Save">
        </div>
        <!-- End Button Field -->
    </form>
</div>
<?php
              }      // if there is no such id show error message
} elseif ($do == 'Update') {
    echo " <h1 class='text-content text-center'>". lang('Update Member'). "</h1>";
    echo " <div class='container'>";
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Get variables from Form
                    $id = $_POST['userId'];
                    $user = $_POST['username'];
                    $email = $_POST['email'];
                    $fullName = $_POST['fullName'];
                    $password = sha1($_POST['password']);
                    if(!empty($_POST['password'])){
                        $password = sha1($_POST['password']);
                    }else{
                        $password = $_POST['oldpassword'];
                    }
                    $formErrors=array();
                if(empty($user))  {$formErrors[]  ='Username Can not be empty';}
                if(empty($email)) {$formErrors[]  ='Email Can not be empty';}
                if(empty($fullName)) {$formErrors[]  ='Full Name Can not be empty';}
                if(!empty($avatarName)&& !in_array($avatarExtension,$avatarAllowedExtensions)){$formErrors[]  ='Not Allowed Extension';}
                if(empty($avatarName)){$formErrors[]  ='No Picture uploaded';}
                if(empty($avatarName)){$formErrors[]  ='No Picture uploaded';}

                foreach($formErrors as $error)
                {echo '<div class="alert alert-danger">'. $error . '</div>';}
        if(empty($formErrors)){
            $stmt2= $con->prepare("SELECT * FROM users WHERE username=? AND userId !=?");
            $stmt2->execute(array($user,$id));
            if($stmt2->rowcount() == 1){
                $errMsg= "User Exist";
                redirectToHome($errMsg, 6,"danger",'back');
            }else{
                
                $stmt= $con->prepare("UPDATE users SET  username=?, email=?, fullName=?,password=?  WHERE userId=?");
                $stmt->execute(array($user, $email,$fullName,$password,$id));
                $errMsg= "<strong>".$stmt->rowCount(). "</strong> record have been updated.";
                redirectToHome($errMsg, 5,"success",'members');
                
                
            }
        }
            } else {
                            $errMsg= "You can't be here directly";
                            redirectToHome($errMsg, 6,"danger",'back');
                        }
    echo "</div>";
        }elseif ($do == 'Delete'){//Delete Member Page
            echo'<h1 class="text-center">Activate Member</h1>';
            echo '<div class="container">';
            //check id Get request userId is Numeric & Get the Integer Value of it
            $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0;
            // Select all data on this id
            $stmt = $con->prepare("SELECT * FROM  users  WHERE userId=?   LIMIT 1");
            //execute query
            $stmt->execute(array($userId));
            // the row count
            $count = $stmt->rowCount();
            // if there is such id show the form
            if ($stmt->rowCount() > 0) {//apply the code if there is Id with input data.
                $stmt = $con->prepare("DELETE FROM users WHERE userId= :IuserId");
                $stmt->bindParam(":IuserId",$userId);
                $stmt->execute();
                $errMsg=$stmt->rowCount(). "record have been Deleted";
                        redirectToHome($errMsg, 6,"danger",'back');
                    } // if there is no such id show error message
            echo '</div>';
    }elseif ($do == 'Activate'){//Activate Member Page
        echo'<h1 class="text-center">Activate Member</h1>';
        echo '<div class="container">';
    //check id Get request userId is Numeric & Get the Integer Value of it
    $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0;
    
    $check= checkItem('userId', 'users', $userId); // check if user exists
    
    if ($check > 0){
        $stmt = $con->prepare("UPDATE users SET regStatus = 1 WHERE userId=?");
        //execute query
        $stmt->execute(array($userId));
        $errMsg= 'Member has been Activated Successfuly';
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
};
