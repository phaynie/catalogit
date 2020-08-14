<?php


include 'boilerplate.php';
if($debug) {
    echo <<<_END

<h3>compositionOnlySearch-45</h3>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';


    
echo<<<_END

<div class="container-fluid bg-light pt-4 pb-5">
    <form action='compositionOnlyOptions.php' method='post'>
        <div class="col-md-6">
        

_END;

            if(isset($_SESSION['compositionOnlySearch_validationFailed'])) {

            echo <<<_END

                Composition Title: <span class="error">{$_SESSION['searchCompositionTitleErr']}</span>
                <input class="form-control" type="text" name="searchCompositionTitle" value="{$_SESSION['compositionOnlySearch_searchCompositionTitle_value']}"/>
                <input class="btn btn-secondary mt-4" type='submit' value='Search for this composition'/>
                <input type='hidden' name="bookID" value='{$_SESSION['bookID']}'/>

_END;

            }else{
  
            echo <<<_END

                Composition Title:<input class="form-control" type="text" name="searchCompositionTitle"/>
                <input class="btn btn-secondary mt-4" type='submit' value='Search for this composition'/>
                <input type='hidden' name="bookID" value='$bookID'/>
        
_END;


            } /*end if isset $_SESSION'compositionOnlySearch_validationFailed'*/


            echo <<<_END
        
        </div> <!-- end col --> 
    </form>
</div><!-- end container -->

_END;



/*destroy session variables*/
unset($_SESSION['compositionOnlySearch_validationFailed']);
unset($_SESSION['compositionOnlySearch_searchCompositionTitle_value']);
unset($_SESSION['searchCompositionTitleErr']);




include 'footer.html';
include 'endingBoilerplate.php';



?>
