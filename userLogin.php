<?php
include 'boilerplate.php';

if($debug) {
    echo '<p>userLogin-54</p>';
}/*end debug*/

include 'beginningNav.php';

echo<<<_END


<div class="container  pb-4">
    
    <div class="row">
        <div class="col-sm-10 offset-sm-1 text-center">
            
_END;

if($_GET['signup'] == "success") {
    echo<<<_END
    <h1 class='text-center signupsuccess'>Signup successful!</h1>
_END;

}

echo<<<_END
            
            
            <h1 class="pb-4 pt-4"> Login to Continue</h1>
        </div><!--end col 1-->
        
        
        <div class="col-sm-6 offset-sm-3 ">
            <div class="info-form">
                <form class=" justify-content-center" action="login_script.php" method="post">
                    <div class="form-group">
                        <label for="mailuid">Username or Email</label>
                        <input class="form-control" type="text" id="mailuid" name="mailuid" ><br>
                        <label for="pwd">Password</label>  
                        <input class="form-control" type="password" id="pwd" name="pwd" ><br>
                        <button class="btn btn-secondary-outline btn-sm mb-4" type="submit" name="login-submit">Login</button><br>
                    </div> <!--form-group--->
                </form>
                
            </div> <!--end info-form-->
        </div> <!--end col-->
    </div> <!--end row-->
</div> <!--end container-->
_END;


include 'footer.html';
include 'endingBoilerplate.php';



?>



