<?php
session_start();
$noNavbar='';
$pageTitle='Login';

if(isset($_SESSION['username'])){
    header("Location:dashboard.php"); // redirect to dashboard page
}
include 'init.php';


if($_SERVER['REQUEST_METHOD'] == 'POST'){
$username= $_POST['user'];
$password= $_POST['pass'];
$hashedPass= sha1($password);
// echo $username . " - " . $password . ' '. $hashedPass;
// check if user exists

$stmt = $con->prepare("SELECT
                            userId, username, password
                        FROM
                            users
                        WHERE
                            username = ? 
                        AND 
                            password = ?
                        AND 
                            groupId = 1
                        LIMIT 1
                            ");
                            
                            
$stmt->execute(array($username, $hashedPass));
$row=$stmt->fetch();
$count = $stmt->rowCount();
// echo $count;
// if count > 0 this means that the record was found
if ($count > 0){
// echo " Welcome, ". $username;
$_SESSION['username'] = $username; // Register seesion username
$_SESSION['ID'] = $row['userId']; // Register seesion  ID
header("Location:dashboard.php"); // redirect to dashboard page
print_r($row);
exit();

}else{
    // echo "Sorry, your login data are incorrect."; // commented to be modified
}
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="login">
    <h4 class="text-center">Admin Login</h4>
<input class="form-control input-lg" type="text" name="user" placeholder="Username" autocomplete="off" id=""/>
<input class="form-control input-lg" type="password" name="pass" placeholder="Password" autocomplete='new-password'/>
<input class="btn btn-primary btn-block" type="submit" value="Login"/>
</form>



<?php
include $tpl. "footer.php";
?>