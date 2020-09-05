<?php
include 'boilerplate.php';
if($debug) {
    echo <<<_END

    <p>addPeople.php  58</p>
 
_END;

}/*end debug*/


include 'beginningNav.php';
/* We arrive at this page if
    -we are adding  a new book or composition to the library and have searched for an Editor, composer, arranger, or Lyricist (as a person) and found that the person is not already existing in the db and would like to add the information to the db.
    -we are editing a current book or composition and want to add or replace  a person and the new person is not already in the database and we would like to add the new information to the db.*/

/*This page
    -provides a form (and button) to submit new people (editor, composer, arranger, lyricist) information.
    -validates the submitted form information.
    -inserts validated information into the people table.
    -sends user by way of header to addRole.php to update(edit/replace) or add(add new) to B2R2P table or delete a row(delete) from B2R2P table .
*/

/*Initialize Variables*/
/*Don't need 'replace' variables because when we choose to replace, we go to peopleOptions.php and then if not found comes here as addNew.
Correction: We DO need replace to follow along with us, (although it won't be used on this page) because when we get to addRole.php replacing a person means updating junction tables while adding new people means inserting into Junction tables, so having the $replace variable will help us differentiate.*/

$debug_string = "";
$replaceEditor = "";
$replaceComposer = "";
$replaceArranger = "";
$replaceLyricist = "";
$replacePeople = "";
$addNewComposer = "";
$addNewArranger = "";
$addNewLyricist = "";
$addNewPeople = "";
$bookID = "";
$compositionID = "";
$editBook = "";
$editComposer = "";
$editArranger = "";
$editLyricist = "";
$editComposition = "";
$editPeople = "";
$editEditor = "";
$newPeopleID = "";
$oldPeopleID = "";
$addNewEditor = "";
$peopleFirstName = "";
$peopleMiddleName = "";
$peopleLastName = "";
$peopleSuffix = "";
$peopleLastNameErr = "";
$peopleFirstName_value = "";
$peopleMiddleName_value = "";
$peopleLastName_value = "";
$peopleSuffix_value = "";
$submit = "";


/*assigning variable names to post and get values*/

if(isset($_REQUEST['bookID']) && is_numeric($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if(isset($_REQUEST['replaceEditor'])) {
    $replaceEditor = $_REQUEST['replaceEditor'];
}

if(isset($_REQUEST['replaceComposer'])) {
    $replaceComposer = $_REQUEST['replaceComposer'];
}

if(isset($_REQUEST['replaceArranger'])) {
    $replaceArranger = $_REQUEST['replaceArranger'];
}

if(isset($_REQUEST['replaceLyricist'])) {
    $replaceLyricist = $_REQUEST['replaceLyricist'];
}

if(isset($_REQUEST['addNewEditor'])) {
    $addNewEditor = $_REQUEST['addNewEditor'];
}


if(isset($_REQUEST['addNewComposer'])) {
    $addNewComposer = $_REQUEST['addNewComposer'];
}

if(isset($_REQUEST['addNewArranger'])) {
    $addNewArranger = $_REQUEST['addNewArranger'];
}

if(isset($_REQUEST['addNewLyricist'])) {
    $addNewLyricist = $_REQUEST['addNewLyricist'];
}

if(isset($_REQUEST['compositionID']) && is_numeric($_REQUEST['compositionID'])) {
    $compositionID = $_REQUEST['compositionID'];
}

if(isset($_REQUEST['oldPeopleID']) && is_numeric($_REQUEST['oldPeopleID'])) {
    $oldPeopleID = $_REQUEST['oldPeopleID'];
}

if(isset($_REQUEST['editBook'])) {
    $editBook = $_REQUEST['editBook'];
}

if(isset($_REQUEST['editComposer'])) {
    $editComposer = $_REQUEST['editComposer'];
}

if(isset($_REQUEST['editArranger'])) {
    $editArranger = $_REQUEST['editArranger'];
}

if(isset($_REQUEST['editLyricist'])) {
    $editLyricist = $_REQUEST['editLyricist'];
}

if(isset($_REQUEST['editComposition'])) {
    $editComposition = $_REQUEST['editComposition'];
}

if(isset($_REQUEST['editEditor'])) {
    $editEditor = $_REQUEST['editEditor'];
}

if(isset($_REQUEST['newPeopleID']) && is_numeric($_REQUEST['newPeopleID'])) {
    $newPeopleID = $_REQUEST['newPeopleID'];
}


if(isset($_REQUEST['peopleFirstName'])) {
    $peopleFirstName = $_REQUEST['peopleFirstName'];
}

if(isset($_REQUEST['peopleMiddleName'])) {
    $peopleMiddleName = $_REQUEST['peopleMiddleName'];
}

if(isset($_REQUEST['peopleLastName'])) {
    $peopleLastName = $_REQUEST['peopleLastName'];
}

if(isset($_REQUEST['peopleSuffix'])) {
    $peopleSuffix = $_REQUEST['peopleSuffix'];
}



if(isset($_REQUEST['submit'])) {
    $submit = $_REQUEST['submit'];
}


/*logic*/
if($addNewEditor == 'true') {
    $sendAddNew = "<input type='hidden' name='addNewEditor' value= 'true' />";
    $role = "Editor";
    $addNewPeople = $addNewEditor;
}elseif($addNewComposer == 'true') {
    $sendAddNew = "<input type='hidden' name='addNewComposer' value= 'true' />";
    $role = "Composer";
    $addNewPeople = $addNewComposer;
}elseif($addNewArranger == 'true') {
    $sendAddNew = "<input type='hidden' name='addNewArranger' value= 'true' />";
    $role = "Arranger";
    $addNewPeople = $addNewArranger;
}elseif($addNewLyricist == 'true') {
    $sendAddNew = "<input type='hidden' name='addNewLyricist' value= 'true' />";
    $role = "Lyricist";
    $addNewPeople = $addNewLyricist;
}elseif($editEditor == 'true') {
    $sendEdit = "<input type='hidden' name='editEditor' value ='true' />";
    $role = "Editor";
    $editPeople = $editEditor;
}elseif($editComposer == 'true') {
    $sendEdit = "<input type='hidden' name='editComposer' value ='true' />";
    $role = "Composer";
    $editPeople = $editComposer;
}elseif($editArranger == 'true') {
    $sendEdit = "<input type='hidden' name='editArranger' value ='true' />";
    $role = "Arranger";
    $editPeople = $editArranger;
}elseif($editLyricist == 'true') {
    $sendEdit = "<input type='hidden' name='editLyricist' value ='true' />";
    $role = "Lyricist";
    $editPeople = $editLyricist;
}elseif($replaceEditor == 'true') {
    $sendReplace = "<input type='hidden' name='replaceEditor' value= 'true' />";
    $role = "Editor";
    $replacePeople = $replaceEditor;
}elseif($replaceComposer == 'true') {
    $sendReplace = "<input type='hidden' name='replaceComposer' value= 'true' />";
    $role = "Composer";
    $replacePeople = $replaceComposer;
}elseif($replaceArranger == 'true') {
    $sendReplace = "<input type='hidden' name='replaceArranger' value= 'true' />";
    $role = "Arranger";
    $replacePeople = $replaceArranger;
}elseif($replaceLyricist == 'true') {
    $sendReplace = "<input type='hidden' name='replaceLyricist' value= 'true' />";
    $role = "Lyricist";
    $replacePeople = $replaceLyricist;
}


if($editBook == 'true') {
    $sendEditBook = "<input type='hidden' name='editBook' value ='true' />";
    $formAction = "editBook.php";
    $page = 'Edit Book Options';
}elseif($editComposition == 'true') {
    $sendEditComposition = "<input type='hidden' name='editComposition' value ='true' />";
    $formAction = "editComposition.php";
    $page = 'Edit Composition Options';
}


$validationFailed = false;  /*A single place to track whether any validation has failed.*/

/*Validation code section
if $validationFailed is true, we will show form pre-populated with error messages and user can re-submit values.
if $validationFailed is false, we will wash data coming from the form.
If editing an existing book and validation is successful   we will go to addRole.php, update the B2R2P table and send the user by way of header to editBook.php
If adding a new book to the library and validation is successful  we will insert this new people info into the people table, go to addRole.php and add a new row to the B2R2P table connecting this person information to the book as an editor, composer, arranger or Lyricist. */


/*Validation*/

/*These values will be used in the form below to show us what we submitted and to make corrections*/
if($submit == 'true') {
    if (strlen($peopleLastName) == 0 ) {
        $peopleLastNameErr = "<span class='error'>  * Last Name of $role is required. </span>";
        $validationFailed = true;
    } /*end if (strlen($peopleLastName) == 0 )*/


    /*If any validation failed, save all form values in variables
    or these simply fall to the variables made to hold the request values*/
    if($validationFailed) {


    }/*end if validationFailed*/


    /*Validation successful!
    Here we wash all values that come from the form*/

    if (!$validationFailed ) {

        $washPostVar = cleanup_post($peopleFirstName);
        $peopleFirstNameAltered = strip_before_insert($conn, $washPostVar);



        if ($debug) {
            $debug_string = "( 'peopleFirstName =' . '$peopleFirstName' . '<br/>')";
        }/*end debug*/

        $washPostVar = cleanup_post($peopleMiddleName);
        $peopleMiddleNameAltered = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($peopleLastName);
        $peopleLastNameAltered = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($peopleSuffix);
        $peopleSuffixAltered = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($oldPeopleID);
        $oldPeopleIDAltered = strip_before_insert($conn, $washPostVar);


        /*This is the code that will update the people table with the changes we made to the current People information.
    When we click on submit below the form, the user is returned to this same page to validate the edited information and then, if we are editing current people info,  it is here where that new information is updated in the people table. The $submit variable (we are still inside of) tells us this is not our first time through the code.  */

        if ($oldPeopleIDAltered !== '' && $editPeople == 'true' ) {
            $updatePeople =  "UPDATE people AS p  SET ";
            if($peopleFirstName == "") {
                $updatePeople .= "p.firstname = NULL,";
            }else{
                $updatePeople .= "p.firstname = '$peopleFirstName',";
            }

            if($peopleMiddleNameAltered == "") {
                $updatePeople .= "p.middlename = NULL,";
            }else{
                $updatePeople .= "p.middlename = '$peopleMiddleNameAltered',";
            }

            if($peopleLastNameAltered == "") {
                $updatePeople .= "p.lastname = NULL,";
            }else{
                $updatePeople .= "p.lastname = '$peopleLastNameAltered',";
            }

            if($peopleSuffixAltered == "") {
                $updatePeople .= "p.suffix = NULL";
            }else{
                $updatePeople .= "p.suffix = '$peopleSuffixAltered'";
            }


            $updatePeople .= "WHERE p.ID = $oldPeopleIDAltered;";


            $updatePeopleResult = $conn->query($updatePeople);

            if ($debug) {
                $debug_string .= "('\nupdatePeople = ' . $updatePeople . '\n<br/>')";
                if (!$updatePeopleResult) $debug_string .= "\n Error description updatePeople: " . mysqli_error($conn) . "\n<br/>";
            }/*end debug*/


          /* echo $debug_string;
          exit();*/



            if($editComposition == 'true') {
                header('Location: editComposition.php?bookID=' . $bookID . '&oldPeopleID=' . $oldPeopleID . '&compositionID=' . $compositionID);
                exit();
            }elseif($editBook == 'true') {
                header('Location: editBook.php?bookID=' . $bookID . '&oldPeopleID=' . $oldPeopleID);
                exit();
            }/*end header logic*/



            /*We will insert our New people information to the db if
            -we are adding a new person to a current book or composition  and the info is not in the Library or
            -we are adding another editor, composer, arranger or Lyricist to the current book or composition that does not already exist in the db
            -we are replacing existing Editor, composer, arranger or lyricist information for a current book or composition but the New person does not yet exist in the db */

            /*We are still in the submit is true section
            only $addNew because if we are using replace, first we go to peopleOptions.php to search,  if we don't choose an existing person(which sends us directly to addRole.php, we will choose the addNew button and have "$addNew..."  following us to get us into this code*/
        } elseif ($addNewPeople == 'true' || $replacePeople == 'true'){

            $peopleInsertQuery = "INSERT INTO people (firstname, middlename, lastname, suffix) VALUES(";

            if($peopleFirstName == "") {
                $peopleInsertQuery .= "NULL,";
            }else{
                $peopleInsertQuery .= "'$peopleFirstName',";
            }

            if($peopleMiddleNameAltered == "") {
                $peopleInsertQuery .= "NULL,";
            }else{
                $peopleInsertQuery .= "'$peopleMiddleNameAltered',";
            }

            if($peopleLastNameAltered == "") {
                $peopleInsertQuery .= "NULL,";
            }else{
                $peopleInsertQuery .= "'$peopleLastNameAltered',";
            }

            if($peopleSuffixAltered == "") {
                $peopleInsertQuery .= "NULL)";
            }else{
                $peopleInsertQuery .= "'$peopleSuffixAltered')";
            }


            /*Send the query to the database*/
            $peopleInsertQueryResult = $conn->query($peopleInsertQuery);

            if ($debug) {
                echo("\npeopleInsertQuery= " . $peopleInsertQuery . "\n<br/>");
                if (!$peopleInsertQueryResult) echo("\n Error description peopleInsertQuery: " . mysqli_error($conn) . "\n<br/>");
            }/*end debug*/

            /*Getting people ID for the organization just inserted into database*/
            /*This needs to be newPeopleID when a person does not exist and we are adding a new person*/
            $newPeopleID = $conn->insert_id;

            if ($debug) {
                echo("newPeopleID = " . $newPeopleID . "<br/>");
            }/*end debug*/
        } /*end elseif ($addNewPeople == 'true' || $replacePeople == 'true')*/

if($editBook == 'true') {
    header('Location: addRole.php?bookID=' . $bookID . '&newPeopleID=' . $newPeopleID . '&oldPeopleID=' . $oldPeopleID . '&addNewEditor=' . $addNewEditor . '&editBook=true');
    exit();

}elseif($editComposition == 'true') {
    header('Location: addRole.php?bookID=' . $bookID . '&newPeopleID=' . $newPeopleID . '&oldPeopleID=' . $oldPeopleID . '&addNewComposer=' . $addNewComposer . '&addNewArranger=' . $addNewArranger . '&addNewLyricist=' . $addNewLyricist . '&replaceComposer=' . $replaceComposer . '&replaceArranger=' . $replaceArranger . '&replaceLyricist=' . $replaceLyricist . '&compositionID=' . $compositionID . '&editComposition=true');
}
    }/*end if (!$validationFailed)*/
} /*end If($submit == 'true')*/

    /*Here we add some additional variables to change the wording of the form in different situations*/

   if ($addNewPeople == 'true') {
        $instructionalText = "<h2> Please enter New $role Information Below</h2>";

    } elseif ($editPeople == 'true') {
        $instructionalText = "<h2> Please edit the $role Information Below</h2>";
    } elseif ($replacePeople == 'true') {
        $instructionalText = "<h2> Please enter the new replacement information for the $role below</h2>";
    } else {
        $instructionalText = "<h2> Please enter $role Information Below</h2>";
    }/*end if($addNewPeople == 'true')*/







/*Edit existing People info
This searches the db for the current Editor, composer, arranger or lyricist (depending on which one we have chosen)
Pre-populates the form with current Editor, composer, arranger or lyricist info so user can correct spellings or complete incomplete portions.
When submitted, those new values will be validated and the people table will be updated*/
if($submit == "") {
    /*This query works only if the $oldPeopleID reflects the people ID of the Editor, composer, Arranger or Lyricist*/
    if ($editPeople == 'true') {
        $peopleQuery = <<<_END

      SELECT p.firstname, p.middlename, p.lastname, p.suffix
      FROM people AS p
      WHERE p.ID = $oldPeopleIDAltered;

_END;

        $peopleQueryResult = $conn->query($peopleQuery);


        if ($debug) {

            echo 'peopleQuery = ' . $peopleQuery . '<br/><br/>';
            if (!$peopleQueryResult) echo("\n Error description query peopleQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        $numberOfPeopleRows = $peopleQueryResult->num_rows;

        for ($j = 0; $j < $numberOfPeopleRows; ++$j) {
            $row = $peopleQueryResult->fetch_array(MYSQLI_NUM);

            $peopleFirstName = $row[0];
            $peopleMiddleName = $row[1];
            $peopleLastName = $row[2];
            $peopleSuffix = $row[3];


        }    /*forloop ending*/


    } /*end if ($editPeople == 'true')*/

} /*end If($submit == "")*/



echo <<<_END
   
<div class="container-fluid bg-light pt-4 pb-4">
$instructionalText

  <div class="row">
    <div class="col-md-6">
      <form action='addPeople.php' method='post'>
        <div class="form-group pt-4">
   



            First Name: 
            <input class="form-control" type="text" name="peopleFirstName" value = "{$fn_encode($peopleFirstName)}"/><br/>
            Middle Name: <input class="form-control"  type="text" name="peopleMiddleName" value = "{$fn_encode($peopleMiddleName)}"/><br/>
            Last Name: $peopleLastNameErr
            <input class="form-control"  type="text" name="peopleLastName" value = "{$fn_encode($peopleLastName)}"/><br/>
            Suffix: <input class="form-control"  type="text" name="peopleSuffix" value = "{$fn_encode($peopleSuffix)}"/><br/>
            
            <input class="btn btn-secondary mt-4" type='submit' value='Submit & Continue'/><br/>
            <input type='hidden' name="bookID" value="{$bookID}"/>
            <input type='hidden' name="oldPeopleID" value="{$oldPeopleID}"/>
            <input type='hidden' name="compositionID" value="{$compositionID}"/>
            <input type='hidden' name="submit" value='true'/>
            $sendAddNew
            $sendEdit
            $sendEditBook
            $sendReplace
            $sendEditComposition
           
   
        </div> <!-- end form-group -->
      </form> <!-- end form -->
        
      <form action='$formAction' method='post'>
         <div class="form-group pt-4">
            <input class="btn btn-secondary mt-4" type='submit' value='Back to $page '/><br/>
            <input type='hidden' name="bookID" value="{$bookID}"/>
            <input type='hidden' name="compositionID" value="{$compositionID}"/>
                      
         </div> <!-- end form-group -->
</form>
    </div> <!-- end col -->
  </div> <!-- end row -->
</div> <!-- end container -->


_END;




include 'footer.html';
include 'endingBoilerplate.php';

?>

