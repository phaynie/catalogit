<?php
include 'boilerplate.php';

if($debug) {
    echo <<<_END

    <p>composerPrintPage-44</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';


/*Initializing variables*/
$composerID = "";
$compositionID = "";



if(isset($_REQUEST['composerID']) && is_numeric($_REQUEST['composerID'])) {
    $composerID = $_REQUEST['composerID'];
}

if(isset($_REQUEST['compositionID']) && is_numeric($_REQUEST['compositionID'])) {
    $compositionID = $_REQUEST['compositionID'];
}


/*here we will wash the variables we will be using in the db queries below*/
$washPostVar = cleanup_post($composerID);
$composerIDAltered = strip_before_insert($conn, $washPostVar);

$washPostVar = cleanup_post($compositionID);
$compositionIDAltered = strip_before_insert($conn, $washPostVar);



/*display composer we just chose*/
/*use query to get most recent composer information using the composer Poeple id*/

$composerQuery = <<<_END

SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
  FROM compositions As c
  LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
  LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
  JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID AND r_composer.role_name = 'Composer'
  WHERE p.ID = '$composerIDAltered';

_END;

/*echo 'composerQuery = ' . $composerQuery . '<br/><br/>';*/
/*send the query*/
$resultComposerQuery = $conn->query($composerQuery);

if($debug) {
    if (!$resultComposerQuery) echo("\n Error description composerQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

if ($resultComposerQuery){
       
    $numberOfComposerRows = $resultComposerQuery->num_rows;

    if($debug) {
        echo 'numberOfComposerRows = ' . $numberOfComposerRows . '<br/><br/>';
    }/*end debug*/

  for ($j = 0 ; $j < $numberOfComposerRows ; ++$j){
    $row = $resultComposerQuery->fetch_array(MYSQLI_NUM);

    $composerID = $row[0];
    $compFirst = $row[1];
    $compMiddle = $row[2];
    $compLast = $row[3];
    $compSuffix = $row[4];
            
  } /*for loop ending*/
 /* echo 'composerID =' . $composerID . "<br/>";*/
} /*END if result composer query*/




/*find all compositions this composer is a composer for and display the composition and the book it is in. 
We will do this inside a card with the composition information to the left and the book information to the right. 
This will use a loop.*/

$compositionQuery = <<<_END

SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, 
c.movement, e.description,v.voicing_type, ens.ensemble_type, c.book_ID 
    FROM compositions AS c
    LEFT JOIN eras AS e ON c.era_ID = e.ID
    LEFT JOIN voicing AS v ON c.voice_ID = v.ID
    LEFT JOIN ensembles AS ens ON c.ensemble_ID = ens.ID
		JOIN C2R2P ON c.ID = C2R2P.composition_ID
    JOIN people AS p ON C2R2P.people_ID = p.ID
    JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID AND r_composer.role_name = 'Composer'
        
    WHERE p.ID = '$composerIDAltered';

_END;

$resultCompositionQuery = $conn->query($compositionQuery);

if($debug) {
    echo 'compositionQuery =' . $compositionQuery . '<br/><br/>';

    if (!$resultCompositionQuery) echo ("\n Error description compositionQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

if ($resultCompositionQuery) {     

  $numberOfCompositionRows = $resultCompositionQuery->num_rows;
  $compositionsFound = ($numberOfCompositionRows  > 0);
  $compositionsNotFound = ($numberOfCompositionRows === 0);

  /*echo "number of composition rows = " . $numberOfCompositionRows .  "";*/

  if($compositionsNotFound) {
    echo <<<_END
    <div class="container-fluid bg-secondary pt-4 pb-3">
      <h2 class="display-4 text-light" >Bummer!</h2>
      <h2 class="text-dark">No compositions from  "$compFirst $compMiddle $compLast $compSuffix" was found. <br/><br/></h2>
      <h4 class="text-light"> Which would you like to do? <br/><br/></h4>
      <form action="composerSearch.php" method="post">
        <input class="btn btn-light"  type='submit' value='Try another Composer Search'/> 
        <input type='hidden' name='bookID' value='$bookID'/>
        <input type='hidden' name='compositionID' value='$compositionID'/>
      </form><br/>  <!-- end form -->

      <form action='addComposer.php' method='post'> 
        <input class="btn btn-light" type='submit' value='Add New compostition information'/>
        <input type='hidden' name='bookID' value='$bookID'/>
        <input type='hidden' name='compositionID' value='$compositionID'/>       
      </form><br/><br/>
      <h2> *You must have a composer to continue.</h2>
    </div> <!-- end container -->


_END;

  }/*end if compositionsnotFound*/

  if($compositionsFound) {
    echo <<<_END

    <div class="container-fluid pt-4 pb-3">
      
      <h3>Composer:</h3>
      <h3 class="display-4">  $compFirst $compMiddle $compLast $compSuffix </h3><br/>
    </div> <!--end container-->
        
_END;

    for ($k = 0 ; $k < $numberOfCompositionRows ; ++$k) {
      $row = $resultCompositionQuery->fetch_array(MYSQLI_NUM);
      /*  var_dump ($row);*/
      $compositionID = $row[0];
      $compName = $row[1];
      $opusLike = $row[2];
      $compNum = $row[3];
      $compNo = $row[4];
      $subTitle = $row[5];
      $movement = $row[6];
      $era = $row[7];
      $voice = $row[8];
      $ensemble = $row[9];
      $CompbookID = $row[10];
            
         /*echo '$k = ' . $k  . '<br/><br/>';*/ 
      
      /*Retrieving all key signatures for this composition
      I will also be creating a comma separated list to use in the displayed information*/
      $keySigQuery = <<<_END
        SELECT  k.key_name
        FROM C2K
        LEFT JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
        WHERE C2K.composition_ID = '$compositionIDAltered';

_END;

      $resultKeySigQuery = $conn->query($keySigQuery);

      if($debug) {
      echo '$keySigQuery = ' . $keySigQuery . '<br/><br/>';
      
      if (!$resultKeySigQuery) echo ("\n Error description keySigQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/

      if ($resultKeySigQuery) {     

        $numberOfKeySigRows = $resultKeySigQuery->num_rows;
        /*Build comma separated list of key signatures in a string*/

        $keySignatureString= "";

        for ($j = 0 ; $j < $numberOfKeySigRows ; ++$j) {
          $row = $resultKeySigQuery->fetch_array(MYSQLI_NUM);
          /* var_dump ($row);*/
          $keySigName = $row[0];
          $keySignatureString .= $keySigName .", ";
            
        } /*for loop ending*/

      } /*End if result kesig query*/

      $displayKeySigString = rtrim($keySignatureString,', ');




      /*Retrieving all key genres for this composition
      I will also be creating a comma separated list to use in the displayed information*/
      $genresQuery = <<<_END

        SELECT  g.genre_type
        FROM C2G 
        LEFT JOIN genres AS g ON C2G.genre_ID = g.ID
        WHERE C2G.composition_ID = '$compositionIDAltered';

_END;

      $resultGenresQuery = $conn->query($genresQuery);

      if($debug) {
      echo '$selectGenresQuery = ' . $genresQuery . '<br/><br/>';
      
      if (!$resultGenresQuery) echo ("\n Error description genresQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/

      if ($resultGenresQuery) {     
        $numberOfGenreRows = $resultGenresQuery->num_rows;
        /*Build comma separated list of genres in a string*/
        $genreString= "";

        for ($j = 0 ; $j < $numberOfGenreRows ; ++$j) {
          $row = $resultGenresQuery->fetch_array(MYSQLI_NUM);
          /* var_dump ($row);*/
          $genreName = $row[0];
          $genreString .= $genreName .", ";
            
        } /*for loop ending*/
    
      } /*End if result genres query*/

      $displayGenreString = rtrim($genreString,', ');


      /*Retrieving all instruments for this composition
      I will also be creating a comma separated list to use in the displayed information*/
      $instrumentQuery = <<<_END
        SELECT  i.instr_name
        FROM C2I 
        LEFT JOIN instruments AS i ON C2I.instrument_ID = i.ID
        WHERE C2I.composition_ID = '$compositionIDAltered';

_END;

      $resultInstrumentQuery = $conn->query($instrumentQuery);
        if($debug) {
            echo '$selectInstrumentQuery = ' . $instrumentQuery . '<br/><br/>';

            if (!$resultInstrumentQuery) echo ("\n Error description instrumentQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

      if ($resultInstrumentQuery) {     
        $numberOfInstRows = $resultInstrumentQuery->num_rows;
        /*Build comma separated list of instruments in a string*/
        $instrumentString= "";

        for ($j = 0 ; $j < $numberOfInstRows ; ++$j) {
          $row = $resultInstrumentQuery->fetch_array(MYSQLI_NUM);
          /* var_dump ($row);*/
          $instrumentName = $row[0];
          $instrumentString .= $instrumentName .", ";
            
        } /*for loop ending*/
    
      } /*End if result instrument query*/

      $displayInstrumentString = rtrim($instrumentString,', ');





      /*Retrieving the General difficulty for this composition*/

      $genDiffQuery = <<<_END
        SELECT  d.difficulty_level
        FROM compositions AS c 
        LEFT JOIN C2D ON c.ID = C2D.composition_ID
        LEFT JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
        JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'General'
        WHERE C2D.composition_ID = '$compositionIDAltered';


_END;

      $resultGenDiffQuery = $conn->query($genDiffQuery);

        if($debug) {
            echo '$selectGenDiffQuery = ' . $genDiffQuery . '<br/><br/>';

            if (!$resultGenDiffQuery) echo("\n Error description genDiffQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

      if ($resultGenDiffQuery) {     
        $numberOfGenRows = $resultGenDiffQuery->num_rows;

        for ($j = 0 ; $j < $numberOfGenRows ; ++$j) {
          $row = $resultGenDiffQuery->fetch_array(MYSQLI_NUM);
          /*  var_dump ($row);*/
          $GenDiffName = $row[0];
          
        } /*for loop ending*/
    
      } /*End if result gendiff query*/


      /*Retrieving the ASP difficluty for this composition*/

      $ASPDiffQuery = <<<_END
        SELECT  d.difficulty_level
        FROM compositions AS c 
        LEFT JOIN C2D ON c.ID = C2D.composition_ID
        LEFT JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
        JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'ASP'
        WHERE C2D.composition_ID = '$compositionIDAltered';

_END;

      $resultASPDiffQuery = $conn->query($ASPDiffQuery);

        if($debug) {
            echo '$selectASPDiffQuery = ' . $ASPDiffQuery . '<br/><br/>';

            if (!$resultASPDiffQuery) echo("\n Error description ASPDiffQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

      if ($resultASPDiffQuery) {     
        $numberOfASPRows = $resultASPDiffQuery->num_rows;

        for ($j = 0 ; $j < $numberOfASPRows ; ++$j) {
          $row = $resultASPDiffQuery->fetch_array(MYSQLI_NUM);
           /* var_dump ($row);*/
          $ASPDiffName = $row[0];
            
        } /*for loop ending*/

      } /*End if resultASPdiff query*/





      /*G- Retrieve book and Composition information to display in browser.
      1- Book Information
      2- Composition information minus the composer, Arranger, or Lyricist*/


      $bookQuery = <<<_END

        SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, p.firstname, p.middlename, p.lastname, p.suffix, org_pub.org_name, org_pub.location
          FROM books AS b
          LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
          LEFT JOIN roles AS r_ed ON B2R2P.role_ID = r_ed.ID AND r_ed.role_name = 'Editor'
          LEFT JOIN people AS p ON B2R2P.people_ID = p.ID
           
          LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
          LEFT JOIN roles AS r_pub ON B2R2O.role_ID = r_pub.ID AND r_pub.role_name = 'Publisher'
          LEFT JOIN organizations AS org_pub ON B2R2O.org_ID = org_pub.ID
           
          JOIN compositions AS c ON c.book_ID = b.ID

          WHERE c.ID = '$compositionIDAltered';  

_END;

        $resultBookQuery = $conn->query($bookQuery);

        if($debug) {
            echo 'bookQuery = ' . $bookQuery . '<br/><br/>';

            if (!$resultBookQuery) echo("\n Error description bookQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        if ($resultBookQuery) {     
          $numberOfBookRows = $resultBookQuery->num_rows;

          for ($j = 0 ; $j < $numberOfBookRows ; ++$j) {
            $row = $resultBookQuery->fetch_array(MYSQLI_NUM);

            /* var_dump ($row);*/
            /*We do not need to sanitize these*/
            $bookID = $row[0];
            $bookTitle = $row[1];
            $bookTag1 = $row[2];
            $bookTag2 = $row[3];
            $bookVolume = $row[4];
            $bookNumber = $row[5];
            $editorFirstName = $row[6];
            $editorMiddleName= $row[7];
            $editorLastName = $row[8];
            $editorSuffix = $row[9];
            $publisherName = $row[10];
            $publisherLocation = $row[11];

          } /*End Book Query for loop*/
        } /*End if resultBookQuery*/

       
       


      


        
       
        /*create query to select the arranger from the database */
        
        $arrangerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
          FROM compositions As c
          LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
          LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
          JOIN roles AS r_arr ON C2R2P.role_ID = r_arr.ID AND r_arr.role_name = 'Arranger'
          WHERE c.ID = '$compositionIDAltered';

_END;

        /*echo 'arrangerQuery = ' . $arrangerQuery . '<br/><br/>';*/
        /*send the query*/
        $resultArrangerQuery = $conn->query($arrangerQuery);


        if($debug) {
            if (!$resultArrangerQuery) echo("\n Error description arrangerQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        if ($resultArrangerQuery){
          $numberOfArrRows = $resultArrangerQuery->num_rows;

          for ($j = 0 ; $j < $numberOfArrRows ; ++$j){
            $row = $resultArrangerQuery->fetch_array(MYSQLI_NUM);

            $arrangerID = $row[0];
            $arrFirst = $row[1];
            $arrMiddle = $row[2];
            $arrLast = $row[3];
            $arrSuffix = $row[4];

          } /*for loop ending*/

        } /*END if result arranger Query*/



        /*create query to select the arranger from the database */
        
        $lyricistQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
          FROM compositions As c
          LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
          LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
          JOIN roles AS r_lyr ON C2R2P.role_ID = r_lyr.ID AND r_lyr.role_name = 'Lyricist'
          WHERE c.ID = '$compositionIDAltered';

_END;

        /*echo 'lyricistQuery = ' . $lyricistQuery . '<br/><br/>';*/
        /*send the query*/
        $resultLyricistQuery = $conn->query($lyricistQuery);


        if($debug) {
            if (!$resultLyricistQuery) echo("\n Error description lyricistQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        if ($resultLyricistQuery){
      
          
          $numberOfLyrRows = $resultLyricistQuery->num_rows;

          for ($j = 0 ; $j < $numberOfLyrRows ; ++$j){
            $row = $resultLyricistQuery->fetch_array(MYSQLI_NUM);

            $lyricistID = $row[0];
            $lyrFirst = $row[1];
            $lyrMiddle = $row[2];
            $lyrLast = $row[3];
            $lyrSuffix = $row[4];

          } /*for loop ending*/

        } /*END if result lyricist Query*/

     

        /* H- Display Book information and Composition info Using HTML*/  
        echo <<<_END

        <div class="container-fluid  pt-4 pb-5">
          
              <div class="row">
                <div class="col-md-6 pb-4">
                  <h3 class="pt-4">Composition Info</h3>
                  Composition Name: $compName <br/>
                  Opus-Like: $opusLike <br/>
                  Opus No.: $compNum <br/>
                  Composition No.: $compNo <br/>
                  Subtitle: $subTitle <br/>
                  Key Signature: $displayKeySigString <br/>
                  Movement: $movement <br/>
                  Era: $era <br/>
                  Genre: $displayGenreString<br/>
                  Voice: $voice <br/>  
                  Ensemble: $ensemble <br/>
                  Instrument: $displayInstrumentString <br/>
                  General difficulty: $GenDiffName <br/>
                  ASP difficulty: $ASPDiffName<br/>
                  Composer Name: $compFirst $compMiddle $compLast $compSuffix <br/>
                  Arranger Name: $arrFirst $arrMiddle $arrLast $arrSuffix <br/>
                  Lyricist Name: $lyrFirst $lyrMiddle $lyrLast $lyrSuffix
                </div> <!-- end col -->
  
      
                <div class="col-md-6 pb-4">
                  <h3 class="pt-4">Book Info</h3>
                  Book Title: $bookTitle <br/>
                  Tag 1: $bookTag1 <br/>
                  Tag 2: $bookTag2 <br/>
                  Book Volume: $bookVolume <br/>
                  Book Number: $bookNumber <br/>
                  Book Editor name: $editorFirstName $editorMiddleName $editorLastName   $editorSuffix<br/>
                  Book Publisher: $publisherName<br/>
                  Publisher Location: $publisherLocation<br/>
                </div> <!-- end col -->
              </div>  <!-- end row -->
            
        </div>  <!-- end container -->

_END;

  } /*Composition for loop ending*/
  





/*Button options for our new composition*/



}/*end ifcompositionsFound*/
} /*END result Composition Query*/

include 'footer.php';
include 'endingBoilerplate.php';

?>
