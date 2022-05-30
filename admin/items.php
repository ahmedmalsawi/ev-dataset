<?php

// Manage Categories Page
ob_start();

session_start();
if (isset($_SESSION['username'])) {
    $pageTitle = 'Items';
    include 'init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] :"Manage";
    if($do == "Manage"){
    
        //Select all NORMAL users NOT ADMINs
        // $stmt = $con->prepare("SELECT * FROM items");
        $stmt = $con->prepare(
            "SELECT 
                items.*, categories.Name AS Cat_Name, users.username AS User_Name 
            FROM 
                items
            INNER JOIN 
                categories 
            ON 
                categories.ID = items.Cat_ID
            INNER JOIN 
                users 
            ON 
                users.userid = items.Member_ID");
        $stmt->execute();
        //Assign to variables
        $items= $stmt->fetchAll();
        
        $getUser=array();
        ?>
<h1 class="text-center"> Manage Items</h1>
<div class="container">
    <a href="items.php?do=Add" class="btn btn-primary form-control"> <i class="fa fa-plus"></i> New item</a>
    <div class="card group-header">
        <h2 class="text-center ">Items</h2>
    </div>
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered table-striped table-hover">
            <tr>
                <td>#</td>
                <td>#ID</td>
                <td>Category</td>
                <td>Name</td>
                <td>Description</td>
                <td>Price</td>
                <td>Creation Date</td>
                <td>Creation User</td>
                <td>Control</td>
            </tr>
            <?php
            foreach ($items as $item) {
                $i = array_search($item, $items) + 1;
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td>' . $item['Item_ID'] . '</td>';
                echo '<td>' . $item['Cat_Name'] . '</td>';
                echo '<td>' . $item['Name'] . '</td>';
                echo '<td>' . $item['Description'] . '</td>';
                echo '<td>' . $item['Price'] . '</td>';
                echo '<td>' . $item['Add_Date'] . '</td>';
                echo '<td>' . $item['User_Name'] . '</td>';
                echo '<td>';
                if ($item['regStatus'] == 0) {
                    echo "<a href='items.php?do=Approve&Item_ID=" . $item['Item_ID'] . "' class='btn btn-info activate'><i class='fa-solid fa-check'></i> Approve</a> ";
                }
                echo "<a href='items.php?do=Edit&Item_ID=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a> ";
                echo "<a href='items.php?do=Delete&Item_ID=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                echo '</td></tr>';
                $i += 1;
            }
            ?>
        </table>
    </div>
</div>

<?php

    
    
    
    }elseif($do == "Add"){
    ?>

<h1 class="text-content text-center">Add New Item</h1>
<div class="container items-form">
    <form action="?do=Insert" class="form-horizontal" method="POST">
        <!-- Start Name Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Item Name</span>
            <input class="form-control input-lg" type="text" name="Name" required="required"
                placeholder="Enter Item's Name">
        </div>
        <!-- End Name Field -->
        <!-- Start Description Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Description</span>
            <input class="form-control input-lg" type="text" name="Description" placeholder="Item's Description">
        </div>
        <!-- End Description Field -->
        <!-- Start Price Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Price</span>
            <input class="form-control input-lg" type="number" name="Price" required="required"
                placeholder="Item's Price">
        </div>
        <!-- End Price Field -->
        <!-- Start Country of Origin Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Origin Country</span>
            <input class="form-control input-lg" type="text" name="Country_Origin" required="required"
                placeholder="Manufacuring Country">
        </div>
        <!-- End Country of Origin Field -->
        <!-- Start Status Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Status</span>
            <div class="select">
                <select name="Status" required="required">
                    <option disabled selected class="dropdown-item" value="0">...</option>
                    <option class="dropdown-item" value="1">Yad Production</option>
                    <option class="dropdown-item" value="2">Trademark</option>
                    <option class="dropdown-item" value="3">Local Market</option>
                    <option class="dropdown-item" value="4">Gift</option>
                    <option class="dropdown-item" value="5">Old Stock</option>
                </select>
            </div>
        </div>
        <!-- End Status Field -->
        <!-- Start Members Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Member</span>
            <div class="select">
                <select name="member" required="required">
                    <option disabled selected class="dropdown-item" value="0">...</option>
                    <?php
                    $stmt = $con->prepare('SELECT * FROM users');
                    $stmt->execute();
                    $users = $stmt->fetchAll();
                    foreach ($users as $user) {
                        echo "<option value='" . $user['userid'] . "'>" . $user['username'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- End Members Field -->
        <!-- Start Catergories Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Catergory</span>
            <div class="select">
                <select name="category" required="required">
                    <option disabled selected class="dropdown-item" value="0">...</option>
                    <?php
                    $allCats = getSqlData('*', 'categories', 'where parent=0', 'ID', 'DESC');
                    foreach ($allCats as $cat) {
                        echo "<option value='" . $cat['ID'] . "'>" . ' <span class="maincatname">--- Main ---<span>' . $cat['Name'] . ' --- ' . '</option>';
                        $childCats = getSqlData('*', 'categories', "where parent={$cat['ID']}", 'ID', 'DESC');
                        foreach ($childCats as $child) {
                            echo "<option value='" . $child['ID'] . "'>" . '<span class="subcatname">--- Sub ---<span>' . $child['Name'] . '  ' . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- End Catergories Field -->
        <!-- Start Tags Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Tags</span>
            <input class="form-control input-lg" type="text" name="tags"
                placeholder="Seperate Tags with comma ( , ) or Tab">
        </div>
        <!-- End Tags Field -->

        <!-- Start Submit Button Field -->
        <div class="input-group mb-3">
            <input class="btn btn-primary form-control" type="submit" value="Add Item">
        </div>
        <!-- End Button Field -->
    </form>
</div>





<?php
    
    
    
    }elseif($do == "Insert"){
    
    
    echo " <h1 class='text-content text-center'>Update Item</h1>";
    echo " <div class='container'>";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {   // Get variables from Form
        $name               = $_POST['Name']            ;
        $description        = $_POST['Description']     ;
        $price              = $_POST['Price']           ;
        $country            = $_POST['Country_Origin']  ;
        $status             = $_POST['Status']          ;
        $member             = $_POST['member']          ;
        $category           = $_POST['category']        ;
        $tags                = $_POST['tags']           ;
        
        $formErrors=array();
        
        if(empty($name))    {$formErrors[]  ='Name Can not be empty';}
        if(empty($price))   {$formErrors[]  ='Price Can not be empty';}
        if(empty($country)) {$formErrors[]  ='Country Can not be empty';}
        if($status == 0)    {$formErrors[]  ='Status Can not be empty';}
        if($member == 0)    {$formErrors[]  ='Member Can not be empty';}
        if($category == 0)  {$formErrors[]  ='Category Can not be empty';}
        
        foreach($formErrors as $error){
            echo '<div class="alert alert-danger">'. $error . '</div>';
        }
        
        if(empty($formErrors)){
        
        /*
        */
        
        //CHECK IF item EXISTS IN database
            $check = checkItem("Name", "items", $name);
            if($check > 0){
                $errMsg= '<strong>'.$check. '</strong> Item with same name already exists.';
                redirectToHome($errMsg, 40,"info",'back');
            }else{
                    //Insert New item in database 
                    $stmt= $con->prepare(
                        "INSERT INTO items 
                            (Name, Description, Price, Country_Origin, Status, Member_ID, Cat_ID, Add_Date, tags) 
                        VALUES
                        (:Iname, :Idesc, :Iprice, :Icountry, :Istatus, :Imember, :Icat, now(), :Itags)
                                        ");
                    $stmt->execute(array(
                        'Iname'=>$name      ,
                        'Idesc'=>$description  ,
                        'Iprice'=>$price     ,
                        'Icountry'=>$country,
                        'Istatus'=>$status,
                        'Imember'=>$member,
                        'Icat'=>$category,
                        'Itags'=>$tags,
                    ));
                    
                    //Success message
                    if($stmt->rowCount() == 0){
                    $errMsg= "No records have been updated";
                    redirectToHome($errMsg, 4,"danger",'home');
                    }else{
                        $errMsg= $stmt->rowCount(). ' record have been updated.';
                    redirectToHome($errMsg, 4,"success",'back'); 
                    }
                }
        }
    } else {
                $errMsg= "You can't be here directly";
                redirectToHome($errMsg, 4,"danger",'home');
            }
        echo "</div>" ;
    
    }elseif($do == "Edit"){
    
        //check id Get request userId is Numeric & Get the Integer Value of it
        $Item_ID = isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID']) ? intval($_GET['Item_ID']) : 0;
        // Select all data on this id
        $stmt = $con->prepare("SELECT * FROM  items  WHERE Item_ID=? ");
        //execute query
        $stmt->execute(array($Item_ID));
        //fetch data
        $item = $stmt->fetch();
        // the row count
        $count = $stmt->rowCount();
        // if there is such id show the form
        if ($stmt->rowCount() > 0) { 
            //apply the code if there is Id with input data.
            ?>
<h1 class="text-content text-center">Edit Item</h1>
<div class="container items-form">
    <form action="?do=Update" class="form-horizontal" method="POST">

        <input type="hidden" name="Item_ID" value="<?php echo $Item_ID; ?>">
        <input type="hidden" name="Name_Old" value="<?php echo $Item_ID; ?>">

        <!-- Start Name Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Item Name</span>
            <input class="form-control input-lg" type="text" name="Name" required="required"
                placeholder="Enter Item's Name" value="<?php echo $item['Name']; ?>">
        </div>
        <!-- End Name Field -->
        <!-- Start Description Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Description</span>
            <input class="form-control input-lg" type="text" name="Description" value="<?php echo $item['Description']; ?>"
                placeholder="Item's Description">
        </div>
        <!-- End Description Field -->
        <!-- Start Price Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Price</span>
            <input class="form-control input-lg" type="number" name="Price" required="required"
                value="<?php echo $item['Price']; ?>" placeholder="Item's Price">
        </div>
        <!-- End Price Field -->
        <!-- Start Country of Origin Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Origin Country</span>
            <input class="form-control input-lg" type="text" name="Country_Origin" value="<?php echo $item['Country_Origin']; ?>"
                required="required" placeholder="Manufacuring Country">
        </div>
        <!-- End Country of Origin Field -->
        <!-- Start Status Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Status</span>
            <div class="select">
                <select name="Status" required="required">
                    <option class="dropdown-item" value="1" <?php if ($item['Status'] == 1) {
                        echo 'selected';
                    } ?>>
                        Yad Production</option>
                    <option class="dropdown-item" value="2" <?php if ($item['Status'] == 2) {
                        echo 'selected';
                    } ?>>
                        Trademark</option>
                    <option class="dropdown-item" value="3" <?php if ($item['Status'] == 3) {
                        echo 'selected';
                    } ?>>
                        Local Market</option>
                    <option class="dropdown-item" value="4" <?php if ($item['Status'] == 4) {
                        echo 'selected';
                    } ?>>
                        Gift</option>
                    <option class="dropdown-item" value="5" <?php if ($item['Status'] == 5) {
                        echo 'selected';
                    } ?>>
                        Old Stock</option>
                </select>
            </div>
        </div>
        <!-- End Status Field -->
        <!-- Start Members Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Member</span>
            <div class="select">
                <select name="member" required="required">
                    <?php
                    $stmt = $con->prepare('SELECT * FROM users');
                    $stmt->execute();
                    $users = $stmt->fetchAll();
                    foreach ($users as $user) {
                        echo "<option value='" . $user['userid'] . "'";
                        if ($item['Member_ID'] == $user['userid']) {
                            echo 'selected';
                        }
                        echo '>' . $user['username'] . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- End Members Field -->
        <!-- Start Catergories Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Catergory</span>
            <div class="select">
                <select name="category" required="required">
                    <?php
                    $allCats = getSqlData('*', 'categories', 'where parent=0', 'ID', 'DESC');
                    foreach ($allCats as $cat) {
                        echo "<option value='" . $cat['ID'] . "'>" . ' <span class="maincatname">--- Main ---<span>' . $cat['Name'] . ' --- ' . '</option>';
                        $childCats = getSqlData('*', 'categories', "where parent={$cat['ID']}", 'ID', 'DESC');
                        foreach ($childCats as $child) {
                            echo "<option value='" . $child['ID'] . "'>" . '<span class="subcatname">--- Sub ---<span>' . $child['Name'] . '  ' . '</option>';
                        }
                    }
                    // foreach ($allcats as $cat) {
                    //     echo "<option value='" . $cat['ID'] . "'";
                    //     if ($item['Cat_ID'] == $cat['ID']) {
                    //         echo 'selected';
                    //     }
                    //     echo '>' . $cat['Name'] . '</option>';
                    // }
                    ?>
                </select>
            </div>
        </div>
        <!-- End Catergories Field -->
        <!-- Start Tags Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Tags</span>
            <input class="form-control input-lg" type="text" name="tags" value="<?php echo $item['tags']; ?>"
                placeholder="Seperate Tags with comma ( , ) or Tab">
        </div>
        <!-- End Tags Field -->
        <!-- Start Button Field -->
        <div class="input-group mb-3">
            <input class="btn btn-primary form-control" type="submit" value="Save">
        </div>
        <!-- End Button Field -->
    </form>
    <?php
    $allComs = getSqlData('comments.*, users.username', 'comments', "INNER JOIN users ON comments.user_id=users.userid WHERE item_id={$Item_ID}", 'c_id', 'DESC');
    $alltags = getSqlData('items.*, users.username', 'items', "INNER JOIN users ON items.Member_ID=users.userid WHERE item_id={$Item_ID}", 'Item_ID', 'DESC');
    // $stmt = $con->prepare("SELECT comments.*, users.username FROM comments INNER JOIN users ON comments.user_id=users.userid WHERE item_id=?");
    // $stmt->execute([$Item_ID]);
    //Assign to variables
    // $rows = $stmt->fetchAll();
    ?>

    <div class="card group-header">
        <h2 class="text-center ">[<?php echo $item['Name']; ?>] Comments</h2>
    </div>
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered table-striped table-hover">
            <tr>
                <td>#</td>
                <td>Comment</td>
                <td>Username</td>
                <td>Date</td>
                <td>Control</td>
            </tr>
            <?php
            foreach ($allComs as $com) {
                $i = array_search($com, $allComs) + 1;
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td>' . $com['comment'] . '</td>';
                echo '<td>' . $com['username'] . '</td>';
                echo '<td>' . $com['comment_date'] . '</td>';
                echo '<td>';
                if ($com['status'] == 0) {
                    echo "<a href='comments.php?do=Approve&c_id=" . $com['c_id'] . "' class='btn btn-info activate'><i class='fa-solid fa-check'></i> Approve</a> ";
                }
                echo "<a href='comments.php?do=Edit&c_id=" . $com['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a> ";
                echo "<a href='comments.php?do=Delete&c_id=" . $com['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                echo '</td></tr>';
                $i += 1;
            }
            ?>
        </table>
    </div>
    <div class="card group-header">
        <h2 class="text-center ">[<?php echo $item['Name']; ?>] Tags</h2>
    </div>
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered table-striped table-hover">
            <tr>
                <td>#</td>
                <td>Item Name</td>
                <td>Username</td>
                <td>Tags</td>
            </tr>
            <?php
            foreach ($alltags as $tag) {
                $i = array_search($tag, $alltags) + 1;
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td>' . $tag['Name'] . '</td>';
                echo '<td>' . $tag['username'] . '</td>';
                echo '<td >' . $tag['tags'] . '</td>';
                echo '</tr>';
                $i += 1;
            }
            ?>
        </table>
    </div>
</div>
<?php
        }else{
            $errMsg= 'No Such Id exists.';
            redirectToHome($errMsg, 4,"info",'back');
        }
    
    
    
    }elseif($do == "Update"){
    
        echo " <h1 class='text-content text-center'>Update Item</h1>";
        echo " <div class='container'>";
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Get variables from Form
                    $id                 = $_POST['Item_ID']         ;
                    $name               = $_POST['Name']            ;
                    $description        = $_POST['Description']     ;
                    $price              = $_POST['Price']           ;
                    $country            = $_POST['Country_Origin']  ;
                    $status             = $_POST['Status']          ;
                    $member             = $_POST['member']          ;
                    $category           = $_POST['category']        ;
                    $tags               = $_POST['tags']         ;
                    
                     $formErrors=array();
        
        if(empty($name))    {$formErrors[]  ='Name Can not be empty';}
        if(empty($price))   {$formErrors[]  ='Price Can not be empty';}
        if(empty($country)) {$formErrors[]  ='Country Can not be empty';}
        foreach($formErrors as $error){echo '<div class="alert alert-danger">'. $error . '</div>';}
        if(empty($formErrors)){
            $stmt= $con->prepare("UPDATE items
                                SET  
                                    Name=?,
                                    Description=?,
                                    Price=?,
                                    Country_Origin=?,
                                    Status=?,
                                    Member_ID=?,
                                    Cat_ID=?,
                                    tags=?
                                WHERE Item_ID=?");
            $stmt->execute(array($name,$description,$price,$country,$status,$member,$category,$tags,$id));
            if($stmt->rowCount() == 0){
                $errMsg= "No records have been updated";
                redirectToHome($errMsg, 70, 'danger','categories');
               }else{
                $errMsg= "<strong>".$stmt->rowCount(). "</strong> record have been updated.";
                redirectToHome($errMsg, 5,"success",'back');
               }
        } else {
                            $errMsg= "You can't be here directly";
                            redirectToHome($errMsg, 60,"danger",'home');
                        }
                    }
      echo "</div>";
    
    
   }elseif ($do == 'pending') {  //Manage Members Page
         $stmt = $con->prepare(
            "SELECT 
                items.*, categories.Name AS Cat_Name, users.username AS User_Name 
            FROM 
                items
            INNER JOIN 
                categories 
            ON 
                categories.ID = items.Cat_ID
            INNER JOIN 
                users 
            ON 
                users.userid = items.Member_ID
            WHERE items.regStatus !=1
                ");
        $stmt->execute();
        //Assign to variables
        $items= $stmt->fetchAll();
        
        $getUser=array();
        ?>

<h1 class="text-center"> Pending Items</h1>
<div class="container">
    <div class="card group-header">
        <h2 class="text-center ">Items</h2>
    </div>
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered table-striped table-hover">
            <tr>
                <td>#</td>
                <td>#ID</td>
                <td>Category</td>
                <td>Name</td>
                <td>Description</td>
                <td>Price</td>
                <td>Creation Date</td>
                <td>Creation User</td>
                <td>Control</td>
            </tr>
            <?php
            foreach ($items as $item) {
                $i = array_search($item, $items) + 1;
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td>' . $item['Item_ID'] . '</td>';
                echo '<td>' . $item['Cat_Name'] . '</td>';
                echo '<td>' . $item['Name'] . '</td>';
                echo '<td>' . $item['Description'] . '</td>';
                echo '<td>' . $item['Price'] . '</td>';
                echo '<td>' . $item['Add_Date'] . '</td>';
                echo '<td>' . $item['User_Name'] . '</td>';
                echo '<td>';
                echo "<div class = 'd-flex'>";
                if ($item['regStatus'] == 0) {
                    echo "<a href='items.php?do=Approve&Item_ID=" . $item['Item_ID'] . "' class='btn btn-info activate'><i class='fa-solid fa-check'></i></a> ";
                }
                echo "<a href='items.php?do=Edit&Item_ID=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i></a> ";
                echo "<a href='items.php?do=Delete&Item_ID=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i></a>";
                echo '</div></td></tr>';
                $i += 1;
            }
            ?>
        </table>
    </div>
</div>

<?php








  
    
    
    
    
    
    }elseif($do == "Delete"){
    
     //check id Get request userId is Numeric & Get the Integer Value of it
            $Item_ID = isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID']) ? intval($_GET['Item_ID']) : 0;
            // Select all data on this id
            $stmt = $con->prepare("SELECT * FROM  items  WHERE Item_ID=? ");
            //execute query
            $stmt->execute(array($Item_ID));
            // the row count
            $count = $stmt->rowCount();
            // if there is such id show the form
            if ($stmt->rowCount() > 0) {//apply the code if there is Id with input data.
                $stmt = $con->prepare("DELETE FROM items WHERE Item_ID= :IItem_ID");
                $stmt->bindParam(":IItem_ID",$Item_ID);
                $stmt->execute();
                $errMsg="<h1 class='text-content text-center'>Delete Item</h1>
                <div class='container'>   <div class='alert alert-danger text-center'><strong>".$stmt->rowCount(). "</strong> record have been Deleted </div>";
                        redirectToHome($errMsg, 6,"danger",'items');
        } // if there is no such id show error message
    
    
    }elseif($do == "Approve"){
        echo"<h1 class='text-content text-center'>Activate Item</h1>";
            echo '<div class="container">';
            //check id Get request userId is Numeric & Get the Integer Value of it
            $Item_ID = isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID']) ? intval($_GET['Item_ID']) : 0;
            
            $check= checkItem('Item_ID', 'items', $Item_ID); // check if user exists

            if ($check > 0){
                $stmt = $con->prepare("UPDATE items SET regStatus = 1 WHERE Item_ID=?");
                //execute query
                $stmt->execute(array($Item_ID));
                $errMsg= 'Item has been Activated Successfuly';
                redirectToHome($errMsg, 2,"success",'back');
            }else{
                $errMsg= 'No Pending Items';
                redirectToHome($errMsg, 3,"danger",'back');
            }
        echo'</div>';
    }
    include $tpl . 'footer.php';
} else {
    header('Location:index.php'); // redirect to dashboard page
    exit();
}
ob_end_flush();
?>
