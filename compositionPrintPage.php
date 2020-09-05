<?php
include 'boilerplate.php';

if($debug) {
    echo <<<_END

<p>compositionPrintPage-46</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';


  
/*Initializing Variables*/
$compositionTitle = "";
$compositionID = "";


/*Assigning local variable names to items in the Request array*/
if(isset($_REQUEST['compositionID']) && is_numeric($_REQUEST['compositionID'])) {
    $compositionID = $_REQUEST['compositionID'];
}

if(isset($_REQUEST['compositionTitle'])) {
    $compositionTitle = $_REQUEST['compositionTitle'];
}

/*Here we are washing each variable that will be used in db queries on this page*/
$washPostVar = cleanup_post($compositionID);
$compositionIDAltered = strip_before_insert($conn, $washPostVar);

$washPostVar = cleanup_post($compositionTitle);
$compositionTitleAltered = strip_before_insert($conn, $washPostVar);





/*find all compositions this composer is a composer for where the composition name = $compositionTitle and display the composition and the book it is in.
We will do this inside a card with the composition information to the left and the book information to the right. 
This will use a loop.*/


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

WHERE c.comp_name = '$compositionTitleAltered';

_END;

/*echo 'So Far So Good 2' . '<br/>';
echo 'compositionQuery = ' . $compositionQuery . '<br/><br/>';*/

/*send the query*/
$resultCompositionQuery = $conn->query($compositionQuery);




if($debug) {
    if (!$resultCompositionQuery) echo("\n Error description compositionQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

if ($resultCompositionQuery) {

if($debug) {
    echo 'So Far So Good 3' . '<br/>';
}/*end debug*/

  $numberOfCompositionRows = $resultCompositionQuery->num_rows;

if($debug) {
    echo 'number of rows = ' . $numberOfCompositionRows . '<br/><br/>';
}/*end debug*/

  $compositionsFound1 = ($numberOfCompositionRows > 0);
  $compositionsNotFound1 = ($numberOfCompositionRows === 0);

  if ($compositionsNotFound1) {

    echo <<<_END

    <div class="container-fluid bg-secondary pt-4 pb-2">   
      <h3 class='display-4 text-light'>Bummer!</h3>  
      <h3>There are currently no compositions with the name of "$compositionTitle". <br/><br/><br/></h3> <h4 class="text-light pb-3">Which would you like to do? <br/></h3>
      <form action='compositionOnlySearch.php' method='post'>
        <input class="btn btn-light" type='submit' value='Try Another Composition Search'/><br/>
      </form><br/>
      <form action='bookTitleSearch.php' method='post'>
        <input class="btn btn-light mb-2" type='submit' value='Add new composition Information to the Library'/><br/>
        <h6>*You will start with the book information</h6>
      </form>
      </div> <!--end container-->

_END;

  } /*End if compositionsNotFound1*/

  if($compositionsFound1) {

    echo <<<_END

    <div class="container-fluid  pt-4 pb-2"> 
     <div class="card">
      <div class="card-body">
      <h3 class="display-4 pb-4 mb-4"> Composition: $compositionTitle</h3>
    
_END;

/*Composition Loop: Now loop through each row returned by the query. Each row is one composition.*/

    for ($i = 0 ; $i < $numberOfCompositionRows ; ++$i) {
      /*  echo 'i at start of loop = ' . $i . '<br/><br/>';    */
      $row = $resultCompositionQuery->fetch_array(MYSQLI_NUM);
      /* var_dump ($row);*/
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
      $bookIDCheck = $row[10];
      $composerFirstName = $row[11];
      $composerMiddleName = $row[12];
      $composerLastName = $row[13];
      $composerSuffix = $row[14];
      $arrangerFirstName = $row[15];
      $arrangerMiddleName = $row[16];
      $arrangerLastName = $row[17];
      $arrangerSuffix = $row[18];
      $lyricistFirstName = $row[19];
      $lyricistMiddleName = $row[20];
      $lyricistLastName = $row[21];
      $lyricistSuffix = $row[22];


      /*Retrieving all key signatures for this composition
      I will also be creating a comma separated list to use in the displayed information*/

      $keySigQuery = <<<_END

        SELECT  k.key_name
        FROM C2K 
        LEFT JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
        WHERE C2K.composition_ID = '$compositionIDAltered';

_END;

      $resultKeySigQuery = $conn->query($keySigQuery);
      /*echo '$keySigQuery = ' . $keySigQuery . '<br/><br/>';*/

        if($debug) {
            if (!$resultKeySigQuery) echo("\n Error description keySigQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

      if ($resultKeySigQuery) {     

        $numKeySigRows = $resultKeySigQuery->num_rows;
        /*Build comma separated list of key signatures in a string*/

        $keySignatureString = "";

        for ($j = 0 ; $j < $numKeySigRows ; ++$j) {
          $row = $resultKeySigQuery->fetch_array(MYSQLI_NUM);
          /* var_dump ($row);*/
          $keySigName = $row[0];
                              
        } /*for loop ending*/

        /*$keySigString = implode(',',$sigVal);*/
        $keySignatureString .= $keySigName.","; 

      } /*End if result kesig query*/

      $displayKeySigString = rtrim($keySignatureString,',');



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
            echo '$genresQuery = ' . $genresQuery . '<br/><br/>';
            if (!$resultGenresQuery) echo ("\n Error description genresQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

      if ($resultGenresQuery) {     

        $numGenreRows = $resultGenresQuery->num_rows;
        /*Build comma separated list of genres in a string*/
        $genreString= "";

        for ($j = 0 ; $j < $numGenreRows ; ++$j) {
          $row = $resultGenresQuery->fetch_array(MYSQLI_NUM);
          /* var_dump ($row);*/

          $genreName = $row[0];

        } /*for loop ending*/

        $genreString .= $genreName.",";

      } /*End if resultGenresQuery*/

      $displayGenreString = rtrim($genreString,',');




      /*Retrieving all instruments for this composition
      I will also be creating a comma separated list to use in the displayeinformation*/
      $instrumentQuery = <<<_END

      SELECT  i.instr_name
      FROM C2I 
      LEFT JOIN instruments AS i ON C2I.instrument_ID = i.ID
      WHERE C2I.composition_ID = '$compositionIDAltered';

_END;

      $resultInstrumentQuery = $conn->query($instrumentQuery);
      if($debug) {
          echo '$instrumentQuery = ' . $instrumentQuery . '<br/><br/>';
        if (!$resultInstrumentQuery) echo ("\n Error description instrumentQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/

      if ($resultInstrumentQuery) {     
        $numInstrumentRows = $resultInstrumentQuery->num_rows;
        /*Build comma separated list of instruments in a string*/
        $instrumentString= "";

        for ($j = 0 ; $j < $numInstrumentRows ; ++$j) {
          $row = $resultInstrumentQuery->fetch_array(MYSQLI_NUM);
          /*var_dump ($row);*/
          $instrumentName = $row[0];
          /*$instrumentString = implode(',',$instVal);*/
          $instrumentString .= $instrumentName.",";
      
        } /*for loop ending*/

      } /*End if resultInstrument query*/

      $displayInstrumentString = rtrim($instrumentString,',');



      /*Retrieving the General difficluty for this composition*/

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
            echo '$genDiffQuery = ' . $genDiffQuery . '<br/><br/>';
            if (!$resultGenDiffQuery) echo("\n Error description genDiffQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

      if ($resultGenDiffQuery) {     
        $numGenDiffRows = $resultGenDiffQuery->num_rows;

        for ($j = 0 ; $j < $numGenDiffRows ; ++$j)  {
          $row = $resultGenDiffQuery->fetch_array(MYSQLI_NUM);
          /* var_dump ($row);*/
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
          echo '$ASPDiffQuery = ' . $ASPDiffQuery . '<br/><br/>';
          if (!$resultASPDiffQuery) echo("\n Error description ASPDiffQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/

      if ($resultASPDiffQuery) {     
        $numASPDiffRows = $resultASPDiffQuery->num_rows;

        for ($j = 0 ; $j < $numASPDiffRows ; ++$j) {
          $row = $resultASPDiffQuery->fetch_array(MYSQLI_NUM);
          /* var_dump ($row);*/

          $ASPDiffName = $row[0];
    
        } /*for loop ending*/

      } /*End if resultASPDiffQuery*/




      $bookQuery  = <<<_END

        SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, o.org_name, o.location, p.firstname, p.middlename, p.lastname, p.suffix 
        FROM books AS b 
        LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID 
        LEFT JOIN roles AS r_p ON r_p.ID = B2R2P.role_ID AND r_p.role_name = 'Editor' 
        LEFT JOIN people AS p ON p.ID = B2R2P.people_ID 
        LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID 
        LEFT JOIN roles AS r_o ON r_o.ID = B2R2O.role_ID AND r_o.role_name = 'Publisher' 
        LEFT JOIN organizations AS o ON o.ID = B2R2O.org_ID 
        LEFT JOIN compositions AS c ON c.book_ID = b.ID
        WHERE c.ID =  '$compositionIDAltered' ;

_END;

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

        }  /*end forloop*/  

      } /* end if result book query */




/*This is the radio button that will hold all of the information about each composition belonging to a specific book. Because it is in our for loop, each composition found with the bookID we are working with, will have this block of information displayed on our page.*/
echo <<<_END
 
        <div class="row mb-4">
          <div class="col-md-6  pb-4">
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
          <div class="col-md-6 mb-4 "> 
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

_END;

      


    } /*End Composition Loop :for loop ending that processes each composition*/

echo <<<_END
</div> <!-- end card-body -->
      </div> <!-- end card -->
</div> <!--end container-->

_END;


  } /*end if $compositionsFound1*/
} /*End if result composition query*/




include 'footer.html';
include 'endingBoilerplate.php';

?>
