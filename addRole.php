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



 /*Giving Variable names to the values from the REQUEST array*/

 if(isset($_REQUEST['bookID'])) {
     $bookID = $_REQUEST['bookID'];
 }

 if(isset($_REQUEST['compositionID'])) {
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


 if(isset($_REQUEST['newPeopleID'])) {
     $newPeopleID = $_REQUEST['newPeopleID'];
 }

 if(isset($_REQUEST['oldPeopleID'])) {
     $oldPeopleID = $_REQUEST['oldPeopleID'];
 }


 if(isset($_REQUEST['replacePublisher'])) {
     $replacePublisher = $_REQUEST['replacePublisher'];
 }

 if(isset($_REQUEST['newOrgID'])) {
     $newOrgID = $_REQUEST['newOrgID'];
 }

 if(isset($_REQUEST['oldOrgID'])) {
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
     $roleID = $editorRoleID;
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
     $roleID = $publisherRoleID;
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
 $washPostVar = cleanup_post($_POST['pubLoc']);
 $pubLocAltered = strip_before_insert($conn, $washPostVar);



 /*Adding a New Editor
 Here we are inserting a new row into the B2R2P or B2R2O table to connect our person (newPeopleID) or organization (newOrgID) with our book as an Editor or Publisher.*/


     if($addNewEditor=='true'){
         $B2R2PInsertQuery = <<<_END
            INSERT INTO B2R2P (book_ID, role_ID, people_ID)
            VALUES('$bookID', '$editorRoleID', '$newPeopleID');
            
_END;

         /*Send the query to the database*/
         $B2R2PInsertQueryResult = $conn->query($B2R2PInsertQuery);
         if ($debug) {
             echo("\nB2R2PInsertQuery= " . $B2R2PInsertQuery . "\n<br/>");
             if (!$B2R2PInsertQueryResult) echo("\n Error description B2R2PInsertQuery: " . mysqli_error($conn) . "\n<br/>");
         }/*end debug*/


         /* if ($debug) {
              echo 'debug only to make visible';
              exit();
          } else {*/

         header('Location: editBook.php?bookID=' . $bookID . '&editBook=true');
         /*}*/
         exit();

     }elseif($addNewPeople == 'true') {
         $C2R2PInsertQuery = <<<_END
            INSERT INTO C2R2P (composition_ID, role_ID, people_ID)
            VALUES('$compositionID', '$roleID', '$newPeopleID');
            
_END;

         /*Send the query to the database*/
         $C2R2PInsertQueryResult = $conn->query($C2R2PInsertQuery);
         if ($debug) {
             echo("\nC2R2PInsertQuery= " . $C2R2PInsertQuery . "\n<br/>");
             if (!$C2R2PInsertQueryResult) echo("\n Error description C2R2PInsertQuery: " . mysqli_error($conn) . "\n<br/>");
         }/*end debug*/




         header('Location: editComposition.php?bookID=' . $bookID . '&editComposition=true&compositionID=' . $compositionID);

         exit();
     }



  /*Adding a New Publisher
  publisher is the only organization for the book*/
if($addNewPublisher=='true'){
     $B2R2OInsertQuery = <<<_END
        INSERT INTO B2R2O (book_ID, role_ID, org_ID)
        VALUES('$bookID', '$publisherRoleID', '$newOrgID');
        
_END;

     /*Send the query to the database*/
     $B2R2OInsertQueryResult = $conn->query($B2R2OInsertQuery);
     if ($debug) {
         echo("\nB2R2OInsertQuery= " . $B2R2OInsertQuery . "\n<br/>");
         if (!$B2R2OInsertQueryResult) echo("\n Error description B2R2OInsertQuery: " . mysqli_error($conn) . "\n<br/>");
     }/*end debug*/


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
     if($replaceEditor == 'true' && $newPeopleID !== 0) {

     $updateB2R2P = <<<_END
         UPDATE B2R2P
         SET book_ID = '$bookID', role_ID = '$roleID', people_ID = '$newPeopleID'
         WHERE B2R2P.book_ID = '$bookID'
             AND B2R2P.role_ID = '$roleID'
             AND B2R2P.people_ID = '$oldPeopleID';
             
_END;

     $updateB2R2PResult = $conn->query($updateB2R2P);

     if ($debug) {
         echo("\nupdateB2R2P= " . $updateB2R2P . "\n<br/>");
         if (!$updateB2R2PResult) echo("\n Error description updateB2R2P: " . mysqli_error($conn) . "\n<br/>");

     } /*end debug*/

     header('Location: editBook.php?bookID=' . $bookID . '&peopleID=' . $newPeopleID . '&editBook=true&replaceEditor=true&searchPeopleLastName_value=' . $searchPeopleLastName_value);
     exit();


    } elseif($replacePeople == 'true' && $newPeopleID !== 0) {

         $updateC2R2P = <<<_END
         UPDATE C2R2P
         SET composition_ID = '$compositionID', role_ID = '$roleID', people_ID = '$newPeopleID'
         WHERE C2R2P.composition_ID = '$compositionID'
             AND C2R2P.role_ID = '$roleID'
             AND C2R2P.people_ID = '$oldPeopleID';
             
_END;

         $updateC2R2PResult = $conn->query($updateC2R2P);

         if ($debug) {
             echo("\nupdateC2R2P= " . $updateC2R2P . "\n<br/>");
             if (!$updateC2R2PResult) echo("\n Error description updateC2R2P: " . mysqli_error($conn) . "\n<br/>");

         } /*end debug*/
/*todo: Not certain we need all these variables to head to the editComposition page. Will look into*/
         header('Location: editComposition.php?bookID=' . $bookID . '&peopleID=' . $newPeopleID . '&editComposition=true&replaceComposer=' . $replaceComposer . '&replaceArranger=' . $replaceArranger . '&replaceLyricist=' . $replaceLyricist . '&compositionID=' . $compositionID . '&searchPeopleLastName_value=' . $searchPeopleLastName_value);
         exit();


     }elseif($replacePublisher == 'true') {
 /*REPLACE PUBLISHER*/

     $updatePublisher = <<<_END
     UPDATE B2R2O
     SET book_ID = '$bookID', role_ID = '$roleID', org_ID = '$newOrgID'
     WHERE B2R2O.book_ID = '$bookID'
         AND B2R2O.role_ID = '$roleID'
         AND B2R2O.org_ID = '$oldOrgID';
         
_END;

     $updatePublisherResult = $conn->query($updatePublisher);

     if ($debug) {
         echo("\nupdatePublisher= " . $updatePublisher . "\n<br/>");
         if (!$updatePublisherResult) echo("\n Error description updatePublisher: " . mysqli_error($conn) . "\n<br/>");

     } /*end debug*/

     header('Location: editBook.php?bookID=' . $bookID . '&orgID=' . $newOrgID . '&editBook=true&replacePublisher=true&searchPubName_value=' . $searchPubName_value);
     exit();

 }/*end if(isset($replacePublisher) && isset($newOrgID*/




    if($onSuccess !== "") { //we came from editEditor.php and passed this clue through
         /*all the update code here*/

         /*roleID is hard coded at the top editorID/publisherID
         /*We have the bookID that came through the post and is now being called $bookID*/
         /*We will also need the people ID for the editor, or the orgID for the publisher. That is what we will do here.*/


         /*Getting the people ID*/
        if($debug) {
            echo 'bookID =' . $bookID . '</br>';
            echo 'editorRoleID =' . $editorRoleID . '</br>';
            echo 'publisherRoleID =' . $publisherRoleID . '</br>';
        }/*end debug*/


//        /*TODO need an if here*/
//        $peopleIDQuery = <<<_END
//            SELECT B2R2P.people_ID
//            FROM B2R2P
//            WHERE B2R2P.book_ID = $bookID
//             AND B2R2P.role_ID = $editorRoleID
//_END;
//
//
//        if ($debug) {
//            echo("\n peopleIDQuery = " . $peopleIDQuery . "\n<br/><br/>");
//        }/*end debug*/
//
//        /*Send the query to the database*/
//        $peopleIDQueryResult = $conn->query($peopleIDQuery);
//
//        /*in case result fails*/
//
//        if ($debug) {
//            if (!$peopleIDQueryResult) echo("\n Error description peopleIDQuery: " . mysqli_error($conn) . "\n<br/>");
//        }/*end debug*/
//
//        if ($peopleIDQueryResult) {
//            $numberOfPeopleRows = $peopleIDQueryResult->num_rows;  /*gets the number of rows in a result*/
//
//            /*build forloop*/
//            for ($j = 0; $j < $numberOfPeopleRows; ++$j) {
//                $row = $peopleIDQueryResult->fetch_array(MYSQLI_NUM); /*Fetch a result row as an numeric array*/
//
//                /*create variables to hold each index (or column) from the given result row array*/
//
//                /*This variable can now be used in other code*/
//                $peopleID = ($row[0]);
//
//
//            } /*for loop ending*/
//
//        } /*End if peopleIDQueryResult */
//
//        echo 'peopleID =' . $peopleID . '</br>';
//
///*Start Here*/        /*TODO need an if here*/
//        $orgIDQuery = <<<_END
//            SELECT B2R2O.org_ID
//            FROM B2R2O
//            WHERE B2R2O.book_ID = $bookID
//             AND B2R2O.role_ID = $publisherRoleID
//_END;
//
//
//        if ($debug) {
//            echo("\n orgIDQuery = " . $orgIDQuery . "\n<br/><br/>");
//        }/*end debug*/
//
//        /*Send the query to the database*/
//        $orgIDQueryResult = $conn->query($orgIDQuery);
//
//        /*in case result fails*/
//
//        if ($debug) {
//            if (!$orgIDQueryResult) echo("\n Error description orgIDQuery: " . mysqli_error($conn) . "\n<br/>");
//        }/*end debug*/
//
//        if ($orgIDQueryResult) {
//            $numberOfOrgRows = $orgIDQueryResult->num_rows;  /*gets the number of rows in a result*/
//
//            /*build forloop*/
//            for ($j = 0; $j < $numberOfOrgRows; ++$j) {
//                $row = $peopleIDQueryResult->fetch_array(MYSQLI_NUM); /*Fetch a result row as an numeric array*/
//
//                /*create variables to hold each index (or column) from the given result row array*/
//
//                /*This variable can now be used in other code*/
//                $orgID = ($row[0]);
//
//
//            } /*for loop ending*/
//
//        } /*End if peopleIDQueryResult */
//
//        echo 'orgID =' . $orgID . '</br>';
//
//
//











     /*TODO we need an if*/

         /*Here we actually update the Editor or Publisher information*/

//         $updateEditor = "
//                UPDATE people AS p
//                SET  	firstname = '$peopleFirstName',
//                middlename = '$peopleMiddleName',
//                lastname = '$peopleLastName',
//                suffix = '$peopleSuffix'
//
//                WHERE p.ID = '$peopleID' ";
//
//
//
//         $updateEditorResult = $conn->query($updateEditor);
//
//         if ($debug) {
//             echo("\nupdateEditor= " . $updateEditor . "\n<br/>");
//             if (!$updateEditorResult) echo("\n Error description updateEditor: " . mysqli_error($conn) . "\n<br/>");
//         }/*end debug*/
//        if ($debug) {
//            echo 'debug only to make visible';
//            exit();
//        } else {
//
//            header('Location: peopleSearch.php?bookID=' . $bookID);
//        }/*end  if not empty onSuccess   else*/
//        exit();
//
//
//
//
// }else {
//
//
//        /*Build insert query strings*/
//        /*insert the new editor info into the people table*/
//
//        $peopleInsertQuery = "INSERT INTO people (firstname, middlename, lastname, suffix)
//        VALUES('$peopleFirstName', '$peopleMiddleName', '$peopleLastName', '$peopleSuffix')";
//
//
//        /*Send the query to the database*/
//        $peopleInsertQueryResult = $conn->query($peopleInsertQuery);
//        if ($debug) {
//            echo("\npeopleInsertQuery= " . $peopleInsertQuery . "\n<br/>");
//            if (!$peopleInsertQueryResult) echo("\n Error description peopleInsertQuery: " . mysqli_error($conn) . "\n<br/>");
//        }/*end debug*/
//
//        /*Getting people ID for the book just inserted into database*/
//        $newPeopleID = $conn->insert_id;
//
//        if ($debug) {
//            echo("newPeopleID = " . $newPeopleID . "<br/>");
//        }/*end debug*/
//
//
//        /*insert into B2R2P to connect this person with this book as an editor*/
//        $B2R2PInsertQuery = "INSERT INTO B2R2P (book_ID, role_ID, people_ID)
//        VALUES('$bookID', '$editorRoleID', '$newPeopleID')";
//
//
//        /*Send the query to the database*/
//        $B2R2PInsertQueryResult = $conn->query($B2R2PInsertQuery);
//        if ($debug) {
//            echo("\nB2R2PInsertQuery= " . $B2R2PInsertQuery . "\n<br/>");
//            if (!$B2R2PInsertQueryResult) echo("\n Error description B2R2PInsertQuery: " . mysqli_error($conn) . "\n<br/>");
//        }/*end debug*/
//
//
//        if ($debug) {
//            echo 'debug only to make visible';
//            exit();
//        } else {
//
//
//            header('Location: peopleSearch.php?bookID=' . $bookID);
//        }/*end  if not empty onSuccess   else*/
//        exit();
//
//    }
//
//
//if(!empty($onSuccess) || isset($editBook)) {
//    $onSuccess = "<input type='hidden' name='onSuccess' value= 'editBook' />";
}
//
//
///*TODO*/
// /*I don't think we need this form anymore. addRole is not a page a user will ever see.  I got rid of it*/
//
//
//
//
///*destroy session variables*/
///*ask Ken about parent session variables   $_SESSION['parentKey']['key'] */
//unset($_SESSION['addRole_validationFailed']);
//unset($_SESSION['addRole_editorFirstName_value']);
//unset($_SESSION['addRole_editorMiddleName_value']);
//unset($_SESSION['addRole_editorLastName_value']);
//unset($_SESSION['addRole_editorSuffix_value']);
//unset($_SESSION['editorLastNameErr']);
//unset($_SESSION['bookID']);
//


include 'footer.html';
include 'endingBoilerplate.php';

?>
  

