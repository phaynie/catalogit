<?php
include 'boilerplate.php';

if($debug) {
    echo <<<_END

 <p>advancedSearch.php-37</p>

_END;

}/*end debug*/

$debug_string = "";

include 'beginningNav.php';

/*Initialize variables holding values from previous page*/
$submit = "";
$compositionID = "";
$oldCompositionID = "";
$editComposition = "";
$addNewComposition = "";
$bookID = "";
$advSearch = "";


/*Initialize local Variables */

$compName = "";
$opus = "";
$opusLike = "";
$opusNum = "";
$compNum = "";
$subTitle = "";
$movement = "";

$keySigs = array();
$genres = array();

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







/*Initialize variables coming from previous page*/
$findInstrument = "";
$findEra = "";
$findDifficulty = "";
$findGenre = "";
$instruments = "";
$searchBoxGeneralInst = "";
$searchBoxGeneralComposer = "";
$searchBoxGeneralArr = "";
$searchBoxGeneralLyr = "";

/*Initialize variables to be used in the form*/


$difficultyErr = "";

$leadText = "";
$buttonText = "";
$textBoxText = "";
$labelText = "";
$checkBoxLabelText = "";
$errorMessage = "";




/*assign local variables to values from Request array (from previous page)*/

if (isset($_REQUEST['bookID']) && is_numeric($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if (isset($_REQUEST['submit'])) {
    $submit = $_REQUEST['submit'];
}

if (isset($_REQUEST['advSearch'])) {
    $advSearch = $_REQUEST['advSearch'];
}

if (isset($_REQUEST['compositionID']) && is_numeric($_REQUEST['compositionID'])) {
    $compositionID = $_REQUEST['compositionID'];
}

if (isset($_REQUEST['oldCompositionID']) && is_numeric($_REQUEST['oldCompositionID'])) {
    $oldCompositionID = $_REQUEST['oldCompositionID'];
}

if (isset($_REQUEST['editComposition'])) {
    $editComposition = $_REQUEST['editComposition'];
}

if (isset($_REQUEST['addNewComposition'])) {
    $addNewComposition = $_REQUEST['addNewComposition'];
}


if (isset($_REQUEST['physCompositionLocNote'])) {
    $physCompositionLocNote = $_REQUEST['physCompositionLocNote'];
}

if (isset($_REQUEST['searchBoxGeneralCompTitle'])) {
    $searchBoxGeneralCompTitle = $_REQUEST['searchBoxGeneralCompTitle'];
}

if (isset($_REQUEST['searchBoxGeneralInst'])) {
    $searchBoxGeneralInst = $_REQUEST['searchBoxGeneralInst'];
}

if (isset($_REQUEST['searchBoxGeneralComposer'])) {
    $searchBoxGeneralComposer = $_REQUEST['searchBoxGeneralComposer'];
}

if (isset($_REQUEST['searchBoxGeneralArr'])) {
    $searchBoxGeneralArr = $_REQUEST['searchBoxGeneralArr'];
}

if (isset($_REQUEST['searchBoxGeneralLyr'])) {
    $searchBoxGeneralLyr = $_REQUEST['searchBoxGeneralLyr'];
}



/*create local variables for the REQUEST values*/

if(isset($_REQUEST['findInstrument'])) {
    $findInstrument = $_REQUEST['findInstrument'];
}

if(isset($_REQUEST['findEra'])) {
    $findEra = $_REQUEST['findEra'];
}

if(isset($_REQUEST['findDifficulty'])) {
    $findDifficulty = $_REQUEST['findDifficulty'];
}

if(isset($_REQUEST['findGenre'])) {
    $findGenre = $_REQUEST['findGenre'];
}











/*assigning variable names to other situations*/

if ($advSearch == 'true') {
    $sendAdvSearch = "<input type='hidden' name='advSearch' value= 'true' />";
}




/*AUTOCOMPLETE TEXT BOXES*/

/*retrieve  instrument name values from db and put into an array*/


$instrumentsArray = "";
$instrumentsArrayQuery = "
                SELECT instr_name
                FROM instruments AS i 
              
                ORDER by i.instr_name ASC
                  ";

$resultInstrumentsArrayQuery = $conn->query($instrumentsArrayQuery);
if($debug) {
    $debug_string .= " 'instrumentsArrayQuery = ' . $instrumentsArrayQuery . '<br/><br/>'";
    if (!$resultInstrumentsArrayQuery) $debug_string.='("\n Error description instrumentsArrayQuery: " . mysqli_error($conn) . "\n<br/>")';
}/*end debug*/

failureToExecute ($resultInstrumentsArrayQuery, 'S513', 'Select ' );


if ($resultInstrumentsArrayQuery) {

    $instrumentsArrayNumberOfRows = $resultInstrumentsArrayQuery->num_rows;
    $instrumentsArray = "<script> let instruments=[";

    for ($j = 0 ; $j < $instrumentsArrayNumberOfRows ; ++$j)
    {
        $row = $resultInstrumentsArrayQuery->fetch_array(MYSQLI_NUM);

        /*  var_dump ($row);*/


        $instrumentsName = htmlspecialchars($row[0], ENT_QUOTES);

        $instrumentsArray .= "'$instrumentsName'" .", ";

    } /*for loop ending*/

} /*End if ($resultInstrumentsArrayQuery)*/

$instrumentsArray = rtrim($instrumentsArray,', ');
$instrumentsArray .="]</script>";

$debug_string .="$instrumentsArray";



/*retrieve  composer last name values from db and put into an array*/


    $composerArray = "";
    $composerArrayQuery = "
                SELECT distinct p.lastname, p.firstname
                FROM people AS p 
                JOIN C2R2P ON p.ID = C2R2P.people_ID
                JOIN roles AS r ON C2R2P.role_ID = r.ID AND r.role_name = 'Composer'
                ORDER by p.lastname ASC, p.firstname ASC;
                  ";

             $resultComposerArrayQuery = $conn->query($composerArrayQuery);
    if($debug) {
        $debug_string.=" 'composerArrayQuery = ' . $composerArrayQuery . '<br/><br/>'";
        if (!$resultComposerArrayQuery) $debug_string.="('\n Error description composerArrayQuery: ' . mysqli_error($conn) . '\n<br/>')";
    }/*end debug*/

failureToExecute ($resultComposerArrayQuery, 'S512', 'Select ' );


    if ($resultComposerArrayQuery) {

        $composerArrayNumberOfRows = $resultComposerArrayQuery->num_rows;
        $composerArray = "<script> let composers=[";

         for ($j = 0 ; $j < $composerArrayNumberOfRows ; ++$j)
            {
                $row = $resultComposerArrayQuery->fetch_array(MYSQLI_NUM);

                /*  var_dump ($row);*/


                $composerLastName = htmlspecialchars($row[0], ENT_QUOTES);

                $composerArray .= "'$composerLastName'" .", ";

            } /*for loop ending*/

    } /*End if ($resultComposerArrayQuery)*/

    $composerArray = rtrim($composerArray,', ');
    $composerArray .="]</script>";

$debug_string .="$composerArray";





/*retrieve arranger last name values from db and put into an array*/

$arrangersArray = "";
$arrangersArrayQuery = "
                SELECT distinct p.lastname, p.firstname
                FROM people AS p 
                JOIN C2R2P ON p.ID = C2R2P.people_ID
                JOIN roles AS r ON C2R2P.role_ID = r.ID AND r.role_name = 'Arranger'
                ORDER by p.lastname ASC, p.firstname ASC;
                  ";

$resultArrangersArrayQuery = $conn->query($arrangersArrayQuery);
if($debug) {
    $debug_string.=" 'arrangersArrayQuery = ' . $arrangersArrayQuery . '<br/><br/>'";
    if (!$resultArrangersArrayQuery) $debug_string.="('\n Error description arrangersArrayQuery: ' . mysqli_error($conn) . '\n<br/>')";
}/*end debug*/

failureToExecute ($resultArrangersArrayQuery, 'S511', 'Select ' );


if ($resultArrangersArrayQuery) {

    $arrangersArrayNumberOfRows = $resultArrangersArrayQuery->num_rows;
    $arrangersArray = "<script> let arrangers=[";

    for ($j = 0 ; $j < $arrangersArrayNumberOfRows ; ++$j)
    {
        $row = $resultArrangersArrayQuery->fetch_array(MYSQLI_NUM);

        /*  var_dump ($row);*/

        $arrangerLastName = htmlspecialchars($row[0], ENT_QUOTES);

        $arrangersArray .= "'$arrangerLastName'" .", ";

    } /*for loop ending*/

} /*End if ($resultArrangersArrayQuery)*/

$arrangersArray = rtrim($arrangersArray,', ');
$arrangersArray .="]</script>";

$debug_string .= "$arrangersArray";


/*retrieve  lyricist last name values from db and put into an array*/

$lyricistsArray = "";
$lyricistsArrayQuery = "
                SELECT distinct p.lastname, p.firstname
                FROM people AS p 
                JOIN C2R2P ON p.ID = C2R2P.people_ID
                JOIN roles AS r ON C2R2P.role_ID = r.ID AND r.role_name = 'Lyricist'
                ORDER by p.lastname ASC, p.firstname ASC;
                  ";

$resultLyricistsArrayQuery = $conn->query($lyricistsArrayQuery);
if($debug) {
    $debug_string.=" 'lyricistsArrayQuery = ' . $lyricistsArrayQuery . '<br/><br/>'";
    if (!$resultLyricistsArrayQuery) $debug_string.='("\n Error description lyricistsArrayQuery: " . mysqli_error($conn) . "\n<br/>")';
}/*end debug*/

failureToExecute ($resultLyricistsArrayQuery, 'S510', 'Select ' );


if ($resultLyricistsArrayQuery) {

    $lyricistsArrayNumberOfRows = $resultLyricistsArrayQuery->num_rows;
    $lyricistsArray = "<script> let lyricists=[";

    for ($j = 0 ; $j < $lyricistsArrayNumberOfRows ; ++$j)
    {
        $row = $resultLyricistsArrayQuery->fetch_array(MYSQLI_NUM);

        /*  var_dump ($row);*/


        $lyricistLastName = htmlspecialchars($row[0], ENT_QUOTES);

        $lyricistsArray .= "'$lyricistLastName'" .", ";

    } /*for loop ending*/

} /*End if ($resultLyricistsArrayQuery)*/

$lyricistsArray = rtrim($lyricistsArray,', ');
$lyricistsArray .="]</script>";

$debug_string .= "$lyricistsArray";




/*retrieve  composition name values from db and put into an array*/


$compositionsArray = "";
$compositionsArrayQuery = "
                SELECT c.comp_name
                FROM compositions AS c 
              
                ORDER by c.comp_name ASC
                  ";

$resultCompositionsArrayQuery = $conn->query($compositionsArrayQuery);
if($debug) {
    $debug_string.=" 'compositionsArrayQuery = ' . $compositionsArrayQuery . '<br/><br/>'";
    if (!$resultCompositionsArrayQuery) $debug_string.='("\n Error description compositionsArrayQuery: " . mysqli_error($conn) . "\n<br/>")';
}/*end debug*/

failureToExecute ($resultCompositionsArrayQuery, 'S509', 'Select ' );


if ($resultCompositionsArrayQuery) {

    $compositionsArrayNumberOfRows = $resultCompositionsArrayQuery->num_rows;
    $compositionsArray = "<script> let compositions=[";

    for ($j = 0 ; $j < $compositionsArrayNumberOfRows ; ++$j)
    {
        $row = $resultCompositionsArrayQuery->fetch_array(MYSQLI_NUM);

        /*  var_dump ($row);*/


        $compositionName = htmlspecialchars($row[0], ENT_QUOTES);

        $compositionsArray .= "'$compositionName'" .", ";

    } /*for loop ending*/

} /*End if ($resultCompositionsArrayQuery)*/

$compositionsArray = rtrim($compositionsArray,', ');
$compositionsArray .="]</script>";

$debug_string .= "$compositionsArray";
















/*save Request values to local 'submission' vars*/
if($submit == 'true') {


    if (isset($_REQUEST['compName'])) {
        $compName = $_REQUEST['compName'];
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






    /*add check box validations here*/
    /*if checkbox validation fails, set checkbox error message and validationFailed = true*/








    /*Validation successful!
    Here we do not need to wash variables here because they will not be used in a db query*/
    /*if all values validate successfully...)*/
    if (!$validationFailed) {



        /*run the search */


            $keySigsHeaderString = "";
            foreach ($keySigs AS $value) {
                $keySigsHeaderString .= '&keySigs[]=' . $value;

            }/*End foreach loop*/


            $genresHeaderString = "";
            foreach ($genres as $value) {
                $genresHeaderString .= '&genres[]=' . $value;
            }/*End foreach loop*/







            /*    echo $debug_string;
                  exit();*/


    /* $check =    'Location: displayAdvSearch.php?advSearch=true&$searchBoxGeneralCompTitle=' . $compName . '&keySigs[]=' . $keySigs . '&genres[]=' . $genres . '&searchBoxGeneralInst=' . $instruments . '&era=' . $era . '&voice=' . $voice . '&ensemble=' . $ensemble . '&genDiff=' . $genDiff . '&ASPDiff=' . $ASPDiff ;*/


            header('Location: displayAdvSearch.php?advSearch=true&searchBoxGeneralCompTitle=' . $searchBoxGeneralCompTitle . '&searchBoxGeneralInst=' . $searchBoxGeneralInst . '&searchBoxGeneralComposer=' . $searchBoxGeneralComposer . '&searchBoxGeneralArr=' . $searchBoxGeneralArr . '&searchBoxGeneralLyr=' . $searchBoxGeneralLyr . $keySigsHeaderString  . $genresHeaderString . '&era=' . $era . '&voice=' . $voice . '&ensemble=' . $ensemble . '&genDiff=' . $genDiff . '&ASPDiff=' . $ASPDiff );
            exit();

    } /*END if (!$validationFailed )*/

} /* end if submit =='true')*/


echo $debug_string;





/*Here we have arrived at the page for the first time NO pre-populated  form */






/*generate form to be used in every situation*/




?>


<div class="container-fluid bg-light pt-4 ">
    <h2 class="pb-4" >Advanced Search</h2>
    <h4 class="pb-4" >Add as many search criteria as you like</h4>
    <form class="pb-4" action='advancedSearch.php' method='post'>


        <div class="row">
            <div class="col-md-4">
                <div class="card  mb-3">
                    <div class="card-body bg-light">
                        <div class="form-group">


                            <h6>Will you be searching by a Composition Title?</h6>
                            <div class="form-check">
                                <label for="searchBoxGeneralCompTitle">Composition Name: <?php echo $compNameErr ?></label>
                                <input type="text" class="form-control" autocomplete="off"  id="searchBoxGeneralCompTitle" name="searchBoxGeneralCompTitle"  placeholder = "Please enter a title for the Composition" /><br/>
                                <ul id="cmpsnArray"></ul>
                            </div> <!-- end form-check -->


                        </div> <!-- end form-group -->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->




                <div class="card mb-3 ">
                    <div class="card-body bg-light">

                        <h6>Will you be searching for an Instrument?</h6>
                        <div class="form-check">
                            <label class="" for="searchBoxGeneralInst">Name of Instrument: </label>
                            <input class="form-control" autocomplete="off" type="text" id="searchBoxGeneralInst" name="searchBoxGeneralInst" placeholder="Please enter an Instrument name" /><br/>
                            <ul id="instArray"></ul>


                        </div> <!-- end form-check -->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->





                <div class="card mb-3">
                    <div class="card-body bg-light">

                        <h6>Will you be searching for a Composer?</h6>
                        <div class="form-check">
                            <label class="" for="searchBoxGeneralComposer">Last Name Only: </label>
                            <input class="form-control" autocomplete="off" type="text" id="searchBoxGeneralComposer" name="searchBoxGeneralComposer" placeholder="Please enter a Last Name for your composer" /><br/>
                            <ul id="compsrArray"></ul>


                        </div> <!-- end form-check -->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->




                <div class="card mb-3">
                    <div class="card-body bg-light">

                        <h6>Will you be searching for an Arranger?</h6>
                        <div class="form-check">

                            <label class="" for="searchBoxGeneralArr">Last Name Only: </label>
                            <input class="form-control" autocomplete="off" type="text" id="searchBoxGeneralArr" name="searchBoxGeneralArr" placeholder="Please enter a Last Name for your arranger" /><br/>
                            <ul id="arrArray"></ul>


                        </div> <!-- end form-check -->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->



                <div class="card mb-3">
                    <div class="card-body bg-light">

                        <h6>Will you be searching for a Lyricist?</h6>
                        <div class="form-check">

                            <label class="" for="searchBoxGeneralLyr">Last Name Only: </label>
                            <input class="form-control" autocomplete="off" type="text" id="searchBoxGeneralLyr" name="searchBoxGeneralLyr" placeholder="Please enter a Last Name for your lyricist" /><br/>
                            <ul id="lyrArray"></ul>


                        </div> <!-- end form-check -->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col -->

<!--For the remainder of these form areas, the values are changed to id, name so that we can use the name on the displayAdvSearch We will un pack it there.-->
            <!-- >keySigs checkboxes -->

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body bg-light">

                        <h6>Key Signature: choose as many as apply</h6>
                        <?php echo $keySigsErr ?>



                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chk2" name="keySigs[]" value="2-C Major" <?php if (in_array( "2-C Major", $keySigs)) {echo("checked");}?>>  C Major<br>
                            <label class="form-check-label sr-only" for="chk2"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"  id="chk3" name="keySigs[]" value="3-G Major" <?php if (in_array( "3-G Major", $keySigs)) {echo("checked");}?>>  G Major<br>
                            <label class="form-check-label sr-only" for="chk3"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input"  id="chk4" name="keySigs[]" value="4-D Major" <?php if (in_array( "4-D Major", $keySigs)) {echo("checked");}?>>  D Major<br>
                            <label class="form-check-label sr-only" for="chk4"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk5" name="keySigs[]" value="5-A Major" <?php if (in_array( "5-A Major", $keySigs)) {echo("checked");}?>>  A Major<br>
                            <label class="form-check-label sr-only" for="chk5"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk6" name="keySigs[]" value="6-E Major" <?php if (in_array( "6-E Major", $keySigs)) {echo("checked");}?>>  E Major<br>
                            <label class="form-check-label sr-only" for="chk6"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk7" name="keySigs[]" value="7-B Major" <?php if (in_array( "7-B Major", $keySigs)) {echo("checked");}?>>  B Major<br>
                            <label class="form-check-label sr-only" for="chk7"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk8" name="keySigs[]" value="8-Gb Major" <?php if (in_array( "8-Gb Major", $keySigs)) {echo("checked");}?>>  Gb Major<br>
                            <label class="form-check-label sr-only" for="chk8"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk9" name="keySigs[]" value="9-Db Major" <?php if (in_array( "9-Db Major", $keySigs)) {echo("checked");}?>>  Db Major<br>
                            <label class="form-check-label sr-only" for="chk9"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk10" name="keySigs[]" value="10-Ab Major" <?php if (in_array( "10-Ab Major", $keySigs)) {echo("checked");}?>>  Ab Major<br>
                            <label class="form-check-label sr-only" for="chk10"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk11" name="keySigs[]" value="11-Eb Major" <?php if (in_array( "11-EbMajor", $keySigs)) {echo("checked");}?>>  Eb Major<br>
                            <label class="form-check-label sr-only" for="chk11"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk12" name="keySigs[]" value="12- Bb Major" <?php if (in_array( "12-Bb Major", $keySigs)) {echo("checked");}?>>  Bb Major<br>
                            <label class="form-check-label sr-only" for="chk12"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk13" name="keySigs[]" value="13-F Major" <?php if (in_array( "13-F Major", $keySigs)) {echo("checked");}?>>  F Major<br>
                            <label class="form-check-label sr-only" for="chk13"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk14" name="keySigs[]" value="14-a minor" <?php if (in_array( "14-a minor", $keySigs)) {echo("checked");}?>>  a minor<br>
                            <label class="form-check-label sr-only" for="chk14"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk15" name="keySigs[]" value="15-e minor" <?php if (in_array( "15-e minor", $keySigs)) {echo("checked");}?>>  e minor<br>
                            <label class="form-check-label sr-only" for="chk15"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk16" name="keySigs[]" value="16-b minor" <?php if (in_array( "16-b minor", $keySigs)) {echo("checked");}?>>  b minor<br>
                            <label class="form-check-label sr-only" for="chk16"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk17" name="keySigs[]" value="17-f# minor" <?php if (in_array( "17-f# minor", $keySigs)) {echo("checked");}?>>  f# minor<br>
                            <label class="form-check-label sr-only" for="chk17"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk18" name="keySigs[]" value="18-c# minor" <?php if (in_array( "18-c# minor", $keySigs)) {echo("checked");}?>>  c# minor<br>
                            <label class="form-check-label sr-only" for="chk18"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk19" name="keySigs[]" value="19-g# minor" <?php if (in_array( "19-g# minor", $keySigs)) {echo("checked");}?>>  g# minor<br>
                            <label class="form-check-label sr-only" for="chk19"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk20" name="keySigs[]" value="20-eb minor" <?php if (in_array( "20-eb minor", $keySigs)) {echo("checked");}?>>  eb minor<br>
                            <label class="form-check-label sr-only" for="chk20"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk21" name="keySigs[]" value="21-bb minor" <?php if (in_array( "21-bb minor", $keySigs)) {echo("checked");}?>>  bb minor<br>
                            <label class="form-check-label sr-only" for="chk21"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk22" name="keySigs[]" value="22-f minor" <?php if (in_array( "22-f minor", $keySigs)) {echo("checked");}?>>  f minor<br>
                            <label class="form-check-label sr-only" for="chk22"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk23" name="keySigs[]" value="23-c minor" <?php if (in_array( "23-c minor", $keySigs)) {echo("checked");}?>>   c minor<br>
                            <label class="form-check-label sr-only" for="chk23"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox"  class="form-check-input"  id="chk24" name="keySigs[]" value="24-g minor" <?php if (in_array( "24-g minor", $keySigs)) {echo("checked");}?>>   g minor<br>
                            <label class="form-check-label sr-only" for="chk24"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check pb-4">
                            <input type="checkbox"  class="form-check-input"  id="chk25" name="keySigs[]" value="25-d minor" <?php if (in_array( "25-d minor", $keySigs)) {echo("checked");}?>>  d minor<br>
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
                            <input type="checkbox" class="form-check-input" id="chbx20" name="genres[]" value="20-Band" <?php if (in_array( "20-Band", $genres)) {echo("checked");}?>> Band<br>
                            <label class="form-check-label sr-only" for="chbx20"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check ">
                            <input type="checkbox" class="form-check-input" id="chbx35" name="genres[]" value="35-Barbershop (female)" <?php if (in_array( "35-Barbershop (female)", $genres)) {echo("checked");}?>> Barbershop (female)<br>
                            <label class="form-check-label sr-only" for="chbx35"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check ">
                            <input type="checkbox" class="form-check-input" id="chbx34" name="genres[]" value="34-Barbershop (male)" <?php if (in_array( "34-Barbershop (male)", $genres)) {echo("checked");}?>> Barbershop (male)<br>
                            <label class="form-check-label sr-only" for="chbx34"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check ">
                            <input type="checkbox" class="form-check-input" id="chbx36" name="genres[]" value="36-Barbershop (mixed)" <?php if (in_array( "36-Barbershop (mixed)", $genres)) {echo("checked");}?>> Barbershop (mixed)<br>
                            <label class="form-check-label sr-only" for="chbx36"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx29" name="genres[]" value="29-Birthday" <?php if (in_array( "29-Birthday", $genres)) {echo("checked");}?>> Birthday<br>
                            <label class="form-check-label sr-only" for="chbx29"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx5" name="genres[]" value="5-Blues" <?php if (in_array( "5-Blues", $genres)) {echo("checked");}?>> Blues<br>
                            <label class="form-check-label sr-only" for="chbx5"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check ">
                            <input type="checkbox" class="form-check-input" id="chbx13" name="genres[]" value="13-Broadway Tunes" <?php if (in_array( "13-Broadway Tunes", $genres)) {echo("checked");}?>> Broadway Tunes<br>
                            <label class="form-check-label sr-only" for="chbx13"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx3" name="genres[]" value="3-Christmas" <?php if (in_array( "3-Christmas", $genres)) {echo("checked");}?>> Christmas<br>
                            <label class="form-check-label sr-only" for="chbx3"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx12" name="genres[]" value="12-Classical" <?php if (in_array( "12-Classical", $genres)) {echo("checked");}?>> Classical<br>
                            <label class="form-check-label sr-only" for="chbx12"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx21" name="genres[]" value="21-Commercial (jingles, Movie & TV themes)" <?php if (in_array( "21-Commercial (jingles, Movie & TV themes)", $genres)) {echo("checked");}?>> Commercial (jingles, Movie & TV themes)<br>
                            <label class="form-check-label sr-only" for="chbx21"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx8" name="genres[]" value="8-Country" <?php if (in_array( "8-Country", $genres)) {echo("checked");}?>> Country<br>
                            <label class="form-check-label sr-only" for="chbx8"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx22" name="genres[]" value="22-Disney" <?php if (in_array( "22-Disney", $genres)) {echo("checked");}?>> Disney<br>
                            <label class="form-check-label sr-only" for="chbx22"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx28" name="genres[]" value="28-Easter" <?php if (in_array( "28-Easter", $genres)) {echo("checked");}?>> Easter<br>
                            <label class="form-check-label sr-only" for="chbx28"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx23" name="genres[]" value="23-Easy Listening" <?php if (in_array( "23-Easy Listening", $genres)) {echo("checked");}?>> Easy Listening<br>
                            <label class="form-check-label sr-only" for="chbx23"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx14" name="genres[]" value="14-Folk Music" <?php if (in_array( "14-Folk Music", $genres)) {echo("checked");}?>> Folk Music<br>
                            <label class="form-check-label sr-only" for="chbx14"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx17" name="genres[]" value="17-Gospel/Christian" <?php if (in_array( "17-Gospel/Christian", $genres)) {echo("checked");}?>> Gospel/Christian<br>
                            <label class="form-check-label sr-only" for="chbx17"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx4" name="genres[]" value="4-Halloween" <?php if (in_array( "4-Halloween", $genres)) {echo("checked");}?>> Halloween<br>
                            <label class="form-check-label sr-only" for="chbx4"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx16" name="genres[]" value="16-Instrumental" <?php if (in_array( "16-Instrumental", $genres)) {echo("checked");}?>> Instrumental<br>
                            <label class="form-check-label sr-only" for="chbx16"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx32" name="genres[]" value="32-Irish" <?php if (in_array( "32-Irish", $genres)) {echo("checked");}?>> Irish<br>
                            <label class="form-check-label sr-only" for="chbx32"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx2" name="genres[]" value="2-Jazz" <?php if (in_array( "2-Jazz", $genres)) {echo("checked");}?>> Jazz<br>
                            <label class="form-check-label sr-only" for="chbx2"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx24" name="genres[]" value="24-Latin" <?php if (in_array( "24-Latin", $genres)) {echo("checked");}?>> Latin<br>
                            <label class="form-check-label sr-only" for="chbx24"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx9" name="genres[]" value="9-Madrigal" <?php if (in_array( "9-Madrigal", $genres)) {echo("checked");}?>> Madrigal<br>
                            <label class="form-check-label sr-only" for="chbx9"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx11" name="genres[]" value="11-Method Book" <?php if (in_array( "11-Method Book", $genres)) {echo("checked");}?>> Method Book<br>
                            <label class="form-check-label sr-only" for="chbx11"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx25" name="genres[]" value="25-Opera" <?php if (in_array( "25-Opera", $genres)) {echo("checked");}?>> Opera<br>
                            <label class="form-check-label sr-only" for="chbx25"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx19" name="genres[]" value="19-Orchestra" <?php if (in_array( "19-Orchestra", $genres)) {echo("checked");}?>> Orchestra<br>
                            <label class="form-check-label sr-only" for="chbx19"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx30" name="genres[]" value="30-Patriotic" <?php if (in_array( "30-Patriotic", $genres)) {echo("checked");}?>> Patriotic<br>
                            <label class="form-check-label sr-only" for="chbx30"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx7" name="genres[]" value="7-Pop" <?php if (in_array( "7-Pop", $genres)) {echo("checked");}?>> Pop<br>
                            <label class="form-check-label sr-only" for="chbx7"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx15" name="genres[]" value="15-Popular Music" <?php if (in_array( "15-Popular Music", $genres)) {echo("checked");}?>> Popular Music<br>
                            <label class="form-check-label sr-only" for="chbx15"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx26" name="genres[]" value="26-R&B Soul" <?php if (in_array( "26-R&B Soul", $genres)) {echo("checked");}?>> R&B Soul<br>
                            <label class="form-check-label sr-only" for="chbx26"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx6" name="genres[]" value="6-Rag" <?php if (in_array( "6-Rag", $genres)) {echo("checked");}?>> Rag<br>
                            <label class="form-check-label sr-only" for="chbx6"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx27" name="genres[]" value="27-Rock" <?php if (in_array( "27-Rock", $genres)) {echo("checked");}?>> Rock<br>
                            <label class="form-check-label sr-only" for="chbx27"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx18" name="genres[]" value="18-Swing" <?php if (in_array( "18-Swing", $genres)) {echo("checked");}?>> Swing<br>
                            <label class="form-check-label sr-only" for="chbx18"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx10" name="genres[]" value="10-Technique" <?php if (in_array( "10-Technique", $genres)) {echo("checked");}?>> Technique<br>
                            <label class="form-check-label sr-only" for="chbx10"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="chbx31" name="genres[]" value="31-ThanksGiving" <?php if (in_array( "31-ThanksGiving", $genres)) {echo("checked");}?>> ThanksGiving<br>
                            <label class="form-check-label sr-only" for="chbx31"></label>
                        </div> <!-- end form-check -->

                        <div class="form-check pb-4">
                            <input type="checkbox" class="form-check-input" id="chbx33" name="genres[]" value="33-Other Alternative" <?php if (in_array( "33-Other Alternative", $genres)) {echo("checked");}?>> Other Alternative<br>
                            <label class="form-check-label sr-only" for="chbx33"></label>
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
                                <option value="7-none" <?php if ($era == "7-none") {echo("selected");} ?>> none</option>
                                <option value="1-Ancient pre 1600" <?php if ($era == "1-Ancient pre 1600") {echo("selected");} ?>> Ancient pre 1600</option>
                                <option value="2-Baroque 1600-1750" <?php if ($era == "2-Baroque 1600-1750") {echo("selected");} ?>> Baroque 1600-1750</option>
                                <option value="3-Classical 1750-1810" <?php if ($era == "3-Classical 1750-1810") {echo("selected");} ?>> Classical 1750-1810</option>
                                <option value="4-Romantic 1780-1910" <?php if ($era == "4-Romantic 1780-1910") {echo("selected");} ?>> Romantic 1780-1910</option>
                                <option value="5-Modern 1890-1930" <?php if ($era == "5-Modern 1890-1930") {echo("selected");} ?>> Modern 1890-1930</option>
                                <option value="6-Contemporary 1930-Present" <?php if ($era == "6-Contemporary 1930-Present") {echo("selected");} ?>> Contemporary 1930-Present</option>
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
                            <select  class="form-control" id="voice"  name="voice" >
                                <option value="12-none" <?php if ($voice == "12-none") {echo("selected");} ?>> none</option>
                                <option value="8-SATB" <?php if ($voice == "8-SATB") {echo("selected");} ?>> SATB</option>
                                <option value="7-SAB" <?php if ($voice == "7-SAB") {echo("selected");} ?>> SAB</option>
                                <option value="2-SSA" <?php if ($voice == "2-SSA") {echo("selected");} ?>> SSA</option>
                                <option value="1-SA" <?php if ($voice == "1-SA") {echo("selected");} ?>> SA</option>
                                <option value="3-SSAA" <?php if ($voice == "3-SSAA") {echo("selected");} ?>> SSAA</option>
                                <option value="4-ST" <?php if ($voice == "4-ST") {echo("selected");} ?>> ST</option>
                                <option value="5-TTBB" <?php if ($voice == "5-TTBB") {echo("selected");} ?>> TTBB</option>
                                <option value="6-SB" <?php if ($voice == "6-SB") {echo("selected");} ?>> SB</option>
                                <option value="9-TBB" <?php if ($voice == "9-TBB") {echo("selected");} ?>> TBB</option>
                             /*row 10 was a duplicate*/
                                <option value="11-TB" <?php if ($voice == "11-TB") {echo("selected");} ?>> TB</option>
                                <option value="13-S" <?php if ($voice == "13-S") {echo("selected");} ?>> S</option>
                                <option value="14-A" <?php if ($voice == "14-A") {echo("selected");} ?>> A</option>
                                <option value="15-T" <?php if ($voice == "15-T") {echo("selected");} ?>> T</option>
                                <option value="16-B" <?php if ($voice == "16-B") {echo("selected");} ?>> B</option>
                                <option value="17-SAA" <?php if ($voice == "17-SAA") {echo("selected");} ?>> SAA</option>
                                <option value="18-STB" <?php if ($voice == "18-STB") {echo("selected");} ?>> STB</option>
                                <option value="19-SAT" <?php if ($voice == "19-SAT") {echo("selected");} ?>> SAT</option>
                                <option value="20-SAB" <?php if ($voice == "20-SAB") {echo("selected");} ?>> SAB</option>
                                <option value="2-AT" <?php if ($voice == "21-AT") {echo("selected");} ?>> AT</option>
                                <option value="22-AB" <?php if ($voice == "22-AB") {echo("selected");} ?>> AB</option>
                                <option value="23-ATB" <?php if ($voice == "23-ATB") {echo("selected");} ?>> ATB</option>
                                <option value="24-TT" <?php if ($voice == "24-TT") {echo("selected");} ?>> TT</option>
                                <option value="25-TTBB" <?php if ($voice == "25-TTBB") {echo("selected");} ?>> TTBB</option>
                                <option value="26-BB" <?php if ($voice == "26-BB") {echo("selected");} ?>> BB</option>
                                <option value="27-TTB" <?php if ($voice == "27-TTB") {echo("selected");} ?>> TTB</option>
                                <option value="2-High Voice" <?php if ($voice == "28-High Voice") {echo("selected");} ?>> High Voice</option>
                                <option value="29-Medium Voice" <?php if ($voice == "29-Medium Voice") {echo("selected");} ?>> Medium Voice</option>
                                <option value="30-Low Voice" <?php if ($voice == "30-Low Voice") {echo("selected");} ?>> Low Voice</option>
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
                                <option value="18-none" <?php if ($ensemble == "18-none") {echo("selected");} ?>> none</option>
                                <option value="1-Solo a capella" <?php if ($ensemble == "1-Solo a capella") {echo("selected");} ?>> Solo a capella</option>
                                <option value="2-Duet a capella" <?php if ($ensemble == "2-Duet a capella") {echo("selected");} ?>> Duet a capella</option>
                                <option value="3-Trio a capella" <?php if ($ensemble == "3-Trio a capella") {echo("selected");} ?>> Trio a capella</option>
                                <option value="4-Quartet a capella" <?php if ($ensemble == "4-Quartet a capella") {echo("selected");} ?>> Quartet a capella</option>
                                <option value="5-Quintet a capella" <?php if ($ensemble == "5-Quintet a capella") {echo("selected");} ?>> Quintet a capella</option>
                                <option value="6-Ensemble" <?php if ($ensemble == "6-Ensemble") {echo("selected");} ?>> Ensemble</option>
                                <option value="7-Solo-Accompanied" <?php if ($ensemble == "7-Solo-Accompanied") {echo("selected");} ?>> Solo-Accompanied</option>
                                <option value="8-Duet-Accompanied" <?php if ($ensemble == "8-Duet-Accompanied") {echo("selected");} ?>> Duet-Accompanied</option>
                                <option value="9-Trio-Accompanied" <?php if ($ensemble == "9-Trio-Accompanied") {echo("selected");} ?>> Trio-Accompanied</option>
                                <option value="10-Quartet-Accompanied" <?php if ($ensemble == "10-Quartet-Accompanied") {echo("selected");} ?>> Quartet-Accompanied</option>
                                <option value="11-Quintet-Accompanied" <?php if ($ensemble == "11-Quintet-Accompanied") {echo("selected");} ?>> Quintet-Accompanied</option>
                                <option value="12-Ensemble-Accompanied" <?php if ($ensemble == "12-Ensemble-Accompanied") {echo("selected");} ?>> Ensemble-Accompanied</option>
                                <option value="13-Band" <?php if ($ensemble == "13-Band") {echo("selected");} ?>> Band</option>
                                <option value="14-Orchestra" <?php if ($ensemble == "14-Orchestra") {echo("selected");} ?>> Orchestra</option>
                                <option value="15-Choir" <?php if ($ensemble == "15-Choir") {echo("selected");} ?>> Choir</option>
                                <option value="16" <?php if ($ensemble == "16") {echo("selected");} ?>> AccompaniedChoir-</option>
                                <option value="17-Accompanied" <?php if ($ensemble == "17-Accompanied") {echo("selected");} ?>> other</option>
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
                                <option value="10-none" <?php if ($genDiff == "10-none") {echo("selected");} ?>> none</option>
                                <option value="1-Gen EE / ASP 1" <?php if ($genDiff == "1-Gen EE / ASP 1") {echo("selected");} ?>> Gen EE / ASP 1</option>
                                <option value="2-Gen E / ASP 2" <?php if ($genDiff == "2-Gen E / ASP 2") {echo("selected");} ?>> Gen E / ASP 2</option>
                                <option value="3-Gen LE / ASP 3" <?php if ($genDiff == "3-Gen LE / ASP 3") {echo("selected");} ?>> Gen LE / ASP 3</option>
                                <option value="4-Gen EI / ASP 4" <?php if ($genDiff == "4-Gen EI / ASP 4") {echo("selected");} ?>> Gen EI / ASP 4</option>
                                <option value="5-Gen I / ASP 5-6" <?php if ($genDiff == "5-Gen I / ASP 5-6") {echo("selected");} ?>> Gen I / ASP 5-6</option>
                                <option value="6-Gen LI / ASP 7" <?php if ($genDiff == "6-Gen LI / ASP 7") {echo("selected");} ?>> Gen LI / ASP 7</option>
                                <option value="7-Gen EA / ASP 8" <?php if ($genDiff == "7-Gen EA / ASP 8") {echo("selected");} ?>> Gen EA / ASP 8</option>
                                <option value="8-Gen A / ASP 9-19" <?php if ($genDiff == "-Gen A / ASP 9-19") {echo("selected");} ?>> Gen A / ASP 9-19</option>
                                <option value="9-Gen LA / ASP 11-12" <?php if ($genDiff == "9-Gen LA / ASP 11-12") {echo("selected");} ?>> Gen LA / ASP 11-12</option>
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
                                <option value="34-none" <?php if ($ASPDiff == "34-none") {echo("selected");} ?>> none</option>
                                <option value="11-ASP 1 / Gen EE" <?php if ($ASPDiff == "11-ASP 1 / Gen EE") {echo("selected");} ?>> ASP 1 / Gen EE</option>
                                <option value="12-ASP 1-2 / Gen EE-E" <?php if ($ASPDiff == "12-ASP 1-2 / Gen EE-E") {echo("selected");} ?>> ASP 1-2 / Gen EE-E</option>
                                <option value="13-ASP 2 / Gen E" <?php if ($ASPDiff == "13-ASP 2 / Gen E") {echo("selected");} ?>> ASP 2 / Gen E</option>
                                <option value="14-ASP 2-3 / Gen E-LE" <?php if ($ASPDiff == "14-ASP 2-3 / Gen E-LE") {echo("selected");} ?>> ASP 2-3 / Gen E-LE </option>
                                <option value="15-ASP 3 / Gen LE" <?php if ($ASPDiff == "15-ASP 3 / Gen LE") {echo("selected");} ?>> ASP 3 / Gen LE</option>
                                <option value="16-ASP 3-4 / Gen LE-EI" <?php if ($ASPDiff == "16-ASP 3-4 / Gen LE-EI") {echo("selected");} ?>> ASP 3-4 / Gen LE-EI</option>
                                <option value="17-ASP 4 / Gen EI" <?php if ($ASPDiff == "17-ASP 4 / Gen EI") {echo("selected");} ?>> ASP 4 / Gen EI</option>
                                <option value="18-ASP 4-5 / Gen EI-I" <?php if ($ASPDiff == "18-ASP 4-5 / Gen EI-I") {echo("selected");} ?>> ASP 4-5 / Gen EI-I</option>
                                <option value="19-ASP 5 / Gen I" <?php if ($ASPDiff == "19-ASP 5 / Gen I") {echo("selected");} ?>> ASP 5 / Gen I</option>
                                <option value="20-ASP 5-6 / Gen I" <?php if ($ASPDiff == "20-ASP 5-6 / Gen I") {echo("selected");} ?>> ASP 5-6 / Gen I</option>
                                <option value="21-ASP 6 / Gen I" <?php if ($ASPDiff == "21-ASP 6 / Gen I") {echo("selected");} ?>> ASP 6 / Gen I</option>
                                <option value="22-ASP 6-7 / Gen I-LI" <?php if ($ASPDiff == "22-ASP 6-7 / Gen I-LI") {echo("selected");} ?>> ASP 6-7 / Gen I-LI</option>
                                <option value="23-ASP 7 / Gen LI" <?php if ($ASPDiff == "23-ASP 7 / Gen LI") {echo("selected");} ?>> ASP 7 / Gen LI</option>
                                <option value="24-ASP 7-8 / Gen LI-EA" <?php if ($ASPDiff == "24-ASP 7-8 / Gen LI-EA") {echo("selected");} ?>> ASP 7-8 / Gen LI-EA</option>
                                <option value="25-ASP 8 / Gen EA" <?php if ($ASPDiff == "25-ASP 8 / Gen EA") {echo("selected");} ?>> ASP 8 / Gen EA</option>
                                <option value="26-ASP 8-9 / Gen EA-A" <?php if ($ASPDiff == "26-ASP 8-9 / Gen EA-A") {echo("selected");} ?>> ASP 8-9 / Gen EA-A</option>
                                <option value="2-ASP 9 / Gen A7" <?php if ($ASPDiff == "27-ASP 9 / Gen A") {echo("selected");} ?>> ASP 9 / Gen A</option>
                                <option value="28-ASP 9-10 / Gen A" <?php if ($ASPDiff == "28-ASP 9-10 / Gen A") {echo("selected");} ?>> ASP 9-10 / Gen A</option>
                                <option value="29-ASP 10 / Gen A" <?php if ($ASPDiff == "29-ASP 10 / Gen A") {echo("selected");} ?>> ASP 10 / Gen A</option>
                                <option value="30-ASP 10-11 / Gen A-LA" <?php if ($ASPDiff == "30-ASP 10-11 / Gen A-LA") {echo("selected");} ?>> ASP 10-11 / Gen A-LA</option>
                                <option value="31-ASP 11 / Gen LA" <?php if ($ASPDiff == "31-ASP 11 / Gen LA") {echo("selected");} ?>> ASP 11 / Gen LA</option>
                                <option value="32-ASP 11-12 / Gen LA" <?php if ($ASPDiff == "32-ASP 11-12 / Gen LA") {echo("selected");} ?>> ASP 11-12 / Gen LA</option>
                                <option value="33-ASP 12 / Gen LA" <?php if ($ASPDiff == "33-ASP 12 / Gen LA") {echo("selected");} ?>> ASP 12 / Gen LA</option>
                            </select>


                        </div> <!-- end form-group -->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div> <!--end row-->






        <input class="btn btn-secondary" type="submit" value="Submit & Continue"/>

        <input type="hidden" name="instType" value="$searchBoxGeneralInst"/>
        <input type="hidden" name="submit" value="true"/>
        <?php echo $sendAdvSearch; ?>




    </form>  <!--end form-->
</div>  <!--end container-->




<?php







echo <<<_END

<div class="container-fluid bg-light">
  <div class="row">
    <div class="col-md-6">
<form class="form-group  pt-3 pb-3" action='introPage.php' method='post'>
         <input class="btn btn-secondary" type='submit' value='Back to Site Options'/>
      </form>
 </div> <!-- end col -->
  </div> <!-- end row -->
</div> <!-- end container -->

_END;

  include 'footer.php';

  include 'endingBoilerplate.php';



echo <<<_END
<script>
listener('searchBoxGeneralCompTitle', compositions,  'cmpsnArray');
</script>

<script>
listener('searchBoxGeneralInst', instruments,  'instArray');
</script>

<script>
listener('searchBoxGeneralComposer', composers,  'compsrArray');
</script>

<script>
listener('searchBoxGeneralArr', arrangers,  'arrArray');
</script>

<script>
listener('searchBoxGeneralLyr', lyricists,  'lyrArray');
</script>

_END;

 ?>
