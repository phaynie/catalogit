<?php

/*Not current. See peopleSearch.php*/
include 'boilerplate.php';

if($debug) {
    echo <<<_END

    <h3>composerSearch-18</h3>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';
$composerID = $_POST['composerID'];
$bookID = $_POST['bookID'];
$compositionID = $_POST['compositionID'];


if (isset($_POST['compName'])) {
    /* A-  Clean up the values sent in the post array from the composition form (addComposition) minus Keysig, genre, instrument they are arrays and will be handled in a bit*/
            

    $washPostVar = cleanup_post($_POST['compName']);
    $compName = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['opus']);
    $opusLike = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['opusNum']);
    $compNum = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['compNum']);
    $compNo = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['subTitle']);
    $subTitle = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['bookID']);
    $bookID = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['mvmnt']);
    $movement = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['postEraID']);
    $eraID = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['postVoiceID']);
    $voiceID = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['postEnsembleID']);
    $ensembleID = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['postASPDiffID']);
    $diffASPID = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['postGenDiffID']);
    $diffGenID = strip_before_insert($conn, $washPostVar);


/*B- Insert records into tables referenced in the compositions table by foreign keys to capture the ids we will need.
We won't actually be entering any information into these tables this time, because the post values were id's and so we don't need to capture the ids we already have them. */


/*C-  Now that we have all our ids and the post values are washed, Create a query to insert information into the compositions table then grab the composition ID and store it into a variable.*/

$querycomp    = <<<_END
      INSERT INTO compositions (comp_name, opus_like, comp_num, comp_no, parent_comp_ID, subtitle, book_ID, movement, era_ID, voice_ID, ensemble_ID) 
      VALUES
      ('$compName', '$opusLike', '$compNum', '$compNo', NULL, '$subTitle', '$bookID', '$movement', '$eraID', '$voiceID', '$ensembleID');

_END;

    /*Send the query to the database*/
    $resultcomp   = $conn->query($querycomp);
    /*Here is where I collect my compositionID for later*/
    $compositionID = $conn->insert_id;

if($debug) {
    if (!$resultcomp) echo("Error description resultcomp: " . mysqli_error($conn));
}/*end debug*/

    if ($resultcomp) {

/*These help me see what was actually sent to the server and if I, in fact, have a composition ID. They will be commented out once I am sure the page is working.*/
        if($debug) {
            echo 'querycomp = ' . $querycomp . '<br/><br/>';
            echo 'compositionID = ' . $compositionID . '<br/>';
        }/*end debug*/

    } /*end if resultcomp*/


  




/*D-  This is where the arrays should be looped through. Keysignature, Genres, Instruments
Purpose of foreach loop:
   -separate each value
   -wash each value for security purposes
   -store each value in a variable
   -insert each value into its junction table, using the compositionID we grabbed earlier, as a connection to the compositions table
   -create comma separated lists
   Do this for C2K, C2G, C2I.*/


/*Insert for C2K*/

if(!empty($_POST['postKeySigID'])) {
  $keySigArray = $_POST['postKeySigID'];
  /*This will insert keysigs from form into database*/
  /*now I have an array of keysignature ids loop through an array of ks arrays and insert each keysignature Ids*/
 
  foreach($keySigArray as $sigVal){
    /*washes the sigval value*/
    $keySigID = htmlspecialchars($sigVal);
    
    $keySigQuery = <<<_END
    INSERT INTO C2K (composition_ID, keysig_ID)
    VALUES ($compositionID, $sigVal);

_END;

    $resultkeySigArray = $conn->query($keySigQuery);
      if($debug) {
          echo 'keySigQuery =' . $keySigQuery . '<br/>';
          echo 'sigVal =' . $sigVal . '<br/>';

          if (!$resultkeySigArray) echo("Error description resultkeySigArray: " . mysqli_error($conn));
      }/*end debug*/

    if ($resultkeySigArray) {
   
    } /*end if resultkeysigarray*/
  } /*end foreach sigval*/
}/*end if !empty postkeysigId*/
    /*echo $displayKeySigString;
    
 /*Insert for C2G*/

if(!empty($_POST['postGenreID'])) {
  $genreArray = $_POST['postGenreID'];
  /*This will insert Genres from form into database*/
  /*now that I have an array of Genre ids, loop through an array of genres and insert each genre Id*/
 
  foreach($genreArray as $genreVal){
    /*washes the genreVal value*/
    $genreID = htmlspecialchars($genreVal);
    
    $genreQuery = <<<_END
    INSERT INTO C2G (composition_ID, genre_ID)
    VALUES ($compositionID, $genreVal);

_END;
    $resultGenreArray = $conn->query($genreQuery);
      if($debug) {
          echo 'genreQuery =' . $genreQuery . '<br/>';
          echo 'genreVal =' . $genreVal . '<br/>';

          if (!$resultGenreArray) echo("Error description resultGenreArray: " . mysqli_error($conn));
      }/*end debug*/

    if ($resultGenreArray) {
    
    } /*end if resultGenrearray*/
  } /*end foreach genreval*/
}/*end if !empty postGenreId*/
  
       

       /*Insert for C2I*/

if(!empty($_POST['postInstrumentID'])) {
  $InstrumentArray = $_POST['postInstrumentID'];
  /*This will insert Instruments from form into database*/
  /*now that I have an array of Instrument ids, loop through an array of instruments and insert each instrument Id*/
 
  foreach($InstrumentArray as $instrumentVal){
    /*washes the instrumentVal value*/
    $InstrumentID = htmlspecialchars($instrumentVal);
    
    $instrumentQuery = <<<_END
    INSERT INTO C2I (composition_ID, instrument_ID)
    VALUES ($compositionID, $instrumentVal);

_END;
    $resultInstrumentArray = $conn->query($instrumentQuery);
      if($debug) {
          echo 'instrumentQuery=' . $instrumentQuery . '<br/>';
          echo 'instrumentVal =' . $instrumentVal . '<br/>';

          if (!$resultInstrumentArray) echo("Error description resultInstrumentArray: " . mysqli_error($conn));
      }/*end debug*/

    if ($resultInstrumentArray) {
    
    } /*end if resultInstrumentarray*/
  } /*end foreach instrumentval*/
}/*end if !empty postInstrumentId*/
    

    

/* E-Insert into remaining junction tables using our composition ID we obtained earlier*/
if(!empty($_POST['postASPDiffID'])) {
 
  /*This will insert the ASP difficulty from form into database*/
 
    /*washes the ASP difficulty value*/
    $ASPDiffID = htmlspecialchars($postASPDiffID);
    
    $ASPDiffInsertQuery = <<<_END

    INSERT INTO C2D (composition_ID, difficulty_ID)
    VALUES ($compositionID, $diffASPID);

_END;

    $resultASPDiffInsertQuery = $conn->query($ASPDiffInsertQuery);

    if($debug) {
        echo 'ASPDiffInsertQuery =' . $ASPDiffInsertQuery . '<br/>';
        if (!$resultASPDiffInsertQuery) echo("Error description resultASPDiffInsertQuery: " . mysqli_error($conn));
    }/*end debug*/

    if ($resultASPDiffInsertQuery) {

        if($debug) {
            echo 'ASP difficulty successfully Inserted<br/>';
        }/*end debug*/
    
    } /*end if resultASPDiffInsertQuery*/
  
}/*end if !empty postASPDiffID*/
    

if(!empty($_POST['postGenDiffID'])) {
 
  /*This will insert the ASP difficulty from form into database*/
 
    /*washes the ASP difficulty value*/
    $GenDiffID = htmlspecialchars($postGenDiffID);
    
    $GendiffInsertQuery = <<<_END

    INSERT INTO C2D (composition_ID, difficulty_ID)
    VALUES ($compositionID, $diffGenID);

_END;

    $resultGenDiffInsertQuery = $conn->query($GendiffInsertQuery);

    if($debug) {
        echo 'GendiffInsertQuery =' . $GendiffInsertQuery . '<br/>';
        if (!$resultGenDiffInsertQuery) echo("Error description resultGenDiffInsertQuery: " . mysqli_error($conn));
    }/*end debug*/

    if ($resultGenDiffInsertQuery) {
        if($debug) {
            echo 'Gen difficulty successfully Inserted';
        }/*end debug*/
    
    } /*end if resultGenDiffInsertQuery*/
  
}/*end if !empty postGenDiffID*/

if($debug) {
    echo 'querycomp = ' . $querycomp . '<br/><br/>';
    echo 'compositionID = ' . $compositionID . '<br/>';
}/*end debug*/


  
/*F-  Retrieve Information to display First from junction tables. Store each in a variable.*/
/*keeping this for the time being so I won't have to re-write the code if I need it*/
  
/*will need to insert into the difficulties table too*/
/*will need to insert into C2B so I can connect the book and the composition?*/

   
    /*Now go right back and get the book information we just inserted by creating a Select statement*/
    /*Why is this not if(!result) echo "INSERT failed <br><br>"; like the original code?*/
   
    /*Don't need the lyricist or arranger info yet*/




 

/*Retrieving all key signatures for this composition
I will also be creating a comma separated list to use in the displayed information*/
if($debug) {
    echo 'Test 1' . '<br/>';
}/*end debug*/

$keySigQuery = <<<_END
        SELECT  k.key_name
        FROM C2K
        LEFT JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
        WHERE C2K.composition_ID = $compositionID;

_END;

 $resultKeySigQuery = $conn->query($keySigQuery);

if($debug) {
    echo '$keySigQuery = ' . $keySigQuery . '<br/><br/>';
    if (!$resultKeySigQuery) echo("\n Error description keySigQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

         if ($resultKeySigQuery) {

        $numberOfRows = $resultKeySigQuery->num_rows;
/*Build comma separated list of key signatures in a string*/

        $keySignatureString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultKeySigQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

            
            $keySigName = ($row[0]);

            $keySignatureString .= $keySigName .", ";
            
          } /*for loop ending*/

/*$keySigString = implode(',',$sigVal);*/
 
    
} /*End if result kesig query*/

$displayKeySigString = rtrim($keySignatureString,', ');




/*Retrieving all key genres for this composition
I will also be creating a comma separated list to use in the displayed information*/
$genresQuery = <<<_END

        SELECT  g.genre_type
        FROM C2G 
        LEFT JOIN genres AS g ON C2G.genre_ID = g.ID
        WHERE C2G.composition_ID = $compositionID;


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

           
            $genreName = ($row[0]);

            $genreString .= $genreName .", ";
            
          } /*for loop ending*/



    
} /*End if result kesig query*/

$displayGenreString = rtrim($genreString,', ');






/*Retrieving all instruments for this composition
I will also be creating a comma separated list to use in the displayed information*/
$instrumentQuery = <<<_END
      SELECT  i.instr_name
      FROM C2I 
      LEFT JOIN instruments AS i ON C2I.instrument_ID = i.ID
      WHERE C2I.composition_ID = $compositionID;


_END;

 $resultInstrumentQuery = $conn->query($instrumentQuery);

 if($debug) {
     echo '$instrumentQuery = ' . $instrumentQuery . '<br/><br/>';
     if (!$resultInstrumentQuery) echo("\n Error description instrumentQuery: " . mysqli_error($conn) . "\n<br/>");
 }/*end debug*/

         if ($resultInstrumentQuery) {

        $numberOfRows = $resultInstrumentQuery->num_rows;
/*Build comma separated list of instruments in a string*/
        $instrumentString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultInstrumentQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

          
            $instrumentName = ($row[0]);
            
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
      WHERE C2D.composition_ID = $compositionID;


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
           
            $GenDiffName = ($row[0]);
            
          } /*for loop ending*/
    
} /*End if result select gendiff query*/


/*Retrieving the ASP difficulty for this composition*/

$ASPDiffQuery = <<<_END
      SELECT  d.difficulty_level
      FROM compositions AS c 
      LEFT JOIN C2D ON c.ID = C2D.composition_ID
      LEFT JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
      JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'ASP'
      WHERE C2D.composition_ID = $compositionID;

_END;

 $resultASPDiffQuery = $conn->query($ASPDiffQuery);

if($debug) {
    echo '$ASPDiffQuery = ' . $ASPDiffQuery . '<br/><br/>';
    if (!$resultASPDiffQuery) echo("\n Error description ASPDiffQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

         if ($resultASPDiffQuery) {

            $ASPNumberOfRows = $resultASPDiffQuery->num_rows;


        for ($j = 0 ; $j < $ASPNumberOfRows ; ++$j)
          {
            $row = $resultASPDiffQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/

           
            $ASPDiffName = ($row[0]);
            
          } /*for loop ending*/
    
    } /*End if result select ASPdiff query*/

} /*End if isset post compname*/








if($debug) {
    echo 'Test 1 <br/>';
    echo 'bookID = ' . $bookID . '<br/>';
}/*end debug*/


/*G- Retrieve book and Composition information to display in browser.
1- Book Information
2- Composition information minus the composer, Arranger, or Lyricist*/

if(empty($bookID)){
  $bookID = $_SESSION['bookID'];
}
        $bookQuery = <<<_END

        SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, p.firstname, p.middlename, p.lastname, p.suffix, org_pub.org_name, org_pub.location
           FROM books AS b
           LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
           LEFT JOIN roles AS r_ed ON B2R2P.role_ID = r_ed.ID AND r_ed.role_name = 'Editor'
           LEFT JOIN people AS p ON B2R2P.people_ID = p.ID
           
           LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
           LEFT JOIN roles AS r_pub ON B2R2O.role_ID = r_pub.ID AND r_pub.role_name = 'Publisher'
           LEFT JOIN organizations AS org_pub ON B2R2O.org_ID = org_pub.ID              

            WHERE b.ID = $bookID; 

_END;

      $resultBookQuery = $conn->query($bookQuery);

if($debug) {
    echo 'bookQuery = ' . $bookQuery . '<br/><br/>';

    if (!$resultBookQuery) echo("\n Error description bookQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

         if ($resultBookQuery) {     

        $numberOfRows = $resultBookQuery->num_rows;

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
          {
            $row = $resultBookQuery->fetch_array(MYSQLI_NUM);

           /* var_dump ($row);*/
        /*We do not need to sanitze these*/
            $bookID = ($row[0]);
            $bookTitle = ($row[1]);
            $bookTag1 = ($row[2]);
            $bookTag2 = ($row[3]);
            $bookVolume = ($row[4]);
            $bookNumber = ($row[5]);
            $editorFirstName = ($row[6]);
            $editorMiddleName= ($row[7]);
            $editorLastName = ($row[8]);
            $editorSuffix = ($row[9]);
            $publisherName = ($row[10]);
            $publisherLocation = ($row[11]);
          }/*end for loop*/
} /*End if resultBookQuery*/

if(empty($compositionID)){
  $compositionID = $_SESSION['compositionID'];
}

       $compositionQuery = <<<_END
        SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, c.movement, e.description,v.voicing_type, ens.ensemble_type, c.book_ID
        FROM compositions AS c
        LEFT JOIN eras AS e ON c.era_ID = e.ID
        LEFT JOIN voicing AS v ON c.voice_ID = v.ID
        LEFT JOIN ensembles AS ens ON c.ensemble_ID = ens.ID
        LEFT JOIN books AS b ON c.book_ID = b.ID

        WHERE c.ID = $compositionID;

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
           
          } /*for loop ending*/

/* H- Display Book information and Composition info Using HTML*/
    echo <<<_END

          <div class="container-fluid bg-light pt-4 pb-4">
            <h3 class="display-4 pb-3">So Far so good!</h3>
                <h3 class=" pb-4">This composition information was added successfully!</h3>
          </div> <!-- end container -->

          <div class="container-fluid bg-light pt-4 pb-5">
            <div class="row">
                <div class="col-md-6 pb-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h3>Book Info</h3>
                            Book Title: $bookTitle <br/>
                            Tag 1: $bookTag1 <br/>
                            Tag 2: $bookTag2 <br/>
                            Book Volume: $bookVolume <br/>
                            Book Number: $bookNumber <br/>
                            Book Editor name: $editorFirstName $editoryMiddleName $editorLastName $editorSuffix<br/>
                            Book Publisher: $publisherName<br/>
                            Publisher Location: $publisherLocation<br/>
                        </div> <!-- card -->
                    </div> <!-- card-body -->
                </div> <!-- end col -->

                <div class="col-md-6 pb-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h3>Composition Info</h3>
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
                            General difficulty: Gen $GenDiffName  (ASP $ASPDiffName) <br/>
                            ASP difficulty: ASP $ASPDiffName (Gen $GenDiffName)  <br/>
                        </div> <!-- card -->
                    </div> <!-- card-body -->
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- end container -->


_END;
    
} /*End If $resultcomposition query*/

/* I- Display form with text box for composer’s last name and Button “Search for this composer”
And Pass hidden values needed for next page.*/

echo<<<_END
<div class="container-fluid bg-light pt-4 pb-5">
    <div class="col-md-6">
        <h3 class="display-4">Let's Continue...</h3>
        <h5>Enter Composer's LAST NAME only</h5>
        <form action='composerOptions.php' method='post'>

_END;

        if(isset($_SESSION['composerSearch_validationFailed'])) {
            echo<<<_END

            <span class="error">{$_SESSION['searchComposerLastNameErr']}</span>
            <input class="form-control" type="text" name="searchComposerLastName"/>
            <h3 class="display-4">Is there a Second Composer?...</h3>
            <h5>Enter second Composer's LAST NAME only or leave blank</h5>
            <span class="error">{$_SESSION['searchComposerLastNameErr2']}</span>
            <input class="form-control" type="text" name="searchComposerLastName2"/>
 
            <input class="btn btn-secondary mt-4" type='submit' value='Search for the composer(s)'/><br/>
            <span>* If there is no composer type "No Composer" and choose that as an option. </span>
            
            <input type='hidden' name="bookID" value='{$_SESSION['bookID']}'/>
            <input type='hidden' name="compositionID" value='{$_SESSION['compositionID']}'/>

_END;

        }else{

            echo<<<_END
    
            <input class="form-control" type="text" name="searchComposerLastName"/>
            <h5 >Is there a Second Composer?...</h5>
            <h5>Enter second Composer's LAST NAME only or leave blank</h5>
            <input class="form-control" type="text" name="searchComposerLastName2"/>
            <input class="btn btn-secondary mt-4" type='submit' value='Search for the composer(s)'/><br/>
            <span>* If there is no composer type "No Composer" and choose that as an option. </span>
            <input type='hidden' name="bookID" value='$bookID'/>
            <input type='hidden' name="compositionID" value='$compositionID'/>
          
_END;

}/*end if composerSearch_validationfailed*/



echo<<<_END


        </form>
    </div> <!-- end col -->
</div> <!-- end container -->

_END;
        



 /*destroy session variables*/
 unset($_SESSION['searchComposerLastNameErr']);
 unset($_SESSION['searchComposerLastNameErr2']);
 unset($_SESSION['composerSearch_validationFailed']);
 unset($_SESSION['composerSearch_searchComposerLastName_value']);
 unset($_SESSION['composerSearch_searchComposerLastName_value2']);
 unset($_SESSION['compositionID']);
 unset($_SESSION['bookID']);


include 'footer.html';


include 'endingBoilerplate.php';




?>




