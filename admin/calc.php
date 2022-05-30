<?php

// Manage Categories Page
ob_start();

session_start();
if (isset($_SESSION['username'])) {
    $pageTitle = 'Calc Cabinets';
    include 'init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] :"Manage";
    if($do == "Manage"){
        ?>
<h1 class="text-center"> Manage Cabinets</h1>
<div class="container">
    <a href="calc.php?do=Add" class="btn btn-primary form-control"> <i class="fa fa-plus"></i> New calc_cab</a>
    <div class="card group-header">
        <h2 class="text-center ">calc</h2>
    </div>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="POST">
            <!-- Start Base QNT Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Base</span>
            <input class="form-control input-lg" type="number" name="baseqnt" required="required"
                placeholder="How Many Base Cabinets?">
        </div>
        <!-- End Base Field -->
            <!-- Start Wall QNT Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Wall</span>
            <input class="form-control input-lg" type="number" name="wallqnt" required="required"
                placeholder="How Many Wall Cabinets?">
        </div>
        <!-- End Wall Field -->
            <!-- Start Tall QNT Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Tall</span>
            <input class="form-control input-lg" type="number" name="tallqnt" required="required"
                placeholder="How Many Tall Cabinets?">
        </div>
        <!-- End Tall Field -->
        <!-- Start Submit Button Field -->
        <div class="input-group mb-3">
            <input class="btn btn-primary form-control" type="submit" value="Spread Table">
        </div>
        <!-- End Button Field -->   
            
    </form>           
            
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                $baseqnt=$_POST['baseqnt'];
                $wallqnt=$_POST['wallqnt'];
                $tallqnt=$_POST['tallqnt'];
                // echo"Base Qnt => ". $baseqnt ."<br>";
                // echo"wall Qnt => ". $wallqnt."<br>";
                // echo"tall Qnt => ". $tallqnt."<br>";
            }
            ?>
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered table-striped table-hover">
            <tr>
                <td>#</td>
                <td>Contract Number</td>
                <td>Cab Name</td>
                <td>Depth</td>
                <td>Height</td>
                <td>Width</td>
                <td>Date</td>
            </tr>
            
            <?php
           $tableItems=array();
           
           for ($i=0; $i < $baseqnt; $i++) { 
            //    echo"Base Qnt => ". $baseqnt ."<br>";
            
               $tableItems[]="B".$i+1;
            //    echo"<p>". $tableItems[$i] ."</p>";
            } 
            for ($i=0; $i < $wallqnt; $i++) { 
                $tableItems[]="W".$i+1;
                // echo"wall Qnt => ". $wallqnt."<br>";
            } 
            for ($i=0; $i < $tallqnt; $i++) { 
                $tableItems[]="T".$i+1;
                // echo"tall Qnt => ". $tallqnt."<br>";
            } 
            
            foreach($tableItems as $item) {
                $i = array_search($item, $tableItems) + 1;
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td> Contract number';
                    echo'</td>';
                    echo '<td>'. $item. "</td>";
                        ?>
                    <td><input class="form-control input-lg" type="number" name="depth" required="required"></td>
                    <td><input class="form-control input-lg" type="number" name="height" required="required"></td>
                    <td><input class="form-control input-lg" type="number" name="width" required="required"></td>
                </tr>
                <?php
                $i += 1;
            }
            ?>
        </table>
    </div>
</div>













<?php
    }elseif($do == "Manage2"){
        ?>
<h1 class="text-center"> Manage Cabinets</h1>
<div class="container">
    <a href="calc.php?do=Add" class="btn btn-primary form-control"> <i class="fa fa-plus"></i> New calc_cab</a>
    <div class="card group-header">
        <h2 class="text-center ">calc</h2>
    </div>
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered table-striped table-hover">
            <tr>
                <td>#</td>
                <td>Contract Number</td>
                <td>Cab Name</td>
                <td>Depth</td>
                <td>Height</td>
                <td>Width</td>
                <td>Date</td>
            </tr>
            
            // Gathering Main Data
            
            <p>
                Getting Vaiables
            </p>  
            <p>
                Contract Number
            </p>  
            <p>
                Base Cabinets QNT
            </p>  
            <p>
                Wall Cabinets QNT
            </p>  
            <p>
                Tall Cabinets QNT
            </p>  
            
 <form action="?do=Insert" class="form-horizontal" method="POST">           
            <!-- Start Base QNT Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Base</span>
            <input class="form-control input-lg" type="number" name="baseqnt" required="required"
                placeholder="How Many Base Cabinets?">
        </div>
        <!-- End Base Field -->
            <!-- Start Wall QNT Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Wall</span>
            <input class="form-control input-lg" type="number" name="baseqnt" required="required"
                placeholder="How Many Wall Cabinets?">
        </div>
        <!-- End Wall Field -->
            <!-- Start Tall QNT Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Tall</span>
            <input class="form-control input-lg" type="number" name="tallqnt" required="required"
                placeholder="How Many Tall Cabinets?">
        </div>
        <!-- End Tall Field -->
        <!-- Start Submit Button Field -->
        <div class="input-group mb-3">
            <input class="btn btn-primary form-control" type="submit" value="Spread Table">
        </div>
        <!-- End Button Field -->   
            
     </form>           
            
            <?php
            foreach ($calc as $calc_cab) {
                $i = array_search($calc_cab, $calc) + 1;
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td>' . $calc_cab['contract_number'] . '</td>';
                echo '<td>' . $calc_cab['cabname'] . '</td>';
                echo '<td>' . $calc_cab['depth'] . '</td>';
                echo '<td>' . $calc_cab['height'] . '</td>';
                echo '<td>' . $calc_cab['width'] . '</td>';
                echo '<td>' . $calc_cab['Add_Date'] . '</td>';
                echo '<td>';
                if ($calc_cab['regStatus'] == 0) {
                    echo "<a href='calc.php?do=Approve&calc_cab_ID=" . $calc_cab['calc_cab_ID'] . "' class='btn btn-info activate'><i class='fa-solid fa-check'></i> Approve</a> ";
                }
                echo "<a href='calc.php?do=Edit&calc_cab_ID=" . $calc_cab['calc_cab_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a> ";
                echo "<a href='calc.php?do=Delete&calc_cab_ID=" . $calc_cab['calc_cab_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
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

<h1 class="text-content text-center">Add New Cabinet</h1>
<div class="container calc-form">
    <form action="?do=Insert" class="form-horizontal" method="POST">
        <!-- Start Name Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Contract Number</span>
            <input class="form-control input-lg" type="text" name="Name" required="required"
                placeholder="Enter calc_cab's Name">
        </div>
        <!-- End Name Field -->
        <!-- Start Description Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Cab Name</span>
            <input class="form-control input-lg" type="text" name="Description" placeholder="calc_cab's Description">
        </div>
        <!-- End Description Field -->
        <!-- Start Price Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Depth</span>
            <input class="form-control input-lg" type="number" name="Price" required="required"
                placeholder="calc_cab's Price">
        </div>
        <!-- End Price Field -->
        <!-- Start Country of Origin Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Height</span>
            <input class="form-control input-lg" type="text" name="Country_Origin" required="required"
                placeholder="Manufacuring Country">
        </div>
        <!-- End Country of Origin Field -->
        <!-- Start Status Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Width</span>
            <div class="select">
                <select name="Status" required="required">
                    <option disabled selected class="dropdown-calc_cab" value="0">...</option>
                    <option class="dropdown-calc_cab" value="1">Yad Production</option>
                    <option class="dropdown-calc_cab" value="2">Trademark</option>
                    <option class="dropdown-calc_cab" value="3">Local Market</option>
                    <option class="dropdown-calc_cab" value="4">Gift</option>
                    <option class="dropdown-calc_cab" value="5">Old Stock</option>
                </select>
            </div>
        </div>
        <!-- End Status Field -->
        <!-- Start Catergories Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Catergory</span>
            <div class="select">
                <select name="category" required="required">
                    <option disabled selected class="dropdown-calc_cab" value="0">...</option>
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
            <input class="btn btn-primary form-control" type="submit" value="Add calc_cab">
        </div>
        <!-- End Button Field -->
    </form>
</div>





<?php
    
    
    
    }elseif($do == "Insert"){
    
    
    echo " <h1 class='text-content text-center'>Update calc_cab</h1>";
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
        
        //CHECK IF calc_cab EXISTS IN database
            $check = checkcalc_cab("Name", "calc", $name);
            if($check > 0){
                $errMsg= '<strong>'.$check. '</strong> calc_cab with same name already exists.';
                redirectToHome($errMsg, 40,"info",'back');
            }else{
                    //Insert New calc_cab in database 
                    $stmt= $con->prepare(
                        "INSERT INTO calc 
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
        $calc_cab_ID = isset($_GET['calc_cab_ID']) && is_numeric($_GET['calc_cab_ID']) ? intval($_GET['calc_cab_ID']) : 0;
        // Select all data on this id
        $stmt = $con->prepare("SELECT * FROM  calc  WHERE calc_cab_ID=? ");
        //execute query
        $stmt->execute(array($calc_cab_ID));
        //fetch data
        $calc_cab = $stmt->fetch();
        // the row count
        $count = $stmt->rowCount();
        // if there is such id show the form
        if ($stmt->rowCount() > 0) { 
            //apply the code if there is Id with input data.
            ?>
<h1 class="text-content text-center">Edit calc_cab</h1>
<div class="container calc-form">
    <form action="?do=Update" class="form-horizontal" method="POST">

        <input type="hidden" name="calc_cab_ID" value="<?php echo $calc_cab_ID; ?>">
        <input type="hidden" name="Name_Old" value="<?php echo $calc_cab_ID; ?>">

        <!-- Start Name Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">calc_cab Name</span>
            <input class="form-control input-lg" type="text" name="Name" required="required"
                placeholder="Enter calc_cab's Name" value="<?php echo $calc_cab['Name']; ?>">
        </div>
        <!-- End Name Field -->
        <!-- Start Description Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Description</span>
            <input class="form-control input-lg" type="text" name="Description" value="<?php echo $calc_cab['Description']; ?>"
                placeholder="calc_cab's Description">
        </div>
        <!-- End Description Field -->
        <!-- Start Price Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Price</span>
            <input class="form-control input-lg" type="number" name="Price" required="required"
                value="<?php echo $calc_cab['Price']; ?>" placeholder="calc_cab's Price">
        </div>
        <!-- End Price Field -->
        <!-- Start Country of Origin Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Origin Country</span>
            <input class="form-control input-lg" type="text" name="Country_Origin" value="<?php echo $calc_cab['Country_Origin']; ?>"
                required="required" placeholder="Manufacuring Country">
        </div>
        <!-- End Country of Origin Field -->
        <!-- Start Status Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Status</span>
            <div class="select">
                <select name="Status" required="required">
                    <option class="dropdown-calc_cab" value="1" <?php if ($calc_cab['Status'] == 1) {
                        echo 'selected';
                    } ?>>
                        Yad Production</option>
                    <option class="dropdown-calc_cab" value="2" <?php if ($calc_cab['Status'] == 2) {
                        echo 'selected';
                    } ?>>
                        Trademark</option>
                    <option class="dropdown-calc_cab" value="3" <?php if ($calc_cab['Status'] == 3) {
                        echo 'selected';
                    } ?>>
                        Local Market</option>
                    <option class="dropdown-calc_cab" value="4" <?php if ($calc_cab['Status'] == 4) {
                        echo 'selected';
                    } ?>>
                        Gift</option>
                    <option class="dropdown-calc_cab" value="5" <?php if ($calc_cab['Status'] == 5) {
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
                        if ($calc_cab['Member_ID'] == $user['userid']) {
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
                    //     if ($calc_cab['Cat_ID'] == $cat['ID']) {
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
            <input class="form-control input-lg" type="text" name="tags" value="<?php echo $calc_cab['tags']; ?>"
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
    $allComs = getSqlData('comments.*, users.username', 'comments', "INNER JOIN users ON comments.user_id=users.userid WHERE calc_cab_id={$calc_cab_ID}", 'c_id', 'DESC');
    $alltags = getSqlData('calc.*, users.username', 'calc', "INNER JOIN users ON calc.Member_ID=users.userid WHERE calc_cab_id={$calc_cab_ID}", 'calc_cab_ID', 'DESC');
    // $stmt = $con->prepare("SELECT comments.*, users.username FROM comments INNER JOIN users ON comments.user_id=users.userid WHERE calc_cab_id=?");
    // $stmt->execute([$calc_cab_ID]);
    //Assign to variables
    // $rows = $stmt->fetchAll();
    ?>

    <div class="card group-header">
        <h2 class="text-center ">[<?php echo $calc_cab['Name']; ?>] Comments</h2>
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
        <h2 class="text-center ">[<?php echo $calc_cab['Name']; ?>] Tags</h2>
    </div>
    <div class="table-responsive">
        <table class="main-table text-center table table-bordered table-striped table-hover">
            <tr>
                <td>#</td>
                <td>calc_cab Name</td>
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
    
        echo " <h1 class='text-content text-center'>Update calc_cab</h1>";
        echo " <div class='container'>";
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Get variables from Form
                    $id                 = $_POST['calc_cab_ID']         ;
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
            $stmt= $con->prepare("UPDATE calc
                                SET  
                                    Name=?,
                                    Description=?,
                                    Price=?,
                                    Country_Origin=?,
                                    Status=?,
                                    Member_ID=?,
                                    Cat_ID=?,
                                    tags=?
                                WHERE calc_cab_ID=?");
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
                calc.*, categories.Name AS Cat_Name, users.username AS User_Name 
            FROM 
                calc
            INNER JOIN 
                categories 
            ON 
                categories.ID = calc.Cat_ID
            INNER JOIN 
                users 
            ON 
                users.userid = calc.Member_ID
            WHERE calc.regStatus !=1
                ");
        $stmt->execute();
        //Assign to variables
        $calc= $stmt->fetchAll();
        
        $getUser=array();
        ?>

<h1 class="text-center"> Pending calc</h1>
<div class="container">
    <div class="card group-header">
        <h2 class="text-center ">calc</h2>
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
            foreach ($calc as $calc_cab) {
                $i = array_search($calc_cab, $calc) + 1;
                echo '<tr>';
                echo '<td>' . $i . '</td>';
                echo '<td>' . $calc_cab['calc_cab_ID'] . '</td>';
                echo '<td>' . $calc_cab['Cat_Name'] . '</td>';
                echo '<td>' . $calc_cab['Name'] . '</td>';
                echo '<td>' . $calc_cab['Description'] . '</td>';
                echo '<td>' . $calc_cab['Price'] . '</td>';
                echo '<td>' . $calc_cab['Add_Date'] . '</td>';
                echo '<td>' . $calc_cab['User_Name'] . '</td>';
                echo '<td>';
                echo "<div class = 'd-flex'>";
                if ($calc_cab['regStatus'] == 0) {
                    echo "<a href='calc.php?do=Approve&calc_cab_ID=" . $calc_cab['calc_cab_ID'] . "' class='btn btn-info activate'><i class='fa-solid fa-check'></i></a> ";
                }
                echo "<a href='calc.php?do=Edit&calc_cab_ID=" . $calc_cab['calc_cab_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i></a> ";
                echo "<a href='calc.php?do=Delete&calc_cab_ID=" . $calc_cab['calc_cab_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i></a>";
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
            $calc_cab_ID = isset($_GET['calc_cab_ID']) && is_numeric($_GET['calc_cab_ID']) ? intval($_GET['calc_cab_ID']) : 0;
            // Select all data on this id
            $stmt = $con->prepare("SELECT * FROM  calc  WHERE calc_cab_ID=? ");
            //execute query
            $stmt->execute(array($calc_cab_ID));
            // the row count
            $count = $stmt->rowCount();
            // if there is such id show the form
            if ($stmt->rowCount() > 0) {//apply the code if there is Id with input data.
                $stmt = $con->prepare("DELETE FROM calc WHERE calc_cab_ID= :Icalc_cab_ID");
                $stmt->bindParam(":Icalc_cab_ID",$calc_cab_ID);
                $stmt->execute();
                $errMsg="<h1 class='text-content text-center'>Delete calc_cab</h1>
                <div class='container'>   <div class='alert alert-danger text-center'><strong>".$stmt->rowCount(). "</strong> record have been Deleted </div>";
                        redirectToHome($errMsg, 6,"danger",'calc');
        } // if there is no such id show error message
    
    
    }elseif($do == "Approve"){
        echo"<h1 class='text-content text-center'>Activate calc_cab</h1>";
            echo '<div class="container">';
            //check id Get request userId is Numeric & Get the Integer Value of it
            $calc_cab_ID = isset($_GET['calc_cab_ID']) && is_numeric($_GET['calc_cab_ID']) ? intval($_GET['calc_cab_ID']) : 0;
            
            $check= checkcalc_cab('calc_cab_ID', 'calc', $calc_cab_ID); // check if user exists

            if ($check > 0){
                $stmt = $con->prepare("UPDATE calc SET regStatus = 1 WHERE calc_cab_ID=?");
                //execute query
                $stmt->execute(array($calc_cab_ID));
                $errMsg= 'calc_cab has been Activated Successfuly';
                redirectToHome($errMsg, 2,"success",'back');
            }else{
                $errMsg= 'No Pending calc';
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
