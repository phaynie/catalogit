<?php
include 'boilerplate.php';
/*Most current addComposition page*/

$debug_string = "";


if($debug) {

$debug_string .= "<p>addComposition2.php-13</p>\n";
/*TODO I should encase all the other echos in quotes and debug_string. Just not sure how to do that without errors on the more complicated strings*/
//echo <<<_END
//
//<p>addComposition2.php-13</p>
//
//_END;

}/*end debug*/

include 'beginningNav.php';

/*Initialize variables holding values from previous page*/
$submit = "";
$compositionID = "";
$oldCompositionID = "";
$editComposition = "";
$addNewComposition = "";
$bookID = "";


/*Initialize local Variables */

$compName = "";
$opus = "";
$opusNum = "";
$compNum = "";
$subTitle = "";
$movement = "";

$keySigs = array();
$genres = array();
$instruments = array();
/*todo should these be arrays too?*/
$era = "";
$voice = "";
$ensemble = "";
$genDiff = "";
$ASPDiff = "";
$physCompositionLocNote = "";





/*Initialize form error variables*/

$compNameErr = "";
$keySigsErr = "";
$genresErr = "";
$instrumentsErr = "";
$eraErr = "";
$voiceErr = "";
$ensembleErr = "";
$genDiffErr = "";
$ASPDiffErr = "";



/*End initializing variables*/
/*if($opusNum == "NULL") {
    $opusNum = "";
}

if($compNum == "NULL") {
    $compNum = "";
}

if($era == "NULL") {
    $era = "";
}

if($voice == "NULL") {
    $voice = "";
}

if($ensemble == "NULL") {
    $ensemble = "";
}*/

/*assign local variables to values from Request array (from previous page)*/

if (isset($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if (isset($_REQUEST['submit'])) {
    $submit = $_REQUEST['submit'];
}

if (isset($_REQUEST['compositionID'])) {
    $compositionID = $_REQUEST['compositionID'];
}

if (isset($_REQUEST['oldCompositionID'])) {
    $oldCompositionID = $_REQUEST['oldCompositionID'];
}

if (isset($_REQUEST['editComposition'])) {
    $editComposition = $_REQUEST['editComposition'];
}

if (isset($_REQUEST['addNewComposition'])) {
    $addNewComposition = $_REQUEST['addNewComposition'];
}

if (isset($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if (isset($_REQUEST['physCompositionLocNote'])) {
    $physCompositionLocNote = $_REQUEST['physCompositionLocNote'];
}


/*assigning variable names to other situations*/

if ($editComposition == 'true') {
    $sendEditComposition = "<input type='hidden' name='editComposition' value= 'true' />";
}

if ($addNewComposition == 'true') {
    $sendAddNewComposition = "<input type='hidden' name='addNewComposition' value= 'true' />";
}







/*save Request values to local 'submission' vars*/
if($submit == 'true') {


    if (isset($_REQUEST['compName'])) {
        $compName = $_REQUEST['compName'];
    }

    if (isset($_REQUEST['opus'])) {
        $opus = $_REQUEST['opus'];
    }


    if (isset($_REQUEST['opusNum']) && $_REQUEST['opusNum'] !== "" ) {
        $opusNum = $_REQUEST['opusNum'];
    }

    if (isset($_REQUEST['compNum']) && $_REQUEST['compNum'] !== "" ) {
        $compNum = $_REQUEST['compNum'];
    }

    if (isset($_REQUEST['subTitle'])) {
        $subTitle = $_REQUEST['subTitle'];
    }

    if (isset($_REQUEST['movement'])) {
        $movement = $_REQUEST['movement'];
    }


    if (isset($_REQUEST['keySigs'])) {
        $keySigs = $_REQUEST['keySigs'];
    }

    if (isset($_REQUEST['genres'])) {
        $genres = $_REQUEST['genres'];
    }

    if (isset($_REQUEST['instruments'])) {
        $instruments = $_REQUEST['instruments'];
    }

    if (isset($_REQUEST['era'])) {
        $era = $_REQUEST['era'];
    }

    if (isset($_REQUEST['voice'])) {
        $voice = $_REQUEST['voice'];
    }

    if (isset($_REQUEST['ensemble'])) {
        $ensemble = $_REQUEST['ensemble'];
    }

    if (isset($_REQUEST['genDiff'])) {
        $genDiff = $_REQUEST['genDiff'];
    }

    if (isset($_REQUEST['ASPDiff'])) {
        $ASPDiff = $_REQUEST['ASPDiff'];
    }



    $validationFailed = false;


    /*VALIDATION*/
    /*validate local submission vars*/
    /*(count($compName) == 0 )*/


    if($compName == "") {
        $compNameErr = "<span class='error'>  * Name of Composition is required </span>";
        $validationFailed = true;
    }/*end if(count($compName) == 0 )*/

    if($opusNum !== "" && !is_numeric($opusNum)) {
        $opusNumErr = "<span class='error'>  * Must be empty or a number </span>";
        $validationFailed = true;
    }/*end if(count($compName) == 0 )*/

    if($compNum !== "" && !is_numeric($compNum)) {
        $compNumErr = "<span class='error'>  * Must be empty or a number </span>";
        $validationFailed = true;
    }/*end if(count($compName) == 0 )*/

    /*add check box validations here*/
    /*if checkbox validation fails, set checkbox error message and validationFailed = true*/


    if(count($keySigs) == 0 ) {
        /*if 0, then no checkboxes checked*/
        $keySigsErr = "<span class='error'>  * At least one box must be checked </span>";
        $validationFailed = true;
    }/*end (count($keySigs) == 0 )*/

    if(count($genres) == 0 ) {
        /*if 0, then no checkboxes checked*/
        $genresErr = "<span class='error'>  * At least one box must be checked </span>";
        $validationFailed = true;
    }/*end if(count($genres) == 0 )*/

    if(count($instruments) == 0 ) {
        /*if 0, then no checkboxes checked*/
        $instrumentsErr = "<span class='error'>  * At least one box must be checked </span>";
        $validationFailed = true;
    }/*end if(count($instruments) == 0 )*/

    if(count($era) == 0 ) {
        $eraErr = "<span class='error'>  * One item must be selected </span>";
        $validationFailed = true;
    }/*end if(count($era) == 0 )*/

    if(count($voice) == 0 ) {
        $voiceErr = "<span class='error'>  * One item must be selected </span>";
        $validationFailed = true;
    }/*end if(count($voice) == 0 )*/

    if(count($ensemble) == 0 ) {
        $ensembleErr = "<span class='error'>  * One item must be selected </span>";
        $validationFailed = true;
    }/*end if(count($ensemble) == 0 )*/

    if(count($genDiff) == 0 ) {
        $genDiffErr = "<span class='error'> * One item must be selected </span>";
        $validationFailed = true;
    }/*end if(count($genDiff) == 0 )*/

    if(count($ASPDiffErr) == 0 ) {
        $ASPDiffErr = "<span class='error'>  * One item must be selected </span>";
        $validationFailed = true;
    }/*end if(count($ASPDiffErr) == 0 )*/





    /*Validation successful!
    Here we wash all values that come from the form*/
    /*if all values validate successfully...)*/
    if (!$validationFailed)

    {

        $washPostVar = cleanup_post($compName);
        $compName = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($opus);
        $opus = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($opusNum);
        $opusNum = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($compNum);
        $compNum = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($subTitle);
        $subTitle = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($movement);
        $movement = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($physCompositionLocNote);
        $physCompositionLocNote = strip_before_insert($conn, $washPostVar);

        foreach($keySigs as &$value) {
            $washPostVar = cleanup_post($value);
            $value = strip_before_insert($conn, $washPostVar);
        }
        unset($value);

        foreach($genres as &$value) {
            $washPostVar = cleanup_post($value);
            $value = strip_before_insert($conn, $washPostVar);
        }
        unset($value);

        foreach($instruments as &$value) {
            $washPostVar = cleanup_post($value);
            $value = strip_before_insert($conn, $washPostVar);
        }
        unset($value);

        $washPostVar = cleanup_post($era);
        $era = strip_before_insert($conn, $washPostVar);

        /*Why are'nt we washing book_Id ? Not submitted by user? */

        $washPostVar = cleanup_post($voice);
        $voice = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($ensemble);
        $ensemble = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($genDiff);
        $genDiff = strip_before_insert($conn, $washPostVar);

        $washPostVar = cleanup_post($ASPDiff);
        $ASPDiff = strip_before_insert($conn, $washPostVar);





    /*save submission variables to DB*/

    if($editComposition == 'true') {
        $updateCompositions = "UPDATE compositions AS c SET ";

        $updateCompositions .= "c.comp_name='$compName', ";

        if($opus =="") {
            $updateCompositions .= "c.opus_like=NULL, ";
        }
        else{
            $updateCompositions .= "c.opus_like='$opus', ";
        }

        if($opusNum =="") {
            $updateCompositions .= "c.comp_num=NULL, ";
        }
        else{
            $updateCompositions .= "c.comp_num=$opusNum, ";
        }

        if($compNum =="") {
            $updateCompositions .= "c.comp_no=NULL, ";
        }
        else{
            $updateCompositions .= "c.comp_no=$compNum, ";
        }

        if($subTitle =="") {
            $updateCompositions .= "c.subtitle=NULL, ";
        }
        else{
            $updateCompositions .= "c.subtitle='$subTitle', ";
        }

        if($bookID =="") {
            $updateCompositions .= "c.book_ID=NULL, ";
        }
        else{
            $updateCompositions .= "c.book_ID=$bookID, ";
        }

        if($movement =="") {
            $updateCompositions .= "c.movement=NULL, ";
        }
        else{
            $updateCompositions .= "c.movement='$movement', ";
        }

        if($era =="") {
            $updateCompositions .= "c.era_ID=NULL, ";
        }
        else{
            $updateCompositions .= "c.era_ID=$era, ";
        }

        if($voice =="") {
            $updateCompositions .= "c.voice_ID=NULL, ";
        }
        else{
            $updateCompositions .= "c.voice_ID=$voice, ";
        }

        if($ensemble =="") {
            $updateCompositions .= "c.ensemble_ID=NULL, ";
        }
        else{
            $updateCompositions .= "c.ensemble_ID=$ensemble, ";
        }

        if($physCompositionLocNote =="") {
            $updateCompositions .= "c.physCompositionLoc=NULL ";
        }
        else{
            $updateCompositions .= "c.physCompositionLoc='$physCompositionLocNote' ";
        }

            $updateCompositions .= "WHERE c.ID=$compositionID;";
            


    $updateCompositionsResult = $conn->query($updateCompositions);

    if ($debug) {

        $debug_string .= "\nupdateCompositions = " . $updateCompositions . "\n<br/>";
        if (!$updateCompositionsResult) {
            $debug_string .= "\n Error description updateCompositions: " . mysqli_error($conn) . "\n<br/>";
        }
    }/*end debug*/


    /*delete past row(s) from the junction tables C2k, C2Gk, C2I before inserting new row*/


    if ($updateCompositionsResult) {
        /*delete from C2K*/
        $deleteC2K = <<<_END

            DELETE FROM C2K
            WHERE C2K.composition_ID = $compositionID;

_END;

        if ($debug) {
            $debug_string .= " '$deleteC2K = ' . $deleteC2K . '<br/><br/>' ";
        }/*end debug*/

        /*send the query*/
        $deleteC2KResult = $conn->query($deleteC2K);

        if ($debug) {
            if (!$deleteC2KResult) {
                $debug_string .= "\n Error description deleteC2K: " . mysqli_error($conn) . "\n<br/>";
            }
        }/*end debug*/
        /*End deleting from C2K*/


        /*Insert new row into C2K*/


        if (count($keySigs) > 0) {

            foreach ($keySigs as $value) {
                if ($debug) {
                    $debug_string .= " ($keySigs . ' = ' . $value) ";
                }/*end debug*/




                $C2KInsertQuery = <<<_END
                            INSERT INTO C2K (composition_ID, keysig_ID)
                            VALUES ('$compositionID', '$value');

_END;

                if ($debug) {
                    $debug_string .= "('\n C2KInsertQuery= ' . $C2KInsertQuery . '\n<br/>')";
                }/*end debug*/

                /*send query and place result into this variable*/
                $C2KInsertQueryResult = $conn->query($C2KInsertQuery);

                if ($debug) {
                    if (!$C2KInsertQueryResult) {
                        $debug_string .= "\n Error description C2KInsertQuery: " . mysqli_error($conn) . "\n<br/>";
                    }
                }/*end debug*/
            }/*end foreach keySigs Array*/

        }/*end if (count($keySigs) > 0)*/
    } /*End if ($updateCompositionResult)*/


    /*delete from C2G*/
    $deleteC2G = <<<_END

                DELETE FROM C2G
                WHERE C2G.composition_ID  = $compositionID;

_END;

    if ($debug) {
        $debug_string .= " ('deleteC2G = ' . $deleteC2G . '<br/><br/>')";
    }/*end debug*/

    /*send the query*/
    $deleteC2GResult = $conn->query($deleteC2G);

    if ($debug) {
        if (!$deleteC2GResult) {
            $debug_string .= "\n Error description deleteC2G: " . mysqli_error($conn) . "\n<br/>";
        }
    }/*end debug*/

    /*Now, insert into    C2G*/
    /*Here i must go find the id number for each genre entered by the user and insert a row into the C2G table */
    if (count($genres) > 0) {

        foreach ($genres as $value) {
            $C2GInsertQuery = <<<_END
                INSERT INTO C2G (composition_ID, genre_ID)
                VALUES ($compositionID, '$value');

_END;

            if ($debug) {
                $debug_string .= "('\n C2GInsertQuery= ' . $C2GInsertQuery . '\n<br/>')";
            }/*end debug*/

            /*send query and place result into this variable*/
            $C2GInsertQueryResult = $conn->query($C2GInsertQuery);

            if ($debug) {
                if (!$C2GInsertQueryResult) {

                    $debug_string .= "\n Error description C2GInsertQuery: " . mysqli_error($conn) . "\n<br/>";
                }
            }/*end debug*/

        }/*end foreach genres Array*/

    }/*end if (count($genres) > 0)*/


    /*delete from C2I*/

    $deleteC2I = <<<_END

        DELETE FROM C2I
        WHERE C2I.composition_ID = '$compositionID';

_END;

    if ($debug) {
        $debug_string .= "('deleteC2I = ' . $deleteC2I . '<br/><br/>') ";
    }/*end debug*/

    /*send the query*/
    $deleteC2IResult = $conn->query($deleteC2I);

    if ($debug) {
        if (!$deleteC2IResult) {
            $debug_string .= "('\n Error description deleteC2I: ' . mysqli_error($conn) . '\n<br/>')";
        }
    }/*end debug*/
    /*end delete from C2I*/

    /*Now, insert into C2I*/
    /*Here i must go find the id number for each instrument entered by the user and insert a row into the C2I table */
    if (count($instruments) > 0) {

        foreach ($instruments as $value) {
            $C2IInsertQuery = <<<_END
                INSERT INTO C2I (composition_ID, instrument_ID)
                VALUES ('$compositionID', '$value');

_END;

            if ($debug) {
                $debug_string .= "('\n C2IInsertQuery= ' . $C2IInsertQuery . '\n<br/>')";
            }/*end debug*/

            /*send query and place result into this variable*/
            $C2IInsertQueryResult = $conn->query($C2IInsertQuery);

            if ($debug) {
                if (!$C2IInsertQueryResult) {
                    $debug_string .= "\n Error description C2IInsertQuery: " . mysqli_error($conn) . "\n<br/>";
                }
            } /*end debug*/
        } /*end foreach instruments Array*/
    }/* end if (count($instruments) > 0)*/



        /*delete from C2D*/

        $deleteC2D = <<<_END

        DELETE FROM C2D
        WHERE C2D.composition_ID = '$compositionID';

_END;

        if ($debug) {
            $debug_string .= "('deleteC2D = ' . $deleteC2D . '<br/><br/>') ";
        }/*end debug*/

        /*send the query*/
        $deleteC2DResult = $conn->query($deleteC2D);

        if ($debug) {
            if (!$deleteC2DResult) {
                $debug_string .= "('\n Error description deleteC2D: ' . mysqli_error($conn) . '\n<br/>')";
            }
        }/*end debug*/
        /*end delete from C2D*/


        /*Now, insert into C2D the first time for General difficulty*/
        $C2DInsertQuery = <<<_END
 INSERT INTO C2D (composition_ID, difficulty_ID)
 VALUES ('$compositionID', '$genDiff');

_END;

        if($debug) {
            $debug_string .= "\n C2DInsertQuery= " . $C2DInsertQuery . "\n<br/>";
        }/*end debug*/

        /*send query and place result into this variable*/
        $C2DInsertQueryResult = $conn->query($C2DInsertQuery);

        if($debug) {
            if (!$C2DInsertQueryResult) $debug_string .= "\n Error description C2DInsertQuery: " . mysqli_error($conn) . "\n<br/>";
        }/*end debug*/




        /*Now, insert into C2D for a second time for ASP difficulty*/
        $C2DInsertQuery = <<<_END
 INSERT INTO C2D (composition_ID, difficulty_ID)
 VALUES ('$compositionID', '$ASPDiff');

_END;

        if($debug) {
            $debug_string .= "\n C2DInsertQuery= " . $C2DInsertQuery . "\n<br/>";
        }/*end debug*/

        /*send query and place result into this variable*/
        $C2DInsertQueryResult = $conn->query($C2DInsertQuery);

        if($debug) {
            if (!$C2DInsertQueryResult) $debug_string .= "\n Error description C2DInsertQuery: " . mysqli_error($conn) . "\n<br/>";
        }/*end debug*/

















  /*    echo $debug_string;
        exit();*/





        header('Location: editComposition.php?bookID=' . $bookID . '&compositionID=' . $compositionID . '&editComposition=true');
    exit();
         } /*end if editComposition == 'true'*/
    } /*END if (!$validationFailed )*/









if( $addNewComposition == 'true' && $validationFailed == false){
    /*insert into compositions table*/


    $compositionInsertQuery = "INSERT INTO compositions (comp_name, opus_like, comp_num, comp_no, subtitle, book_ID, movement, era_ID, voice_ID, ensemble_ID, physCompositionLoc)
VALUES (";


        $compositionInsertQuery .= "'$compName', ";

        if($opus == "") {
            $compositionInsertQuery .= " NULL, ";
        }
        else{
            $compositionInsertQuery .= "'$opus', ";
        }

        if($opusNum == "") {
            $compositionInsertQuery .= " NULL, ";
        }
        else{
            $compositionInsertQuery .= " $opusNum, ";
        }

        if($compNum == "") {
            $compositionInsertQuery .= " NULL, ";
        }
        else{
            $compositionInsertQuery .= " $compNum, ";
        }

        if($subTitle == "") {
            $compositionInsertQuery .= " NULL, ";
        }
        else{
            $compositionInsertQuery .= " '$subTitle', ";
        }

        if($bookID == "") {
            $compositionInsertQuery .= " NULL, ";
        }
        else{
            $compositionInsertQuery .= " $bookID, ";
        }

        if($movement == "") {
            $compositionInsertQuery .= " NULL, ";
        }
        else{
            $compositionInsertQuery .= " '$movement', ";
        }

        if($era == "") {
            $compositionInsertQuery .= " NULL, ";
        }
        else{
            $compositionInsertQuery .= " $era, ";
        }

        if($voice == "") {
            $compositionInsertQuery .= " NULL, ";
        }
        else{
            $compositionInsertQuery .= " $voice, ";
        }

        if($ensemble == "") {
            $compositionInsertQuery .= " NULL, ";
        }
        else{
            $compositionInsertQuery .= " $ensemble, ";
        }

        if($physCompositionLocNote == "") {
            $compositionInsertQuery .= " NULL )";
        }
        else{
            $compositionInsertQuery .= " '$physCompositionLocNote' )";
        }








    if($debug) {
        $debug_string .= "\n compositionInsertQuery= " . $compositionInsertQuery . "\n<br/>";
    }/*end debug*/

    /*send query and place result into this variable*/
    $compositionInsertQueryResult = $conn->query($compositionInsertQuery);

    if($debug) {
        if (!$compositionInsertQueryResult) $debug_string .= "\n Error description compositionInsertQuery: " . mysqli_error($conn) . "\n<br/>";
    }/*end debug*/

    /*Here I will want to get the composition ID I just created*/
    $compositionID = $conn->insert_id;

    if($debug) {
        $debug_string .=  'compositionID = ' . $compositionID . '<br/>';
    }/*end debug*/

    /*for testing purposes only, I'm creating fake key sig id Array*/
    /*$keySigID = [1, 2, 3];*/




    /*Now, insert into   C2K*/

    /*Here i must go find the id number for each key signature entered by the user and insert a row into the C2K table */
    if(!is_array($keySigs)) {
        if($debug) {
            $debug_string .=  '$keySigID is not an array' . $keySigs;
        }/*end debug*/
    }else{
        foreach ($keySigs as &$value) {
            if($debug) {
                $debug_string .=  $keySigs . " = " . $value;
            }/*end debug*/

            $C2KInsertQuery = <<<_END
        INSERT INTO C2K (composition_ID, keysig_ID)
        VALUES ('$compositionID', '$value');

_END;

            if($debug) {
                $debug_string .= "\n C2KInsertQuery= " . $C2KInsertQuery . "\n<br/>";
            }/*end debug*/

            /*send query and place result into this variable*/
            $C2KInsertQueryResult = $conn->query($C2KInsertQuery);

            if($debug) {
                if (!$C2KInsertQueryResult) $debug_string .= "\n Error description C2KInsertQuery: " . mysqli_error($conn) . "\n<br/>";
            }/*end debug*/
        }/*end foreach keysig Array*/
    }/*end if is array*/




    /*Now, insert into    C2G*/

    /*Here i must go find the id number for each genre entered by the user and insert a row into the C2G table */
    if(!is_array($genres)) {
        if($debug) {
            $debug_string .=  '$keySigID is not an array' . $genres;
        }/*end debug*/
    }else{
        foreach ($genres as &$value) {
            $C2GInsertQuery = <<<_END
    INSERT INTO C2G (composition_ID, genre_ID)
    VALUES ('$compositionID', '$value');

_END;

            if($debug) {
                $debug_string .= "\n C2GInsertQuery= " . $C2GInsertQuery . "\n<br/>";
            }/*end debug*/

            /*send query and place result into this variable*/
            $C2GInsertQueryResult = $conn->query($C2GInsertQuery);

            if($debug) {
                if (!$C2GInsertQueryResult) $debug_string .= "\n Error description C2GInsertQuery: " . mysqli_error($conn) . "\n<br/>";
            }/*end debug*/

        }/*end foreach genre Array*/

    }/*!is_array($keySigID)*/


    /*Now, insert into C2I*/
    /*Here i must go find the id number for each instrument entered by the user and insert a row into the C2I table */
    if(!is_array($instruments)) {
        if($debug) {
            $debug_string .=  '$instrumentID is not an array' . $instruments;
        }/*end debug*/

    }else{
        foreach ($instruments as &$value) {
            $C2IInsertQuery = <<<_END
        INSERT INTO C2I (composition_ID, instrument_ID)
        VALUES ('$compositionID', '$value');

_END;

            if($debug) {
                $debug_string .= "\n C2IInsertQuery= " . $C2IInsertQuery . "\n<br/>";
            }/*end debug*/

            /*send query and place result into this variable*/
            $C2IInsertQueryResult = $conn->query($C2IInsertQuery);

            if($debug) {
                if (!$C2IInsertQueryResult) $debug_string .= "\n Error description C2IInsertQuery: " . mysqli_error($conn) . "\n<br/>";
            }/*end debug*/
        }/*end foreach instrument Array*/
    }/* end instrument is array*/




    /*Now, insert into C2D the first time for General difficulty*/
    $C2DInsertQuery = <<<_END
 INSERT INTO C2D (composition_ID, difficulty_ID)
 VALUES ('$compositionID', '$genDiff');

_END;

    if($debug) {
        $debug_string .= "\n C2DInsertQuery= " . $C2DInsertQuery . "\n<br/>";
    }/*end debug*/

    /*send query and place result into this variable*/
    $C2DInsertQueryResult = $conn->query($C2DInsertQuery);

    if($debug) {
        if (!$C2DInsertQueryResult) $debug_string .= "\n Error description C2DInsertQuery: " . mysqli_error($conn) . "\n<br/>";
    }/*end debug*/




    /*Now, insert into C2D for a second time for ASP difficulty*/
    $C2DInsertQuery = <<<_END
 INSERT INTO C2D (composition_ID, difficulty_ID)
 VALUES ('$compositionID', '$ASPDiff');

_END;

    if($debug) {
        $debug_string .= "\n C2DInsertQuery= " . $C2DInsertQuery . "\n<br/>";
    }/*end debug*/

    /*send query and place result into this variable*/
    $C2DInsertQueryResult = $conn->query($C2DInsertQuery);

    if($debug) {
        if (!$C2DInsertQueryResult) $debug_string .= "\n Error description C2DInsertQuery: " . mysqli_error($conn) . "\n<br/>";
    }/*end debug*/






 /*echo $debug_string;
    exit();*/






    header('Location: editComposition.php?bookID=' . $bookID . '&compositionID=' . $compositionID . '&editComposition=true');
    exit();

    /*add header*/
}/*end if( $addNewComposition == 'true' && $validationFailed == false)*/
} /* end if submit =='true')*/
echo $debug_string;





/*Here we have arrived at the page for the first time and are expecting a pre-populated composition form ready to be edited if wanted*/

if($submit == "" && $editComposition == 'true'){
/*get form Values from DB*/
    /*Retrieving all key signatures for this composition
    I will also be creating a comma separated list to use in the displayed information*/
    $keySigsQuery = <<<_END
      SELECT  k.ID
      FROM C2K
      LEFT JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
      WHERE C2K.composition_ID = '$compositionID';

_END;

    $resultKeySigsQuery = $conn->query($keySigsQuery);
    if($debug) {
        echo '$keySigsQuery = ' . $keySigsQuery . '<br/><br/>';
        if (!$resultKeySigsQuery) echo("\n Error description $keySigsQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    if ($resultKeySigsQuery) {

        $numberOfRows = $resultKeySigsQuery->num_rows;
        /*Build comma separated list of key signatures in a string*/

        $keySignatureString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
        {
            $row = $resultKeySigsQuery->fetch_array(MYSQLI_NUM);

            /* var_dump ($row);*/
            array_push($keySigs, strval($row[0]));

            $keySignatureString .= $keySigs .", ";

        } /*for loop ending*/




    } /*End if result keysigs query*/

    $displayKeySigsString = rtrim($keySignatureString,', ');




    /*Retrieving all  genres for this composition
    I will also be creating a comma separated list to use in the displayed information*/
    $genresQuery = <<<_END

        SELECT  g.ID
        FROM C2G 
        LEFT JOIN genres AS g ON C2G.genre_ID = g.ID
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

        $genresString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
        {
            $row = $resultGenresQuery->fetch_array(MYSQLI_NUM);

            /* var_dump ($row);*/
            array_push($genres, strval($row[0]));


            $genresString .= $genres .", ";

        } /*for loop ending*/

    } /*End if result genres query*/

    $displayGenresString = rtrim($genresString,', ');





    /*Retrieving all instruments for this composition
    I will also be creating a comma separated list to use in the displayed information*/
    $instrumentsQuery = <<<_END
      SELECT  i.ID
      FROM C2I 
      LEFT JOIN instruments AS i ON C2I.instrument_ID = i.ID
      WHERE C2I.composition_ID = '$compositionID';


_END;

    $resultInstrumentsQuery = $conn->query($instrumentsQuery);
    if($debug) {
        echo '$instrumentsQuery = ' . $instrumentsQuery . '<br/><br/>';
        if (!$resultInstrumentsQuery) echo ("\n Error description instrumentsQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    if ($resultInstrumentsQuery) {

        $numberOfRows = $resultInstrumentsQuery->num_rows;
        /*Build comma separated list of instruments in a string*/
        $instrumentsString= "";

        for ($j = 0 ; $j < $numberOfRows ; ++$j)
        {
            $row = $resultInstrumentsQuery->fetch_array(MYSQLI_NUM);

            /* var_dump ($row);*/

            array_push($instruments, strval($row[0]));

            $instrumentsString .= $instruments .", ";

        } /*for loop ending*/



    } /*End if result instruments query*/

    $displayInstrumentsString = rtrim($instrumentsString,', ');







    /*Retrieving the General difficulty for this composition*/

    $genDiffQuery = <<<_END
      SELECT  d.ID
      FROM compositions AS c 
      LEFT JOIN C2D ON c.ID = C2D.composition_ID
      LEFT JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
      JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'General'
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

            $genDiff = $row[0];

        } /*for loop ending*/

    } /*End if result select gendiff query*/





    /*Retrieving the ASP difficulty for this composition*/

    $ASPDiffQuery = <<<_END
      SELECT  d.ID
      FROM compositions AS c 
      LEFT JOIN C2D ON c.ID = C2D.composition_ID
      LEFT JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
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

            $ASPDiff = $row[0];


        } /*for loop ending*/

    } /*End if result select ASPDiff query*/


    $compositionQuery = <<<_END
        SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, c.movement, c.era_ID,c.voice_ID, c.ensemble_ID, c.book_ID, c.physCompositionLoc 
        FROM compositions AS c
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

            $compositionID = $row[0];
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


}/*End if($submit == "" && $editComposition == 'true')*/

/*Add new info situation


/*generate form to be used in every situation*/

/*HTML  form*/

/*THis is the first three text boxes in the add composition form*/


if($opusNum == 'NULL') {
    $opusNum = "";
}
?>


<div class="container-fluid bg-light pt-4 ">
 <h2 class="pb-4" >Add Composition Information below</h2>
  <form class="pb-4" action='addComposition2.php' method='post'>
   

  <div class="row">
    <div class="col-md-6">
      <div class="card  mb-3">
        <div class="card-body bg-light">   
        <div class="form-group">

            <label for="compositionName">Composition Name: <?php echo $compNameErr ?></label>
            <input type="text" class="form-control" id="compositionName" name="compName" value="<?php echo $compName ?>" /><br/>

            <label for="opusLike">Opus-Like:  </label>
            <input type="text" class="form-control" id="opusLike" name="opus" value="<?php echo $opus ?>"/><br/>

            <label for="opusNum">Opus No.:<?php echo $opusNumErr ?> </label>
            <input type="text" class="form-control" id="opusNum" name="opusNum" value="<?php echo $opusNum ?>"/><br/>



           </div> <!-- end form-group -->
        </div> <!-- end card-body -->
     </div> <!-- end card -->
  </div> <!-- end col -->
  
 
  <div class="col-md-6">
    <div class="card mb-3">
      <div class="card-body bg-light">   
        <div class="form-group">


<!-- This is the second three text boxes in the add composition form -->


                <label for="compositionNum">Composition No.:<?php echo $compNumErr ?> </label>
                <input type="number" class="form-control" id="compositionNum" name="compNum" min="0" value="<?php echo $compNum ?>"/><br/>

                <label for="subTitle">Subtitle: </label> 
                <input type="text" class="form-control" id="subTitle" name="subTitle" value="<?php echo $subTitle ?>"/><br/>

                <label for="mvmnt">Movement: </label>
                <input type="text" class="form-control" id="mvmnt" name="movement" value="<?php echo $movement ?>"/><br/>


          </div> <!-- end form-group -->
        </div> <!-- end card-body -->
      </div> <!-- end card -->
    </div> <!-- end col -->
  </div> <!-- end row -->
    

<!-- >keySigs checkboxes -->


<div class="row">
  <div class="col-md-4">     
    <div class="card mb-3">
      <div class="card-body bg-light">

            <h6>Key Signature: choose as many as apply</h6>
            <?php echo $keySigsErr ?>

            <div class="form-check">   
                <input type="checkbox" class="form-check-input" id="chk1" name="keySigs[]" value="1" <?php if (in_array( "1", $keySigs)) {echo("checked");}?>>  none<br>
                <label class="form-check-label sr-only" for="chk1"></label>
            </div> <!-- end form-check -->

            <div class="form-check"> 
                <input type="checkbox" class="form-check-input" id="chk2" name="keySigs[]" value="2" <?php if (in_array( "2", $keySigs)) {echo("checked");}?>>  C Major<br>
                <label class="form-check-label sr-only" for="chk2"></label>
            </div> <!-- end form-check -->

            <div class="form-check"> 
                <input type="checkbox" class="form-check-input"  id="chk3" name="keySigs[]" value="3" <?php if (in_array( "3", $keySigs)) {echo("checked");}?>>  G Major<br>
                <label class="form-check-label sr-only" for="chk3"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox" class="form-check-input"  id="chk4" name="keySigs[]" value="4" <?php if (in_array( "4", $keySigs)) {echo("checked");}?>>  D Major<br>
                <label class="form-check-label sr-only" for="chk4"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk5" name="keySigs[]" value="5" <?php if (in_array( "5", $keySigs)) {echo("checked");}?>>  A Major<br>
                <label class="form-check-label sr-only" for="chk5"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk6" name="keySigs[]" value="6" <?php if (in_array( "6", $keySigs)) {echo("checked");}?>>  E Major<br>
                <label class="form-check-label sr-only" for="chk6"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk7" name="keySigs[]" value="7" <?php if (in_array( "7", $keySigs)) {echo("checked");}?>>  B Major<br>
                <label class="form-check-label sr-only" for="chk7"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk8" name="keySigs[]" value="8" <?php if (in_array( "8", $keySigs)) {echo("checked");}?>>  Gb Major<br>
                <label class="form-check-label sr-only" for="chk8"></label>
            </div> <!-- end form-check -->

            <div class="form-check">  
                <input type="checkbox"  class="form-check-input"  id="chk9" name="keySigs[]" value="9" <?php if (in_array( "9", $keySigs)) {echo("checked");}?>>  Db Major<br>
                <label class="form-check-label sr-only" for="chk9"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk10" name="keySigs[]" value="10" <?php if (in_array( "10", $keySigs)) {echo("checked");}?>>  Ab Major<br>
                <label class="form-check-label sr-only" for="chk10"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk11" name="keySigs[]" value="11" <?php if (in_array( "11", $keySigs)) {echo("checked");}?>>  Eb Major<br>
                <label class="form-check-label sr-only" for="chk11"></label>
             </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk12" name="keySigs[]" value="12" <?php if (in_array( "12", $keySigs)) {echo("checked");}?>>  Bb Major<br>
                <label class="form-check-label sr-only" for="chk12"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk13" name="keySigs[]" value="13" <?php if (in_array( "13", $keySigs)) {echo("checked");}?>>  F Major<br>
                <label class="form-check-label sr-only" for="chk13"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk14" name="keySigs[]" value="14" <?php if (in_array( "14", $keySigs)) {echo("checked");}?>>  a minor<br>
                <label class="form-check-label sr-only" for="chk14"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk15" name="keySigs[]" value="15" <?php if (in_array( "15", $keySigs)) {echo("checked");}?>>  e minor<br>
                <label class="form-check-label sr-only" for="chk15"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk16" name="keySigs[]" value="16" <?php if (in_array( "16", $keySigs)) {echo("checked");}?>>  b minor<br>
                <label class="form-check-label sr-only" for="chk16"></label>
            </div> <!-- end form-check -->
      
            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk17" name="keySigs[]" value="17" <?php if (in_array( "17", $keySigs)) {echo("checked");}?>>  f# minor<br>
                <label class="form-check-label sr-only" for="chk17"></label>
                </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk18" name="keySigs[]" value="18" <?php if (in_array( "18", $keySigs)) {echo("checked");}?>>  c# minor<br>
                <label class="form-check-label sr-only" for="chk18"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk19" name="keySigs[]" value="19" <?php if (in_array( "19", $keySigs)) {echo("checked");}?>>  g# minor<br>
                <label class="form-check-label sr-only" for="chk19"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk20" name="keySigs[]" value="20" <?php if (in_array( "20", $keySigs)) {echo("checked");}?>>  eb minor<br>
                <label class="form-check-label sr-only" for="chk20"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk21" name="keySigs[]" value="21" <?php if (in_array( "21", $keySigs)) {echo("checked");}?>>  bb minor<br>
                <label class="form-check-label sr-only" for="chk21"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk22" name="keySigs[]" value="22" <?php if (in_array( "22", $keySigs)) {echo("checked");}?>>  f minor<br>
                <label class="form-check-label sr-only" for="chk22"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk23" name="keySigs[]" value="23" <?php if (in_array( "23", $keySigs)) {echo("checked");}?>>   c minor<br>
                <label class="form-check-label sr-only" for="chk23"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk24" name="keySigs[]" value="24" <?php if (in_array( "24", $keySigs)) {echo("checked");}?>>   g minor<br>
                <label class="form-check-label sr-only" for="chk24"></label>
            </div> <!-- end form-check -->

            <div class="form-check pb-4">
                <input type="checkbox"  class="form-check-input"  id="chk25" name="keySigs[]" value="25" <?php if (in_array( "25", $keySigs)) {echo("checked");}?>>  d minor<br>
                <label class="form-check-label sr-only" for="chk25"></label>

        </div> <!-- end form-check -->
    </div> <!-- end card-body -->
  </div> <!-- end card -->
</div> <!-- end col -->




 <div class="col-md-4">
   <div class="card mb-3">
      <div class="card-body bg-light">

        <h6>Genre: choose as many as apply</h6>
        <?php echo $genresErr ?>

      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chbx1" name="genres[]" value="1" <?php if (in_array( "1", $genres)) {echo("checked");}?>> none<br>
        <label class="form-check-label sr-only" for="chbx1"></label>
      </div> <!-- end form-check -->



          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx20" name="genres[]" value="20" <?php if (in_array( "20", $genres)) {echo("checked");}?>> Band<br>
              <label class="form-check-label sr-only" for="chbx20"></label>
          </div> <!-- end form-check -->

          <div class="form-check ">
              <input type="checkbox" class="form-check-input" id="chbx35" name="genres[]" value="35" <?php if (in_array( "35", $genres)) {echo("checked");}?>> Barbershop (female)<br>
              <label class="form-check-label sr-only" for="chbx35"></label>
          </div> <!-- end form-check -->

          <div class="form-check ">
              <input type="checkbox" class="form-check-input" id="chbx34" name="genres[]" value="34" <?php if (in_array( "34", $genres)) {echo("checked");}?>> Barbershop (male)<br>
              <label class="form-check-label sr-only" for="chbx34"></label>
          </div> <!-- end form-check -->

          <div class="form-check ">
              <input type="checkbox" class="form-check-input" id="chbx36" name="genres[]" value="36" <?php if (in_array( "36", $genres)) {echo("checked");}?>> Barbershop (mixed)<br>
              <label class="form-check-label sr-only" for="chbx36"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx29" name="genres[]" value="29" <?php if (in_array( "29", $genres)) {echo("checked");}?>> Birthday<br>
              <label class="form-check-label sr-only" for="chbx29"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx5" name="genres[]" value="5" <?php if (in_array( "5", $genres)) {echo("checked");}?>> Blues<br>
              <label class="form-check-label sr-only" for="chbx5"></label>
          </div> <!-- end form-check -->

          <div class="form-check ">
              <input type="checkbox" class="form-check-input" id="chbx13" name="genres[]" value="13" <?php if (in_array( "13", $genres)) {echo("checked");}?>> Broadway Tunes<br>
              <label class="form-check-label sr-only" for="chbx13"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx3" name="genres[]" value="3" <?php if (in_array( "3", $genres)) {echo("checked");}?>> Christmas<br>
              <label class="form-check-label sr-only" for="chbx3"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx12" name="genres[]" value="12" <?php if (in_array( "12", $genres)) {echo("checked");}?>> Classical<br>
              <label class="form-check-label sr-only" for="chbx12"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx21" name="genres[]" value="21" <?php if (in_array( "21", $genres)) {echo("checked");}?>> Commercial (jingles, Movie & TV themes)<br>
              <label class="form-check-label sr-only" for="chbx21"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx8" name="genres[]" value="8" <?php if (in_array( "8", $genres)) {echo("checked");}?>> Country<br>
              <label class="form-check-label sr-only" for="chbx8"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx22" name="genres[]" value="22" <?php if (in_array( "22", $genres)) {echo("checked");}?>> Disney<br>
              <label class="form-check-label sr-only" for="chbx22"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx28" name="genres[]" value="28" <?php if (in_array( "28", $genres)) {echo("checked");}?>> Easter<br>
              <label class="form-check-label sr-only" for="chbx28"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx23" name="genres[]" value="23" <?php if (in_array( "23", $genres)) {echo("checked");}?>> Easy Listening<br>
              <label class="form-check-label sr-only" for="chbx23"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx14" name="genres[]" value="14" <?php if (in_array( "14", $genres)) {echo("checked");}?>> Folk Music<br>
              <label class="form-check-label sr-only" for="chbx14"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx17" name="genres[]" value="17" <?php if (in_array( "17", $genres)) {echo("checked");}?>> Gospel/Christian<br>
              <label class="form-check-label sr-only" for="chbx17"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx4" name="genres[]" value="4" <?php if (in_array( "4", $genres)) {echo("checked");}?>> Halloween<br>
              <label class="form-check-label sr-only" for="chbx4"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx16" name="genres[]" value="16" <?php if (in_array( "16", $genres)) {echo("checked");}?>> Instrumental<br>
              <label class="form-check-label sr-only" for="chbx16"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx32" name="genres[]" value="32" <?php if (in_array( "32", $genres)) {echo("checked");}?>> Irish<br>
              <label class="form-check-label sr-only" for="chbx32"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx2" name="genres[]" value="2" <?php if (in_array( "2", $genres)) {echo("checked");}?>> Jazz<br>
              <label class="form-check-label sr-only" for="chbx2"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx24" name="genres[]" value="24" <?php if (in_array( "24", $genres)) {echo("checked");}?>> Latin<br>
              <label class="form-check-label sr-only" for="chbx24"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx9" name="genres[]" value="9" <?php if (in_array( "9", $genres)) {echo("checked");}?>> Madrigal<br>
              <label class="form-check-label sr-only" for="chbx9"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx11" name="genres[]" value="11" <?php if (in_array( "11", $genres)) {echo("checked");}?>> Method Book<br>
              <label class="form-check-label sr-only" for="chbx11"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx25" name="genres[]" value="25" <?php if (in_array( "25", $genres)) {echo("checked");}?>> Opera<br>
              <label class="form-check-label sr-only" for="chbx25"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx19" name="genres[]" value="19" <?php if (in_array( "19", $genres)) {echo("checked");}?>> Orchestra<br>
              <label class="form-check-label sr-only" for="chbx19"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx30" name="genres[]" value="30" <?php if (in_array( "30", $genres)) {echo("checked");}?>> Patriotic<br>
              <label class="form-check-label sr-only" for="chbx30"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx7" name="genres[]" value="7" <?php if (in_array( "7", $genres)) {echo("checked");}?>> Pop<br>
              <label class="form-check-label sr-only" for="chbx7"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx15" name="genres[]" value="15" <?php if (in_array( "15", $genres)) {echo("checked");}?>> Popular Music<br>
              <label class="form-check-label sr-only" for="chbx15"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx26" name="genres[]" value="26" <?php if (in_array( "26", $genres)) {echo("checked");}?>> R&B Soul<br>
              <label class="form-check-label sr-only" for="chbx26"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx6" name="genres[]" value="6" <?php if (in_array( "6", $genres)) {echo("checked");}?>> Rag<br>
              <label class="form-check-label sr-only" for="chbx6"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx27" name="genres[]" value="27" <?php if (in_array( "27", $genres)) {echo("checked");}?>> Rock<br>
              <label class="form-check-label sr-only" for="chbx27"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx18" name="genres[]" value="18" <?php if (in_array( "18", $genres)) {echo("checked");}?>> Swing<br>
              <label class="form-check-label sr-only" for="chbx18"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx10" name="genres[]" value="10" <?php if (in_array( "10", $genres)) {echo("checked");}?>> Technique<br>
              <label class="form-check-label sr-only" for="chbx10"></label>
          </div> <!-- end form-check -->

          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="chbx31" name="genres[]" value="31" <?php if (in_array( "31", $genres)) {echo("checked");}?>> ThanksGiving<br>
              <label class="form-check-label sr-only" for="chbx31"></label>
          </div> <!-- end form-check -->

          <div class="form-check pb-4">
              <input type="checkbox" class="form-check-input" id="chbx33" name="genres[]" value="33" <?php if (in_array( "33", $genres)) {echo("checked");}?>> Other Alternative<br>
              <label class="form-check-label sr-only" for="chbx33"></label>
          </div> <!-- end form-check -->

      </div> <!-- end card-body -->
    </div> <!-- end card -->
  </div> <!-- end col -->


    
  <div class="col-md-4">
    <div class="card mb-3">
       <div class="card-body bg-light">


      <h6>Instrument:choose as many as apply</h6>
      <?php echo $instrumentsErr ?>

      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chkbx7" name="instruments[]" value="7" <?php if (in_array( "7", $instruments)) {echo("checked");}?>>  none<br>
        <label class="form-check-label sr-only" for="chkbx7"></label>
      </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx9" name="instruments[]" value="9" <?php if (in_array( "9", $instruments)) {echo("checked");}?>>  Bass<br>
               <label class="form-check-label sr-only" for="chkbx9"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx30" name="instruments[]" value="30" <?php if (in_array( "30", $instruments)) {echo("checked");}?>>  Bass Drum<br>
               <label class="form-check-label sr-only" for="chkbx30"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx21" name="instruments[]" value="21" <?php if (in_array( "21", $instruments)) {echo("checked");}?>>  Bassoon<br>
               <label class="form-check-label sr-only" for="chkbx21"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx37" name="instruments[]" value="37" <?php if (in_array( "37", $instruments)) {echo("checked");}?>>  Bells (hand)<br>
               <label class="form-check-label sr-only" for="chkbx37"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx42" name="instruments[]" value="42" <?php if (in_array( "42", $instruments)) {echo("checked");}?>>  Bongos<br>
               <label class="form-check-label sr-only" for="chkbx42"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx38" name="instruments[]" value="38" <?php if (in_array( "38", $instruments)) {echo("checked");}?>>  Bells (resonator)<br>
               <label class="form-check-label sr-only" for="chkbx38"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx42" name="instruments[]" value="42" <?php if (in_array( "42", $instruments)) {echo("checked");}?>>  Bongos<br>
               <label class="form-check-label sr-only" for="chkbx42"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx43" name="instruments[]" value="43" <?php if (in_array( "43", $instruments)) {echo("checked");}?>>  BoomWhackers<br>
               <label class="form-check-label sr-only" for="chkbx43"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx29" name="instruments[]" value="29" <?php if (in_array( "29", $instruments)) {echo("checked");}?>>  Castinets<br>
               <label class="form-check-label sr-only" for="chkbx29"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx34" name="instruments[]" value="34" <?php if (in_array( "34", $instruments)) {echo("checked");}?>>  Celesta<br>
               <label class="form-check-label sr-only" for="chkbx34"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx8" name="instruments[]" value="8" <?php if (in_array( "8", $instruments)) {echo("checked");}?>>  Cello<br>
               <label class="form-check-label sr-only" for="chkbx8"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx33" name="instruments[]" value="33" <?php if (in_array( "33", $instruments)) {echo("checked");}?>>  Chimes<br>
               <label class="form-check-label sr-only" for="chkbx33"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx20" name="instruments[]" value="20" <?php if (in_array( "20", $instruments)) {echo("checked");}?>>  Clarinet<br>
               <label class="form-check-label sr-only" for="chkbx20"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx47" name="instruments[]" value="47" <?php if (in_array( "47", $instruments)) {echo("checked");}?>>  Clavichord<br>
               <label class="form-check-label sr-only" for="chkbx47"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx14" name="instruments[]" value="14" <?php if (in_array( "14", $instruments)) {echo("checked");}?>>  Cornet<br>
               <label class="form-check-label sr-only" for="chkbx14"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx28" name="instruments[]" value="28" <?php if (in_array( "28", $instruments)) {echo("checked");}?>>  Cymbals<br>
               <label class="form-check-label sr-only" for="chkbx28"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx50" name="instruments[]" value="50" <?php if (in_array( "50", $instruments)) {echo("checked");}?>>  Djembe<br>
               <label class="form-check-label sr-only" for="chkbx50"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx41" name="instruments[]" value="41" <?php if (in_array( "41", $instruments)) {echo("checked");}?>>  Drum Set<br>
               <label class="form-check-label sr-only" for="chkbx41"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx17" name="instruments[]" value="17" <?php if (in_array( "17", $instruments)) {echo("checked");}?>>  Flute<br>
               <label class="form-check-label sr-only" for="chkbx17"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx11" name="instruments[]" value="11" <?php if (in_array( "11", $instruments)) {echo("checked");}?>>  French Horn<br>
               <label class="form-check-label sr-only" for="chkbx11"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx27" name="instruments[]" value="27" <?php if (in_array( "27", $instruments)) {echo("checked");}?>>  Glockenspiel<br>
               <label class="form-check-label sr-only" for="chkbx27"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx32" name="instruments[]" value="32" <?php if (in_array( "32", $instruments)) {echo("checked");}?>>  Gong<br>
               <label class="form-check-label sr-only" for="chkbx32"></label>
           </div> <!-- end form-check -->

           <div class="form-check ">
               <input type="checkbox"  class="form-check-input" id="chkbx6" name="instruments[]" value="6" <?php if (in_array( "6", $instruments)) {echo("checked");}?>>  Guitar (accoustic)<br>
               <label class="form-check-label sr-only" for="chkbx6"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx49" name="instruments[]" value="49" <?php if (in_array( "49", $instruments)) {echo("checked");}?>>  Guitar (electric)<br>
               <label class="form-check-label sr-only" for="chkbx49"></label>
           </div> <!-- end form-check -->

           <div class="form-check ">
               <input type="checkbox"  class="form-check-input" id="chkbx10" name="instruments[]" value="10" <?php if (in_array( "10", $instruments)) {echo("checked");}?>>  Harp<br>
               <label class="form-check-label sr-only" for="chkbx10"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx46" name="instruments[]" value="46" <?php if (in_array( "46", $instruments)) {echo("checked");}?>>  Harpsichord<br>
               <label class="form-check-label sr-only" for="chkbx46"></label>
           </div> <!-- end form-check -->

           <div class="form-check ">
               <input type="checkbox"  class="form-check-input" id="chkbx25" name="instruments[]" value="25" <?php if (in_array( "25", $instruments)) {echo("checked");}?>>  Marimba<br>
               <label class="form-check-label sr-only" for="chkbx25"></label>
           </div> <!-- end form-check -->

           <div class="form-check ">
               <input type="checkbox"  class="form-check-input" id="chkbx19" name="instruments[]" value="19" <?php if (in_array( "19", $instruments)) {echo("checked");}?>>  Oboe<br>
               <label class="form-check-label sr-only" for="chkbx19"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx44" name="instruments[]" value="44" <?php if (in_array( "44", $instruments)) {echo("checked");}?>>  Organ<br>
               <label class="form-check-label sr-only" for="chkbx44"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx1" name="instruments[]" value="1" <?php if (in_array( "1", $instruments)) {echo("checked");}?>>  Piano<br>
               <label class="form-check-label sr-only" for="chkbx1"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx22" name="instruments[]" value="22" <?php if (in_array( "22", $instruments)) {echo("checked");}?>>  Piccolo<br>
               <label class="form-check-label sr-only" for="chkbx22"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx18" name="instruments[]" value="18" <?php if (in_array( "18", $instruments)) {echo("checked");}?>>  Recorder<br>
               <label class="form-check-label sr-only" for="chkbx18"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx16" name="instruments[]" value="16" <?php if (in_array( "16", $instruments)) {echo("checked");}?>>  Saxaphone<br>
               <label class="form-check-label sr-only" for="chkbx16"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx15" name="instruments[]" value="15" <?php if (in_array( "15", $instruments)) {echo("checked");}?>>  Sousaphone<br>
               <label class="form-check-label sr-only" for="chkbx15"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx36" name="instruments[]" value="36" <?php if (in_array( "36", $instruments)) {echo("checked");}?>>  Snare Drum<br>
               <label class="form-check-label sr-only" for="chkbx36"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx45" name="instruments[]" value="45" <?php if (in_array( "45", $instruments)) {echo("checked");}?>>  Synthesizer<br>
               <label class="form-check-label sr-only" for="chkbx45"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx31" name="instruments[]" value="31" <?php if (in_array( "31", $instruments)) {echo("checked");}?>>  Tambourine<br>
               <label class="form-check-label sr-only" for="chkbx31"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx23" name="instruments[]" value="23" <?php if (in_array( "23", $instruments)) {echo("checked");}?>>  Timpani<br>
               <label class="form-check-label sr-only" for="chkbx23"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx39" name="instruments[]" value="39" <?php if (in_array( "39", $instruments)) {echo("checked");}?>>  Tom (floor)<br>
               <label class="form-check-label sr-only" for="chkbx39"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx40" name="instruments[]" value="40" <?php if (in_array( "40", $instruments)) {echo("checked");}?>>  Tom Toms<br>
               <label class="form-check-label sr-only" for="chkbx40"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx35" name="instruments[]" value="35" <?php if (in_array( "35", $instruments)) {echo("checked");}?>>  Triangle<br>
               <label class="form-check-label sr-only" for="chkbx35"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx12" name="instruments[]" value="12" <?php if (in_array( "12", $instruments)) {echo("checked");}?>>  Trombone<br>
               <label class="form-check-label sr-only" for="chkbx12"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx3" name="instruments[]" value="3" <?php if (in_array( "3", $instruments)) {echo("checked");}?>>  Trumpet<br>
               <label class="form-check-label sr-only" for="chkbx3"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx13" name="instruments[]" value="13" <?php if (in_array( "13", $instruments)) {echo("checked");}?>>  Tuba<br>
               <label class="form-check-label sr-only" for="chkbx13"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx26" name="instruments[]" value="26" <?php if (in_array( "26", $instruments)) {echo("checked");}?>>  Vibraphone<br>
               <label class="form-check-label sr-only" for="chkbx26"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx5" name="instruments[]" value="5" <?php if (in_array( "5", $instruments)) {echo("checked");}?>>  Viola<br>
               <label class="form-check-label sr-only" for="chkbx5"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx4" name="instruments[]" value="4" <?php if (in_array( "4", $instruments)) {echo("checked");}?>>  Violin<br>
               <label class="form-check-label sr-only" for="chkbx4"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx2" name="instruments[]" value="2" <?php if (in_array( "2", $instruments)) {echo("checked");}?>>  Voice<br>
               <label class="form-check-label sr-only" for="chkbx2"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx24" name="instruments[]" value="24" <?php if (in_array( "24", $instruments)) {echo("checked");}?>>  Xylophone<br>
               <label class="form-check-label sr-only" for="chkbx24"></label>
           </div> <!-- end form-check -->

           <div class="form-check">
               <input type="checkbox"  class="form-check-input" id="chkbx51" name="instruments[]" value="51" <?php if (in_array( "51", $instruments)) {echo("checked");}?>>  Other<br>
               <label class="form-check-label sr-only" for="chkbx51"></label>
           </div> <!-- end form-check -->

























































       </div> <!-- end card-body -->
      </div> <!-- end card -->
    </div> <!-- end col -->
  </div> <!-- end row -->




  <div class="row">
    <div class="col-md-6">
      <div class="card mb-3">
        <div class="card-body bg-light">
          <div class="form-group pt-2">

              <label for="era">Era: choose one</label>
              <?php echo $eraErr ?>
        
              <select  class="form-control" id="era" name="era">
              <option value="7" <?php if ($era == "7") {echo("selected");} ?>> none</option>
              <option value="1" <?php if ($era == "1") {echo("selected");} ?>> Ancient pre 1600</option>
              <option value="2" <?php if ($era == "2") {echo("selected");} ?>> Baroque 1600-1750</option>
              <option value="3" <?php if ($era == "3") {echo("selected");} ?>> Classical 1750-1810</option>
              <option value="4" <?php if ($era == "4") {echo("selected");} ?>> Romantic 1780-1910</option>
              <option value="5" <?php if ($era == "5") {echo("selected");} ?>> Modern 1890-1930</option>
              <option value="6" <?php if ($era == "6") {echo("selected");} ?>> Contemporary 1930-Present</option>
              </select>
        
        </div>  <!-- end form-group -->
      </div> <!-- end card-body -->
    </div> <!-- end card -->
  </div> <!-- end col -->


  <div class="col-md-6">
    <div class="card mb-3">
      <div class="card-body bg-light">
        <div class="form-group pt-2">

            <label for="voice">Voice: choose one</label>
            <?php echo $voiceErr ?>
            <select  class="form-control" id="voice"  name="voice">
              <option value="12" <?php if ($voice == "12") {echo("selected");} ?>> none</option>
              <option value="1" <?php if ($voice == "1") {echo("selected");} ?>> SA</option>
              <option value="2" <?php if ($voice == "2") {echo("selected");} ?>> SSA</option>
              <option value="3" <?php if ($voice == "3") {echo("selected");} ?>> SSAA</option>
              <option value="4" <?php if ($voice == "4") {echo("selected");} ?>> ST</option>
              <option value="5" <?php if ($voice == "5") {echo("selected");} ?>> TTBB</option>
              <option value="6" <?php if ($voice == "6") {echo("selected");} ?>> SB</option>
              <option value="7" <?php if ($voice == "7") {echo("selected");} ?>> SAB</option>
              <option value="8" <?php if ($voice == "8") {echo("selected");} ?>> SATB</option>
              <option value="9" <?php if ($voice == "9") {echo("selected");} ?>> TBB</option>
            /*row 10 was a duplicate*/
              <option value="11" <?php if ($voice == "11") {echo("selected");} ?>> TB</option>
              <option value="11" <?php if ($voice == "11") {echo("selected");} ?>> TB</option>
              <option value="13" <?php if ($voice == "13") {echo("selected");} ?>> S</option>
              <option value="14" <?php if ($voice == "14") {echo("selected");} ?>> A</option>
              <option value="16" <?php if ($voice == "16") {echo("selected");} ?>> B</option>
              <option value="18" <?php if ($voice == "18") {echo("selected");} ?>> STB</option>
              <option value="19" <?php if ($voice == "19") {echo("selected");} ?>> SAT</option>
              <option value="20" <?php if ($voice == "20") {echo("selected");} ?>> SAB</option>
              <option value="21" <?php if ($voice == "21") {echo("selected");} ?>> AT</option>
              <option value="22" <?php if ($voice == "22") {echo("selected");} ?>> AB</option>
              <option value="23" <?php if ($voice == "23") {echo("selected");} ?>> ATB</option>
              <option value="24" <?php if ($voice == "24") {echo("selected");} ?>> TT</option>
              <option value="25" <?php if ($voice == "25") {echo("selected");} ?>> TTBB</option>
              <option value="26" <?php if ($voice == "26") {echo("selected");} ?>> BB</option>
              <option value="27" <?php if ($voice == "27") {echo("selected");} ?>> TTB</option>
              <option value="28" <?php if ($voice == "28") {echo("selected");} ?>> High Voice</option>
              <option value="29" <?php if ($voice == "29") {echo("selected");} ?>> Medium Voice</option>
              <option value="30" <?php if ($voice == "30") {echo("selected");} ?>> Low Voice</option>
            </select>

          </div> <!-- end form-group -->
        </div> <!-- end card-body -->
      </div> <!-- end card -->
    </div> <!-- end col -->
  </div> <!-- end row -->

  
  <div class="row">
    <div class="col-md-6">
      <div class="card mb-3">
        <div class="card-body bg-light">
          <div class="form-group pt-2">
          

               <label for="ensemble">Ensemble: choose one</label>
               <?php echo $ensembleErr ?>
               <select  class="form-control" id="ensemble" name="ensemble">
                  <option value="18" <?php if ($ensemble == "18") {echo("selected");} ?>> none</option>
                  <option value="1" <?php if ($ensemble == "1") {echo("selected");} ?>> Solo a capella</option>
                  <option value="2" <?php if ($ensemble == "2") {echo("selected");} ?>> Duet a capella</option>
                  <option value="3" <?php if ($ensemble == "3") {echo("selected");} ?>> Trio a capella</option>
                  <option value="4" <?php if ($ensemble == "4") {echo("selected");} ?>> Quartet a capella</option>
                  <option value="5" <?php if ($ensemble == "5") {echo("selected");} ?>> Quintet a capella</option>
                  <option value="6" <?php if ($ensemble == "6") {echo("selected");} ?>> Ensemble</option>
                  <option value="7" <?php if ($ensemble == "7") {echo("selected");} ?>> Solo-Accompanied</option>
                  <option value="8" <?php if ($ensemble == "8") {echo("selected");} ?>> Duet-Accompanied</option>
                  <option value="9" <?php if ($ensemble == "9") {echo("selected");} ?>> Trio-Accompanied</option>
                  <option value="10" <?php if ($ensemble == "10") {echo("selected");} ?>> Quartet-Accompanied</option>
                  <option value="11" <?php if ($ensemble == "11") {echo("selected");} ?>> Quintet-Accompanied</option>
                  <option value="12" <?php if ($ensemble == "12") {echo("selected");} ?>> Ensemble-Accompanied</option>
                  <option value="13" <?php if ($ensemble == "13") {echo("selected");} ?>> Band</option>
                  <option value="14" <?php if ($ensemble == "14") {echo("selected");} ?>> Orchestra</option>
                  <option value="15" <?php if ($ensemble == "15") {echo("selected");} ?>> Choir</option>
                  <option value="16" <?php if ($ensemble == "16") {echo("selected");} ?>> Choir-Accompanied</option>
                  <option value="17" <?php if ($ensemble == "17") {echo("selected");} ?>> other</option>
                </select>

          </div> <!-- end form-group -->
        </div> <!-- end card-body -->
      </div> <!-- end card -->
    </div> <!-- end col -->
    

      
    <div class="col-md-6">
      <div class="card mb-3">
        <div class="card-body bg-light">
          <div class="form-group pt-2">

              <label for="genDiff">General Difficulty Level: choose one</label> 
              <?php echo $genDiffErr ?>
              <select  class="form-control" id="genDiff" name="genDiff">
                <option value="10" <?php if ($genDiff == "10") {echo("selected");} ?>> none</option>
                <option value="1" <?php if ($genDiff == "1") {echo("selected");} ?>> Gen EE / ASP 1</option>
                <option value="2" <?php if ($genDiff == "2") {echo("selected");} ?>> Gen E / ASP 2</option>
                <option value="3" <?php if ($genDiff == "3") {echo("selected");} ?>> Gen LE / ASP 3</option>
                <option value="4" <?php if ($genDiff == "4") {echo("selected");} ?>> Gen EI / ASP 4</option>
                <option value="5" <?php if ($genDiff == "5") {echo("selected");} ?>> Gen I / ASP 5-6</option>
                <option value="6" <?php if ($genDiff == "6") {echo("selected");} ?>> Gen LI / ASP 7</option>
                <option value="7" <?php if ($genDiff == "7") {echo("selected");} ?>> Gen EA / ASP 8</option>
                <option value="8" <?php if ($genDiff == "8") {echo("selected");} ?>> Gen A / ASP 9-19</option>
                <option value="9" <?php if ($genDiff == "9") {echo("selected");} ?>> Gen LA / ASP 11-12</option>
              </select>

        </div> <!-- end form-group -->
      </div> <!-- end card-body -->
    </div> <!-- end card -->
  </div> <!-- end col -->
 </div> <!-- end row -->


  <div class="row">
    <div class="col-md-6">
      <div class="card mb-3">
        <div class="card-body bg-light">     
          <div class="form-group pt-2">


            <label for="aspDiff">ASP difficulty level: choose one</label>
            <?php echo $ASPDiffErr ?>
            <select  class="form-control" id="aspDiff" name="ASPDiff">
                    <option value="34" <?php if ($ASPDiff == "34") {echo("selected");} ?>> none</option>
                    <option value="11" <?php if ($ASPDiff == "11") {echo("selected");} ?>> ASP 1 / Gen EE</option>
                    <option value="12" <?php if ($ASPDiff == "12") {echo("selected");} ?>> ASP 1-2 / Gen EE-E</option>
                    <option value="13" <?php if ($ASPDiff == "13") {echo("selected");} ?>> ASP 2 / Gen E</option>
                    <option value="14" <?php if ($ASPDiff == "14") {echo("selected");} ?>> ASP 2-3 / Gen E-LE </option>
                    <option value="15" <?php if ($ASPDiff == "15") {echo("selected");} ?>> ASP 3 / Gen LE</option>
                    <option value="16" <?php if ($ASPDiff == "16") {echo("selected");} ?>> ASP 3-4 / Gen LE-EI</option>
                    <option value="17" <?php if ($ASPDiff == "17") {echo("selected");} ?>> ASP 4 / Gen EI</option>
                    <option value="18" <?php if ($ASPDiff == "18") {echo("selected");} ?>> ASP 4-5 / Gen EI-I</option>
                    <option value="19" <?php if ($ASPDiff == "19") {echo("selected");} ?>> ASP 5 / Gen I</option>
                    <option value="20" <?php if ($ASPDiff == "20") {echo("selected");} ?>> ASP 5-6 / Gen I</option>
                    <option value="21" <?php if ($ASPDiff == "21") {echo("selected");} ?>> ASP 6 / Gen I</option>
                    <option value="22" <?php if ($ASPDiff == "22") {echo("selected");} ?>> ASP 6-7 / Gen I-LI</option>
                    <option value="23" <?php if ($ASPDiff == "23") {echo("selected");} ?>> ASP 7 / Gen LI</option>
                    <option value="24" <?php if ($ASPDiff == "24") {echo("selected");} ?>> ASP 7-8 / Gen LI-EA</option>
                    <option value="25" <?php if ($ASPDiff == "25") {echo("selected");} ?>> ASP 8 / Gen EA</option>
                    <option value="26" <?php if ($ASPDiff == "26") {echo("selected");} ?>> ASP 8-9 / Gen EA-A</option>
                    <option value="27" <?php if ($ASPDiff == "27") {echo("selected");} ?>> ASP 9 / Gen A</option>
                    <option value="28" <?php if ($ASPDiff == "28") {echo("selected");} ?>> ASP 9-10 / Gen A</option>
                    <option value="29" <?php if ($ASPDiff == "29") {echo("selected");} ?>> ASP 10 / Gen A</option>
                    <option value="30" <?php if ($ASPDiff == "30") {echo("selected");} ?>> ASP 10-11 / Gen A-LA</option>
                    <option value="31" <?php if ($ASPDiff == "31") {echo("selected");} ?>> ASP 11 / Gen LA</option>
                    <option value="32" <?php if ($ASPDiff == "32") {echo("selected");} ?>> ASP 11-12 / Gen LA</option>
                    <option value="33" <?php if ($ASPDiff == "33") {echo("selected");} ?>> ASP 12 / Gen LA</option>
            </select>


          </div> <!-- end form-group -->  
        </div> <!-- end card-body -->
      </div> <!-- end card -->     
    </div> <!-- end col -->



          <div class="col-md-6">
              <div class="card mb-3">
                  <div class="card-body bg-light">
                      <div class="form-group pt-2">
                          <label for="physCompositionLoc">Composition Location: Type in the Composition Location for your library</label>
                          <input type="text" class="form-control" id="physCompositionLoc" name="physCompositionLocNote" value="<?php echo $physCompositionLocNote ?>"/><br/>
                          <p>If using quotes: Opt for single quotes rather than double</p></p>
                      </div> <!-- end form-group -->
                  </div> <!-- end card-body -->
              </div> <!-- end card -->
          </div> <!-- end col -->
      </div> <!--end row-->




      <input class="btn btn-secondary" type="submit" value="Submit & Continue"/>
    <input type="hidden" name="bookID" value="<?php echo $bookID; ?>" />
    <input type="hidden" name="compositionID" value="<?php echo $compositionID; ?>"/>
    <input type="hidden" name="submit" value="true"/>
    <?php echo $sendEditComposition; ?>
      <?php echo $sendAddNewComposition; ?>
    

   
  </form>  <!--end form-->
</div>  <!--end container-->




<?php

include 'footer.html';
include 'endingBoilerplate.php';

?>