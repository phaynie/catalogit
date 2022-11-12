<?php

$debug = true;
$debug_string = "";

// setcookie("XDEBUG_SESSION_START", "PHPSTORM");

  session_start();
  
$sessionUserId = "";

if(isset($_SESSION['userId'])){
    $sessionUserId = $_SESSION['userId'];
}


if($debug) {
    print_r($_SESSION);
    echo "<br>Session userId = " . $sessionUserId . "<br>";
   
} /*end debug*/

/*if no session user id and not already on index.php or answer it, or about it, or contact it, then redirect to index.php*/
/*Boiler plate is not a good place for this code. There are too many contingencies. It needs to be put on each page.*/
$pageName = $_SERVER['PHP_SELF'];

// load pages that can be seen without being logged in into array or list

// change logic below to check if $pageName is not in the list

$openPage = array(
        "/index.php",
        "/userLogin.php",
        "/login_script.php",
        "/indexlogin.php",
        "/about.php",
        "/answer.php",
        "/contact.php",
        "/logout_script.php");


if(!isset($_SESSION['userId'])  &&  !in_array($pageName, $openPage, TRUE )) {
            header("Location: index.php");
}





include 'not4git.php';

$adminStatus = ""; 
$sessionUserID = ""; 





if($debug) {
    echo("<br/>site / dbname = ");
    print_r($db);
    echo("<br/>");
} /*end debug*/



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
      integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    <title>CatalogitBoilerplate</title>
  </head>

<body class="container-fluid bg-light mt-5 ">

<?php

//Establish variables to create connection to the db
$hn = 'localhost';  //server name
$un = 'cleverbu_dbuser';       //user name
/*password comes from not4git.php*/

  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");

$primaryKeyName ="ID";
$tableName = "books";

/*Let's print out what is in the post and Get array each time this page wakes up.*/
if($debug) {
    echo <<<_END
    <h5> POST VALUES </h5>

_END;

    foreach ($_POST as $key => $value)
        echo $key . '=' . $value . '<br />';
} /*end debug*/

if($debug) {
    echo <<<_END
    <h5> GET VALUES </h5>

_END;

    foreach ($_GET as $key => $value){
        
        if(is_array($value)){
            echo $key . '=' . print_r($value);
        }
        else {
        echo $key . '=' . $value . '<br />';
        }
    }
} /*end debug*/

/*function getNameFromString($mystring){
    return substr($mystring, strpos($mystring, '-')+1);
}*/


/*This was the second original function. Name doesn't really make sense for my code.*/
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

/*Here we are using the same code as above but with a better name. When all the names in the code body have been changed I will erase above test-input function.*/
function cleanup_post($data) {
  
  $data = trim($data);
  /*$data = stripslashes($data);*/
  /*$data = htmlspecialchars($data);*/
 
  return $data;
}

/*this function is used for the form values that can have more than one option and are returned in an array keysig, genre, instrument*/
/*In order to be able to directly modify array elements within the loop precede $value with &*/
/*Reference of a $value and the last array element remain even after the foreach loop. It is recommended to destroy it by unset().*/
function cleanup_post_array($data) {
  foreach ($data as &$arrayElement) {
    $arrayElement = trim($arrayElement);
    $arrayElement = stripslashes($arrayElement);
    $arrayElement = htmlspecialchars($arrayElement);
  } /*end for each*/
  return $data;
  unset($data);
}

function strip_array_before_insert($conn, $var) {
    foreach ($var as &$arrayElement) {
        $arrayElement = $conn->real_escape_string($arrayElement);
    }/*end for each*/
    return $var;
    unset($var);

}



if (isset($_POST['delete']) && isset($_POST[$primaryKeyName]))
  {
    $primaryKeyValue   = get_post($conn, $primaryKeyName);
    $query  = "DELETE FROM " . $tableName . " WHERE " . $primaryKeyName . "= " . $primaryKeyValue;
    $result = $conn->query($query);
    if (!$result) echo("Error description !result: " . mysqli_error($conn));
  }

  /*here is where we sanitize variables before we save them in the database*/
  /*real_escape_string   Escapes special characters in a string for use in an SQL statement, taking into account the current charset of the connection*/

  /*This was the first original function. Name doesn't really make sense for my code.*/
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }

  
/*Here we are using the same code as above but with a better name. When all the names in the code body have been changed I will erase above get_post function.*/
  function strip_before_insert($conn, $var)
  {
    return $conn->real_escape_string($var);
  }

/*Using a variable function trick so we can encode variables inside heredocs
value = "$fn_encode($stringtoencode)"*/
function fn_encode($data) {
    return htmlspecialchars($data, ENT_QUOTES);
}
$fn_encode = 'fn_encode';




/*Function created to make user aware the database action was not successful*/
function failureToExecute($result, $errorNumber, $action) {
    if (!$result) {
        echo "<h2 class='db_error' > Error# $errorNumber : Database $action was not successful. Contact the Administrator.</h2><br/><br/>";
        exit();
    }
}



  ?>