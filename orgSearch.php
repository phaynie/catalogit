<?php
include 'boilerplate.php';

/*We arrive at this page if we are
-Adding a new book to the library and are adding a publisher to that book.
-Editing a current book and want to add or replace a publisher.
-adding an additional Publisher to an existing book and want to know if it already exists in the db*/

/*Purpose of this page is to:
-provide the user with a form that has a search box and submit button to submit a publisher name (we will search for it in orgOptions).
-Validate the publisher name the user submits.
-Once validation is successful, user is sent to orgOptions.php

*/


if($debug) {
    echo <<<_END

  <p>orgSearch-8</p>
 

_END;

}/*end debug*/


include 'beginningNav.php';

/*initializing Variables*/
$searchPubNameErr = "";
$searchPubName = "";
$searchPubName_value = "";
$replacePublisherText = "";
$replaceContinueText = "";
$addNewPublisherContinueText = "";
$bookID = "";
$editBook = "";
$replacePublisher = "";
$oldOrgID = "";
$addNewPublisher = "";
$submit = "";

$validationFailed = false; /*A single place to track whether any validation has failed.*/

/*we use REQUEST here because then we can find our Key whether it is in the Post array or the Get Array. REQUEST includes both*/
if(isset($_REQUEST['bookID']) && is_numeric($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if(isset($_REQUEST['editBook'])) {
    $editBook = $_REQUEST['editBook'];
}

if(isset($_REQUEST['replacePublisher'])) {
    $replacePublisher = $_REQUEST['replacePublisher'];
}

if(isset($_REQUEST['oldOrgID']) && is_numeric($_REQUEST['oldOrgID'])) {
    $oldOrgID = $_REQUEST['oldOrgID'];
}

if(isset($_REQUEST['addNewPublisher'])) {
    $addNewPublisher = $_REQUEST['addNewPublisher'];
}

if(isset($_REQUEST['searchPubName'])) {
    $searchPubName = $_REQUEST['searchPubName'];
}

if(isset($_REQUEST['submit'])) {
    $submit = $_REQUEST['submit'];
}



if($editBook == 'true') {
    $formAction = 'editBook.php';
    $sendEditBook = "<input type='hidden' name='editBook' value= 'true' />";
}else{
    $formAction = 'displayBook.php';
}


if($addNewPublisher == 'true') {
    $addNewPublisherText = '<h5>Enter FULL NAME of New Publisher below</h5>';
    $addNewPublisherContinueText = '<h3 >Let\'s see if the new Publisher Already Exists</h3>';
    $sendAddNewPublisher = "<input type='hidden' name='addNewPublisher' value= 'true' />";
}


if($replacePublisher == 'true') {
    $replacePublisherText = '<h5>Enter NAME of New Publisher below</h5>';
    $replaceContinueText = '<h3 class="display-4">Let\'s search for a replacement Publisher</h3>';
    $sendReplacePublisher = "<input type='hidden' name='replacePublisher' value='true' />";
}

/*here we wash any variables that will be used in db queries below*/
$washPostVar = cleanup_post($bookID);
$bookIDAltered = strip_before_insert($conn, $washPostVar);






$orgNamesArray = "";
$orgNamesArrayQuery = "
                SELECT distinct o.org_name
                FROM organizations AS o 
               
               WHERE o.ID != 1 AND o.ID != 2
                ORDER by o.org_name
                  ";

$resultOrgNamesArrayQuery = $conn->query($orgNamesArrayQuery);
if($debug) {
    $debug_string.=" 'orgNamesArrayQuery = ' . $orgNamesArrayQuery . '<br/><br/>'";
    if (!$resultOrgNamesArrayQuery) $debug_string.="('\n Error description orgNamesArrayQuery: ' . mysqli_error($conn) . '\n<br/>')";
}/*end debug*/

if ($resultOrgNamesArrayQuery) {

    $orgNamesArrayNumberOfRows = $resultOrgNamesArrayQuery->num_rows;
    $orgNamesArray = "<script> let orgNames=[";

    for ($j = 0 ; $j < $orgNamesArrayNumberOfRows ; ++$j)
    {
        $row = $resultOrgNamesArrayQuery->fetch_array(MYSQLI_NUM);

        /*  var_dump ($row);*/


        $orgName = htmlspecialchars($row[0], ENT_QUOTES);

        $orgNamesArray .= "'$orgName'" .", ";





    } /*for loop ending*/

} /*End if ($resultBookTitleArrayQuery)*/

$orgNamesArray = rtrim($orgNamesArray,', ');
$orgNamesArray .="]</script>";






/*Validation code section
 if $validationFailed is true, we will show form pre-populated with error messages and user can re-submit values.
 if $validationFailed is false, we will wash data coming from the form.*/


    /*boilerplate is over, now validate, if needed*/

    if (strlen($searchPubName) == 0 && $submit=='true') {
        $searchPubNameErr = "<span class= \"error\" >* Publisher Name is required</span>";
        $validationFailed = true;
    }/*end */

    /*If any validation failed, give values to our initialized variables*/

    if ($validationFailed) {
        $searchPubName_value = $searchPubName;
    } /*end if validation failed*/


    /*Validation over*/
    /*washes this user data*/
    if (!$validationFailed && $submit=='true') {

/*don't need to wash here*/

        /*oldOrgID needs to be sent when replacing publisher*/
        header('Location: orgOptions.php?bookID=' . $bookID . '&oldOrgID=' . $oldOrgID . '&editBook=true&replacePublisher=' . $replacePublisher . '&searchPubName=' . $searchPubName . '&addNewPublisher=' . $addNewPublisher);
        exit();
    }/* End if (!$validationFailed && $submit=='true')*/


if($debug) {
    echo $debug_string;
}
echo $orgNamesArray;







/*  get the book information  by creating a Select statement but only if we are not editing a book*/
/*build query*/
if(!$editBook) {
$bookQuery = <<<_END

          SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, o.org_name, o.location, p.firstname, p.middlename, p.lastname, p.suffix, p.id, o.id
          FROM books AS b
          LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
          LEFT JOIN roles AS r_p ON r_p.ID = B2R2P.role_ID AND r_p.role_name = 'Editor'
          LEFT JOIN people AS p ON p.ID = B2R2P.people_ID
          LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
          LEFT JOIN roles AS r_o ON r_o.ID = B2R2O.role_ID AND r_o.role_name = 'Publisher'
          LEFT JOIN organizations AS o ON o.ID = B2R2O.org_ID

          WHERE b.ID = '$bookIDAltered' ;

_END;

$bookQueryResult = $conn->query($bookQuery);

if ($debug) {
    echo 'bookQuery =' . $bookQuery . '</br>';
}

if (!$bookQueryResult) echo("\n Error description query bookQuery: " . mysqli_error($conn) . "\n<br/>");

$numberOfRows = $bookQueryResult->num_rows;

for ($j = 0; $j < $numberOfRows; ++$j) {
    $row = $bookQueryResult->fetch_array(MYSQLI_NUM);

    $bookID = $row[0];
    $bookTitle = $row[1];
    $bookTag1 = $row[2];
    $bookTag2 = $row[3];
    $bookVolume = $row[4];
    $bookNumber = $row[5];
    $publisherName = $row[6];
    $publisherLocation = $row[7];
    $editorFirstName = $row[8];
    $editorMiddleName = $row[9];
    $editorLastName = $row[10];
    $editorSuffix = $row[11];
    $peopleID = $row[12];
    $orgID = $row[13];
}/*forloop ending*/
/*This will loop for each result row*/








    echo <<<_END

  <div class="container-fluid bg-light pt-4 pb-5">
    <h3 class="display-4 pb-3">So Far So Good!</h3>
    <h3 class="pb-4">This Book information was updated successfully!</h3>
  </div><!-- end container -->



    <div class="container-fluid bg-light pt-4 pb-5">
      <h3 class="display-4 pb-3">So Far So Good!</h3>
      <h3 class="pb-4">This book information was added or updated successfully!</h3>
    </div> <!-- end container-->
      
      <div class="container-fluid bg-light pt-4 pb-5">
      <div class="row">
          <div class="col-md-6 pb-4">
            <div class="card bg-light">
              <div class="card-body">
                <h3> Book Info </h3>
                Book Title: $bookTitle <br/>
                Tag 1: $bookTag1 <br/>
                Tag 2: $bookTag2 <br/>
                Book Volume: $bookVolume <br/>
                Book Number: $bookNumber <br/>
                Editor Name: $editorFirstName $editorMiddleName $editorLastName $editorSuffix<br/>
                Publisher Name: $publisherName <br/>
                Publisher Location: $publisherLocation <br/>     
              </div> <!-- card-body -->
            </div> <!-- card -->
          </div> <!-- end col -->
        </div> <!-- end row -->
      </div> <!-- end container -->

_END;

} /*end if not editBook*/
/*Next we will display form with text box for Publisher's name and button "Search for this Publisher". We will also pass hidden values needed in the next page.
 */

      echo <<<_END
      
  <div class="container-fluid bg-light pt-4 pb-5"> 
    <div class="col-md-6">
      <form action='orgSearch.php' method='post'>
          $replaceContinueText
          $addNewPublisherContinueText
          $addNewPublisherText
          $replacePublisherText


        Publisher Name: $searchPubNameErr
        <input class="form-control" autocomplete="off" type="text" id="searchPubName" name="searchPubName" placeholder = "Please enter a Publisher Name" /><br/>
        <ul id="pbNmsArray"></ul>
        <input class="btn btn-secondary mt-4" type='submit' value='Search for this Publisher'/>
        <input type='hidden' name="bookID" value="{$bookID}"/>
        <input type='hidden' name="oldOrgID" value="{$oldOrgID}"/>
        <input type='hidden' name="submit" value='true'/>
        $sendReplacePublisher
        $sendEditBook
        $sendAddNewPublisher
   
      </form> <!-- end form -->
          
      <form action='editBook.php' method='post'>
        <input class="btn btn-secondary mt-4" type='submit' value='Back to Book Editing Options'/>
        <input type='hidden' name="bookID" value='$bookID'/>
      </form> <!-- end form -->
    </div> <!-- col -->
  </div> <!-- container -->
          
_END;

       
   
    
    include 'footer.html';
    
    include 'endingBoilerplate.php';

echo <<<_END
<script>
listener('searchPubName', orgNames,  'pbNmsArray');
</script>

_END;



?>






