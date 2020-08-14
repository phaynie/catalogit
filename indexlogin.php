<?php
include 'boilerplate.php';

if($debug) {
    echo <<<_END

 <p>indexlogin.php-48</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

?>


    <main>
        <div class="container-fluid bg-light pt-4 pb-2">
            <div class="row">
                <div class="col-md-6 ">
                    <?php
                    if(isset($_SESSION['userId'])) {
                        echo '<p class="login-status">You are logged in!</p>';
                    }else{
                        echo '<p class="login-status">You are logged out!</p>';
                    }
                    ?>

                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container 1 -->
    </main>









<?php

include 'footer.html';
include 'endingBoilerplate.php';



?>