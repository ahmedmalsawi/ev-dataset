<?php
session_start();
$pageTitle="Login/Signup";
if(isset($_SESSION['user'])){header("Location:index.php");}; // redirect to Home page
include 'init.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if(isset($_POST['login'])){
        $user= $_POST['username'];
        $pass= $_POST['password'];
        $hashedPass= sha1($pass);
        $stmt = $con->prepare("SELECT  userid, username, password FROM users WHERE  username = ? AND password = ?");
        $stmt->execute(array($user, $hashedPass));
        $get=$stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0){
            $_SESSION['user'] = $user;
            $_SESSION['uid'] = $get['userid'];
            header("Location:index.php"); // redirect to dashboard page
            exit();
            }
        }else{
            $postUser=$_POST['username'];
            $postPass= $_POST['password'];
            $postPass2= $_POST['password2'];
            $postEmail= $_POST['email'];
            $postfullName= $_POST['fullName'];
        $formErrors=array();
        if (isset($postUser)){
            $filteredusername= filter_content($postUser);
            if(strlen($filteredusername)<4){
                $formErrors[]="Username Can't be less than 4 characters";
            }
        }
        if (isset($postPass)&&isset($_POST['password2'])){
            $filteredpassword= filter_content($postPass);
            $filteredpassword2= filter_content($postPass2);
            if(empty($postPass)){
                $formErrors[]="Password Can't be Empty.";
            }
            if(strlen($filteredpassword)<4){
                $formErrors[]="Password Can't be less than 4 characters";
            }
            if(sha1($filteredpassword) !== sha1($filteredpassword2)){
                $formErrors[]="Password should be the same !";
            }
        }
        if (isset($postEmail)){
                $filteredemail= filter_content($postEmail);
            if(filter_var($postEmail,FILTER_VALIDATE_EMAIL)!= true){
                $formErrors[]="Email format is wrong";
            };
        }
        
        if (isset($postfullName)){
            $filteredfullName= filter_content($postfullName);
            if(strlen($filteredfullName)<8){
                $formErrors[]="Full Name Can't be less than 8 characters";
            }
        }
        
        if(empty($formErrors)){
            
            $check=checkItem("username", "users", $filteredusername);
            if($check == 1) {
                    $formErrors[]="This user already exist.";
                }else{
                    // $formErrors[]="User is added Successfully.";
                    $stmt= $con->prepare("  INSERT INTO 
                        users (username, password, email, fullName, regDate, regStatus) 
                        VALUES(:Iusername, :Ipassword, :Iemail, :IfullName, now(),0)");
                    $stmt->execute(array(
                        'Iusername'=>$postUser      ,
                        'Ipassword'=>sha1($postPass)  ,
                        'Iemail'=>$postEmail     ,
                        'IfullName'=>$postfullName,
                    ));
                    //Success message
                    $successMsg = "User is added Successfully.";
                }
        }
    }
}
?>
<div class="container login-page">
    <h1 class="text-center">
        <span data-class="login" class="active">Login</span>
        | <span data-class="signup">Signup</span>
    </h1>
    <!-- Start login Form -->
    <form class="login-form login active" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="input-container ">
            <input class="form-control" type="text" name="username" placeholder="Username" required="required">
        </div>
        <div class="input-container ">
            <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Password"required="required">
        </div>
            <input class="btn btn-success btn-block" type="submit" value="Login" name="login"/>
    </form>
    <!-- End login Form -->
    <!-- Start Signup Form -->
    <form class="signup-form signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="input-container">
            <input 
            pattern=".{8,16}"
            title="Enter 8 to 16 characters."
            class="form-control" type="text" name="username" placeholder="Username" required="required">
        </div>
        <div class="input-container">
            <input minlenght='8' class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Password here" required="required">
            </div>
            <div class="input-container">
                <input minlenght='8' class="form-control" type="password" name="password2" autocomplete="new-password" placeholder="Password one more time" required="required">
            </div>
            <div class="input-container">
                <input class="form-control" type="email" name="email" placeholder="E-mail for activation" required="required">
            </div>
            <div class="input-container">
                <input minlenght='8' class="form-control" type="text" name="fullName" placeholder="Full Name" required="required">
            </div>
            <input class="btn btn-success" type="submit" value="Signup" name="signup"/>
        </form>
        <!-- End Signup Form -->
        <div class="errors text-center">
                <?php 
                    if(!empty($formErrors)){
                        foreach ($formErrors as $error) {
                            echo "<div class='msg err'>".$error."</div>";
                            }
                        }
                        if (isset($successMsg)){
                            echo "<div class='msg sucsess'>".$successMsg."</div>";
                    }
                ?>
        </div>
</div>









<?php
include $tpl. "footer.php";
?>