<?php
include 'boilerplate.php';
/*not current. See peopleOption.php*/
if($debug) {
    echo <<<_END
  
  <p>Arranger options-22</p>
   
_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

/*Lists arrangers with similar last name*/

$bookID = $_POST['bookID'];
$compositionID = $_POST['compositionID'];
$composerPeopleID = $_POST['composerPeopleID'];



/*In this section we will process Arranger information being submitted to the data base by the user in the form on pg 23 addArranger.php*/
/*If the user entered at least the lastname of the arranger in the form on page23 addArranger*/

if(isset($_POST['arrangerLastName'])){

   /*perform all validations needed for all fields*/

   if(empty($_POST['arrangerLastName'])) {
    $_SESSION['arrangerLastNameErr'] = " * Arranger Last Name is required";
    $validationFailed = true;
   } /*end if  post arrangerLastName*/

  /*if any validation failed, save all form values in sessions*/
   if($validationFailed) {
      $_SESSION['addArranger_validationFailed'] = true;
      $_SESSION['addArranger_arrangerFirstName_value'] = $_POST['arrangerFirstName'];
      $_SESSION['addArranger_arrangerMiddleName_value'] = $_POST['arrangerMiddleName'];
      $_SESSION['addArranger_arrangerLastName_value'] = $_POST['arrangerLastName'];
      $_SESSION['addArranger_arrangerSuffix_value'] = $_POST['arrangerSuffix'];
      $_SESSION['bookID'] = $_POST['bookID'];
      $_SESSION['arrangerID'] = $_POST['arrangerID'];
      $_SESSION['compositionID'] = $_POST['compositionID'];
   

      header('Location: addArranger.php');
      exit();
   } /*end if validationFailed*/


  /*wash the data coming in from user form pg 23 addArranger*/


    $washPostVar = cleanup_post($_POST['arrangerFirstName']);
    $arrangerFirstName = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['arrangerMiddleName']);
    $arrangerMiddleName = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['arrangerLastName']);
    $arrangerLastName = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['arrangerSuffix']);
    $arrangerSuffix = strip_before_insert($conn, $washPostVar);


  /*create the insert query to add the users arranger info into the people table*/ 
  
  $queryPeopleInsert = <<<_END

  INSERT INTO people (firstname, middlename, lastname, suffix)
  VALUES('$arrangerFirstName', '$arrangerMiddleName', '$arrangerLastName', '$arrangerSuffix');

_END;

if($debug) {
    echo("\n queryPeopleInsert = " . $queryPeopleInsert . "\n<br/>");
}/*end debug*/

  /*Send query and place result into this variable*/
  $queryPeopleInsertResult = $conn->query($queryPeopleInsert);

if($debug) {
    if (!$queryPeopleInsertResult) echo("\n Error description queryPeopleInsertResult: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

    /*Need the most recent id entered for my people id for later*/
    $peopleID = $conn->insert_id;


    /*Getting the arrnger Role ID so I can use it in the insert query below*/
    $roleQuery = "SELECT ID FROM roles WHERE role_name = 'Arranger'";
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
    for ($j = 0 ; $j < $numberOfRoleRows ; ++$j) {
      $row = $roleQueryResult->fetch_array(MYSQLI_NUM); /*Fetch a result row as an numeric array*/

      /*create variables to hold each index (or column) from the given result row array*/
        
      /*This variable can now be used in other code*/
      $arrangerRoleID = ($row[0]);
          
    } /*for loop ending*/

  } /*End if Rolequery result*/

  /*create insert query to add a row to the C2R2P table to connect this person with this composition as an arranger*/
  $insertQuery = "INSERT INTO C2R2P (composition_ID, role_ID, people_ID)
    VALUES (  $compositionID,
                $arrangerRoleID,
                $peopleID
                )";

if($debug) {
    echo("\n insertQuery = " . $insertQuery . "\n<br/>");
}/*end debug*/

  /*Send query and place result into this variable*/
  $insertQueryResult = $conn->query($insertQuery);

if($debug) {
    if (!$insertQueryResult) echo("Error description insertQueryResult: " . mysqli_error($conn));
}/*end debug*/

  /*Now, get fresh arranger info from data base */

  $arrangerQuery1 = <<<_END

    SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
    FROM compositions As c
    LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
    LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
    JOIN roles AS r_arr ON C2R2P.role_ID = r_arr.ID AND r_arr.role_name = 'Arranger'
    WHERE p.lastname = '$arrangerLastName';

_END;

if($debug) {
    echo 'arrangerQuery1 = ' . $arrangerQuery1 . '<br/><br/>';
}/*end debug*/

  /*send the query*/
  $resultArrangerQuery1 = $conn->query($arrangerQuery1);


if($debug) {
    if (!$resultArrangerQuery1) echo("Error description arrangerQuery1: " . mysqli_error($conn));
}/*end debug*/
  
  if ($resultArrangerQuery1){
       
    $numberOfArrangerRows1 = $resultArrangerQuery1->num_rows;
    $arrangerFound1 = ($numberOfArrangerRows1  > 0);
    $arrangerNotFound1 = ($numberOfArrangerRows1 === 0);
    
    if ($arrangerNotFound1) {

      echo <<<_END
          
      <div class="container-fluid bg-secondary pb-3">
        <h2 class="display-4">Oops...<br/><br/></h2>
        <h2 class="text-dark">Arranger info was not successfully entered into the catalogit music library. <br/><br/></h2>
        <h4 class="text-light" >You may want to try again, or report the error.<br/><br/></h4>     
        <form action='addArranger.php' method='post'>
          <input class="btn btn-light" type='submit' value='Try Adding Arranger Info Again' />
          <input type='hidden' name='bookID' value='$bookID'/>
          <input type='hidden' name='compositionID' value='$compositionID'/>
        </form> <!-- end form -->
  
        <form action="reportError.php' method='post'>
          <input class="btn btn-light" type='submit' value='Report Error' />
          <input type='hidden' name='bookID' value='$bookID'/>
          <input type='hidden' name='compositionID' value='$compositionID'/>
        </form> <!-- end form -->
      </div>  <!-- end container -->
                       
_END;
          
    } /*END if arranger not found1*/

    if ($arrangerFound1) {

      
      echo <<<_END
  
      <div class="container-fluid bg-secondary pt-4 pb-3">
        <h5 class="text-light pb-2"> Click on the "choose Arragnger" button to continue.</h5>
  
_END;


      for ($j = 0 ; $j < $numberOfArrangerRows1 ; ++$j){
        $row = $resultArrangerQuery1->fetch_array(MYSQLI_NUM);

        $arrangerID = ($row[0]);
        $arrFirst = ($row[1]);
        $arrMiddle = ($row[2]);
        $arrLast = ($row[3]);
        $arrSuffix = ($row[4]);
            

        echo <<<_END

      
        <div class="card mb-3">
          <div class="card-body bg-light">arrangerPeopleID
            <form action="lyricistSearch.php" method='post'>
              <div class="form-check">
                Arranger Name: $arrFirst $arrMiddle $arrLast $arrSuffix<br><br>
                <input class="btn" type='submit' value='Choose this Arranger'/>
                <input type='hidden' name='bookID' value='$bookID'/>
                <input type='hidden' name='arrangerPeopleID' value='$arrangerID'/>
                <input type='hidden' name='compositionID' value='$compositionID'/>
              </div>  <!-- form-check -->
            </form> <!-- end form -->
          </div>  <!-- end card-body -->
        </div>  <!-- end card -->
    

_END;

      } /*for loop ending*/

      echo <<<_END

      </div> <!-- end container -->

      <div class="container-fluid bg-secondary text-light pb-3">
        <h2 class="mb-3">None of these Arrangers match</h2>
        <form action="addArranger.php" method='post'>
          <input class="btn btn-light" type='submit' value='Add New Arranger Info'/>
          <input type='hidden' name='bookID' value='$bookID'/>
          <input type='hidden' name='compositionID' value='$compositionID'/>
        </form><br/> <!-- end form -->
        <form action="lyricistSearch.php" method='post'>
          <input class="btn btn-light" type='submit' value='No Arranger: Continue'/>
          <input type='hidden' name='bookID' value='$bookID'/>
          <input type='hidden' name='compositionID' value='$compositionID'/>
        </form> <!-- end form -->
      </div> <!-- end container -->

_END;

    } /*End if arrangerFound1*/
  } /*End if $resultArrangerQuery1*/

  
}  /*END if isset arrangerlast name*/










/*In this section we will search the data base for the Arranger the user is looking for. They will have submitted the last name of the Arranger they want in the text box on pg 21
Then the possible arrangers are displayed. 
Then, should none of those arrangers be the one the user wants, there is an option to add arranger information to the database (using the code above)*/
$validationFailed = false;
$bookID = $_POST['bookID'];
$compositionID = $_POST['compositionID'];

if (isset($_POST['searchArrangerLastName'])) {

 /*perform all validations needed for all fields*/


 if(empty($_POST['searchArrangerLastName'])) {
   $_SESSION['searchArrangerLastNameErr'] = ' * Last Name of Arranger is required';
   $validationFailed = true;
 } /*end if empty searchArrangerLastName*/

 /*If any validation failed, save all from values in sessions*/

 if($validationFailed) {
   $_SESSION['arrangerSearch_validationFailed'] = true;
   $_SESSION['arrangerSearch_searchComposerLastName_value'] = $_POST['searchArrangerLastName'];
   $_SESSION['compositionID'] = $_POST['compositionID'];
   $_SESSION['bookID'] = $_POST['bookID'];
   

   header('Location: arrangerSearch.php');
   exit();
 } /*end if validationFailed*/



 /*Validation over, now save form A Post values in database*/

  /*washes this user data*/


    $washPostVar = cleanup_post($_POST['searchArrangerLastName']);
    $searchArrangerLastName = strip_before_insert($conn, $washPostVar);
       
  /*searches the database for the arranger the user is looking for */
        
  $peopleQuery2 = <<<_END

    SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
    FROM people AS p
    WHERE p.lastname = '$searchArrangerLastName';

_END;

if($debug) {
    echo 'arrangerQuery2 = ' . $peopleQuery2 . '<br/><br/>';
}/*end debug*/

  /*send the query*/
  $resultPeopleQuery2 = $conn->query($peopleQuery2);


if($debug) {
    if (!$resultPeopleQuery2) echo("Error description $peopleQuery2: " . mysqli_error($conn));
}/*end debug*/

  if ($resultPeopleQuery2){
       
    $numberOfPeopleRows2 = $resultPeopleQuery2->num_rows;
    $peopleFound2 = ($numberOfPeopleRows2  > 0);
    $peopleNotFound2 = ($numberOfPeopleRows2 === 0);

         
    if ($peopleNotFound2) {
           
       echo <<<_END

      <div class="container-fluid bg-secondary pt-4 pb-3">
      <h2 class="display-4 text-light">Bummer!<br/><br/></h2>
        <h2>No arranger by the last name of  "$searchArrangerLastName" was found. <br/><br/></h2>
        <h4 class="text-light"> Which would you like to do? <br/><br/></h4>
        <form action="arrangerSearch.php" method='post'>
          <input class="btn btn-light" type='submit' value='Try another Arranger Search'/>
          <input type='hidden' name='bookID' value='$bookID'/>
          <input type='hidden' name='compositionID' value='$compositionID'/>
          <input type='hidden' name='composerPeopleID' value='$composerPeopleID'/>
        </form><br/><br/> <!-- end form -->
        <form action="addArranger.php" method='post'>
          <input class="btn btn-light" type='submit' value='Add New Arranger Information'/>
          <input type='hidden' name='bookID' value='$bookID'/>
          <input type='hidden' name='compositionID' value='$compositionID'/>
        </form><br/><br/> <!-- end form -->
        <form action="lyricistSearch.php" method='post'>
          <input class="btn btn-light" type='submit' value='No Arranger: Continue'/>
          <input type='hidden' name='bookID' value='$bookID'/>
          <input type='hidden' name='compositionID' value='$compositionID'/>
        </form><br/><br/> <!-- end form -->
      </div> <!-- end container -->

_END;

    } /*END if arranger not found*/

  if ($peopleFound2) {
    echo <<<_END

    <div class="container-fluid bg-secondary pt-3 pb-3">
      <h5 class="text-light pb-2">Click on the "choose Arragnger" button to continue.</h5>

_END;

    for ($j = 0 ; $j < $numberOfPeopleRows2 ; ++$j){
      $row = $resultPeopleQuery2->fetch_array(MYSQLI_NUM);

      $peopleID = ($row[0]);
      $peopleFirst = ($row[1]);
      $peopleMiddle = ($row[2]);
      $peopleLast = ($row[3]);
      $peopleSuffix = ($row[4]);

/*we will go to the lyricistSearch page to continue our composition information collection. Post values sent along are: composerid bookid compositionid composerid but not role id. We will retrieve that on the lyricistSearch page and insert those values into the C2R2P table to connect the person as an arranger to the composition information we are building. */

      echo <<<_END

      <div class="card mb-3">
        <div class="card-body bg-light">
          <form action="lyricistSearch.php" method='post'>
          <div class="form-check">
            Arranger Name: $peopleFirst $peopleMiddle $peopleLast $peopleSuffix<br><br>
            <input class="btn" type='submit' value='Choose this Arranger'/>
            <input type='hidden' name='bookID' value='$bookID'/>
            <input type='hidden' name='arrangerPeopleID' value='$peopleID'/>
            <input type='hidden' name='compositionID' value='$compositionID'/>
            <input type='hidden' name='addNewArranger' value='true'/>
            </div> <!-- form-check -->  
          </form> <!-- end form -->
        </div> <!-- end card-body -->
      </div> <!-- end card -->

_END;

    } /*for loop ending*/

    echo <<<_END

    </div> <!-- end container -->

    <div class="container-fluid bg-secondary text-light pb-3">
      <h2 class="mb-3">None of these Arrangers match</h2>
      <form action="addArranger.php" method='post'>
        <input class="btn btn-light" type='submit' value='Add New Arranger Info'/>
        <input type='hidden' name='bookID' value='$bookID'/>
        <input type='hidden' name='compositionID' value='$compositionID'/>
      </form> <!-- end form -->
      <form action="lyricistSearch.php" method='post'>
        <input class="btn btn-light" type='submit' value='No Arranger: Continue'/>
        <input type='hidden' name='bookID' value='$bookID'/>
        <input type='hidden' name='compositionID' value='$compositionID'/>
      </form> <!-- end form -->
      
    </div> <!-- end container -->

_END;

    }/*End if $peoplefound2*/

  } /*End ifresult peopleQuery2*/ 

        
} /*End if isset post searchArrangerLastName */
      



include 'footer.php';
include 'endingBoilerplate.php';

?>

