<?php
include 'boilerplate.php';
/*Not current see addPeople.php*/
if($debug) {
    echo <<<_END

<p>addArranger-23</p>

_END;
}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';
 
$bookID = $_POST['bookID'] ; 
$compositionID = $_POST['compositionID']; 

echo <<<_END

  <div class="container-fluid bg-light pt-4 pb-3">
    <h2>Please enter arranger info below</h2>
    <div class="row">
      <div class="col-md-6">
        <form action='arrangerOptions.php' method='post'>
          <div class="form-group pt-4">
_END;

          if(isset($_SESSION['addArranger_ValidationFailed'])) {
            echo<<<_END
            First Name: <input class="form-control" type="text" name="arrangerFirstName" value="{$_SESSION['addArranger_arrangerFirstName_value']}"/><br/>
            Middle Name: <input class="form-control"  type="text" name="arrangerMiddleName" value="{$_SESSION['addArranger_arrangerMiddleName_value']}"/><br/>
            Last Name: <span class="error">{$_SESSION['arrangerLastNameErr']}</span>
            <input class="form-control"  type="text" name="arrangerLastName" value="{$_SESSION['addArranger_arrangerLastName_value']}"/><br/>
            Suffix: <input class="form-control"  type="text" name="arrangerSuffix" value="{$_SESSION['addArranger_arrangerSuffix_value']}"/><br/>
            <input class="btn btn-secondary" type='submit' value='Continue'/>
            <input type='hidden' name='bookID' value="{$_SESSION['bookID']}"/>
            <input type='hidden' name='compositionID' value="{$_SESSION['compositionID']}"/>
_END;

          }else{
          echo<<<_END

            First Name: <input class="form-control" type="text" name="arrangerFirstName"/><br/>
            Middle Name: <input class="form-control"  type="text" name="arrangerMiddleName"/><br/>
            Last Name: <input class="form-control"  type="text" name="arrangerLastName"/><br/>
            Suffix: <input class="form-control"  type="text" name="arrangerSuffix"/><br/>
            <input class="btn btn-secondary" type='submit' value='Continue'/>
            <input type='hidden' name='bookID' value='$bookID'/>
            <input type='hidden' name='compositionID' value='$compositionID'/>
_END;
          }/*end if(isset($_SESSION['addArranger_ValidationFailed']))*/
          echo<<<_END

          </div>  <!-- end form-group -->
        </form> <!-- end form -->
      </div>  <!-- end col -->
    </div>  <!-- end row -->
  </div>  <!-- end container -->

_END;


/*destroy session variables*/
/*ask Ken about parent session variables   $_SESSION['parentKey']['key'] */
unset($_SESSION['addArranger_validationFailed']);
unset($_SESSION['addArranger_arrangerFirstName_value']);
unset($_SESSION['addArranger_arrangerMiddleName_value']);
unset($_SESSION['addArranger_arrangerLastName_value']);
unset($_SESSION['addArranger_arrangerSuffix_value']);
unset($_SESSION['arrangerLastNameErr']);
unset($_SESSION['bookID']);
unset($_SESSION['arrangerID']);
unset($_SESSION['compositionID']);



include 'footer.php';
include 'endingBoilerplate.php'

?>





