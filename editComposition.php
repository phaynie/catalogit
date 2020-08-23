<?php
include 'boilerplate.php';

if($debug) {
  echo <<<_END

<p>editComposition-17</p>

_END;

}/*end debug*/
/*include 'beginningNav.html';*/
include 'beginningNav.php';

$bookID = "";
$compositionID = "";
$editComposition = "";
$bookTitle = "";

/*anything you want to be NULL in the database if user didn't enter anything is "NULL"*/

$bookTag1 = "";
$bookTag2 = "";
$bookVolume = "";
$bookNumber = "";
$publisherName = "";
$editorFirstName = "";
$editorMiddleName = "";
$editorLastName = "";
$editorSuffix = "";
$displayEditorPeopleString = "";
$publisherName = "";
$publisherLocation = "";
$displayPublisherOrgString = "";
$physBookLocNote = "";

$compName = "";
$opus = "";
$opusNum = "";
$compNum = "";
$subTitle = "";
$keySig = "";
$displayKeySigString = "";
$movement = "";
$era = "";
$displayGenreString = "";
$voice = "";
$ensemble = "";
$composerFirstName = "";
$composerMiddleName = "";
$composerLastName = "";
$composerSuffix = "";
$displayComposerString = "";
$arrangerFirstName = "";
$arrangerMiddleName = "";
$arrangerLastName = "";
$arrangerSuffix = "";
$displayArrangerString = "";
$lyricistFirstName = "";
$lyricistMiddleName = "";
$lyricistLastName = "";
$lyricistSuffix = "";
$displayLyricistString = "";
$instrument = "";
$displayInstrumentString = "";
$diffASP = "";
$diffGen = "";
$disableERDComposer = "";
$disableERDArranger = "";
$disableERDLyricist = "";
$physCompositionLocNote = "";




if(isset($_REQUEST['bookID'])) {
  $bookID = $_REQUEST['bookID'];
}

if(isset($_REQUEST['compName'])) {
  $compName = $_REQUEST['compName'];
}

if(isset($_REQUEST['compositionID'])) {
  $compositionID = $_REQUEST['compositionID'];
}

if(isset($_REQUEST['editComposition'])) {
  $editComposition = $_REQUEST['editComposition'];
}
/*we will not have gotten this $editComposition) from previous page. We send this out for the first time from this page*/
if($editComposition == 'true') {
  $sendEditComposition = "<input type='hidden' name='editComposition' value ='true' />";
}

$notEntered = "<span style='color:rgba(0,0,0,0.4);'>Not Entered</span>";




 /* search for book and composition info*/



  /*Retrieving all key signatures for this composition
I will also be creating a comma separated list to use in the displayed information*/
  /*We want to select the key_name here because we will only be displaying this value not making it checked or selected. */
  $keySigQuery = <<<_END
      SELECT  k.key_name
      FROM C2K
      JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
      WHERE C2K.composition_ID = '$compositionID';

_END;

  $resultKeySigQuery = $conn->query($keySigQuery);
  if($debug) {
    echo '$keySigQuery = ' . $keySigQuery . '<br/><br/>';
    if (!$resultKeySigQuery) echo("\n Error description $keySigQuery: " . mysqli_error($conn) . "\n<br/>");
  }/*end debug*/

  if ($resultKeySigQuery) {

    $numberOfRows = $resultKeySigQuery->num_rows;
    /*Build comma separated list of key signatures in a string*/

    $keySignatureString= "";

    for ($j = 0 ; $j < $numberOfRows ; ++$j)
    {
      $row = $resultKeySigQuery->fetch_array(MYSQLI_NUM);

      /* var_dump ($row);*/

      $keySig = htmlspecialchars($row[0]);

      $keySignatureString .= $keySig .", ";

    } /*for loop ending*/




  } /*End if result keysig query*/

  $displayKeySigString = rtrim($keySignatureString,', ');




  /*Retrieving all  genres for this composition
  I will also be creating a comma separated list to use in the displayed information*/
  $genresQuery = <<<_END

        SELECT  g.genre_type
        FROM C2G 
        JOIN genres AS g ON C2G.genre_ID = g.ID
        WHERE C2G.composition_ID = '$compositionID';


_END;

  $resultGenresQuery = $conn->query($genresQuery);
  if($debug) {
    echo '$genresQuery = ' . $genresQuery . '<br/><br/>';
    if (!$resultGenresQuery) echo("\n Error description genresQuery: " . mysqli_error($conn) . "\n<br/>");
  }/*end debug*/

  if ($resultGenresQuery) {

    $numberOfRows = $resultGenresQuery->num_rows;
    /*Build comma separated list of genres in a string*/

    $genreString= "";

    for ($j = 0 ; $j < $numberOfRows ; ++$j)
    {
      $row = $resultGenresQuery->fetch_array(MYSQLI_NUM);

      /* var_dump ($row);*/


      $genreName = htmlspecialchars($row[0]);

      $genreString .= $genreName .", ";

    } /*for loop ending*/

  } /*End if result kesig query*/

  $displayGenreString = rtrim($genreString,', ');





  /*Retrieving all instruments for this composition
  I will also be creating a comma separated list to use in the displayed information*/
  $instrumentQuery = <<<_END
      SELECT  i.instr_name
      FROM C2I 
      JOIN instruments AS i ON C2I.instrument_ID = i.ID
      WHERE C2I.composition_ID = '$compositionID';


_END;

  $resultInstrumentQuery = $conn->query($instrumentQuery);
  if($debug) {
    echo '$instrumentQuery = ' . $instrumentQuery . '<br/><br/>';
    if (!$resultInstrumentQuery) echo ("\n Error description instrumentQuery: " . mysqli_error($conn) . "\n<br/>");
  }/*end debug*/

  if ($resultInstrumentQuery) {

    $numberOfRows = $resultInstrumentQuery->num_rows;
    /*Build comma separated list of instruments in a string*/
    $instrumentString= "";

    for ($j = 0 ; $j < $numberOfRows ; ++$j)
    {
      $row = $resultInstrumentQuery->fetch_array(MYSQLI_NUM);

      /* var_dump ($row);*/


      $instrumentName = htmlspecialchars($row[0]);

      $instrumentString .= $instrumentName .", ";

    } /*for loop ending*/



  } /*End if result instrument query*/

  $displayInstrumentString = rtrim($instrumentString,', ');
/*$displayInstrumentString = substr($instrumentString, 0, strrpos($instrumentString, ",  " ));*/
/*second option does not produce the desired results in this situation. */






  /*Retrieving the General difficulty for this composition*/

  $genDiffQuery = <<<_END
      SELECT  d.difficulty_level
      FROM compositions AS c 
      JOIN C2D ON c.ID = C2D.composition_ID
      JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
      JOIN organizations as o ON d.org_ID = o.ID AND o.org_name = 'General'
      WHERE C2D.composition_ID = '$compositionID';


_END;

  $resultGenDiffQuery = $conn->query($genDiffQuery);
  if($debug) {
    echo '$genDiffQuery = ' . $genDiffQuery . '<br/><br/>';
    if (!$resultGenDiffQuery) echo("\n Error description genDiffQuery: " . mysqli_error($conn) . "\n<br/>");
  }/*end debug*/

  if ($resultGenDiffQuery) {

    $GenNumberOfRows = $resultGenDiffQuery->num_rows;


    for ($j = 0 ; $j < $GenNumberOfRows ; ++$j)
    {
      $row = $resultGenDiffQuery->fetch_array(MYSQLI_NUM);

      /*  var_dump ($row);*/

      $diffGen = htmlspecialchars($row[0]);

    } /*for loop ending*/

  } /*End if result select gendiff query*/





  /*Retrieving the ASP difficulty for this composition*/

  $ASPDiffQuery = <<<_END
      SELECT  d.difficulty_level
      FROM compositions AS c 
      JOIN C2D ON c.ID = C2D.composition_ID
      JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
      JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'ASP'
      WHERE C2D.composition_ID = '$compositionID';

_END;

  $resultASPDiffQuery = $conn->query($ASPDiffQuery);
  if($debug) {
    echo '$ASPDiffQuery = ' . $ASPDiffQuery . '<br/><br/>';
    if (!$resultASPDiffQuery) echo("\n Error description: ASPDiffQuery: " . mysqli_error($conn) . "\n<br/>");
  }/*end debug*/

  if ($resultASPDiffQuery) {

    $ASPNumberOfRows = $resultASPDiffQuery->num_rows;


    for ($j = 0 ; $j < $ASPNumberOfRows ; ++$j)
    {
      $row = $resultASPDiffQuery->fetch_array(MYSQLI_NUM);

      /* var_dump ($row);*/


      $diffASP = htmlspecialchars($row[0]);

    } /*for loop ending*/

  } /*End if result select ASPdiff query*/





  /*G- Retrieve book and Composition information to display in browser.
  1- Book Information
  2- Composition information minus the composer, Arranger, or Lyricist*/




  /*new book query allowing for multiple editors and publishers*/
if (strlen($bookID)  > 0) {

  $bookQuery = <<<_END

          SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, b.physBookLoc
          FROM books AS b

          WHERE b.ID = '$bookID' ;

_END;

  $bookQueryResult = $conn->query($bookQuery);

  if ($debug) {
    echo 'bookQuery =' . $bookQuery . '</br>';
  }

  if (!$bookQueryResult) echo("\n Error description query bookQuery: " . mysqli_error($conn) . "\n<br/>");
  if ($bookQueryResult) {
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

  } /*end if book query result*/


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
  if ($debug) {
    echo 'editorPeopleQuery = ' . $editorPeopleQuery . '<br/><br/>';

    if (!$resultEditorPeopleQuery) echo("\n Error description editorPeopleQuery: " . mysqli_error($conn) . "\n<br/>");
  }/*end debug*/

  if ($resultEditorPeopleQuery) {
    $numEditorPeopleRows = $resultEditorPeopleQuery->num_rows;
    /*Build comma separated list of editorPeople in a string*/
    $editorPeopleString = "";

    for ($j = 0; $j < $numEditorPeopleRows; ++$j) {
      $row = $resultEditorPeopleQuery->fetch_array(MYSQLI_NUM);
      /*var_dump ($row);*/
      $editorPeopleID = htmlspecialchars($row[0]);
      $editorPeopleFirstName = htmlspecialchars($row[1]);
      $editorPeopleMiddleName = htmlspecialchars($row[2]);
      $editorPeopleLastName = htmlspecialchars($row[3]);
      $editorPeopleSuffix = htmlspecialchars($row[4]);
      /*$editorPeopleString = implode(',',$instVal);*/
      $editorPeopleString .= $editorPeopleFirstName . " " . $editorPeopleMiddleName . " " . $editorPeopleLastName . " " . $editorPeopleSuffix . ", ";

    } /*for loop ending*/

  } /*End if $resultEditorPeopleQuery query*/

  /*$displayEditorPeopleString = rtrim($editorPeopleString, 'Editor Name: ');*/
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
  if ($debug) {
    echo 'publisherOrgQuery = ' . $publisherOrgQuery . '<br/><br/>';

    if (!$resultPublisherOrgQuery) echo("\n Error description publisherOrgQuery: " . mysqli_error($conn) . "\n<br/>");
  }/*end debug*/

  if ($resultPublisherOrgQuery) {
    $numPublisherOrgRows = $resultPublisherOrgQuery->num_rows;
    /*Build comma separated list of publisherOrg in a string*/
    $publisherOrgString = "";

    for ($j = 0; $j < $numPublisherOrgRows; ++$j) {
      $row = $resultPublisherOrgQuery->fetch_array(MYSQLI_NUM);
      /*var_dump ($row);*/
      $publisherOrgID = htmlspecialchars($row[0]);
      $publisherOrgName = htmlspecialchars($row[1]);
      $publisherOrgLocation = htmlspecialchars($row[2]);

      /*$editorPeopleString = implode(',',$instVal);*/
      $publisherOrgString .= $publisherOrgName . "</br> Publisher Location: " . $publisherOrgLocation . "</br>Publisher Name: ";

    } /*for loop ending*/

  } /*End if $resultPublisherOrgQuery*/

  /*$displayPublisherOrgString = rtrim($publisherOrgString, "</br>Publisher Name: ");*/
  $displayPublisherOrgString = substr($publisherOrgString, 0, strrpos($publisherOrgString, "</br>Publisher Name: " ));

  /*end new book query*/
} /*end if bookID > 0}*/



 /*end new book query allowing multiple editors and publishers*/




  $compositionQuery = <<<_END
        SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, c.movement, e.description, v.voicing_type, ens.ensemble_type, b.ID, c.physCompositionLoc 
        FROM compositions AS c
        LEFT JOIN eras AS e ON c.era_ID = e.ID
        LEFT JOIN voicing AS v ON c.voice_ID = v.ID
        LEFT JOIN ensembles AS ens ON c.ensemble_ID = ens.ID
        LEFT JOIN books AS b ON c.book_ID = b.ID

        WHERE c.ID = '$compositionID';
       
_END;

  $resultCompositionQuery = $conn->query($compositionQuery);
  if($debug) {
    echo 'compositionQuery = ' . $compositionQuery . '<br/><br/>';
    if (!$resultCompositionQuery) echo("\n Error description compositionQuery: " . mysqli_error($conn) . "\n<br/>");
  }/*end debug*/

  if ($resultCompositionQuery) {

    $numberOfRows = $resultCompositionQuery->num_rows;

    for ($j = 0 ; $j < $numberOfRows ; ++$j)
    {
      $row = $resultCompositionQuery->fetch_array(MYSQLI_NUM);

      /*  var_dump ($row);*/

      $queryCompositionID = htmlspecialchars($row[0]);
      $compName = htmlspecialchars($row[1]);
      $opus = htmlspecialchars($row[2]);
      $opusNum = htmlspecialchars($row[3]);
      $compNum = htmlspecialchars($row[4]);
      $subTitle = htmlspecialchars($row[5]);
      $movement = htmlspecialchars($row[6]);
      $era = htmlspecialchars($row[7]);
      $voice = htmlspecialchars($row[8]);
      $ensemble = htmlspecialchars($row[9]);
      $compbookID = htmlspecialchars($row[10]);
      $physCompositionLocNote = htmlspecialchars($row[11]);


    } /*for loop ending*/
  } /*END result Composition Query*/
  $deletedItem = '$compName';


  $composerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        JOIN C2R2P ON c.ID = C2R2P.composition_ID
        JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r ON  r.ID = C2R2P.role_ID AND r.role_name = 'Composer'
        
        WHERE c.ID = '$compositionID';

_END;

  if($debug) {
    echo 'composerQuery = ' . $composerQuery . '<br/><br/>';
  }/*end debug*/

  /*send the query*/
  $resultComposerQuery = $conn->query($composerQuery);


  if($debug) {
    if (!$resultComposerQuery) echo("\n Error description composerQuery: " . mysqli_error($conn) . "\n<br/>");
  }/*end debug*/

  if ($resultComposerQuery){

    $numberOfComposerRows = $resultComposerQuery->num_rows;
    $composerString = "";

    for ($j = 0 ; $j < $numberOfComposerRows ; ++$j){
      $row = $resultComposerQuery->fetch_array(MYSQLI_NUM);

      $composerID = htmlspecialchars($row[0]);
      $compFirst = htmlspecialchars($row[1]);
      $compMiddle = htmlspecialchars($row[2]);
      $compLast = htmlspecialchars($row[3]);
      $compSuffix = htmlspecialchars($row[4]);

      $composerString .= $compFirst . " " . $compMiddle . " " . $compLast . " " . $compSuffix . ", ";

    } /*for loop ending*/
  } /*END if result composer query*/

/*$displayComposerString = rtrim($composerString, "Composer Name: ");*/
$displayComposerString = substr($composerString, 0, strrpos($composerString, ", " ));


if($displayComposerString == ""){
  $disableERDComposer = 'disabled';
}

  /*create query to select the arranger from the database */

  $arrangerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        JOIN C2R2P ON c.ID = C2R2P.composition_ID
        JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r ON  r.ID = C2R2P.role_ID AND r.role_name = 'Arranger'
        
        WHERE c.ID = '$compositionID';

_END;

  if($debug) {
    echo 'arrangerQuery = ' . $arrangerQuery . '<br/>';
  }/*end debug*/

  /*send the query*/
  $resultArrangerQuery = $conn->query($arrangerQuery);


  if($debug) {
    if (!$resultArrangerQuery) echo("\n Error description arrangerQuery: " . mysqli_error($conn) . "\n<br/>");
  }/*end debug*/

  if ($resultArrangerQuery){

    $numberOfArrangerRows = $resultArrangerQuery->num_rows;
    $arrangerString = "";

    for ($j = 0 ; $j < $numberOfArrangerRows ; ++$j){
      $row = $resultArrangerQuery->fetch_array(MYSQLI_NUM);

      $arrangerID = htmlspecialchars($row[0]);
      $arrFirst = htmlspecialchars($row[1]);
      $arrMiddle = htmlspecialchars($row[2]);
      $arrLast = htmlspecialchars($row[3]);
      $arrSuffix = htmlspecialchars($row[4]);

      $arrangerString .= $arrFirst . " " . $arrMiddle . " " . $arrLast . " " . $arrSuffix . ", ";

    } /*for loop ending*/

  } /*END if result arranger Query*/

  /*$displayArrangerString = rtrim($arrangerString, "Arranger Name: ");*/
  $displayArrangerString = substr($arrangerString, 0, strrpos($arrangerString, ", " ));

if($displayArrangerString == ""){
  $disableERDArranger = 'disabled';
}


  /*create query to select the arranger from the database */

  $lyricistQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        JOIN C2R2P ON c.ID = C2R2P.composition_ID
        JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r ON r.ID = C2R2P.role_ID AND r.role_name = 'Lyricist'
       
        WHERE c.ID = '$compositionID';

_END;

  if($debug) {
    echo 'lyricistQuery = ' . $lyricistQuery . '<br/><br/>';
  }/*end debug*/

  /*send the query*/
  $resultLyricistQuery = $conn->query($lyricistQuery);

  if($debug) {
    if (!$resultLyricistQuery) echo("\n Error description lyricistQuery: " . mysqli_error($conn) . "\n<br/>");
  }/*end debug*/

  if ($resultLyricistQuery){


    $numberOfLyricistRows = $resultLyricistQuery->num_rows;
    $lyricistString = "";

    for ($j = 0 ; $j < $numberOfLyricistRows ; ++$j){
      $row = $resultLyricistQuery->fetch_array(MYSQLI_NUM);

      $lyricistID = htmlspecialchars($row[0]);
      $lyrFirst = htmlspecialchars($row[1]);
      $lyrMiddle = htmlspecialchars($row[2]);
      $lyrLast = htmlspecialchars($row[3]);
      $lyrSuffix = htmlspecialchars($row[4]);

      $lyricistString .= $lyrFirst . " " . $lyrMiddle . " " . $lyrLast . " " . $lyrSuffix . ", ";

    } /*for loop ending*/

  } /*END if result arranger Query*/

$displayLyricistString = substr($lyricistString, 0, strrpos($lyricistString, ", " ));


if($displayLyricistString == ""){
  $disableERDLyricist = 'disabled';
}

/*strrpos($lyricistString, "</br>Lyricist Name: " )

substr($lyricistString, 0, strrpos($lyricistString, "</br>Lyricist Name: " ));*/


/*I wanted to display 'Not Entered' when a user left a field empty*/



/*book 'not entered' display logic*/

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







/*composition 'not entered' display logic*/


if($opus == "") {
  $opus = "$notEntered";
}

if($opusNum == "") {
  $opusNum = "$notEntered";
}


if($compNum == "") {
  $compNum = "$notEntered";
}

if($subTitle == "") {
  $subTitle = "$notEntered";
}

if($displayKeySigString == "none") {
  $displayKeySigString = "$notEntered";
}

if($displayGenreString == "none") {
  $displayGenreString = "$notEntered";
}


if($movement == "") {
  $movement = "$notEntered";
}

if($era == "none") {
  $era = "$notEntered";
}

if($voice == "none") {
  $voice = "$notEntered";
}

if($ensemble == "none") {
  $ensemble = "$notEntered";
}

if($displayInstrumentString == "none") {
  $displayInstrumentString = "$notEntered";
}

if($physCompositionLocNote == "") {
  $physCompositionLocNote = "$notEntered";
}

if($displayComposerString == "") {
  $displayComposerString = "$notEntered";
}

if($displayArrangerString == "") {
  $displayArrangerString = "$notEntered";
}

if($displayLyricistString == "") {
  $displayLyricistString = "$notEntered";
}

if($diffASP == 'none') {
  $diffASP = "$notEntered";
}

if($diffGen == 'none') {
  $diffGen = "$notEntered";
}










/* display book and composition info*/

echo <<<_END

 <div class="container-fluid bg-secondary pt-3 pb-3 mt-3">
    <h4 class="display-4 text-light text-center  ">$compName (edit)</h4>
    <h3 class = "text-center">What would you like to do with this Composition info?</h3>
    <h4 class = "text-center">Have you finished adding the Composer, Arranger and Lyricist?</h4>
    <div class="row pt-4"</div> 
    <div class=" col-md-4 offset-md-2 ">
        <div class="card  mt-4 mb-3">
              <div class="card-body bg-light">
               
                <h4>Composition Info</h4>
                Composition Name:<strong>  $compName </strong> <br/>
                Opus-Like: $opus <br/>
                Opus No.: $opusNum <br/>
                Composition No.: $compNum <br/>
                Subtitle:   $subTitle <br/>
                Movement:  $movement <br/>
                Key Signature:   $displayKeySigString <br/>
                Era: $era <br/>
                Genre:   $displayGenreString<br/>
                Voice:  $voice <br/>
                Ensemble:   $ensemble <br/>
                Instrument:   $displayInstrumentString <br/>
                General difficulty:  $diffGen  <br/>
                ASP difficulty:  $diffASP  <br/>
                Composer Name:  $displayComposerString <br/>
                Arranger Name:  $displayArrangerString<br/>
                Lyricist Name:  $displayLyricistString<br/>
                Composition Location: <span style="color:#EB6B42;">  $physCompositionLocNote</span><br/><br/>
                
                
                 <h4>Book Info</h4>
                Book Title:<strong> $bookTitle </strong><br/>
                Tag 1: $bookTag1 <br/>
                Tag 2: $bookTag2 <br/>
                Book Volume: $bookVolume <br/>
                Book Number: $bookNumber <br/>
                Editor Name: $displayEditorPeopleString <br/>
                Publisher Name: $displayPublisherOrgString<br/>
                Book Location: <span style="color:#EB6B42;">  $physBookLocNote</span><br/><br/>
            
    
              </div>  <!-- end card-body -->
        </div>  <!-- end card -->
    </div>  <!-- end col -->
        
        
    <div class="col-md-4">
        <div class="card  border-secondary mt-4 mb-3">
            <div class="card-body bg-secondary">
                <form action='addComposition2.php' method='post'>
                    <div class="form-check">
                        <input class="btn btn-light" type="submit" value="Edit Existing General Composition Info for '$compName'  " />
                        <input type="hidden" name="bookID" value="$bookID" />
                        <input type="hidden" name="compName" value="$compName" />
                        <input type="hidden" name="bookTitle" value="$bookTitle"/>
                        <input type="hidden" name="compositionID" value= "$compositionID" />
                        <input type="hidden" name="editComposition" value ="true" />
                    </div><!-- end form-check -->
                </form>
                
                 <form action='delete.php' method='post'>
                    <div class="form-check">
                        <input class="btn btn-light confirm deletecomposition_button" type="submit" value="Delete '$compName' from '$bookTitle'  "/>
                        <input type="hidden" name="editComposition" value ="true" />
                        <input type="hidden" name="bookID" value= "$bookID" />
                        <input type="hidden" name="compositionID" value="$compositionID" />
                        <input type="hidden" name="compName" value="$compName"/>
                        <input type="hidden" name="bookTitle" value="$bookTitle"/>
                        <input type="hidden" name="deleteComposition" value= "true" />
                    </div><!-- end form-check -->
                 </form>
        
          
                 <form action='peopleOptions.php' method='post'>
                    <div class="form-check">
                      <input class="btn btn-light" type='submit' $disableERDComposer value="Edit, Replace, or Delete Composer for '$compName'"/>
                      <input type="hidden" name="bookID" value='$bookID'/>
                      <input type="hidden" name="compositionID" value='$compositionID'/>
                      <input type="hidden" name="compName" value='$compName'/>
                      <input type="hidden" name="bookTitle" value='$bookTitle'/>
                      <input type="hidden" name="oldPeopleID" value= '$peopleID' />
                      <input type="hidden" name="editReplaceDeleteComposer" value= 'true' />
                      <input type="hidden" name='editComposition' value ='true' />
                    </div><!-- end form-check -->
                 </form>
                 
                 <form action='peopleSearch.php' method='post'>
                    <div class="form-check">
                        <input class="btn btn-light" type='submit' value="Add New Composer to '$compName'"/>
                        <input type="hidden" name="bookID" value='$bookID'/>
                        <input type="hidden" name="compositionID" value='$compositionID'/>
                        <input type="hidden" name="oldPeopleID" value= '$peopleID' />
                        <input type="hidden" name="compName" value='$compName'/>
                        <input type="hidden" name="bookTitle" value='$bookTitle'/>
                        <input type="hidden" name="addNewComposer" value= 'true' />
                        <input type="hidden" name='editComposition' value ='true' />
                    </div><!-- end form-check -->
                 </form>
                 
                 <form action='peopleOptions.php' method='post'>
                    <div class="form-check">
                        <input class="btn btn-light" type='submit' $disableERDArranger value="Edit, Replace, or Delete Arranger for '$compName'"/>
                        <input type="hidden" name="bookID" value='$bookID'/>
                        <input type="hidden" name="compositionID" value='$compositionID'/>
                        <input type="hidden" name="compName" value='$compName'/>
                        <input type="hidden" name="bookTitle" value='$bookTitle'/>
                        <input type="hidden" name="editReplaceDeleteArranger" value= 'true' />
                        <input type="hidden" name='editComposition' value ='true' />
                    </div><!-- end form-check -->
                 </form>
                 
                 <form action='peopleSearch.php' method='post'>
                    <div class="form-check">
                        <input class="btn btn-light" type='submit' value="Add New Arranger to '$compName'"/>
                        <input type="hidden" name="bookID" value='$bookID'/>
                        <input type="hidden" name="compositionID" value='$compositionID'/>
                        <input type="hidden" name="oldPeopleID" value= '$peopleID' />
                        <input type="hidden" name="compName" value='$compName'/>
                        <input type="hidden" name="bookTitle" value='$bookTitle'/>
                        <input type="hidden" name="addNewArranger" value= 'true' />
                        <input type="hidden" name='editComposition' value ='true' />
                    </div><!-- end form-check -->
                 </form>
                 
                 <form action='peopleOptions.php' method='post'>
                    <div class="form-check">
                        <input class="btn btn-light" type='submit' $disableERDLyricist value="Edit, Replace, or Delete Lyricist from '$compName'"/>
                        <input type="hidden" name="bookID" value='$bookID'/>
                        <input type="hidden" name="compositionID" value='$compositionID'/>
                        <input type="hidden" name="compName" value='$compName'/>
                        <input type="hidden" name="bookTitle" value='$bookTitle'/>
                        <input type="hidden" name="editReplaceDeleteLyricist" value= 'true' />
                        <input type="hidden" name='editComposition' value ='true' />
                    </div><!-- end form-check -->
                 </form>
                 
                  <form action='peopleSearch.php' method='post'>
                      <div class="form-check">
                          <input class="btn btn-light" type='submit' value="Add New Lyricist to '$compName'"/>
                          <input type="hidden" name="bookID" value='$bookID'/>
                          <input type="hidden" name="compositionID" value='$compositionID'/>
                          <input type="hidden" name="oldPeopleID" value= '$peopleID' />
                          <input type="hidden" name="compName" value='$compName'/>
                          <input type="hidden" name="bookTitle" value='$bookTitle'/>
                          <input type="hidden" name="addNewLyricist" value= 'true' />
                          <input type="hidden" name='editComposition' value ='true' />
                      </div><!-- end form-check -->
                  </form>
                  
                  <form action='displayComposition.php' method='post'>
                      <div class="form-check">
                          <input class="btn btn-light" type='submit' value="Done Editing '$compName'"/>
                          <input type="hidden" name="bookID" value='$bookID'/>
                          <input type="hidden" name="compositionID" value='$compositionID'/>
                          <input type="hidden" name='editComposition' value ='true' />
                      </div><!-- end form-check -->
                  </form>

               </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>  <!-- end col -->
     </div>  <!-- end row -->
 </div> <!-- end container -->

_END;



  include 'footer.html';
  include 'endingBoilerplate.php';

  ?>






