<?php
include 'boilerplate.php';
/*Not intended to be kept*/
if($debug) {
    echo <<<_END
  
   <p>Composer options-19</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

/*Lists composers with similar last name*/
 
$bookID = $_POST['bookID'];
$compositionID = $_POST['compositionID'];

echo <<<_END
   
  <form action='arrangerSearch.php' method='post'>
  <div class="section">

_END;



/*If the user entered at least the lastname of the composer*/
if(isset($_POST['composerLastName'])){

/*wash the data coming in from user table pg 20*/

    $washPostVar = cleanup_post($_POST['composerFirstName']);
    $composerFirstName = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['composerMiddleName']);
    $composerMiddleName = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['composerLastName']);
    $composerLastName = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['composerSuffix']);
    $composerSuffix = strip_before_insert($conn, $washPostVar);
            

 /*create the insert query to add the users composer info into the people table*/ 
  /*$queryPeopleInsert = <<<_END

    INSERT INTO people (firstname, middlename, lastname, suffix)
    VALUES('{$_POST['composerFirstName']}','{$_POST['composerMiddleName']}','{$_POST['composerLastName']}','{$_POST['composerSuffix']}');
_END;*/

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
    if (!$queryPeopleInsertResult) echo("\n Error description: " . mysqli_error($conn) . "\n<br/>");
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
     
      /*incase result fails*/

if($debug) {
    if (!$roleQueryResult) echo("\n Error description roleQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

      if ($roleQueryResult) {
      $numberOfRows = $roleQueryResult->num_rows;  /*gets the number of rows in a result*/

        
      /*build forloop*/
      for ($j = 0 ; $j < $numberOfRows ; ++$j){
         $row = $roleQueryResult->fetch_array(MYSQLI_NUM); /*Fetch a result row as an numeric array*/

        /*create variables to hold each index (or column) from the given result row array*/
        
        /*This variable can now be used in other code*/
          $composerRoleID = ($row[0]);
          
        } /*for loop ending*/

    } /*End if Rolequery result*/

    /*create insert query to add a row to the B2R2P table to connect this person with this book as an editor*/
    $insertQuery = "INSERT INTO C2R2P (composition_ID, role_ID, people_ID)
      VALUES (  $compositionID,
                $composerRoleID,
                $peopleID
                )";

      echo ("\n insertQuery = " . $insertQuery . "\n<br/>");
      /*Send query and place result into this variable*/
      $insertQueryResult = $conn->query($insertQuery);

if($debug) {
    if (!$insertQueryResult) echo("Error description: " . mysqli_error($conn));
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
     
          $numberOfRows = $resultComposerQuery->num_rows;

          $composerFound = ($numberOfRows  > 0);
          $composerNotFound = ($numberOfRows === 0);


/*__________________________________________________________________________________ */      
          if ($composerNotFound) {
          
            echo <<<_END
             
            <div class="container bg-secondary pb-3">
            <h2 class="text-dark">No composer by the last name of "$composerLastName" was found. <br/><br/></h2>
            <h4 class="text-light"> Would you like to add this composer information to this composition? <br/><br/></h4>
            <form action="addComposer.php" method='post'>
            </div> <!-- end container -->


_END;

          } /*END if composer not found*/
          
        

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultComposerQuery->fetch_array(MYSQLI_NUM);

            $composerID = ($row[0]);
            $compFirst = ($row[1]);
            $compMiddle = ($row[2]);
            $compLast = ($row[3]);
            $compSuffix = ($row[4]);
          
echo <<<_END

          <input type="radio" name="composerPeopleID" value="$composerID"/> Composer Name: $compFirst $compMiddle $compLast $compSuffix<br><br>
_END;

          } /*for loop ending*/
      } /*End if $resultComposerQuery*/

}  /*END if isset composerlast name*/



/*printed out header, now we will loop through results set and display one radio per row*/
    if (isset($_POST['searchComposerLastName'])) {

        $washPostVar = cleanup_post($_POST['searchComposerLastName']);
        $searchComposerLastName = strip_before_insert($conn, $washPostVar);
       
        /*create query to select the editor from the database if it comes from either pg 7a or 6*/
        
      $composerQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions As c
        LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
        LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
        JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID AND r_composer.role_name = 'Composer'
        WHERE p.lastname = '$searchComposerLastName';

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
       
          $numberOfRows = $resultComposerQuery->num_rows;
          
          $composerFound = ($numberOfRows  > 0);
          $composerNotFound = ($numberOfRows === 0);


          if ($composerNotFound) {

              if($debug) {
                  echo "<h3>No composer by the last name of  \"" . $searchComposerLastName . "\" was found. <br/><br/> Would you like to add this composer information to this composition? <br/><br/>";
              }/*end debug*/
          } /*END if composer not found*/
/*_________________________________________________________________________________ */
          

          for ($j = 0 ; $j < $numberOfRows ; ++$j){
            $row = $resultComposerQuery->fetch_array(MYSQLI_NUM);

            $composerID = ($row[0]);
            $compFirst = ($row[1]);
            $compMiddle = ($row[2]);
            $compLast = ($row[3]);
            $compSuffix = ($row[4]);


            

echo <<<_END

          <input type="radio" name="composerPeopleID" value="$composerID"/> Composer Name: $compFirst $compMiddle $compLast $compSuffix<br><br>
_END;

          } /*for loop ending*/

      } /*End ifresult ComposerQuery*/
        
  } /*End if isset post composerLastName */


      
if($composerFound ) {

echo <<<_END
<h3>Choose a Composer option below</h3>
          <input type='submit' value='Choose Composer'/> 
          <input type='hidden' name='bookID' value='$bookID'/>
          <input type='hidden' name='compositionID' value='$compositionID'/>
      </div> 
    </form><br/>

      <h2>None of these composers match</h2>

_END;

  } /*END if $composerFound*/

  echo <<<_END

    <form action='addComposer.php' method='post'>
      <input type='submit' value='Add Composer Info to this composition'/>
      <input type='hidden' name='bookID' value='$bookID'/>
      <input type='hidden' name='compositionID' value='$compositionID'/>
    </form><br/><br/>

_END;

 
include 'footer.html';
include 'endingBoilerplate.php';

?>



 






