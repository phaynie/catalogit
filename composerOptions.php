<?php
include 'boilerplate.php';
/*Not current. See peopleOptions.php*/
if($debug) {
  echo <<<_END
  
   <p>Composer options- 19</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

/*Lists Composers with similar last name*/
 
$bookID = $_POST['bookID'];
$compositionID = $_POST['compositionID'];
$validationFailed = false; /*A single place to track whether an validation has failed*/



/*In this section we will process Composer information being submitted to the data base by the user in the form on pg 20*/
/*If the user entered at least the last name of the composer in the form on page18*/

/*boilerplate over, now validate, if needed*/

if(isset($_POST['composerLastName'])){
  /*perform all validations needed for all fields*/

  if(empty($_POST['composerLastName'])) {
    $_SESSION['composerLastNameErr'] = " * Composer Last Name is required";
    $validationFailed = true;
  } /*end if empty post composerLastName*/

  /*if any validation failed, save all form values in sessions*/
  if($validationFailed) {
    $_SESSION['addComposer_validationFailed'] = true;
    $_SESSION['addComposer_composerFirstName_value'] = $_POST['composerFirstName'];
    $_SESSION['addComposer_composerMiddleName_value'] = $_POST['composerMiddleName'];
    $_SESSION['addComposer_composerLastName_value'] = $_POST['composerLastName'];
    $_SESSION['addComposer_composerSuffix_value'] = $_POST['composerSuffix'];
    $_SESSION['bookID'] = $_POST['bookID'];
    $_SESSION['composerID'] = $_POST['composerID'];
    $_SESSION['compositionID'] = $_POST['compositionID'];

    header('Location: addComposer.php');
    exit();
  } /*end if validationFailed*/



  /*Validation over, now save form A (addComposer) Post values in database.*/

  /*wash the data coming in from user form pg 20*/
  
  $washPostVar = cleanup_post($_POST['composerFirstName']);
  $composerFirstName = strip_before_insert($conn, $washPostVar);
  
  $washPostVar = cleanup_post($_POST['composerMiddleName']);
  $composerMiddleName = strip_before_insert($conn, $washPostVar);
  
  $washPostVar = cleanup_post($_POST['composerLastName']);
  $composerLastName = strip_before_insert($conn, $washPostVar);
  
  $washPostVar = cleanup_post($_POST['composerSuffix']);
  $composerSuffix = strip_before_insert($conn, $washPostVar);

  /*create the insert query to add the users composer info into the people table*/ 
  $queryPeopleInsert = <<<_END

  INSERT INTO people (firstname, middlename, lastname, suffix)
  VALUES('$composerFirstName', '$composerMiddleName', '$composerLastName', '$composerSuffix');

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
    $numberOfRoleQueryRows = $roleQueryResult->num_rows;  /*gets the number of rows in a result*/
  
          
    /*build forloop*/
    for ($j = 0 ; $j < $numberOfRoleQueryRows ; ++$j){
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
              $peopleID
                  )";

if($debug) {
  echo ("\n insertQuery = " . $insertQuery . "\n<br/>");
}/*end debug*/

  /*Send query and place result into this variable*/
  $insertQueryResult = $conn->query($insertQuery);

  if($debug) {
    if (!$insertQueryResult) echo("Error description insertQueryResult: " . mysqli_error($conn));
  }/*end debug*/

  /*Now, get fresh composer info from data base */
  
  $composerQuery = <<<_END

    SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
    FROM compositions As c
    LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
    LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
    JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID AND r_composer.role_name = 'Composer'
    WHERE p.lastname = '$composerLastName';

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

    $numberOfComposer1Rows = $resultComposerQuery->num_rows;
    $composer1Found = ($numberOfComposer1Rows  > 0);
    $composer1NotFound = ($numberOfComposer1Rows === 0);


  if ($composer1NotFound) {
    echo <<<_END

    <div class="container-fluid bg-secondary pt-4 pb-3">
      <h2 class="display-4" >Oops! </h2>
      <h2 class="text-dark">Composer information for "$composerLastName" was not successfully entered into the catalogit Library. <br/><br/></h2>
      <h4 class="text-light" You may want to try again, or report the error. <br/><br/></h4>
      <form action='addComposer.php' method='post'>
        <input class="btn btn-light" type='submit' value='Try adding composer info again' />
      </form> <!-- end form -->
      <form action='reportError.php' method='post'>
        <input class="btn btn-light" type='submit' value='Report Error' />
      </form> <!-- end form -->
    </div> <!-- end container -->
          
_END;


  } /*END if composer1 not found*/

  if($composer1Found){
    echo <<<_END

      <div class="container-fluid bg-secondary pt-3 pb-3">
        <h5 class="text-light pb-2">Click on the "choose Composer" button to continue. </h5>
       

_END;


   
    for ($j = 0 ; $j < $numberOfComposer1Rows ; ++$j){
      $row = $resultComposerQuery->fetch_array(MYSQLI_NUM);

      $composerID = ($row[0]);
      $compFirst = ($row[1]);
      $compMiddle = ($row[2]);
      $compLast = ($row[3]);
      $compSuffix = ($row[4]);
  
echo <<<_END


      <div class="card mb-3">
        <div class="card-body bg-light">
          <form action="arrangerSearch.php" method='post'>
            <div class="form-check">
              Composer Name: $compFirst $compMiddle $compLast $compSuffix<br><br>
              <input class="btn" type='submit' value='Choose this Composer'/>
              <input type='hidden' name='bookID' value='$bookID'/>
              <input type='hidden' name='composerPeopleID' value='$composerID'/>
            <input type='hidden' name='compositionID' value='$compositionID'/>
            <input type='hidden' name='addNewComposer' value='true'/>
            </div> <!-- form-check -->
          </form> <br/> <!-- end form -->
        </div> <!-- card-body -->
      </div> <!-- card- -->
    

_END;

    } /*for loop ending*/
    echo <<<_END

    </div> <!-- end container -->

   

        <div class="container-fluid bg-secondary text-light pb-3">     
          <h2 class="mb-3">None of these composers match</h2>
          <form action="composerSearch.php" method="post">
          <input class="btn btn-light"  type='submit' value='Try New Composer Search'/> 
          <input type='hidden' name='bookID' value='$bookID'/>
          <input type='hidden' name='compositionID' value='$compositionID'/>
        </form><br/>  <!-- end form -->
          <form action="addComposer.php" method="post">
            <input class="btn btn-light"  type='submit' value='Add New Composer Info'/> 
            <input type='hidden' name='bookID' value='$bookID'/>
            <input type='hidden' name='compositionID' value='$compositionID'/>
          </form><br/>  <!-- end form -->
        </div>  <!-- end container -->



_END;

  } /*End if composer1Found*/
  } /*End if $resultComposerQuery*/

 
}  /*END if isset composerlast name*/
















/*In this section we will search the data base for the composer the user is looking for. They will have submitted the  name of the Composer they want in the text box on pg 18
Then the possible composers are diplayed.
Then should none of those composers be the one the user wants, there is an option to add composer information to the database*/
$validationFailed = false;

/*boilerplate is over, now validate, if needed*/

if (isset($_POST['searchComposerLastName'])) {
  /*perform all validations needed for all fields*/

if($debug) {
  echo "starting validation" . "<br/>";
}/*end debug*/

  if(empty($_POST['searchComposerLastName'])) {
    $_SESSION['searchComposerLastNameErr'] = ' * Last Name of Composer is required';
    $validationFailed = true;
  } /*end if empty searchComposerLastName*/

  /*If any validation failed, save all from values in sessions*/

  if($validationFailed) {
    $_SESSION['composerSearch_validationFailed'] = true;
    $_SESSION['composerSearch_searchComposerLastName_value'] = $_POST['searchComposerLastName'];
    $_SESSION['compositionID'] = $_POST['compositionID'];
    $_SESSION['bookID'] = $_POST['bookID'];

    header('Location: composerSearch.php');
    exit();
  } /*end if validationFailed*/



  /*Validation over, now save form A Post values in database*/

  /*washes user data from text box on pg 18*/

  $washPostVar = cleanup_post($_POST['searchComposerLastName']);
  $searchComposerLastName = strip_before_insert($conn, $washPostVar);

 

/*searches the database for the composer the user is looking for*/
  $peopleQuery2 = <<<_END

  SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
  FROM people AS p 
  WHERE p.lastname = '$searchComposerLastName';

_END;

if($debug) {
  echo '$peopleQuery2 = ' . $peopleQuery2 . '<br/><br/>';
}/*end debug*/

  /*send the query*/
  $resultPeopleQuery2 = $conn->query($peopleQuery2);

if($debug) {
  if (!$resultPeopleQuery2) echo("\n Error description $peopleQuery2: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

  if ($resultPeopleQuery2){

    if($debug) {
      echo 'check this 1 <br/>';
    }/*end debug*/

    $numberOfPeople2Rows = $resultPeopleQuery2->num_rows;
    if($debug) {
      echo 'number of People rows =' . $numberOfPeople2Rows . "<br/>";
    }/*end debug*/

    $people2Found = ($numberOfPeople2Rows > 0);
    $people2NotFound = ($numberOfPeople2Rows === 0);

    if ($people2NotFound) {
      echo 'check this 2 <br/>';
      echo <<<_END

      <div class="container-fluid bg-secondary pt-4 pb-3">
        <h3 class="display-4 text-light" >Bummer!</h3>
        <h2 class="text-dark">No composer by the name of  "$searchComposerLastName" was found. <br/><br/></h2>
        <h4 class="text-light"> Which would you like to do? <br/><br/></h4>

          <form action="composerSearch.php" method="post">
            <input class="btn btn-light"  type='submit' value='Try another Composer Search'/> 
            <input type='hidden' name='bookID' value='$bookID'/>
            <input type='hidden' name='compositionID' value='$compositionID'/>
          </form><br/>  <!-- end form -->
       
       
        <form action='addComposer.php' method='post'> 
          <input class="btn btn-light" type='submit' value='Add New composer information'/>
          <input type='hidden' name='bookID' value='$bookID'/>
          <input type='hidden' name='compositionID' value='$compositionID'/>       
        </form><br/><br/>
        <h2> *You must have a composer to continue.</h2>
      </div> <!-- end container -->

_END;

    } /*END if composer2 not found*/

    if ($people2Found) {
      
      echo <<<_END

        <div class="container-fluid bg-secondary pt-3 pb-3">
          <h5 class="text-light pb-2">Click on the "Choose Composer" button to continue. </h5>      

_END;

      if($debug) {
        echo 'people2 Found <br/>';
      }/*end debug*/

        for ($j = 0 ; $j < $numberOfPeople2Rows ; ++$j) {
            $row = $resultPeopleQuery2->fetch_array(MYSQLI_NUM);

            $peopleID = ($row[0]);
            $peopleFirst = ($row[1]);
            $peopleMiddle = ($row[2]);
            $peopleLast = ($row[3]);
            $peopleSuffix = ($row[4]);

  /*we will go to the Search page to continue our composition information collection. Post values sent along are: composerid, bookid, compositionid but not role id. We will retrieve that on the arragnerSearch page and insert those values into the C2R2P table to connect the person as a composer to the composition information we are building.
   */
          if($debug) {
            echo 'check this 5 <br/>';
          }/*end debug*/
 
            echo <<<_END

              <div class="card mb-3">
                <div class="card-body bg-light">
                  <form  action="arrangerSearch.php" method="post">
                  <div class="form-check">
                    Composer Name: $peopleFirst $peopleMiddle $peopleLast $peopleSuffix<br><br>
                    <input class="btn"  type='submit' value='Choose this Composer'/> 
                    <input type='hidden' name='bookID' value='$bookID'/>
                    <input type='hidden' name='compositionID' value='$compositionID'/> 
                    <input type='hidden' name='composerID' value='$peopleID'/>
                    <input type='hidden' name='addNewComposer' value='true'/> 
                  </div>  <!-- form-check -->
                  </form><br/>  <!-- end form -->
                </div>  <!-- end card-body --> 
              </div>  <!-- end card -->
_END;

            } /*for loop ending*/         

            echo <<<_END
      
            </div> <!-- end Container -->
      
              <div class="container-fluid bg-secondary text-light pb-3">     
                <h2 class="mb-3">None of these composers match</h2>
                <form action="composerSearch.php" method="post">
                  <input class="btn btn-light"  type='submit' value='Try a new Composer Search'/> 
                  <input type='hidden' name='bookID' value='$bookID'/>
                  <input type='hidden' name='compositionID' value='$compositionID'/>
                </form><br/>  <!-- end form -->
                <form action="addComposer.php" method="post">
                  <input class="btn btn-light"  type='submit' value='Add New Composer Info'/> 
                  <input type='hidden' name='bookID' value='$bookID'/>
                  <input type='hidden' name='compositionID' value='$compositionID'/>
                </form><br/>  <!-- end form -->
                </div> <!-- end Container -->

_END;

      if($debug) {
        echo 'check this 7 <br/>';
      }/*end debug*/

      } /*END if $people2Found*/
  
  } /*End if result people Query*/
        
} /*End ifissetpost searchComposerlastname */

include 'footer.html';
include 'endingBoilerplate.php';

?>





