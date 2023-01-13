 <?php
 include 'boilerplate.php';
 if($debug) {
     echo <<<_END

    <p>addRole.php  -7A</p>
 
_END;
 }/*end debug*/

 /*This page holds code for these scenarios:
 1- We are inserting new book or composition information into our database for the first time as we add a new book to the library.
 2- We are editing  the book, editor, or publisher information for an existing book.
    (check this out...when we edit a composition, I am pretty sure all the work with the junction tables happens in addComposition.php instead of here. )
 3- We are replacing the book, editor, or publisher information for an existing book.
     we are replacing the composer, arranger or lyricist for an existing composition
 4- We are adding the editor, or Publisher information to an existing book for the first time.
     check to see if we are doing all of this for the composition in addComposition.php*/



 /*include 'beginningNav.html';*/
 include 'beginningNav.php';

 /*Initializing Variables*/
 $bookID = "";
 $compositionID = "";
 $editBook = "";
 $editComposition = "";
 $newPeopleID = "";
 $oldPeopleID = "";

 /*AddNewPerson might not end up here at all*/
 $newOrgID = "";
 $oldOrgID = "";
 $addNewPublisher = "";
 $replacePublisher = "";
 $addNewEditor = "";
 $replaceEditor = "";
 $addNewComposer = "";
 $replaceComposer = "";
 $replacePeople = "";
 $addNewArranger = "";
 $replaceArranger = "";
 $addNewLyricist = "";
 $replaceLyricist = "";




 $roleID = "";
 $onSuccess = "";
 $editorRoleID = 4;
 $composerRoleID = 1;
 $arrangerRoleID = 2;
 $lyricistRoleID = 3;
 $publisherRoleID = 5;
 $editBookPassThrough = "";
 $pubNameValue = "";
 $pubLocValue = "";
 $addNewPeople = "";



 /*Giving Variable names to the values from the REQUEST array*/

 if(isset($_REQUEST['bookID']) && is_numeric($_REQUEST['bookID'])) {
     $bookID = $_REQUEST['bookID'];
 }

 if(isset($_REQUEST['compositionID']) && is_numeric($_REQUEST['compositionID'])) {
     $compositionID = $_REQUEST['compositionID'];
 }

 if(isset($_REQUEST['editBook'])) {
     $editBook = $_REQUEST['editBook'];
 }

 if(isset($_REQUEST['editComposition'])) {
     $editComposition = $_REQUEST['editComposition'];
 }

 if(isset($_REQUEST['replaceEditor'])) {
     $replaceEditor = $_REQUEST['replaceEditor'];
 }

 if(isset($_REQUEST['addNewEditor'])) {
     $addNewEditor = $_REQUEST['addNewEditor'];
 }

 if(isset($_REQUEST['replaceComposer'])) {
     $replaceComposer = $_REQUEST['replaceComposer'];
 }

 if(isset($_REQUEST['addNewComposer'])) {
     $addNewComposer = $_REQUEST['addNewComposer'];
 }

 if(isset($_REQUEST['replaceArranger'])) {
     $replaceArranger = $_REQUEST['replaceArranger'];
 }

 if(isset($_REQUEST['addNewArranger'])) {
     $addNewArranger = $_REQUEST['addNewArranger'];
 }

 if(isset($_REQUEST['replaceLyricist'])) {
     $replaceLyricist = $_REQUEST['replaceLyricist'];
 }

 if(isset($_REQUEST['addNewLyricist'])) {
     $addNewLyricist = $_REQUEST['addNewLyricist'];
 }


 if(isset($_REQUEST['newPeopleID']) && is_numeric($_REQUEST['newPeopleID'])) {
     $newPeopleID = $_REQUEST['newPeopleID'];
 }

 if(isset($_REQUEST['oldPeopleID']) && is_numeric($_REQUEST['oldPeopleID'])) {
     $oldPeopleID = $_REQUEST['oldPeopleID'];
 }


 if(isset($_REQUEST['replacePublisher'])) {
     $replacePublisher = $_REQUEST['replacePublisher'];
 }

 if(isset($_REQUEST['newOrgID']) && is_numeric($_REQUEST['newOrgID'])) {
     $newOrgID = $_REQUEST['newOrgID'];
 }

 if(isset($_REQUEST['oldOrgID']) && is_numeric($_REQUEST['oldOrgID'])) {
     $oldOrgID = $_REQUEST['oldOrgID'];
 }

 if(isset($_REQUEST['addNewPublisher'])) {
     $addNewPublisher = $_REQUEST['addNewPublisher'];
 }

 if(isset($_REQUEST['onSuccess'])) {
     $onSuccess = $_REQUEST['onSuccess'];
 }

/*create logic for specific situations*/

 if($replaceEditor == 'true') {
     $role = "Editor";
     $roleID = $editorRoleID; /*$roleID created here, wont' need to be washed   $editorRoleID created here, wont' need to be washed*/
     /*$replacePeople = $replaceEditor;*/  /*commenting this out because replaceEditor uses different code then the other three and will catch again if it is included in the replacePeople as it has been before. Will test for other conflicts*/
 }elseif($replaceComposer == 'true') {
     $role = "Composer";
     $roleID = $composerRoleID;
     $replacePeople = $replaceComposer;
 }elseif($replaceArranger == 'true') {
     $role = "Arranger";
     $roleID = $arrangerRoleID;
     $replacePeople = $replaceArranger;
 }elseif($replaceLyricist == 'true') {
     $role = "Lyricist";
     $roleID = $lyricistRoleID;
     $replacePeople = $replaceLyricist;
 }elseif($replacePublisher == 'true') {
     $role = "Publisher";
     $roleID = $publisherRoleID; /*created here. Won't need to be washed*/
     $replaceOrg = $replacePublisher; /*probably not necessary since there will only be one.*/
 }


 if($addNewEditor == 'true') {
     $role = "Editor";
     $roleID = $editorRoleID;
     /*$addNewPeople = $addNewEditor;*/  /*commenting this out because replaceEditor uses different code then the other three and will catch again if it is included in the replacePeople as it has been before. Will test for other conflicts*/
 }elseif($addNewComposer == 'true') {
     $role = "Composer";
     $roleID = $composerRoleID;
     $addNewPeople = $addNewComposer;
 }elseif($addNewArranger == 'true') {
     $role = "Arranger";
     $roleID = $arrangerRoleID;
     $addNewPeople = $addNewArranger;
 }elseif($addNewLyricist == 'true') {
     $role = "Lyricist";
     $roleID = $lyricistRoleID;
     $addNewPeople = $addNewLyricist;
 }elseif($addNewPublisher == 'true') {
     $role = "Publisher";
     $roleID = $publisherRoleID;
     $addNewOrg = $addNewPublisher; /*probably not necessary since there will only be one.*/
 }




 if($debug) {
    echo("bookID = " . $_REQUEST['bookID'] . '</br>');
}/*end debug*/


 /*Here we will wash variables and give them unique name to be used in the db*/
 $washPostVar = cleanup_post($compositionID);
 $compositionIDAltered = strip_before_insert($conn, $washPostVar);

 $washPostVar = cleanup_post($bookID);
 $bookIDAltered = strip_before_insert($conn, $washPostVar);

 $washPostVar = cleanup_post($newPeopleID);
 $newPeopleIDAltered = strip_before_insert($conn, $washPostVar);

 $washPostVar = cleanup_post($newOrgID);
 $newOrgIDAltered = strip_before_insert($conn, $washPostVar);

 $washPostVar = cleanup_post($oldPeopleID);
 $oldPeopleIDAltered = strip_before_insert($conn, $washPostVar);

 $washPostVar = cleanup_post($oldOrgID);
 $oldOrgIDAltered = strip_before_insert($conn, $washPostVar);



 /*Adding a New Editor
 Here we are inserting a new row into the B2R2P or B2R2O table to connect our person (newPeopleID) or organization (newOrgID) with our book as an Editor or Publisher.*/


     if($addNewEditor=='true'){
         $B2R2PInsertQuery = <<<_END
            INSERT INTO b2r2p (book_ID, role_ID, people_ID)
            VALUES('$bookID', '$editorRoleID', '$newPeopleIDAltered');
            
_END;

         /*Send the query to the database*/
         $B2R2PInsertQueryResult = $conn->query($B2R2PInsertQuery);
         if ($debug) {
             echo("\nB2R2PInsertQuery= " . $B2R2PInsertQuery . "\n<br/>");
             if (!$B2R2PInsertQueryResult) echo("\n Error description B2R2PInsertQuery: " . mysqli_error($conn) . "\n<br/>");
         }/*end debug*/

         failureToExecute ($B2R2PInsertQueryResult, 'I613', 'Insert ' );



         /* if ($debug) {
              echo 'debug only to make visible';
              exit();
          } else {*/

         header('Location: editBook.php?bookID=' . $bookID . '&editBook=true');
         /*}*/
         exit();

     }elseif($addNewPeople == 'true') {
         $C2R2PInsertQuery = <<<_END
            INSERT INTO c2r2p (composition_ID, role_ID, people_ID)
            VALUES('$compositionIDAltered', '$roleID', '$newPeopleIDAltered');
            
_END;

         /*Send the query to the database*/
         $C2R2PInsertQueryResult = $conn->query($C2R2PInsertQuery);
         if ($debug) {
             echo("\nC2R2PInsertQuery= " . $C2R2PInsertQuery . "\n<br/>");
             if (!$C2R2PInsertQueryResult) echo("\n Error description C2R2PInsertQuery: " . mysqli_error($conn) . "\n<br/>");
         }/*end debug*/

         failureToExecute ($C2R2PInsertQueryResult, 'I614', 'Insert ' );



         header('Location: editComposition.php?bookID=' . $bookID . '&editComposition=true&compositionID=' . $compositionID);

         exit();
     }



  /*Adding a New Publisher
  publisher is the only organization for the book*/
if($addNewPublisher=='true'){
     $B2R2OInsertQuery = <<<_END
        INSERT INTO b2r2o (book_ID, role_ID, org_ID)
        VALUES('$bookID', '$publisherRoleID', '$newOrgIDAltered');
        
_END;

     /*Send the query to the database*/
     $B2R2OInsertQueryResult = $conn->query($B2R2OInsertQuery);
     if ($debug) {
         echo("\nB2R2OInsertQuery= " . $B2R2OInsertQuery . "\n<br/>");
         if (!$B2R2OInsertQueryResult) echo("\n Error description B2R2OInsertQuery: " . mysqli_error($conn) . "\n<br/>");
     }/*end debug*/

    failureToExecute ($B2R2OInsertQueryResult, 'I615', 'Insert ' );

     /* if ($debug) {
          echo 'debug only to make visible';
          exit();
      } else {*/

     header('Location: editBook.php?bookID=' . $bookID . '&editBook=true');
     /*}*/
     exit();

 }/*end if  addNewPublisher  */




/*REPLACE EDITOR/COMPOSER/ARRANGER/LYRICIST*/
 /*Once it is determined what new person or organization will replace the old person or organization, we update the B2R2P or B2R2O table with the new people or organization info for the new editor or publisher*/


 /*Editor is the only person for the book*/
     if($replaceEditor == 'true' && $newPeopleIDAltered !== 0) {

     $updateB2R2P = <<<_END
         UPDATE b2r2p
         SET book_ID = '$bookID', role_ID = '$roleID', people_ID = '$newPeopleIDAltered'
         WHERE b2r2p.book_ID = '$bookID'
             AND b2r2p.role_ID = '$roleID'
             AND b2r2p.people_ID = '$oldPeopleIDAltered';
             
_END;

     $updateB2R2PResult = $conn->query($updateB2R2P);

     if ($debug) {
         echo("\nupdateB2R2P= " . $updateB2R2P . "\n<br/>");
         if (!$updateB2R2PResult) echo("\n Error description updateB2R2P: " . mysqli_error($conn) . "\n<br/>");

     } /*end debug*/

         failureToExecute ($updateB2R2PResult, 'U704', 'Update ' );

     header('Location: editBook.php?bookID=' . $bookID . '&peopleID=' . $newPeopleID . '&editBook=true&replaceEditor=true&searchPeopleLastName_value=' . $searchPeopleLastName_value);
     exit();


    } elseif($replacePeople == 'true' && $newPeopleIDAltered !== 0) {

         $updateC2R2P = <<<_END
         UPDATE c2r2p
         SET composition_ID = '$compositionIDAltered', role_ID = '$roleID', people_ID = '$newPeopleIDAltered'
         WHERE c2r2p.composition_ID = '$compositionIDAltered'
             AND c2r2p.role_ID = '$roleID'
             AND c2r2p.people_ID = '$oldPeopleIDAltered';
             
_END;

         $updateC2R2PResult = $conn->query($updateC2R2P);

         if ($debug) {
             echo("\n updateC2R2P= " . $updateC2R2P . "\n<br/>");
             if (!$updateC2R2PResult) echo("\n Error description updateC2R2P: " . mysqli_error($conn) . "\n<br/>");

         } /*end debug*/

         failureToExecute ($updateC2R2PResult, 'U704', 'Update ' );

         /*todo: Not certain we need all these variables to head to the editComposition page. Will look into*/
         header('Location: editComposition.php?bookID=' . $bookID . '&peopleID=' . $newPeopleID . '&editComposition=true&replaceComposer=' . $replaceComposer . '&replaceArranger=' . $replaceArranger . '&replaceLyricist=' . $replaceLyricist . '&compositionID=' . $compositionID . '&searchPeopleLastName_value=' . $searchPeopleLastName_value);
         exit();


     }elseif($replacePublisher == 'true') {
 /*REPLACE PUBLISHER*/

     $updatePublisher = <<<_END
     UPDATE b2r2o
     SET book_ID = '$bookID', role_ID = '$roleID', org_ID = '$newOrgIDAltered'
     WHERE b2r2o.book_ID = '$bookID'
         AND b2r2o.role_ID = '$roleID'
         AND b2r2o.org_ID = '$oldOrgIDAltered';
         
_END;

     $updatePublisherResult = $conn->query($updatePublisher);

     if ($debug) {
         echo("\nupdatePublisher= " . $updatePublisher . "\n<br/>");
         if (!$updatePublisherResult) echo("\n Error description updatePublisher: " . mysqli_error($conn) . "\n<br/>");

     } /*end debug*/
         failureToExecute ($updatePublisherResult, 'U705', 'Update ' );



        header('Location: editBook.php?bookID=' . $bookID . '&orgID=' . $newOrgID . '&editBook=true&replacePublisher=true&searchPubName_value=' . $searchPubName_value);
     exit();

 }/*end if(isset($replacePublisher) && isset($newOrgID*/




    if($onSuccess !== "") { //we came from editEditor.php and passed this clue through
        /*all the update code here*/

        /*roleID is hard coded at the top editorID/publisherID
        /*We have the bookID that came through the post and is now being called $bookID*/
        /*We will also need the people ID for the editor, or the orgID for the publisher. That is what we will do here.*/


        /*Getting the people ID*/
        if ($debug) {
            echo 'bookID =' . $bookID . '</br>';
            echo 'editorRoleID =' . $editorRoleID . '</br>';
            echo 'publisherRoleID =' . $publisherRoleID . '</br>';
        }/*end debug*/


    } /*End if($onSuccess !== "")*/












include 'footer.php';
include 'endingBoilerplate.php';

?>
  

