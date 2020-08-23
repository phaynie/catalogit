
 
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
$publisherID = "";
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

if(isset($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if(isset($_REQUEST['publisherID'])) {
    $publisherID = $_REQUEST['publisherID'];
}

if(isset($_REQUEST['physBookLocNote'])) {
    $physBookLocNote = $_REQUEST['physBookLocNote'];
}


if($debug) {
    echo "publisherID =" . $publisherID . "<br/>";
}/*end debug*/

/*Logic for specific instances*/

$notEntered = "<span style='color:rgba(0,0,0,0.4);'>Not Entered</span>";






    

echo <<<_END

  <div class="container-fluid bg-light pt-4 pb-3">
   <h3 class="display-4">Success!</h3>
   <h3>What would you like to do with this book?</h3>
   </div>

   
    
  

_END;

  if (strlen($bookID)  > 0) {

      $bookQuery  = <<<_END

          SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, b.physBookLoc
          FROM books AS b

          WHERE b.ID = '$bookID' ;

_END;

      $bookQueryResult = $conn->query($bookQuery);

      if($debug) {
          echo 'bookQuery =' . $bookQuery . '</br>';
      }

      if (!$bookQueryResult) echo ("\n Error description query bookQuery: " . mysqli_error($conn) . "\n<br/>");
      if($bookQueryResult) {
          $numberOfBookRows = $bookQueryResult->num_rows;

          for ($j = 0; $j < $numberOfBookRows; ++$j) {
              $row = $bookQueryResult->fetch_array(MYSQLI_NUM);

              $bookID = htmlspecialchars($row[0]);
              $bookTitle = htmlspecialchars($row[1]);
              $bookTag1 = htmlspecialchars($row[2]);
              $bookTag2 = htmlspecialchars($row[3]);
              $bookVolume = htmlspecialchars($row[4]);
              $bookNumber = htmlspecialchars($row[5]);
              $physBookLocNote = htmlspecialchars($row[6]);

          }    /*forloop ending*/

      } /*end if bookquery result*/




      /*Retrieving all editor info for this book
     I will also be creating a comma separated list to use in the displayed information, except my comma will be a break and Editor Name: */
      $editorPeopleQuery = <<<_END

      SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
      FROM books AS b 
      JOIN B2R2P ON b.ID = B2R2P.book_ID
      JOIN people AS p ON p.ID= B2R2P.people_ID
      WHERE b.ID = '$bookID';

_END;

      $resultEditorPeopleQuery = $conn->query($editorPeopleQuery);
      if($debug) {
          echo 'editorPeopleQuery = ' . $editorPeopleQuery . '<br/><br/>';

          if (!$resultEditorPeopleQuery) echo ("\n Error description editorPeopleQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/

      if ($resultEditorPeopleQuery) {
          $numEditorPeopleRows = $resultEditorPeopleQuery->num_rows;
          /*Build comma separated list of editorPeople in a string*/
          $editorPeopleString= "";

          for ($j = 0 ; $j < $numEditorPeopleRows ; ++$j) {
              $row = $resultEditorPeopleQuery->fetch_array(MYSQLI_NUM);
              /*var_dump ($row);*/
              $editorPeopleID = htmlspecialchars($row[0]);
              $editorPeopleFirstName = htmlspecialchars($row[1]);
              $editorPeopleMiddleName = htmlspecialchars($row[2]);
              $editorPeopleLastName = htmlspecialchars($row[3]);
              $editorPeopleSuffix = htmlspecialchars($row[4]);
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
      WHERE b.ID = '$bookID';

_END;

      $resultPublisherOrgQuery = $conn->query($publisherOrgQuery);
      if($debug) {
          echo 'publisherOrgQuery = ' . $publisherOrgQuery . '<br/><br/>';

          if (!$resultPublisherOrgQuery) echo ("\n Error description publisherOrgQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/

      if ($resultPublisherOrgQuery) {
          $numPublisherOrgRows = $resultPublisherOrgQuery->num_rows;
          /*Build comma separated list of publisherOrg in a string*/
          $publisherOrgString= "";

          for ($j = 0 ; $j < $numPublisherOrgRows ; ++$j) {
              $row = $resultPublisherOrgQuery->fetch_array(MYSQLI_NUM);
              /*var_dump ($row);*/
              $publisherOrgID = htmlspecialchars($row[0]);
              $publisherOrgName = htmlspecialchars($row[1]);
              $publisherOrgLocation = htmlspecialchars($row[2]);

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
     
        <h3>Book Info</h3>
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
    WHERE c.book_ID = '$bookID';

_END;

$resultCompositionQuery = $conn->query($compositionQuery);
if($debug) {
    echo 'compositionQuery = ' . $compositionQuery . '<br/><br/>';

    if (!$resultCompositionQuery) echo ("\n Error description resultCompositionQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

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
            $compositionID = htmlspecialchars($row[0]);
            $compName = htmlspecialchars($row[1]);
            $bookID = htmlspecialchars($row[2]);
            $physCompositionLocNote = htmlspecialchars($row[3]);


            echo <<<_END
                 
             <form action='displayComposition.php' method='post'>
                       
                <input class="btn  btn-link" type="submit" value="$compName" />
                <input type="hidden" name="compositionID" value= "$compositionID" />
                <input type="hidden" name="bookID" value= "$bookID" />
                <input type="hidden" name="compName" value= "$compName" />
                       
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
        <input class="btn btn-secondary mb-3" type='submit' value='Edit this Book'/>
        <input type='hidden' name="bookID" value='$bookID'/>
        <input type='hidden' name="editBook" value= true />
        
      </form>
      
      <form action='compositionSearch.php' method='post'>
        <input class="btn btn-secondary mb-3" type='submit' value='Add a Composition to this book'/>
        <input type='hidden' name="bookID" value='$bookID'/>
       
      </form>

      <form action='bookTitleSearch.php' method='post'>
        <input class="btn btn-secondary mb-3" type='submit' value='Add a New Book to the Library'/>
      </form>

      <form action='introPage.php' method='post'>
        <input class="btn btn-secondary mb-3" type='submit' value='Search the Library'/>
      </form>

      <form action='bookPrintPage.php' method='post'>
        <input class="btn btn-secondary mb-3" type='submit' value='Print this book information'/>
        <input type='hidden' name="bookID" value='$bookID'/> 
        <input type='hidden' name="printBook" value="true"/>       
      </form>

      <form action='exitMessage.php' method='post'>
        <input class="btn btn-secondary mb-3" type='submit' value='Exit Library'/>
      </form>
     
    </div> <!-- end col -->
  </div> <!-- end row -->
</div>  <!-- end container -->

_END;


  
    
include 'footer.html';
include 'endingBoilerplate.php';
?>

