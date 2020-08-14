<?php
include 'boilerplate.php';

if($debug) {
  echo <<<_END
  
   <p>composerOnlyOptions- 47</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

/*Lists Composers with similar last name*/
 
$bookID = $_POST['bookID'];
$compositionID = $_POST['compositionID'];
$validationFailed = false; /*A single place to track whether any validation has failed*/

/*Normally, this section would be for validating and inserting the information from addComposer but since, in this instance, composer info cannot be added (since it must be connected to a book and composition), there will not be a section here at all as might have been expected*/









/*In this section we will search the data base for the composer the user is looking for. They will have submitted the  name of the Composer they want in the text box on pg 18
Then the possible composers are displayed.
Then, should none of those composers be the one the user wants, there is an option to add composer information to the database starting with the book Info*/


/*boilerplate is over, now validate, if needed*/


if (isset($_POST['searchComposerLastName'])) {
  /*perform all validations needed for all fields*/

if($debug) {
  echo "starting validation <br/>";
}/*end debug*/

  if(empty($_POST['searchComposerLastName'])) {
    $_SESSION['searchComposerLastNameErr'] = ' * Last Name of Composer is required';
    $validationFailed = true;
  } /*end if empty searchComposerLastName*/

  /*If any validation failed, save all from values in sessions*/

  if($validationFailed) {
    $_SESSION['composerOnlySearch_validationFailed'] = true;
    $_SESSION['composerOnlySearch_searchComposerLastName_value'] = $_POST['searchComposerLastName'];
    $_SESSION['compositionID'] = $_POST['compositionID'];

    header('Location: composerOnlySearch.php');
    exit();
  } /*end if validationFailed*/



  /*Validation over, now save form A Post values in database*/

  /*washes user data from text box on pg 18*/   

  $washPostVar = cleanup_post($_POST['searchComposerLastName']);
  $searchComposerLastName = strip_before_insert($conn, $washPostVar);

/*searches the database for the composer the user is looking for*/
  $composerQuery2 = <<<_END

  SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
  FROM compositions As c
  LEFT JOIN C2R2P ON c.ID = C2R2P.composition_ID
  LEFT JOIN people AS p ON C2R2P.people_ID = p.ID
  JOIN roles AS r_composer ON C2R2P.role_ID = r_composer.ID AND r_composer.role_name = 'Composer'
  WHERE p.lastname = '$searchComposerLastName';

_END;

if($debug) {
  echo 'composerQuery2 = ' . $composerQuery2 . '<br/><br/>';
}/*end debug*/

  /*send the query*/
  $resultComposerQuery2 = $conn->query($composerQuery2);

if($debug) {
  if (!$resultComposerQuery2) echo("\n Error description composerQuery2: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

  if ($resultComposerQuery2){
    if($debug) {
      echo 'check this 1 <br/>';
    }/*end debug*/

    $numberOfComposer2Rows = $resultComposerQuery2->num_rows;
    if($debug) {
      echo 'number of rows =' . $numberOfComposer2Rows . "<br/>";
    }/*end debug*/

    $composer2Found = ($numberOfComposer2Rows > 0);
    $composer2NotFound = ($numberOfComposer2Rows === 0);

    if ($composer2NotFound) {
      if($debug) {
        echo 'check this 2 <br/>';
      }/*end debug*/
      echo <<<_END

      <div class="container-fluid bg-secondary pt-4 pb-3">
        <h3 class="display-4 text-light" >Bummer!</h3>
        <h2 class="text-dark">No composer by the name of  "$searchComposerLastName" was found. <br/><br/></h2>
        <h4 class="text-light"> Which would you like to do? <br/><br/></h4>
        <form action="composerOnlySearch.php" method="post">
          <input class="btn btn-light"  type='submit' value='Try another Composer Search'/> 
        </form><br/>  <!-- end form -->
      
        <form action='bookTitleSearch.php' method='post'> 
          <input class="btn btn-light" type='submit' value='Add New composer information'/><br/>
          <span> * Composer info can only be added when connected to a composition and book.</span><br/>
          <span> We'll start with the book Info.</span>       
        </form>
        
      </div> <!-- end container -->

_END;

    } /*END if composer2 not found*/

    if ($composer2Found) {
      
      echo <<<_END

        <div class="container-fluid bg-secondary pt-3 pb-3">
          <h5 class="text-light pb-2">Click on the "Choose Composer" button to continue. </h5>      

_END;
          if($debug) {
            echo 'composer2 Found <br/>';
          }/*end debug*/
          for ($j = 0 ; $j < $numberOfComposer2Rows ; ++$j) {
            $row = $resultComposerQuery2->fetch_array(MYSQLI_NUM);

            $composerID = ($row[0]);
            $compFirst = ($row[1]);
            $compMiddle = ($row[2]);
            $compLast = ($row[3]);
            $compSuffix = ($row[4]);

  /*we will go to the arrangerSearch page to continue our composition information collection. Post values sent along are: composerid, bookid, compositionid but not role id. We will retrieve that on the arragnerSearch page and insert those values into the C2R2P table to connect the person as a composer to the composition information we are building. 
   */
            if($debug) {
              echo 'check this 5 <br/>';
            }/*end debug*/
 
            echo <<<_END

              <div class="card mb-3">
                <div class="card-body bg-light">
                  <form  action="displayComposer.php" method="post">
                  <div class="form-check">
                    Composer Name: $compFirst $compMiddle $compLast $compSuffix<br><br>
                    <input class="btn"  type='submit' value='Choose this Composer'/> 
                    <input type='hidden' name='composerID' value='$composerID'/>
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
                <form action="composerOnlySearch.php" method="post">
                  <input class="btn btn-light"  type='submit' value='Try a new Composer Search'/> 
                </form><br/>  <!-- end form -->
                <form action='bookTitleSearch.php' method='post'> 
                  <input class="btn btn-light" type='submit' value='Add New composer information'/><br/>
                  <span> * Composer info can only be added when connected to a composition and book.</span><br/>
                  <span> We'll start with the book Info.</span>      
                </form>
                  
              </div> <!-- end container -->
            </div> <!-- end Container -->

_END;
        if($debug) {
          echo 'check this 7 <br/>';
        }/*end debug*/
      } /*END if $composer2Found*/
  
  } /*End if result Composer Query*/ 
        
} /*End ifissetpost searchComposerlastname */

include 'footer.html';
include 'endingBoilerplate.php';

?>
