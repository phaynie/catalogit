





/***********/


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


if (isset($_REQUEST['keySigs'])) {
    $keySigs = $_REQUEST['keySigs'];
}

if (isset($_REQUEST['genres'])) {
    $genres = $_REQUEST['genres'];
}

if (isset($_REQUEST['era']) && $_REQUEST['era'] !== '7') {
    $era = $_REQUEST['era'];
}

if (isset($_REQUEST['instruments'])) {
    $instruments = $_REQUEST['instruments'];
}

if (isset($_REQUEST['voice']) && $_REQUEST['voice'] !== '12') {
    $voice = $_REQUEST['voice'];
}

if (isset($_REQUEST['ensemble']) && $_REQUEST['ensemble'] !== '18') {
    $ensemble = $_REQUEST['ensemble'];
}

if (isset($_REQUEST['genDiff']) && $_REQUEST['genDiff'] !== '10') {
    $genDiff = $_REQUEST['genDiff'];
}

if (isset($_REQUEST['ASPDiff']) && $_REQUEST['ASPDiff'] !== '34') {
    $ASPDiff = $_REQUEST['ASPDiff'];
}


/*run the search */
if ($advSearch == 'true') {

    $keySigsString = "";
    foreach ($keySigs AS $value) {
        $keySigsString .= $value . ', ';
    }/*End foreach loop*/
    $keySigsString = rtrim($keySigsString, ', ');

    $genresString = "";
    foreach ($genres as $genre) {
        $genresString .= $genre . ', ';
    }/*End foreach loop*/
    $genresString = rtrim($genresString, ', ');


    $advIDSearchQuery = "
    SELECT distinct c.ID
FROM compositions AS c
LEFT JOIN C2I ON c.ID = C2I.composition_ID
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


    if (strlen($searchBoxGeneralCompTitle) > 0) {
        $advIDSearchQuery .= " AND c.comp_name ='" . $searchBoxGeneralCompTitle . "'";
    }

    if (strlen($searchBoxGeneralInst) > 0) {
        $advIDSearchQuery .= " AND C2I.instrument_ID ='" . $searchBoxGeneralInst . "'";
    }
    if (strlen($searchBoxGeneralComposer) > 0) {
        $advIDSearchQuery .= " AND C2R2Pcomp.role_ID =1 AND pComp.lastname ='" . $searchBoxGeneralComposer . "'";
    }
    if (strlen($searchBoxGeneralArr) > 0) {
        $advIDSearchQuery .= " AND C2R2Parr.role_ID = 2 AND pArr.lastname ='" . $searchBoxGeneralArr . "'";
    }
    if (strlen($searchBoxGeneralLyr) > 0) {
        $advIDSearchQuery .= " AND C2R2Plyr.role_ID = 3 AND pLyr.lastname ='" . $searchBoxGeneralLyr . "'";
    }
    if (count($keySigs) > 0) {
        $advIDSearchQuery .= " AND C2K.keysig_ID IN (" . $keySigsString . " )";
    }
    if (count($genres) > 0) {
        $advIDSearchQuery .= " AND C2G.genre_ID IN (" . $genresString . " ) ";
    }
    if (strlen($era) > 0) {
        $advIDSearchQuery .= " AND c.era_ID = " . $era . "";
    }
    if (strlen($voice) > 0) {
        $advIDSearchQuery .= " AND c.voice_ID = " . $voice . "";
    }
    if (strlen($ensemble) > 0) {
        $advIDSearchQuery .= " AND c.ensemble_ID = " . $ensemble . "";
    }


    if (strlen($ASPDiff) > 0) {
        $advIDSearchQuery .= " AND d_A.ID =" . $ASPDiff . "";
    }
    if (strlen($genDiff) > 0) {
        $advIDSearchQuery .= " AND d_G.ID =" . $genDiff . "";
    }


    $advIDSearchQueryResult = $conn->query($advIDSearchQuery);

    if ($debug) {
        echo 'advIDSearchQuery =' . $advIDSearchQuery . '</br>';
    }

    if (!$advIDSearchQueryResult) echo("\n Error description query advIDSearchQuery: " . mysqli_error($conn) . "\n<br/>");
    if ($advIDSearchQueryResult) {

        $numberOfAdvSearchIDQueryRows = $advIDSearchQueryResult->num_rows;
        $compositionIDList = "";
        for ($j = 0; $j < $numberOfAdvSearchIDQueryRows; ++$j) {
            $row = $advIDSearchQueryResult->fetch_array(MYSQLI_NUM);

            $compositionID = ($row[0]);

            $compositionIDFound = ($numberOfAdvSearchIDQueryRows > 0);
            $compositionIDNotFound = ($numberOfAdvSearchIDQueryRows === 0);

            if ($compositionIDNotFound) {
                $notFound = 'disabled';

                echo <<<_END
            <div class="container-fluid bg-secondary text-light pb-3">
            <h3 class="display-4 pt-4 pb-4"> No Results for your Search</h3>
            </div>

_END;

            }/*if($compositionIDNotFound)*/


            if ($compositionIDFound) {


                echo "compositionIDList = $compositionIDList ";
                $advSearchDisplayQuery = "
            SELECT  c.comp_name, p.firstname, p.lastname, b.title, b.ID
            FROM compositions AS c
            JOIN C2R2P ON c.ID = C2R2P.composition_ID
            JOIN people AS p ON C2R2P.people_ID = p.ID
            JOIN roles AS r ON  r.ID = C2R2P.role_ID AND r.role_name = 'Composer'
            JOIN books AS b ON c.book_ID = b.ID


            WHERE c.ID = $compositionID;


            ";

                $advSearchDisplayQueryResult = $conn->query($advSearchDisplayQuery);

                if ($debug) {
                    echo 'advSearchDisplayQuery =' . $advSearchDisplayQuery . '</br>';
                }

                if (!$advSearchDisplayQueryResult) echo("\n Error description query advSearchDisplayQuery: " . mysqli_error($conn) . "\n<br/>");
                if ($advSearchDisplayQueryResult) {
                    $numberOfAdvSearchDisplayQueryRows = $advSearchDisplayQueryResult->num_rows;
                    $advancedSearchFound = ($numberOfAdvSearchDisplayQueryRows > 0);
                    $advancedSearchNotFound = ($numberOfAdvSearchDisplayQueryRows === 0);

                    if ($advancedSearchNotFound) {
                        $notFound = 'disabled';

                        echo <<<_END
            <div class="container-fluid bg-secondary text-light pb-3">
            <h3 class="display-4 pt-4 pb-4"> No Results for your Search</h3>
            </div>
_END;

                    }/*End if($advancedSearchNotFound)*/

                    if ($compositionIDFound && $advancedSearchFound) {
                        /*display Search results*/

                        echo <<<_END

                <div class="container-fluid bg-light pt-4 pb-5 ">
                    <div class="row justify-content-center">
                        <div class="col-md-6  pb-4">
                            <div class="card  mt-4 mb-3 ">
                                <div class="card-body bg-light ">
                                    <h3 class="display-4"> Your Search Results </h3>

                                    <input type="radio" id="groupByBook" name="groupBy" checked = "checked" value="">
                                    <label for="groupByBook" style="display:inline;">Group by Book</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="groupByComposition" name="groupBy" value="" style="display:inline;">
                                    <label for="groupByComposition">Group by Composition</label><br>


_END;

                        for ($j = 0; $j < $numberOfAdvSearchDisplayQueryRows; ++$j) {
                            $row = $advSearchDisplayQueryResult->fetch_array(MYSQLI_NUM);

                            $compositionName = ($row[0]);
                            $composerFirstName = ($row[1]);
                            $composerLastName = ($row[2]);
                            $bookTitle = ($row[3]);
                            $bookID = ($row[4]);


                            echo <<<_END
                                                    <form action='displayComposition.php' method='post' style="display:inline;" >

                                                            <input class="btn  btn-link" type="submit" value="$compositionName  "  />
                                                            <input type="hidden" name="compositionID" value= "$compositionID" />
                                                            <input type="hidden" name="bookID" value= "$bookID" />
                                                            <input type="hidden" name="compName" value= "$compositionName" />
                                                            <input type="hidden" name="compLastName" value= "$composerLastName" />
                                                            <input type="hidden" name="compFirstName" value= "$composerFirstName" />


                                                    </form> <!-- form -->
                                                       <h6 style="display:inline;" >&nbsp;&nbsp;&nbsp;composed by </h6> &nbsp;&nbsp;&nbsp;
                                                     <form action='displayComposer.php' method='post' style="display:inline;">
                                                            <input class="btn  btn-link" type="submit" value="  $composerFirstName $composerLastName "  />
                                                            <input type="hidden" name="compositionID" value= "$compositionID" />
                                                            <input type="hidden" name="bookID" value= "$bookID" />
                                                            <input type="hidden" name="compName" value= "$compositionName" />
                                                            <input type="hidden" name="compLastName" value= "$composerLastName" />
                                                            <input type="hidden" name="compFirstName" value= "$composerFirstName" />

                                                    </form><br><br> <!-- form -->

_END;

                        } /*End forloop */

                        echo <<<_END

                                        </div> <!-- END card body-->
                                    </div> <!-- END card-->
                                </div> <!-- END col-->
                            </div> <!-- END row-->
                        </div> <!-- END container-->



<h6 style="display:inline;" >&nbsp;&nbsp;&nbsp;composed by </h6> &nbsp;&nbsp;&nbsp;
style="display:inline
_END;


                    }/*End if($advancedSearchFound)*/
                } /*End if($advSearchDisplayQueryResult)*/
            }/*End if($compositionIDFound)*/
        }    /*forloop ending advSearchIdQuery*/
    } /*End if($advIDSearchQueryResult)*/
}/*End if($advancedSearch)*/


echo <<<_END

            <div class="container-fluid bg-secondary text-light pt-4 pb-3">

                <form action="introPage.php" method='post'>
                    <input class="btn btn-light" type='submit' value='Back to Site Options'/>
                </form> <!-- end form -->

                <form action="Print Search Results.php" method='post'>
                    <input class="btn btn-light" type='submit' $notFound value='Print Search Results'/>

                </form> <!-- end form -->

                <form action="advancedSearch.php" method='post'>
                  <input class="btn btn-light" type='submit' value='Try Another Advanced Search'/>
                  <input type='hidden' name='advSearch' value= 'true' />
                </form> <!-- end form -->
            </div> <!-- end container -->


_END;


include 'footer.html';
include 'endingBoilerplate.php';






