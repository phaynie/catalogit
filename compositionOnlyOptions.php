<?php
include 'boilerplate.php';

if($debug) {
  echo <<<_END

        <p>compositionOnlyOptions-41</p>
_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

$validationFailed = false; /*A single place to track whether any validation has failed.*/

/*boilerplate is over, now validate, if needed*/

    
if(isset($_POST['searchCompositionTitle'])) {
  /*perform all validations needed for all fields*/

if($debug) {
  echo "searchCompositionTitle is set";
}/*end debug*/

  if(empty($_POST['searchCompositionTitle'])) {
    $_SESSION['searchCompositionTitleErr'] = " * Title of Composition is required";
    $validationFailed = true;
  } /*End of if empty searchCompositionTitle

  /*If any validation failed, save all form values in sessions*/

  if($validationFailed) {
    $_SESSION['compositionOnlySearch_validationFailed'] = true;
    $_SESSION['compositionOnlySearch_searchCompositionTitle_value'] = $_POST['searchCompositionTitle'];
   


    header('Location: compositionOnlySearch.php');
    exit();
  } /*end if $validationFailed*/


  /*Validation over, now save form A Post values in Database*/
  /*washes user data from text box on page 45 compositionsOnlySearch  */

  $washPostVar = cleanup_post($_POST['searchCompositionTitle']);
  $compositionTitle = strip_before_insert($conn, $washPostVar);

if($debug) {
  echo 'So Far So Good 1' . '<br/>';
}/*end debug
      /*Create a query string that gets all the easy composition info for every composition in the specific book*/
     

  $compositionQuery = <<<_END

        SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, c.movement, e.description,v.voicing_type, ens.ensemble_type, c.book_ID, p_composer.firstname, p_composer.middlename, p_composer.lastname, p_composer.suffix, p_arranger.firstname, p_arranger.middlename, p_arranger.lastname, p_arranger.suffix, p_lyricist.firstname, p_lyricist.middlename, p_lyricist.lastname, p_lyricist.suffix
        FROM compositions AS c
        LEFT JOIN eras AS e ON c.era_ID = e.ID
        LEFT JOIN voicing AS v ON c.voice_ID = v.ID
        LEFT JOIN ensembles AS ens ON c.ensemble_ID = ens.ID
        LEFT JOIN books AS b ON c.book_ID = b.ID
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID 
        LEFT JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID 
        LEFT JOIN roles AS r_arranger ON C2R2P.role_ID = r_arranger.ID 
        LEFT JOIN roles AS r_lyricist ON C2R2P.role_ID = r_lyricist.ID 
        LEFT JOIN people AS p_composer ON C2R2P.people_ID = p_composer.ID AND r_composer.role_name = 'Composer'
        LEFT JOIN people AS p_arranger ON C2R2P.people_ID = p_arranger.ID AND r_arranger.role_name = 'Arranger'
        LEFT JOIN people AS p_lyricist ON C2R2P.people_ID = p_lyricist.ID AND r_lyricist.role_name = 'Lyricist'

        WHERE c.comp_name = '$compositionTitle';

_END;

if($debug) {
  echo 'So Far So Good 2' . '<br/>';
  echo 'compositionQuery = ' . $compositionQuery . '<br/><br/>';
}/*end debug*/

/*send the query*/
  $resultCompositionQuery = $conn->query($compositionQuery);
 
  
  if($debug) {
    if (!$resultCompositionQuery) echo("\n Error description resultCompositionQuery: " . mysqli_error($conn) . "\n<br/>");
  }/*end debug*/

  
  if ($resultCompositionQuery) {

    if($debug) {
      echo 'So Far So Good 3' . '<br/>';
    } /*end debug*/
    $numberOfCompositionRows = $resultCompositionQuery->num_rows;

    if($debug) {
      echo 'number of rows = ' . $numberOfCompositionRows . '<br/><br/>';
    }/*end debug*/

    $compositionsFound1 = ($numberOfCompositionRows > 0);
    $compositionsNotFound1 = ($numberOfCompositionRows === 0);

    if ($compositionsNotFound1) {

      echo <<<_END
      
          <div class="container-fluid bg-secondary pt-4 pb-3">   
          <h3 class='display-4 text-light'>Bummer!</h3>  
          <h2>There are currently no compositions with the name of "$compositionTitle". <br/><br/><br/></h2> 
          <h4 class="text-light">Which would you like to do? <br/></h4>
            <form action='compositionOnlySearch.php' method='post'>
              <input class="btn btn-light" type='submit' value='Try Another Composition Search'/><br/>
             
            </form><br/>
            <form action='bookTitleSearch.php' method='post'>
              <input class="btn btn-light mb-2" type='submit' value='Add new composition Information to the Library'/><br/>
              <h6>*You will start with the book information</h6>
                 
            </form>
            
      
_END;
      
      
        } /*End if compositionsNotFound1*/

    if($compositionsFound1) {

      echo <<<_END

      <div class="container-fluid bg-secondary pt-3 pb-3"> 
      <h5 class="text-light pb-2">Choose a composition option below to continue.</h5>
      
      </div> <!--end container-->
_END;

  

    

echo <<<_END

<div class="container-fluid bg-secondary pt-4 pb-2">

_END;

    /*Composition Loop: Now loop through each row returned by the query. Each row is one composition.*/
    for ($i = 0 ; $i < $numberOfCompositionRows ; ++$i) {
      /*  echo 'i at start of loop = ' . $i . '<br/><br/>';    */
      $row = $resultCompositionQuery->fetch_array(MYSQLI_NUM);
      /* var_dump ($row);*/
      $compositionID = ($row[0]);
      $compName = ($row[1]);            
      $opusLike = ($row[2]);
      $compNum = ($row[3]);
      $compNo = ($row[4]);
      $subTitle = ($row[5]);                          
      $movement = ($row[6]);
      $era = ($row[7]);            
      $voice = ($row[8]);
      $ensemble = ($row[9]);
      $bookIDCheck = ($row[10]); 
      $composerFirstName = ($row[11]);
      $composerMiddleName = ($row[12]);
      $composerLastName = ($row[13]);
      $composerSuffix = ($row[14]);
      $arrangerFirstName = ($row[15]);
      $arrangerMiddleName = ($row[16]);
      $arrangerLastName = ($row[17]);
      $arrangerSuffix = ($row[18]);
      $lyricistFirstName = ($row[19]);
      $lyricistMiddleName = ($row[20]);
      $lyricistLastName = ($row[21]);
      $lyricistSuffix = ($row[22]);

  




  /*Retrieving all key signatures for this composition
  I will also be creating a comma separated list to use in the displayed information*/
   
  $selectKeySigQuery = <<<_END
       
    SELECT  k.key_name
    FROM C2K 
    LEFT JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
    WHERE C2K.composition_ID = $compositionID;

_END;

  $resultSelectKeySigQuery = $conn->query($selectKeySigQuery);
  /*echo '$selectKeySigQuery = ' . $selectKeySigQuery . '<br/><br/>';*/

      if($debug) {
        if (!$resultSelectKeySigQuery) echo("\n Error description selectKeySigQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/

  if ($resultSelectKeySigQuery) {     

    $numKeySigRows = $resultSelectKeySigQuery->num_rows;
    /*Build comma separated list of key signatures in a string*/

    $keySignatureString = "";

    for ($j = 0 ; $j < $numKeySigRows ; ++$j) {
      $row = $resultSelectKeySigQuery->fetch_array(MYSQLI_NUM);
      /* var_dump ($row);*/
      $keySigName = ($row[0]);
                            
    } /*for loop ending*/

    /*$keySigString = implode(',',$sigVal);*/
    $keySignatureString .= $keySigName.","; 
    
  } /*End if result kesig query*/

  $displayKeySigString = rtrim($keySignatureString,',');



  /*Retrieving all key genres for this composition
  I will also be creating a comma separated list to use in the displayed information*/
  $selectGenresQuery = <<<_END

    SELECT  g.genre_type
    FROM C2G 
    LEFT JOIN genres AS g ON C2G.genre_ID = g.ID
    WHERE C2G.composition_ID = $compositionID;

_END;

  $resultSelectGenresQuery = $conn->query($selectGenresQuery);
  /* echo '$selectGenresQuery = ' . $selectGenresQuery . '<br/><br/>';*/

      if($debug) {
        if (!$resultSelectGenresQuery) echo("\n Error description selectGenresQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/

  if ($resultSelectGenresQuery) {     

    $numGenreRows = $resultSelectGenresQuery->num_rows;
    /*Build comma separated list of genres in a string*/
    $genreString= "";

    for ($j = 0 ; $j < $numGenreRows ; ++$j) {
      $row = $resultSelectGenresQuery->fetch_array(MYSQLI_NUM);
      /* var_dump ($row);*/

        
      $genreName = ($row[0]);

    } /*for loop ending*/

    $genreString .= $genreName.",";
    
  } /*End if resultSelectGenreQuery*/

  $displayGenreString = rtrim($genreString,',');






  /*Retrieving all instruments for this composition
  I will also be creating a comma separated list to use in the displayeinformation*/
  $selectInstrumentQuery = <<<_END
    SELECT  i.instr_name
    FROM C2I 
    LEFT JOIN instruments AS i ON C2I.instrument_ID = i.ID
    WHERE C2I.composition_ID = $compositionID;

_END;

  $resultSelectInstrumentQuery = $conn->query($selectInstrumentQuery);
  /* echo '$selectInstrumentQuery = ' . $selectInstrumentQuery . '<br/><br/>';*/

      if($debug) {
        if (!$resultSelectInstrumentQuery) echo("\n Error description selectInstrumentQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/

  if ($resultSelectInstrumentQuery) {     
    $numInstrumentRows = $resultSelectInstrumentQuery->num_rows;
    /*Build comma separated list of instruments in a string*/
    $instrumentString= "";

    for ($j = 0 ; $j < $numInstrumentRows ; ++$j) {
      $row = $resultSelectInstrumentQuery->fetch_array(MYSQLI_NUM);
      /*var_dump ($row);*/
      $instrumentName = ($row[0]);
      /*$instrumentString = implode(',',$instVal);*/
      $instrumentString .= $instrumentName.",";
              
    } /*for loop ending*/

  } /*End if resultSelectinstrument query*/

  $displayInstrumentString = rtrim($instrumentString,',');





  /*Retrieving the General difficluty for this composition*/

  $selectGenDiffQuery = <<<_END
    SELECT  d.difficulty_level
    FROM compositions AS c 
    LEFT JOIN C2D ON c.ID = C2D.composition_ID
    LEFT JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
    JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'General'
    WHERE C2D.composition_ID = $compositionID;
        
_END;

  $resultselectGenDiffQuery = $conn->query($selectGenDiffQuery);
  /* echo '$selectGenDiffQuery = ' . $selectGenDiffQuery . '<br/><br/>';*/

      if($debug) {
        if (!$resultselectGenDiffQuery) echo("\n Error description selectGenDiffQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/
  if ($resultselectGenDiffQuery) {     
    $numGDiffRows = $resultselectGenDiffQuery->num_rows;

    for ($j = 0 ; $j < $numGDiffRows ; ++$j)  {
      $row = $resultselectGenDiffQuery->fetch_array(MYSQLI_NUM);
      /* var_dump ($row);*/
      $GenDiffName = ($row[0]);
    } /*for loop ending*/
    
  } /*End if result select gendiff query*/

  /*Retrieving the ASP difficluty for this composition*/
  $selectASPDiffQuery = <<<_END

    SELECT  d.difficulty_level
    FROM compositions AS c 
    LEFT JOIN C2D ON c.ID = C2D.composition_ID
    LEFT JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
    JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'ASP'
    WHERE C2D.composition_ID = $compositionID;
        
_END;

  $resultselectASPDiffQuery = $conn->query($selectASPDiffQuery);
  /*echo '$selectASPDiffQuery = ' . $selectASPDiffQuery . '<br/><br/>';*/

      if($debug) {
        if (!$resultselectASPDiffQuery) echo("\n Error description selectASPDiffQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/

  if ($resultselectASPDiffQuery) {     
    $numASPDiffRows = $resultselectASPDiffQuery->num_rows;

    for ($j = 0 ; $j < $numASPDiffRows ; ++$j) {
      $row = $resultselectASPDiffQuery->fetch_array(MYSQLI_NUM);
      /* var_dump ($row);*/
 
      $ASPDiffName = ($row[0]);
            
    } /*for loop ending*/
    
  } /*End if result select ASPdiff query*/







  $bookQuery  = 
  "SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, o.org_name, o.location, p.firstname, p.middlename, p.lastname, p.suffix 
  FROM books AS b 
  LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID 
  LEFT JOIN roles AS r_p ON r_p.ID = B2R2P.role_ID AND r_p.role_name = 'Editor' 
  LEFT JOIN people AS p ON p.ID = B2R2P.people_ID 
  LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID 
  LEFT JOIN roles AS r_o ON r_o.ID = B2R2O.role_ID AND r_o.role_name = 'Publisher' 
  LEFT JOIN organizations AS o ON o.ID = B2R2O.org_ID 
  LEFT JOIN compositions AS c ON c.book_ID = b.ID
  WHERE c.ID = " . $compositionID ;

  

  /*Send Query*/
  $resultBookQuery = $conn->query($bookQuery);
      if($debug) {
        echo 'bookQuery = ' . $bookQuery . '<br/><br/>';
        if (!$resultBookQuery) echo("\n Error description bookQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/

  if ($resultBookQuery) {
    $numberOfBookRows = $resultBookQuery->num_rows;

    for ($j = 0 ; $j < $numberOfBookRows ; ++$j) {
      $row = $resultBookQuery->fetch_array(MYSQLI_NUM);
      /*Don't need to sanitize these they come from the db not the user*/
      $bookID = ($row[0]);
      $bookTitle = ($row[1]);
      $bookTag1 = ($row[2]);
      $bookTag2 = ($row[3]);
      $bookVolume = ($row[4]);
      $bookNumber = ($row[5]);
      $publisherName = ($row[6]);
      $publisherLocation = ($row[7]);
      $editorFirstName = ($row[8]);
      $editorMiddleName = ($row[9]);
      $editorLastName = ($row[10]);
      $editorSuffix = ($row[11]);
  
    }  /*end forloop*/


    

 } /* end if result book query */




/*This is  no longer a radio button that will hold all of the information about each composition belonging to a specfic book. Got rid of the radio button because it made the use have to click the radio button and a regular button to send all the info needed.  Because it is in our for loop, each composition found with the bookID we are working with, will have this block of information displayed on our page.*/
        echo <<<_END
         
    
        <div class="card  mb-3">
          <div class="card-body bg-light">
          
      
            <form class="mt-4" action='displayComposition.php' method='post'>
            <div class="form-check">
            <div class="row">
            <div class="col sm-6">
            <h3>Composition Info:</h3>
              Composition Title: $compName<br>
              Opus or sim: $opusLike<br>
              Opus Number or sim: $compNum<br>
              Composition No.: $compNo<br>
              Subtitle: $subTitle<br>
              Key Signature: $displayKeySigString<br>
              Movement: $movement<br>
              Era: $era <br>
              Genre: $displayGenreString <br>
              Voice: $voice <br>
              Ensemble: $ensemble <br>
              Instrument: $displayInstrumentString <br>
              Composer: $composerFirstName $composerMiddleName $composerLastName $composerSuffix <br>
              Arranger: $arrangerFirstName $arrangerMiddleName $arrangerLastName $arrangerSuffix <br>
              Lyricist: $lyricistFirstName $lyricistMiddleName $lyricistLastName $lyricistSuffix <br>
              ASP difficulty: $ASPDiffName <br>
              General difficulty: $GenDiffName <br>
             
            </div> <!-- end col -->
            <div class="col sm-6"> 
            <h3>Book Info:</h3>
              Book Title: $bookTitle<br>
              Book Tag 1: $bookTag1<br>
              Book Tag 2: $bookTag2<br>
              Book Volume: $bookVolume<br>
              Book Number: $bookNumber<br>
              Editor Name: $editorFirstName $editorMiddleName $editorLastName $editorSuffix<br>
              Publisher Name: $publisherName<br>
              Publisher Location: $publisherLocation<br><br>
                    
            </div> <!-- end col -->
            </div> <!--end row-->
              <input class="btn mt-4" type='submit' value='Choose This Composition and its Book'/>
              <input type='hidden' name="compositionID" value='$compositionID'/>
              <input type='hidden' name="bookID" value='$bookID'/>
                    
            </div><br/> <!-- form-check -->
            </form><br/> <!-- form -->
            </div> <!-- end card-body -->   
          </div>  <!-- end card -->
        

_END;
 
              


  } /*End Composition Loop :for loop ending that processes each composition*/

  echo <<<_END

  </div> <!--end container-->

_END;

  /*Our first button is still part of the form that has our radio button with all our existing composition information inside it. This radio button is part of our loop and each composition (and its accompanying information) that is associated with this book ID appears as a radio button. When user selects a radio button (thereby selecting a specific composition) and clicks on Choose Composition button, the composition ID is passed along as the value of the radio button. We also send the connected bookID in a hidden input.

  Our second button  is also in a form with a radio button choice. (Maybe this doesn't need to be a radio button??? ) The  bookID is sent as the value in the radio button. By clicking the "Add New Composition to this book", We are sent to a page (page 13) that allows us to add a composition to this specific book. Our bookID goes along with us a hidden input in our form.

  Our third button, "Add a new book", directs us back to page 2 where we can begin the process of adding an entirely new book.

  */
 
  

 




echo <<<_END
<div class="container-fluid bg-secondary pt-4 pb-2">

 
  <div class="form-row"> 
    <div class="col-auto ">
    <form action='compositionPrintPage.php' method='post'>
      <input class="btn btn-light" type='submit' value="Print all of these compositions and their books"/>
      <input type="hidden" name="bookID" value="$bookID">
      <input type="hidden" name="compositionTitle" value="$compositionTitle">
      <input type="hidden" name="compositionID" value="$compositionID">

    </form><br> 
    <h2 class="pb-3 text-light" >None of these compositions match<h2/><br>  
      <form action='addCompositionCurrentBook.php' method='post'>
          <button class="btn btn-light" type='submit'>Add a New Composition to this book</button>
          <input type="hidden" name="bookID" value="$bookID">   
      </form><br> 
      <form action='compositionOnlySearch.php' method='post'>
      <button class="btn btn-light" type='submit'>Try Another Composition Search</button>
         
  </form><br>
    </div> <!-- end col -->
    </div> <!-- end row -->
  </div> <!-- end container -->
 

_END;


  
} /*end if $compositionsFound1*/
} /*End if result composition query*/


} /*End if isset post searchCompositionTitle*/
 
include 'footer.html';
include 'endingBoilerplate.php';

?>
