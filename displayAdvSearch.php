<?php

include 'boilerplate.php';

if ($debug) {
    echo <<<_END

  <p>displayAdvSearch.php-57</p>

_END;

}/*end debug*/


include 'beginningNav.php';

/*Initialize variables coming from other pages*/
/*from advancedSearch.php*/
$advSearch = "";
$searchBoxGeneralCompTitle = "";
$searchBoxGeneralInst = "";
$searchBoxGeneralComposer = "";
$searchBoxGeneralArr = "";
$searchBoxGeneralLyr = "";
$keySigs = array();
$genres = array();
$era = "";
$voice = "";
$ensemble = "";
$genDiff = "";
$ASPDiff = "";
$instType = "";


/*create Local Variables for the REQUEST values*/

if (isset($_REQUEST['advSearch'])) {
    $advSearch = $_REQUEST['advSearch'];
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

if (isset($_REQUEST['instType'])) {
    $instType = $_REQUEST['instType'];
}

if (isset($_REQUEST['keySigs'])) {
    $keySigs = $_REQUEST['keySigs'];
}

if (isset($_REQUEST['genres'])) {
    $genres = $_REQUEST['genres'];
}

if (isset($_REQUEST['era']) && $_REQUEST['era'] !== '7-none') {
    $era = $_REQUEST['era'];
}

if (isset($_REQUEST['instruments'])) {
    $instruments = $_REQUEST['instruments'];
}

if (isset($_REQUEST['voice']) && $_REQUEST['voice'] !== '12-none') {
    $voice = $_REQUEST['voice'];
}

if (isset($_REQUEST['ensemble']) && $_REQUEST['ensemble'] !== '18-none') {
    $ensemble = $_REQUEST['ensemble'];
}

if (isset($_REQUEST['genDiff']) && $_REQUEST['genDiff'] !== '10-none') {
    $genDiff = $_REQUEST['genDiff'];
}

if (isset($_REQUEST['ASPDiff']) && $_REQUEST['ASPDiff'] !== '34-none') {
    $ASPDiff = $_REQUEST['ASPDiff'];
}




/*functions to unpack the id/name variables*/

function getIdFromString($mystring)  {
    return substr($mystring, 0, strpos($mystring, "-"));
}


function getNameFromString($mystring){
    return substr($mystring, strpos($mystring, '-')+1);
}






/*run the search */
if($advSearch == 'true') {

    $keySigsString = "";
    foreach ($keySigs AS $value) {
        $keySigIdsString .= getIdFromString($value) . ', ';
        $keySigNamesString .= getNameFromString($value) . ', ';
    }/*End foreach loop*/
    $keySigIdsString = rtrim($keySigIdsString, ', ');
    $keySigNamesString = rtrim($keySigNamesString, ', ');

    $genresString = "";
    foreach ($genres as $genre) {
        $genreIdsString .= getIdFromString($genre) . ', ';
        $genreNamesString .= getNameFromString($genre) . ', ';
    }/*End foreach loop*/
    $genreIdsString = rtrim($genreIdsString, ', ');
    $genreNamesString = rtrim($genreNamesString, ', ');





/*here we wash the values that will be used in the db*/

    $washPostVar = cleanup_post($searchBoxGeneralCompTitle);
    $searchBoxGeneralCompTitleAltered = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($searchBoxGeneralInst);
    $searchBoxGeneralInstAltered = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($searchBoxGeneralComposer);
    $searchBoxGeneralComposerAltered = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($searchBoxGeneralArr);
    $searchBoxGeneralArrAltered = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($searchBoxGeneralLyr);
    $searchBoxGeneralLyrAltered = strip_before_insert($conn, $washPostVar);


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

    $washPostVar = cleanup_post($era);
    $eraAltered = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($voice);
    $voiceAltered = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($ensemble);
    $ensembleAltered = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($genDiff);
    $genDiffAltered = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($ASPDiff);
    $ASPDiffAltered = strip_before_insert($conn, $washPostVar);















    $searchString = "";


    $advIDSearchQuery = "
    SELECT distinct c.ID, c.comp_name
FROM compositions AS c
LEFT JOIN C2I ON c.ID = C2I.composition_ID
LEFT JOIN instruments as i ON C2I.instrument_ID = i.ID
LEFT JOIN C2R2P AS C2R2Pcomp ON c.ID = C2R2Pcomp.composition_ID
LEFT JOIN people AS pComp ON C2R2Pcomp.people_ID = pComp.ID
LEFT JOIN C2R2P AS C2R2Parr ON c.ID = C2R2Parr.composition_ID
LEFT JOIN people AS pArr ON C2R2Parr.people_ID = pArr.ID
LEFT JOIN C2R2P AS C2R2Plyr ON c.ID = C2R2Plyr.composition_ID
LEFT JOIN people AS pLyr ON C2R2Plyr.people_ID = pLyr.ID
LEFT JOIN C2K ON c.ID = C2K.composition_ID 
LEFT JOIN C2G ON c.ID = C2G.composition_ID
LEFT JOIN C2D AS C2D_A ON c.ID = C2D_A.composition_ID 
LEFT JOIN difficulties AS d_A ON C2D_A.difficulty_ID = d_A.ID
LEFT JOIN C2D AS C2D_G ON c.ID = C2D_G.composition_ID 
LEFT JOIN difficulties AS d_G ON C2D_G.difficulty_ID = d_G.ID

WHERE 1=1";


    if (strlen($searchBoxGeneralCompTitleAltered) > 0) {
        $advIDSearchQuery .= " AND c.comp_name ='" . $searchBoxGeneralCompTitleAltered . "'";
        $searchString .= "Composition Title: " . $searchBoxGeneralCompTitleAltered .  "<br>";
    }

    if (strlen($searchBoxGeneralInstAltered) > 0) {
        $advIDSearchQuery .= " AND i.instr_name ='" . $searchBoxGeneralInstAltered . "'";
        $searchString .= "Instrument: " . $searchBoxGeneralInstAltered .  "<br>";
    }
    if (strlen($searchBoxGeneralComposerAltered) > 0) {
        $advIDSearchQuery .= " AND C2R2Pcomp.role_ID =1 AND pComp.lastname ='" . $searchBoxGeneralComposerAltered . "'";
        $searchString .= "Composer: " . $searchBoxGeneralComposerAltered .  "<br>";

    }
    if (strlen($searchBoxGeneralArrAltered) > 0) {
        $advIDSearchQuery .= " AND C2R2Parr.role_ID = 2 AND pArr.lastname ='" . $searchBoxGeneralArrAltered . "'";
        $searchString .= "Arranger: " . $searchBoxGeneralArrAltered .  "<br>";
    }
    if (strlen($searchBoxGeneralLyrAltered) > 0) {
        $advIDSearchQuery .= " AND C2R2Plyr.role_ID = 3 AND pLyr.lastname ='" . $searchBoxGeneralLyrAltered . "'";
        $searchString .= "Lyricist: " . $searchBoxGeneralLyrAltered .  "<br>";
    }
    if (count($keySigs) > 0) {
        $advIDSearchQuery .= " AND C2K.keysig_ID IN (" . $keySigIdsString . " ) ";
        $searchString .= "Key Signature(s): " . $keySigNamesString .  "<br>";
    }
    if (count($genres) > 0) {
        $advIDSearchQuery .= " AND C2G.genre_ID IN (" . $genreIdsString . " ) ";
        $searchString .= "Genre(s): " . $genreNamesString .  "<br>";
    }
    if (strlen($eraAltered) > 0) {
        $advIDSearchQuery .= " AND c.era_ID = " . getIdFromString($eraAltered) . " ";
        $searchString .= "Era: " . getNameFromString($eraAltered) .  "<br>";

    }
    if (strlen($voiceAltered) > 0) {
        $advIDSearchQuery .= " AND c.voice_ID = " . getIdFromString($voiceAltered) . " ";
        $searchString .= "Voicing: " . getNameFromString($voiceAltered) .  "<br>";
    }
    if (strlen($ensembleAltered) > 0) {
        $advIDSearchQuery .= " AND c.ensemble_ID = " . getIdFromString($ensembleAltered) . " ";
        $searchString .= "Ensemble: " . getNameFromString($ensembleAltered) .  "<br>";
    }

    if (strlen($ASPDiffAltered) > 0) {
        $advIDSearchQuery .= " AND d_A.ID =" . getIdFromString($ASPDiffAltered) . " ";
        $searchString .= "ASP Difficulty Level: " . getNameFromString($ASPDiffAltered) .  "<br>";
    }
    if (strlen($genDiffAltered) > 0) {
        $advIDSearchQuery .= " AND d_G.ID =" . getIdFromString($genDiffAltered) . " ";
        $searchString .= "General Difficulty Level: " . getNameFromString($genDiffAltered) .  "<br>";
    }


    $advIDSearchQuery .= "ORDER BY c.comp_name";


    $advIDSearchQueryResult = $conn->query($advIDSearchQuery);

    if ($debug) {
        echo 'advIDSearchQuery =' . $advIDSearchQuery . '</br>';
    }

    if (!$advIDSearchQueryResult) echo("\n Error description query advIDSearchQuery: " . mysqli_error($conn) . "\n<br/>");
    if ($advIDSearchQueryResult) {
        $numberOfAdvSearchIDQueryRows = $advIDSearchQueryResult->num_rows;
        $compositionIDFound = ($numberOfAdvSearchIDQueryRows > 0);
        $compositionIDNotFound = ($numberOfAdvSearchIDQueryRows === 0);




        if ($compositionIDNotFound) {
            $notFound = 'disabled';

            echo <<<_END
            <div class="container-fluid bg-secondary text-light pb-3 ">
            <h3 class="display-4 pt-4 pb-4"> No Results for your Search</h3>
            <h5> You searched for: </h5>
                 $searchString
            </div> <!-- end container -->

_END;

        }/*if($compositionIDNotFound)*/

        if ($compositionIDFound) {
            echo <<<_END
                
                <div class="container-fluid bg-light pt-4 pb-5 ">
                    <div class="row justify-content-center">
                        <div class="col-md-10  pb-4">
                            <div class="card  mt-4 mb-3 ">
                                <div class="card-body bg-light  ">
                                  
                                    <h3 class="display-4 pt-4 pb-4 text-center"> Your Search Results </h3>
                                    <h5> You searched for: </h5>
                                    $searchString
                                  <form  class="pt-4 pb-4 text-center" action="" method = "" >
                                   
                                   <!-- <input type="radio" id="groupByBook" name="groupBy" checked = "checked" value="book">
                                    <label for="groupByBook" style="display:inline;">Group by Book</label>&nbsp;&nbsp;&nbsp;&nbsp; 
                                    <input type="radio" id="groupByComposition" name="groupBy" value="composition" style="display:inline;">
                                    <label for="groupByComposition">Group by Composition</label><br>
                                    </form><br><br>-->

_END;





            /*loop for Composition ID*/
            for ($j = 0; $j < $numberOfAdvSearchIDQueryRows; ++$j) {
                $row = $advIDSearchQueryResult->fetch_array(MYSQLI_NUM);

                $compositionID = htmlspecialchars($row[0]);


                $advSearchCompositionNameQuery = "
                SELECT  c.comp_name, b.ID, b.title
                FROM compositions AS c 
                JOIN books AS b ON c.book_ID = b.ID
                
                WHERE c.ID = '$compositionID';
                
                
                ";

                $advSearchCompositionNameQueryResult = $conn->query($advSearchCompositionNameQuery);

                if ($debug) {
                    echo 'advSearchComposerNameQuery =' . $advSearchCompositionNameQuery . '</br>';
                    if (!$advSearchCompositionNameQueryResult) echo("\n Error description query $advSearchCompositionNameQuery: " . mysqli_error($conn) . "\n<br/>");
                }

                if ($advSearchCompositionNameQueryResult) {
                    $numberOfAdvSearchCompositionNameQueryRows = $advSearchCompositionNameQueryResult->num_rows;
                    $compositionNameFound = ($advSearchCompositionNameQueryResult > 0);
                    $compositionNameNotFound = ($numberOfAdvSearchCompositionNameQueryRows === 0);


                    for ($i = 0; $i < $numberOfAdvSearchCompositionNameQueryRows; ++$i) {
                        $row = $advSearchCompositionNameQueryResult->fetch_array(MYSQLI_NUM);

                        $compositionName = htmlspecialchars($row[0]);
                        $bookID = htmlspecialchars($row[1]);
                        $bookTitle = htmlspecialchars($row[2]);

                    } /*end for loop*/

                }/* end if ($advSearchCompositionNameQueryResult)*/

                        $advSearchComposerQuery = "
                       SELECT p.firstname, p.lastname, p.ID
                        FROM compositions AS c
                        JOiN C2R2P ON c.ID = C2R2P.composition_ID
                        JOIN people AS p ON C2R2P.people_ID = p.ID AND C2R2P.role_ID=1
                        
                        Where c.ID = '$compositionID';
                        
                        
                        ";

                        $advSearchComposerQueryResult = $conn->query($advSearchComposerQuery);

                        if ($debug) {
                            echo 'advSearchComposerQuery =' . $advSearchComposerQuery . '</br>';
                            if (!$advSearchComposerQueryResult) echo("\n Error description query advSearchComposerQuery: " . mysqli_error($conn) . "\n<br/>");
                        }

                        if ($advSearchComposerQueryResult) {
                            $numberOfAdvSearchComposerQueryRows = $advSearchComposerQueryResult->num_rows;
                            $advancedComposerSearchFound = ($numberOfAdvSearchComposerQueryRows > 0);
                            $advancedComposerSearchNotFound = ($numberOfAdvSearchComposerQueryRows === 0);

                            $composerString = "";

                            for ($i = 0; $i < $numberOfAdvSearchComposerQueryRows; ++$i) {
                                $row = $advSearchComposerQueryResult->fetch_array(MYSQLI_NUM);


                                $composerFirstName = htmlspecialchars($row[0]);
                                $composerLastName = htmlspecialchars($row[1]);
                                $composerID = htmlspecialchars($row[2]);

                                $composerString .= $composerFirstName .  " " . $composerLastName . "</br> ";

                            } /*for loop ending*/
                        } /*END if ($advSearchComposerQueryResult)*/

                    $displayComposerString = substr($composerString, 0, strrpos($composerString, "</br> " ));









                                echo <<<_END
                                                   
                
                                            <div class="row ">
                                            <div class="col-md-2  ">
                                            </div>
                                            <div class="col-md-3  ">
                                                        <a href="displayComposition.php?compositionID=${compositionID}&instType=${instType}&bookID=${bookID}&advSearch=true">$compositionName</a>
                                                 </div>
                                                <div class="col-md-3  "> 
                                                       <h6 >composed by </h6> 
                                                </div>
                                                
                                                <div class="col-md-4  "> 
                                                          <a href="displayComposer.php?compositionID=${compositionID}&instType=${instType}&bookID=${bookID}&composerID=${composerID}&advSearch=true">$displayComposerString</a>
                                                 </div>
                                            </div> <!--end row-->
                                                   
                                           
                                                  
                            
_END;





            }/*End CompositionID for Loop*/
            echo <<<_END
                
                                        </div> <!-- END card body-->
                                    </div> <!-- END card-->
                                </div> <!-- END col-->
                            </div> <!-- END row-->
                        </div> <!-- END container-->
       
            
                
                    

_END;
            if ($compositionIDNotFound) {
                $notFound = 'disabled';

                echo <<<_END
                        <div class="container-fluid bg-secondary text-light pb-3">
                        <h3 class="display-4 pt-4 pb-4"> No Results for your Search</h3>
                        <h5> You searched for: </h5>
                         $searchString
                        </div>
_END;

            }/*End if($advancedSearchNotFound)*/


        }/*ENd if($compositionIDFound)*/

    } /*End if ($advIDSearchQueryResult)*/

}/*End if advancedSearch is true*/

echo <<<_END

            <div class="container-fluid bg-secondary text-light pt-4 pb-4 ">
            
               <br><form action="introPage.php" method='post'>
                    <input class="btn btn-light" type='submit' value='Back to Site Options'/>
                </form> <!-- end form --><br>
                
               <br><form action="Print Search Results.php" method='post'>
                    <input class="btn btn-light" type='submit' $notFound value='Print Search Results'/>     
                </form> <!-- end form --><br>
        
                <form action="advancedSearch.php" method='post'>
                  <input class="btn btn-light" type='submit' value='Try Another Advanced Search'/>
                  <input type='hidden' name='advSearch' value= 'true' />
                </form> <!-- end form -->
            </div> <!-- end container -->
 

_END;


include 'footer.html';
include 'endingBoilerplate.php';






