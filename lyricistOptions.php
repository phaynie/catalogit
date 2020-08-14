<?php
include 'boilerplate.php';
/*This page is no longer needed. See peopleOptions.php*/
if($debug) {
  echo <<<_END
  
   <p>Lyricist options-25</p>
   
_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

/*Lists lyricists with similar last name*/

$bookID = $_POST['bookID'];
$compositionID = $_POST['compositionID'];
$composerID = $_POST['composerID'];
$arrangerID = $_POST['arrangerID'];

$lyricistFound = ($numberOfRows > 0);
$lyricistNotFound = ($numberOfRows === 0);






/*In this section we will process Lyricist information being submitted to the data base by the user in the form on pg 26 addLyricist.php*/
/*If the user entered at least the lastname of the Lyricist in the form on page26 addLyricist.php
*/
if(isset($_POST['lyricistLastName'])){
    /*perform all validations needed for all fields*/
 
    if(empty($_POST['lyricistLastName'])) {
     $_SESSION['lyricistLastNameErr'] = " * Lyricist Last Name is required";
     $validationFailed = true;
   } /*end if  post lyricistLastName*/
 
   /*if any validation failed, save all form values in sessions*/
   if($validationFailed) {
     $_SESSION['addLyricist_validationFailed'] = true;
     $_SESSION['addLyricist_lyricistFirstName_value'] = $_POST['lyricistFirstName'];
     $_SESSION['addLyricist_lyricistMiddleName_value'] = $_POST['lyricistMiddleName'];
     $_SESSION['addLyricist_lyricistLastName_value'] = $_POST['lyricistLastName'];
     $_SESSION['addLyricist_lyricistSuffix_value'] = $_POST['lyricistSuffix'];
     $_SESSION['bookID'] = $_POST['bookID'];
     $_SESSION['compositionID'] = $_POST['compositionID'];
    
 
     header('Location: addLyricist.php');
     exit();
   } /*end if validationFailed*/


   

  /*wash the data coming in from user form pg 26*/

  $washPostVar = cleanup_post($_POST['lyricistFirstName']);
  $lyricistFirstName = strip_before_insert($conn, $washPostVar);

  $washPostVar = cleanup_post($_POST['lyricistMiddleName']);
  $lyricistMiddleName = strip_before_insert($conn, $washPostVar);

  $washPostVar = cleanup_post($_POST['lyricistLastName']);
  $lyricistLastName = strip_before_insert($conn, $washPostVar);

  $washPostVar = cleanup_post($_POST['lyricistSuffix']);
  $lyricistSuffix = strip_before_insert($conn, $washPostVar);



  /*create the insert query to add the user's lyricist info into the people table*/ 
  $peopleInsertQuery = <<<_END

    INSERT INTO people (firstname, middlename, lastname, suffix)
    VALUES('$lyricistFirstName', '$lyricistMiddleName', '$lyricistLastName', '$lyricistSuffix');

_END;

if($debug) {
  echo("\n peopleInsertQuery = " . $peopleInsertQuery . "\n<br/>");
}/*end debug*/

  /*Send query and place result into this variable*/
  $peopleInsertQueryResult = $conn->query($peopleInsertQuery);

if($debug) {
  if (!$peopleInsertQueryResult) echo("\n Error description peopleInsertQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug/*

  /*Need the most recent id entered for my people id for later*/
  $peopleID = $conn->insert_id;

  /*Getting the lyricist Role ID so I can use it in the insert query below*/
  $roleQuery = "SELECT ID FROM roles WHERE role_name = 'Lyricist'";
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
    if($debug) {
    $numberOfRoleRows = $roleQueryResult->num_rows;  /*gets the number of rows in a result*/

    /*build forloop*/
    for ($j = 0 ; $j < $numberOfRows ; ++$j) {
      $row = $roleQueryResult->fetch_array(MYSQLI_NUM); /*Fetch a result row as an numeric array*/
    }/*end debug*/

      /*create variables to hold each index (or column) from the given result row array*/
        
      /*This variable can now be used in other code*/
      $lyricistRoleID = ($row[0]);
          
    } /*for loop ending*/

  } /*End if Rolequery result*/

  /*create insert query to add a row to the C2R2P table to connect this person with this composition as a lyricist*/
  $insertQuery = "INSERT INTO C2R2P (composition_ID, role_ID, people_ID)
    VALUES (  $compositionID,
                $lyricistRoleID,
                $peopleID
                )";

if($debug) {
  echo("\n insertQuery = " . $insertQuery . "\n<br/>");
}/*end debug*/

  /*Send query and place result into this variable*/
  $insertQueryResult = $conn->query($insertQuery);

if($debug) {
  if (!$insertQueryResult) echo("Error description InsertQuery: " . mysqli_error($conn));
}/*end debug*/

    /*Now, get fresh lyricist info from data base */

    $lyricistQuery1 = <<<_END

      SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
      FROM compositions As c
      LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
      LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
      JOIN roles AS r_lyr ON C2R2P.role_ID = r_lyr.ID AND r_lyr.role_name = 'Lyricist'
      WHERE p.lastname = '$lyricistLastName';

_END;

if($debug) {
  echo '$lyricistQuery1 = ' . $lyricistQuery1 . '<br/><br/>';
}/*end debug*/

    /*send the query*/
    $resultLyricistQuery1 = $conn->query($lyricistQuery1);


if($debug) {
  if (!$resultPeopleQuery1) echo("\n Error description lyricistQuery1: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

  if ($resultLyricistQuery1) {
     
    $numberOfLyricistRows = $resultLyricistQuery1->num_rows;

    $lyricistFound = ($numberOfLyricistRows  > 0);
    $lyricistNotFound = ($numberOfLyricistRows === 0);

    if ($lyricistNotFound) {
           
      echo <<<_END
  
      <div class="container bg-secondary pb-3">
        <h2 class="display-4">Oops! <br/><br/></h2>
        <h2 class="text-dark">Lyricist info was not successfully entered into the Catalogit music library.<br/><br/></h2>
        <h4 class="text-light">You may want to try again, or report the error.<br/><br/></h4>
        <form action="addLyricist.php" method="post">
          <input class="btn btn-light" type="submit" value="Try adding Lyricist info again"/>
        </form> <!-- end form -->
  
        <form action="reportError.php" method="post">
          <input class="btn btn-light" type="submit" value="Report Error"/>
        </form> <!-- end form -->
      </div> <!-- end container -->
  
_END;
  
    } /*END if lyricist not found*/

    if ($lyricistFound) {

      echo <<<_END

        <div class="container-fluid bg-secondary pt-4 pb-3">
        <h5 class="text-light pb-2">Click the radio button to choose a Lyricist Option below. Then, click on the "choose Lyricist" button to continue.</h5>

_END;

    for ($j = 0 ; $j < $numberOfLyricistRows ; ++$j){
      $row = $resultLyricistQuery1->fetch_array(MYSQLI_NUM);

      $lyricistID = ($row[0]);
      $lyrFirst = ($row[1]);
      $lyrMiddle = ($row[2]);
      $lyrLast = ($row[3]);
      $lyrSuffix = ($row[4]);
            

      echo <<<_END

      <div class="container-fluid bg-secondary pt-4 pb-3">
        <div class="card mb-3">
          <div class="card-body bg-light">
            <form action="displayComposition.php" method='post'>
              Lyricist Name: $lyrFirst $lyrMiddle $lyrLast $lyrSuffix<br><br>
              <input class="btn" type='submit' value='Choose this Lyricist'/>
              <input type='hidden' name='bookID' value= '$bookID' />
                <input type='hidden' name='compositionID' value= '$compositionID' />
                <input type='hidden' name='addNewLyricist' value= 'true' />
                <input type='hidden' name='lyricistPeopleID' value= '$lyricistID' />
            </form> <!-- end form -->
          </div> <!-- end card-body -->
        </div> <!-- end card -->
      </div> <!-- end container -->

_END;

    } /*for loop ending*/

    echo <<<_END

    </div> <!-- end container -->

    <div class="container-fluid bg-secondary text-light pb-3">
      <h2 class="mb-3">None of these lyricists match</h2>
      <form action="addLyricist.php" method='post'>
        <input class="btn btn-light" type='submit' value='Add new Lyricist Info'/>
        <input type='hidden' name='bookID' value= '$bookID' />
        <input type='hidden' name='compositionID' value= '$compositionID' />
        <input type='hidden' name='composerID' value='$composerID' />
        <input type='hidden' name='arrangerID' value= '$arrangerID' />
      </form> <br/><!-- end form -->
      <form action="displayComposition.php" method='post'>
        <input class="btn btn-light" type='submit' value='No Lyricist: Continue'/>
        <input type='hidden' name='bookID' value= '$bookID' />
        <input type='hidden' name='compositionID' value= '$compositionID' />
      </form> <!-- end form -->
    </div> <!-- end container -->

_END;

    } /*End if  $lyrcistFound*/

  } /*End if $resultLyricistQuery1*/

}  /*END if isset lyricistLastName*/










/*In this section we will search the data base for the lyricist the user is looking for. They will have submitted the last name of the lyricist they want in the text box on pg 24 lyricistSearch
Then the possible lyricists are displayed through a radio button.
Then, should none of those arranger be the one the user wants, there is an option to add arranger information to the database (using the code above)*/

$validationFailed = false;  /*a single place to track whether any validation has failed.*/
/*boilerplate is over, now validate, if needed.*/


if (isset($_POST['searchLyricistLastName'])) {
  /*perform all validations needed for all fields*/

  if(empty($_POST['searchLyricistLastName'] )) {
    $_SESSION['searchLyricistLastNameErr'] = ' * Lyricist Last Name is required';
    $validationFailed = true;
  }/*end if empty search Lyricist*/

  /*If any validation failed, save all form values in sessions*/
  if($validationFailed) {
    $_SESSION['lyricistSearch_validationFailed'] = true;
    $_SESSION['lyricistSearch_searchLyricistLastName_value'] = $_POST['searchLyricistLastName'];
    $_SESSION['bookID'] = $_POST['bookID'];
    $_SESSION['compositionID'] = $_POST['compositionID'];

    header('Location: lyricistSearch.php');
    exit();
  }/*End if validation failed*/


  /*Validation over, now wash post values and place in variables to be used later. */


  /*washes this user data*/

  $washPostVar = cleanup_post($_POST['searchLyricistLastName']);
  $searchLyricistLastName = strip_before_insert($conn, $washPostVar);
       
  /*searches the database for the lyricist the user is looking for*/
  $peopleQuery2 = <<<_END

    SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
    FROM people As p
    WHERE p.lastname = '$searchLyricistLastName';

_END;

if($debug) {
  echo '$peopleQuery2 = ' . $peopleQuery2 . '<br/><br/>';
}/*end debug*/


  /*send the query*/
  $resultPeopleQuery2 = $conn->query($peopleQuery2);


if($debug) {
  if (!$resultPeopleQuery2) echo("\n Error description $peopleQuery2: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

  if ($resultPeopleQuery2) {
        
    $numberOfPeopleRows = $resultPeopleQuery2->num_rows;

    $peopleFound2 = ($numberOfPeopleRows  > 0);
    $peopleNotFound2 = ($numberOfPeopleRows === 0);

    if ($peopleNotFound2) {
           
      echo <<<_END
            
      <div class="container-fluid bg-secondary pt-4 pb-3">
      <h2 class="display-4 text-light">Bummer! <br/><br/></h2>
      <h2 >No lyricist by the last name of "$searchLyricistLastName" was found. <br/><br/></h2>
      <h4 class="text-light"> Which would you like to do? <br/><br/></h4>
      
      <form action="lyricistSearch.php" method='post'>
        <input class=" btn btn-light" type='submit' value='Try another Lyricist Search'/>
        <input type="hidden" name='bookID' value='$bookID'/>
        <input type="hidden" name='compositionID' value='$compositionID'/>
      </form><br/> <!-- end form -->
      <form action="addLyricist.php" method='post'>
        <input class="btn btn-light" type='submit' value='Add New Lyricist Information'/>
        <input type="hidden" name='bookID' value='$bookID'/>
        <input type="hidden" name='compositionID' value='$compositionID'/>
      </form><br/> <!-- end form -->
      <form action="displayComposition.php" method='post'>
        <input class="btn btn-light" type='submit' value='No Lyricist: Continue'/>
        <input type="hidden" name='bookID' value='$bookID'/>
        <input type="hidden" name='compositionID' value='$compositionID'/>
      </form> <!-- end form -->
      
      </div> <!-- end container -->

_END;

    } /*END if people not found2*/

    if ($peopleFound2) {

      echo <<<_END

        <div class="container-fluid bg-secondary pt-4 pb-3">
        <h5 class="text-light pb-2">Click the radio button to choose a Lyricist Option below. Then, click on the "choose Lyricist" button to continue.</h5>

_END;

      for ($j = 0 ; $j < $numberOfPeopleRows ; ++$j){
        $row = $resultPeopleQuery2->fetch_array(MYSQLI_NUM);

        $peopleID2 = ($row[0]);
        $peopleFirst = ($row[1]);
        $peopleMiddle = ($row[2]);
        $peopleLast = ($row[3]);
        $peopleSuffix = ($row[4]);


        /*When the radio button below is selected, we will go to the displayComposition.php page to continue our composition information collection. Post values sent along are: 
        composerid bookid compositionid but not role id. We will retrieve it on the display composition page and insert those values into the C2R2P table to connect the person as a Lyricist to the composition information we are building. */

        echo <<<_END

          <div class="card mb-3">
            <div class="card-body bg-light">
              <form action="displayComposition.php" method='post'>
                <input type="radio" name="lyricistPeopleID" value="$peopleID2"/> Lyricist Name: $peopleFirst $peopleMiddle $peopleLast $peopleSuffix<br><br>
                <input class="btn" type='submit' value='Choose this Lyricist'/>
                <input type='hidden' name='bookID' value= '$bookID' />
                <input type='hidden' name='compositionID' value= '$compositionID' />
                <input type='hidden' name='composerID' value='$composerID' />
                <input type='hidden' name='arrangerID' value= '$peopleID2' />
                <input type='hidden' name='addNewLyricist' value= 'true' />
              </form> <!-- end form -->
            </div> <!-- card-body -->
          </div> <!-- card -->

_END;

      } /*for loop ending*/


      echo <<<_END

        </div> <!-- end container -->

        <div class="container-fluid bg-secondary text-light pb-3">
          <h2 class="mb-3">None of these lyricists match</h2>
          <form action="addLyricist.php" method='post'>
            <input class="btn btn-light" type='submit' value='Add new Lyricist Info'/>
            <input type='hidden' name='bookID' value= '$bookID' />
            <input type='hidden' name='compositionID' value= '$compositionID' />
            <input type='hidden' name='composerID' value='$composerID' />
            <input type='hidden' name='arrangerID' value= '$peopleID2' />
          </form><br> <!-- end form -->
          <form action="displayComposition.php" method='post'>
          <input class="btn btn-light" type='submit' value='No Lyricist: Continue'/>
          <input type='hidden' name='bookID' value= '$bookID' />
          <input type='hidden' name='compositionID' value= '$compositionID' />
          </form> <!-- end form -->
        </div> <!-- end container -->

_END;

} /*End if  $peopleFound*/
  } /*End ifresult peopleQuery2*/
        
  } /*End if isset post searchLyricistLastName */
      



include 'footer.html';
include 'endingBoilerplate.php';

?>






