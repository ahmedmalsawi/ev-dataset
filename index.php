<?php
ob_start();
session_start();
$pageTitle="Home Page";
include 'init.php';

if(!isset($_SESSION['user'])){
    header("Location:login.php"); // redirect to Home page
}


$items=getAll('items');

    $query = "WHERE regStatus=1";
    $items = getData('*', 'items', 1000,'item_ID', 'DESC',$query);
    ?>
<div class="container">
    <div class="row row-cols-md-3 g-4">
        <?php foreach($items as $item){ ?>
            <div class="col-sm-6 col-md-3">
                <div class="card h-100"> 
                    <div class="card-title"> 
                        <div class="img-thumbnail item-box">
                            <span class="price-tag">
                                <?php echo $item['Price']; ?>
                                SR
                            </span>
                            <img class="img-responsive img-fluid" src="images/avatar2.jpg" alt="">
                        </div>
                        <div class="card-body"> 
                        <div class="caption">
                            <h3>
                                <a class="btn btn-outline-secondary blockquote d-flex text-center" 
                                href="items.php?Item_ID=<?php echo $item['Item_ID'];?>"><?php echo $item['Name'];?></a>
                            </h3>
                            <p class="card-text">
                                <?php echo $item['Description']; ?>
                            </p>
                            <div class="add-dated card-footer text-center link-dark">
                                <?php  echo $item['Add_Date']; ?>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php
include $tpl. "footer.php";
ob_end_flush();
?>