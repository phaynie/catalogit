<?php
include 'boilerplate.php';

if($debug) {
    echo <<<_END

<p>displayComposition-14</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';


$compositionID = "";
$bookID = "";
$instType = "";
$composerPeopleID = "";
$lyricistPeopleID = "";
$lyricistRoleID = "";


$bookTitle = "";
$bookTag1 = "";
$bookTag2 = "";
$bookVolume = "";
$bookNumber = "";
$displayEditorPeopleString = "";
$displayPublisherOrgString = "";


$notEntered = "";

$instType = "";
$compName = "";
$opus = "";
$opusNum = "";
$compNum = "";
$subTitle = "";
$displayKeySigString = "";
$movement = "";
$era = "";
$displayGenreString = "";
$voice = "";
$ensemble = "";
$displayInstrumentString = "";
$genDiff = "";
$diffASP = "";
$displayComposerString = "";
$displayArrangerString = "";
$displayLyricistString = "";
$physCompositionLocNote = "";
$advSearch = "";



if(isset($_REQUEST['bookID']) && is_numeric($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if(isset($_REQUEST['instType'])) {
    $instType = $_REQUEST['instType'];
}


if(isset($_REQUEST['compositionID']) && is_numeric($_REQUEST['compositionID'])) {
    $compositionID = $_REQUEST['compositionID'];
}

if(isset($_REQUEST['advSearch'])) {
    $advSearch = $_REQUEST['advSearch'];
}

if(isset($_REQUEST['$composerPeopleID']) && is_numeric($_REQUEST['composerPeopleID'])) {
    $composerPeopleID = $_REQUEST['$composerPeopleID'];
}

if(isset($_REQUEST['$lyricistPeopleID']) && is_numeric($_REQUEST['lyricistPeopleID'])) {
    $lyricistPeopleID = $_REQUEST['$lyricistPeopleID'];
}

/*logic for specific situations*/
$notEntered = "<span style='color:rgba(0,0,0,0.4);'>Not Entered</span>";

if($advSearch =='true') {
    $sendAdvSearch = "<input type='hidden' name='advSearch' value='true'>" ;

}elseif($advSearch !=='true') {
    $disableButton = 'disabled';
}



/*here we will wash any variables that will be used in a db query on this page*/
$washPostVar = cleanup_post($compositionID);
$compositionIDAltered = strip_before_insert($conn, $washPostVar);

$washPostVar = cleanup_post($bookID);
$bookIDAltered = strip_before_insert($conn, $washPostVar);


/*lines 77-527 search for the complete book and complete composition info*/


      /*Retrieving all key signatures for this composition
I will also be creating a comma separated list to use in the displayed information*/
      $keySigQuery = <<<_END
      SELECT  k.key_name
      FROM C2K
      JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
      WHERE C2K.composition_ID = '$compositionIDAltered';

_END;

 $resultKeySigQuery = $conn->query($keySigQuery);
if($debug) {
    echo '$keySigQuery = ' . $keySigQuery . '<br/><br/>';
    if (!$resultKeySigQuery) echo("\n Error description $keySigQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

failureToExecute ($resultKeySigQuery, 'S553', 'Select ' );


         if ($resultKeySigQuery) {

        $numberOfRows = $resultKeySigQuery->num_rows;
/*Build comma separated list of key signatures in a string*/

        $keySignatureString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultKeySigQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

            
            $keySigName = $row[0];

            $keySignatureString .= $keySigName .", ";
            
          } /*for loop ending*/


 
    
} /*End if result kesig query*/

$displayKeySigString = rtrim($keySignatureString,', ');




/*Retrieving all  genres for this composition
I will also be creating a comma separated list to use in the displayed information*/
$genresQuery = <<<_END

        SELECT  g.genre_type
        FROM C2G 
        JOIN genres AS g ON C2G.genre_ID = g.ID
        WHERE C2G.composition_ID = '$compositionIDAltered';


_END;

 $resultGenresQuery = $conn->query($genresQuery);
if($debug) {
    echo '$genresQuery = ' . $genresQuery . '<br/><br/>';
    if (!$resultGenresQuery) echo("\n Error description genresQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

failureToExecute ($resultGenresQuery, 'S554', 'Select ' );


         if ($resultGenresQuery) {

        $numberOfRows = $resultGenresQuery->num_rows;
/*Build comma separated list of genres in a string*/

        $genreString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultGenresQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

           
            $genreName = $row[0];

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
      WHERE C2I.composition_ID = '$compositionIDAltered';


_END;

 $resultInstrumentQuery = $conn->query($instrumentQuery);
if($debug) {
    echo '$instrumentQuery = ' . $instrumentQuery . '<br/><br/>';
    if (!$resultInstrumentQuery) echo ("\n Error description instrumentQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

failureToExecute ($resultInstrumentQuery, 'S555', 'Select ' );


         if ($resultInstrumentQuery) {

        $numberOfRows = $resultInstrumentQuery->num_rows;
/*Build comma separated list of instruments in a string*/
        $instrumentString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
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
      JOIN C2D ON c.ID = C2D.composition_ID
      JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
      JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'General'
      WHERE C2D.composition_ID = '$compositionIDAltered';


_END;

 $resultGenDiffQuery = $conn->query($genDiffQuery);
if($debug) {
    echo '$genDiffQuery = ' . $genDiffQuery . '<br/><br/>';
    if (!$resultGenDiffQuery) echo("\n Error description genDiffQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

failureToExecute ($resultGenDiffQuery, 'S556', 'Select ' );


         if ($resultGenDiffQuery) {

        $GenNumberOfRows = $resultGenDiffQuery->num_rows;


        for ($j = 0 ; $j < $GenNumberOfRows ; ++$j)
          {
            $row = $resultGenDiffQuery->fetch_array(MYSQLI_NUM);

          /*  var_dump ($row);*/
           
            $diffGen = $row[0];
            
          } /*for loop ending*/
    
} /*End if result select gendiff query*/





/*Retrieving the ASP difficulty for this composition*/

$ASPDiffQuery = <<<_END
      SELECT  d.difficulty_level
      FROM compositions AS c 
      JOIN C2D ON c.ID = C2D.composition_ID
      JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
      JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'ASP'
      WHERE C2D.composition_ID = '$compositionIDAltered';

_END;

 $resultASPDiffQuery = $conn->query($ASPDiffQuery);
if($debug) {
    echo '$ASPDiffQuery = ' . $ASPDiffQuery . '<br/><br/>';
    if (!$resultASPDiffQuery) echo("\n Error description: ASPDiffQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

failureToExecute ($resultASPDiffQuery, 'S557', 'Select ' );


         if ($resultASPDiffQuery) {

        $ASPNumberOfRows = $resultASPDiffQuery->num_rows;


        for ($j = 0 ; $j < $ASPNumberOfRows ; ++$j)
          {
            $row = $resultASPDiffQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

           
            $diffASP = $row[0];
            
          } /*for loop ending*/
    
} /*End if result select ASPdiff query*/




/*new book query allowing all editors and publishers to be listed*/

if (strlen($bookID)  > 0 || strlen($compositionIDAltered) > 0) {

    $bookQuery = <<<_END

          SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, b.physBookLoc
          FROM books AS b
          JOIN compositions AS c ON c.book_ID = b.ID
         

          WHERE b.ID = '$bookIDAltered'
          OR c.ID = '$compositionIDAltered';
          

_END;

    $bookQueryResult = $conn->query($bookQuery);

    if ($debug) {
        echo 'bookQuery =' . $bookQuery . '</br>';
    }

    if (!$bookQueryResult) echo("\n Error description query bookQuery: " . mysqli_error($conn) . "\n<br/>");

    failureToExecute ($bookQueryResult, 'S558', 'Select ' );


    if ($bookQueryResult) {
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

    } /*end if book query result*/


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
    if ($debug) {
        echo 'editorPeopleQuery = ' . $editorPeopleQuery . '<br/><br/>';

        if (!$resultEditorPeopleQuery) echo("\n Error description editorPeopleQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    failureToExecute ($resultEditorPeopleQuery, 'S559', 'Select ' );


    if ($resultEditorPeopleQuery) {
        $numEditorPeopleRows = $resultEditorPeopleQuery->num_rows;
        /*Build comma separated list of editorPeople in a string*/
        $editorPeopleString = "";

        for ($j = 0; $j < $numEditorPeopleRows; ++$j) {
            $row = $resultEditorPeopleQuery->fetch_array(MYSQLI_NUM);
            /*var_dump ($row);*/
            $editorPeopleID = $row[0];
            $editorPeopleFirstName = $row[1];
            $editorPeopleMiddleName = $row[2];
            $editorPeopleLastName = $row[3];
            $editorPeopleSuffix = $row[4];
            /*$editorPeopleString = implode(',',$instVal);*/
            $editorPeopleString .= $editorPeopleFirstName . " " . $editorPeopleMiddleName . " " . $editorPeopleLastName . " " . $editorPeopleSuffix . "<br/>Editor Name: ";

        } /*for loop ending*/

    } /*End if $resultEditorPeopleQuery query*/

    $displayEditorPeopleString = substr($editorPeopleString, 0, strrpos($editorPeopleString, "<br/>Editor Name: " ));




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
    if ($debug) {
        echo 'publisherOrgQuery = ' . $publisherOrgQuery . '<br/><br/>';

        if (!$resultPublisherOrgQuery) echo("\n Error description publisherOrgQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    failureToExecute ($resultPublisherOrgQuery, 'S560', 'Select ' );


    if ($resultPublisherOrgQuery) {
        $numPublisherOrgRows = $resultPublisherOrgQuery->num_rows;
        /*Build comma separated list of publisherOrg in a string*/
        $publisherOrgString = "";

        for ($j = 0; $j < $numPublisherOrgRows; ++$j) {
            $row = $resultPublisherOrgQuery->fetch_array(MYSQLI_NUM);
            /*var_dump ($row);*/
            $publisherOrgID = $row[0];
            $publisherOrgName = $row[1];
            $publisherOrgLocation = $row[2];

            /*$editorPeopleString = implode(',',$instVal);*/
            $publisherOrgString .= $publisherOrgName . "</br> Publisher Location: " . $publisherOrgLocation . "</br>Publisher Name: ";

        } /*for loop ending*/

    } /*End if $resultPublisherOrgQuery*/

    $displayPublisherOrgString = substr($publisherOrgString, 0, strrpos($publisherOrgString, "</br>Publisher Name: " ));



    /*end new book query*/
} /*end if bookID > 0}*/elseif($bookIDAltered == "") {

}





       $compositionQuery = <<<_END
        SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, c.movement, e.description,v.voicing_type, ens.ensemble_type, c.book_ID, c.physCompositionLoc 
        FROM compositions AS c
        LEFT JOIN eras AS e ON c.era_ID = e.ID
        LEFT JOIN voicing AS v ON c.voice_ID = v.ID
        LEFT JOIN ensembles AS ens ON c.ensemble_ID = ens.ID
        LEFT JOIN books AS b ON c.book_ID = b.ID

        WHERE c.ID = '$compositionIDAltered';
       
_END;

      $resultCompositionQuery = $conn->query($compositionQuery);
if($debug) {
    echo 'compositionQuery = ' . $compositionQuery . '<br/><br/>';
    if (!$resultCompositionQuery) echo("\n Error description compositionQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

failureToExecute ($resultCompositionQuery, 'S561', 'Select ' );


         if ($resultCompositionQuery) {     

        $numberOfRows = $resultCompositionQuery->num_rows;

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultCompositionQuery->fetch_array(MYSQLI_NUM);

          /*  var_dump ($row);*/

            $queryCompositionID = $row[0];
            $compName = $row[1];
            $opus = $row[2];
            $opusNum = $row[3];
            $compNum = $row[4];
            $subTitle = $row[5];
            $movement = $row[6];
            $era = $row[7];
            $voice = $row[8];
            $ensemble = $row[9];
            $compBookID = $row[10];
            $physCompositionLocNote = $row[11];
            
           
          } /*for loop ending*/
        } /*END result Composition Query*/


/*This composer query and code allows for multiple composers*/
$composerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        JOIN C2R2P ON c.ID = C2R2P.composition_ID
        JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r ON  r.ID = C2R2P.role_ID AND r.role_name = 'Composer'
        WHERE c.ID = '$compositionIDAltered';

_END;

if($debug) {
    echo 'composerQuery = ' . $composerQuery . '<br/><br/>';
}/*end debug*/

        /*send the query*/
        $resultComposerQuery = $conn->query($composerQuery);


if($debug) {
    if (!$resultComposerQuery) echo("\n Error description composerQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

failureToExecute ($resultComposerQuery, 'S562', 'Select ' );


        if ($resultComposerQuery){
       
          $numberOfComposerRows = $resultComposerQuery->num_rows;
          $composerString= "";

          for ($j = 0 ; $j < $numberOfComposerRows ; ++$j){
            $row = $resultComposerQuery->fetch_array(MYSQLI_NUM);

            $composerID = $row[0];
            $compFirst = $row[1];
            $compMiddle = $row[2];
            $compLast = $row[3];
            $compSuffix = $row[4];

              $composerString .= $compFirst .  " " . $compMiddle . " " . $compLast . " " . $compSuffix . "<br/>Composer Name: ";

          } /*for loop ending*/
        } /*END if result composer query*/

        $displayComposerString = substr($composerString, 0, strrpos($composerString, "<br/>Composer Name: " ));
    
        
       
        /*create query to select the arrangers from the database */
        
      $arrangerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        JOIN C2R2P ON c.ID = C2R2P.composition_ID
        JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r ON r.ID = C2R2P.role_ID AND r.role_name = 'Arranger'
       
        WHERE c.ID = '$compositionIDAltered';

_END;

if($debug) {
    echo 'arrangerQuery = ' . $arrangerQuery . '<br/><br/>';
}/*end debug*/

        /*send the query*/
        $resultArrangerQuery = $conn->query($arrangerQuery);


if($debug) {
    if (!$resultArrangerQuery) echo("\n Error description arrangerQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

failureToExecute ($resultArrangerQuery, 'S563', 'Select ' );


        if ($resultArrangerQuery){
       
          $numberOfArrRows = $resultArrangerQuery->num_rows;
          $arrangerString="";

          for ($j = 0 ; $j < $numberOfArrRows ; ++$j){
            $row = $resultArrangerQuery->fetch_array(MYSQLI_NUM);

            $arrangerID = $row[0];
            $arrFirst = $row[1];
            $arrMiddle = $row[2];
            $arrLast = $row[3];
            $arrSuffix = $row[4];

              $arrangerString .= $arrFirst .  " " . $arrMiddle . " " . $arrLast . " " . $arrSuffix . "<br/>Arranger Name: ";

          } /*for loop ending*/

        } /*END if result arranger Query*/

        $displayArrangerString = substr($arrangerString, 0, strrpos($arrangerString, "<br/>Arranger Name: " ));


/*create query to select the lyricists from the database */
        
      $lyricistQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        JOIN C2R2P ON c.ID = C2R2P.composition_ID
        JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r ON r.ID = C2R2P.role_ID AND r.role_name = 'Lyricist'
       
       
        WHERE c.ID = '$compositionIDAltered';

_END;

if($debug) {
    echo 'lyricistQuery = ' . $lyricistQuery . '<br/><br/>';
}/*end debug*/

        /*send the query*/
        $resultLyricistQuery = $conn->query($lyricistQuery);

if($debug) {
    if (!$resultLyricistQuery) echo("\n Error description lyricistQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

failureToExecute ($resultLyricistQuery, 'S564', 'Select ' );


        if ($resultLyricistQuery){
      
          
          $numberOfLyrRows = $resultLyricistQuery->num_rows;
          $lyricistString="";

          for ($j = 0 ; $j < $numberOfLyrRows ; ++$j){
            $row = $resultLyricistQuery->fetch_array(MYSQLI_NUM);

            $lyricistID = $row[0];
            $lyrFirst = $row[1];
            $lyrMiddle = $row[2];
            $lyrLast = $row[3];
            $lyrSuffix = $row[4];

              $lyricistString .= $lyrFirst .  " " . $lyrMiddle . " " . $lyrLast . " " . $lyrSuffix . "<br/>Lyricist Name: ";
          } /*for loop ending*/

        } /*END if result lyricist Query*/
$displayLyricistString = substr($lyricistString, 0, strrpos($lyricistString, "<br/>Lyricist Name: " ));





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









/* H- Display Book information and Composition info Using HTML*/
  echo <<<_END



  <div class="container-fluid bg-light pt-4 pb-3">
  <h3 class="display-4 pb-3  noPrint">Success!</h3>
  <h3>Composition:</h3>
  <h3 class="display-4">  $compName </h3><br/>
  <h3 class=" noPrint">What would you like to do with this composition information?</h3>
  </div>
 

  <div class="container-fluid bg-light pt-4 pb-5">
    <div class="row">
      <div class="col-md-6 pb-4">
       
      
     
     
    
        <h3 class="pt-4">Composition Info</h3>
        Composition Name:<strong> $compName </strong><br/>
        Opus-Like: $opus <br/>
        Opus No.: $opusNum <br/>
        Composition No.: $compNum <br/>
        Subtitle: $subTitle <br/>
        Key Signature: $displayKeySigString <br/>
        Movement: $movement <br/>
        Era: $era <br/>
        Genre: $displayGenreString<br/>
        Voice: $voice <br/>  
        Ensemble: $ensemble <br/>
        Instrument: $displayInstrumentString <br/>
        General difficulty: $diffGen <br/>
        ASP difficulty: $diffASP<br/>
        Composer Name: $displayComposerString <br/>
        Arranger Name: $displayArrangerString <br/>
        Lyricist Name: $displayLyricistString<br/>
        Composition Location: <span style="color:#EB6B42;">$physCompositionLocNote</span><br/><br/><br/>
        
        <h3>Book Info</h3>
        Book Title: <strong>$bookTitle</strong> <br/>
        Tag 1: $bookTag1 <br/>
        Tag 2: $bookTag2 <br/>
        Book Volume: $bookVolume <br/>
        Book Number: $bookNumber <br/><br/>
        Editor Name: $displayEditorPeopleString<br/>
        Publisher Name: $displayPublisherOrgString<br/>
        Book Location: <span style="color:#EB6B42;">$physBookLocNote</span><br/>
        
        
        
        
        
      </div> <!-- end col -->
  
   

_END;

/*Button options for our new composition*/

echo <<<_END

      <div class="col-md-4 offset-lg-2 pb-4 pt-3">
        <form action='editComposition.php' method='post'>
          <input class="btn btn-secondary mb-3 noPrint" type='submit' value='Edit Composition' />
          
          <input  type='hidden' name="compositionID" value='$compositionID' />
          <input type='hidden' name="bookID" value='$bookID' />
          <input type='hidden' name="compName" value="{$fn_encode($compName)}" />
          <input type='hidden' name="editComposition" value='true' />
        </form>
     
        <form action='displayBook.php' method='post'>
          <input  class="btn btn-secondary mb-3 noPrint" type='submit' value='Go to Display Book'/>
          <input type='hidden' name="bookID" value='$bookID' />
        </form>

        <form action='introPage.php' method='post'>
          <input  class="btn btn-secondary mb-3 noPrint" type='submit' value='Search or Add to the Library'/>
        </form>

        <form action='displayComposition.php' method='post'>
          <button class="btn btn-secondary mb-3 noPrint" onclick="window.print()">Print Info for &quot; $compName &quot;</button>
          <input type='hidden' name="compositionID" value='$compositionID'/>
          <input type='hidden' name="compositionTitle" value="{$fn_encode($compName)}"/>
          <input type='hidden' name="bookID" value='$bookID' />
        </form>

        <form action='exitMessage.php' method='post'>
          <input  class="btn btn-secondary mb-3  noPrint" type='submit' value='Exit Library'/>
        </form>
      </div>  <!-- end col -->
    </div>  <!-- end row -->
  </div>  <!-- end container -->

_END;

include 'footer.php';
include 'endingBoilerplate.php';

?>






