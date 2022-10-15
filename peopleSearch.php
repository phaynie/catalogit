
<?php

include 'boilerplate.php';

/*We arrive at this page if we are
-Adding a new book or Composition to the library and are adding an Editor, Composer, Arranger, or lyricist to that book.
-Editing a current book or Composition and want to add or replace an Editor, Composer, Arranger, or lyricist.
-adding an additional Editor, Composer, Arranger, or lyricist to an existing book or Composition and want to know if it already exists in the db
-searching for all the pieces and books a person is linked to as a "composer", Lyricist, Arranger, Editor etc.*/


/*Purpose of this page is to:
-provide the user with a form that has a search box and submit button to submit an Editor, Composer, Arranger, or lyricist name (we will search for it in peopleOptions).
-Validate the  name the user submits.
-Once validation is successful, user is sent to peopleOptions.php

*/
$debug_string = "";

if($debug) {
    $debug_string .= "peopleSearch.php<br/>";
}/*end debug*/


include 'beginningNav.php';


/*initializing Variables*/
$searchPeopleLastNameErr = "";
$searchPeopleLastName = "";
$searchPeopleLastName_value = "";
$replaceEditorText = "";
$replaceContinueText = "";
$addNewEditorContinueText = "";
$bookID = "";
$compositionID = "";
$oldPeopleID = "";
$editBook = "";
$editComposition = "";
$replaceEditor = "";
$addNewEditor = "";
$replaceComposer = "";
$addNewComposer = "";
$replaceArranger = "";
$addNewArranger = "";
$replaceLyricist = "";
$addNewLyricist = "";
$addNewPeople = "";
$replacePeople = "";
$findComposer = "";
$findPerson = "";
$submit = "";
$role = "";
$validationFailed = false; /*A single place to track whether any validation has failed.*/


 $replacePeopleContinueText = "";
 $addNewPeopleContinueText = "";
 $findComposerContinueText = "";
 $findPersonContinueText = "";
 
 $sendEditBook = "";
 $sendEditComposition = "";
 $sendAddNew = "";
 $sendFindPerson = "";
 $sendReplace = "";
 $sendFindComposer = "";
 $formAction = "";
 $page = "";
 $informationText = "";

/*we use REQUEST here because then we can find our Key whether it is in the Post array or the Get Array. REQUEST includes both*/

if(isset($_REQUEST['bookID']) && is_numeric($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
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

if(isset($_REQUEST['editComposition'])) {
    $editComposition = $_REQUEST['editComposition'];
}

if(isset($_REQUEST['replaceEditor'])) {
    $replaceEditor = $_REQUEST['replaceEditor'];
}

if(isset($_REQUEST['addNewEditor'])) {
    $addNewEditor = $_REQUEST['addNewEditor'];
}

if(isset($_REQUEST['replaceComposer'])) {
    $replaceComposer = $_REQUEST['replaceComposer'];
}

if(isset($_REQUEST['addNewComposer'])) {
    $addNewComposer = $_REQUEST['addNewComposer'];
}

if(isset($_REQUEST['replaceArranger'])) {
    $replaceArranger = $_REQUEST['replaceArranger'];
}

if(isset($_REQUEST['addNewArranger'])) {
    $addNewArranger = $_REQUEST['addNewArranger'];
}

if(isset($_REQUEST['replaceLyricist'])) {
    $replaceLyricist = $_REQUEST['replaceLyricist'];
}

if(isset($_REQUEST['addNewLyricist'])) {
    $addNewLyricist = $_REQUEST['addNewLyricist'];
}

if(isset($_REQUEST['findComposer'])) {
    $findComposer = $_REQUEST['findComposer'];
}

if(isset($_REQUEST['findPerson'])) {
    $findPerson = $_REQUEST['findPerson'];
}

if(isset($_REQUEST['searchPeopleLastName'])) {
    $searchPeopleLastName = $_REQUEST['searchPeopleLastName'];
}

if(isset($_REQUEST['submit'])) {
    $submit = $_REQUEST['submit'];
}


/*logic for variable values in different situations*/

if($editBook == 'true') {
    $formAction = 'editBook.php';
    $sendEditBook = "<input type='hidden' name='editBook' value= 'true' />";
    $editBookOrComposition = $editBook;
    $informationText = "<h3 class='pb-4'>This book information was updated successfully!</h3>";
    $page = 'Book Editing Options';
}elseif($editComposition == 'true') {
    $formAction = 'editComposition.php';
    $sendEditComposition = "<input type='hidden' name='editComposition' value= 'true' />";
    $informationText = "<h3 class='pb-4'>This composition information was updated successfully!</h3>";
    $page = 'Composition Editing Options';
}

if($addNewEditor=='true') {
    $role = "Editor";
    $addNewPeopleContinueText = "<h3 >Let's see if the new Editor Already Exists</h3>";
    $sendAddNew = "<input type='hidden' name='addNewEditor' value= 'true' />";
    $addNewPeople = $addNewEditor;
}elseif($replaceEditor =='true') {
    $role = "Editor";
    $replacePeopleText = "<h5>Enter LAST NAME of New Editor below</h5>";
    $replacePeopleContinueText = "<h3 '>Let's search for a replacement Editor</h3>";
    $sendReplace = "<input type='hidden' name='replaceEditor' value='true' />";
    $replace = $replaceEditor;
}elseif($addNewComposer =='true') {
    $role = "Composer";
    $addNewPeopleText = "<h5>Enter LAST NAME of New Composer below</h5>";
    $addNewPeopleContinueText = "<h3  >Let's see if the new Composer Already Exists</h3>";
    $sendAddNew = "<input type='hidden' name='addNewComposer' value= 'true' />";
    $addNewPeople = $addNewComposer;
}elseif($replaceComposer =='true') {
    $role = "Composer";
    $replacePeopleContinueText = "<h3>Let's search for a replacement Composer</h3>";
    $sendReplace = "<input type='hidden' name='replaceComposer' value='true' />";
    $replacePeople = $replaceComposer;
}elseif($addNewArranger =='true') {
    $role = "Arranger";
    $addNewPeopleContinueText = "<h3 >Let's see if the new Arranger Already Exists</h3>";
    $sendAddNew = "<input type='hidden' name='addNewArranger' value= 'true' />";
    $addNewPeople = $addNewArranger;
}elseif($replaceArranger =='true') {
    $role = "Arranger";
    $replacePeopleContinueText = "<h3 >Let's search for a replacement Arranger</h3>";
    $sendReplace = "<input type='hidden' name='replaceArranger' value='true' />";
    $replacePeople = $replaceArranger;
}elseif($addNewLyricist =='true') {
    $role = "Lyricist";
    $addNewPeopleContinueText = "<h3 >Let's see if the new Lyricist Already Exists</h3>";
    $sendAddNew = "<input type='hidden' name='addNewLyricist' value= 'true' />";
    $addNewPeople = $addNewLyricist;
}elseif($replaceLyricist =='true') {
    $role = "Lyricist";
    $replacePeopleContinueText = "<h3 >Let's search for a replacement Lyricist</h3>";
    $sendReplace = "<input type='hidden' name='replaceLyricist' value='true' />";
    $replacePeople = $replaceLyricist;
}elseif($findComposer =='true') {
    $role = "Composer";
    $findComposerContinueText = "<h3 >Let's see if our Composer already exists</h3>";
    $page = "Intro Page";
    $formAction = "introPage.php";
    $sendFindComposer = "<input type='hidden' name='findComposer' value='true'/>";
}elseif($findPerson =='true') {
    $role = "Person";
    $findPersonContinueText = "<h3 >Let's see if our Person already exists</h3>";
    $page = "Intro Page";
    $formAction = "introPage.php";
    $sendFindPerson = "<input type='hidden' name='findPerson' value='true'/>";
}


/*here we will wash all variable values that will be used in db Queries on this page*/

$washPostVar = cleanup_post($bookID);
$bookIDAltered = strip_before_insert($conn, $washPostVar);



/*Auto Complete: retrieve people values from db and put into an array*/


$personsArray = "";
$personsArrayQuery = "
                SELECT distinct p.lastname
                FROM people AS p 
               
                ORDER by p.lastname
                  ";

$resultPersonsArrayQuery = $conn->query($personsArrayQuery);
if($debug) {
    $debug_string.="personsArrayQuery = " . $personsArrayQuery . "<br/><br/>";
    if (!$resultPersonsArrayQuery) $debug_string.="('\n Error description personsArrayQuery: ' . mysqli_error($conn) . '\n<br/>')";
}/*end debug*/

failureToExecute ($resultPersonsArrayQuery, 'S587', 'Select ' );


if ($resultPersonsArrayQuery) {

    $personsArrayNumberOfRows = $resultPersonsArrayQuery->num_rows;
    $personsArray = "<script> let persons=[";

    for ($j = 0 ; $j < $personsArrayNumberOfRows ; ++$j)
    {
        $row = $resultPersonsArrayQuery->fetch_array(MYSQLI_NUM);

        /*  var_dump ($row);*/


        $person = htmlspecialchars($row[0], ENT_QUOTES);

        $personsArray .= "'$person'" .", ";







    } /*for loop ending*/

} /*End if ($result$PersonsArrayQuery)*/

$personsArray = rtrim($personsArray,', ');
$personsArray .="]</script>";











/*Validation code section
     if $validationFailed is true, we will show form pre-populated with error messages and user can re-submit values.
     if $validationFailed is false, we will wash data coming from the form.*/

/*boilerplate is over, now validate, if needed*/


if($submit == 'true') {
    if (strlen($searchPeopleLastName) == 0 ) {
        $searchPeopleLastNameErr = "<span class= 'error' >* Last Name of $role is required</span>";
        $validationFailed = true;
    }/*end */

    /*If any validation failed, give values to our initialized variables*/

    if ($validationFailed) {
        $searchPeopleLastName_value = $searchPeopleLastName;
    } /*end if validation failed*/


    /*Validation over*/
    /*washes this user data*/
if (!$validationFailed ) {
     /*Don't need to wash var here. It will not be used until next page*/

/*oldPeopleID needs to be sent when replacing editor*/
        header('Location: peopleOptions.php?bookID=' . $bookID . '&compName=' . $compName . '&compositionID=' . $compositionID . '&oldPeopleID=' . $oldPeopleID . '&editBook=' . $editBook . '&editComposition=' . $editComposition . '&replaceEditor=' . $replaceEditor . '&replaceComposer=' . $replaceComposer . '&replaceArranger=' . $replaceArranger . '&replaceLyricist=' . $replaceLyricist . '&addNewEditor=' . $addNewEditor . '&addNewComposer=' . $addNewComposer . '&addNewArranger=' . $addNewArranger . '&addNewLyricist=' . $addNewLyricist . '&searchPeopleLastName=' . $searchPeopleLastName . '&findComposer=' . $findComposer. '&findPerson=' . $findPerson);
        exit();
    } /* End if (!$validationFailed )*/


}/*End if submit == 'true'*/

if($debug) {
    echo $debug_string;
}
echo $personsArray;








/*  get the book information  by creating a Select statement but only if we are not editing. If we are editing, we don't need to display all the book or composition info. We will be working with editing a specific part of the book or composition and searching for only that item.*/
/*build query*/

/*it is possible we will also need to search for the Composition info. This may be wanted if we are not editing. We have not explored this yet.
or, in this new scenario we wont need this book search at all. Will there ever be a situation where we want the book info displayed on this page?*/
    if($editBook !== "true" && $editComposition !== "true" && $findComposer !== "true" && $findPerson !== "true") {
        $bookQuery  = <<<_END

          SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, b.physBookLoc
          FROM books AS b

          WHERE b.ID = '$bookIDAltered' ;

_END;

        $bookQueryResult = $conn->query($bookQuery);

        if($debug) {
            echo 'bookQuery =' . $bookQuery . '</br>';
        }

        if (!$bookQueryResult) echo ("\n Error description query bookQuery: " . mysqli_error($conn) . "\n<br/>");

        failureToExecute ($bookQueryResult, 'S588', 'Select ' );


        if($bookQueryResult) {
            $numberOfBookRows = $bookQueryResult->num_rows;

            for ($j = 0; $j < $numberOfBookRows; ++$j) {
                $row = $bookQueryResult->fetch_array(MYSQLI_NUM);

                $bookID = $row[0];
                $bookTitle = $row[1];
                $bookTag1 = $row[2];
                $bookTag2 = $row[3];
                $bookVolume = $row[4];
                $bookNumber = $row[5];
                $physBookLocNote = $row[6];

            }    /*forloop ending*/

        } /*end if bookquery result*/




        /*Retrieving all editor info for this book
       I will also be creating a comma separated list to use in the displayed information, except my comma will be a break and Editor Name: */
        $editorPeopleQuery = <<<_END

      SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
      FROM books AS b 
      JOIN b2r2p ON b.ID = b2r2p.book_ID
      JOIN people AS p ON p.ID= b2r2p.people_ID
      WHERE b.ID = '$bookIDAltered';

_END;

        $resultEditorPeopleQuery = $conn->query($editorPeopleQuery);
        if($debug) {
            echo 'editorPeopleQuery = ' . $editorPeopleQuery . '<br/><br/>';

            if (!$resultEditorPeopleQuery) echo ("\n Error description editorPeopleQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        failureToExecute ($resultEditorPeopleQuery, 'S589', 'Select ' );


        if ($resultEditorPeopleQuery) {
            $numEditorPeopleRows = $resultEditorPeopleQuery->num_rows;
            /*Build comma separated list of editorPeople in a string*/
            $editorPeopleString= "";

            for ($j = 0 ; $j < $numEditorPeopleRows ; ++$j) {
                $row = $resultEditorPeopleQuery->fetch_array(MYSQLI_NUM);
                /*var_dump ($row);*/
                $editorPeopleID = $row[0];
                $editorPeopleFirstName = $row[1];
                $editorPeopleMiddleName = $row[2];
                $editorPeopleLastName = $row[3];
                $editorPeopleSuffix = $row[4];
                /*$editorPeopleString = implode(',',$instVal);*/
                $editorPeopleString .= $editorPeopleFirstName .  " " . $editorPeopleMiddleName . " " . $editorPeopleLastName . " " . $editorPeopleSuffix . "</br>Editor Name: ";

            } /*for loop ending*/

        } /*End if $resultEditorPeopleQuery query*/


        $displayEditorPeopleString = substr($editorPeopleString, 0, strrpos($editorPeopleString, "</br>Editor Name: " ));






        /*Retrieving all publisher info for this book
       I will also be creating a comma separated list to use in the displayed information, except my comma will be a break and Publisher Name: */
        $publisherOrgQuery = <<<_END

      SELECT  o.ID, o.org_name, o.location
      FROM books AS b 
      JOIN b2r2o ON b.ID = b2r2o.book_ID
      JOIN organizations AS o ON o.ID= b2r2o.org_ID
      WHERE b.ID = '$bookIDAltered';

_END;

        $resultPublisherOrgQuery = $conn->query($publisherOrgQuery);
        if($debug) {
            echo 'publisherOrgQuery = ' . $publisherOrgQuery . '<br/><br/>';

            if (!$resultPublisherOrgQuery) echo ("\n Error description publisherOrgQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        failureToExecute ($resultPublisherOrgQuery, 'S590', 'Select ' );


        if ($resultPublisherOrgQuery) {
            $numPublisherOrgRows = $resultPublisherOrgQuery->num_rows;
            /*Build comma separated list of publisherOrg in a string*/
            $publisherOrgString= "";

            for ($j = 0 ; $j < $numPublisherOrgRows ; ++$j) {
                $row = $resultPublisherOrgQuery->fetch_array(MYSQLI_NUM);
                /*var_dump ($row);*/
                $publisherOrgID = $row[0];
                $publisherOrgName = $row[1];
                $publisherOrgLocation = $row[2];

                /*$editorPeopleString = implode(',',$instVal);*/
                $publisherOrgString .= $publisherOrgName . "</br> Publisher Location: " . $publisherOrgLocation . "</br></br>Publisher Name: ";

            } /*for loop ending*/

        } /*End if $resultPublisherOrgQuery*/


        $displayPublisherOrgString = substr($publisherOrgString, 0, strrpos($publisherOrgString, "</br>Publisher Name: " ));







        echo <<<_END

    <div class="container-fluid bg-light pt-4 pb-5">
      <h3 class="display-4 pb-3">So Far So Good!</h3>
      $informationText
     
    </div> <!-- end container--> 
    
_END;

    if($bookID) {
        echo <<<_END
      
      <div class="container-fluid bg-light pt-4 pb-5">
      <div class="row">
          <div class="col-md-6 pb-4">
            <div class="card bg-light">
              <div class="card-body">
                <h3> Book Info </h3>
                Book Title: <strong>$bookTitle</strong> <br/>
                Tag 1: $bookTag1 <br/>
                Tag 2: $bookTag2 <br/>
                Book Volume: $bookVolume <br/>
                Book Number: $bookNumber <br/>
                Editor Name: $displayEditorPeopleString<br/>
           <br/>Publisher Name: $displayPublisherOrgString <br/>  
                Book Location: <span style="color:#EB6B42;">  $physBookLocNote</span><br/><br/>   
              </div> <!-- card-body -->
            </div> <!-- card -->
          </div> <!-- end col -->
        </div> <!-- end row -->
      </div> <!-- end container -->

_END;

}/*End if($bookID)*/
} /*end if not editBook && if not edit composition*/











/*Next we will display form with text box for person's last name and button "Search for this Person". We will also pass hidden values needed when we validate.
 */
 

 
    echo <<<_END

    <div class="container-fluid bg-light pt-4 pb-5" >
      <div class="col-md-6">
        <form action="peopleSearch.php" method="post">
          $replacePeopleContinueText
          $addNewPeopleContinueText
          $findComposerContinueText
          $findPersonContinueText
         <p> if your $role last name begins with von or van it has been included as part of the last name. ex. van Beethoven. </p>

  
          $role Last Name: $searchPeopleLastNameErr
          <input class="form-control" autocomplete="off" type="text" name="searchPeopleLastName" id="searchPeopleLastName" autofocus placeholder = "Please enter the last name of the $role "/>
          <ul id="cmpsrsArray"></ul>
          <input class="btn btn-secondary mt-4" type="submit" value="Search for this $role"/>
          <input type="hidden" name="bookID" value="{$bookID}"/>
          <input type="hidden" name="compositionID" value="{$compositionID}"/>
          <input type="hidden" name="oldPeopleID" value="{$oldPeopleID}"/>
          <input type="hidden" name="submit" value="true"/>
          $sendReplace
          $sendEditBook
          $sendEditComposition
          $sendAddNew
          $sendFindComposer
          $sendFindPerson
        </form>   <!-- end form -->
      
        <form action="$formAction" method="post">
          <input class="btn btn-secondary mt-4" type="submit" value="Back to $page "/>
          <input type="hidden" name="bookID" value="$bookID"/>
          <input type="hidden" name="compositionID" value="$compositionID"/>
        </form>  <!-- end form -->
      </div>  <!-- end col -->
    </div> <!-- end container -->

_END;
        



include 'footer.php';
include 'endingBoilerplate.php';

echo <<<_END
<script>
listener('searchPeopleLastName', persons,  'cmpsrsArray');
</script>

_END;


?>



