<?php
/*This is a unique navbar created for  index.php This nav will be seen when the user has not logged in yet.*/


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

                    <li class="nav-item">
                        <a class="nav-link" href="answer.php">Answer-it</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About-it</a>
                    </li>
                    <li>
                        <a class="nav-link " href="contact.php">Contact-it</a>
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
                  <h5 class="nav-item burnt ">Login to Continue</h5>';
              }

              echo<<<_END

            </div>

      </div><!-- end container -->
    </nav>
</header>

_END;


?>