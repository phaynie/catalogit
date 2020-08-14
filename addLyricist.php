<?php
include 'boilerplate.php';
/*Not current. See addPeople.php*/
if($debug) {
    echo <<<_END

<p>addLyricist-26</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

$bookID = $_POST['bookID'];
$compositionID = $_POST['compositionID'];  

echo <<<_END
  <div class="container bg-light pt-4 pb-3">
    <h2>Please Enter Lyricist Info Below</h2>
    <div class="row">
      <div class="col-md-6">
        <form action='lyricistOptions.php' method='post'>
          <div class="form-group pt-4">

_END;

          if(isset($_SESSION['addLyricist_validationFailed'])) {
            echo<<<_END
            First Name: <input class="form-control" type="text" name="lyricistFirstName" value="{$_SESSION['addLyricist_lyricistFirstName_value']}"/><br/>
            Middle Name: <input class="form-control" type="text" name="lyricistMiddleName" value="{$_SESSION['addLyricist_lyricistMiddleName_value']}"/><br/>
            Last Name: <span class="error">{$_SESSION['lyricistLastNameErr']}</span>
            <input class="form-control" type="text" name="lyricistLastName" value="{$_SESSION['addLyricist_lyricistLastName_value']}"/><br/>
            Suffix: <input class="form-control" type="text" name="lyricistSuffix" value="{$_SESSION['addLyricist_lyricistSuffix_value']}"/><br/>
            <input class="btn btn-secondary" type='submit' value='Continue'/>
            <input type='hidden' name='bookID' value= "{$_SESSION['bookID']}" />
            <input type='hidden' name='compositionID' value= "{$_SESSION['compositionID']}" />

_END;

          }else{
            echo<<<_END
          
            First Name: <input class="form-control" type="text" name="lyricistFirstName"/><br/>
            Middle Name: <input class="form-control" type="text" name="lyricistMiddleName"/><br/>
            Last Name: <input class="form-control" type="text" name="lyricistLastName"/><br/>
            Suffix: <input class="form-control" type="text" name="lyricistSuffix"/><br/>
  
            <input class="btn btn-secondary" type='submit' value='Continue'/>
            <input type='hidden' name='bookID' value= $bookID />
            <input type='hidden' name='compositionID' value= $compositionID />
_END;

          } /*end if(isset(addLyricist_validationFailed))*/
          echo<<<_END

          </div> <!-- end form-group -->
        </form>  <!-- end form -->
      </div> <!-- end col -->
    </div> <!-- end row -->
  </div> <!-- end container -->

_END;


/*destroy session variables*/
/*ask Ken about parent session variables   $_SESSION['parentKey']['key'] */

unset($_SESSION['lyricistLastNameErr']);
unset($_SESSION['addLyricist_validationFailed']);
unset($_SESSION['addLyricist_lyricistFirstName_value']);
unset($_SESSION['addLyricist_lyricistMiddleName_value']);
unset($_SESSION['addLyricist_lyricistLastName_value']);
unset($_SESSION['addLyricist_lyricistSuffix_value']);
unset($_SESSION['bookID']);
unset($_SESSION['compositionID']);

include 'footer.html';
include 'endingBoilerplate.php';

?>



