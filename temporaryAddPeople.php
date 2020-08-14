<?php
include 'boilerplate.php';
if($debug) {
    echo <<<_END

    <p>addPeople.php  58</p>
 
_END;

}/*end debug*/


include 'beginningNav.php';
/* We arrive at this page if
    -we are adding a new book to the library and have searched for an Editor and found that the Editor is not already existing in the db and would like to add the information to the db.
    -we are editing a current book and want to add or replace the editor and the new editor is not already in the database and we would like to add the new information to the db.*/

/*This page
    -provides a form (and button) to submit new people (editor) information.
    -validates the submitted form information.
    -inserts validated information into the people table.
    -sends user by way of header to addRole.php to update(edit/replace) or add(add new) to B2R2P table or delete a row(delete) from B2R2P table .
*/

/*Initialize Variables*/

$bookID = "";
$compositionID = "";
$editBook = "";
$editComposer = "";
$editArranger = "";
$editLyricist = "";
$editComposition = "";
$editEditor = "";
$newPeopleID = "";
$oldPeopleID = "";
$addNewEditor = "";
$replaceEditor = "";
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

if(isset($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if(isset($_REQUEST['compositionID'])) {
    $compositionID = $_REQUEST['compositionID'];
}

if(isset($_REQUEST['oldPeopleID'])) {
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

if(isset($_REQUEST['newPeopleID'])) {
    $newOrgID = $_REQUEST['newPeopleID'];
}

if(isset($_REQUEST['addNewEditor'])) {
    $addNewEditor = $_REQUEST['addNewEditor'];
}

if(isset($_REQUEST['replaceEditor'])) {
    $replaceEditor = $_REQUEST['replaceEditor'];
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



if($replaceEditor == 'true') {
    $sendReplaceEditor = "<input type='hidden' name='replaceEditor' value= 'true' />";
}

if($addNewEditor == 'true') {
    $sendAddNewEditor = "<input type='hidden' name='addNewEditor' value= 'true' />";
}

if($editEditor == 'true') {
    $sendEditEditor = "<input type='hidden' name='editEditor' value ='true' />";
}

if($editComposer == 'true') {
    $sendEditComposer = "<input type='hidden' name='editComposer' value ='true' />";
}

if($editArranger == 'true') {
    $sendEditArranger = "<input type='hidden' name='editArranger' value ='true' />";
}

if($editLyricist == 'true') {
    $sendEditLyricist = "<input type='hidden' name='editLyricist' value ='true' />";
}

if($editBook == 'true') {
    $sendEditBook = "<input type='hidden' name='editBook' value ='true' />";
}

if($editComposition == 'true') {
    $sendEditComposition = "<input type='hidden' name='editComposition' value ='true' />";
}


$validationFailed = false;  /*A single place to track whether any validation has failed.*/

/*Validation code section
if $validationFailed is true, we will show form pre-populated with error messages and user can re-submit values.
if $validationFailed is false, we will wash data coming from the form.
If editing an existing book and validation is successful   we will go to addRole.php, update the B2R2P table and send the user by way of header to editBook.php
If adding a new book to the library and validation is successful  we will insert this new editor info into the people table, go to addRole.php and add a new row to the B2R2P table connecting this person information to the book as an editor. */


/*These values will be used in the form below to show us what we submitted and to make corrections*/

if (strlen($peopleLastName) == 0 && $submit=='true') {
    /* Perform all validations needed for all fields*/
    $peopleLastNameErr = " * Last Name of Editor is required";
    $validationFailed = true;
} /*end if (strlen($peopleLastName) == 0 && $submit=='true')*/


/*If any validation failed, save all form values in variables
or these simply fall to the variables made to hold the request values*/
if ($validationFailed) {

    $peopleFirstName_value = $peopleFirstName;
    $peopleMiddleName_value = $peopleMiddleName;
    $peopleLastName_value = $peopleLastName;
    $peopleSuffix_value = $peopleSuffix;
    $peopleLastNameErr_value = "<span class=\"error\"> {$peopleLastNameErr} </span>";
}/*end if validationFailed*/





/*Validation successful!
Here we wash all values that come from the form*/

if (!$validationFailed && $submit=='true') {

    $washPostVar = cleanup_post($_POST['peopleFirstName']);
    $peopleFirstName = strip_before_insert($conn, $washPostVar);

    if($debug) {
        echo 'peopleFirstName =' . "$peopleFirstName" . '<br/>';
    }/*end debug*/

    $washPostVar = cleanup_post($_POST['peopleMiddleName']);
    $peopleMiddleName = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['peopleLastName']);
    $peopleLastName = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['peopleSuffix']);
    $peopleSuffix = strip_before_insert($conn, $washPostVar);


    /*This is the code that will update the people table with the changes we made to the current Editor information.
When we click on submit below the form, the user is returned to this same page to validate the edited information and then, if we are editing current editor info,  it is here where that new information is updated in the people table. The $submit variable tells us this is not our first time through the code.  */

    if ($oldPeopleID !== '' && $editEditor == 'true' && $submit = 'true') {
        $updatePeople = <<<_END
                UPDATE people AS p
                SET  	p.firstname = '$peopleFirstName',
                p.middlename = '$peopleMiddleName',
                p.lastname = '$peopleLastName',
                p.suffix = '$peopleSuffix'                             
                WHERE p.ID = $oldPeopleID;
                
_END;


        $updatePeopleResult = $conn->query($updatePeople);

        if ($debug) {
            echo("\nupdatePeople = " . $updatePeople . "\n<br/>");
            if (!$updatePeopleResult) echo("\n Error description updatePeople: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/


        header('Location: editBook.php?bookID=' . $bookID . '&oldPeopleID=' . $oldPeopleID);
        exit();


        /*We will insert our New Editor information to the db if
        -we are adding a new Editor to a current book where there is no Editor info or
        -we are adding another Editor to the current book that does not already exist in the db
        -we are replacing existing Editor information for a current book but the New Editor does not yet exist in the db and we have added the info to the form*/

        /*And submit is true
        only add New because if we replace, first we search if we don't choose existing we will add new and have "addNew..." to get into this code*/
    } elseif($addNewEditor == 'true' || $replaceEditor == 'true') {

        $peopleInsertQuery = <<<_END
                INSERT INTO people (firstname, middlename, lastname, suffix)
                VALUES('$peopleFirstName', '$peopleMiddleName', '$peopleLastName', '$peopleSuffix');
        
_END;

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
    } /*end elseif($addNewEditor == 'true' || $replaceEditor == 'true')*/


    header('Location: addRole.php?bookID=' . $bookID . '&newPeopleID=' . $newPeopleID . '&oldPeopleID=' . $oldPeopleID . '&addNewEditor=' . $addNewEditor . '&replaceEditor=' . $replaceEditor .  '&editBook=true');
    exit();


}/*end if (!$validationFailed && $submit=='true')*/


/*Here we add some additional variables to change the wording in different situations*/

if($replaceEditor == 'true') {
    $instructionalText = "<h2> Please enter New Editor Information Below</h2>";

}elseif($addNewEditor=='true'){
    $instructionalText = "<h2> Please enter New Editor Information Below</h2>";

}elseif($editEditor=='true'){
    $instructionalText = "<h2> Please edit the Editor Information Below</h2>";
}else{
    $instructionalText = "<h2> Please enter Editor Information Below</h2>";
}/*end if isset replace editor*/



/*Edit existing Editor info
This searches the db for the current Editor
Pre-populates the form with current Editor info so user can correct spellings or complete incomplete portions.
When submitted, those new values will be validated and the people table will be updated*/

if($editEditor=='true') {
    $peopleEditorQuery  = <<<_END

      SELECT p.firstname, p.middlename, p.lastname, p.suffix
      FROM people AS p
      WHERE p.ID = $oldPeopleID;

_END;

    $peopleEditorQueryResult = $conn->query($peopleEditorQuery);


    if($debug) {

        echo 'peopleEditorQuery = ' . $peopleEditorQuery . '<br/><br/>';
        if (!$peopleEditorQueryResult) echo("\n Error description query peopleEditorQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    $numberOfPeopleEditorRows = $peopleEditorQueryResult->num_rows;

    for ($j = 0 ; $j < $numberOfPeopleEditorRows ; ++$j)
    {
        $row = $peopleEditorQueryResult->fetch_array(MYSQLI_NUM);

        $peopleEditorFirstName = htmlspecialchars($row[0]);
        $peopleEditorMiddleName = htmlspecialchars($row[1]);
        $peopleEditorLastName = htmlspecialchars($row[2]);
        $peopleEditorSuffix = htmlspecialchars($row[3]);


    }    /*forloop ending*/

    $peopleEditorFirstName_value = $peopleEditorFirstName;
    $peopleEditorMiddleName_value = $peopleEditorMiddleName;
    $peopleEditorLastName_value = $peopleEditorLastName;
    $peopleEditorSuffix_value = $peopleEditorSuffix;



} /*end if isset edit editor*/





echo <<<_END
   
<div class="container-fluid bg-light pt-4 pb-4">
$instructionalText

  <div class="row">
    <div class="col-md-6">
      <form action='addPeople.php' method='post'>
        <div class="form-group pt-4">
   



            First Name: $peopleLastNameErr_value
            <input class="form-control" type="text" name="peopleFirstName" value = "{$peopleEditorFirstName_value}"/><br/>
            Middle Name: <input class="form-control"  type="text" name="peopleMiddleName" value = "{$peopleEditorMiddleName_value}"/><br/>
            Last Name: $peopleLastNameErr
            <input class="form-control"  type="text" name="peopleLastName" value = "{$peopleEditorLastName_value}"/><br/>
            Suffix: <input class="form-control"  type="text" name="peopleSuffix" value = "{$peopleEditorSuffix_value}"/><br/>
            
            <input class="btn btn-secondary mt-4" type='submit' value='Submit and Continue'/><br/>
            <input type='hidden' name="bookID" value="{$bookID}"/>
            <input type='hidden' name="oldPeopleID" value="{$oldPeopleID}"/>
            <input type='hidden' name="submit" value='true'/>
            $sendReplaceEditor
            $sendAddNewEditor
            $sendEditEditor
            $onSuccess
            $sendEditBook
   
        </div> <!-- end form-group -->
      </form> <!-- end form -->
    </div> <!-- end col -->
  </div> <!-- end row -->
</div> <!-- end container -->


_END;




include 'footer.html';
include 'endingBoilerplate.php';

?>
