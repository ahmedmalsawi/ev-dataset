<?php
// title function that echo page title in case the page has the variable page title and echo default for other page

function getAll($table){
    global $con;
    $getAll=$con->prepare("SELECT * FROM $table");
    $getAll->execute();
    $all=$getAll->fetchAll();
return $all;
};


// Get Records Function  Advanced

function getSqlData($field, $table, $where="", $orderField="", $oredering='DESC'){
    global $con;
    $getStmt=$con->prepare("SELECT $field FROM $table $where ORDER BY $orderField $oredering");
    $getStmt->execute();
    $all=$getStmt->fetchAll();
return $all;
};

// Get latest Records Function  [ users, items, comments]

function getData($select, $table, $limit=500, $order='userId', $arrange='DESC', $query=""){
    global $con;
    $getStmt=$con->prepare("SELECT $select FROM $table $query ORDER BY $order $arrange  LIMIT $limit ");
    $getStmt->execute();
    $rows=$getStmt->fetchAll();
return $rows;
};
function getItems($id){
    global $con;
    $getStmt=$con->prepare("SELECT * FROM items WHERE Cat_ID=13 ORDER BY Item_ID DESC ");
    $getStmt->execute();
    $rows=$getStmt->fetchAll();
return $rows;
};


//$query = "WHERE item_id=".$_GET['pageid'];
//$items = getItems('*', 'items', 1000,'item_Id', 'DESC',$query);



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
function checkItem($select, $from, $value,$query=" ")
{
    global $con;
    $statment = $con->prepare("SELECT * FROM $from WHERE $select = '$value' $query");
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

function filter_content($text, $tags = '', $invert = FALSE) {

  preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
  $tags = array_unique($tags[1]);
   
  if(is_array($tags) AND count($tags) > 0) {
    if($invert == FALSE) {
      return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
    }
    else {
      return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
    }
  }
  elseif($invert == FALSE) {
    return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
  }
  return $text;
}


// -----------------------------------------------------------------------------------------
// ------------------------------- SANITAIZE  V2 -------------------------------------------
// -----------------------------------------------------------------------------------------

function filter_string(string $string): string
{
    $str = preg_replace('/x00|<[^>]*>?/', '', $string);
    return str_replace(["'", '"'], ['&#39;', '&#34;'], $str);
}

// -----------------------------------------------------------------------------------------
// ------------------------------- SANITAIZE  V3 -------------------------------------------
// -----------------------------------------------------------------------------------------


const FILTERS = [
    // 'string' => FILTER_SANITIZE_STRING,
    // 'string[]' => [
        // 'filter' => FILTER_SANITIZE_STRING,
        // 'flags' => FILTER_REQUIRE_ARRAY
    // ],
    'email' => FILTER_SANITIZE_EMAIL,
    'int' => [
        'filter' => FILTER_SANITIZE_NUMBER_INT,
        'flags' => FILTER_REQUIRE_SCALAR
    ],
    'int[]' => [
        'filter' => FILTER_SANITIZE_NUMBER_INT,
        'flags' => FILTER_REQUIRE_ARRAY
    ],
    'float' => [
        'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
        'flags' => FILTER_FLAG_ALLOW_FRACTION
    ],
    'float[]' => [
        'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
        'flags' => FILTER_REQUIRE_ARRAY
    ],
    'url' => FILTER_SANITIZE_URL,
];

/**
* Recursively trim strings in an array
* @param array $items
* @return array
*/
function array_trim(array $items): array
{
    return array_map(function ($item) {
        if (is_string($item)) {
            return trim($item);
        } elseif (is_array($item)) {
            return array_trim($item);
        } else
            return $item;
    }, $items);
}

/**
* Sanitize the inputs based on the rules an optionally trim the string
* @param array $inputs
* @param array $fields
* @param int $default_filter FILTER_SANITIZE_STRING
* @param array $filters FILTERS
* @param bool $trim
* @return array
*/
function sanitize(array $inputs, array $fields = [], int $default_filter = FILTER_SANITIZE_STRING, array $filters = FILTERS, bool $trim = true): array
{
    if ($fields) {
        $options = array_map(fn($field) => $filters[$field], $fields);
        $data = filter_var_array($inputs, $options);
    } else {
        $data = filter_var_array($inputs, $default_filter);
    }

    return $trim ? array_trim($data) : $data;
}



// -----------------------------------------------------------------------------------------
// ------------------------------- SANITAIZE -----------------------------------------------
// -----------------------------------------------------------------------------------------
