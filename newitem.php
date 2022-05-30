<?php
ob_start();
session_start();
$pageTitle = 'Create New Item';
include 'init.php';
if (!isset($_SESSION['user'])) {
    header('Location:login.php');
    exit(); // redirect to Home page
}

$postuserid = $_SESSION['uid'];
$postusername = $_SESSION['user'];
$formErrors = [];
$itemAvatarName = $_FILES['image']['name'];
$image = '';
if (isset($itemAvatarName)) {
    $itemAvatarName = $_FILES['image']['name'];
    $itemAvatarName = trim($itemAvatarName);
    $itemAvatarName = str_replace(' ', '_', $itemAvatarName);
    $itemAvatarName = str_replace('__', '_', $itemAvatarName);
    $itemAvatarName = str_replace('__', '_', $itemAvatarName);
    $itemAvatarName = str_replace('__', '_', $itemAvatarName);
    $itemAvatarName = str_replace('__', '_', $itemAvatarName);
    $itemAvatarSize = $_FILES['image']['size'];
    $itemAvatarTmp = $_FILES['image']['tmp_name'];
    $itemAvatarType = $_FILES['image']['type'];
    $tmp = explode('.', $itemAvatarName);
    $file_extension = end($tmp);
    $itemAvatarAllowedExtensions = ['jpg', 'png', 'gif', 'jpeg'];
    $itemAvatarExtension = strtolower($file_extension);
    $itemAvatar = $user . '_' . date('_Y_m_d.') . $itemAvatarExtension;
    if (!empty($itemAvatarName) && !in_array($itemAvatarExtension, $itemAvatarAllowedExtensions)) {
        $formErrors[] = 'Not Allowed Extension';
    }
    if (empty($itemAvatarName)) {
        $formErrors[] = 'No Picture uploaded';
    }
    if ($itemAvatarSize > 4194304) {
        $formErrors[] = 'File is larger than 4 MB';
    }
    $image = $itemAvatar;
    move_uploaded_file($itemAvatarTmp, 'images\items\\' . $itemAvatar);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_content($_POST['Name']);
    $desc = filter_var($_POST['Description'], FILTER_SANITIZE_EMAIL);
    $price = filter_var($_POST['Price'], FILTER_SANITIZE_NUMBER_INT);
    $country = filter_var($_POST['Country_Origin'], FILTER_SANITIZE_EMAIL);
    $status = 0;
    $category = 0;
    $tags = filter_content($_POST['tags']);
    $tags = trim($tags);
    $tags = str_replace(' ', '_', $tags);
    $tags = str_replace('__', '_', $tags);
    $tags = str_replace('__', '_', $tags);
    $tags = str_replace('__', '_', $tags);
    $tags = str_replace('__', '_', $tags);
    $check = checkItem('Name', 'items', $name);

    if (isset($_POST['Status'])) {
        $status = filter_var($_POST['Status'], FILTER_SANITIZE_NUMBER_INT);
    }
    if (isset($_POST['category'])) {
        $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    }

    if (strlen($name) < 4) {
        $formErrors[] = 'Name must be at least 4 characters';
    }
    if (empty($name)) {
        $formErrors[] = 'Name must not be empty !!';
    }
    if ($check > 0) {
        $formErrors[] = 'Item with same name already exists !!';
    }
    if (strlen($desc) < 4) {
        $formErrors[] = 'Description must be at least 4 characters';
    }
    if (empty($desc)) {
        $formErrors[] = 'Description must not be empty !!';
    }
    if (strlen($country) < 4) {
        $formErrors[] = 'Country must be at least 4 characters';
    }
    if ($category == 0) {
        $formErrors[] = 'Category Can not be empty';
    }
    if ($status == 0) {
        $formErrors[] = 'Status Can not be empty';
    }

    if (empty($formErrors)) {
        //Insert New item in database
        $stmt = $con->prepare(
            "INSERT INTO items 
                            (Name, Description, Price, Country_Origin, Status, Member_ID, Cat_ID, Add_Date,tags, image) 
                        VALUES
                        (:Iname, :Idesc, :Iprice, :Icountry, :Istatus, :Imember, :Icat, now(),:Itags, :Iimage)
                                        ",
        );
        $stmt->execute([
            'Iname' => $name,
            'Idesc' => $desc,
            'Iprice' => $price,
            'Icountry' => $country,
            'Istatus' => $status,
            'Imember' => $postuserid,
            'Icat' => $category,
            'Itags' => $tags,
            'Iimage' => $image,
        ]);

        //Success message
        if ($stmt) {
            $successMsg = 'New Item has been added successfully';
        }
    }
}

?>
<h1 class="text-center"><?php echo $pageTitle; ?></h1>
<div class="information block">
    <div class="container">
        <div class="panel panel-primary card">
            <div class="panel-heading card-header "> <?php echo $pageTitle; ?> </div>
            <div class="panel-body card-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="container items-form">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="form-horizontal" method="POST"
                                enctype="multipart/form-data">
                                <!-- Start Name Field -->
                                <div class=" input-group mb-3">
                                    <span class="input-group-text">Item Name</span>
                                    <input class="form-control input-lg live" data-class=".live-title" type="text"
                                        name="Name" required="required" pattern=".{4,}"
                                        title="This field should have at least 4 characters"
                                        placeholder="Enter Item's Name">
                                </div>
                                <!-- End Name Field -->
                                <!-- Start Description Field -->
                                <div class=" input-group mb-3">
                                    <span class="input-group-text">Description</span>
                                    <input class="form-control input-lg live" type="text" name="Description"
                                        data-class=".live-desc" pattern=".{10,}"
                                        title="This field should have at least 10 characters"
                                        placeholder="Item's Description">
                                </div>
                                <!-- End Description Field -->
                                <!-- Start Price Field -->
                                <div class=" input-group mb-3">
                                    <span class="input-group-text">Price</span>
                                    <input class="form-control input-lg live" type="number" name="Price"
                                        required="required" data-class=".live-price" placeholder="Item's price">
                                </div>
                                <!-- End Price Field -->
                                <!-- Start Country of Origin Field -->
                                <div class=" input-group mb-3">
                                    <span class="input-group-text">Origin Country</span>
                                    <input class="form-control input-lg " type="text" name="Country_Origin"
                                        required="required" placeholder="Manufacuring Country">
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
                                <!-- Start Catergories Field -->
                                <div class=" input-group mb-3">
                                    <span class="input-group-text">Catergory</span>
                                    <div class="select">
                                        <select name="category" required="required">
                                            <option disabled selected class="dropdown-item" value="0">...</option>
                                            <?php
                                            $cats = getSqlData('*', 'categories', '', 'ID', 'ASC');
                                            foreach ($cats as $cat) {
                                                echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- End Catergories Field -->
                                <!-- Start Tags Field -->
                                <div class=" input-group mb-3">
                                    <span class="input-group-text">Tags</span>
                                    <input class="form-control input-lg live" type="text" name="tags"
                                        placeholder="Seperate Tags with comma ( , ) or Tab" data-class=".live-tag">
                                </div>
                                <!-- End Tags Field -->
                                <!-- Start Picture Field -->
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Picture</span>
                                    <input class="form-control input-lg" id="live-img" type="file" name="image"
                                        required="required">
                                </div>
                                <!-- End Picture Field -->
                                <!-- Start Button Field -->
                                <div class="input-group mb-3">
                                    <input class="btn btn-primary form-control" type="submit" value="Add Item">
                                </div>
                                <!-- End Button Field -->
                            </form>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="img-thumbnail item-box live-preview">
                            <span class="price-tag live-price">0 SR</span>
                            <?php
                            if (isset($itemAvatar)) {
                                echo '<img class="img-responsive img-fluid live-img img-thumbnail" src="uploads/avatars/' . $itemAvatar . '" alt="avatar">';
                            } else {
                            }
                            echo '<img class="img-responsive img-fluid" src="images/avatar2.jpg" alt="item">';
                            ?>
                            <div class="caption">
                                <h3 class="live-title"> Title </h3>
                                <p class="live-desc"> Description </p>
                                <p class="live-tag"> Tags </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Looping Errors-->
        <?php
        
        if (!empty($formErrors)) {
            echo "<div class=' container  add-new-item-errors'>";
            foreach ($formErrors as $error) {
                echo "<div class='msg err fs-5'>" . $error . '</div>';
                // echo "<div class='alert alert-danger text-center'>".$error."</div>";
            }
            echo '</div>';
        }
        if (isset($successMsg)) {
            echo "<div class='msg sucsess'>" . $successMsg . '</div>';
        }
        
        ?>
        <!-- End Looping Errors-->
    </div>
</div>
<?php
include $tpl . 'footer.php';
ob_end_flush();
?>
