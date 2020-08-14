<?php


include 'boilerplate.php';

if($debug) {
    echo <<<_END

<h3>composerOnlySearch-42</h3>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

$validationFailed = false;
$bookID = $_POST['bookID'];
$compositionID = $_POST['compositionID'];


/*here we display text box for composer's last name and button "Search for this Composer"
including the error messages should the $validationFailed be true */

    
  echo<<<_END

  <div class="container-fluid bg-light pt-4 pb-5">
    <form action='composerOnlyOptions.php' method='post'>
      <div class="col-md-6">
        <h5>Enter Composer's LAST NAME only</h5><br/>
_END;

if(isset($_SESSION['composerOnlySearch_validationFailed'])) {
  echo <<<_END
        Composer Last Name: <span class="error">{$_SESSION['searchComposerLastNameErr']}</span><input class="form-control" type="text" name="searchComposerLastName" value="{$_SESSION['composerOnlySearch_searchComposerLastName_value']}"/>

_END;

}else{
  echo <<<_END
        Composer Last Name: <input class="form-control" type="text" name="searchComposerLastName"/>

_END;

} /*end isset session composerOnlySearch_validationFailed*/

echo <<<_END

        <input class="btn btn-secondary mt-4" type='submit' value='Search for this composer'/>
      </div>
    </form>
  </div><!-- end container -->

_END;

 /*destroy session variables*/
 unset($_SESSION['composerOnlySearch_validationFailed']);
 unset($_SESSION['composerOnlySearch_searchComposerLastName_value']);
 unset($_SESSION['searchComposerLastNameErr']);
 unset($_SESSION['bookID']); /*one time to clear mistake erase this next time you see*/
 unset($_SESSION['compositionID']);



include 'footer.html';


include 'endingBoilerplate.php';




?>
