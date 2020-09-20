<?php
include 'boilerplate.php';

if($debug) {
    echo <<<_END

<p>addOrg.php-10</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';
/* We arrive at this page if
    A. We are adding a new book to the library and have searched for a publisher and found that it is not already existing in the db and would like to add the information to the db.
    B. We are editing a current book and want to add or replace the publisher and the new publisher is not already in the database and we would like to add the new information to the db.
    C. We are editing a book, and choose to edit the publisher information. In this case, our form should be prepopulated with the current publisher information, and allow us to edit the information. This will then, need to be validated and the organizations table updated. */

/*This page
    -provides a form (and button) to submit new organization (publisher) information.
    -validates the submitted form information.
    -inserts validated information into the organization table.
    -sends user by way of header to addRole.php to update(edit/replace) or add(add new) to B2R2O table or delete a dispal(delete) from B2R2O table .
*/

/*Initialize Variables*/

$bookID = "";
$editBook = "";
$editPublisher = "";
$newOrgID = "";
$oldOrgID = "";
$addNewPublisher = "";
$replacePublisher = "";
$pubName = "";
$pubLoc = "";
$pubName_value = "";
$pubLoc_value = "";
$submit = "";
$debug_string = "";
$oldOrgIDAltered = "";

/*bookID will NOT be used in db queries on this page
We still check for numeric value*/
if(isset($_REQUEST['bookID']) && is_numeric($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}
/*making sure the id variables are washed too.
oldOrgID will be used in db queries on this page*/
if(isset($_REQUEST['oldOrgID']) && is_numeric($_REQUEST['oldOrgID'])) {
    $oldOrgID = $_REQUEST['oldOrgID'];
}

if(isset($_REQUEST['editBook'])) {
    $editBook = $_REQUEST['editBook'];
}

if(isset($_REQUEST['editPublisher'])) {
    $editPublisher = $_REQUEST['editPublisher'];
}

/*$newOrgID is not used in any db queries on this page*/
if(isset($_REQUEST['newOrgID']) && is_numeric($_REQUEST['newOrgID'])) {
    $newOrgID = $_REQUEST['newOrgID'];
}

if(isset($_REQUEST['addNewPublisher'])) {
    $addNewPublisher = $_REQUEST['addNewPublisher'];
}

if(isset($_REQUEST['replacePublisher'])) {
    $replacePublisher = $_REQUEST['replacePublisher'];
}

if(isset($_REQUEST['pubName'])) {
    $pubName = $_REQUEST['pubName'];
}

if(isset($_REQUEST['pubLoc'])) {
    $pubLoc = $_REQUEST['pubLoc'];
}

if(isset($_REQUEST['submit'])) {
    $submit = $_REQUEST['submit'];
}

if($replacePublisher == 'true') {
    $sendReplacePublisher = "<input type='hidden' name='replacePublisher' value= 'true' />";
}

if($addNewPublisher == 'true') {
    $sendAddNewPublisher = "<input type='hidden' name='addNewPublisher' value= 'true' />";
}

if($editPublisher == 'true') {
    $sendEditPublisher = "<input type='hidden' name='editPublisher' value ='true' />";
}

if($editBook == 'true') {
    $sendEditBook = "<input type='hidden' name='editBook' value ='true' />";
}


$validationFailed = false;  /*A single place to track whether any validation has failed.*/

/*Validation code section
if $validationFailed is true, we will show form pre-populated with error messages and user can re-submit values.
if $validationFailed is false, we will wash data coming from the form.
If editing an existing book and validation is successful   we will go to addRole.php, update the B2R2O table and send the user by way of header to editBook.php
If adding a new book to the library and validation is successful  we will insert this new publisher info into the organizations table, go to addRole.php and add a new row to the B2R2O table connecting this organization information to the book as a publisher. */


/*These values will be used in the form below to show us what we submitted and to make corrections*/

if (strlen($pubName) == 0 && $submit=='true') {
    /* Perform all validations needed for all fields*/
        $pubNameErr = " * Publisher Name is required";
        $validationFailed = true;
} /*end if (strlen($pubName) == 0 && $submit=='true')*/


    /*If any validation failed, save all form values in variables*/
if ($validationFailed) {
        $pubName_value = $pubName;
        $pubLoc_value = $pubLoc;
        $pubNameErr_value = "<span class=\"error\"> {$pubNameErr} </span>";
}/*end if validationFailed*/



/*Validation successful!
Here we wash all values that come from the form*/


if (!$validationFailed) {

    $washPostVar = cleanup_post($oldOrgID);
    $oldOrgIDAltered = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($pubName);
    $pubNameAltered = strip_before_insert($conn, $washPostVar);

    if ($debug) {
        $debug_string = 'pubName =' . $pubNameAltered . '<br/>';
    }/*end debug*/

    $washPostVar = cleanup_post($pubLoc);
    $pubLocAltered = strip_before_insert($conn, $washPostVar);
}

if (!$validationFailed && $submit=='true') {
/*This is the code that will update the organization table with the changes we made to the current Publisher information.
When we click on submit below the form, the user is returned to this same page to validate the edited information and then, if we are editing current publisher info,  it is here where that new information is updated in the organizations table. The $submit variable tells us this is not our first time through the code.  */

    if ($oldOrgIDAltered !== '' && $editPublisher == 'true' && $submit = 'true') {

        $updateOrganizations = "UPDATE organizations AS o SET ";
        if($pubNameAltered =="") {
            $updateOrganizations .= " o.org_name = NULL,";
        }else{
            $updateOrganizations .= " o.org_name = '$pubNameAltered',";
        }
        if($pubLocAltered =="") {
            $updateOrganizations .= " o.location = NULL";
        }else{
            $updateOrganizations .= " o.location = '$pubLocAltered'";
        }
        $updateOrganizations .= "WHERE o.ID = '$oldOrgIDAltered' ;";


        $updateOrganizationsResult = $conn->query($updateOrganizations);

             if ($debug) {
            $debug_string .="\nupdateOrganizations= " . $updateOrganizations . "\n<br/>";
                if (!$updateOrganizationsResult) $debug_string .="\n Error description updateOrganizations: " . mysqli_error($conn) . "\n<br/>";
            }/*end debug*/

        if (!$updateOrganizationsResult) {
            echo "<p class='error'> Database did not update . Contact administrator </p> . '\n<br/>'";
            exit();
        }


       /* echo $debug_string;
          exit();*/

        header('Location: editBook.php?bookID=' . $bookID . '&oldOrgID=' . $oldOrgID);
        exit();



/*We will insert our New Publisher information to the db if
-we are adding a new Publisher to a current book where there is no Publisher info or
-we are adding another Publisher to the current book that does not already exist in the db
-we are replacing existing Publisher information for a current book but the New Publisher does not yet exist in the db and we have added the info to the form*/

    }/*if(isset($orgID)*/ elseif($addNewPublisher == 'true' || $replacePublisher == 'true') {
        $organizationsInsertQuery =  "INSERT INTO organizations (org_name, location) VALUES(";
        if($pubNameAltered == "") {
            $organizationsInsertQuery .=  "NULL,";
        }else{
            $organizationsInsertQuery .=  "'$pubNameAltered',";
        }

        if($pubLocAltered == "") {
            $organizationsInsertQuery .=  "NULL)";
        }else{
            $organizationsInsertQuery .=  "'$pubLocAltered')";
        }


        /*Send the query to the database*/
        $organizationsInsertQueryResult = $conn->query($organizationsInsertQuery);

        if ($debug) {
            echo("\norganizationsInsertQuery= " . $organizationsInsertQuery . "\n<br/>");
            if (!$organizationsInsertQueryResult) echo("\n Error description organizationsInsertQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        /*Getting org ID for the organization just inserted into database*/
        /*This needs to be newOrgID when an Organization does not exist and we are adding a new organization*/
        $newOrgID = $conn->insert_id;

        if ($debug) {
            echo("newOrgID = " . $newOrgID . "<br/>");
        }/*end debug*/
    } /*end else*/


    header('Location: addRole.php?bookID=' . $bookID . '&newOrgID=' . $newOrgID . '&oldOrgID=' . $oldOrgID . '&addNewPublisher=' . $addNewPublisher . '&replacePublisher=' . $replacePublisher .  '&editBook=true');
    exit();


}/*end if(isset($_POST['pubName']) && !$validationFailed)*/



if($replacePublisher == 'true') {
    $instructionalText = "<h2> Please enter New Publisher Information Below</h2>";

}elseif($addNewPublisher=='true'){
    $instructionalText = "<h2> Please enter New Publisher Information Below</h2>";

}elseif($editPublisher=='true'){
    $instructionalText = "<h2> Please edit the Publisher Information Below</h2><br/><h6 class='burnt'>If you edit the information below it will be changed everywhere in the library. </h6><h6 class='burnt'>If you want to replace the publisher with a different publisher choose the \"Back to Edit Book\" Button and choose the Replace option.</h6>";
}else{
    $instructionalText = "<h2> Please enter Publisher Information Below</h2>";
}/*end if isset replace publisher*/



/*Edit existing Publisher info
This searches the db for the current publisher
Pre-populates the form with current Publisher info so user can correct spellings or complete incomplete portions.
When submitted, those new values will be validated and the organizations table will be updated*/
if($editPublisher=='true') {


    $organizationsPublisherQuery  = <<<_END

      SELECT o.org_name, o.location
      FROM organizations AS o
      WHERE o.ID = '$oldOrgIDAltered';

_END;

    $organizationsPublisherQueryResult = $conn->query($organizationsPublisherQuery);


    if($debug) {

        echo 'organizationsPublisherQuery = ' . $organizationsPublisherQuery . '<br/><br/>';
        if (!$organizationsPublisherQueryResult) echo("\n Error description query organizationsPublisherQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    $numberOfRows = $organizationsPublisherQueryResult->num_rows;

    for ($j = 0 ; $j < $numberOfRows ; ++$j)
    {
        $row = $organizationsPublisherQueryResult->fetch_array(MYSQLI_NUM);

        $orgPubName = $row[0];
        $orgPubLoc = $row[1];


    }    /*forloop ending*/


    $pubName_value = $orgPubName;
    $pubLoc_value = $orgPubLoc;


} /*end if isset edit publisher*/




echo <<<_END

<div class="container bt-light pt-4 pb-4">
  $instructionalText
  <div class="row">
    <div class="col-md-6">  
      <form action='addOrg.php' method='post'>
        <div class="form-group pt-4">


           

                Publisher Name: $pubNameErr_value
                <input class="form-control" type="text" name="pubName" value="{$fn_encode($pubName_value)}"/><br/>
                Publisher Location: <input class="form-control" type="text" name="pubLoc" value= "{$fn_encode($pubLoc_value)}"/><br/>
                <input class="btn btn-secondary mt-4" type='submit' value='Submit and Continue'/>
                <input type='hidden' name="bookID" value='{$bookID}'/>
                <input type='hidden' name="oldOrgID" value='{$oldOrgID}'/>
                <input type='hidden' name="submit" value='true'/>
                $sendReplacePublisher
                $sendAddNewPublisher
                $sendEditPublisher
                $onSuccess
                $sendEditBook
                


        </div><!-- end form-group -->
      </form> <!-- end form --> 
      <form action='editBook.php' method='post'>
        <div class="form-group pt-4">

                <input class="btn btn-secondary mt-4" type='submit' value='Back to Edit Book Options'/>
                <input type='hidden' name="bookID" value='{$bookID}'/>
                $sendEditBook
        </div><!-- end form-group -->
      </form> <!-- end form --> 
    </div><!-- end col -->
  </div><!-- end row -->
</div>  <!-- end container -->

_END;



include 'footer.php';
include 'endingBoilerplate.php';

?>



