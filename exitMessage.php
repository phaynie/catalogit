<?php
include 'boilerplate.php';

if($debug) {
    echo <<<_END

 <p>exitMessage-15</p>

_END;

}/*end debug*/
$userPersonname = $_SESSION['userId'];
/*include 'beginningNav.html';*/
include 'beginningNav.php';


    /*there is no hidden value for the home button because no value allows it to be !isset returning our code to the first page of our file. */
    /*Exit button has not yet been worked out how to exit from the web site.*/

echo <<<_END

<h3 class="display-4 text-center">Thank you for using Catalog-it </h3>
<div class="container">
    <div class= "row">
        <div class="col-sm-6 offset-3">
            <p>I hope you liked my work in progress! </p>
            <p>Please leave a review if you like. </p>
            <p>I'd love to hear what features you would like to see. </p><br>
            <form action='introPage.php' method='post'>
                <input class="btn btn-secondary mt-4 " type='submit' value='Oops, Continue using Catalogit'/>
            </form>
  
            <form action='review.php' method='post'>   
                <input class="btn btn-secondary mt-4 " type='submit' value='Leave a Review'/>   
            </form>

            <form action='index.php' method='post'>  
                <input class="btn btn-secondary mt-4 "type='submit' value='Exit Library'/> 
                <input type='hidden' name="next" value=''/>  
            </form><br><br>
        </div><!-- end col --> 
    </div><!-- end row -->
</div> <!-- end container -->

_END;

include 'footer.html';
include 'endingBoilerplate.php';

?>




