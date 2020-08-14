<?php
include 'boilerplate.php';
/*Not current. see addComposition2.php*/
if($debug) {
    echo <<<_END

    <p>addComposition.php-13</p>

_END;
}/*end debug*/

include 'beginningNav.php';


/*Initialize Variables*/
$submit = "";
$compositionID = "";
$oldCompositionID = "";
$editComposition = "";
$bookID = "";

$compName = "";
$compName_value = "";
$opus = "";
$opusNum = "";
$compNum = "";
$subTitle = "";
$movement = "";
$movement_value = "";

$postKeySigID = "";
$postGenreID = "";
$postInstrumentID = "";
$postEraID = "";
$postVoiceID = "";
$postEnsembleID = "";
$postGenDiffID = "";
$postASPDiffID = "";

$compNameErr = "";
$postKeySigIDErr = "";
$postGenreIDErr = "";
$postInstrumentIDErr = "";
$postEraIDErr = "";
$postVoiceIDErr = "";
$postEnsembleIDErr = "";
$postGenDiffIDErr = "";
$postASPDiffIDErr = "";


$postKeySigArray = array(
    "1" => "",
    "2" => "",
    "3" => "",
    "4" => "",
    "5" => "",
    "6" => "",
    "7" => "",
    "8" => "",
    "9" => "",
    "10" => "",
    "11" => "",
    "12" => "",
    "13" => "",
    "14" => "",
    "15" => "",
    "16" => "",
    "17" => "",
    "18" => "",
    "19" => "",
    "20" => "",
    "21" => "",
    "22" => "",
    "23" => "",
    "24" => "",
    "25" => "" );

$postGenreArray = array(
    "1" => "",
    "2" => "",
    "3" => "",
    "4" => "",
    "5" => "",
    "6" => "",
    "7" => "",
    "8" => "",
    "9" => "",
    "10" => "",
    "11" => "",
    "12" => "",
    "13" => "" );

$postInstrumentArray = array(
    "1" => "",
    "2" => "",
    "3" => "",
    "4" => "",
    "5" => "",
    "6" => "",
    "7" => "" );

$postEraArray = array(
    "1" => "",
    "2" => "",
    "3" => "",
    "4" => "",
    "5" => "",
    "6" => "",
    "7" => "" );

$postVoiceArray = array(
    "1" => "",
    "2" => "",
    "3" => "",
    "4" => "",
    "5" => "",
    "6" => "",
    "7" => "",
    "8" => "",
    "9" => "",
    "10" => "",
    "11" => "",
    "12" => "" );

$postEnsembleArray = array(
    "1" => "",
    "2" => "",
    "3" => "",
    "4" => "",
    "5" => "",
    "6" => "",
    "7" => "",
    "8" => "",
    "9" => "",
    "10" => "",
    "11" => "",
    "12" => "",
    "13" => "",
    "14" => "",
    "15" => "",
    "16" => "",
    "17" => "",
    "18" => "" );

$postGenDiffArray = array(
    "1" => "",
    "2" => "",
    "3" => "",
    "4" => "",
    "5" => "",
    "6" => "",
    "7" => "",
    "8" => "",
    "9" => "",
    "10" => "" );

$postASPDiffArray = array(
    "11" => "",
    "12" => "",
    "13" => "",
    "14" => "",
    "15" => "",
    "16" => "",
    "17" => "",
    "18" => "",
    "19" => "",
    "20" => "",
    "21" => "",
    "22" => "",
    "23" => "",
    "24" => "",
    "25" => "",
    "26" => "",
    "27" => "",
    "28" => "",
    "29" => "",
    "30" => "",
    "31" => "",
    "32" => "",
    "33" => "",
    "34" => "" );


/*assigning variable names to post and get values*/

if(isset($_REQUEST['submit'])) {
    $submit = $_REQUEST['submit'];
}

if(isset($_REQUEST['compositionID'])) {
    $compositionID = $_REQUEST['compositionID'];
}

if(isset($_REQUEST['oldCompositionID'])) {
    $oldCompositionID = $_REQUEST['oldCompositionID'];
}

if(isset($_REQUEST['editComposition'])) {
    $editComposition = $_REQUEST['editComposition'];
}

if(isset($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}


if(isset($_REQUEST['compName'])) {
    $compName = $_REQUEST['compName'];
}

if(isset($_REQUEST['opus'])) {
    $opus = $_REQUEST['opus'];
}

if(isset($_REQUEST['opusNum'])) {
    $opusNum = $_REQUEST['opusNum'];
}

if(isset($_REQUEST['compNum'])) {
    $compNum = $_REQUEST['compNum'];
}

if(isset($_REQUEST['subTitle'])) {
    $subTitle = $_REQUEST['subTitle'];
}

if(isset($_REQUEST['movement'])) {
    $movement = $_REQUEST['movement'];
}



if(isset($_REQUEST['postKeySigID'])) {
    $postKeySigID = $_REQUEST['postKeySigID'];
}

if(isset($_REQUEST['postGenreID'])) {
    $postGenreID = $_REQUEST['postGenreID'];
}

if(isset($_REQUEST['postInstrumentID'])) {
    $postInstrumentID = $_REQUEST['postInstrumentID'];
}

if(isset($_REQUEST['postEraID'])) {
    $postEraID = $_REQUEST['postEraID'];
}

if(isset($_REQUEST['postVoiceID'])) {
    $postVoiceID = $_REQUEST['postVoiceID'];
}

if(isset($_REQUEST['postEnsembleID'])) {
    $postEnsembleID = $_REQUEST['postEnsembleID'];
}

if(isset($_REQUEST['postGenDiffID'])) {
    $postGenDiffID = $_REQUEST['postGenDiffID'];
}

if(isset($_REQUEST['postASPDiffID'])) {
    $postASPDiffID = $_REQUEST['postASPDiffID'];
}

/*assigning variable names to other situations*/

if($editComposition == 'true') {
    $sendEditComposition = "<input type='hidden' name='editComposition' value= 'true' />";
}

$validationFailed = false;


/*Validation code section
if $validationFailed is true, we will show form pre-populated with error messages and user can re-submit values.
if $validationFailed is false, we will wash data coming from the form. And
If editing  existing general composition info and validation is successful   we will update the compositions table before being sent by header to editComposition.php
If editing non general composition info and validation is successful   we will update the compositions table and then go to addRole.php to update any junction tables.
If adding a new composition to the library and validation is successful  we will insert this new composition info into the compositions table, go to addRole.php and add a new row to the junction table(C2R2P) connecting this specific composition info to the composition as a composer, lyricist or arranger. . */

/*These values will be used in the form below to show us what we submitted and to make corrections*/

/*TODO: probably if editComposition exists, we will need to search for the composition based on the old composition id and use the values to pre=populate the form fields. Look at other similar pages.*/

/*SEARCH FOR COMPOSITION*/

if($editComposition == 'true') {


    /*Retrieving all key signatures for this composition
I will also be creating a comma separated list to use in the displayed information*/
    $keySigQuery = <<<_END
      SELECT  k.ID
      FROM C2K
      LEFT JOIN keysignatures AS k ON C2K.keysig_ID = k.ID
      WHERE C2K.composition_ID = $oldCompositionID;

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

                $postKeySigArray[$row[0]] = 'checked';


            $keySignatureString .= $postKeySigArray[$row[0]] .", ";

        } /*for loop ending*/




    } /*End if result keysig query*/

    $displayKeySigString = rtrim($keySignatureString,', ');




    /*Retrieving all  genres for this composition
    I will also be creating a comma separated list to use in the displayed information*/
    $genresQuery = <<<_END

        SELECT  g.ID
        FROM C2G 
        LEFT JOIN genres AS g ON C2G.genre_ID = g.ID
        WHERE C2G.composition_ID = $oldCompositionID;


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



            $postGenreArray[$row[0]] = 'checked';

            $genreString .= $postGenreArray[$row[0]] .", ";

        } /*for loop ending*/

    } /*End if result keysig query*/

    $displayGenreString = rtrim($genreString,', ');





    /*Retrieving all instruments for this composition
    I will also be creating a comma separated list to use in the displayed information*/
    $instrumentQuery = <<<_END
      SELECT  i.ID
      FROM C2I 
      LEFT JOIN instruments AS i ON C2I.instrument_ID = i.ID
      WHERE C2I.composition_ID = $oldCompositionID;


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

            $postInstrumentArray[$row[0]] = 'checked';


            $instrumentString .= $postInstrumentArray[$row[0]] .", ";

        } /*for loop ending*/



    } /*End if result instrument query*/

    $displayInstrumentString = rtrim($instrumentString,', ');







    /*Retrieving the General difficulty for this composition*/

    $genDiffQuery = <<<_END
      SELECT  d.ID
      FROM compositions AS c 
      LEFT JOIN C2D ON c.ID = C2D.composition_ID
      LEFT JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
      JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'General'
      WHERE C2D.composition_ID = $oldCompositionID;


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
                $postGenDiffArray[$row[0]] = 'selected';

        } /*for loop ending*/

    } /*End if result select gendiff query*/





    /*Retrieving the ASP difficulty for this composition*/

    $ASPDiffQuery = <<<_END
      SELECT  d.ID
      FROM compositions AS c 
      LEFT JOIN C2D ON c.ID = C2D.composition_ID
      LEFT JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
      JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'ASP'
      WHERE C2D.composition_ID = $oldCompositionID;

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

                $postASPDiffArray[$row[0]] = 'selected';


        } /*for loop ending*/

    } /*End if result select ASPDiff query*/







    $compositionQuery = <<<_END
        SELECT c.ID, c.comp_name, c.opus_like, c.comp_num, c.comp_no, c.subtitle, c.movement, c.era_ID,c.voice_ID, c.ensemble_ID, c.book_ID 
        FROM compositions AS c
        LEFT JOIN books AS b ON c.book_ID = b.ID

        WHERE c.ID = $oldCompositionID;
       
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

            $queryCompositionID = ($row[0]);
            $compName = ($row[1]);
            $opusLike = ($row[2]);
            $compNum = ($row[3]);
            $compNo = ($row[4]);
            $subTitle = ($row[5]);
            $movement = ($row[6]);
            /*era*/
            if($row[7] !== null) {
                $postEraArray[$row[7]] = 'selected';
            }
            /*voice*/
            if($row[8] !== null) {
                $postVoiceArray[$row[8]] = 'selected';
            }
            /*ensemble*/
            if($row[9] !== null) {
                $postEnsembleArray[$row[9]] = 'selected';
            }

            $compBookID = ($row[10]);


        } /*for loop ending*/
    } /*END result Composition Query*/
    $deletedItem = '$compName';

    /*This composer query and code allows for multiple composers*/
    $composerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r ON  r.ID = C2R2P.role_ID AND r.role_name = 'Composer'
        
        WHERE c.ID = $oldCompositionID;

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
        $composerString= "";

        for ($j = 0 ; $j < $numberOfComposerRows ; ++$j){
            $row = $resultComposerQuery->fetch_array(MYSQLI_NUM);

            $composerID = ($row[0]);
            $compFirst = ($row[1]);
            $compMiddle = ($row[2]);
            $compLast = ($row[3]);
            $compSuffix = ($row[4]);

            $composerString .= $compFirst .  " " . $compMiddle . " " . $compLast . " " . $compSuffix . "</br></br>Composer Name: ";

        } /*for loop ending*/
    } /*END if result composer query*/

    $displayComposerString = rtrim($composerString,'</br>Composer Name: ');



    /*create query to select the arrangers from the database */

    $arrangerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r ON  r.ID = C2R2P.role_ID AND r.role_name = 'Arranger'
       
        WHERE c.ID = $oldCompositionID;

_END;

    if($debug) {
        echo 'arrangerQuery = ' . $arrangerQuery . '<br/><br/>';
    }/*end debug*/

    /*send the query*/
    $resultArrangerQuery = $conn->query($arrangerQuery);


    if($debug) {
        if (!$resultArrangerQuery) echo("\n Error description arrangerQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    if ($resultArrangerQuery){

        $numberOfArrRows = $resultArrangerQuery->num_rows;
        $arrangerString="";

        for ($j = 0 ; $j < $numberOfArrRows ; ++$j){
            $row = $resultArrangerQuery->fetch_array(MYSQLI_NUM);

            $arrangerID = ($row[0]);
            $arrFirst = ($row[1]);
            $arrMiddle = ($row[2]);
            $arrLast = ($row[3]);
            $arrSuffix = ($row[4]);

            $arrangerString .= $arrFirst .  " " . $arrMiddle . " " . $arrLast . " " . $arrSuffix . "</br></br>Arranger Name: ";

        } /*for loop ending*/

    } /*END if result arranger Query*/

    $displayArrangerString = rtrim($arrangerString,'</br>Arranger Name: ');

    /*create query to select the lyricists from the database */

    $lyricistQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r ON r.ID = C2R2P.role_ID AND r.role_name = 'Lyricist'
       
        WHERE c.ID = $oldCompositionID;

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


        $numberOfLyrRows = $resultLyricistQuery->num_rows;
        $lyricistString="";

        for ($j = 0 ; $j < $numberOfLyrRows ; ++$j){
            $row = $resultLyricistQuery->fetch_array(MYSQLI_NUM);

            $lyricistID = ($row[0]);
            $lyrFirst = ($row[1]);
            $lyrMiddle = ($row[2]);
            $lyrLast = ($row[3]);
            $lyrSuffix = ($row[4]);

            $lyricistString .= $lyrFirst .  " " . $lyrMiddle . " " . $lyrLast . " " . $lyrSuffix . "</br></br>Lyricist Name: ";
        } /*for loop ending*/

    } /*END if result lyricist Query*/
    $displayLyricistString = rtrim($lyricistString,'</br>Lyricist Name: ');




} /*END if($editComposition == 'true')*/








/*VALIDATION*/

if(strlen($compName) == 0 && $submit == 'true') {

    $compNameErr = " * Name of Composition is required";
    $compNameErr_value = "<span class=\"error\"> {$compNameErr} </span>";

    $validationFailed = true;
}/*end if(strlen($compName) == 0 && $submit == 'true')*/

    /*add check box validations here*/
    /*if checkbox validation fails, set checkbox error message and validationFailed = true*/
/*TODO  check to see if these need to be changed to strlen*/
if(strlen($postKeySigID == 0 && $submit == 'true')) {
    /*if 0, then no checkboxes checked*/
    $postKeySigIDErr = " * At least one box must be checked";
    $postKeySigIDErr_value = "<span class=\"error\"> {$postKeySigIDErr} </span>";

    $validationFailed = true;
}/*end if(strlen($postKeySigID == 0)*/

if(strlen($postGenreID == 0 && $submit == 'true')) {
    /*if 0, then no checkboxes checked*/
    $postGenreIDErr = " * At least one box must be checked";
    $postGenreIDErr_value = "<span class=\"error\"> {$postGenreIDErr} </span>";

    $validationFailed = true;
}/*end if(strlen($postGenreID == 0)*/

if(strlen($postInstrumentID == 0 && $submit == 'true')) {
    /*if 0, then no checkboxes checked*/
    $postInstrumentIDErr = " * At least one box must be checked";
    $postInstrumentIDErr_value = "<span class=\"error\"> {$postInstrumentIDErr} </span>";

    $validationFailed = true;
}/*end if(strlen($postInstrumentID == 0)*/

/*if(strlen(trim($postEraID) == 0 && $submit == 'true'))*/
if(strlen($postEraID == 0 && $submit == 'true')) {
    $postEraIDErr = " * One item must be selected";
    $postEraIDErr_value = "<span class=\"error\"> {$postEraIDErr} </span>";

    $validationFailed = true;
}/*end if isset post postEraID*/

if(strlen($postVoiceID == 0 && $submit == 'true' )) {
    $postVoiceIDErr = " * One item must be selected";
    $postVoiceIDErr_value = "<span class=\"error\"> {$postVoiceIDErr} </span>";

    $validationFailed = true;
}/*end if not isset post postVoiceID*/

if(strlen($postEnsembleID == 0 && $submit == 'true')) {
    $postEnsembleIDErr = " * One item must be selected";
    $postEnsembleIDErr_value = "<span class=\"error\"> {$postEnsembleIDErr} </span>";

    $validationFailed = true;
}/*end if not isset post postEnsembleID*/

if(strlen($postGenDiffID == 0 && $submit == 'true')) {
    $postGenDiffIDErr = " * One item must be selected";
    $postGenDiffIDErr_value = "<span class=\"error\"> {$postGenDiffIDErr} </span>";

    $validationFailed = true;
}/*end if not isset post postGenDiffID*/

if(strlen($postASPDiffID == 0 && $submit == 'true')) {
    $postASPDiffIDErr = " * One item must be selected";
    $postASPDiffIDErr_value = "<span class=\"error\"> {$postASPDiffIDErr} </span>";

    $validationFailed = true;
}/*end if not isset post postASPDiffID*/


/*todo here is where we loose the opus values*/

/*If any validation failed, save all form values in variables*/
if ($validationFailed = 'true' || $editComposition = 'true') {
    /*store submitted form values so we can pre-populate the form */
    $compName_value = $compName;
    $opus_value = $opusLike;
    $opusNum_value = $compNum;
    $compNum_value = $compNo;
    $subTitle_value = $subTitle;
    $movement_value = $movement;

    $postKeySigID_value = $postKeySigID;

    $postGenreID_value = $postGenreID;

    $postInstrumentID_value = $postInstrumentID;

    $postEraID_value = $postEraID;

    $postVoiceID_value = $postVoiceID;

    $postEnsembleID_value = $postEnsembleID;

    $postGenDiffID_value = $postGenDiffID;

    $postASPDiffID_value = $postASPDiffID;


/*This is not validation, it is finding out which boxes have been checked

    /*Now let's look at all the checkboxes related to keySig*/
    if($postKeySigID > 0) {

        if (in_array("1", $postKeySigID)) { /*if the user didn't check it, it won't be in the array*/
            $postKeySigArray[1] =  "checked";
        }

        if (in_array("2", $postKeySigID)) {
            $postKeySigArray[2] =  "checked";
        }

        if (in_array("3", $postKeySigID)) {
            $postKeySigArray[3] =  "checked";
        }

        if (in_array("4", $postKeySigID)) {
            $postKeySigArray[4] =  "checked";
        }

        if (in_array("5", $postKeySigID)) {
            $postKeySigArray[5] =  "checked";
        }

        if (in_array("6", $postKeySigID)) {
            $postKeySigArray[6] =  "checked";
        }

        if (in_array("7", $postKeySigID)) {
            $postKeySigArray[7] =  "checked";
        }

        if (in_array("8", $postKeySigID)) {
            $postKeySigArray[8] =  "checked";
        }

        if (in_array("9", $postKeySigID)) {
            $postKeySigArray[9] =  "checked";
        }

        if (in_array("10", $postKeySigID)) {
            $postKeySigArray[10] =  "checked";
        }

        if (in_array("11", $postKeySigID)) {
            $postKeySigArray[11] =  "checked";
        }

        if (in_array("12", $postKeySigID)) {
            $postKeySigArray[12] =  "checked";
        }

        if (in_array("13", $postKeySigID)) {
            $postKeySigArray[13] =  "checked";
        }

        if (in_array("14", $postKeySigID)) {
            $postKeySigArray[14] =  "checked";
        }

        if (in_array("15", $postKeySigID)) {
            $postKeySigArray[15] =  "checked";
        }

        if (in_array("16", $postKeySigID)) {
            $postKeySigArray[16] =  "checked";
        }

        if (in_array("17", $postKeySigID)) {
            $postKeySigArray[17] =  "checked";
        }

        if (in_array("18", $postKeySigID)) {
            $postKeySigArray[18] =  "checked";
        }

        if (in_array("19", $postKeySigID)) {
            $postKeySigArray[19] =  "checked";
        }

        if (in_array("20", $postKeySigID)) {
            $postKeySigArray[20] =  "checked";
        }

        if (in_array("21", $postKeySigID)) {
            $postKeySigArray[21] =  "checked";
        }

        if (in_array("22", $postKeySigID)) {
            $postKeySigArray[22] =  "checked";
        }

        if (in_array("23", $postKeySigID)) {
            $postKeySigArray[23] =  "checked";
        }

        if (in_array("24", $postKeySigID)) {
            $postKeySigArray[24] =  "checked";
        }

        if (in_array("25", $postKeySigID)) {
            $postKeySigArray[25] =  "checked";
        }

    }/* End if ($postKeySigID)*/

    /*Now let's look at all the checkboxes related to genre*/





    if($postGenreID > 0) {

        if (in_array("1", $postGenreID)) {
            $postGenreArray[1] =  "checked";
        }

        if (in_array("2", $postGenreID)) {
            $postGenreArray[2] =  "checked";
        }

        if (in_array("3", $postGenreID)) {
            $postGenreArray[3] =  "checked";
        }

        if (in_array("4", $postGenreID)) {
            $postGenreArray[4] =  "checked";
        }

        if (in_array("5", $postGenreID)) {
            $postGenreArray[5] =  "checked";
        }

        if (in_array("6", $postGenreID)) {
            $postGenreArray[6] =  "checked";
        }

        if (in_array("7", $postGenreID)) {
            $postGenreArray[7] =  "checked";
        }

        if (in_array("8", $postGenreID)) {
            $postGenreArray[8] =  "checked";
        }

        if (in_array("9", $postGenreID)) {
            $postGenreArray[9] =  "checked";
        }

        if (in_array("10", $postGenreID)) {
            $postGenreArray[10] =  "checked";
        }

        if (in_array("11", $postGenreID)) {
            $postGenreArray[11] =  "checked";
        }

        if (in_array("12", $postGenreID)) {
            $postGenreArray[12] =  "checked";
        }

        if (in_array("13", $postGenreID)) {
            $postGenreArray[13] =  "checked";
        }


    }/*end if ($post postGenreID > 0)*/





    /*Now let's look at all the checkboxes related to instrument*/
    /*Still in the if validation failed clause*/

    if($postInstrumentID > 0) {

        if (in_array("1", $postInstrumentID)) { /*if the user didn't check it, it won't be in the array*/
            $postInstrumentArray[1] =  "checked";
        }

        if (in_array("2", $postInstrumentID)) {
            $postInstrumentArray[2] =  "checked";
        }

        if (in_array("3", $postInstrumentID)) {
            $postInstrumentArray[3] =  "checked";
        }

        if (in_array("4", $postInstrumentID)) {
            $postInstrumentArray[4] =  "checked";
        }

        if (in_array("5", $postInstrumentID)) {
            $postInstrumentArray[5] =  "checked";
        }

        if (in_array("6", $postInstrumentID)) {
            $postInstrumentArray[6] =  "checked";
        }

        if (in_array("7", $postInstrumentID)) {
            $postInstrumentArray[7] =  "checked";
        }

    }/*end if ($postInstrumentID > 0 )*/


    /*Now let's look at all the options related to era*/

    if($postEraID > 0) {

        if ($postEraID == 1) {
            $postEraArray[1] = "selected";
        }

        if ($postEraID == 2) {
            $postEraArray[2] = "selected";
        }

        if ($postEraID == 3) {
            $postEraArray[3] = "selected";
        }

        if ($postEraID == 4) {
            $postEraArray[4] = "selected";
        }

        if ($postEraID == 5) {
            $postEraArray[5] = "selected";
        }

        if ($postEraID == 6) {
            $postEraArray[6] = "selected";
        }

        if ($postEraID == 7) {
            $postEraArray[7] = "selected";
        }

    }/*end if($postEraID > 0 )*/



    /*Now let's look at all the options related to voice*/
    if($postVoiceID > 0) {

        if ($postVoiceID == 1) {
            $postVoiceArray[1] = "selected";
        }

        if ($postVoiceID == 2) {
            $postVoiceArray[2] = "selected";
        }

        if ($postVoiceID == 3) {
            $postVoiceArray[3] = "selected";
        }

        if ($postVoiceID == 4) {
            $postVoiceArray[4] = "selected";
        }

        if ($postVoiceID == 5) {
            $postVoiceArray[5] = "selected";
        }

        if ($postVoiceID == 6) {
            $postVoiceArray[6] = "selected";
        }

        if ($postVoiceID == 7) {
            $postVoiceArray[7] = "selected";
        }

        if ($postVoiceID == 8) {
            $postVoiceArray[8] = "selected";
        }

        if ($postVoiceID == 9) {
            $postVoiceArray[9] = "selected";
        }

        if ($postVoiceID == 10) {
            $postVoiceArray[10] = "selected";
        }

        if ($postVoiceID == 11) {
            $postVoiceArray[11] = "selected";
        }

        if ($postVoiceID == 12) {
            $postVoiceArray[12] = "selected";
        }

    }/*end if($postVoiceID > 0)*/




    /*Now let's look at all the options related to ensemble*/

    if($postEnsembleID > 0 ) {

        if($postEnsembleID == 1) {
            $postEnsembleArray[1] = "selected";
        }

        if($postEnsembleID == 2) {
            $postEnsembleArray[2] = "selected";
        }

        if($postEnsembleID == 3) {
            $postEnsembleArray[3] = "selected";
        }

        if($postEnsembleID == 4) {
            $postEnsembleArray[4] = "selected";
        }

        if($postEnsembleID == 5) {
            $postEnsembleArray[5] = "selected";
        }

        if($postEnsembleID == 6) {
            $postEnsembleArray[6] = "selected";
        }

        if($postEnsembleID == 7) {
            $postEnsembleArray[7] = "selected";
        }

        if($postEnsembleID == 8) {
            $postEnsembleArray[8] = "selected";
        }

        if($postEnsembleID == 9) {
            $postEnsembleArray[9] = "selected";
        }

        if($postEnsembleID == 10) {
            $postEnsembleArray[10] = "selected";
        }

        if($postEnsembleID == 11) {
            $postEnsembleArray[11] = "selected";
        }

        if($postEnsembleID == 12) {
            $postEnsembleArray[12] = "selected";
        }

        if($postEnsembleID == 13) {
            $postEnsembleArray[13] = "selected";
        }

        if($postEnsembleID == 14) {
            $postEnsembleArray[14] = "selected";
        }

        if($postEnsembleID == 15) {
            $postEnsembleArray[15] = "selected";
        }

        if($postEnsembleID == 16) {
            $postEnsembleArray[16] = "selected";
        }

        if($postEnsembleID == 17) {
            $postEnsembleArray[17] = "selected";
        }

        if($postEnsembleID == 18) {
            $postEnsembleArray[18] = "selected";
        }



    }/*end if($postEnsembleID > 0 )*/


    /*Now let's look at all the options related to GenDiff*/

    if($postGenDiffID > 0 ) {

        if($postGenDiffID == 1) {
            $postGenDiffArray[1] = "selected";
        }

        if($postGenDiffID == 2) {
            $postGenDiffArray[2] = "selected";
        }

        if($postGenDiffID == 3) {
            $postGenDiffArray[3] = "selected";
        }

        if($postGenDiffID == 4) {
            $postGenDiffArray[4] = "selected";
        }

        if($postGenDiffID == 5) {
            $postGenDiffArray[5] = "selected";
        }

        if($postGenDiffID == 6) {
            $postGenDiffArray[6] = "selected";
        }

        if($postGenDiffID == 7) {
            $postGenDiffArray[7] = "selected";
        }

        if($postGenDiffID == 8) {
            $postGenDiffArray[8] = "selected";
        }

        if($postGenDiffID == 9) {
            $postGenDiffArray[9] = "selected";
        }

        if($postGenDiffID == 10) {
            $postGenDiffArray[10] = "selected";
        }

    }/*end if($postGenDiffID > 0 )*/


    /*Now let's look at all the checkboxes related to ASPDiff*/

    if($postASPDiffID > 0 ) {

        if($postASPDiffID == 11) {
            $postASPDiffArray[11] = "selected";
        }

        if($postASPDiffID == 12) {
            $postASPDiffArray[12] = "selected";
        }

        if($postASPDiffID == 13) {
            $postASPDiffArray[13] = "selected";
        }

        if($postASPDiffID == 14) {
            $postASPDiffArray[14] = "selected";
        }

        if($postASPDiffID == 15) {
            $postASPDiffArray[15] = "selected";
        }

        if($postASPDiffID == 16) {
            $postASPDiffArray[16] = "selected";
        }

        if($postASPDiffID == 17) {
            $postASPDiffArray[17] = "selected";
        }

        if($postASPDiffID == 18) {
            $postASPDiffArray[18] = "selected";
        }

        if($postASPDiffID == 19) {
            $postASPDiffArray[19] = "selected";
        }

        if($postASPDiffID == 20) {
            $postASPDiffArray[20] = "selected";
        }

        if($postASPDiffID == 21) {
            $postASPDiffArray[21] = "selected";
        }

        if($postASPDiffID == 22) {
            $postASPDiffArray[22] = "selected";
        }

        if($postASPDiffID == 23) {
            $postASPDiffArray[23] = "selected";
        }

        if($postASPDiffID == 24) {
            $postASPDiffArray[24] = "selected";
        }

        if($postASPDiffID == 25) {
            $postASPDiffArray[25] = "selected";
        }

        if($postASPDiffID == 26) {
            $postASPDiffArray[26] = "selected";
        }

        if($postASPDiffID == 27) {
            $postASPDiffArray[27] = "selected";
        }

        if($postASPDiffID == 28) {
            $postASPDiffArray[28] = "selected";
        }

        if($postASPDiffID == 29) {
            $postASPDiffArray[29] = "selected";
        }

        if($postASPDiffID == 30) {
            $postASPDiffArray[30] = "selected";
        }

        if($postASPDiffID == 31) {
            $postASPDiffArray[31] = "selected";
        }

        if($postASPDiffID == 32) {
            $postASPDiffArray[32] = "selected";
        }

        if($postASPDiffID == 33) {
            $postASPDiffArray[33] = "selected";
        }

        if($postASPDiffID == 34) {
            $postASPDiffArray[34] = "selected";
        }

    }/*end if($postASPDiffID < 0 )*/


}/*end if validationFailed*/




/*Validation successful!
Here we wash all values that come from the form*/

if (!$validationFailed && $submit=='true') {

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


} /*END if (!$validationFailed && $submit=='true')*/



/*This is the code that will update the composition table with the changes we made to the current Composition information.
When we click on submit below the form, the user is returned to this same page to validate the edited information and then, if we are editing current composition info,  it is here where that new information is updated in the composition table. (All values are updated in the Composition table except keysignature, genre, and instrument.
We then delete the row(s) from the C2K, C2G and C2I tables and insert the new values into those tables.
The $submit variable tells us this is not our first time through the code.  */

if ($oldCompositionID !== '' && $editComposition == 'true' && $submit == 'true') {

    /*deleting current rows from the C2K, C2G, and C2I tables*/

    $deleteC2I = <<<_END

    DELETE FROM C2I
    WHERE C2I.composition_ID = $oldCompositionID;

_END;

    if ($debug) {
        echo 'deleteC2I = ' . $deleteC2I . '<br/><br/>';
    }/*end debug*/

    /*send the query*/
    $deleteC2IResult = $conn->query($deleteC2I);

    if ($debug) {
        if (!$deleteC2IResult) echo("\n Error description deleteC2I: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/
    /*end delete from C2I*/


    /*delete from C2K*/
    if ($deleteC2IResult) {
        $deleteC2K = <<<_END

            DELETE FROM C2K
            WHERE C2K.composition_ID = $oldCompositionID;

_END;

        if ($debug) {
            echo '$deleteC2K = ' . $deleteC2K . '<br/><br/>';
        }/*end debug*/

        /*send the query*/
        $deleteC2KResult = $conn->query($deleteC2K);

        if ($debug) {
            if (!$deleteC2KResult) echo("\n Error description deleteC2K: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

        /*End deleting from C2K*/

    } /*End if ($deleteC2IResult)*/


    if ($deleteC2KResult) {
            $deleteC2G = <<<_END

                DELETE FROM C2G
                WHERE C2G.composition_ID  = $oldCompositionID;

_END;

            if ($debug) {
                echo 'deleteC2G = ' . $deleteC2G . '<br/><br/>';
            }/*end debug*/

            /*send the query*/
            $deleteC2GResult = $conn->query($deleteC2G);

            if ($debug) {
                if (!$deleteC2GResult) echo("\n Error description deleteC2G: " . mysqli_error($conn) . "\n<br/>");
            }/*end debug*/

    } /*End if ($deleteC2IResult)*/




    /*updating all values in the composition table*/
    if ($deleteC2KResult) {
        $updateCompositions = <<<_END
        UPDATE compositions AS c
        SET  	c.comp_name = '$compName',
        c.opus_like = '$opus'
        c.comp_num = $opusNum,
        c.comp_no = $compNum, 
        c.subtitle = '$subTitle',
        c.book_ID = $bookID,
        c.movement = '$movement',
        c.era_ID = $postEraID,
        c.voice_ID = $postVoiceID,
        c.ensemble_ID = $postEnsembleID                             
        WHERE c.ID = $oldCompositionID;
        
_END;

        $updateCompositionsResult = $conn->query($updateCompositions);

        if ($debug) {
            echo("\nupdateCompositions = " . $updateCompositions . "\n<br/>");
            if (!$updateCompositionsResult) echo("\n Error description updateCompositions: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

    } /*End if ($deleteC2KResult)*/




    if ($updateCompositionsResult) {

        /*inserting the new information into the the C2k, C2G and C2I tables*/
        /*see composition Options line 756 inserting into the C2K table*/

        /*Here i must go find the id number for each key signature entered by the user and insert a row into the C2K table */

        if (!is_array($postKeySigArray)) {
            if ($debug) {
                echo '$postKeySigArray is not an array' . $postKeySigArray;
            }/*end debug*/
        } else {
            foreach ($postKeySigArray as &$value) {
                if ($debug) {
                    echo $postKeySigArray . " = " . $value;
                }/*end debug*/

                $C2KInsertQuery = <<<_END
                INSERT INTO C2K (composition_ID, keysig_ID)
                VALUES ('$oldCompositionID', '$value');

_END;

                if ($debug) {
                    echo("\n C2KInsertQuery= " . $C2KInsertQuery . "\n<br/>");
                }/*end debug*/

                /*send query and place result into this variable*/
                $C2KInsertQueryResult = $conn->query($C2KInsertQuery);

                if ($debug) {
                    if (!$C2KInsertQueryResult) echo("\n Error description C2KInsertQuery: " . mysqli_error($conn) . "\n<br/>");
                }/*end debug*/
            }/*end foreach keysig Array*/
        }/*end if is array*/
    } /*End if ($updateCompositionResult)*/



/*Now, insert into    C2G*/
/*Here i must go find the id number for each genre entered by the user and insert a row into the C2G table */
    if (!is_array($postGenreArray)) {
        if ($debug) {
            echo '$postGenreArray is not an array' . $postGenreArray;
        }/*end debug*/
    } else {
        foreach ($postGenreArray as &$value) {
            $C2GInsertQuery = <<<_END
            INSERT INTO C2G (composition_ID, genre_ID)
            VALUES ('$oldCompositionID', '$value');

_END;

            if ($debug) {
                echo("\n C2GInsertQuery= " . $C2GInsertQuery . "\n<br/>");
            }/*end debug*/

            /*send query and place result into this variable*/
            $C2GInsertQueryResult = $conn->query($C2GInsertQuery);

            if ($debug) {
                if (!$C2GInsertQueryResult) echo("\n Error description C2GInsertQuery: " . mysqli_error($conn) . "\n<br/>");
            }/*end debug*/

        }/*end foreach genre Array*/

    }/*!is_array($postGenreArray)*/


/*Now, insert into C2I*/
/*Here i must go find the id number for each instrument entered by the user and insert a row into the C2I table */
    if (!is_array($postInstrumentArray)) {
        if ($debug) {
            echo '$postInstrumentArray is not an array' . $postInstrumentArray;
        }/*end debug*/

    } else {
        foreach ($postInstrumentArray as &$value) {
            $C2IInsertQuery = <<<_END
            INSERT INTO C2I (composition_ID, instrument_ID)
            VALUES ('$oldCompositionID', '$value');

_END;

            if ($debug) {
                echo("\n C2IInsertQuery= " . $C2IInsertQuery . "\n<br/>");
            }/*end debug*/

            /*send query and place result into this variable*/
            $C2IInsertQueryResult = $conn->query($C2IInsertQuery);

            if ($debug) {
                if (!$C2IInsertQueryResult) echo("\n Error description C2IInsertQuery: " . mysqli_error($conn) . "\n<br/>");
            }/*end debug*/
        }/*end foreach instrument Array*/
    }/* end $postInstrumentArray is array*/



    if ($C2IInsertQueryResult) {
        header('Location: editComposition.php?bookID=' . $bookID . '&oldCompositionID=' . $oldCompositionID . '&editComposition=true');
        exit();
    } /*End if ($C2IInsertQueryResult)*/


} /*End if ($oldCompositionID !== '' && $editComposition == 'true' && $submit == 'true')*/




/*HTML  form*/

/*THis is the first three text boxes in the add composition form*/
echo <<<_END


<div class="container-fluid bg-light pt-4 ">
 <h2 class="pb-4" >Add Composition Information below</h2>
  <form class="pb-4" action='addComposition.php' method='post'>
   

  <div class="row">
    <div class="col-md-6">
      <div class="card  mb-3">
        <div class="card-body bg-light">   
        <div class="form-group">

            <label for="compositionName">Composition Name: <span class="error">{$compNameErr_value}</span></label>
            <input type="text" class="form-control" id="compositionName" name="compName" value="{$compName_value}" /><br/>

            <label for="opusLike">Opus-Like: </label>
            <input type="text" class="form-control" id="opusLike" name="opus" value="{$opus_value}"/><br/>

            <label for="opusNum">Opus No.: </label>
            <input type="text" class="form-control" id="opusNum" name="opusNum" value="{$opusNum_value}"/><br/>



           </div> <!-- end form-group -->
        </div> <!-- end card-body -->
     </div> <!-- end card -->
  </div> <!-- end col -->
  
 
  <div class="col-md-6">
    <div class="card mb-3">
      <div class="card-body bg-light">   
        <div class="form-group">

_END;

/*This is the second three text boxes in the add composition form*/


    echo<<<_END

                <label for="compositionNum">Composition No.: </label>
                <input type="number" class="form-control" id="compositionNum" name="compNum" min="0" value="{$compNum_value}"/><br/>

                <label for="subTitle">Subtitle: </label> 
                <input type="text" class="form-control" id="subTitle" name="subTitle" value="{$subTitle_value}"/><br/>

                <label for="mvmnt">Movement: </label>
                <input type="text" class="form-control" id="mvmnt" name="movement" value="{$movement_value}"/><br/>


          </div> <!-- end form-group -->
        </div> <!-- end card-body -->
      </div> <!-- end card -->
    </div> <!-- end col -->
  </div> <!-- end row -->
    
_END;

/*keysig checkboxes*/

echo <<<_END

<div class="row">
  <div class="col-md-4">     
    <div class="card mb-3">
      <div class="card-body bg-light">

            <h6>Key Signature: choose as many as apply</h6>
            <span class="error">{$postKeySigIDErr_value}</span>

            <div class="form-check">   
                <input type="checkbox" class="form-check-input" id="chk1" name="postKeySigID[]" value="1" {$postKeySigArray[1]}>  none<br>
                <label class="form-check-label sr-only" for="chk1"></label>
            </div> <!-- end form-check -->

            <div class="form-check"> 
                <input type="checkbox" class="form-check-input" id="chk2" name="postKeySigID[]" value="2" {$postKeySigArray[2]}>  C Major<br>
                <label class="form-check-label sr-only" for="chk2"></label>
            </div> <!-- end form-check -->

            <div class="form-check"> 
                <input type="checkbox" class="form-check-input"  id="chk3" name="postKeySigID[]" value="3" {$postKeySigArray[3]}>  G Major<br>
                <label class="form-check-label sr-only" for="chk3"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox" class="form-check-input"  id="chk4" name="postKeySigID[]" value="4" {$postKeySigArray[4]}>  D Major<br>
                <label class="form-check-label sr-only" for="chk4"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk5" name="postKeySigID[]" value="5" {$postKeySigArray[5]}>  A Major<br>
                <label class="form-check-label sr-only" for="chk5"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk6" name="postKeySigID[]" value="6" {$postKeySigArray[6]}>  E Major<br>
                <label class="form-check-label sr-only" for="chk6"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk7" name="postKeySigID[]" value="7" {$postKeySigArray[7]}>  B Major<br>
                <label class="form-check-label sr-only" for="chk7"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk8" name="postKeySigID[]" value="8" {$postKeySigArray[8]}>  Gb Major<br>
                <label class="form-check-label sr-only" for="chk8"></label>
            </div> <!-- end form-check -->

            <div class="form-check">  
                <input type="checkbox"  class="form-check-input"  id="chk9" name="postKeySigID[]" value="9" {$postKeySigArray[9]}>  Db Major<br>
                <label class="form-check-label sr-only" for="chk9"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk10" name="postKeySigID[]" value="10" {$postKeySigArray[10]}>  Ab Major<br>
                <label class="form-check-label sr-only" for="chk10"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk11" name="postKeySigID[]" value="11" {$postKeySigArray[11]}>  Eb Major<br>
                <label class="form-check-label sr-only" for="chk11"></label>
             </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk12" name="postKeySigID[]" value="12" {$postKeySigArray[12]}>  Bb Major<br>
                <label class="form-check-label sr-only" for="chk12"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk13" name="postKeySigID[]" value="13" {$postKeySigArray[13]}>  F Major<br>
                <label class="form-check-label sr-only" for="chk13"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk14" name="postKeySigID[]" value="14" {$postKeySigArray[14]}>  a minor<br>
                <label class="form-check-label sr-only" for="chk14"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk15" name="postKeySigID[]" value="15" {$postKeySigArray[15]}>  e minor<br>
                <label class="form-check-label sr-only" for="chk15"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk16" name="postKeySigID[]" value="16" {$postKeySigArray[16]}>  b minor<br>
                <label class="form-check-label sr-only" for="chk16"></label>
            </div> <!-- end form-check -->
      
            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk17" name="postKeySigID[]" value="17" {$postKeySigArray[17]}>  f# minor<br>
                <label class="form-check-label sr-only" for="chk17"></label>
                </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk18" name="postKeySigID[]" value="18" {$postKeySigArray[18]}>  c# minor<br>
                <label class="form-check-label sr-only" for="chk18"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk19" name="postKeySigID[]" value="19" {$postKeySigArray[19]}>  g# minor<br>
                <label class="form-check-label sr-only" for="chk19"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk20" name="postKeySigID[]" value="20" {$postKeySigArray[20]}>  eb minor<br>
                <label class="form-check-label sr-only" for="chk20"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk21" name="postKeySigID[]" value="21" {$postKeySigArray[21]}>  bb minor<br>
                <label class="form-check-label sr-only" for="chk21"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk22" name="postKeySigID[]" value="22" {$postKeySigArray[22]}>  f minor<br>
                <label class="form-check-label sr-only" for="chk22"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk23" name="postKeySigID[]" value="23" {$postKeySigArray[23]}>  c minor<br>
                <label class="form-check-label sr-only" for="chk23"></label>
            </div> <!-- end form-check -->

            <div class="form-check">
                <input type="checkbox"  class="form-check-input"  id="chk24" name="postKeySigID[]" value="24" {$postKeySigArray[24]}>  g minor<br>
                <label class="form-check-label sr-only" for="chk24"></label>
            </div> <!-- end form-check -->

            <div class="form-check pb-4">
                <input type="checkbox"  class="form-check-input"  id="chk25" name="postKeySigID[]" value="25" {$postKeySigArray[25]}>  d minor<br>
                <label class="form-check-label sr-only" for="chk25"></label>

        </div> <!-- end form-check -->
    </div> <!-- end card-body -->
  </div> <!-- end card -->
</div> <!-- end col -->


_END;


echo<<<_END

 <div class="col-md-4">
   <div class="card mb-3">
      <div class="card-body bg-light">

        <h6>Genre: choose as many as apply</h6>
        <span class="error">{$postGenreIDErr_value}</span>

      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chbx1" name="postGenreID[]" value="1" {$postGenreArray[1]}>none<br>
        <label class="form-check-label sr-only" for="chbx1"></label>
      </div> <!-- end form-check -->


      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx2" name="postGenreID[]" value="2" {$postGenreArray[2]}>Jazz<br>
        <label class="form-check-label sr-only" for="chbx2"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx3" name="postGenreID[]" value="3" {$postGenreArray[3]}>Christmas<br>
        <label class="form-check-label sr-only" for="chbx3"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx4" name="postGenreID[]" value="4" {$postGenreArray[4]}>Halloween<br>
        <label class="form-check-label sr-only" for="chbx4"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx5" name="postGenreID[]" value="5" {$postGenreArray[5]}>Blues<br>
        <label class="form-check-label sr-only" for="chbx5"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx6" name="postGenreID[]" value="6" {$postGenreArray[6]}>Rag<br>
        <label class="form-check-label sr-only" for="chbx6"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx7" name="postGenreID[]" value="7" {$postGenreArray[7]}>Pop<br>
        <label class="form-check-label sr-only" for="chbx7"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx8" name="postGenreID[]" value="8" {$postGenreArray[8]}>Country<br>
        <label class="form-check-label sr-only" for="chbx8"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx9" name="postGenreID[]" value="9" {$postGenreArray[9]}>Madrigal<br>
        <label class="form-check-label sr-only" for="chbx9"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx10" name="postGenreID[]" value="10" {$postGenreArray[10]}>Technique<br>
        <label class="form-check-label sr-only" for="chbx10"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx11" name="postGenreID[]" value="11" {$postGenreArray[11]}>Method Book<br>
        <label class="form-check-label sr-only" for="chbx11"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="chbx12" name="postGenreID[]" value="12" {$postGenreArray[12]}>Classical<br>
        <label class="form-check-label sr-only" for="chbx12"></label>
      </div> <!-- end form-check -->

      <div class="form-check pb-4">
        <input type="checkbox" class="form-check-input" id="chbx13" name="postGenreID[]" value="13" {$postGenreArray[13]}>Other<br>
        <label class="form-check-label sr-only" for="chbx13"></label>
  
        </div> <!-- end form-check -->
      </div> <!-- end card-body -->
    </div> <!-- end card -->
  </div> <!-- end col -->


    
  <div class="col-md-4">
    <div class="card mb-3">
       <div class="card-body bg-light">


      <h6>Instrument:choose as many as apply</h6>
      <span class="error">{$postInstrumentIDErr_value}</span>

      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chkbx7" name="postInstrumentID[]" value="7" {$postInstrumentArray[7]}>  none<br>
        <label class="form-check-label sr-only" for="chkbx7"></label>
      </div> <!-- end form-check -->

      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chkbx1" name="postInstrumentID[]" value="1" {$postInstrumentArray[1]}>  Piano<br>
        <label class="form-check-label sr-only" for="chkbx1"></label>
      </div> <!-- end form-check -->


      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chkbx2" name="postInstrumentID[]" value="2" {$postInstrumentArray[2]}>  Voice<br>
        <label class="form-check-label sr-only" for="chkbx2"></label>
      </div> <!-- end form-check -->


      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chkbx3" name="postInstrumentID[]" value="3" {$postInstrumentArray[3]}>  Trumpet<br>
        <label class="form-check-label sr-only" for="chkbx3"></label>
      </div> <!-- end form-check -->


      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chkbx4" name="postInstrumentID[]" value="4" {$postInstrumentArray[4]}>  Violin<br>
        <label class="form-check-label sr-only" for="chkbx4"></label>
      </div> <!-- end form-check -->


      <div class="form-check">
        <input type="checkbox"  class="form-check-input" id="chkbx5" name="postInstrumentID[]" value="5" {$postInstrumentArray[5]}>  Viola<br>
        <label class="form-check-label sr-only" for="chkbx5"></label>
      </div> <!-- end form-check -->


      <div class="form-check pb-4">
        <input type="checkbox"  class="form-check-input" id="chkbx6" name="postInstrumentID[]" value="6" {$postInstrumentArray[6]}>  Guitar<br>
        <label class="form-check-label sr-only" for="chkbx6"></label>

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
              {$postEraIDErr_value}
        
              <select  class="form-control" id="era" name="postEraID">
              <option value="7" {$postEraArray[7]}>none</option>
              <option value="1" {$postEraArray[1]}>Ancient pre 1600</option>
              <option value="2" {$postEraArray[2]}>Baroque 1600-1750</option>
              <option value="3" {$postEraArray[3]}>Classical 1750-1810</option>
              <option value="4" {$postEraArray[4]}>Romantic 1780-1910</option>
              <option value="5" {$postEraArray[5]}>Modern 1890-1930</option>
              <option value="6" {$postEraArray[6]}>Contemporary 1930-Present</option>
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
            <span class="error">{$postVoiceIDErr_value}</span>
            <select  class="form-control" id="voice"  name="postVoiceID">
              <option value="12" {$postVoiceArray[12]}>none</option>
              <option value="1" {$postVoiceArray[1]}>SA</option>
              <option value="2" {$postVoiceArray[2]}>SSA</option>
              <option value="3" {$postVoiceArray[3]}>SSAA</option>
              <option value="4" {$postVoiceArray[4]}>ST</option>
              <option value="5" {$postVoiceArray[5]}>TTBB</option>
              <option value="6" {$postVoiceArray[6]}>SB</option>
              <option value="7" {$postVoiceArray[7]}>SAB</option>
              <option value="8" {$postVoiceArray[8]}>SATB</option>
              <option value="9" {$postVoiceArray[9]}>TBB</option>
              <option value="10" {$postVoiceArray[10]}>TBB</option>
              <option value="11" {$postVoiceArray[11]}>TB</option>
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
          
_END;

echo<<<_END

               <label for="ens">Ensemble: choose one</label>
               <span class="error">{$postEnsembleIDErr_value}</span>
               <select  class="form-control" id="voice" name="postEnsembleID">
                  <option value="18" {$postEnsembleArray[18]}>none</option>
                  <option value="1" {$postEnsembleArray[1]}>Solo a capella</option>
                  <option value="2" {$postEnsembleArray[2]}>Duet a capella</option>
                  <option value="3" {$postEnsembleArray[3]}>Trio a capella</option>
                  <option value="4" {$postEnsembleArray[4]}>Quartet a capella</option>
                  <option value="5" {$postEnsembleArray[5]}>Quintet a capella</option>
                  <option value="6" {$postEnsembleArray[6]}>Ensemble</option>
                  <option value="7" {$postEnsembleArray[7]}>Solo-Accompanied</option>
                  <option value="8" {$postEnsembleArray[8]}>Duet-Accompanied</option>
                  <option value="9" {$postEnsembleArray[9]}>Trio-Accompanied</option>
                  <option value="10" {$postEnsembleArray[10]}>Quartet-Accompanied</option>
                  <option value="11" {$postEnsembleArray[11]}>Quintet-Accompanied</option>
                  <option value="12" {$postEnsembleArray[12]}>Ensemble-Accompanied</option>
                  <option value="13" {$postEnsembleArray[13]}>Band</option>
                  <option value="14" {$postEnsembleArray[14]}>Orchestra</option>
                  <option value="15" {$postEnsembleArray[15]}>Choir</option>
                  <option value="16" {$postEnsembleArray[16]}>Choir-Accompanied</option>
                  <option value="17" {$postEnsembleArray[17]}>other</option>
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
              <span class="error">{$postGenDiffIDErr_value}</span>
              <select  class="form-control" id="genDiff" name="postGenDiffID">
                <option value="10" {$postGenDiffArray[10]}>none</option>
                <option value="1" {$postGenDiffArray[1]}>Gen EE / ASP 1</option>
                <option value="2" {$postGenDiffArray[2]}>Gen E / ASP 2</option>
                <option value="3" {$postGenDiffArray[3]}>Gen LE / ASP 3</option>
                <option value="4" {$postGenDiffArray[4]}>Gen EI / ASP 4</option>
                <option value="5" {$postGenDiffArray[5]}>Gen I / ASP 5-6</option>
                <option value="6" {$postGenDiffArray[6]}>Gen LI / ASP 7</option>
                <option value="7" {$postGenDiffArray[7]}>Gen EA / ASP 8</option>
                <option value="8" {$postGenDiffArray[8]}>Gen A / ASP 9-19</option>
                <option value="9" {$postGenDiffArray[9]}>Gen LA / ASP 11-12</option>
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
            <span class="error">{$postASPDiffIDErr_value}</span>
            <select  class="form-control" id="aspDiff" name="postASPDiffID">
                    <option value="34" {$postASPDiffArray[34]}>none</option>
                    <option value="11" {$postASPDiffArray[11]}>ASP 1 / Gen EE</option>
                    <option value="12" {$postASPDiffArray[12]}>ASP 1-2 / Gen EE-E</option>
                    <option value="13" {$postASPDiffArray[13]}>ASP 2 / Gen E</option>
                    <option value="14" {$postASPDiffArray[14]}>ASP 2-3 / Gen E-LE </option>
                    <option value="15" {$postASPDiffArray[15]}>ASP 3 / Gen LE</option>
                    <option value="16" {$postASPDiffArray[16]}>ASP 3-4 / Gen LE-EI</option>
                    <option value="17" {$postASPDiffArray[17]}>ASP 4 / Gen EI</option>
                    <option value="18" {$postASPDiffArray[18]}>ASP 4-5 / Gen EI-I</option>
                    <option value="19" {$postASPDiffArray[19]}>ASP 5 / Gen I</option>
                    <option value="20" {$postASPDiffArray[20]}>ASP 5-6 / Gen I</option>
                    <option value="21" {$postASPDiffArray[21]}>ASP 6 / Gen I</option>
                    <option value="22" {$postASPDiffArray[22]}>ASP 6-7 / Gen I-LI</option>
                    <option value="23" {$postASPDiffArray[23]}>ASP 7 / Gen LI</option>
                    <option value="24" {$postASPDiffArray[24]}>ASP 7-8 / Gen LI-EA</option>
                    <option value="25" {$postASPDiffArray[25]}>ASP 8 / Gen EA</option>
                    <option value="26" {$postASPDiffArray[26]}>ASP 8-9 / Gen EA-A</option>
                    <option value="27" {$postASPDiffArray[27]}>ASP 9 / Gen A</option>
                    <option value="28" {$postASPDiffArray[28]}>ASP 9-10 / Gen A</option>
                    <option value="29" {$postASPDiffArray[29]}>ASP 10 / Gen A</option>
                    <option value="30" {$postASPDiffArray[30]}>ASP 10-11 / Gen A-LA</option>
                    <option value="31" {$postASPDiffArray[31]}>ASP 11 / Gen LA</option>
                    <option value="32" {$postASPDiffArray[32]}>ASP 11-12 / Gen LA</option>
                    <option value="33" {$postASPDiffArray[33]}>ASP 12 / Gen LA</option>
            </select>


          </div> <!-- end form-group -->  
        </div> <!-- end card-body -->
      </div> <!-- end card -->     
    </div> <!-- end col -->
  </div> <!--end row-->


    <input class="btn btn-secondary" type='submit' value='Submit & Continue'/>
    <input type='hidden' name="bookID" value='$bookID'/>
    <input type='hidden' name="oldCompositionID" value='$oldCompositionID'/>
    <input type='hidden' name="submit" value='true'/>
    $sendEditComposition
  

   
  </form>  <!--end form-->
</div>  <!--end container-->

_END;

/*When button is clicked, the form returns the code to itself (addComposition.php to validate any new information in the code. If the code validates the user will be sent via header to editComposition where the user can decide what they would like to do next. */










/*We will insert our New Composer information to the db if
    -we are adding a new Composer to a current composition where there is no Composer info or
    -we are adding another Composer to the current composition that does not already exist in the db
    -we are replacing existing Composer information for a current composition but the New Composer does not yet exist in the db and we have added the info to the form*/








/*Here we add some additional variables to change the wording in different situations*/




/*Edit existing Composer, Arranger, or Lyricist info
This searches the db for the current Composer, arranger or Lyricist
Pre-populates the form with current Composer,arranger or lyricist info so user can correct spellings or complete incomplete portions.
When submitted, those new values will be validated and the people table will be updated*/


include 'footer.html';
include 'endingBoilerplate.php';

?>