<?php
include 'boilerplate.php';

if($debug) {
    echo <<<_END
  
  <p>OrgOptions.php-9</p>

_END;

}/*end debug*/


include 'beginningNav.php';

/*We arrive at this page if
-we are adding a new book to the library, and have submitted a publisher name to be added to the new book
-we are editing a current book and want to add or replace the publisher for the current book*/

/*This page will
-search for the publisher the user asked for in the orgSearch page
-display any organizations found that match the search
-provide choices to
    -choose an existing organization
    -try another search
    -add new organization info to the database*/

/*Initialize Variables*/

$searchPubName = "";
$bookID = "";
$bookTitle = "";
$oldOrgID = "";
$newOrgID = "";
$editBook = "";
$replacePublisher = "";
$sendEditBook = "";
$addNewPublisher = "";
$role = "";

$sendAddNewPublisher = "";
$sendReplacePublisher = "";
$formAction = "";
$editReplaceDeletePub = "" ;






/*using Request values allows us to find our keys in the Get, Post or Cookie array.*/

if(isset($_REQUEST['searchPubName'])) {
    $searchPubName = $_REQUEST['searchPubName'];
}

if(isset($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if(isset($_REQUEST['bookTitle'])) {
    $bookTitle = $_REQUEST['bookTitle'];
}

if(isset($_REQUEST['oldOrgID'])) {
    $oldOrgID = $_REQUEST['oldOrgID'];
}

echo "oldOrgID =" . $oldOrgID . "</br>";

if(isset($_REQUEST['editBook'])) {
    $editBook = $_REQUEST['editBook'];
}

if(isset($_REQUEST['replacePublisher'])) {
    $replacePublisher = $_REQUEST['replacePublisher'];
}


if(isset($_REQUEST['addNewPublisher'])) {
    $addNewPublisher = $_REQUEST['addNewPublisher'];
}


if(isset($_REQUEST['editReplaceDeletePub'])) {
    $editReplaceDeletePub = $_REQUEST['editReplaceDeletePub'];
}

/*create logic to use variables for many situations*/

if($editBook == 'true') {
    $sendEditBook = "<input type='hidden' name='editBook' value='$editBook' /> ";
}

if($replacePublisher == 'true') {
    $sendReplacePublisher = "<input type='hidden' name='replacePublisher' value='$replacePublisher' /> ";
}

if($addNewPublisher == 'true') {
    $sendAddNewPublisher = "<input type='hidden' name='addNewPublisher' value='$addNewPublisher' /> ";
}


if($editBook !=='') {
    $formAction = 'editBook.php';
}else{
    $formAction = 'displayBook.php';
}


if($editReplaceDeletePub == 'true') {
    $role = "Publisher";
    $sendEdit = "<input type='hidden' name='editPublisher' value='true' /> ";
    $sendReplace = "<input type='hidden' name='replacePublisher' value='true' /> ";
    $sendDelete = "<input type='hidden' name='deletePublisher' value='true' /> ";
    /*$editReplaceDeletePerson = $editReplaceDeleteLyricist;  not needed only one organization*/
    $deleteButton = 'deletePublisher_button';
}


/*boilerplate over*/



/*In this section we will search the data base for the Publisher the user is looking for. They will have submitted the  name of the Publisher they want in the text box in orgSearch.php. Then, the possible publishers are displayed. Then, should none of those publishers be the one the user wants, there is an option to add new Publisher information to the database. User is sent to addOrg.php
There is also the possibility that there is no Publisher. Since Publisher is the final step in collecting book information, the "No Publisher, continue" button takes the user either back to  displayBook.php or editBook.php to let the user decide what they want to do next*/


if (strlen($searchPubName) > 0  ) {

    /*searches the database for the publisher the user is looking for*/
    /*I am commenting this code out because it asks specifically for an organization where the role is publisher.
    I believe I will not need this code in other situations since I should only be looking for an organization
     not a publisher. I will copy and paste this query changing it to look for only an organization, not a
    publisher. */

    $orgQuery = <<<_END

    SELECT  o.ID, o.org_name, o.location
    FROM organizations As o
    LEFT JOIN B2R2O ON o.ID = B2R2O.org_ID 

    WHERE o.org_name LIKE '%$searchPubName%';

_END;


    if($debug) {
        echo 'orgQuery = ' . $orgQuery . '<br/><br/>';
    }/*end debug*/

    /*send the query*/
    $resultOrgQuery = $conn->query($orgQuery);

    if($debug) {
        if (!$resultOrgQuery) echo("\n Error description resultOrgQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    if ($resultOrgQuery){
        if($debug) {
            echo ("tattletale") ;
        }/*end debug*/

        $numberOfOrgRows = $resultOrgQuery->num_rows;

        $organizationsFound = ($numberOfOrgRows  > 0);
        $organizationsNotFound = ($numberOfOrgRows === 0);

        if ($organizationsNotFound) {

            echo <<<_END

          <div class="container-fluid bg-secondary pt-4 pb-3">
            <h2 class="display-4 text-light">Bummer!</h2>
            <h2>No publisher by the name of "$searchPubName" was found. <br/><br/></h2>
            <h4 class="text-light"> Which would you like to do? <br/><br/></h4>
            <form action='orgSearch.php' method='post'> 
              <input class="btn btn-light" type='submit' value='Try another Publisher Search'/>
              <input type='hidden' name='bookID' value='$bookID'/>
              <input type='hidden' name='oldOrgID' value='$oldOrgID'/> 
              $sendEditBook
              $sendReplacePublisher 
              $sendAddNewPublisher       
            </form><br/><br/><!-- end form -->
            
            <form action='addOrg.php' method='post'> 
              <input class="btn btn-light" type='submit' value='Add New Publisher Information'/>
              <input type='hidden' name='bookID' value='$bookID'/> 
              <input type='hidden' name='oldOrgID' value='$oldOrgID'/>
              $sendEditBook 
              $sendReplacePublisher 
              $sendAddNewPublisher   
            </form><br/><br/><!-- end form -->
            <form action='editBook.php' method='post'> 
              <input class="btn btn-light" type='submit' value='Back to Book Editing Options'/>
              <input type='hidden' name='bookID' value='$bookID'/>       
            </form><br/><br/><!-- end form -->
          </div> <!-- end container -->

_END;

        } /*END if organizations not found*/

        elseif ($organizationsFound) {

            echo <<<_END

          <div class="container-fluid bg-secondary pt-3 pb-3">
          <h5 class="text-light pb-2">"Choose a button to continue".</h5>
          

_END;

            for ($j = 0 ; $j < $numberOfOrgRows ; ++$j){
                $row = $resultOrgQuery->fetch_array(MYSQLI_NUM);

                $publisherID = ($row[0]);
                $publisherName = ($row[1]);
                $publisherLocation = ($row[2]);


/*TODO: figure out what the form action here should be. */
                /*check out whether this should be oldOrgID or newOrgID*/

                echo <<<_END

        
                <div class="card mb-3">
                  <div class="card-body bg-light">
                    <form action="addRole.php" method="post">
                      Publisher Name: <strong>$publisherName</strong><br>
                      Publisher Location: $publisherLocation <br><br>
                      <input class="btn"  type='submit' value='Choose this Publisher'/>
                      <input type='hidden' name='newOrgID' value='$publisherID'/> 
                      <input type='hidden' name='bookID' value='$bookID'/>
                      <input type='hidden' name='oldOrgID' value='$oldOrgID'/>
                      $sendAddNewPublisher 
                      $sendReplacePublisher 
                      $sendEditBook
                      $sendReplacePublisher
                    </form><br/>  <!-- end form -->
                  </div>  <!-- end card-body --> 
                </div>  <!-- end card -->
        

_END;

            } /*for loop ending*/

            echo <<<_END

      

        <div class="container-fluid bg-secondary text-light pb-3">     
          <h2 class="mb-3">None of these publishers match</h2><br/>
          
          <form action='orgSearch.php' method='post'> 
            <input class="btn btn-light" type='submit' value='Try another Publisher Search'/>
            <input type='hidden' name='bookID' value='$bookID'/> 
              <input type='hidden' name='oldOrgID' value='$oldOrgID'/> 
              $sendEditBook
              $sendReplacePublisher 
              $sendAddNewPublisher        
          </form><br/><!-- end form -->
          
          <form action="addOrg.php" method="post">
            <input class="btn btn-light"  type='submit' value='Add New Publisher Info'/> 
            <input type='hidden' name='bookID' value='$bookID'/>
            <input type='hidden' name='oldOrgID' value='$oldOrgID'/>
            $sendAddNewPublisher 
            $sendReplacePublisher 
            $sendEditBook
          </form><br/>  <!-- end form -->
          
          <form action="$formAction" method="post">
            <input class="btn btn-light"  type='submit' value='Back to Edit Book Options'/> 
            <input type='hidden' name='bookID' value='$bookID'/>
          </form> <!-- end form --><br/><br/>
        </div>  <!-- end container -->
        
_END;

        } /*end if organizationsFound*/

    } /*End ifresultOrgQuery*/

} /*End if (strlen('searchPubName']) > 0) */

/*This ends the portion of code that would be used when coming from orgSearch and there was a valid publisher name*/













/*This code is only used if you are coming from editBook having selected the edit/Replace/delete publisher button*/


if($editReplaceDeletePub == "true") {
    $publisherOrgQuery = <<<_END

      SELECT  o.ID, o.org_name, o.location
      FROM books AS b 
      JOIN B2R2O ON b.ID = B2R2O.book_ID
      JOIN organizations AS o ON o.ID= B2R2O.org_ID
      WHERE b.ID = $bookID;

_END;

    $resultPublisherOrgQuery = $conn->query($publisherOrgQuery);
    if ($debug) {
        echo 'publisherOrgQuery = ' . $publisherOrgQuery . '<br/><br/>';

        if (!$resultPublisherOrgQuery) echo("\n Error description publisherOrgQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    if ($resultPublisherOrgQuery) {
        $numPublisherOrgRows = $resultPublisherOrgQuery->num_rows;
        $pubOrgFound = ($numPublisherOrgRows > 0);
        $pubOrgNotFound = ($numPublisherOrgRows === 0);


        if ($pubOrgNotFound) {

            echo <<<_END
    
          <div class="container-fluid bg-secondary pt-4 pb-3">
            <h2 class="display-4 text-light">Bummer!</h2>
            <h2>No publisher for your book was found. <br/><br/></h2>
             <form action="addOrg.php" method="post">
            <input class="btn btn-light"  type='submit' value='Add New Publisher Info'/> 
            <input type='hidden' name='bookID' value='$bookID'/>
            <input type='hidden' name='oldOrgID' value='$oldOrgID'/>
            $sendAddNewPublisher 
            $sendReplacePublisher 
            $sendEditBook
          </form><br/>  <!-- end form -->
          
          <form action='orgSearch.php' method='post'> 
            <input class="btn btn-light" type='submit' value='Try another Publisher Search'/>
            <input type='hidden' name='bookID' value='$bookID'/> 
              <input type='hidden' name='oldOrgID' value='$oldOrgID'/> 
              $sendEditBook
              $sendReplacePublisher 
              $sendAddNewPublisher        
          </form><br/><!-- end form -->
          
          <form action="$formAction" method="post">
            <input class="btn btn-light"  type='submit' value='No Publisher: Continue'/> 
            <input type='hidden' name='bookID' value='$bookID'/>
          </form> <!-- end form --><br/><br/>
          </div> /*End container*/
            

_END;

        } /*END if pubOrgNotFound*/

        if ($pubOrgFound) {

            echo <<<_END

          <div class="container-fluid bg-secondary pt-3 pb-3">
          <h5 class="text-light pb-2">Click on "Edit", "Replace" or "Delete" to Continue.</h5>
          <p class="text-light">EDIT:  Makes changes to this publisher information everywhere in the catalog.</p>
          <p class="text-light">REPLACE:  Exchanges this publisher information for new publisher information for this book only.</p>
          <p class="text-light">DELETE:  Deletes this publisher information from this book only. This publisher will remain in the library to be used at other times. </p>
          </div>  <!-- end container --> 

_END;

            for ($j = 0; $j < $numPublisherOrgRows; ++$j) {
                $row = $resultPublisherOrgQuery->fetch_array(MYSQLI_NUM);
                /*var_dump ($row);*/
                $publisherOrgID = ($row[0]);
                $publisherOrgName = ($row[1]);
                $publisherOrgLocation = ($row[2]);


                /*TODO: figure out what the form action here should be. */
                /*check out whether this should be oldOrgID or newOrgID*/

                echo <<<_END

             <div class="container-fluid bg-secondary pt-3 pb-3">
                <div class="card mb-3">
                  <div class="card-body bg-light">                  
                      <h5>Publisher Name: $publisherOrgName</h5>
                      <h5>Publisher Location: $publisherOrgLocation </h5><br><br>
                      <div class="row">   
                        <form action="addOrg.php" method="post">
                          <div class="col">                      
                              <input class="btn btn-sm"  type='submit' value='EDIT'/>
                              <input type='hidden' name='bookID' value='$bookID'/>
                              <input type='hidden' name='oldOrgID' value='$publisherOrgID'/>
                              <input type='hidden' name='editPublisher' value='true'/>
                              $sendEditBook
                          </div>  <!-- end col -->
                        </form>  <!-- end form -->
                        <form action="orgSearch.php" method="post">
                            <div class="col">
                              <input class="btn btn-sm"  type='submit' value='REPLACE'/>
                              <input type='hidden' name='bookID' value='$bookID'/>
                              <input type='hidden' name='oldOrgID' value='$publisherOrgID'/>
                              <input type='hidden' name='replacePublisher' value='true'/>
                              $sendEditBook
                            </div>  <!-- end col -->
                        </form>  <!-- end form -->
                        <form action="delete.php" method="post">
                            <div class="col">
                              <input class="btn btn-sm {$deleteButton}"  type='submit' value='DELETE'/>
                              <input type='hidden' name='bookID' value='$bookID'/>
                              <input type='hidden' name='oldOrgID' value='$publisherOrgID'/>
                              <input type='hidden' name='deletePublisher' value='true'/> 
                              $sendEditBook
                            </div>  <!-- end col -->
                        </form>  <!-- end form -->
                      </div>  <!-- end row -->  
                  </div>  <!-- end card-body --> 
                </div>  <!-- end card -->
                
             </div>  <!-- end container -->   

_END;

            } /*for loop ending*/
        }/*End if ($pubOrgFound)*/
    }/*End if ($resultPublisherOrgQuery)*/

}/*END if($editReplaceDeletePub = "true")*/






include 'footer.html';
include 'endingBoilerplate.php';

?>







