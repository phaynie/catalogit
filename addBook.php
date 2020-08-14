<?php
/*This page provides a form with which to add or edit book info.
When we are editing a book we see the form pre-populated with current book info we will validate, wash and update. goes to edit book again and again until user is finished updating and chooses "Done".
When we are adding new book info, we will validate, wash and insert new info. we are sent to peopleSearch to continue adding information to the book.
*/
include 'boilerplate.php';

if($debug) {
    echo <<<_END

    <p>addBook-32</p>

_END;

}/*end debug*/


/*include 'beginningNav.html';*/
include 'beginningNav.php';

/*Initialize local variables for values coming from previous page*/

$bookID = "";
$editBook = "";
$submit = "";
$addNewBook = "";



/* big space because i don't care about all the stuff above - and i don't want to think about it.
 *
 * general idea is to:
 * FIRST - initialize all the prepop variables that will hold any existing values to be pre-populated in form and also error messages
 * do that here*/


$bookTitle = "";
$tag1 = "";
$tag2 = "";
$bookVol = "";
$bookNum = "";
$placeHolder = "";
$editBook = "";
$physBookLocNote = "";
$debug_string = "";

/*Set local variables and assign the REQUEST values coming from the form or previous page. */

if(isset($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if(isset($_REQUEST['editBook'])) {
    $editBook = $_REQUEST['editBook'];
}

if(isset($_REQUEST['submit'])) {
    $submit = $_REQUEST['submit'];
}

if(isset($_REQUEST['addNewBook'])) {
    $addNewBook = $_REQUEST['addNewBook'];
}

if(isset($_REQUEST['bookTitle'])) {
    $bookTitle = $_REQUEST['bookTitle'];
}

if(isset($_REQUEST['bookVol'])) {
    $bookVol = $_REQUEST['bookVol'];
}

if(isset($_REQUEST['tag1'])) {
    $tag1 = $_REQUEST['tag1'];
}

if(isset($_REQUEST['tag2'])) {
    $tag2 = $_REQUEST['tag2'];
}


if(isset($_REQUEST['bookNum'])) {
    $bookNum = $_REQUEST['bookNum'];
}

if(isset($_REQUEST['physBookLocNote'])) {
    $physBookLocNote = $_REQUEST['physBookLocNote'];
}

$validationFailed = false;  /*A single place to track whether any validation has failed.*/




/*Logic for passing variables along from page to page*/

if($editBook == 'true') {
    $sendEditBook = "<input type='hidden' name='editBook' value= 'true' />";
    $primaryText = "<h2>Please edit Book Information below</h2>";
}else{
    $primaryText = "<h2>Please enter new Book Information below</h2>";

}

if($addNewBook == 'true') {
    $sendAddNewBook = "<input type='hidden' name='addNewBook' value= 'true' />";
}

/*Validation Code Section
if $validationFailed is true, we will show form pre-populated with error messages and user can re-submit values.
if $validationFailed is false, we will wash data coming from the form.
If editing the book we will update the form and send the user to editBook
If adding new book info we will insert, claim a book  Id and continue to search publisher.*/

if($submit == 'true') {



        if($bookTitle == "") {
            $bookTitleErr = "<span class='error'>* Book Title is required</span>";
            $validationFailed = true;
        } /*end if($bookTitle == "") > 0)*/

        if($bookNum !== "" && !is_numeric($bookNum)) {
            $bookNumErr = "<span class='error'>* Book Number must be empty or a number</span>";
            $validationFailed = true;
        } /*end if(strlen($bookTitle) > 0)*/





    /*Validation successful!
Here we wash all values that come from the form*/

    if($bookTitle !== "" && !$validationFailed) {

        $washPostVar = cleanup_post($bookTitle);
        $bookTitle = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($tag1);
        $tag1 = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($tag2);
        $tag2 = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($bookVol);
        $bookVol = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($bookNum);
        $bookNum = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($physBookLocNote);
        $physBookLocNote = strip_before_insert($conn, $washPostVar);





        if ($editBook == 'true') { //we came from editBook.php and passed this clue through
            /*all the update code here*/

            $updateBooks = " UPDATE books AS b SET ";
            $updateBooks .= "b.title = '$bookTitle', ";
            if($tag1 == "") {
                $updateBooks .= "b.tag1 = NULL,";
            }else{
                $updateBooks .= "b.tag1 = '$tag1',";
            }

            if($tag2 == "") {
                $updateBooks .= "b.tag2 = NULL,";
            }else{
                $updateBooks .= "b.tag2 = '$tag2',";
            }

            if($bookVol == "") {
                $updateBooks .= "b.book_vol = NULL,";
            }else{
                $updateBooks .= "b.book_vol = '$bookVol',";
            }

            if($bookNum == "") {
                $updateBooks .= "b.book_num = NULL,";
            }else{
                $updateBooks .= "b.book_num = '$bookNum',";
            }

            if($physBookLocNote == "") {
                $updateBooks .= "b.physBookLoc = NULL";
            }else{
                $updateBooks .= "b.physBookLoc = '$physBookLocNote'";
            }

                $updateBooks .= " WHERE b.ID = $bookID;";
                


            $updateBooksResult = $conn->query($updateBooks);

            if ($debug) {
                $debug_string = "\nupdateBooks= " . $updateBooks . "\n<br/>";
                if (!$updateBooksResult) $debug_string .="\n Error description updateBooks: " . mysqli_error($conn) . "\n<br/>";
            }/*end debug*/

             /* echo $debug_string;
       exit();*/

            header('Location: editBook.php?bookID=' . $bookID . '&editBook=true');
            exit();


        } elseif ($editBook == "") {

            /*Build the insert query string*/
            $bookInsertQuery = "INSERT INTO books (title, tag1, tag2, book_vol, book_num, physBookLoc)
        VALUES(";
            $bookInsertQuery .= "'$bookTitle',";
            if($tag1 == "") {
                $bookInsertQuery .= "NULL,";
            }else{
                $bookInsertQuery .= "'$tag1',";
            }

            if($tag2 == "") {
                $bookInsertQuery .= "NULL,";
            }else{
                $bookInsertQuery .= "'$tag2',";
            }

            if($bookVol == "") {
                $bookInsertQuery .= "NULL,";
            }else{
                $bookInsertQuery .= "'$bookVol',";
            }

            if($bookNum == "") {
                $bookInsertQuery .= "NULL,";
            }else{
                $bookInsertQuery .= "'$bookNum',";
            }

            if($physBookLocNote == "") {
                $bookInsertQuery .= "NULL)";
            }else{
                $bookInsertQuery .= "'$physBookLocNote')";
            }


            /*Send the query to the database*/
            $bookInsertQueryResult = $conn->query($bookInsertQuery);
            if ($debug) {
                echo("\nbookInsertQuery= " . $bookInsertQuery . "\n<br/>");
                if (!$bookInsertQueryResult) echo("\n Error description bookInsertQuery: " . mysqli_error($conn) . "\n<br/>");
            }/*end debug*/

            /*Getting book ID for the book just inserted into database*/
            $bookID = $conn->insert_id;


            header('Location: editBook.php?bookID=' . $bookID . '&bookTitle=' . $bookTitle);
            /*Where we will continue adding Editor and Publisher info to our new book.*/
        } /*End elseif($editBook == "")*/
        exit();

    } /*End if(strlen($bookTitle) > 0 && !$validationFailed)*/

} /*End if($submit == 'true')*/


/*if not adding new or fixing failed validation we will need a pre-populated form to edit this general book info*/
/*Here we gather the general book information that will pre-populate this form for editing. */
if($submit == "") {
    if ($editBook == 'true' ) {
        $bookQuery  =  <<<_END
    
      SELECT  b.title, b.tag1, b.tag2, b.book_vol, b.book_num, b.physBookLoc
        FROM books AS b
        
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

                $bookTitle = $row[0];
                $tag1 = $row[1];
                $tag2 = $row[2];
                $bookVol = $row[3];
                $bookNum = $row[4];
                $physBookLocNote = $row[5];

            } /*end bookquery loop*/

        }/*end if bookqueryresult*/

    } /*End if ($editBook == 'true' || $bookID > 0)*/




}/*End if($submit == "")*/

if($bookNum == 'NULL') {
    $bookNum = "";
}

if(isset($_REQUEST['bookVol']) && $_REQUEST['bookNum'] !== "") {
    $bookVol = $_REQUEST['bookVol'];
}


/* - create the form, using whatever is in the prepop variables for the values and the error messages*/

echo <<<_END
<div class="container-fluid bg-light pt-4 pb-4">
  $primaryText
  <div class="row">
    <div class="col-md-6">
      <form action='addBook.php' method='post'>
        <div class="form-group pt-4">

          
          Book Title: $bookTitleErr <input class="form-control " type='text' name='bookTitle' value = " $bookTitle"/>
          <br/>Tag 1: <input class="form-control"  type="text" name="tag1" value = "$tag1" />
          <br/>Tag 2: <input class="form-control"  type="text" name="tag2" value = "$tag2"/>
          <br/>Book Volume: <input class="form-control"  type="text" name="bookVol" value = "{$bookVol}" />
          <br/>  
          Book Number: $bookNumErr<input class="form-control"  type="text" name="bookNum"value = "{$bookNum}" placeholder="{$placeHolder}"/>
          <br/>Book Location: <input class="form-control"  type="text" name="physBookLocNote" value = "$physBookLocNote" />
          <p> *If using quotes: Use single quotes rather than double</p>
          
            <br/><input class="btn btn-secondary" type='submit' value='Submit new information'/>
            <input type='hidden' name='submit' value='true'/>
            <input type='hidden' name='bookID' value='$bookID'/>
            $sendEditBook
            $sendAddNewBook
        
        </div>  <!-- end form-group -->
      </form> <!-- end form -->
       <form action='introPage.php' method='post'>
        <div class="form-group pt-4">
            <br/><input class="btn btn-secondary" type='submit' value='Back to Intro Page Options'/>
            
        
        </div>  <!-- end form-group -->
      </form> <!-- end form -->

_END;


 if($editBook == 'true') {
     echo <<<_END
      <form action='editBook.php' method='post'>
        <div class="form-group pt-4">
            <br/><input class="btn btn-secondary" type='submit' value='Back to Edit Book'/>
            <input type='hidden' name='bookID' value='$bookID'/>
            $sendEditBook
            $sendAddNewBook
        
        </div>  <!-- end form-group -->
      </form> <!-- end form -->

_END;

 } /*End if($editBook == 'true')*/

     echo <<<_END
    </div>  <!-- end col -->
  </div>  <!-- end row -->
</div>  <!-- end container -->

_END;



include 'footer.html';
include 'endingBoilerplate.php';

?>