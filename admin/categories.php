<?php

// Manage Categories Page
ob_start();

session_start();
if (isset($_SESSION['username'])) {
    $pageTitle = 'Categories';
    include 'init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] :"Manage";
        if($do == "Manage"){
        $sort= "ASC";
        $sort_array= array('ASC','DESC');
        if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
        $sort = $_GET['sort'];
        };
        $stmt2= $con->prepare("SELECT * FROM categories WHERE parent=0 ORDER BY Ordering $sort");
        $stmt2->execute();
        $cats = $stmt2->fetchAll(); ?>
<h1 class="text-center"> Manage Categories</h1>
<div class="container categories">
    <div class="panel panel-default">
        <div class="card-header header">
            <div>
                <i class="fa fa-edit"></i> Manage Categories
            </div>
            <div class="options pull-right">
                <div class='sort'>
                    <a class="<?php if ($sort == 'ASC') {
                        echo 'active';
                    } ?> " href="?sort=ASC"><i class="fa-solid fa-sort-up fa-2x"></i></a>
                    <a class="<?php if ($sort == 'DESC') {
                        echo 'active';
                    } ?> " href="?sort=DESC"><i class="fa-solid fa-sort-down fa-2x"></i></a>
                </div>
                <div class='view'>
                    [
                    <span class="active" data-view="full">Full</span> |
                    <span data-view="classic">Classic</span>
                    ]
                </div>
            </div>
        </div>
        <div class='card cats panel-body'>
            <?php foreach ($cats as $cat) {?>
            <div class='cat'>
                <div class=' hidden-button'>
                    <a class='btn btn-primary' href='categories.php?do=Edit&catId=<?php echo $cat['ID']; ?>'><i
                            class='fa fa-edit'></i> Edit</a>
                    <a class='btn btn-danger confirm' href='categories.php?do=Delete&catId=<?php echo $cat['ID']; ?>'><i
                            class='fa fa-close'></i> Delete</a>
                </div>
                <h3> <?php echo $cat['Name']; ?> </h3>
                <div class='full-view'>
                    <?php
                    if (empty($cat['Description'])) {
                        echo '<p>No description</p>';
                    } else {
                        echo '<p>' . $cat['Description'] . '</p>';
                    }
                    
                    if ($cat['Visibility'] == 0) {
                        echo '<span class="visibilty-no no"> <i class="fa fa-eye-low-vision"></i> Hidden</span>';
                    } else {
                        echo '<span class="visibilty-yes"> <i class="fa-solid fa-eye"></i> Visible</span>';
                    }
                    if ($cat['Allow_Comment'] == 0) {
                        echo '<span class="comment-allow-no no"> <i class="fa fa-circle-xmark"></i> Comments</span>';
                    } else {
                        echo '<span class="comment-allow-yes"> <i class="fa-solid fa-circle-check"></i> Comments</span>';
                    }
                    if ($cat['Allow_Ads'] == 0) {
                        echo '<span class="ads-allow-no no"> <i class="fa fa-circle-xmark"></i> Ads</span>';
                    } else {
                        echo '<span class="ads-allow-yes"><i class="fa-solid fa-circle-check"></i> Ads</span>';
                    }
                    ?>
                </div>
                <!-- Get Child Categories -->
                <?php
                            $childCats = getSqlData("*", "categories", "WHERE parent ={$cat['ID']}" , "Name", "ASC");
                            if(!empty($childCats)){ ?>
                <div>
                    <ul class='list-unstyled'>
                        <?php foreach ($childCats as $child){ ?>
                        <li class=" nav-item  -li">
                            <div class="sub-item-li">
                                <a class="nav-link "
                                    href="../categories.php?pageid=<?php echo $child['ID']; ?>"><?php echo $child['Name']; ?></a>
                                <div class=' hidden-button sub-cat'>
                                    <a class='btn btn-primary show-hidden-btn '
                                        href='categories.php?do=Edit&catId=<?php echo $child['ID']; ?>'><i
                                            class='fa fa-edit'></i></a>
                                    <a class='btn btn-danger show-hidden-btn confirm'
                                        href='categories.php?do=Delete&catId=<?php echo $child['ID']; ?>'><i
                                            class='fa fa-close'></i></a>
                                </div>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>

            </div>
            <?php } ?>
        </div>
        <a class='add-category btn btn-primary' href="categories.php?do=Add"><i class="fa fa-plus"></i> Add New
            Category</a>
    </div>






    <?php
    }elseif($do == "Add"){ ?>

    <h1 class="text-content text-center">Add New Category</h1>
    <div class="container">
        <form action="?do=Insert" class="form-horizontal" method="POST">
            <!-- Start Name Field -->
            <div class=" input-group mb-3">
                <span class="input-group-text">Name</span>
                <input class="form-control input-lg" type="text" name="name" required="required"
                    placeholder="Enter Category Name">
            </div>
            <!-- End Name Field -->
            <!-- Start Description Field -->
            <div class="input-group mb-3">
                <span class="input-group-text">Description</span>
                <input class="form-control input-lg " type="text" name="description"
                    placeholder="Description of category">
            </div>
            <!-- End Description Field -->
            <!-- Start ordering Field -->
            <div class="input-group mb-3">
                <span class="input-group-text">Ordering</span>
                <input class="form-control input-lg" type="number" name="ordering"
                    placeholder="Number of Category order">
            </div>
            <!-- End ordering Field -->
            <!-- Start Parent Field -->
            <div class=" input-group mb-3">
                <span class="input-group-text">Parent</span>
                <div class="select">
                    <select name="parent" required="required">
                        <option disabled selected class="dropdown-item" value="0">None</option>
                        <?php
                        $parents = getSqlData('*', 'categories', 'WHERE Visibility=1 AND parent=0', 'Name', 'ASC');
                        foreach ($parents as $parent) {
                            echo "<option value='" . $parent['ID'] . "'>" . $parent['Name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!-- End Parent Field -->
            <!-- Start Visibilty Field -->
            <div class="input-group mb-3">
                <span class="input-group-text form-span text-center">Visibilty</span>
                <input type="radio" class="btn-check" name="visibilty" id="vis-yes" autocomplete="off" value=1
                    checked>
                <label class="btn btn-outline-success" for="vis-yes">Visible</label>
                <input type="radio" class="btn-check" name="visibilty" id="vis-no" autocomplete="off" value=0>
                <label class="btn btn-outline-danger" for="vis-no">Hidden</label>
            </div>
            <!-- End Visibilty Field -->
            <!-- Start Commenting Field -->
            <div class="input-group mb-3">
                <span class="input-group-text form-span">Commenting</span>
                <input type="radio" class="btn-check" name="commenting" id="com-yes" autocomplete="off" value=1
                    checked>
                <label class="btn btn-outline-success" for="com-yes">Enable</label>
                <input type="radio" class="btn-check" name="commenting" id="com-no" autocomplete="off" value=0>
                <label class="btn btn-outline-danger" for="com-no">Disable</label>
            </div>
            <!-- End Commenting Field -->
            <!-- Start Adds Field -->
            <div class="input-group mb-3">
                <span class="input-group-text form-span">Ads</span>
                <input type="radio" class="btn-check" name="ads" id="ads-yes" autocomplete="off" value=1 checked>
                <label class="btn btn-outline-success" for="ads-yes">Enable</label>
                <input type="radio" class="btn-check" name="ads" id="ads-no" autocomplete="off" value=0>
                <label class="btn btn-outline-danger" for="ads-no">Disable</label>
            </div>
            <!-- End Adds Field -->


            <!-- Start Button Field -->
            <div class="input-group mb-3">
                <input class="btn btn-primary form-control" type="submit" value="Add Category">
            </div>
            <!-- End Button Field -->
        </form>
    </div>





    <?php
    }elseif($do == "Insert"){
    
        echo " <h1 class='text-content text-center'>Insert Category</h1>";
        echo " <div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {   // Get variables from Form
            $name       = $_POST['name'];
            $desc       = $_POST['description'];
            $parent       = $_POST['parent'];
            $order      = $_POST['ordering'];
            $visibe     = $_POST['visibilty'];
            $comment    = $_POST['commenting'];
            $ads        = $_POST['ads'];
            
            $check = checkItem('name', 'categories', $name);
            if($check > 0){ //CHECK IF USERNAME EXISTS IN database
                $errMsg= '<strong>'.$check. '</strong> Category with the same name already exists.';
                redirectToHome($errMsg, 43,"danger",'back');
            }else{//Insert New Catergory in database 
                $stmt= $con->prepare("  INSERT INTO 
                categories (Name , Description, parent, Ordering, Visibility, Allow_Comment, Allow_Ads) 
                VALUES(:IName , :IDescription, :Iparent, :IOrdering, :IVisibility, :IAllow_Comment, :IAllow_Ads)");
                $stmt->execute(array(
                    'IName'             =>  $name   ,
                    'IDescription'      =>  $desc   ,
                    'Iparent'           =>  $parent   ,
                    'IOrdering'         =>  $order  ,
                    'IVisibility'       =>  $visibe ,
                    'IAllow_Comment'    =>  $comment,
                    'IAllow_Ads'        =>  $ads    ,
                ));
                
                //Success message
                if($stmt->rowCount() == 0){
                $errMsg= "No records have been updated";
                redirectToHome($errMsg, 4,"danger",'back');
                }else{
                    $errMsg= $stmt->rowCount(). ' record have been updated.';
                redirectToHome($errMsg, 4,"info",'back'); 
                }
            }
        } else {
            $errMsg= "You can't be here directly";
            redirectToHome($errMsg, 4,"danger",'members');
        }
        echo "</div>" ;
        
        
        
    
        
        
        
    
        
    
    }elseif ($do == 'Edit') { //Edit Page
        //check id Get request CatId is Numeric & Get the Integer Value of it
        $catId = isset($_GET['catId']) && is_numeric($_GET['catId']) ? intval($_GET['catId']) : 0;
        // Select all data on this id
        $stmt = $con->prepare("SELECT * FROM  categories  WHERE Id=?  ");
        //execute query
        $stmt->execute(array($catId));
        //fetch data
        $cat = $stmt->fetch();
        // the row count
        $count = $stmt->rowCount();
        // if there is such id show the form
        if ($stmt->rowCount() > 0) {  //apply the code if there is Id with input data.  ?>
    <h1 class="text-content text-center">Edit Category</h1>
    <div class="container text-center">
        <form action="?do=Update" class="form-horizontal" method="POST">
            <!-- Start Name Field -->
            <input type="hidden" name="catId" value="<?php echo $catId; ?>">
            <div class=" input-group mb-3">
                <span class="input-group-text">Name</span>
                <input class="form-control input-lg" type="text" name="name" required="required"
                    placeholder="Enter Category Name" value="<?php echo $cat['Name']; ?>">
            </div>
            <!-- End Name Field -->
            <!-- Start Description Field -->
            <div class="input-group mb-3">
                <span class="input-group-text">Description</span>
                <input class="form-control input-lg " type="text" name="description"
                    placeholder="Description of category" value="<?php echo $cat['Description']; ?>">
            </div>
            <!-- End Description Field -->
            <!-- Start ordering Field -->
            <div class="input-group mb-3">
                <span class="input-group-text">Ordering</span>
                <input class="form-control input-lg " type="number" name="ordering"
                    placeholder="Number of Category order" value="<?php echo $cat['Ordering']; ?>">
            </div>
            <!-- End ordering Field -->
            <!-- Start Parent Field -->
            <div class=" input-group mb-3">
                <span class="input-group-text">Parent</span>
                <div class="select">
                    <select name="parent" required="required">
                        <option class="dropdown-item" value="0">None</option>
                        <?php
                        $parents = getSqlData('*', 'categories', 'WHERE Visibility=1 AND parent=0', 'Name', 'ASC');
                        foreach ($parents as $parent) {
                            echo '<option ';
                            if ($parent['ID'] == $cat['parent']) {
                                echo ' selected ';
                            }
                            echo " value='" . $parent['ID'] . "'>" . $parent['Name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!-- End Parent Field -->
            <!-- Start Visibilty Field -->
            <div class="input-group mb-3">
                <span class="input-group-text form-span text-center">Visibilty</span>
                <?php
                if ($cat['Visibility'] == 1) {
                    echo '<input type="radio" class="btn-check" name="visibilty" id="vis-yes" autocomplete="off" value=1 checked>';
                    echo '<label class="btn btn-outline-success" for="vis-yes" >Visible</label>';
                    echo '<input type="radio" class="btn-check" name="visibilty" id="vis-no" autocomplete="off" value=0>';
                    echo '<label class="btn btn-outline-danger" for="vis-no" >Hidden</label>';
                } elseif ($cat['Visibility'] == 0) {
                    echo '<input type="radio" class="btn-check" name="visibilty" id="vis-yes" autocomplete="off" value=1 >';
                    echo '<label class="btn btn-outline-success" for="vis-yes" >Visible</label>';
                    echo '<input type="radio" class="btn-check" name="visibilty" id="vis-no" autocomplete="off" value=0 checked> ';
                    echo '<label class="btn btn-outline-danger" for="vis-no" >Hidden</label>';
                }
                ?>
            </div>
            <!-- End Visibilty Field -->
            <!-- Start Commenting Field -->
            <div class="input-group mb-3">
                <span class="input-group-text form-span">Commenting</span>
                <?php
                if ($cat['Allow_Comment'] == 1) {
                    echo '<input type="radio" class="btn-check" name="commenting" id="com-yes" autocomplete="off" value=1 checked>';
                    echo '<label class="btn btn-outline-success" for="com-yes" >Enable</label>';
                    echo '<input type="radio" class="btn-check" name="commenting" id="com-no" autocomplete="off" value=0>';
                    echo '<label class="btn btn-outline-danger" for="com-no" >Disable</label>';
                } elseif ($cat['Allow_Comment'] == 0) {
                    echo '<input type="radio" class="btn-check" name="commenting" id="com-yes" autocomplete="off" value=1 >';
                    echo '<label class="btn btn-outline-success" for="com-yes" >Enable</label>';
                    echo '<input type="radio" class="btn-check" name="commenting" id="com-no" autocomplete="off" value=0 checked>';
                    echo '<label class="btn btn-outline-danger" for="com-no" >Disable</label>';
                }
                ?>
            </div>
            <!-- End Commenting Field -->
            <!-- Start Adds Field -->
            <div class="input-group mb-3">
                <span class="input-group-text form-span">Ads</span>
                <?php
                if ($cat['Allow_Ads'] == 1) {
                    echo '<input type="radio" class="btn-check" name="ads" id="ads-yes" autocomplete="off" value=1 checked>';
                    echo '<label class="btn btn-outline-success" for="ads-yes" >Enable</label>';
                    echo '<input type="radio" class="btn-check" name="ads" id="ads-no" autocomplete="off" value=0>';
                    echo '<label class="btn btn-outline-danger" for="ads-no" >Disable</label>';
                } elseif ($cat['Allow_Ads'] == 0) {
                    echo '<input type="radio" class="btn-check" name="ads" id="ads-yes" autocomplete="off" value=1 >';
                    echo '<label class="btn btn-outline-success" for="ads-yes" >Enable</label>';
                    echo '<input type="radio" class="btn-check" name="ads" id="ads-no" autocomplete="off" value=0 checked>';
                    echo '<label class="btn btn-outline-danger" for="ads-no" >Disable</label>';
                }
                ?>
            </div>
            <!-- End Adds Field -->


            <!-- Start Button Field -->
            <div class="input-group mb-3">
                <input class="btn btn-primary form-control" type="submit" value="Save">
            </div>
            <!-- End Button Field -->
        </form>




    </div>
    <?php
              }      // if there is no such id show error message
/*
                                <span class="input-group-text">Ads</span>
                                 
                                <input id="ads" type="radio" class="btn-check" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0){echo 'checked';}?>>
    <label class="btn btn-outline-success" for="ads">Enabled</label>

    <input id="ads-n" type="radio" class="btn-check" name="ads" value="1" <?php if ($cat['Allow_Ads'] == 1) {
        echo 'checked';
    } ?>>
    <label class="btn btn-outline-danger" for="ads-n">Disabled</label>



    <form action="?do=Update" class="form-horizontal" method="POST">
        <input type="hidden" name="catId" value="<?php echo $catId; ?>">
        <!-- Start Name Field -->
        <div class=" input-group mb-3">
            <span class="input-group-text">Name</span>
            <input class="form-control input-lg" type="text" name="name" required="required"
                placeholder="Enter Category Name" value="<?php echo $cat['Name']; ?>">
        </div>
        <!-- End Name Field -->
        <!-- Start Description Field -->
        <div class="input-group mb-3">
            <span class="input-group-text">Description</span>
            <input class="form-control input-lg " type="text" name="description" placeholder="Description of category"
                value="<?php echo $cat['Description']; ?>">
        </div>
        <!-- End Description Field -->
        <!-- Start ordering Field -->
        <div class="input-group mb-3">
            <span class="input-group-text">Ordering</span>
            <input class="form-control input-lg " type="number" name="ordering" placeholder="Number of Category order"
                value="<?php echo $cat['Ordering']; ?>">
        </div>
        <!-- End ordering Field -->
        <!-- Start Visibilty Field -->
        <div class="checkboxes">
            <div class="form-check form-switch">
                <input id="vis" class="form-check-input" type="checkbox" role="switch" name="visibilty" value="0"
                    <?php if ($cat['Visibility'] == 1) {
                        echo 'checked';
                    } ?>>
                <label for="vis" class="form-check-label">Visiblity</label>
            </div>

            <div class="form-check form-switch">
                <input id="com" class="form-check-input" type="checkbox" role="switch" name="commenting" value="0"
                    <?php if ($cat['Allow_Comment'] == 1) {
                        echo 'checked';
                    } ?>>
                <label for="com" class="form-check-label">Commenting</label>
            </div>

            <div class="form-check form-switch container-fluid">


                <?php
                if ($cat['Allow_Ads'] == 1) {
                    echo '<input id="ads-status" type="radio" role="switch" class="btn-check" name="ads" value=1 checked>';
                    echo '<label class="btn btn-outline-info" for="ads-status" >Ads: (Enabled)</label>';
                } elseif ($cat['Allow_Ads'] == 0) {
                    echo '<input id="ads-status" type="radio" role="switch" class="btn-check" name="ads" value=0 checked>';
                    echo '<label class="btn btn-outline-danger" for="ads-status" >Ads: (Disabled)</label>';
                }
                ?>
            </div>
        </div>
        <div class="input-group mb-3">
            <input class="btn btn-primary form-control" type="submit" value="Save changes">
        </div>
        <!-- End Button Field -->
    </form>



    ////////////////////////////////////////////////////////////////////////////////////////////////
    Old form
    ///////////////////////////////////////////////////////////////////////////////////////
    <form action="?do=Update" class="form-horizontal" method="POST">
        <!-- Start Name Field -->
        <input type="hidden" name="catId" value="<?php echo $catId; ?>">
        <div class=" input-group mb-3">
            <span class="input-group-text">Name</span>
            <input class="form-control input-lg" type="text" name="name" required="required"
                placeholder="Enter Category Name" value="<?php echo $cat['Name']; ?>">
        </div>
        <!-- End Name Field -->
        <!-- Start Description Field -->
        <div class="input-group mb-3">
            <span class="input-group-text">Description</span>
            <input class="form-control input-lg " type="text" name="description" placeholder="Description of category"
                value="<?php echo $cat['Description']; ?>">
        </div>
        <!-- End Description Field -->
        <!-- Start ordering Field -->
        <div class="input-group mb-3">
            <span class="input-group-text">Ordering</span>
            <input class="form-control input-lg " type="number" name="ordering" placeholder="Number of Category order"
                value="<?php echo $cat['Ordering']; ?>">
        </div>
        <!-- End ordering Field -->
        <!-- Start Visibilty Field -->
        <div class="input-group mb-3">
            <span class="input-group-text">Visiblity</span>
            <div class="form-check form-switch">
                <input id="vis-yes" class="form-check-input" type="checkbox" role="switch" name="visibilty" value="0"
                    <?php if ($cat['Visibility'] == 0) {
                        echo 'checked';
                    } ?>>
                <label for="vis-yes">Yes</label>
            </div>
            <div class="form-check form-switch">
                <input id="vis-no" class="form-check-input" type="checkbox" role="switch" name="visibilty" value="1"
                    <?php if ($cat['Visibility'] == 1) {
                        echo 'checked';
                    } ?>>
                <label for="vis-no">No</label>
            </div>
        </div>
        <!-- End Visibilty Field -->
        <!-- Start Commenting Field -->
        <div class="input-group mb-3">
            <span class="input-group-text">Commenting</span>
            <div class="form-check form-switch">
                <input id="com-yes" class="form-check-input" type="checkbox" role="switch" name="commenting" value="0"
                    <?php if ($cat['Allow_Comment'] == 0) {
                        echo 'checked';
                    } ?>>
                <label class="form-check-label" for="com-yes">Yes</label>
            </div>
            <div class="form-check form-switch">
                <input id="com-no" class="form-check-input" type="checkbox" role="switch" name="commenting" value="1"
                    <?php if ($cat['Allow_Comment'] == 1) {
                        echo 'checked';
                    } ?>>
                <label class="form-check-label" for="com-no">No</label>
            </div>
        </div>
        <!-- End Commenting Field -->
        <!-- Start Adds Field -->
        <div class="input-group mb-3">
            <span class="input-group-text">Allow Ads</span>
            <div class="form-check form-switch">
                <input id="ads-yes" class="form-check-input" type="checkbox" role="switch" name="ads" value="0"
                    <?php if ($cat['Allow_Ads'] == 0) {
                        echo 'checked';
                    } ?>>
                <label class="form-check-label" for="ads-yes">Yes</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" id="ads-no" class="form-check-input" type="checkbox" role="switch"
                    name="ads" value="1" <?php if ($cat['Allow_Ads'] == 1) {
                        echo 'checked';
                    } ?>>
                <label class="form-check-label" for="ads-no">No</label>
            </div>
        </div>
        <!-- End Visibilty Field -->
        <!-- Start Button Field -->
        <div class="input-group mb-3">
            <input class="btn btn-primary form-control" type="submit" value="Add Category">
        </div>
        <!-- End Button Field -->
    </form>













    */






    }elseif($do == "Update"){
    echo " <h1 class='text-content text-center'>Update Category</h1>";
    echo " <div class='container'>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get variables from Form
        $id = $_POST['catId'];
        // $user = $_POST['username'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $order = $_POST['ordering'];
        $visible = $_POST['visibilty'];
        $comment = $_POST['commenting'];
        $ads = $_POST['ads'];
        $stmt= $con->prepare("UPDATE categories
        SET
        Name=?,
        Description=?,
        Ordering=?,
        Visibility=?,
        Allow_Comment=?,
        Allow_Ads=?
        WHERE ID=?");
        $stmt->execute(array($name,$description,$order,$visible,$comment,$ads,$id));
        if($stmt->rowCount() == 0){
        $errMsg= "No records have been updated";
        redirectToHome($errMsg, 7, 'danger','categories');
        }else{
        $errMsg= "<strong>".$stmt->rowCount(). "</strong> record have been updated.";
        redirectToHome($errMsg, 5,"success",'categories');
        }
        } else {
        $errMsg= "You can't be here directly";
        redirectToHome($errMsg, 6,"danger",'home');
        }
        echo "</div>";

    }elseif($do == "Delete"){
    echo "<h1 class='text-content text-center'>Delete Category</h1>";
    echo "<div class='container'>";
        $catId = isset($_GET['catId']) && is_numeric($_GET['catId']) ? intval($_GET['catId']) : 0;
        // Select all data on this id
        $stmt = $con->prepare("SELECT * FROM categories WHERE ID=? LIMIT 1");
        //execute query
        $stmt->execute(array($catId));
        // the row count
        $count = $stmt->rowCount();
        // if there is such id show the form
        if ($stmt->rowCount() > 0) {//apply the code if there is Id with input data.
        $stmt = $con->prepare("DELETE FROM categories WHERE ID= :zId");
        $stmt->bindParam(":zId",$catId);
        $stmt->execute();
        $errMsg="<div class='alert alert-danger text-center'> Record has been Deleted </div>";
        redirectToHome($errMsg, 4,"info",'categories');
        }else{ // if there is no such id show error message
        $errMsg="<div class='alert alert-danger text-center'>There is No such Category </div>";
        redirectToHome($errMsg, 4,"danger",'categories');
        }

        echo"</div>";



    }elseif($do == "Activate"){


    }
    include $tpl . 'footer.php';
    } else {
    header('Location:index.php'); // redirect to dashboard page
    exit();
    }
    ob_end_flush();
    ?>
    ?>
    ?>
