<?php

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
// if the page is main page
if ($do == 'Manage') {
    echo ' Welcome .. you are in category page.';
    echo '<a href="?do=Insert"> Add a new category +</a>';
} elseif ($do == 'Add') {
    echo 'Welcome .. you are in category page';
} elseif ($do == 'Insert') {
    echo 'Welcome .. you are in category page';
} else {
    echo 'Error :- No page with this name. :)';
}

?>

<ul class="list-unstyled latest-users">
    <li>
        <div class='name'>
            <span class='member'>samy samy</span>
        </div>
        <div class='buttons'>
            <a disabled class='btn btn-secondary pull-right' disabled>
                <i class='fa-solid fa-check'></i>
            </a>
            <a href='members.php?do=Edit&userId=184' class='btn btn-success pull-right'>
                <i class='fa fa-edit'></i>
            </a>
            <a href='members.php?do=Delete&userId=184' class='btn btn-danger confirm pull-right'>
                <i class='fa fa-close'></i>
            </a>
        </div>
        </div>
    </li>
    <li>
        <div class='name'><span class='member'>Kamelia moo</span> </div>
        <div class='buttons'><a disabled class='btn btn-secondary pull-right' disabled><i
                    class='fa-solid fa-check'></i></a> <a href='members.php?do=Edit&userId=183'
                class='btn btn-success pull-right'><i class='fa fa-edit'></i></a> <a
                href='members.php?do=Delete&userId=183' class='btn btn-danger confirm pull-right'><i
                    class='fa fa-close'></i></a></div>
        </div>
    </li>
    <li>
        <div class='name'><span class='member'>reem elbarody2</span> </div>
        <div class='buttons'><a disabled class='btn btn-secondary pull-right' disabled><i
                    class='fa-solid fa-check'></i></a> <a href='members.php?do=Edit&userId=143'
                class='btn btn-success pull-right'><i class='fa fa-edit'></i></a> <a
                href='members.php?do=Delete&userId=143' class='btn btn-danger confirm pull-right'><i
                    class='fa fa-close'></i></a></div>
        </div>
    </li>
    <li>
        <div class='name'>last input [ <span class='admin'> Admin </span> ]
        </div>
    </li>
    <div class='buttons'><a disabled class='btn btn-secondary pull-right' disabled><i
                class='fa-solid fa-check pull-right'></i></a><a href='members.php?do=Edit&userId=69'
            class='btn btn-success pull-right'><i class='fa fa-edit'></i></a><a href='members.php?do=Delete&userId=69'
            class='btn btn-danger pull-right confirm'><i class='fa fa-close'></i></a></div>
    </div>
    </li>
    <li>
        <div class='name'><span class='member'>Kareem elbayar</span> </div>
        <div class='buttons'><a disabled class='btn btn-secondary pull-right' disabled><i
                    class='fa-solid fa-check'></i></a> <a href='members.php?do=Edit&userId=68'
                class='btn btn-success pull-right'><i class='fa fa-edit'></i></a> <a
                href='members.php?do=Delete&userId=68' class='btn btn-danger confirm pull-right'><i
                    class='fa fa-close'></i></a></div>
        </div>
    </li>
</ul>














<!-- 

<div class='card cats panel-body'>
<?php
                foreach ($cats as $cat) {
                    echo "<div class='cat'>";
                        echo "<div class=' hidden-button'>";
                            echo "<a class='btn btn-primary' href='categories.php?do=Edit&catId=". $cat['ID']. "'><i class='fa fa-edit'></i> Edit</a>";
                            echo "<a class='btn btn-danger confirm'href='categories.php?do=Delete&catId=". $cat['ID']. "'><i class='fa fa-close'></i> Delete</a>";
                            echo "</div>";
                        echo '<h3>' . $cat['Name'] . '</h3>';
                        echo "<div class= 'full-view'>";
                            if ($cat['parent'] == 0) {echo '<p></p>';
                                }
                                //else{
                                // $catParent= "ID = ".$cat['parent'];
                                // $stmt3= $con->prepare("SELECT * FROM categories WHERE $catParent ORDER BY Ordering DESC");
                                // $stmt3->execute();
                                // $parent = $stmt3->fetch();
                                // echo "<p class='btn btn-light '>Category => ".$parent['Name']."</p>";
                            //}
                            if ($cat['Description'] == '') {echo '<p>No description</p>';
                                }else{echo "<p>".$cat['Description']."</p>";}
                            if ($cat['Visibility'] == 0) {echo '<span class="visibilty-no no"> <i class="fa fa-eye-low-vision"></i> Hidden</span>';
                                } else {echo '<span class="visibilty-yes"> <i class="fa-solid fa-eye"></i> Visible</span>';}
                            if ($cat['Allow_Comment'] == 0) { echo '<span class="comment-allow-no no"> <i class="fa fa-circle-xmark"></i> Comments</span>';
                                } else {echo '<span class="comment-allow-yes"> <i class="fa-solid fa-circle-check"></i> Comments</span>';}
                            if ($cat['Allow_Ads'] == 0) { echo '<span class="ads-allow-no no"> <i class="fa fa-circle-xmark"></i> Ads</span>';
                        } else {echo '<span class="ads-allow-yes"><i class="fa-solid fa-circle-check"></i> Ads</span>';}
                        echo "</div>";
                        // Get Child Categories
                        echo '<div class="accordion-item">';
                        $childCats = getSqlData("*", "categories", "WHERE parent ={$cat['ID']}" , "Name", "ASC");
                        if(!empty($childCats)){ ?>
                                            <h4 class="accordion-header">  Sub Categories </h4>
                                            <ul class='list-unstyled'>
                                                <?php
                                     foreach ($childCats as $child){
                                         echo'<li class=" nav-item show-hidden-li"> <a class="nav-link " href="../categories.php?pageid='.$child['ID'].'">' .$child['Name'].'</a></li>';
                                         echo "<a class='btn btn-primary show-hidden-li' href='categories.php?do=Edit&catId=". $child['ID']. "'><i class='fa fa-edit'></i></a>";
                                         echo "<a class='btn btn-danger show-hidden confirm'href='categories.php?do=Delete&catId=". $child['ID']. "'><i class='fa fa-close'></i></a>";
                                        }?>
                                  </ul>
                                  <?php } ?>
                         </div>
                     </div>
<?php
                    
                    
                }
            ?>
    </div>


-->