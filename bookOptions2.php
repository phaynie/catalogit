<?php

/*DB SECURITY
will wash user info to be used in db queries ($searchBookTitle and bookID)
When data is recovered from the db we use htmlspecialchars And ENT_QUOTES to allow the info to be clean and readable again.
*/

/*We arrive at this page when:
 A. We are searching for a book and have come from  bookTitleSearch.php. We only receive the book title from the user.
    We then search for the book ID and it does not need to be washed. $bookIDAltered does not work for us in this instance.*/

include 'boilerplate.php';

if($debug) {
    echo <<<_END
  
  <p>bookOptions2-3</p>

_END;

}/*end debug*/


include 'beginningNav.php';

/*Initialize variables coming from other pages*/

$bookID = "";
$searchBookTitle = "";
$bookTitle = "";
$tag1 = "";
$tag2 = "";
$bookVolume = "";
$bookNumber = "";
$physBookLocNote = "";
$displayEditorPeopleString = "";
$displayPublisherOrgString = "";
$bookTitleFound = "";
$bookTitleNotFound = "";

/*create local variables for the REQUEST values*/

if(isset($_REQUEST['bookID']) && is_numeric($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if(isset($_REQUEST['searchBookTitle'])) {
    $searchBookTitle = $_REQUEST['searchBookTitle'];
}

/*create logic to allow variables to be used in more than one situation*/


$notEntered = "<span style='color:rgba(0,0,0,0.4);'>Not Entered</span>";

/*Here we wash this information before we send it in a db query*/


$washPostVar = cleanup_post($searchBookTitle);
$searchBookTitleAltered = strip_before_insert($conn, $washPostVar);



/*coming from bookTitleSearch.php we will only have the value from the text box now validated not washed. The name of that text box  is ‘searchBookTitle’.*/

/* Search for book information for a book by the name of ‘searchBookTitle’*/

if(strlen($searchBookTitleAltered) > 0) {
    $bookQuery = <<<_END
    
              SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, b.physBookLoc
              FROM books AS b
    
              WHERE b.title LIKE '%$searchBookTitleAltered%' ;

_END;

    $bookQueryResult = $conn->query($bookQuery);

    if ($debug) {
        echo 'bookQuery =' . $bookQuery . '</br>';
    }

    if (!$bookQueryResult) echo("\n Error description query bookQuery: " . mysqli_error($conn) . "\n<br/>");
    failureToExecute ($bookQueryResult, 'S514', 'Select ' );

    if ($bookQueryResult) {
        $numberOfBookRows = $bookQueryResult->num_rows;

        for ($j = 0; $j < $numberOfBookRows; ++$j) {
            $row = $bookQueryResult->fetch_array(MYSQLI_NUM);

            /*here we are reversing the htmlspecialchars function we used when the info was entered into the db.
            specifically allowing the quotes to be represented by " .*/
            $bookID = $row[0];
            $bookTitle = $row[1];
            $bookTag1 = $row[2];
            $bookTag2 = $row[3];
            $bookVolume = $row[4];
            $bookNumber = $row[5];
            $physBookLocNote = $row[6];

        }    /*forloop ending*/



        $bookTitleFound = ($numberOfBookRows > 0);
        $bookTitleNotFound = ($numberOfBookRows === 0);

        /*Retrieving all editor info for this book
          I will also be creating a comma separated list to use in the displayed information, except my comma will be a break and Editor Name: */

/*logic that says only look for editor etc if we got a result*/

        if ($bookTitleFound) {


            $editorPeopleQuery = <<<_END
        
              SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
              FROM books AS b 
              JOIN b2r2p ON b.ID = b2r2p.book_ID
              JOIN people AS p ON p.ID= b2r2p.people_ID
              WHERE b.ID = '$bookID';

_END;

            $resultEditorPeopleQuery = $conn->query($editorPeopleQuery);
            if ($debug) {
                echo 'editorPeopleQuery = ' . $editorPeopleQuery . '<br/><br/>';

                if (!$resultEditorPeopleQuery) echo("\n Error description editorPeopleQuery: " . mysqli_error($conn) . "\n<br/>");
            }/*end debug*/

            failureToExecute ($resultEditorPeopleQuery, 'S515', 'Select ' );


            if ($resultEditorPeopleQuery) {
                $numEditorPeopleRows = $resultEditorPeopleQuery->num_rows;
                /*Build comma separated list of editorPeople in a string*/
                $editorPeopleString = "";

                for ($j = 0; $j < $numEditorPeopleRows; ++$j) {
                    $row = $resultEditorPeopleQuery->fetch_array(MYSQLI_NUM);
                    /*var_dump ($row);*/
                    /*here we are reversing the htmlspecialchars function we used when the info was entered into the db.
                    specifically allowing the quotes to be represented by " .*/
                    $editorPeopleID = $row[0];
                    $editorPeopleFirstName = $row[1];
                    $editorPeopleMiddleName = $row[2];
                    $editorPeopleLastName = $row[3];
                    $editorPeopleSuffix = $row[4];
                    /*$editorPeopleString = implode(',',$instVal);*/
                    $editorPeopleString .= $editorPeopleFirstName . " " . $editorPeopleMiddleName . " " . $editorPeopleLastName . " " . $editorPeopleSuffix . ", ";

                } /*for loop ending*/

            } /*End if $resultEditorPeopleQuery query*/


            $displayEditorPeopleString = substr($editorPeopleString, 0, strrpos($editorPeopleString, ", "));


            /*Retrieving all publisher info for this book
            I will also be creating a comma separated list to use in the displayed information, except my comma will be a break and Publisher Name: */

            $publisherOrgQuery = <<<_END
    
                  SELECT  o.ID, o.org_name, o.location
                  FROM books AS b 
                  JOIN b2r2o ON b.ID = b2r2o.book_ID
                  JOIN organizations AS o ON o.ID= b2r2o.org_ID
                  WHERE b.ID = '$bookID';

_END;

            $resultPublisherOrgQuery = $conn->query($publisherOrgQuery);
            if ($debug) {
                echo 'publisherOrgQuery = ' . $publisherOrgQuery . '<br/><br/>';

                if (!$resultPublisherOrgQuery) echo("\n Error description publisherOrgQuery: " . mysqli_error($conn) . "\n<br/>");
            }/*end debug*/

            failureToExecute ($resultPublisherOrgQuery, 'S516', 'Select ' );


            if ($resultPublisherOrgQuery) {
                $numPublisherOrgRows = $resultPublisherOrgQuery->num_rows;
                /*Build comma separated list of publisherOrg in a string*/
                $publisherOrgString = "";

                for ($j = 0; $j < $numPublisherOrgRows; ++$j) {
                    $row = $resultPublisherOrgQuery->fetch_array(MYSQLI_NUM);
                    /*var_dump ($row);*/
                    /*here we are reversing the htmlspecialchars function we used when the info was entered into the db.
                    specifically allowing the quotes to be represented by " .*/
                    $publisherOrgID = $row[0];
                    $publisherOrgName = $row[1];
                    $publisherOrgLocation = $row[2];

                    /*$editorPeopleString = implode(',',$instVal);*/
                    $publisherOrgString .= $publisherOrgName . "</br> Publisher Location: " . $publisherOrgLocation . "</br>Publisher Name: ";

                } /*for loop ending*/

            } /*End if $resultPublisherOrgQuery*/


            $displayPublisherOrgString = substr($publisherOrgString, 0, strrpos($publisherOrgString, "</br>Publisher Name: "));
        } /*end if bookTitleFound*/
    } /*end if bookquery result*/




   if($bookTitleNotFound)  {
       echo <<<_END
      
      <div class="container-fluid bg-light pt-4 pb-3">
        <div class="displayCard bg-secondary px-4 pt-4 pb-3">
            <h2 class="display-4 text-light bummerText1 ">Bummer!<br/></h2>
            <h2 class="text-dark bummerText2">No Book with the title of "$searchBookTitle" was found. <br/><br/></h2>
                
            <form action='bookTitleSearch.php' method='post'>
              <input class="btn btn-light" type='submit' value='Try another Book Title Search' />
            </form> <!-- end form -->
            <form action="addBook.php" method='post'>
              <input class="btn btn-light" type='submit' value='Add New Book Info'/>
              <input type='hidden' name='addNewBook' value='true'/>
            </form> <!-- end form -->
        </div>
       
      </div>  <!-- end container -->
                       
_END;
   }/*End if($bookTitleNotFound)*/


    if ($bookTitleFound) {

        /*book*/

        if($bookTag1 == "") {
            $bookTag1 = $notEntered;
        }

        if($bookTag2 == "") {
            $bookTag2 = $notEntered;
        }

        if($bookVolume == "") {
            $bookVolume = $notEntered;
        }

        if($bookNumber == "") {
            $bookNumber = $notEntered;
        }

        if($physBookLocNote == "") {
            $physBookLocNote = $notEntered;
        }

        if($displayEditorPeopleString == "") {
            $displayEditorPeopleString = $notEntered;
        }

        if($displayPublisherOrgString == "") {
            $displayPublisherOrgString = $notEntered;
        }




        echo <<<_END
  
      <div class="container-fluid bg-secondary pt-2 pb-3">
        <div class="displayCard bg-secondary pt-4 pb-3">
          <h5 class="text-light pb-2">Click on the "Choose this Book" button to continue.</h5>
        </div>  
       
          <div class="card displayCard mb-3" >
              <div class="card-body bg-light">
                <form action='displayBook.php' method='post'>
                    <div class="form-check">
                      Book Title:<strong> $bookTitle </strong><br>
                      Book Tag 1: $bookTag1<br>
                      Book Tag 2: $bookTag2<br>
                      Book Volume: $bookVolume<br>
                      Book Number: $bookNumber<br>
                      Editor Name: $displayEditorPeopleString<br>
                      Publisher Name: $displayPublisherOrgString<br>
                      Book Location:  <span style="color:#EB6B42;"> $physBookLocNote</span><br><br>
            
                      <input class="btn" type='submit' value='Choose this Book'/>
                      <input type='hidden' name='bookID' value='$bookID'/>
                  </div><br/> <!-- form-check -->
                </form><br/> <!-- form -->
              </div> <!-- end card-body -->   
          </div>  <!-- end card -->
         
      </div> <!-- end container -->

      <div class="container-fluid  bg-secondary text-light pb-3">
          <div class="displayCard bg-secondary text-light pb-3">
            <h5 class="mb-3">If None of these Book Options match</h5>
            <form action="bookTitleSearch.php" method='post'>
              <input class="btn btn-light my-2" type='submit' value='Try Another Book Search'/>
            </form> <!-- end form -->
            <form action="addBook.php" method='post'>
              <input class="btn btn-light" type='submit' value='Add New Book Info'/>
              <input type='hidden' name='addNewBook' value='true'/>
    
            </form> <!-- end form -->
          </div><!-- end displayCard -->
      </div> <!-- end container -->

_END;

} /*End if bookTitleFound*/


} /*end if(strlen($searchBookTitle) > 0) */





include 'footer.php';
include 'endingBoilerplate.php';

?>
