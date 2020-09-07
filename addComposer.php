<?php
include 'boilerplate.php';
/*not current. See addPeople.php*/
if($debug) {
  echo <<<_END
    <p>add composer-20</p>

_END;
}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

$bookID = $_POST['bookID'];
$compositionID = $_POST['compositionID'];
$composerID = $_POST['composerID'];


echo <<<_END

  <div class="container-fluid bg-light pt-4 pb-4">
    <h2> Please enter Composer information below.</h2>
    <div class="row">
      <div class="col-md-6">
        <form action='composerOptions.php' method='post'>
          <div class="form-group pt-4">
_END;

if(isset($_SESSION['addComposer_validationFailed'])) {  /*We only set this value if validation failed*/ 
echo <<<_END

            
            First Name: <input class="form-control" type="text" name="composerFirstName" value="{$_SESSION['addComposer_composerFirstName_value']}"/><br/>
            Middle Name: <input  class="form-control" type="text" name="composerMiddleName" value="{$_SESSION['addComposer_composerMiddleName_value']}"/><br/>
            Last Name: <span class="error">{$_SESSION['composerLastNameErr']}</span>
            <input  class="form-control" type="text" name="composerLastName" value="{$_SESSION['addComposer_composerLastName_value']}"/><br/>
            Suffix: <input class="form-control"  type="text" name="composerSuffix" value="{$_SESSION['addComposer_composerSuffix_value']}"/><br/>
            <input class="btn btn-secondary" type='submit' value='Submit and Continue'/><br/>
            <input type='hidden' name="bookID" value="{$_SESSION['bookID']}"/>
            <input type='hidden' name="composerID" value="{$_SESSION['composerID']}"/>
            <input type='hidden' name="compositionID" value="{$_SESSION['compositionID']}"/>
_END;

}else{
  echo<<<_END

            First Name: <input class="form-control" type="text" name="composerFirstName"/><br/>
            Middle Name: <input  class="form-control" type="text" name="composerMiddleName"/><br/>
            Last Name: <input  class="form-control" type="text" name="composerLastName"/><br/>
            Suffix: <input class="form-control"  type="text" name="composerSuffix"/><br/>
            <input class="btn btn-secondary" type='submit' value='Submit and Continue'/><br/>
            <input type='hidden' name="bookID" value="$bookID"/>
            <input type='hidden' name="compositionID" value="$compositionID"/>
            <input type='hidden' name="composerID" value="$composerID"/>

_END;
}/*end if isset Session addComposer_validationFailed*/ /*End Else*/
echo<<<_END

          </div>  <!-- end form-group -->
        </form>  <!-- end form -->
      </div>  <!-- end col -->
    </div>  <!-- end row -->
  </div>  <!-- end container -->

_END;

/*destroy session variables*/
unset($_SESSION['addComposer_validationFailed']);
unset($_SESSION['addComposer_editorFirstName_value']);
unset($_SESSION['addComposer_editorMiddleName_value']);
unset($_SESSION['addComposer_editorLastName_value']);
unset($_SESSION['addComposer_editorSuffix_value']);
unset($_SESSION['composerLastNameErr']);
unset($_SESSION['bookID']);
unset($_SESSION['composerID']);
unset($_SESSION['compositionID']);








include 'footer.php';
include 'endingBoilerplate.php';

?>










