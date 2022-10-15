<?php
include 'boilerplate.php';

if($debug) {
    echo '<p>userLogin-54</p>';
}/*end debug*/

include 'beginningNav.php';

?>


<div class="container  pb-4">
    
    <div class="row">
        <div class="col-sm-10 offset-sm-1 text-center">
            
<?php

if($_GET['signup'] == "success") {
   ?>
    <h1 class='text-center signupsuccess'>Signup successful!</h1>
<?php

}

?>
            
            
            <h1 class="pb-4 pt-4"> Log in to Continue</h1>
        </div><!--end col 1-->
        
        
        <div class="col-sm-6 offset-sm-3 ">
            <div class="info-form">
                <form class=" justify-content-center" action="login_script.php" method="post">
                    <div class="form-group">
                        <label for="mailuid">Username or Email</label>
                        <input class="form-control" type="text" id="mailuid" name="mailuid" ><br>
                        <label for="pwd">Password</label>  
                        <input class="form-control" type="password" id="pwd" name="pwd" ><br>
                        <button class="btn btn-secondary-outline btn-sm mb-4" type="submit" >Login</button><br>
                        <input type='hidden' name='loginSubmit'  value='true'>
                    </div> <!--form-group--->
                </form>
                
            </div> <!--end info-form-->
        </div> <!--end col-->
    </div> <!--end row-->
</div> <!--end container-->
<?php


include 'footer.php';
include 'endingBoilerplate.php';



?>



