<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>bootstrap.css.map">
    <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>bootstrap.min.css.map">
    <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>jquery.selectBoxIt.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>backend.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $css; ?>frontend.css">
</head>
<nav class="navbar navbar-inverse navbar-dark navbar-expand-lg bg-dark">
    <div class="container">
        <div class="nav-items-left">
            <a class="navbar-brand active " href="index.php">Home Page</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav"
                aria-controls="app-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="nav-items-left">
            <div class="collapse navbar-collapse navbar-right navbar-nav nav" id="app-nav">
                <ul class="mr-sm-3 navbar-nav navbar-right">
                    <?php 
                    // Get main categories
                    $categories = getSqlData("*", "categories", "WHERE Visibility=1 AND parent=0" , "Name", "ASC");
                    foreach ($categories as $category){
                    echo  '<li class=" nav-item ">';
                        echo '<a class="nav-link " href="categories.php?pageid='.$category['ID'].'">';
                            echo $category['Name'];
                        echo '</a>';
                    echo '</li>';
                    // Get Child Categories
                    $childCats = getSqlData("*", "categories", "WHERE parent ={$category['ID']}" , "Name", "ASC");
                    if(!empty($childCats)){ ?>
                    <li class=" nav-item ">
                        <a class="nav-link " href="categories.php?pageid=<?php echo $category['ID']; ?>">
                            <?php echo $category['Name']; ?>
                        </a>
                    </li>
                    <ul class='list-unstyled'>
                        <?php
                        foreach ($childCats as $child) {
                            echo '<li class=" nav-item "> <a class="nav-link " href="categories.php?pageid=' . $child['ID'] . '">' . $child['Name'] . '</a></li>';
                        }
                        echo '</ul>';
                        ?>
                        <?php } 
                }?>
                    </ul>
                    <?php if(isset($_SESSION['user'])){ ?>
                    <div class="btn btn-group my-info ">
                        <div class="justify-content-between ">
                            <img class="rounded-circle" src="images/avatar.jpg" alt="User Image">
                            <button type="button" class="btn btn-secondary  dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <?php echo $sessionUser; ?>
                            </button>
                            <ul class="dropdown-menu">
                                <li> <a class="dropdown-item btn btn-primary" href="profile.php#my-profile"> My
                                        Profile</a></li>
                                <li> <a class="dropdown-item" href="logout.php"> Logout </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li> <a class="dropdown-item" href="items.php"> Items </a></li>
                                <li> <a class="dropdown-item" href="profile.php#my-items"> My Items </a></li>
                                <li> <a class="dropdown-item" href="newitem.php"> New Item </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li> <a class="dropdown-item" href="profile.php#my-comments"> My Comments </a></li>
                                <li> <a class="dropdown-item" href="newcomment.php"> New Comment </a></li>
                            </ul>
                        </div>
                    </div>
                    <?php
        }else{
                        ?>
                    <a class="btn btn btn-secondary" href="login.php">
                        <span class="pull-right">
                            Login/Signup
                        </span>
                    </a>
                    <?php 
    }
    ?>
            </div>
        </div>
    </div>
</nav>

<body>
