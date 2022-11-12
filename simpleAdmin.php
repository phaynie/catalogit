<?php
include 'boilerplate.php';



if($debug) {
    echo <<<_END

 <p>simpleAdmin.php-48</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

?>

    <main>
        <div class="container-fluid bg-light pt-4 pb-4">
            <div class="row">
                <div class="col-sm-10 offset-sm-1 text-center">
                    <img class="img-responsive" src="images/crudelogo3.png"/>
                    <h1 class="display-3 pb-4">Admin</h1>
                </div><!--end col 1-->
                <?php
                if(isset($_GET['error'])) {
                    if($_GET['error'] == "emptyfields") {
                        echo "<p class='error'>Fill in all fields!</p>";
                    }else if ($_GET['error'] == "invaliduidmail"){
                        echo "<p class='error'>Invalid username and email!</p>";
                    }else if ($_GET['error'] == "invaliduid"){
                        echo "<p class='error'>Invalid username!</p>";
                    }else if ($_GET['error'] == "invalidmail"){
                        echo "<p class='error'>Invalid e-mail!</p>";
                    }else if ($_GET['error'] == "passwordcheck"){
                        echo "<p class='error'>Your passwords do not match!</p>";
                    }else if ($_GET['error'] == "usertaken"){
                        echo "<p class='error'>Username is already taken!</p>";
                    }
                }else if($_GET['admin'] == "success") {
                    echo "<p class='signupsuccess'>Signup successful!</p>";
                }
                ?>
                

            <div class="col-sm-6 offset-sm-3 ">
                <div class="info-form"></div>
                <form class="justify-content-center" action="admin_func.php" method="post">
                    <div class="form-group">
                        <h3>Add Login Information to a database</h3>

                       

                        

                        
                        <label for="uid">Username</label>
                        <input class="form-control" type="text" name="uid" value="<?echo $_GET['uid']?>"><br/>

                        <label for="mail">E-mail Address</label>
                        <input class="form-control" type="text" name="mail" value="<?echo $_GET['mail']?>"><br/>

                        <label for="pwd">Password</label>
                        <input class="form-control" type="password" name="pwd"><br/>

                        <label for="pwd-repeat">Repeat Password</label>
                        <input class="form-control" type="password" name="pwd-repeat"><br/>
                        <button class="btn btn-secondary-outline btn-sm mb-4" role="button" type="submit" name="admin-submit">Add Login Info</button><br>
                    </div> <!--end form-group-->
                </form>
            </div><!--end info-form-->
        </div><!--end col-->


        

       

        </div><!--end row-->
        </div> <!--end container-->

    </main>



<?php


?>





include 'footer.php';
include 'endingBoilerplate.php';



?>