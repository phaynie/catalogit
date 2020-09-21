<?php
include 'boilerplate.php';

if($debug) {
    echo <<<_END

  <p>compositionOptions2.php-11</p>

_END;

}/*end debug*/
/*Where are we coming from?
displayCompositon.php
compositionSearch.php

include 'beginningNav.php';

/*Initialize variables coming from other pages*/

$bookID = "";
$searchCompositionTitle = "";
$searchCompositionTitleAltered = "";


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

$compositionID = "";
$compName = "";
$opus = "";
$opusNum = "";
$compNum = "";
$subTitle = "";
$keySig = "";
$displayKeySigString = "";
$movement = "";
$era = "";
$genre = "";
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




/*create local variables for the REQUEST values*/

if(isset($_REQUEST['bookID']) && is_numeric($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if(isset($_REQUEST['searchCompositionTitle'])) {
    $searchCompositionTitle = $_REQUEST['searchCompositionTitle'];
}

if(isset($_REQUEST['compositionID']) && is_numeric($_REQUEST['compositionID'])) {
    $compositionID = $_REQUEST['compositionID'];
}











/*Here we wash this information before we send it in a db query*/
$washPostVar = cleanup_post($searchCompositionTitle);
$searchCompositionTitleAltered = strip_before_insert($conn, $washPostVar);

$washPostVar = cleanup_post($bookID);
$bookIDAltered = strip_before_insert($conn, $washPostVar);

$washPostVar = cleanup_post($compositionID);
$compositionIDAltered = strip_before_insert($conn, $washPostVar);



$notEntered = "<span style='color:rgba(0,0,0,0.4);'>Not Entered</span>";


/*retrieve composition options*/
if ($searchCompositionTitleAltered !== "") {


    $compositionQuery = <<<_END
            SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, c.movement, e.description, v.voicing_type, ens.ensemble_type, c.book_ID, c.physCompositionLoc, b.ID 
            FROM compositions AS c
            LEFT JOIN eras AS e ON c.era_ID = e.ID
            LEFT JOIN voicing AS v ON c.voice_ID = v.ID
            LEFT JOIN ensembles AS ens ON c.ensemble_ID = ens.ID
            LEFT JOIN books AS b ON c.book_ID = b.ID
    
            WHERE c.comp_name LIKE '%$searchCompositionTitleAltered%';
       
_END;

    $resultCompositionQuery = $conn->query($compositionQuery);
    if ($debug) {
        echo 'compositionQuery = ' . $compositionQuery . '<br/><br/>';
        if (!$resultCompositionQuery) echo("\n Error description compositionQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    failureToExecute ($resultCompositionQuery, 'S518', 'Select ' );



    if ($resultCompositionQuery) {

        $numberOfCompositionRows = $resultCompositionQuery->num_rows;
        $compositionsFound = ($numberOfCompositionRows > 0);
        $compositionsNotFound = ($numberOfCompositionRows === 0);


        if ($compositionsNotFound) {


            echo <<<_END
      
      <div class="container-fluid bg-secondary pt-4 pb-2"> 
        <h3 class= "display-4 text-light" > Bummer! </h3>
        <h3>No composition with the title of  "$searchCompositionTitle" was found. <br/><br/><br/></h3> 
        <h4 class="text-light pb-3">Choose an option below <br/></h4>
        <form action='compositionSearch.php' method='post'>
          <button class="btn btn-light" type='submit'>Try another Composition Search</button><br/>
          <input type="hidden" name="bookID" value="$bookID"> 
        </form><br/>
        <form action='addComposition2.php' method='post'>
          <button class="btn btn-light" type='submit'>Add New Composition Information</button><br>
          <span class="text-light">Compositions will be added to the current book, or you will be asked to find or add a book for your composition. </span><br/>
          <input type="hidden" name="bookID" value="$bookID">
          <input type='hidden' name='addNewComposition' value='true'/>    
        </form>
    
      
_END;


        } elseif ($compositionsFound) {





            echo <<<_END
        
            <div class="container-fluid bg-secondary pt-4 pb-2"> 
                  <h5 class="text-light pb-2">Choose a composition below. Then click on the "Choose this Composition" button to continue.</h5>
            </div> <!--end container-->
            <div class="container-fluid bg-secondary pt-4 pb-2">
_END;

            /*COMPOSITION LOOP*/
            for ($j = 0; $j < $numberOfCompositionRows; ++$j) {
                $row = $resultCompositionQuery->fetch_array(MYSQLI_NUM);

                /*  var_dump ($row);*/

                $compositionID = htmlspecialchars($row[0], ENT_QUOTES);
                $compName = $row[1];
                $opus = $row[2];
                $opusNum = $row[3];
                $compNum = $row[4];
                $subTitle = $row[5];
                $movement = $row[6];
                $era = $row[7];
                $voice = $row[8];
                $ensemble = $row[9];
                $bookID = $row[10];
                $physCompositionLocNote = $row[11];



                $compositionsFound = ($numberOfCompositionRows > 0);
                $compositionsNotFound = ($numberOfCompositionRows === 0);




  /*Retrieving all key signatures for this composition
I will also be creating a comma separated list to use in the displayed information*/
  /*We want to select the key_name here because we will only be displaying this value not making it checked or selected. */
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

                failureToExecute ($resultKeySigQuery, 'S519', 'Select ' );


                if ($resultKeySigQuery) {

    $numberOfRows = $resultKeySigQuery->num_rows;
    /*Build comma separated list of key signatures in a string*/

    $keySignatureString= "";

    for ($i = 0 ; $i < $numberOfRows ; ++$i)
    {
      $row = $resultKeySigQuery->fetch_array(MYSQLI_NUM);

      /* var_dump ($row);*/

      $keySig = $row[0];

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
        WHERE C2G.composition_ID = '$compositionIDAltered';


_END;

  $resultGenresQuery = $conn->query($genresQuery);
  if($debug) {
    echo '$genresQuery = ' . $genresQuery . '<br/><br/>';
    if (!$resultGenresQuery) echo("\n Error description genresQuery: " . mysqli_error($conn) . "\n<br/>");
  }/*end debug*/

                failureToExecute ($resultGenresQuery, 'S520', 'Select ' );


                if ($resultGenresQuery) {

    $numberOfRows = $resultGenresQuery->num_rows;
    /*Build comma separated list of genres in a string*/

    $genreString= "";

    for ($i = 0 ; $i < $numberOfRows ; ++$i)
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

                failureToExecute ($resultInstrumentQuery, 'S521', 'Select ' );


                if ($resultInstrumentQuery) {

    $numberOfRows = $resultInstrumentQuery->num_rows;
    /*Build comma separated list of instruments in a string*/
    $instrumentString= "";

    for ($i = 0 ; $i < $numberOfRows ; ++$i)
    {
      $row = $resultInstrumentQuery->fetch_array(MYSQLI_NUM);

      /* var_dump ($row);*/


      $instrumentName = $row[0];

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
      JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'General'
      WHERE C2D.composition_ID = '$compositionIDAltered';


_END;

  $resultGenDiffQuery = $conn->query($genDiffQuery);
  if($debug) {
    echo '$genDiffQuery = ' . $genDiffQuery . '<br/><br/>';
    if (!$resultGenDiffQuery) echo("\n Error description genDiffQuery: " . mysqli_error($conn) . "\n<br/>");
  }/*end debug*/

                failureToExecute ($resultGenDiffQuery, 'S522', 'Select ' );


                if ($resultGenDiffQuery) {

    $GenNumberOfRows = $resultGenDiffQuery->num_rows;


    for ($i = 0 ; $i < $GenNumberOfRows ; ++$i)
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

                failureToExecute ($resultASPDiffQuery, 'S523', 'Select ' );


                if ($resultASPDiffQuery) {

    $ASPNumberOfRows = $resultASPDiffQuery->num_rows;


    for ($i = 0 ; $i < $ASPNumberOfRows ; ++$i)
    {
      $row = $resultASPDiffQuery->fetch_array(MYSQLI_NUM);

      /* var_dump ($row);*/


      $diffASP = $row[0];

    } /*for loop ending*/

  } /*End if result select ASPdiff query*/









                $composerQuery = <<<_END
                
                        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
                        FROM compositions As c
                        JOIN C2R2P ON c.ID = C2R2P.composition_ID
                        JOIN people AS p ON C2R2P.people_ID = p.ID
                        JOIN roles AS r ON  r.ID = C2R2P.role_ID AND r.role_name = 'Composer'
                        
                        WHERE c.ID = '$compositionIDAltered';

_END;

                if ($debug) {
                    echo 'composerQuery = ' . $composerQuery . '<br/><br/>';
                }/*end debug*/

                /*send the query*/
                $resultComposerQuery = $conn->query($composerQuery);


                if ($debug) {
                    if (!$resultComposerQuery) echo("\n Error description composerQuery: " . mysqli_error($conn) . "\n<br/>");
                }/*end debug*/

                failureToExecute ($resultComposerQuery, 'S524', 'Select ' );

                if ($resultComposerQuery) {

                    $numberOfComposerRows = $resultComposerQuery->num_rows;
                    $composerString = "";

                    for ($i = 0; $i < $numberOfComposerRows; ++$i) {
                        $row = $resultComposerQuery->fetch_array(MYSQLI_NUM);

                        $composerID = $row[0];
                        $compFirst = $row[1];
                        $compMiddle = $row[2];
                        $compLast = $row[3];
                        $compSuffix = $row[4];

                        $composerString .= $compFirst . " " . $compMiddle . " " . $compLast . " " . $compSuffix . "</br>Composer Name: ";

                    } /*for loop ending*/
                } /*END if result composer query*/


                $displayComposerString = substr($composerString, 0, strrpos($composerString, "</br>Composer Name: "));

                /*ToDo do I need this code this time?*/
                if ($displayComposerString == "") {
                    $disableERDComposer = 'disabled';
                }

                /*create query to select the arranger from the database */

                $arrangerQuery = <<<_END
                
                        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
                        FROM compositions As c
                        JOIN C2R2P ON c.ID = C2R2P.composition_ID
                        JOIN people AS p ON C2R2P.people_ID = p.ID
                        JOIN roles AS r ON  r.ID = C2R2P.role_ID AND r.role_name = 'Arranger'
                        
                        WHERE c.ID = '$compositionIDAltered';

_END;

                if ($debug) {
                    echo 'arrangerQuery = ' . $arrangerQuery . '<br/>';
                }/*end debug*/

                /*send the query*/
                $resultArrangerQuery = $conn->query($arrangerQuery);


                if ($debug) {
                    if (!$resultArrangerQuery) echo("\n Error description arrangerQuery: " . mysqli_error($conn) . "\n<br/>");
                }/*end debug*/

                failureToExecute ($resultArrangerQuery, 'S525', 'Select ' );


                if ($resultArrangerQuery) {

                    $numberOfArrangerRows = $resultArrangerQuery->num_rows;
                    $arrangerString = "";

                    for ($i = 0; $i < $numberOfArrangerRows; ++$i) {
                        $row = $resultArrangerQuery->fetch_array(MYSQLI_NUM);

                        $arrangerID = $row[0];
                        $arrFirst = $row[1];
                        $arrMiddle = $row[2];
                        $arrLast = $row[3];
                        $arrSuffix = $row[4];

                        $arrangerString .= $arrFirst . " " . $arrMiddle . " " . $arrLast . " " . $arrSuffix . "</br>Arranger Name: ";

                    } /*for loop ending*/

                } /*END if result arranger Query*/

                /*$displayArrangerString = rtrim($arrangerString, "Arranger Name: ");*/
                $displayArrangerString = substr($arrangerString, 0, strrpos($arrangerString, "</br>Arranger Name: "));




                /*create query to select the arranger from the database */

                $lyricistQuery = <<<_END
                
                        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
                        FROM compositions As c
                        JOIN C2R2P ON c.ID = C2R2P.composition_ID
                        JOIN people AS p ON C2R2P.people_ID = p.ID
                        JOIN roles AS r ON r.ID = C2R2P.role_ID AND r.role_name = 'Lyricist'
                       
                        WHERE c.ID = '$compositionIDAltered';

_END;

                if ($debug) {
                    echo 'lyricistQuery = ' . $lyricistQuery . '<br/><br/>';
                }/*end debug*/

                /*send the query*/
                $resultLyricistQuery = $conn->query($lyricistQuery);

                if ($debug) {
                    if (!$resultLyricistQuery) echo("\n Error description lyricistQuery: " . mysqli_error($conn) . "\n<br/>");
                }/*end debug*/

                failureToExecute ($resultLyricistQuery, 'S526', 'Select ' );


                if ($resultLyricistQuery) {


                    $numberOfLyricistRows = $resultLyricistQuery->num_rows;
                    $lyricistString = "";

                    for ($i = 0; $i < $numberOfLyricistRows; ++$i) {
                        $row = $resultLyricistQuery->fetch_array(MYSQLI_NUM);

                        $lyricistID = $row[0];
                        $lyrFirst = $row[1];
                        $lyrMiddle = $row[2];
                        $lyrLast = $row[3];
                        $lyrSuffix = $row[4];

                        $lyricistString .= $lyrFirst . " " . $lyrMiddle . " " . $lyrLast . " " . $lyrSuffix . "</br>Lyricist Name: ";

                    } /*for loop ending*/

                } /*END if result arranger Query*/

                $displayLyricistString = substr($lyricistString, 0, strrpos($lyricistString, "</br>Lyricist Name: "));

                /*ToDo do I need this code this time?*/
                if ($displayLyricistString == "") {
                    $disableERDLyricist = 'disabled';
                }

















                if($bookIDAltered !== "") {
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

                    failureToExecute ($bookQueryResult, 'S527', 'Select ' );

                    if($bookQueryResult) {
                        $numberOfBookRows = $bookQueryResult->num_rows;

                        for ($i = 0; $i < $numberOfBookRows; ++$i) {
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

                    failureToExecute ($resultEditorPeopleQuery, 'S528', 'Select ' );


                    if ($resultEditorPeopleQuery) {
                        $numEditorPeopleRows = $resultEditorPeopleQuery->num_rows;
                        /*Build comma separated list of editorPeople in a string*/
                        $editorPeopleString= "";

                        for ($i = 0 ; $i < $numEditorPeopleRows ; ++$i) {
                            $row = $resultEditorPeopleQuery->fetch_array(MYSQLI_NUM);
                            /*var_dump ($row);*/
                            $editorPeopleID = $row[0];
                            $editorPeopleFirstName = $row[1];
                            $editorPeopleMiddleName = $row[2];
                            $editorPeopleLastName = $row[3];
                            $editorPeopleSuffix = $row[4];
                            /*$editorPeopleString = implode(',',$instVal);*/
                            $editorPeopleString .= $editorPeopleFirstName . " " . $editorPeopleMiddleName . " " . $editorPeopleLastName . " " . $editorPeopleSuffix . "</br>Editor Name: ";

                        } /*for loop ending*/

                    } /*End if $resultEditorPeopleQuery query*/


                    $displayEditorPeopleString = substr($editorPeopleString, 0, strrpos($editorPeopleString, "</br>Editor Name: " ));

                    if($displayEditorPeopleString == ""){
                        $disableERDEditor = 'disabled';
                    }




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

                    failureToExecute ($resultPublisherOrgQuery, 'S529', 'Select ' );


                    if ($resultPublisherOrgQuery) {
                        $numPublisherOrgRows = $resultPublisherOrgQuery->num_rows;
                        /*Build comma separated list of publisherOrg in a string*/
                        $publisherOrgString= "";

                        for ($i = 0 ; $i < $numPublisherOrgRows ; ++$i) {
                            $row = $resultPublisherOrgQuery->fetch_array(MYSQLI_NUM);
                            /*var_dump ($row);*/
                            $publisherOrgID = $row[0];
                            $publisherOrgName = $row[1];
                            $publisherOrgLocation = $row[2];

                            /*$editorPeopleString = implode(',',$instVal);*/
                            $publisherOrgString .= $publisherOrgName . "</br> Publisher Location: " . $publisherOrgLocation . "</br></br>Publisher Name: ";

                        } /*for loop ending*/

                    } /*End if $resultPublisherOrgQuery*/


                    $displayPublisherOrgString = substr($publisherOrgString, 0, strrpos($publisherOrgString, "</br>Publisher Name: " ));

                    if($displayPublisherOrgString == ""){
                        $disableERDPub = 'disabled';
                    }
                }/*End if($bookID !== "")*/










                /*book 'not entered' display text*/

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







                /*composition 'not entered' display text*/


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





                /*Here we hold all of the information about each composition belonging to a specific book. Because it is in our for loop, each composition found with the bookID we are working with, will have this block of information displayed on our page.*/
                echo <<<_END
         
                <div class="row">
             
                <div class="col-sm-6"> 
                    <div class="card  mb-3">
                     <div class="card-body bg-light">
                     
                    
                
                    <form class="mt-4" action='displayComposition.php' method='post'>
                        <div class="form-check">
                          Composition Title:<strong> $compName</strong><br>
                          Opus or sim: $opus<br>
                          Opus Number or sim: $opusNum<br>
                          Composition No.: $compNum<br>
                          Subtitle: $subTitle<br>
                          Key Signature: $displayKeySigString<br>
                          Movement: $movement<br>
                          Era: $era <br>
                          Genre: $displayGenreString <br>
                          Voice: $voice <br>
                          Ensemble: $ensemble <br>
                          Instrument: $displayInstrumentString <br>
                          Composer Name: $displayComposerString<br>
                          Arranger Name: $displayArrangerString <br>
                          Lyricist Name: $displayLyricistString <br>
                          ASP difficulty: $diffASP <br>
                          General difficulty: $diffGen <br>
                          Composition Location:<span style="color:#EB6B42;"> $physCompositionLocNote </span> <br><br>
            
                        
                          <input class="mt-4 btn btn-secondary" type='submit' value='Choose this Composition'/>
                          <input type="hidden" name="bookID" value="$bookID"/><br> 
                          <input type="hidden" name="compositionID" value="$compositionID"/><br>
                        </div> <!-- end form-check -->
                        </form>
                       
                        </div> <!-- end card body -->
                        </div> <!-- end card -->
                        </div> <!-- end column -->
                    
                 
                
                      <div class="col-sm-6"> 
                    <div class="card   mb-3">
                     <div class="card-body pt-3 bg-light">
                  
                       
                        
                           Book Title: <strong>$bookTitle</strong> <br/>
                           Tag 1: $bookTag1 <br/>
                           Tag 2: $bookTag2 <br/>
                           Book Volume: $bookVolume <br/>
                           Book Number: $bookNumber <br/>
                           Editor Name: $displayEditorPeopleString<br/>
                           Publisher Name: $displayPublisherOrgString <br/>
                           Book Location: <span style="color:#EB6B42;">$physBookLocNote</span><br/><br/>
                      
                          
                          </div> <!-- end card body -->
                           </div> <!-- end card -->
                        </div> <!-- end column -->
                        
                </div> <!--end row-->
                
                
                

_END;



            }/*End Composition Loop*/

            echo <<<_END

            <div class="container-fluid bg-secondary text-light pb-3">
                <h2 class="mb-3">None of these Composition Options match</h2>
                <form action="CompositionSearch.php" method='post'>
                    <input class="btn btn-light" type='submit' value='Try Another Composition Search'/>
                    <input type='hidden' name='bookID' value="$bookID"/>
                </form> <!-- end form -->
        
                <form action="addComposition2.php" method='post'>
                  <input class="btn btn-light" type='submit' value='Add New Composition Info'/>
                  <input type='hidden' name='addNewComposition' value='true'/>
                  <input type='hidden' name='bookID' value="$bookID"/>
                </form> <!-- end form -->
            </div> <!-- end container -->
      

_END;


        }/*End else if Compositions Found/not found*/
    }/*End $ifresultCompositionQuery*/
} /*ENd if ($searchCompositionTitleAltered !== "")*/






include 'footer.php';
include 'endingBoilerplate.php';

?>
