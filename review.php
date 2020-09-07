<?php


include 'boilerplate.php';

if($debug) {

    echo <<<_END

        <p>review.php-4</p>

_END;

}/*end debug*/

include 'beginningNav.php';


/*Intialize variables*/

$submit="";


/*create local variables for REQUEST values*/


if(isset($_REQUEST['submit'])) {
    $submit = $_REQUEST['submit'];
}



/*We will validate the review information
Figure out where to send the review info for processing or displaying
create header back to exitMessage.php. */

if($submit =="") {
    echo <<<_END
    
    <h3 class= "display-4 text-center">Thank you for stopping by Review-it!</h3><br><br>
    <div class="container">
        <div class= "row">
            <div class="col">
                <h4 class="text-center" style="color:brown;">*CURRENTLY UNDER CONSTRUCTION*</h4>
                <p class="text-center">are you a teacher, student, instrumentalist, musician</p>
                <p class="text-center">general like/dislike</p>
                <p class="text-center">Overall look and feel of the app</p>
                <p class="text-center">Does this app have the things you are looking for in a music library?</p>
                <p class="text-center">What functionality would you like to see that does not exist?</p> 
                <p class="text-center">Did you have trouble with any part of the Library?</p>
                <p class="text-center">What is your favorite part of this app?</p> 
                <p class="text-center">Comments:</p>
                <p class="text-center">text box</p>
        
                <form action="review.php" method="post">
                    <input class="btn btn-secondary mt-4" type="submit" value="submit Review "/>
                    <input type="hidden" name="submit" value="true"  />       
                </form>   <!-- end form -->
                <form action="displayBook.php" method="post">
                    <input class="btn btn-secondary mt-4" type="submit" value="Cancel "/>
                    <input type="hidden" name="submit" value="true"  />       
                </form><br><br>   <!-- end form -->
            </div><!-- end col --> 
        </div><!-- end row -->
    </div> <!-- end container -->

_END;

} /*end if not submit*/


if($submit == 'true') {

    echo <<<_END


<div class="container">
    <div class= "row">
        <div class="col">
            <h3 class= "display-4 text-center mt-4">Thank you for stopping by Review-it!</h3><br><br>
            <h5 class= "text-center mossaccent" style="color:#309941;">I have received your review. </h5>
            <h5 class= "text-center mossaccent" style="color:#309941;">Thanks again!</h5><br><br>
            <form action="exitMessage.php" method="post">
                <input class="btn btn-secondary mt-4" type="submit" value="Exit Library "/>
             </form>   <!-- end form -->
            <form action="introPage.php" method="post">
                <input class="btn btn-secondary mt-4" type="submit" value="Return to IntroPage "/>
            </form>   <!-- end form -->
        </div><!-- end col --> 
    </div><!-- end row -->
</div> <!-- end container -->

_END;

}/*end if submit is true*/


include 'footer.php';
include 'endingBoilerplate.php';
?>
