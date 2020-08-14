<?php
include 'boilerplate.php';
/*This page is no longer needed. See orgOptions.php*/
if($debug) {
  echo <<<_END
  
  <p>OrgOptions.php-9</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

/*Lists Organizations with similar names*/
/*using these GET values when coming from orgSearch.php. Result of sending info through the header.*/
/*Question: will there be a scenario where I will send  these through the post and need the POST values below?*/
if(isset($_GET['searchPubName_value'])) {
  $searchPubName = $_GET['searchPubName_value'];
}else{
  $searchPubName = $_POST['searchPubName_value'];
}



if(isset($_GET['bookID'])) {
  $bookID = $_GET['bookID'];
}else{
  $bookID = $_POST['bookID'];
}

if(isset($_GET['oldOrgID'])) {
  $oldOrgID = $_GET['oldOrgID'];
}else{
  $oldOrgID = $_POST['oldOrgID'];
}

echo "oldOrgID =" . $oldOrgID . "</br>";

if(isset($_GET['editBook'])) {
  $editBook = $_GET['editBook'];
  $sendEditBook = "<input type='hidden' name='editBook' value='$editBook' /> ";

}else{
  $editBook = $_POST['editBook'];
  $sendEditBook = "<input type='hidden' name='editBook' value='$editBook' /> ";
}

if(isset($_GET['replacePublisher'])) {
  $replacePublisher = $_GET['replacePublisher'];
}else{
  $replacePublisher = $_POST['replacePublisher'];
}

if(isset($_GET['addNewPublisher'])) {
  $addNewPublisher = $_GET['addNewPublisher'];
}else{
  $addNewPublisher = $_POST['addNewPublisher'];
}

if($editBook !=='') {
  $formAction = 'editBook.php';
}else{
  $formAction = 'addRole.php';
}


/*In this section we will process Publisher information being submitted to the data base by the user in the form on pg 10*/
/*If the user entered at least the Publisher name in the form on page10*/

/*ToDo*/
/*Determine if all of this validation code can be deleted because addOrg.php validates itself.I think only the second section of this code is needed now*/

$validationFailed = false;

/*boilerplate over, now validate if needed.*/

if(isset($_POST['pubName'])){

  /*Perform all validations needed for all fields*/
  if(empty($_POST['pubName'])) {
    $_SESSION['pubNameErr'] = " * Publisher Name is required";
    $validationFailed = true;
  } /*end if empty pubName*/

  /*if any validation failed, save all forms in sessions*/
  if($validationFailed) {
    $_SESSION['addOrg_validationFailed'] = true;
    $_SESSION['addOrg_pubName_value'] = $_POST['pubName'];
    $_SESSION['addOrg_pubLoc_value'] = $_POST['pubLoc'];
    $_SESSION['bookID'] = $_POST['bookID'];

  header('Location: addOrg.php');
  exit();

  }  /*end if validationFailed*/

  /*Validation over, now save form A (addOrg) post values in database*/

  /*if from addOrg - insert Publisher info*/

  if(isset($_POST['pubName'])) {
    if($debug) {
      echo "Since this is a submission from addOrg, insert publisher info" . "<br/>";
    }/*end debug*/
  

  /*wash the data coming in from user form pg 10 addOrg*/

    $washPostVar = cleanup_post($_POST['pubName']);
    $publisherName = strip_before_insert($conn, $washPostVar);

    $washPostVar = cleanup_post($_POST['pubLoc']);
    $publisherLocation = strip_before_insert($conn, $washPostVar);

  /*create the insert query to add the users publisher info into the organizations table*/ 
  

  $orgInsertQuery = <<<_END

    INSERT INTO organizations (org_name, location)
    VALUES('$publisherName', '$publisherLocation');

_END;

  
  /*Send query and place result into this variable*/
  $resultOrgInsertQuery = $conn->query($orgInsertQuery);
    if($debug) {
      echo("\n orgInsertQuery = " . $orgInsertQuery . "\n<br/>");
      if (!$resultOrgInsertQuery) echo("\n Error description OrgInsertQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/


  /*Need the most recent id entered for my org id for later*/
  $orgID = $conn->insert_id;


  /*Getting the organization Role ID (Publisher) so I can use it in the insert query below*/
  $publisherRoleQuery = "SELECT ID FROM roles WHERE role_name = 'Publisher'";
    if($debug) {
      echo("\n publisherRoleQuery = " . $publisherRoleQuery . "\n<br/><br/>");
    }/*end debug*/
      
  /*Send the query to the database*/
  $publisherRoleQueryResult   = $conn->query($publisherRoleQuery);
     
  /*in case result fails*/

    if($debug) {
      if (!$publisherRoleQueryResult) echo("\n Error description publisherRoleQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

  if ($publisherRoleQueryResult) {
    $numberOfRows = $publisherRoleQueryResult->num_rows;  /*gets the number of rows in a result*/

    /*build forloop*/
    for ($j = 0 ; $j < $numberOfRows ; ++$j) {
      $row = $publisherRoleQueryResult->fetch_array(MYSQLI_NUM); /*Fetch a result row as an numeric array*/

      /*create variables to hold each index (or column) from the given result row array*/
        
      /*This variable can now be used in other code*/
      $publisherRoleID = ($row[0]);
          
    } /*for loop ending*/

  } /*End if publisherRoleQueryResult */



  /*create insert query to add a row to the B2R2O table to connect this organization with this book as a publisher*/
  $insertQuery1 = "INSERT INTO B2R2O (book_ID, role_ID, org_ID)
    VALUES (  $bookID,
              $publisherRoleID,
              $orgID
                )";

    if($debug) {
      echo("\n insertQuery1 = " . $insertQuery1 . "\n<br/>");
    }/*end debug*/

  /*Send query and place result into this variable*/
  $insertQueryResult1 = $conn->query($insertQuery1);

    if($debug) {
      if (!$insertQueryResult1) echo ("Error description: " . mysqli_error($conn)) . "<br/>";
    }/*end debug*/

}  /*end if isset pubName*/









  /*Now, get fresh publisher info from database*/
  $publisherQuery = <<<_END

    SELECT  o.ID, o.org_name, o.location
    FROM books As b
    LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
    LEFT JOIN organizations AS o ON B2R2O.org_ID = o.ID
    JOIN roles AS r_pub ON B2R2O.role_ID = r_pub.ID AND r_pub.role_name = 'Publisher'
    WHERE o.org_name = '$searchPubName';

_END;

if($debug) {
  echo 'publisherQuery = ' . $publisherQuery . '<br/><br/>';
}/*end debug*/

  /*send the query*/
  $resultPublisherQuery = $conn->query($publisherQuery);


if($debug) {
  if (!$resultPublisherQuery) echo("\nError description publisherQuery: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

  if ($resultPublisherQuery){
    $numberOfPublisherRows = $resultPublisherQuery->num_rows;
    $publisherFound = ($numberOfPublisherRows > 0);
    $publisherNotFound = ($numberOfPublisherRows === 0);

    if ($publisherNotFound) {

      echo <<<_END
  
      <div class="container-fluid bg-secondary pb-3 pt-4">
        <h2 class="text-dark">Oops! No publisher by the name of "$publisherName" was found. <br/><br/></h2>
        <h4 class="text-light">You may want to try again, or report the error. <br/><br/></h4>
        <form action='addOrg.php' method='post'>
          <input class="btn btn-light" type='submit' value='Try adding publisher info again' />
          <input type='hidden' name='bookID' value='$bookID'/>
        </form> <!-- end form -->
  
        <form action='reportError.php' method='post'>
          <input class="btn btn-light" type='submit' value='Report Error' />
          <input type='hidden' name='bookID' value='$bookID'/>
        </form> <!-- end form -->
      </div> <!-- end container -->
     
_END;
  
    } /*END ifPublisherNotFound*/

    if($publisherFound) {
      echo <<<_END

      <div class="container-fluid bg-secondary pt-3 pb-3">
      <h5 class="text-light pb-2">Click on the "Choose this Publisher" button to continue.</h5>
      </div>  <!-- end container -->

_END;

  

    for ($j = 0 ; $j < $numberOfPublisherRows ; ++$j){
      $row = $resultPublisherQuery->fetch_array(MYSQLI_NUM);

      $publisherID = ($row[0]);
      $publisherName = ($row[1]);
      $publisherLocation = ($row[2]);
            
      echo <<<_END

      <div  class="container-fluid bg-secondary pt-4 pb-3">
        <div class="card">
          <div class="card-body bg-light">
            <form action="$formAction" method='post'>
            Publisher Name: $publisherName <br>
            Publisher Location: $publisherLocation<br><br>
              <input class="btn" type='submit' value='Choose this Publisher'/>
              <input type="hidden" name="newOrgID" value="$publisherID" />
            <input type="hidden" name="bookID" value="$bookID" />
            <input type='hidden' name='addNewPublisher' value='true'>
            </form> <br/> <!-- end form -->
          </div> <!--end card-body-->
        </div> <!--end card-->
      </div> <!--end container -->

_END;

    } /*for loop ending*/

    echo <<<_END

    <div class="container-fluid bg-secondary text-light pt-3 pb-3">
      <h2 class="mb-3">None of these Publishers match</h2>
      <form action="addOrg.php" method='post'>
        <input class="btn btn-light" type='submit' value='Add New Publisher Info'/>
        <input type='hidden' name='bookID' value='$bookID'/>
      </form> <!-- end form -->
      <form action="displayBook.php" method='post'>
        <input class="btn btn-light" type='submit' value='No Publisher: Continue'/>
        <input type='hidden' name='bookID' value='$bookID'/>
      </form> <!-- end form -->

    </div> <!-- end container -->

_END;

    } /*end if publisherFound*/

    

  } /*End ifresultPublisherQuery*/



}  /*END if isset post pubName */










/*In this section we will search the data base for the Publisher the user is looking for. They will have submitted the  name of the Publisher they want in the text box on pg 8. Then, the possible publishers are displayed. Then, should none of those publishers be the one the user wants, there is an option to add arranger information to the database ( using the code above) .*/


  
  $validationFailed = false; /*A single place to track whether any validation has failed.*/

/*boilerplate is over, now validate, if needed*/
/*If we didn't get sent back from page C, because Form B validation failed, validate form A Submission*/
if (isset($_POST['searchPubName'])) {
  /*perform all validations needed for all fields*/
if($debug) {
  echo 'skipped to if isset searchPubName';
}/*end debug*/

  if(empty($_POST['searchPubName']))  {
    
    $_SESSION['searchPubNameErr'] = ' * Publisher Name is required';
    $validationFailed = true;
  }/*end if empty searchPubName*/

  /*If any validation failed, save all form values in sessions*/

  if($validationFailed) {
    $_SESSION['orgSearch_validationFailed'] = true;
    $_SESSION['orgSearch_searchPubName_value'] = $_POST['searchPubName'];
    $_SESSION['bookID'] = $_POST['bookID'];
    
    
    header('Location: orgSearch.php');
    exit();
  } /*end if validation failed*/


/*Validation over, now save for A Post values in Database bottom half of code*/

  /*washes this user data*/

  $washPostVar = cleanup_post($_POST['searchPubName']);
  $searchPublisherName = strip_before_insert($conn, $washPostVar);
       
  /*searches the database for the publisher the user is looking for*/     
  $publisherQuery2 = <<<_END

    SELECT  o.ID, o.org_name, o.location
    FROM books As b
    LEFT JOIN B2R2O ON b.ID = B2R2O.book_ID
    LEFT JOIN organizations AS o ON B2R2O.org_ID = o.ID
    JOIN roles AS r_pub ON B2R2O.role_ID = r_pub.ID AND r_pub.role_name = 'Publisher'
    WHERE o.org_name = '$searchPublisherName';

_END;

if($debug) {
  echo 'publisherQuery2 = ' . $publisherQuery2 . '<br/><br/>';
}/*end debug*/

  /*send the query*/
  $resultPublisherQuery2 = $conn->query($publisherQuery2);

if($debug) {
  if (!$resultPublisherQuery2) echo("\n Error description resultPublisherQuery2: " . mysqli_error($conn) . "\n<br/>");
}/*end debug*/

  if ($resultPublisherQuery2){
    if($debug) {
      echo ("tattletale") ;
    }/*end debug*/

    $numberOfRows = $resultPublisherQuery2->num_rows;

    $publisherFound = ($numberOfRows  > 0);
    $publisherNotFound = ($numberOfRows === 0);

    if ($publisherNotFound) {
           
      echo <<<_END

      <div class="container-fluid bg-secondary pt-4 pb-3">
      <h2 class="display-4 text-light">Bummer!</h2>
        <h2>No publisher by the name of "$searchPublisherName" was found. <br/><br/></h2>
        <h4 class="text-light"> Which would you like to do? <br/><br/></h4>
        <form action='orgSearch.php' method='post'> 
          <input class="btn btn-light" type='submit' value='Try another Publisher Search'/>
          <input type='hidden' name='bookID' value='$bookID'/>       
        </form><br/><br/><!-- end form -->
        <form action='addOrg.php' method='post'> 
          <input class="btn btn-light" type='submit' value='Add New Publisher Information'/>
          <input type='hidden' name='bookID' value='$bookID'/>      
        </form><br/><br/><!-- end form -->
        <form action='displayBook.php' method='post'> 
          <input class="btn btn-light" type='submit' value='No Publisher: Continue'/>
          <input type='hidden' name='bookID' value='$bookID'/>       
        </form><br/><br/><!-- end form -->
      </div> <!-- end container -->

_END;

    } /*END if publisher not found*/

    if ($publisherFound) {
           
      echo <<<_END

      <div class="container-fluid bg-secondary pt-3 pb-3">
      <h5 class="text-light pb-2">Click on the "Choose Publisher" button to continue.</h5>
      

_END;

      for ($j = 0 ; $j < $numberOfRows ; ++$j){
        $row = $resultPublisherQuery2->fetch_array(MYSQLI_NUM);

        $publisherID2 = ($row[0]);
        $publisherName2 = ($row[1]);
        $publisherLocation2 = ($row[2]);
           
        /*When the button below is selected, we will go to the displayBook.php page to continue our composition information collection. Post values sent along are: bookid, editorid but not roleid. We will retrieve that on the displayBook page and insert those values into the B2R2O table to connect the organization as a publisher to the book information we are building. */
            

        echo <<<_END

        
        <div class="card mb-3">
          <div class="card-body bg-light">
            <form action="displayBook.php" method="post">
              Publisher Name: $publisherName2<br>
              Publisher Location: $publisherLocation2 <br><br>
              <input class="btn"  type='submit' value='Choose this Publisher'/>
              <input type='hidden' name='publisherID' value='$publisherID2'/> 
              <input type='hidden' name='bookID' value='$bookID'/>
              <input type='hidden' name='addNewPublisher' value='true'>   
            </form><br/>  <!-- end form -->
          </div>  <!-- end card-body --> 
        </div>  <!-- end card -->
        

_END;

      } /*for loop ending*/

      echo <<<_END

      

        <div class="container-fluid bg-secondary text-light pb-3">     
          <h2 class="mb-3">None of these publishers match</h2><br/>
          <form action="addOrg.php" method="post">
            <input class="btn btn-light"  type='submit' value='Add New Publisher Info'/> 
            <input type='hidden' name='bookID' value='$bookID'/>
            <input type='hidden' name='oldPeopleID' value='$oldPeopleID'/>
          </form><br/>  <!-- end form -->
          <form action="displayBook.php" method="post">
          <input class="btn btn-light"  type='submit' value='No Publisher: Continue'/> 
          <input type='hidden' name='bookID' value='$bookID'/>
        </div>  <!-- end container -->
        
_END;

    } /*end if publisherFound*/  

  } /*End ifresultPublisherQuery2*/ 
        
} /*End ifissetpost searchPubName */
      

include 'footer.html';
include 'endingBoilerplate.php';

?>







