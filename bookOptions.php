<?php
include 'boilerplate.php';
/*Not current. See bookOptions2*/
if($debug) {
  echo <<<_END
  
  <p>bookoptions-3</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

/*Lists books with similar titles*/     

/*Initialize variables coming from other pages*/

$bookID = "";
$searchBookTitle = "";
$bookTitle = "";
$bookTag1 = "";
$bookTag2 = "";
$bookVolume = "";
$bookNumber = "";

/*create local variables for the REQUEST values*/

if(isset($_REQUEST['bookID'])) {
  $bookID = $_REQUEST['bookID'];
}

if(isset($_REQUEST['searchBookTitle'])) {
  $searchBookTitle = $_REQUEST['searchBookTitle'];
}



/*printed out header, now we will loop through results set and display book
 per row*/

/*In this section we will process Book information being submitted to the database by the user in the form on pg 32 addBookInfo.php*/
/*if the user entered at least the title of the book in the form on pg 32 addBookInfo*/

if (isset($_POST['bookTitle'])) {

  
  /*Get all the fields from the form*/
  /*wash the data coming in from user form pg 32 addBookInfo.php*/


  $washPostVar = cleanup_post($_POST['bookTitle']);
  $bookTitle = strip_before_insert($conn, $washPostVar);

  $washPostVar = cleanup_post($_POST['tag1']);
  $bookTag1 = strip_before_insert($conn, $washPostVar);

  $washPostVar = cleanup_post($_POST['tag2']);
  $bookTag2 = strip_before_insert($conn, $washPostVar);

  $washPostVar = cleanup_post($_POST['bookVol']);
  $bookVolume = strip_before_insert($conn, $washPostVar);

  $washPostVar = cleanup_post($_POST['bookNum']);
  $bookNumber = strip_before_insert($conn, $washPostVar);

  /*validate form info*/


  /*create the insert query to add the user's book info into the books table*/
  $bookInsertQuery = <<<_END

  INSERT INTO books (title, tag1, tag2, book_vol, book_num)
  VALUES('$bookTitle','$bookTag1', '$bookTag2', '$bookVolume', '$bookNumber');

_END;

if($debug) {
  echo ("\n bookInsertQuery= " . $bookInsertQuery . "\n<br/>");
}/*end debug*/
  /*send query and place result into this variable*/
  $bookInsertQueryResult = $conn->query($bookInsertQuery);

if($debug) {
  if (!$bookInsertQueryResult) echo ("\n Error description bookInsertQueryResult: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

/*Now, get fresh book info from the database */

$bookQuery  =  <<<_END
 SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, o.org_name, o.location, p.firstname, p.middlename, p.lastname, p.suffix
    FROM books AS b
    LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
    LEFT JOIN roles AS r_p ON r_p.ID = B2R2P.role_ID AND r_p.role_name = 'Editor'
    LEFT JOIN people AS p ON p.ID = B2R2P.people_ID
    LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
    LEFT JOIN roles AS r_o ON r_o.ID = B2R2O.role_ID AND r_o.role_name = 'Publisher'
    LEFT JOIN organizations AS o ON o.ID = B2R2O.org_ID
    WHERE b.title ='$bookTitle';

_END;

if($debug) {
  echo 'bookQuery = ' . $bookQuery . '<br/><br/>';
}/*end debug*/

          /*send the query*/
  $resultBookQuery = $conn->query($bookQuery);

if($debug) {
  if(!$resultBookQuery) echo("\n Error description bookQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

  if($resultBookQuery) {
    $numberOfBookRows = $resultBookQuery->num_rows;
    $bookTitleFound = ($numberOfBookRows > 0);
    $bookTitleNotFound = ($numberOfBookRows === 0);


    if ($bookTitleNotFound) {

      echo <<<_END
          
      <div class="container-fluid bg-secondary pb-3">
        <h2 class="display-4">Oops...<br/><br/></h2>
        <h2 class="text-dark">This Book info was not successfully entered into the  music library. <br/><br/></h2>
        <h4 class="text-light" >You may want to try again, or report the error.<br/><br/></h4>     
        <form action='addBookInfo.php' method='post'>
          <input class="btn btn-light" type='submit' value='Try adding Book Info again' />
        </form> <!-- end form -->
  
        <form action="reportError.php' method='post'>
          <input class="btn btn-light" type='submit' value='Report Error' />
        </form> <!-- end form -->
      </div>  <!-- end container -->
                       
_END;
          
    } /*END if bookTitle not found*/

    if ($bookTitleFound) {
      echo <<<_END
  
      <div class="container-fluid bg-secondary pt-4 pb-3">
        <h5 class="text-light pb-2">Click on the "Choose this Book" button to continue.</h5>
  
_END;


    /*build loop*/
    for ($j = 0 ; $j < $numberOfBookRows ; ++$j) {
      $row = $resultBookQuery->fetch_array(MYSQLI_NUM);
      /*Don't need to be washed. These are from the database, not a user*/
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

    echo <<<_END
           
  
         
    <div class="card mb-3" >
      <div class="card-body bg-light">
        <form action='displayBook.php' method='post'>
        <div class="form-check">
          Book Title: $bookTitle<br>
          Book Tag 1: $bookTag1<br>
          Book Tag 2: $bookTag2<br>
          Book Volume: $bookVolume<br>
          Book Number: $bookNumber<br>
          Editor Name: $editorFirstName $editorMiddleName $editorLastName $editorSuffix<br>
          Publisher Name: $publisherName<br>
          Publisher Location: $publisherLocation<br><br>

          <input class="btn" type='submit' value='Choose this Book'/>
          <input type='hidden' name='bookID' value='$bookID'/>
          </div><br/> <!-- form-check -->
        </form><br/> <!-- form -->
        
        <form action='displayBook.php' method='post'>
        <div class="form-check">
          <input class="btn" type='submit' value='Delete this Book'/>
          <input type='hidden' name='bookID' value='$bookID'/>
          </div><br/> <!-- form-check -->
        </form><br/> <!-- form -->
        
      </div> <!-- end card-body -->   
    </div>  <!-- end card -->
 
    
_END;

    } /*for loop ending*/

    echo <<<_END

      </div> <!-- end container -->

      <div class="container-fluid bg-secondary text-light pb-3">
        <h2 class="mb-3">None of these Book Options match</h2>
        <form action="addBookInfo.php" method='post'>
          <input class="btn btn-light" type='submit' value='Add New Book Info'/>
        </form> <!-- end form -->
        
      </div> <!-- end container -->

_END;

    } /*End if bookTitleFound*/
  } /*End if $resultBookQuery*/

} /*end if isset bookTitle*/












/*In this section we will search the database for the book the user is looking for. They will have submitted the title of the book they want to find in the text box on pg 2 bookTitleSearch.php Then the possible books are displayed. Then, if, even though there may be a result but none of the results are the book the user is looking for, then there is an option to add the book information to the database using the code above.*/


if(strlen($searchBookTitle) > 0) {
       
      /*searches the database for the Book the user is looking for */

      $bookQuery  =  <<<_END
    
      SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, o.org_name, o.location, p.firstname, p.middlename, p.lastname, p.suffix
        FROM books AS b
        LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
        LEFT JOIN roles AS r_p ON r_p.ID = B2R2P.role_ID AND r_p.role_name = 'Editor'
        LEFT JOIN people AS p ON p.ID = B2R2P.people_ID
        LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
        LEFT JOIN roles AS r_o ON r_o.ID = B2R2O.role_ID AND r_o.role_name = 'Publisher'
        LEFT JOIN organizations AS o ON o.ID = B2R2O.org_ID
        WHERE b.title ='$searchBookTitle';
       
_END;

    if($debug) {
      echo 'bookQuery = ' . $bookQuery . '<br/><br/>';
    }/*end debug*/

      /*send the query*/
      $bookQueryResult = $conn->query($bookQuery);

    if($debug) {
      if (!$bookQueryResult) echo("\n Error description bookQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

      if ($bookQueryResult){

        $numberOfBookRows = $bookQueryResult->num_rows;
        $bookTitleFound = ($numberOfBookRows > 0);
        $bookTitleNotFound = ($numberOfBookRows === 0);

        if ($bookTitleNotFound) {

          echo <<<_END
      
          <div class="container-fluid  bg-secondary  pb-3">
            <h2 class="display-4 text-light">Bummer!<br/><br/></h2>
            <h2 class='text-dark'>No Book by the name of "$searchBookTitle" was found. <br/><br/></h2>
            <h4 class='text-light'>Which would you like to do?<br/><br/></h4>
            <form action='bookTitleSearch.php' method='post'>    
              <input class="btn btn-light" type='submit' value='Try Another Search'/> 
            </form><br/>
            <form action='addBookInfo.php' method='post'>    
              <input class="btn btn-light" type='submit' value='Add New Book Info'/> 
            </form><br/>
            
          </div> <!--end container-->
      
_END;

        } /*END if $bookTitleNotFound*/



        if ($bookTitleFound) {

          echo <<<_END
    
          <div class="container-fluid bg-secondary pb-3 "> 
               
            <h2 class="display-3">Books similar to yours</h2>
            <h5 class="text-light pb-2">Click on the "choose book" button to continue. </h5>
          
_END;



          for ($j = 0 ; $j < $numberOfBookRows ; ++$j) {
            $row = $bookQueryResult->fetch_array(MYSQLI_NUM);
            /*Don't need to be washed. These are from the database, not a user*/
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

          echo <<<_END
           
                    
            <div class="card mb-3" >
              <div class="card-body bg-light">
             
                <form action='displayBook.php' method='post'>
                <div class="form-check">
                  Book Title: $bookTitle<br>
                  Book Tag 1: $bookTag1<br>
                  Book Tag 2: $bookTag2<br>
                  Book Volume: $bookVolume<br>
                  Book Number: $bookNumber<br>
                  Editor Name: $editorFirstName $editorMiddleName $editorLastName $editorSuffix<br>
                  Publisher Name: $publisherName<br>
                  Publisher Location: $publisherLocation<br><br>
                  
                  <input class="btn mt-4" type='submit' value='Choose this Book'/>
                  
                  <input type='hidden' name='bookID' value= $bookID />
                  </div><br/> <!-- form-check -->
                </form><br/> <!-- form -->
               
              </div> <!-- end card-body -->   
            </div>  <!-- end card -->
     
        
_END;

          } /*for loop ending*/



          echo <<<_END
    
          </div> <!-- end container-->
    
          <div class="container-fluid  bg-secondary text-light pt-4 pb-3 ">
            <h2>None of these books match</h2>
            <form action='addBookInfo.php' method='post'>    
              <input class="btn btn-light mt-3" type='submit' value='Add New Book Info'/> 
            </form><br/><br/>
            <form action="bookTitleSearch.php" method='post'>
              <input class="btn btn-light" type='submit' value='Try Another Book Title Search'/>
            </form> <!-- end form -->
          </div> <!--end container-->

_END;

        } /*END if $bookTitleFound*/

        echo <<<_END
    
          </div> <!-- end container -->  
       
_END;


  } /*end if bookQuery result*/
} /*end if isset searchBookTitle*/
  

include 'footer.php';
include 'endingBoilerplate.php';

?>
