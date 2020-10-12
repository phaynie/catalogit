
<?php
include 'boilerplate.php';

if($debug) {
    echo <<<_END

<p>displayPerson-43</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';



/*Where did we come from?
displayAdvSearch.php
peopleOptions.php */



/*Initialize local variables for values coming from other pages*/

$composerID = "";
$arrangerID = "";
$lyricistID = "";
$peopleID = "";
/*$compositionID = "";*/
/*$bookID = "";*/

$bookTitle = "";
$bookTag1 = "";
$bookTag2 = "";
$bookVolume = "";
$bookNumber = "";
$displayEditorPeopleString = "";
$displayPublisherOrgString = "";

$notEntered = "";

$compName = "";
$opus = "";
$compNum = "";
$compNo = "";
$subTitle = "";
$displayKeySigString = "";
$movement = "";
$era = "";
$displayGenreString = "";
$voice = "";
$ensemble = "";
$displayInstrumentString = "";
$diffGen = "";
$diffASP = "";
$displayComposerString = "";
$displayArrangerString = "";
$displayLyricistString = "";
$physCompositionLocNote = "";
$findComposer = "";
$findPerson = "";
$currentPeopleFirst = "";
$currentPeopleMiddle = "";
$currentPeopleLast = "";
$currentPeopleSuffix = "";



/*if(isset($_REQUEST['bookID']) && is_numeric($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}*/

if(isset($_REQUEST['composerID']) && is_numeric($_REQUEST['composerID'])) {
    $composerID = $_REQUEST['composerID'];
    $role = "Composer";

}

if(isset($_REQUEST['arrangerID']) && is_numeric($_REQUEST['arrangerID'])) {
    $arrangerID = $_REQUEST['arrangerID'];
    $role = "Arranger";

}

if(isset($_REQUEST['lyricistID']) && is_numeric($_REQUEST['lyricistID'])) {
    $lyricistID = $_REQUEST['lyricistID'];
    $role = "Lyricist";
}

if(isset($_REQUEST['peopleID']) && is_numeric($_REQUEST['peopleID'])) {
    $peopleID = $_REQUEST['peopleID'];
}

if(isset($_REQUEST['findPerson']) ) {
    $findPerson = $_REQUEST['findPerson'];
    $role = 'Person';
    $sendFindPerson = "<input type='hidden' name='findPerson' value='true' />";
}

if(isset($_REQUEST['findComposer'])) {
    $findComposer = $_REQUEST['findComposer'];
    $role = 'Composer';
    $rolePhrase = 'Compositions';

}

/*if(isset($_REQUEST['compositionID']) && is_numeric($_REQUEST['compositionID'])) {
    $compositionID = $_REQUEST['compositionID'];
}*/


$notEntered = "<span style='color:rgba(0,0,0,0.4);'>Not Entered</span>";


/*here we will wash all variables that will be usd in the db queries below*/
$washPostVar = cleanup_post($composerID);
$composerIDAltered = strip_before_insert($conn, $washPostVar);

$washPostVar = cleanup_post($arrangerID);
$arrangerIDAltered = strip_before_insert($conn, $washPostVar);

$washPostVar = cleanup_post($lyricistID);
$lyricistIDAltered = strip_before_insert($conn, $washPostVar);

$washPostVar = cleanup_post($peopleID);
$peopleIDAltered = strip_before_insert($conn, $washPostVar);

/*$washPostVar = cleanup_post($compositionID);
$compositionID = strip_before_insert($conn, $washPostVar);*/

/*$washPostVar = cleanup_post($bookID);
$bookIDAltered = strip_before_insert($conn, $washPostVar);*/




/*display composer we just chose*/
/*use query to get most recent composer information using the composerid*/




if($findPerson =='true'){
    $peopleQuery = <<<_END

SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
  FROM people AS p
  
   WHERE p.ID = '$peopleIDAltered';

_END;

}else{


    $peopleQuery = <<<_END

SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
  FROM compositions As c
  JOIN C2R2P ON c.ID = C2R2P.composition_ID
  JOIN people AS p ON C2R2P.people_ID = p.ID
  JOIN roles AS r_people ON C2R2P.role_ID = r_people.ID AND r_people.role_name = '$role'
   WHERE p.ID = '$peopleIDAltered';

_END;

}/*end if($findPerson =='true')*/

if($debug) {
    echo '$peopleQuery = ' . $peopleQuery . '<br/><br/>';
}/*end debug*/

/*send the query*/
$resultPeopleQuery = $conn->query($peopleQuery);

if($debug) {
    if (!$resultPeopleQuery) echo("\n Error description peopleQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

failureToExecute ($resultPeopleQuery, 'S540', 'Select ' );


if ($resultPeopleQuery){
       
  $numberOfPeopleRows = $resultPeopleQuery->num_rows;
  $peopleString = "";

if($debug) {
    echo 'numberOfPeopleRows = ' . $numberOfPeopleRows . '<br/><br/>';
}/*end debug*/

  for ($j = 0 ; $j < $numberOfPeopleRows ; ++$j){
    $row = $resultPeopleQuery->fetch_array(MYSQLI_NUM);

    $currentPeopleID = $row[0];
    $currentPeopleFirst = $row[1];
    $currentPeopleMiddle = $row[2];
    $currentPeopleLast = $row[3];
    $currentPeopleSuffix = $row[4];

  } /*for loop ending*/

if($debug) {
    echo 'peopleID =' . $peopleID . "<br/>";
}/*end debug*/

} /*END if result people query*/




/*find all compositions this composer is a composer for and display the composition and the book it is in. 
We will do this inside a card with the composition information to the left and the book information to the right. 
This will use a loop.*/
if($findPerson == 'true') {

    $compositionQuery = <<<_END

SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, 
c.movement, e.description,v.voicing_type, ens.ensemble_type, c.book_ID, c.physCompositionLoc 
    FROM compositions AS c
    LEFT JOIN eras AS e ON c.era_ID = e.ID
    LEFT JOIN voicing AS v ON c.voice_ID = v.ID
    LEFT JOIN ensembles AS ens ON c.ensemble_ID = ens.ID
	LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
    LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
   
        
    WHERE p.ID = '$peopleIDAltered'
    ORDER BY c.comp_name ASC;

_END;

}else{

$compositionQuery = <<<_END

SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, 
c.movement, e.description,v.voicing_type, ens.ensemble_type, c.book_ID, c.physCompositionLoc 
    FROM compositions AS c
    LEFT JOIN eras AS e ON c.era_ID = e.ID
    LEFT JOIN voicing AS v ON c.voice_ID = v.ID
    LEFT JOIN ensembles AS ens ON c.ensemble_ID = ens.ID
	LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
    LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
    LEFT JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID AND r_composer.role_name = '$role'
        
    WHERE p.ID = '$peopleIDAltered'
    ORDER BY c.comp_name ASC;

_END;

}/* End if(findPerson == 'true')*/


    $resultCompositionQuery = $conn->query($compositionQuery);
    if($debug) {
        echo 'compositionQuery =' . $compositionQuery . '<br/><br/>';
        if (!$resultCompositionQuery) echo("\n Error description compositionQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    failureToExecute ($resultCompositionQuery, 'S541', 'Select ' );


    if ($resultCompositionQuery) {

        $numberOfCompositionRows = $resultCompositionQuery->num_rows;
        $compositionsFound = ($numberOfCompositionRows  > 0);
        $compositionsNotFound = ($numberOfCompositionRows === 0);

        if($debug) {
            echo "number of composition rows = " . $numberOfCompositionRows . "  <br/>";
        }/*end debug*/
















  if($compositionsFound) {
    echo <<<_END

    <div class="container-fluid bg-light pt-4 pb-3">
      <h3 class="display-4 pb-3 noPrint">Success!</h3>
      <h3>$role:</h3>
      <h3 class="display-4">  $currentPeopleFirst $currentPeopleMiddle $currentPeopleLast $currentPeopleSuffix </h3>
    </div> <!--end container-->
        
_END;

    /*composition Loop*/
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
            

        if($debug) {
            echo '$k = ' . $k  . '<br/><br/>';
        }/*end debug*/
      
      /*Retrieving all key signatures for this composition
      I will also be creating a comma separated list to use in the displayed information*/
      $keySigQuery = <<<_END
        SELECT  k.key_name
        FROM C2K
        JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
        WHERE C2K.composition_ID = '$compositionIDAltered';

_END;

        /*Does the composition Id come from the query above? */

      $resultKeySigQuery = $conn->query($keySigQuery);
      if($debug) {
          echo '$keySigQuery = ' . $keySigQuery . '<br/><br/>';
          if (!$resultKeySigQuery) echo("\n Error description keySigQuery: " . mysqli_error($conn) . "\n<br/>");
      }/*end debug*/

        failureToExecute ($resultKeySigQuery, 'S542', 'Select ' );


        if ($resultKeySigQuery) {

        $numberOfKeySigRows = $resultKeySigQuery->num_rows;
        /*Build comma separated list of key signatures in a string*/

        $keySignatureString= "";

        for ($j = 0 ; $j < $numberOfKeySigRows ; ++$j) {
          $row = $resultKeySigQuery->fetch_array(MYSQLI_NUM);
          /* var_dump ($row);*/
          $keySigName = htmlspecialchars($row[0], ENT_QUOTES);
          $keySignatureString .= $keySigName .", ";
            
        } /*for loop ending*/

      } /*End if result kesig query*/

      $displayKeySigString = rtrim($keySignatureString,', ');




      /*Retrieving all key genres for this composition
      I will also be creating a comma separated list to use in the displayed information*/
      $genresQuery = <<<_END

        SELECT  g.genre_type
        FROM C2G 
        JOIN genres AS g ON C2G.genre_ID = g.ID
        WHERE C2G.composition_ID = '$compositionIDAltered';

_END;

      $resultGenresQuery = $conn->query($genresQuery);
        if($debug) {
            echo '$selectGenresQuery = ' . $genresQuery . '<br/><br/>';
            if (!$resultGenresQuery) echo("\n Error description genresQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        failureToExecute ($resultGenresQuery, 'S543', 'Select ' );


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
        JOIN instruments AS i ON C2I.instrument_ID = i.ID
        WHERE C2I.composition_ID = '$compositionIDAltered';

_END;

      $resultInstrumentQuery = $conn->query($instrumentQuery);
        if($debug) {
            echo '$selectInstrumentQuery = ' . $instrumentQuery . '<br/><br/>';
            if (!$resultInstrumentQuery) echo("\n Error description instrumentQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        failureToExecute ($resultInstrumentQuery, 'S544', 'Select ' );


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





      /*Retrieving the General difficluty for this composition*/

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
            echo '$selectGenDiffQuery = ' . $genDiffQuery . '<br/><br/>';
            if (!$resultGenDiffQuery) echo("\n Error description genDiffQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        failureToExecute ($resultGenDiffQuery, 'S545', 'Select ' );


        if ($resultGenDiffQuery) {
        $numberOfGenRows = $resultGenDiffQuery->num_rows;

        for ($j = 0 ; $j < $numberOfGenRows ; ++$j) {
          $row = $resultGenDiffQuery->fetch_array(MYSQLI_NUM);
          /*  var_dump ($row);*/
          $diffGen = $row[0];
          
        } /*for loop ending*/
    
      } /*End if result gendiff query*/


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
            echo '$selectASPDiffQuery = ' . $ASPDiffQuery . '<br/><br/>';
            if (!$resultASPDiffQuery) echo("\n Error description ASPDiffQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        failureToExecute ($resultASPDiffQuery, 'S546', 'Select ' );


        if ($resultASPDiffQuery) {
        $numberOfASPRows = $resultASPDiffQuery->num_rows;

        for ($j = 0 ; $j < $numberOfASPRows ; ++$j) {
          $row = $resultASPDiffQuery->fetch_array(MYSQLI_NUM);
           /* var_dump ($row);*/
          $diffASP = $row[0];
            
        } /*for loop ending*/

      } /*End if resultASPdiff query*/





      /*G- Retrieve book and Composition information to display in browser.
      1- Book Information
      2- Composition information minus the composer, Arranger, or Lyricist*/


    /*    $bookQuery = <<<_END

          SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, b.physBookLoc
          FROM books AS b

          WHERE c.ID = '$compositionID' ;

_END;*/




       $bookQuery = <<<_END
        
        SELECT c.ID, b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, b.physBookLoc
          FROM compositions AS c
          JOIN books as b ON b.ID = c.book_ID

          WHERE c.ID = '$compositionID' ;
        

_END;

       $bookQueryResult = $conn->query($bookQuery);

        if ($debug) {
            echo 'bookQuery =' . $bookQuery . '</br>';
        }

        if (!$bookQueryResult) echo("\n Error description query bookQuery: " . mysqli_error($conn) . "\n<br/>");

        failureToExecute ($bookQueryResult, 'S547', 'Select ' );


        if ($bookQueryResult) {
            $numberOfBookRows = $bookQueryResult->num_rows;

            for ($j = 0; $j < $numberOfBookRows; ++$j) {
                $row = $bookQueryResult->fetch_array(MYSQLI_NUM);

                $compositionID = $row[0];
                $bookID = $row[1];
                $bookTitle = $row[2];
                $bookTag1 = $row[3];
                $bookTag2 = $row[4];
                $bookVolume = $row[5];
                $bookNumber = $row[6];

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

        failureToExecute ($resultEditorPeopleQuery, 'S548', 'Select ' );


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

  /*$displayEditorPeopleString = rtrim($editorPeopleString, 'Editor Name: ');*/
  $displayEditorPeopleString = substr($editorPeopleString, 0, strrpos($editorPeopleString, "<br/>Editor Name: " ));



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

        failureToExecute ($resultPublisherOrgQuery, 'S549', 'Select ' );


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

  /*$displayPublisherOrgString = rtrim($publisherOrgString, "</br>Publisher Name: ");*/
  $displayPublisherOrgString = substr($publisherOrgString, 0, strrpos($publisherOrgString, "</br>Publisher Name: " ));

  /*end new book query*/
 /*end if bookID > 0}*/



 /*end new book query allowing multiple editors and publishers*/


        /*This composer query and code allows for multiple composers*/
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

        failureToExecute ($resultComposerQuery, 'S550', 'Select ' );


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





        /*create query to select the arranger from the database */
        
        $arrangerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
          FROM compositions As c
          JOIN C2R2P ON c.ID = C2R2P.composition_ID
          JOIN people AS p ON C2R2P.people_ID = p.ID
          JOIN roles AS r_arr ON C2R2P.role_ID = r_arr.ID AND r_arr.role_name = 'Arranger'
          WHERE c.ID = '$compositionID';

_END;

        if($debug) {
            echo 'arrangerQuery = ' . $arrangerQuery . '<br/><br/>';
        }/*end debug*/

        /*send the query*/
        $resultArrangerQuery = $conn->query($arrangerQuery);


        if($debug) {
            if (!$resultArrangerQuery) echo("\n Error description arrangerQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        failureToExecute ($resultArrangerQuery, 'S551', 'Select ' );


        if ($resultArrangerQuery){
          $numberOfArrRows = $resultArrangerQuery->num_rows;
            $arrangerString = "";

          for ($j = 0 ; $j < $numberOfArrRows ; ++$j){
            $row = $resultArrangerQuery->fetch_array(MYSQLI_NUM);

            $arrangerID = $row[0];
            $arrFirst = $row[1];
            $arrMiddle = $row[2];
            $arrLast = $row[3];
            $arrSuffix = $row[4];

            $arrangerString .= $arrFirst . " " . $arrMiddle . " " . $arrLast . " " . $arrSuffix . "<br/>Arranger Name: ";


          } /*for loop ending*/

        } /*END if result arranger Query*/

        $displayArrangerString = substr($arrangerString, 0, strrpos($arrangerString, "<br/>Arranger Name: " ));




        /*create query to select the arranger from the database */
        
        $lyricistQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
          FROM compositions As c
          JOIN C2R2P ON c.ID = C2R2P.composition_ID
          JOIN people AS p ON C2R2P.people_ID = p.ID
          JOIN roles AS r_lyr ON C2R2P.role_ID = r_lyr.ID AND r_lyr.role_name = 'Lyricist'
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

        failureToExecute ($resultLyricistQuery, 'S552', 'Select ' );


        if ($resultLyricistQuery){
          $numberOfLyrRows = $resultLyricistQuery->num_rows;
            $lyricistString = "";

          for ($j = 0 ; $j < $numberOfLyrRows ; ++$j){
            $row = $resultLyricistQuery->fetch_array(MYSQLI_NUM);

            $lyricistID = $row[0];
            $lyrFirst = $row[1];
            $lyrMiddle = $row[2];
            $lyrLast = $row[3];
            $lyrSuffix = $row[4];

            $lyricistString .= $lyrFirst . " " . $lyrMiddle . " " . $lyrLast . " " . $lyrSuffix . "<br/>Lyricist Name: ";

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


        if($movement == "") {
            $movement = "$notEntered";
        }

        if($era == "none") {
            $era = "$notEntered";
        }

        if($displayGenreString == "none") {
            $displayGenreString = "$notEntered";
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

        if($diffASP == "none") {
            $diffASP = "$notEntered";
        }

        if($diffGen == "none") {
            $diffGen = "$notEntered";
        }









        /* H- Display Composition info with its connected book Using HTML*/
        echo <<<_END

        <div class="container-fluid bg-light ">
          <div class="card  border-0">
            <div class="card-body bg-light">
              <div class="row">
                <div class="col-md-4 offset-md-1 pb-4">
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
                  Composer Name:  $displayComposerString<br/> 
                  Arranger Name:  $displayArrangerString<br/>
                  Lyricist Name:  $displayLyricistString<br/>
                  Composition Location: <span style="color:#EB6B42;">$physCompositionLocNote</span><br/><br/>
            
                
                
                                
                    
                    <form action="editComposition.php" method="post">
                        <input class="btn btn-secondary mb-3 noPrint"  type='submit' value='Edit Composition'/> 
                        <input type='hidden' name='bookID' value='$bookID'/>
                        <input type='hidden' name='compositionID' value='$compositionID'/>
                        $sendFindPerson
                    </form>  <!-- end form -->
                   
             
    </div> <!-- end col -->
  
      
                <div class="col-md-4 pb-4">
                  <h3 class="pt-4">Composition Book Info</h3>
                  Book Title: <strong>$bookTitle</strong> <br/>
                  Tag 1: $bookTag1 <br/>
                  Tag 2: $bookTag2 <br/>
                  Book Volume: $bookVolume <br/>
                  Book Number: $bookNumber <br/>
                  Editor Name: $displayEditorPeopleString <br/>
                  Publisher Name: $displayPublisherOrgString<br/>
                  Book Location: <span style="color:#EB6B42;">$physBookLocNote</span><br/><br/>
                  
                   <form action="editBook.php" method="post">
                        <input class="btn btn-secondary mb-3 noPrint"  type='submit' value='Edit Book'/> 
                        <input type='hidden' name='bookID' value='$bookID'/>
                        <input type='hidden' name='compositionID' value='$compositionID'/>
                        $sendFindPerson
                    </form>  <!-- end form -->
                </div> <!-- end col -->
                
                
              </div>  <!-- end row -->
            </div>  <!-- end card body -->
        </div>  <!-- end card -->
     </div>  <!-- end container -->
             
       

_END;

  } /*Composition for loop ending*/
  






}/*end ifcompositionsFound*/
} /*END if ($resultCompositionQuery)*/












/*Searching for any book where p.ID = our person*/

if($findPerson == 'true') {
    $bookQuery = <<<_END
        
        SELECT  b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, b.physBookLoc 
          FROM books AS b 
          JOIN B2R2P ON B2R2P.book_ID = b.ID 
          JOIN roles AS r ON r.ID = B2R2P.role_ID AND r.role_name = 'Editor' 
          JOIN people AS p ON B2R2P.people_ID = p.ID  
          WHERE p.ID = '$peopleIDAltered';
        

_END;

    $bookQueryResult = $conn->query($bookQuery);

    if ($debug) {
        echo 'bookQuery =' . $bookQuery . '</br>';
    }

    if (!$bookQueryResult) echo("\n Error description query bookQuery: " . mysqli_error($conn) . "\n<br/>");

    failureToExecute($bookQueryResult, 'S547', 'Select ');


    if ($bookQueryResult) {
        $numberOfBookRows = $bookQueryResult->num_rows;
        $booksFound = ($numberOfBookRows  > 0);
        $booksNotFound = ($numberOfBookRows === 0);


        /*bookQuery For loop*/
        for ($j = 0; $j < $numberOfBookRows; ++$j) {
            $row = $bookQueryResult->fetch_array(MYSQLI_NUM);



            $bookID = $row[0];
            $bookTitle = $row[1];
            $bookTag1 = $row[2];
            $bookTag2 = $row[3];
            $bookVolume = $row[4];
            $bookNumber = $row[5];
            $physBookLocNote = $row[6];


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

            failureToExecute($resultEditorPeopleQuery, 'S548', 'Select ');


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

            /*$displayEditorPeopleString = rtrim($editorPeopleString, 'Editor Name: ');*/
            $displayEditorPeopleString = substr($editorPeopleString, 0, strrpos($editorPeopleString, "<br/>Editor Name: "));


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

            failureToExecute($resultPublisherOrgQuery, 'S549', 'Select ');


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

            /*$displayPublisherOrgString = rtrim($publisherOrgString, "</br>Publisher Name: ");*/
            $displayPublisherOrgString = substr($publisherOrgString, 0, strrpos($publisherOrgString, "</br>Publisher Name: "));


            /* H- Display Composition info with its connected book Using HTML*/
            echo <<<_END

        <div class="container-fluid bg-light ">
          <div class="card  border-0 ">
            <div class="card-body bg-light">
              <div class="row">
                  <div class="col-md-4  offset-md-1 pb-4">
                  <h3 class="pt-4">Book Info</h3>
                  Book Title: <strong>$bookTitle</strong> <br/>
                  Tag 1: $bookTag1 <br/>
                  Tag 2: $bookTag2 <br/>
                  Book Volume: $bookVolume <br/>
                  Book Number: $bookNumber <br/>
                  Editor Name: $displayEditorPeopleString <br/>
                  Publisher Name: $displayPublisherOrgString<br/>
                  Book Location: <span style="color:#EB6B42;">$physBookLocNote</span><br/><br/>
                  
                     <form action="editBook.php" method="post">
                        <input class="btn btn-secondary mb-3 noPrint"  type='submit' value='Edit Book'/> 
                        <input type='hidden' name='bookID' value='$bookID'/>
                        <input type='hidden' name='compositionID' value='$compositionID'/>
                        $sendFindPerson
                    </form>  <!-- end form -->
                </div> <!-- end col -->
             
     
                 
           
              </div>  <!-- end row -->
            </div>  <!-- end card body -->
        </div>  <!-- end card -->
     </div>  <!-- end container -->

     

   


_END;






        } /*Bookforloop ending*/

    } /*end if book query result*/
}/*End if($findPerson == 'true')*/

    /*Button options for our new information*/



if($compositionsFound || $booksFound) {



    echo <<<_END


 <h3 class="noPrint pt-4 pl-4">What would you like to do with this information?</h3><br/>
              <div class="col-md-3 offset-1 pb-4 pt-3">
                   
                
                    
                    <form action="peopleSearch.php" method="post">
                        <input class="btn btn-secondary mb-3 noPrint  btn-block"  type='submit' value='Try another $role Search'/> 
                        <input type='hidden' name='bookID' value='$bookID'/>
                        <input type='hidden' name='compositionID' value='$compositionID'/>
                        $sendFindPerson
                    </form>  <!-- end form -->
                
                
                    <form action='introPage.php' method='post'>
                      <input  class="btn btn-secondary  btn-block mb-3 noPrint" type='submit' value='New Library Search'/>
                    </form>
                
                    <form action='displayPerson.php' method='post'>
                      <button class="btn btn-secondary mb-3 noPrint  btn-block" onclick="window.print()">Print</button>
                      <input type='hidden' name="compositionID" value='$compositionID'/>
                      <input type='hidden' name="bookID" value='$bookID'/>
                      <input type='hidden' name="composerPrintPage" value='true'/>
                      <input type='hidden' name="composerID" value='$composerID'/>
                      $sendFindPerson
                    </form>
                
                    <form action='exitMessage.php' method='post'>
                      <input  class="btn btn-secondary mb-3 noPrint  btn-block" type='submit' value='Exit Library'/>
                    </form>
     
               </div>  <!-- end col -->
              </div>  <!-- end row -->
            </div>  <!-- end card body -->
        </div>  <!-- end card -->
     </div>  <!-- end container -->





_END;

}


if($compositionsNotFound && $booksNotFound) {



    echo <<<_END
   
                <div class="col-md-4 pb-4">
                      <h2 class="display-4 text-light" >Bummer!</h2>
                      <h2 class="text-dark">No information about  "$currentPeopleFirst $currentPeopleMiddle $currentPeopleLast $currentPeopleSuffix" was found. <br/><br/></h2>
                      <h4 class="text-light"> Which would you like to do? <br/><br/></h4>
                 <div class="input-group">
                      <form action="peopleSearch.php" method="post">
                        <button class="btn btn-light "  type='button' >Try another $role Search</button> 
                        <input type='hidden' name='bookID' value='$bookID'/>
                        <input type='hidden' name='compositionID' value='$compositionID'/>
                        $sendFindPerson
                      </form><br/>  <!-- end form -->
                  
                
                      <form action='addPeople.php' method='post'> 
                        <input  class="btn btn-light" type='submit' value='Add New $role information'/>
                        <input type='hidden' name='bookID' value='$bookID'/>
                        <input type='hidden' name='compositionID' value='$compositionID'/>       
                      </form><br/><br/>
              
                </div> <!-- end col -->
              </div>  <!-- end row -->
            </div>  <!-- end card body -->
        </div>  <!-- end card -->
     </div>  <!-- end container -->



_END;


}/*end if($compositionsNotFound && booksNotFound)*/













include 'footer.php';
include 'endingBoilerplate.php';

?>