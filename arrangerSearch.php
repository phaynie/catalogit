<?php
include 'boilerplate.php';
/*Not current. See peopleOptions.php*/
if($debug) {
  echo <<<_END

    <p>arrangerSearch-21</p>
    
_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';


$compositionID = $_POST['compositionID'];
$bookID = $_POST['bookID'];
$composerPeopleID = $_POST['composerPeopleID'];



/*In the previous page (19 composerOptions), we were sent to this page (arrangerSearch)  to continue our composition information collection. Post values sent along are: composerpeopleid, bookid, compositionid but not role id. We will retrieve this roleid below, and insert those values into the C2R2P table to connect the person as a composer to the composition information we are building. 
   */ 
if(empty($bookID)) {
  $bookID = $_SESSION['bookID'];
}
        


if(isset($_POST['addNewComposer'])){
  /*Getting the composer Role ID so I can use it in the insert query below*/
  $roleQuery = "SELECT ID FROM roles WHERE role_name = 'Composer'";

if($debug) {
  echo("\n roleQuery = " . $roleQuery . "\n<br/><br/>");
}/*end debug*/
  
  /*Send the query to the database*/
  $roleQueryResult   = $conn->query($roleQuery);
 
  /*in case result fails*/

if($debug) {
  if (!$roleQueryResult) echo("\n Error description roleQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

  if ($roleQueryResult) {
    $numberOfRoleRows = $roleQueryResult->num_rows;  /*gets the number of rows in a result*/

      
    /*build forloop*/
    for ($j = 0 ; $j < $numberOfRoleRows ; ++$j){
       $row = $roleQueryResult->fetch_array(MYSQLI_NUM); /*Fetch a result row as an numeric array*/

      /*create variables to hold each index (or column) from the given result row array*/
      
      /*This variable can now be used in other code*/
        $composerRoleID = ($row[0]);
        
    } /*for loop ending*/

  } /*End if Rolequery result*/

  /*create insert query to add a row to the C2R2P table to connect this person with this composition as a composer*/
  $insertQuery = "INSERT INTO C2R2P (composition_ID, role_ID, people_ID)
    VALUES (  $compositionID,
              $composerRoleID,
              $composerPeopleID
              )";
if(debug) {

  echo ("\n insertQuery = " . $insertQuery . "\n<br/>");

}/*end Debug*/
    /*Send query and place result into this variable*/
  $insertQueryResult = $conn->query($insertQuery);

if(debug) {
  if (!$insertQueryResult) echo("Error description insertQueryResult: " . mysqli_error($conn));
}/*end Debug*/

} /*end if isset add new composer */




if(empty($compositionID)) {
  $compositionID = $_SESSION['compositionID'];
}

/*Retrieving all key signatures for this composition
I will also be creating a comma separated list to use in the displayed information*/
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

    $numberOfKeyRows = $resultKeySigQuery->num_rows;
    /*Build comma separated list of key signatures in a string*/

    $keySignatureString= "";

    for ($j = 0 ; $j < $numberOfKeyRows ; ++$j){
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

  $numberOfGenreRows = $resultGenresQuery->num_rows;
  /*Build comma separated list of genres in a string*/

  $genreString= "";

  for ($j = 0 ; $j < $numberOfGenreRows ; ++$j) {
    $row = $resultGenresQuery->fetch_array(MYSQLI_NUM);

    /* var_dump ($row);*/
           
    $genreName = ($row[0]);

    $genreString .= $genreName .", ";
            
  } /*for loop ending*/
    
} /*End if result select genres query*/

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

  $numberOfInstRows = $resultInstrumentQuery->num_rows;
  /*Build comma separated list of instruments in a string*/
  $instrumentString= "";

  for ($j = 0 ; $j < $numberOfInstRows ; ++$j) {
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

  $numberOfGenRows = $resultGenDiffQuery->num_rows;

  for ($j = 0 ; $j < $numberOfGenRows ; ++$j) {
    $row = $resultGenDiffQuery->fetch_array(MYSQLI_NUM);

    /*  var_dump ($row);*/
           
    $GenDiffName = ($row[0]);
            
  } /*for loop ending*/
    
} /*End if result select gendiff query*/




/*Retrieving the ASP difficulty for this composition*/

$aspDiffQuery = <<<_END

  SELECT  d.difficulty_level
  FROM compositions AS c 
  LEFT JOIN C2D ON c.ID = C2D.composition_ID
  LEFT JOIN difficulties AS d ON C2D.difficulty_ID = d.ID
  JOIN organizations as o On d.org_ID = o.ID AND o.org_name = 'ASP'
  WHERE C2D.composition_ID = $compositionID;

_END;

$resultASPDiffQuery = $conn->query($aspDiffQuery);
if($debug) {
  echo '$aspDiffQuery = ' . $aspDiffQuery . '<br/><br/>';

  if (!$resultASPDiffQuery) echo("\n Error description aspDiffQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/
if ($resultASPDiffQuery) {     

  $numberOfASPRows = $resultASPDiffQuery->num_rows;

  for ($j = 0 ; $j < $numberOfASPRows ; ++$j) {
    $row = $resultASPDiffQuery->fetch_array(MYSQLI_NUM);

    /* var_dump ($row);*/

    $ASPDiffName = ($row[0]);
            
  } /*for loop ending*/
    
} /*End if result select ASPdiff query*/




/*G- Retrieve book and Composition information to display in browser.
1- Book Information
2- Composition information minus the composer, Arranger, or Lyricist*/

if(empty($bookID)){
  $bookID = $_SESSION['bookID'];
} /*End if empty book ID*/

if($debug) {
  echo 'bookID = ' . '<br/>';
}/*end debug*/

$bookQuery = <<<_END


  SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, p.firstname, p.middlename, p.lastname, p.suffix, org_pub.org_name, org_pub.location
      FROM books AS b
      LEFT JOIN B2R2P ON b.ID = B2R2P.book_ID
      LEFT JOIN roles AS r_ed ON B2R2P.role_ID = r_ed.ID AND r_ed.role_name = 'Editor'
      LEFT JOIN people AS p ON B2R2P.people_ID = p.ID
           
      LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
      LEFT JOIN roles AS r_pub ON B2R2O.role_ID = r_pub.ID AND r_pub.role_name = 'Publisher'
      LEFT JOIN organizations AS org_pub ON B2R2O.org_ID = org_pub.ID              

       WHERE b.ID = $bookID  

_END;

$resultBookQuery = $conn->query($bookQuery);
if($debug) {
  echo 'bookQuery = ' . $bookQuery . '<br/><br/>';

if (!$resultBookQuery) echo("\n Error description bookQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

if ($resultBookQuery) {     

  $numberOfBookRows = $resultBookQuery->num_rows;

  for ($j = 0 ; $j < $numberOfBookRows ; ++$j)  {
    $row = $resultBookQuery->fetch_array(MYSQLI_NUM);

    /* var_dump ($row);*/
    /*We do not need to sanitize these*/
    $queryBookID = ($row[0]);
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

  } /*End Book Query for loop*/
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

if($debug) {
  $resultCompositionQuery = $conn->query($compositionQuery);
  echo 'compositionQuery = ' . $compositionQuery . '<br/><br/>';

if (!$resultCompositionQuery) echo("\n Error description compositionQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/
if ($resultCompositionQuery) {     

  $numberOfCompositionRows = $resultCompositionQuery->num_rows;

  for ($j = 0 ; $j < $numberOfCompositionRows ; ++$j) {
    $row = $resultCompositionQuery->fetch_array(MYSQLI_NUM);

    /*  var_dump ($row);*/

    $queryCompositionID = ($row[0]);
    $compName = ($row[1]);            
    $opusLike = ($row[2]);
    $compNum = ($row[3]);
    $compNo = ($row[4]);
    $subTitle = ($row[5]);                          
    $movement = ($row[6]);
    $era = ($row[7]);            
    $voice = ($row[8]);
    $ensemble = ($row[9]); 
    $CompbookID = ($row[10]);
            
           
  } /*for loop ending*/
} /*END result Composition Query*/


if(empty($composerPeopleID)) {
  $composerPeopleID = $_SESSION['$composerPeopleID'];
}

$composerQuery = <<<_END

  SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
  FROM compositions As c
  LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
  LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
  JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID AND r_composer.role_name = 'Composer'
  WHERE p.ID = $composerPeopleID;


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

  for ($j = 0 ; $j < $numberOfComposerRows ; ++$j) {
    $row = $resultComposerQuery->fetch_array(MYSQLI_NUM);
    $composerPeopleID = ($row[0]);
    $compFirst = ($row[1]);
    $compMiddle = ($row[2]);
    $compLast = ($row[3]);
    $compSuffix = ($row[4]);
            
  } /*for loop ending*/
} /*END if result composer query*/

/* H- Display Book information and Composition info Using HTML*/
echo <<<_END

    <div class="container-fluid bg-light pt-4 pb-5">
      <h3 class="display-4 pb-3">So Far So Good!</h3>
      <h3 class="pb-4"> This composition information was added successfully!</h3>
    </div> <!--end container-->
      
    <div class="container-fluid bg-light pt-4 pb-5">
      <div class="row">
        <div class=" col-md-6 pb-4">
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
            </div> <!-- end card-body -->
          </div> <!--end card-->
        </div> <!--end col-->

        <div class=" col-md-6 pb-4">
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
              Difficulty: Gen $GenDiffName / ASP $ASPDiffName <br/>
              Composer Name: $compFirst $compMiddle $compLast $compSuffix <br/>
            </div> <!-- end card-body -->
          </div> <!--end card-->
        </div> <!--end col-->
      </div> <!--end row-->
    </div> <!--end container-->

_END;



/*next we will display form with text box for arranger's last name and button "Search for this arranger". We will also pass hidden values needed in the next page */

echo <<<_END

    <div class="container-fluid bg-light pt-4 pb-5">
      <div class="col-md-6">
        <form action='arrangerOptions.php' method='post'>
          <h3 class="display-4"> Let's Continue...</h3>
          <h5> If there is an arranger for this composition, enter arranger's Last name only below.</h5>

_END;

        if(isset($_SESSION['arrangerSearch_validationFailed'])) {

           echo<<<_END

          <span class="error">{$_SESSION['searchArrangerLastNameErr']}</span>
          <input class="form-control" type="text" name="searchArrangerLastName" value="{$_SESSION['arrangerSearch_searchArrangerLastName_value']}"/>
          <input class="btn btn-secondary mt-4" type='submit' value='Search for this Arranger'/>
          <input type='hidden' name='bookID' value="{$_SESSION['bookID']}"/>
          <input type='hidden' name='compositionID' value="{$_SESSION['compositionID']}"/>
          <input type='hidden' name='composerPeopleID' value="{$_SESSION['composerPeopleID']}"/>

_END;

        }else{
          echo<<<_END

         
          <input class="form-control" type="text" name="searchArrangerLastName" />
          <input class="btn btn-secondary mt-4" type='submit' value='Search for this Arranger'/>
          <input type='hidden' name='bookID' value="$bookID"/>
          <input type='hidden' name='compositionID' value="$compositionID"/>
          <input type='hidden' name='composerPeopleID' value="$composerPeopleID"/>

_END;

        }/*end if(isset($_SESSION['arrangerSearch_validationFailed']*/

        echo<<<_END

        </form>
        <form action='lyricistSearch.php' method='post'>
          <input class="btn btn-secondary mt-4" type='submit' value='No arranger: Continue'/>
          <input type='hidden' name='bookID' value= '$bookID'/>
          <input type='hidden' name='compositionID' value= '$compositionID'/>
          <input type='hidden' name='composerPeopleID' value= '$composerPeopleID'/>
        </form>
      </div> <!--end col-->
    </div> <!--end container-->

_END;

  
     /*destroy session variables*/
     unset($_SESSION['arrangerSearch_validationFailed']);
     unset($_SESSION['arrangerSearch_searchComposerLastName_value']);
     unset($_SESSION['searchArrangerLastNameErr']);
     unset($_SESSION['bookID']);
     unset($_SESSION['compositionID']);
 
     

include 'footer.php';
include 'endingBoilerplate.php';

?>







