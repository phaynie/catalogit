<?php


include 'boilerplate.php';

if ($debug) {
    echo <<<_END

<p>bookPrintPage.php-16</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

/*Initialize variables*/
$compositionID = "";
$bookID = "";





/*create local variables for REQUEST values*/

if(isset($_REQUEST['compositionID']) && is_numeric($_REQUEST['compositionID'])) {
    $compositionID = $_REQUEST['compositionID'];
}

if(isset($_REQUEST['bookID']) && is_numeric($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}


/*Here we will wash any variables that will be used in a db query on this page*/
$washPostVar = cleanup_post($bookID);
$bookIDAltered = strip_before_insert($conn, $washPostVar);





/*collect Book Info*/

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
      LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
      LEFT JOIN people AS p ON p.ID= B2R2P.people_ID
      WHERE b.ID = '$bookIDAltered';

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
        $editorPeopleID = $row[0];
        $editorPeopleFirstName = $row[1];
        $editorPeopleMiddleName = $row[2];
        $editorPeopleLastName = $row[3];
        $editorPeopleSuffix = $row[4];
        /*$editorPeopleString = implode(',',$instVal);*/
        $editorPeopleString .= $editorPeopleFirstName .  " " . $editorPeopleMiddleName . " " . $editorPeopleLastName . " " . $editorPeopleSuffix . "</br></br>Editor Name: ";

    } /*for loop ending*/

} /*End if $resultEditorPeopleQuery query*/

$displayEditorPeopleString = rtrim($editorPeopleString,'</br>Editor Name: ');






/*Retrieving all publisher info for this book
I will also be creating a comma separated list to use in the displayed information, except my comma will be a break and Publisher Name: */
$publisherOrgQuery = <<<_END

      SELECT  o.ID, o.org_name, o.location
      FROM books AS b 
      LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
      LEFT JOIN organizations AS o ON o.ID= B2R2O.org_ID
      WHERE b.ID = '$bookIDAltered';

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
        $publisherOrgID = $row[0];
        $publisherOrgName = $row[1];
        $publisherOrgLocation = $row[2];

        /*$editorPeopleString = implode(',',$instVal);*/
        $publisherOrgString .= $publisherOrgName . "</br> Publisher Location: " . $publisherOrgLocation . "</br></br>Publisher Name: ";

    } /*for loop ending*/

} /*End if $resultPublisherOrgQuery*/

$displayPublisherOrgString = rtrim($publisherOrgString,'</br>Publisher Name: ');



/*collect Compositions from that book info*/

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
         Book Number: $bookNumber<br/><br/>
         Editor Name: $displayEditorPeopleString<br/><br/>
         Publisher Name: $displayPublisherOrgString <br/><br/>
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

    if ($resultCompositionQuery) {
        $numberOfCompositionRows = $resultCompositionQuery->num_rows;
        if ($debug) {
            echo 'rows = ' . $numberOfCompositionRows . '<br/><br/>';
        }/*end debug*/

        $compositionsFound1 = ($numberOfCompositionRows > 0);
        $compositionsNotFound1 = ($numberOfCompositionRows === 0);


        if ($compositionsNotFound1) {

            echo <<<_END
  
     
       
        <br><br><br><h5 class='text-dark'>No Compositions from  "$bookTitle" were found. <br/><br/></h5>
      
  
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
                       
                <input class="btn  btn-link" type="submit" value="$compName" />
                <input type="hidden" name="compositionID" value= "$compositionID" />
                <input type="hidden" name="bookID" value= "$bookID" />
                <input type="hidden" name="compName" value= "$compName" />
                       
             </form> <!-- form -->        
                 
_END;

            } /*for loop ending*/
        } /*end if compositions found*/
    }/*end if resultcomposition query*/



echo<<<_END

    </div>  <!-- end card-body -->
           </div>  <!-- end card -->  
    </div> <!-- end col -->
        </div> <!-- end row -->
        </div> <!-- end container -->
    
</div> <!-- end container -->


<form class="pl-3 noPrint" action="displayBook.php" method="post">
    <input class="btn btn-secondary mb-3" type="submit" value="Back to Display Book"/>
    <input type="hidden" name="bookID" value='$bookID'/>
</form><br><br>

    
</div>  <!-- end card-body -->
           </div>  <!-- end card -->  
    </div> <!-- end col -->
        </div> <!-- end row -->
        </div> <!-- end container -->







_END;













include 'footer.html';
include 'endingBoilerplate.php';

?>
