<!-- boiler plate and nav bar included in all pages. Will make this an include eventually. -->
<?php
$disabled = "";
if(!isset($_SESSION['userId'])) {
    $disabled = 'disabled';
    $welcomeLink = "<a class='nav-link ' href='index.php''>Welcome!</a>";
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
                    <li class="nav-item">
                        $welcomeLink
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