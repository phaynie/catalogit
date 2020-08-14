<?php

/*This page provides a form with which to add or update book info.
When we are editing a book we see the form pre-populated with current book info we will validate, wash and update. goes to edit book again and again until user is finished updating and chooses "Done".
When we are adding new book info, we will validate, wash and insert new info. we are sent to peopleSearch to continue adding information to the book.
*/
include 'boilerplate.php';
/*Not current. See addBook.php*/
if($debug) {
    echo <<<_END

    <p>addBookInfo-32</p>

_END;

}/*end debug*/


/*include 'beginningNav.html';*/
include 'beginningNav.php';

if($debug) {
    echo "Am I getting any session info? " . $_SESSION['bookTitleErr'] . "</br>";
}/*end debug*/


$bookID = $_POST['bookID']; /*this is needed for when we come from editBook.php .*/
$editBook = $_POST['editBook'];/*this is needed for when we come from editBook.php .*/
$onSuccess = $_POST['onSuccess'];



/* big space because i don't care about all the stuff above - and i don't want to think about it.
 *
 * general idea is to:
 * FIRST - initialize all the prepop variables that will hold any existing values to be pre-populated in form and also error messages
 * do that here*/

$bookTitleErr = "";
$bookTitleValue = "";
$tag1Value = "";
$tag2Value = "";
$bookVolValue = "";
$bookNumErr = "";
$bookNumValue = "";
$placeHolderValue = "";
$editBookPassThrough = "";



/*Validation Code Section
if $validationFailed is true, we will show form prepopulated with error messages and user can re-submit values.
if $validationFailed is false, we will wash data coming from the form. 
If editing the book we will update the form and send the user to editBook
If adding new book info we will insert, claim a book  Id and continue to search publisher.*/

$validationFailed = false;  /*A single place to track whether any validation has failed.*/

if(isset($_POST['bookTitle'])) { /*bookTitle can be set and have an empty value. submit sets booktitle even if it is empty*/
    if($debug) {
        echo "inside isset booktitle" . "<br/>";
    }/*end debug*/

    /* Perform all validations needed for all fields*/
    if(empty($_POST['bookTitle'])){

        $bookTitleErr = " * Book Title is required";
        $validationFailed = true;
    } /*end ifemptybookTitle*/


    if (!empty($_POST['bookNum']) && (!is_numeric($_POST['bookNum'])))  {
        $bookNumErr = " * Book Number must be a number";
        $validationFailed = true;
    } /*end if*/



    /*If any validation failed, save all form values in variables*/
    if($validationFailed) {

        $bookTitleErr = "<span class=\"error\"> Book Title is required </span>";
        $bookTitleValue = $_POST['bookTitle'];
        $tag1Value = $_POST['tag1'];
        $tag2Value = $_POST['tag2'];
        $bookVolValue = $_POST['bookVol'];
        $bookNumErr = "<span class=\"error\"> Book Number must be a number </span>";
        $bookNumValue = $_POST['bookNum'];

    } /*end if validationFailed*/
    
} /*end if isset bookTitle*/


/*Validation successful!
Here we wash all values that come from the form*/

if(isset($_POST['bookTitle']) && !$validationFailed) {
    
    $washPostVar = cleanup_post($_POST['bookTitle']);
    $bookTitle = strip_before_insert($conn, $washPostVar);

    if($debug) {
        echo 'bookTitle =' . "$bookTitle" . '<br/>';
    }/*end debug*/

    $washPostVar = cleanup_post($_POST['tag1']);
    $tag1 = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['tag2']);
    $tag2 = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['bookVol']);
    $bookVol = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['bookNum']);
    $bookNum = strip_before_insert($conn, $washPostVar);

    if(!empty($onSuccess)) { //we came from editBook.php and passed this clue through
        /*all the update code here*/
       $updateBooks = <<<_END
        UPDATE books AS b
        SET  	title = '$bookTitle',
	    tag1 = '$tag1',
	    tag2 = '$tag2',
	    book_vol = '$bookVol',
	    book_num = $bookNum
        WHERE b.ID = $bookID;
_END;

        $updateBooksResult   = $conn->query($updateBooks);

        if($debug) {
            echo("\nupdateBooks= " . $updateBooks . "\n<br/>");
            if (!$updateBooksResult) echo("\n Error description updateBooks: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        header('Location: editBook.php?bookID='.$bookID.'&editBook=true');
        exit();
        
        
    }else{
        
        /*Build the insert query string*/
        $bookInsertQuery="INSERT INTO books (title, tag1, tag2, book_vol, book_num)
        VALUES('$bookTitle', '$tag1', '$tag2', '$bookVol', $bookNum)";

    
        /*Send the query to the database*/
        $bookInsertQueryResult   = $conn->query($bookInsertQuery);
        if($debug) {
            echo("\nbookInsertQuery= " . $bookInsertQuery . "\n<br/>");
            if (!$bookInsertQueryResult) echo("\n Error description bookInsertQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/
    
        /*Getting book ID for the book just inserted into database*/
        $bookID = $conn->insert_id;
    
        if($debug) {
                echo("bookID = " . $bookID . "<br/>");
        }/*end debug*/
    
    
        if($debug) {
            echo('we made it to hereA' . "\n<br/>");
        }/*end debug*/
    
    
            header('Location: peopleSearch.php?bookID='.$bookID);
        }
        exit();
    
    
    }/*end if!$validationFailed*/









 /* SECOND - IF we are here because validation failed, update those (prepop) variables from the session variables and also error messages
 * do that here*/
if(!empty($onSuccess) || isset($editBook)) {
    $onSuccess = "<input type='hidden' name='onSuccess' value= 'editBook' />";
}




 /* * THIRD - IF NOT adding new OR fixing failed validation - update those (prepop) variables from the database
 * * do that here*/
if(isset($editBook)) {
    /*Book query to get book info from the database*/

     $bookQuery  =  <<<_END
    
      SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, o.org_name, o.location, p.firstname, p.middlename, p.lastname, p.suffix
        FROM books AS b
        LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
        LEFT JOIN roles AS r_p ON r_p.ID = B2R2P.role_ID AND r_p.role_name = 'Editor'
        LEFT JOIN people AS p ON p.ID = B2R2P.people_ID
        LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
        LEFT JOIN roles AS r_o ON r_o.ID = B2R2O.role_ID AND r_o.role_name = 'Publisher'
        LEFT JOIN organizations AS o ON o.ID = B2R2O.org_ID
        WHERE b.ID ='$bookID';
       
_END;

    if($debug) {
      echo 'bookQuery = ' . $bookQuery . '<br/><br/>';
    }/*end debug*/

      /*send the query*/
      $bookQueryResult = $conn->query($bookQuery);

    if($debug) {
      if (!$bookQueryResult) echo("\n Error description bookQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    if ($bookQueryResult) {

        $numberOfBookRows = $bookQueryResult->num_rows;
        $bookTitleFound = ($numberOfBookRows > 0);
        $bookTitleNotFound = ($numberOfBookRows === 0);

        for ($j = 0; $j < $numberOfBookRows; ++$j) {
            $row = $bookQueryResult->fetch_array(MYSQLI_NUM);
            /*Don't need to be washed. These are from the database, not a user*/
            $bookID = $row[0];
            $bookTitleValue = $row[1];
            $tag1Value = $row[2];
            $tag2Value = $row[3];
            $bookVolValue = $row[4];
            $bookNumValue = $row[5];
            $publisherName = $row[6];
            $publisherLocation = $row[7];
            $editorFirstName = $row[8];
            $editorMiddleName = $row[9];
            $editorLastName = $row[10];
            $editorSuffix = $row[11];
        } /*end bookquery loop*/

    }/*end if bookqueryresult*/
}/*end ifeditBook*/

 /* FOURTH - to handle placeholder text when bookNum is empty*/

if(!isset($bookNumValue) || empty($bookNumValue)) {
        $placeHolderValue = "Must be a number";
    }/*end ifemptybooknumvalue*/

    /*FIFTH - create the form, using whatever is in the prepop variables for the values and the error messages
 ** do that here*/


   /*cannot use _END syntax with simple variable substitution here. Must use lots of if/else logic*/
/*From page 3*/
echo <<<_END
<div class="container-fluid bg-light pt-4 pb-4">
  <h2>Please enter or edit Book information below.</h2>
  <div class="row">
    <div class="col-md-6">
      <form action='addBookInfo.php' method='post'>
        <div class="form-group pt-4">

          
          Book Title: $bookTitleErr<input class="form-control " type='text' name='bookTitle' value = " {$bookTitleValue}"/>
          
          <br/>Tag 1: <input class="form-control"  type="text" name="tag1" value = "{$tag1Value}" />
          <br/>Tag 2: <input class="form-control"  type="text" name="tag2" value = "{$tag2Value}"/>
          <br/>Book Volume: <input class="form-control"  type="text" name="bookVol" value = "{$bookVolValue}" />
          <br/>  
          Book Number: $bookNumErr<input class="form-control"  type="text" name="bookNum"value = "{$bookNumValue}" placeholder="{$placeHolderValue}"/>
          
            <br/><input class="btn btn-secondary" type='submit' value='Submit new information'/>
            $onSuccess
            <input type='hidden' name='bookID' value='$bookID'/>
        
        
        </div>  <!-- end form-group -->
      </form> <!-- end form -->
    </div>  <!-- end col -->
  </div>  <!-- end row -->
</div>  <!-- end container -->

_END;


/*destroy session variables*/
unset($_SESSION['addBookInfo_validationFailed']);
unset($_SESSION['addBookInfo_bookTitle_value']);
unset($_SESSION['addBookInfo_tag1_value']);
unset($_SESSION['addBookInfo_tag2_value']);
unset($_SESSION['addBookInfo_bookVol_value']);
unset($_SESSION['addBookInfo_bookNum_value']);
unset($_SESSION['bookNumErr']);
unset($_SESSION['bookTitleErr']);
unset($_SESSION['addRole_bookID_value']);








include 'footer.html';
include 'endingBoilerplate.php';

?>
