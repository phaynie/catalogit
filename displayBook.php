
 
<?php


include 'boilerplate.php';

if($debug) {

    echo <<<_END

        <p>Display book-4</p>

_END;

}/*end debug*/

include 'beginningNav.php';


/*Initialize local variables for values coming from other pages*/
$bookID = "";

$bookTag1 = "";
$bookTag2 = "";
$bookVolume = "";
$bookNumber = " ";
$publisherName = "";
$editorFirstName = "";
$editorMiddleName = "";
$editorLastName = "";
$editorSuffix = "";
$displayEditorPeopleString = "";
$publisherLocation = "";
$displayPublisherOrgString = "";
$physBookLocNote = "";

$editorPeopleID = "";
$editorPeopleFirstName ="";
$editorPeopleMiddleName = "";
$editorPeopleLastName = "";
$editorPeopleSuffix = "";
$publisherOrgID = "";
$publisherOrgName = "";
$publisherOrgLocation = "";
$disableERDPub = "";
$disableERDEditor = "";

/*Initialize variables to be used in the form*/

if(isset($_REQUEST['bookID']) && is_numeric($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}




/*Logic for specific instances*/

$notEntered = "<span style='color:rgba(0,0,0,0.4);'>Not Entered</span>";



/*here we will was any variables that will be used in the db queries below*/

$washPostVar = cleanup_post($bookID);
$bookIDAltered = strip_before_insert($conn, $washPostVar);



    

echo <<<_END

  <div class="container-fluid bg-light pt-4 pb-3">
   <h3 class="display-4 noPrint">Success!</h3>
   <h3 class="noPrint">What would you like to do with this book?</h3>
   </div>

   
    
  

_END;

  if (strlen($bookIDAltered)  > 0) {

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

      failureToExecute ($bookQueryResult, 'S536', 'Select ' );


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
      JOIN B2R2P ON b.ID = B2R2P.book_ID
      JOIN people AS p ON p.ID= B2R2P.people_ID
      WHERE b.ID = '$bookIDAltered';

_END;

      $resultEditorPeopleQuery = $conn->query($editorPeopleQuery);
      if($debug) {
          echo 'editorPeopleQuery = ' . $editorPeopleQuery . '<br/><br/>';

          if (!$resultEditorPeopleQuery) echo ("\n Error description editorPeopleQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/

      failureToExecute ($resultEditorPeopleQuery, 'S537', 'Select ' );


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
              $editorPeopleString .= $editorPeopleFirstName .  " " . $editorPeopleMiddleName . " " . $editorPeopleLastName . " " . $editorPeopleSuffix . ", ";

          } /*for loop ending*/

      } /*End if $resultEditorPeopleQuery query*/

      /*$displayEditorPeopleString = rtrim($editorPeopleString,'</br>Editor Name: ');*/

      $displayEditorPeopleString = substr($editorPeopleString, 0, strrpos($editorPeopleString, ", " ));




      /*Retrieving all publisher info for this book
     I will also be creating a comma separated list to use in the displayed information, except my comma will be a break and Publisher Name: */
      $publisherOrgQuery = <<<_END

      SELECT  o.ID, o.org_name, o.location
      FROM books AS b 
      JOIN B2R2O ON b.ID = B2R2O.book_ID
      JOIN organizations AS o ON o.ID= B2R2O.org_ID
      WHERE b.ID = '$bookIDAltered';

_END;

      $resultPublisherOrgQuery = $conn->query($publisherOrgQuery);
      if($debug) {
          echo 'publisherOrgQuery = ' . $publisherOrgQuery . '<br/><br/>';

          if (!$resultPublisherOrgQuery) echo ("\n Error description publisherOrgQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/

      failureToExecute ($resultPublisherOrgQuery, 'S538', 'Select ' );


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
              $publisherOrgString .= $publisherOrgName . "</br> Publisher Location: " . $publisherOrgLocation . "</br>Publisher Name: ";

          } /*for loop ending*/

      } /*End if $resultPublisherOrgQuery*/

     /* $displayPublisherOrgString = rtrim($publisherOrgString,'</br>Publisher Name: ');*/

      $displayPublisherOrgString = substr($publisherOrgString, 0, strrpos($publisherOrgString, "</br></br>Publisher Name: " ));



      /*book*/

      if($bookTag1 == "" ) {
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

      if($displayEditorPeopleString == "" ) {
          $displayEditorPeopleString = $notEntered;
      }

      if($displayPublisherOrgString == "" ) {
          $displayPublisherOrgString = $notEntered;
      }









      echo <<<_END

  <div class="container-fluid bg-light pt-4 pb-5">
    <div class="row">
      <div class="col-md-6  pb-4">
        <div class="card  mt-4 mb-3">
           <div class="card-body bg-light">
     
        <h3>$bookTitle</h3><br/><br/>
         Book Title:<strong> $bookTitle </strong><br/>
         Tag 1: $bookTag1<br/>
         Tag 2: $bookTag2<br/>
         Book Volume: $bookVolume<br/>
         Book Number: $bookNumber<br/>
         Editor Name: $displayEditorPeopleString<br/>
         Publisher Name: $displayPublisherOrgString <br/>
         Book Location:<span style="color:#EB6B42;">  $physBookLocNote</span><br/><br/>
       
  
_END;


/*Here is how we display the composition links*/

$compositionQuery = <<<_END
    SELECT c.ID, c.comp_name, c.book_ID, c.physCompositionLoc
    FROM compositions AS c
    WHERE c.book_ID = '$bookIDAltered';

_END;

$resultCompositionQuery = $conn->query($compositionQuery);
if($debug) {
    echo 'compositionQuery = ' . $compositionQuery . '<br/><br/>';

    if (!$resultCompositionQuery) echo ("\n Error description resultCompositionQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

      failureToExecute ($resultCompositionQuery, 'S539', 'Select ' );


      if ($resultCompositionQuery) {
    $numberOfCompositionRows = $resultCompositionQuery->num_rows;
    if ($debug) {
        echo 'rows = ' . $numberOfCompositionRows . '<br/><br/>';
    }/*end debug*/

    $compositionsFound1 = ($numberOfCompositionRows > 0);
    $compositionsNotFound1 = ($numberOfCompositionRows === 0);


    if ($compositionsNotFound1) {

        echo <<<_END
  
     
        <h2 class=" text-light">Bummer!<br/><br/></h2>
        <h5 class='text-dark'>No Compositions from  "$bookTitle" were found. <br/><br/></h5>
      
  
_END;

    } /*END if $compositionsNotFound*/

    if($compositionsFound1) {

        echo <<<_END

      
        <h5 class=" pt-4">Compositions from $bookTitle </h5>
      
_END;

        for ($j = 0; $j < $numberOfCompositionRows; ++$j) {
            $row = $resultCompositionQuery->fetch_array(MYSQLI_NUM);
            /*Don't need to be washed. These are from the database, not a user*/
            $compositionID = $row[0];
            $compName = $row[1];
            $bookID = $row[2];
            $physCompositionLocNote = $row[3];


            echo <<<_END
                 
             <form action='displayComposition.php' method='post'>
                       
                <input class="btn  btn-link" type="submit" value="{$fn_encode($compName)}" />
                <input type="hidden" name="compositionID" value= "$compositionID" />
                <input type="hidden" name="bookID" value= "$bookID" />
                <input type="hidden" name="compName" value= "{$fn_encode($compName)}" />
                       
             </form> <!-- form -->        
                 
_END;

             } /*for loop ending*/
         } /*end if compositions found*/
     }/*if resultcomposition query*/
  } /*end if (strnlen($bookID)  > 0)*/















      echo<<<_END

    </div>  <!-- end card-body -->
           </div>  <!-- end card -->  
    </div> <!-- end col -->

_END;

    echo <<<_END

   
    <div class="col-md-4  pb-4 pt-3 mt-4">
       
      <form action='editBook.php' method='post'>
        <input class="btn btn-secondary mb-3 noPrint" type='submit' value='Edit this Book'/>
        <input type='hidden' name="bookID" value='$bookID'/>
        <input type='hidden' name="editBook" value= true />
        
      </form>
      
      <form action='compositionSearch.php' method='post'>
        <input class="btn btn-secondary mb-3 noPrint" type='submit' value='Add a Composition to this book'/>
        <input type='hidden' name="bookID" value='$bookID'/>
       
      </form>

      <form action='bookTitleSearch.php' method='post'>
        <input class="btn btn-secondary mb-3 noPrint" type='submit' value='Add a New Book to the Library'/>
      </form>

      <form action='introPage.php' method='post'>
        <input class="btn btn-secondary mb-3 noPrint" type='submit' value='Search the Library'/>
      </form>

      <form action='displayBook.php' method='post'>
        <button class="btn btn-secondary mb-3 noPrint" onclick="window.print()">Print this book information</button>
        <input type='hidden' name="bookID" value='$bookID'/> 
        <input type='hidden' name="printBook" value="true"/>       
      </form>

      <form action='exitMessage.php' method='post'>
        <input class="btn btn-secondary mb-3 noPrint" type='submit' value='Exit Library'/>
      </form>
     
    </div> <!-- end col -->
  </div> <!-- end row -->
</div>  <!-- end container -->

_END;


  
    
include 'footer.php';
include 'endingBoilerplate.php';
?>

