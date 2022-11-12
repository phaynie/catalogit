<!-- boiler plate and nav bar included in all pages. Will make this an include eventually. -->
<?php
$welcomeLink = "";
$disabled = "";

if(!isset($_SESSION['userID'])) {
    $disabled = 'disabled';
    $welcomeLink = "<a class='nav-link ' href='index.php'>Welcome!</a>";
    
}

/*ADMIN STATUS*/
$adminTab = "";
$sessionUserID = "";
$currentUserName = "";
$currentUserAdmin = "";
$adminStatus = ""; 


/*Trying to address warning Undefined Array key "userId in beg nav.php on line 20"
$sessionUserID = $_SESSION['userId']; 
foreach ($sessionUserID as $key => $value){
    echo "key = " . $key . "<br>
    value = " . $value . "<br>";
}*/



$adminStatusQuery = "SELECT *
FROM users
WHERE idUsers = $sessionUserID";

$adminStatusQueryResult = $conn->query($adminStatusQuery);


if ($debug) {
   echo 'adminStatusQuery = ' . $adminStatusQuery . '<br/><br/>';
    if (!$adminStatusQueryResult) {
        $queryError = "\n Error description: adminStatusQuery " . mysqli_error($conn) . "\n<br/>";
        
    }
}/*end debug*/

if ($adminStatusQueryResult) {
    $numberOfAdminStatusQueryRows = $adminStatusQueryResult->num_rows;

    for ($j = 0; $j < $numberOfAdminStatusQueryRows; ++$j) {
        $row = $adminStatusQueryResult->fetch_array(MYSQLI_NUM);

        $currentUserID = $row[0];
        $currentUserName = $row[1];
        $currentUserEmail = $row[2];
        $currentUserPwd = $row[3];
        $currentUserAdminStatus = $row[4];

    }
    if($currentUserAdminStatus == false){
    $adminStatus = "User";
    }elseif($currentUserAdminStatus == true){
    $adminStatus = "Admin";
    $adminTab = "";
    }
    if($debug){
    echo "currentUserName = " . $currentUserName . "<br>";
    echo "currentUserAdminStatus = " . $currentUserAdminStatus . "<br>";
    echo "adminStatus = " . $adminStatus . "<br>";
    }

    if($adminStatus == 'Admin' ) {
        $adminTab = "
        
        <li class='nav-item'>
                        <a class='nav-link $disabled' href='simpleAdmin.php'>Admin-it</a>
                    </li>";

    }
}


echo<<<_END

<header class="page-header font-small bg-secondary py-3">
    <nav class="navbar navbar navbar-expand-lg navbar-light bg-light">
         <div class="container-fluid ">
           <a class="navbar-brand" href="#">
           <img class="img-responsive" src="images/crudelogo3.png"
                /></a>

            <button
                class="navbar-toggler"
                data-toggle="collapse"
                data-target="#navbarNav"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item ">
                        <a class="nav-link $disabled" href="introPage.php">Home</a>
                    </li>
                    <span> $adminTab </span>
                    <li class="nav-item">
                        <a class="nav-link $disabled" href="introPage.php">Search-it</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link $disabled" href="answer.php">Answer-it</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About-it</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="contact.php">Contact-it</a>
                    </li>
                   <!-- <li class="nav-item">
                        <a class="nav-link $disabled" href="signup.php">Admin-it</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link $disabled" href="review.php">Review-it</a>
                    </li>
                   
                </ul>
            </div><!-- navbar-collapse -->
            
            
            <div>
            
_END;

              if(isset($_SESSION['userId'])) {
              echo '
                  <form action="logout_script.php" method="post"><br>
                  <button class="navButton"  type="submit" name="logout-submit">Logout</button><br>
                  </form> 
                  <h5 class="nav-item burnt"> You are Logged in!</h5>';
              }else{
              echo '
                  <form action="userLogin.php" method="post">   
                  <button class="navButton"  type="submit" name="login">Login</button>
                  </form>
                  <h5 class="nav-item burnt"> Log in to continue.</h5>';
              }

              echo<<<_END

            </div>
      </div><!-- end container -->
    </nav>
</header>







_END;


?>