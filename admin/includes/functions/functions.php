<?php
// title function that echo page title in case the page has the variable page title and echo default for other page

function getTitle()
{
    global $pageTitle;
    if (isset($pageTitle)) {
        echo $pageTitle;
    } else {
        echo 'default';
    }
}
// Redirect to Home function  V.1.0
// Message + time before reload
/*
  Redirect to Home function  V.2.0
 msg + + url + time
 
 
 */
function redirectToHome($errMsg, $seconds = 3,$type = null,$url = null)
{
    if ($url == 'members') {
        $url = 'members.php';
        $urlName= 'Members Page';
    }elseif ($url == 'categories') {
        $url = 'categories.php';
        $urlName= 'Categories Page';
    }elseif ($url == 'comments') {
        $url = 'comments.php';
        $urlName= 'Comments Page';
    }elseif ($url == 'items') {
        $url = 'items.php';
        $urlName= 'Items Page';
    }elseif ($url == 'home') {
        $url = 'index.php';
        $urlName= 'Home Page';
    }elseif($url == 'back'){
        $urlName= 'Previous Page';
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== null){
            $url = $_SERVER['HTTP_REFERER'];
        }
        $url = 'index.php';
    }elseif ($url == null) {
            $url = 'index.php';
            $urlName= 'Home Page';
    }
    
    if ($type == 'danger') {
        $type = 'alert alert-danger';
    } elseif ($type == 'success') {
        $type = 'alert alert-success';
    } elseif ($type == 'info') {
        $type = 'alert alert-info';
    }elseif ($type == null) {
        $type = 'alert alert-success';
    }
// for($i=$sec;$i<=0;$i--){
//             echo "<div class='text-center ".$type."'>" . $errMsg . '</div>';
//             echo "<div class='alert alert-info text-center'> You wil be redirected to ".$urlName." after " . $i . ' Seconds.</div>';
//             header("refresh:$i;url=$url");
//         };
//     echo $write;
    
            echo "<div class='text-center ".$type."'>" . $errMsg . '</div>';
            echo "<div class='alert alert-info text-center'> You wil be redirected to ".$urlName." after " . $seconds . ' Seconds.</div>';
            header("refresh:$seconds;url=$url");
    exit();
}

//check for existing items
function checkItem($select, $from, $value)
{
    global $con;
    $statment = $con->prepare("SELECT * FROM $from WHERE $select = '$value'");
    $statment->execute();
    $count = $statment->rowCount();
    return $count;
}



// Get row count <V class="1">

function countItems($item, $table){
    global $con;
    $stmt2=$con->prepare("SELECT COUNT($item) FROM $table");
    $stmt2->execute();
    return $stmt2->fetchColumn();

};

function countPending($item, $table,$cond){
    global $con;
    $stmt2=$con->prepare("SELECT COUNT($item) FROM $table WHERE $cond");
    $stmt2->execute();
    return $stmt2->fetchColumn();
    
};

// Get latest Records Function  [ users, items, comments]

function getLatestRecords($select, $table, $limit=5, $order='userId', $arrange='DESC', $query=""){
    global $con;
/*     if ($query = null){
    $query = "";
    }else{
    $query = "WHERE ".$query;
    } */
    $getStmt=$con->prepare("SELECT $select FROM $table $query ORDER BY $order $arrange  LIMIT $limit ");
    $getStmt->execute();
    $rows=$getStmt->fetchAll();
return $rows;

};


// Get Records Function  Advanced

function getSqlData($field, $table, $where="", $orderField="", $oredering='DESC'){
    global $con;
    $getStmt=$con->prepare("SELECT $field FROM $table $where ORDER BY $orderField $oredering");
    $getStmt->execute();
    $all=$getStmt->fetchAll();
return $all;
};