<?php

include 'boilerplate.php';

if($debug) {
    echo <<<_END
  
  <p>peopleOptions.php-7</p>

_END;

}/*end debug*/


include 'beginningNav.php';

/*We arrive at this page if
-we are adding a new book to the library, and have submitted a editor name to be added to the new book
-we are editing a current book and want to add or replace the editor for the current book*/

/*This page will
-search for the Editor the user asked for in the peopleSearch page
-display any people found that match the search
-provide choices to
    -choose an existing person
    -try another search
    -add new people info to the database*/

/*We also arrive at this page if
-we are adding a new composition to the a book in the library, and have submitted a person(say a composer) name to be added to the new composition.
-we are editing a current composition and want to add or replace a person (say a composer or lyricist or arranger) for the current composition*/

/*This page will
-search for the person the user asked for in the peopleSearch page
-display any people found that match the search
-provide choices to
    -choose an existing person
    -try another search
    -add new people info to the database*/



/*Initialize Variables from previous page(s)*/

$searchPeopleLastName = "";
$bookID = "";
$bookTitle = "";
$compositionID = "";
$oldPeopleID = "";
$newPeopleID = "";
$editBook = "";
$editComposition = "";
$compName = "";
$bookTitle = "";
$editReplaceDeleteEditor = "" ;
$editReplaceDeleteComposer = "" ;
$editReplaceDeleteArranger = "" ;
$editReplaceDeleteLyricist = "" ;
$findComposer = "";


$replaceEditor = "";
$replaceComposer = "";
$replaceArranger = "";
$replaceLyricist = "";

$addNewEditor = "";
$addNewComposer = "";
$addNewArranger = "";
$addNewLyricist = "";

/*Initialize variables for form and text use*/

$role = "";
$Title = "";
$sendEditBook = "";
$sendEditComposition = "";
$sendEdit = "";
$sendAddNew = "";
$sendReplace = "";
$sendDelete = "";
$formAction = "";
$deleteButton = "";





/*Give local variable names to the REQUEST values*/


if(isset($_REQUEST['searchPeopleLastName'])) {
    $searchPeopleLastName = $_REQUEST['searchPeopleLastName'];
}

if(isset($_REQUEST['bookID']) && is_numeric($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if(isset($_REQUEST['bookTitle'])) {
    $bookTitle = $_REQUEST['bookTitle'];
}

if(isset($_REQUEST['compName'])) {
    $compName = $_REQUEST['compName'];
}

if(isset($_REQUEST['compositionID'])) {
    $compositionID = $_REQUEST['compositionID'];
}

if(isset($_REQUEST['oldPeopleID']) && is_numeric($_REQUEST['oldPeopleID'])) {
    $oldPeopleID = $_REQUEST['oldPeopleID'];
}

echo "oldPeopleID =" . $oldPeopleID . "</br>";

if(isset($_REQUEST['editBook'])) {
    $editBook = $_REQUEST['editBook'];
}

if(isset($_REQUEST['editComposition'])) {
    $editComposition = $_REQUEST['editComposition'];
}



if(isset($_REQUEST['editReplaceDeleteEditor'])) {
    $editReplaceDeleteEditor = $_REQUEST['editReplaceDeleteEditor'];
}

if(isset($_REQUEST['editReplaceDeleteComposer'])) {
    $editReplaceDeleteComposer = $_REQUEST['editReplaceDeleteComposer'];
}

if(isset($_REQUEST['editReplaceDeleteArranger'])) {
    $editReplaceDeleteArranger = $_REQUEST['editReplaceDeleteArranger'];
}

if(isset($_REQUEST['editReplaceDeleteLyricist'])) {
    $editReplaceDeleteLyricist = $_REQUEST['editReplaceDeleteLyricist'];
}

/*These are needed when returning from peopleSearch.php*/

if(isset($_REQUEST['replaceEditor'])) {
    $replaceEditor = $_REQUEST['replaceEditor'];
}

if(isset($_REQUEST['replaceComposer'])) {
    $replaceComposer = $_REQUEST['replaceComposer'];
}

if(isset($_REQUEST['replaceArranger'])) {
    $replaceArranger = $_REQUEST['replaceArranger'];
}

if(isset($_REQUEST['replaceLyricist'])) {
    $replaceLyricist = $_REQUEST['replaceLyricist'];
}


if(isset($_REQUEST['addNewEditor'])) {
    $addNewEditor = $_REQUEST['addNewEditor'];
}

if(isset($_REQUEST['addNewComposer'])) {
    $addNewComposer = $_REQUEST['addNewComposer'];
}

if(isset($_REQUEST['addNewArranger'])) {
    $addNewArranger = $_REQUEST['addNewArranger'];
}

if(isset($_REQUEST['addNewLyricist'])) {
    $addNewLyricist = $_REQUEST['addNewLyricist'];
}

if(isset($_REQUEST['findComposer'])) {
    $findComposer = $_REQUEST['findComposer'];
}


/*Create logic to use variables for many situations*/


if($editBook == 'true') {
    $sendEditBook = "<input type='hidden' name='editBook' value='$editBook' /> ";
    $formAction = 'editBook.php';
    $formActionChoose = 'editBook.php'; /*might need to be addRole here*/
    $Title = $bookTitle;
    $page = 'Book Editing Options';
}elseif($editComposition == 'true') {
    $sendEditComposition = "<input type='hidden' name='editComposition' value='$editComposition' /> ";
    $formAction = 'editComposition.php';
    $formActionChoose = 'addRole.php';
    $Title = $compName;
    $page = 'Composition Editing Options';
}elseif($findComposer =='true') {
    $formAction = "introPage.php";
    $formActionChoose = "displayComposer.php";
}else{
    $formAction = 'displayBook.php';
}

if($editReplaceDeleteEditor == 'true') {
    $role = 'Editor';
    $sendEdit = "<input type='hidden' name='editEditor' value='true' /> ";
    $sendReplace = "<input type='hidden' name='replaceEditor' value='true' /> ";
    $sendDelete = "<input type='hidden' name='deleteEditor' value='true' /> ";
    /*think this through. We need this for sendEdit and sendDelete too? Yes for what goes along with the button*/
    $editReplaceDeletePerson = $editReplaceDeleteEditor;
    $deleteButton = 'deleteEditor_button';
}elseif($editReplaceDeleteComposer == 'true') {
    $role = "Composer";
    $sendEdit = "<input type='hidden' name='editComposer' value='true' /> ";
    $sendReplace = "<input type='hidden' name='replaceComposer' value='true' /> ";
    $sendDelete = "<input type='hidden' name='deleteComposer' value='true' /> ";
    $editReplaceDeletePerson = $editReplaceDeleteComposer;
    $deleteButton = 'deleteComposer_button';
}elseif($editReplaceDeleteArranger == 'true') {
    $role = "Arranger";
    $sendEdit = "<input type='hidden' name='editArranger' value='true' /> ";
    $sendReplace = "<input type='hidden' name='replaceArranger' value='true' /> ";
    $sendDelete = "<input type='hidden' name='deleteArranger' value='true' /> ";
    $editReplaceDeletePerson = $editReplaceDeleteArranger;
    $deleteButton = 'deleteArranger_button';
}elseif($editReplaceDeleteLyricist == 'true') {
    $role = "Lyricist";
    $sendEdit = "<input type='hidden' name='editLyricist' value='true' /> ";
    $sendReplace = "<input type='hidden' name='replaceLyricist' value='true' /> ";
    $sendDelete = "<input type='hidden' name='deleteLyricist' value='true' /> ";
    $editReplaceDeletePerson = $editReplaceDeleteLyricist;
    $deleteButton = 'deleteArranger_button';
}

/*/*These are needed when returning from peopleSearch.php*/

if($replaceEditor == 'true') {
    $role = 'Editor';
    $sendReplace = "<input type='hidden' name='replaceEditor' value='true' /> ";
    $replacePeople = $replaceEditor;
}elseif($replaceComposer == 'true') {
    $role = 'Composer';
    $sendReplace = "<input type='hidden' name='replaceComposer' value='true' /> ";
    $replacePeople = $replaceComposer;
}elseif($replaceArranger == 'true') {
    $role = 'Arranger';
    $sendReplace = "<input type='hidden' name='replaceArranger' value='true' /> ";
    $replacePeople = $replaceArranger;
}elseif($replaceLyricist == 'true') {
    $role = 'Lyricist';
    $sendReplace = "<input type='hidden' name='replaceLyricist' value='true' /> ";
    $replacePeople = $replaceLyricist;
}


if($addNewEditor == 'true') {
    $role = 'Editor';
    $sendAddNew = "<input type='hidden' name='addNewEditor' value='true' /> ";
    $addNewPeople = $addNewEditor;
}elseif($addNewComposer == 'true') {
    $role = 'Composer';
    $sendAddNew = "<input type='hidden' name='addNewComposer' value='true' /> ";
    $addNewPeople = $addNewComposer;
}elseif($addNewArranger == 'true') {
    $role = 'Arranger';
    $sendAddNew = "<input type='hidden' name='addNewArranger' value='true' /> ";
    $addNewPeople = $addNewArranger;
}elseif($addNewLyricist == 'true') {
    $role = 'Lyricist';
    $sendAddNew = "<input type='hidden' name='addNewLyricist' value='true' /> ";
    $addNewPeople = $addNewLyricist;
}elseif($findComposer == 'true') {
    $role = 'Composer';
    $sendFindComposer = "<input type='hidden' name='findComposer' value='true' /> ";
    $page = "Intro Page";
}



/*In this section we will search the data base for the Person the user is looking for. They will have submitted the  name of the Person they want in the text box in peopleSearch.php. Then, the possible People are displayed. Then, should none of those People be the one the user wants, there is an option to add new People information to the database. User is sent to addPeople.php
There is also the possibility that there is no Editor, or Composer etc. Since Editor is not the final step in collecting book information, the "No Editor, continue" button takes the user either back to   editBook.php or searchPublisher to let the user decide what they want to do next*/

/*Here we wash this information before we send it in a db query*/
$washPostVar = cleanup_post($searchPeopleLastName);
$searchPeopleLastNameAltered = strip_before_insert($conn, $washPostVar);

$washPostVar = cleanup_post($bookID);
$bookIDAltered = strip_before_insert($conn, $washPostVar);

$washPostVar = cleanup_post($compositionID);
$compositionIDAltered = strip_before_insert($conn, $washPostVar);




if (strlen($searchPeopleLastNameAltered) > 0) {

    /*searches the database for the person the user is looking for*/
      $peopleQuery = <<<_END
    
        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM people As p
        
        WHERE p.lastname LIKE '%$searchPeopleLastNameAltered%';

_END;

        if($debug) {
            echo 'peopleQuery = ' . $peopleQuery . '<br/><br/>';
        }/*end debug*/

      /*send the query*/
      $resultPeopleQuery = $conn->query($peopleQuery);

        if($debug) {
            if (!$resultPeopleQuery) echo("\nError description PeopleQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/

      if ($resultPeopleQuery){
        $numberOfPeopleRows = $resultPeopleQuery->num_rows;
        $peopleFound = ($numberOfPeopleRows > 0);
        $peopleNotFound = ($numberOfPeopleRows === 0);

        if ($peopleNotFound) {

            echo <<<_END

      <div class="container-fluid bg-secondary pt-4 pb-3">
      <h2 class="display-4 text-light">Bummer!</h2>
        <h2>No Person by the name of "$searchPeopleLastName" was found. <br/><br/></h2>
        <h4 class="text-light"> Which would you like to do? <br/><br/></h4>
        <form action="peopleSearch.php" method='post'> 
          <input class="btn btn-light" type="submit" value="Try another $role Search"/>
          <input type="hidden" name="bookID" value="$bookID"/>
          <input type="hidden" name="compositionID" value="$compositionID"/>
          $sendEditBook 
          $sendEditComposition
          $sendReplace 
          $sendAddNew 
          $sendFindComposer        
        </form><br/><br/><!-- end form -->
        
        <form action="addPeople.php" method="post"> 
          <input class="btn btn-light" type="submit" value="Add New $role Information"/>
          <input type="hidden" name="bookID" value="$bookID"/> 
          <input type="hidden" name="compositionID" value="$compositionID"/>
          <input type="hidden" name="oldPeopleID" value='$oldPeopleID'/>
          $sendEditBook 
          $sendEditComposition
          $sendReplace 
          $sendAddNew 
          $sendFindComposer  
        </form><br/><br/><!-- end form -->
        <form action="$formAction" method="post"> 
          <input class="btn btn-light" type="submit" value="Back to $page "/>
          <input type="hidden" name="bookID" value="$bookID"/>
          <input type="hidden" name="compositionID" value="$compositionID"/>       
        </form><br/><br/><!-- end form -->
      </div> <!-- end container -->

_END;

        } /*END if editor not found*/

        if ($peopleFound) {

            echo <<<_END
              
            <div class="container-fluid bg-secondary pt-3 pb-3">
            <h5 class="text-light pb-2"> Click on a button to continue.</h5>

_END;

            for ($j = 0 ; $j < $numberOfPeopleRows ; $j++){
              $row = $resultPeopleQuery->fetch_array(MYSQLI_NUM);

              $peopleID = $row[0];
              $peopleFirst = $row[1];
              $peopleMiddle = $row[2];
              $peopleLast = $row[3];
              $peopleSuffix = $row[4];

                /*TODO: figure out what the form action here should be. */
                /*TODO:  check out whether this should be oldPeopleID or newPeopleID and don't we need both?*/
/*case one: we are editing an existing book or composition.
/*we are adding a new book or composition and are gathering the people information to add to the book or composition.
/* In either case, we have found our newPerson and need to connect this new person with our book or composition. That means we need to be sent to the addRole.php page in both cases. Hence the hard coded form action*/

                echo <<<_END
        
           
                <div class="card mb-3">
                  <div class="card-body bg-light">
                    <form action="$formActionChoose" method="post">
                      $role Name: $peopleFirst $peopleMiddle $peopleLast $peopleSuffix<br><br>
                      <input class="btn" type="submit" value="Choose this $role">
                      <input type="hidden" name="newPeopleID" value="$peopleID"/>
                      <input type="hidden" name="oldPeopleID" value="$oldPeopleID"/>
                      <input type="hidden" name="bookID" value="$bookID"/>
                      <input type="hidden" name="compositionID" value="$compositionID"/>
                      <input type="hidden" name="composerID" value="$peopleID"/>
                      $sendAddNew  
                      $sendReplace 
                      $sendEditBook
                      $sendEditComposition
                      $sendFindComposer
                    </form><br/> <!-- end form -->
                  </div> <!-- end card-body -->
                </div> <!-- end card -->
           

_END;

            } /*for loop ending*/

            echo <<<_END
        
           
        
            <div class="container-fluid bg-secondary text-light pb-3">
              <h2 class="mb-3"> None of these $role s Match</h2><br/>
              <form action="addPeople.php" method="post">
                <input class="btn btn-light" type="submit" value="Add New $role Info"/>
                <input type="hidden" name="bookID" value="$bookID"/>
                <input type="hidden" name="compositionID" value="$compositionID"/>
                <input type="hidden" name="oldPeopleID" value="$oldPeopleID"/>
                $sendAddNew  
                $sendReplace
                $sendEditBook
                $sendEditComposition
                $sendFindComposer
              </form> <!-- end form --><br/>
              
              <form action="peopleSearch.php" method="post"> 
                <input class="btn btn-light" type="submit" value="Try another $role Search"/>
                <input type="hidden" name="bookID" value="$bookID"/>
                <input type="hidden" name="compositionID" value="$compositionID"/> 
                $sendAddNew  
                $sendReplace
                $sendEditBook
                $sendEditComposition  
                $sendFindComposer    
              </form><br/><!-- end form -->
              
              <form action="$formAction" method="post">
                <input class="btn btn-light" type="submit" value="Back to $page "/>
                <input type="hidden" name="bookID" value="$bookID"/>
                <input type="hidden" name="compositionID" value="$compositionID"/> 
                $sendEditBook
                $sendEditComposition   
              </form> <!-- end form --><br/><br/>
            </div> <!-- end container -->

_END;

            } /*end if peopleFound*/
        } /*End if ($resultPeopleQuery)*/

    }  /*End if (strlen($searchPeopleLastName) > 0)) */















if ($editReplaceDeletePerson == 'true') {


    if($editBook == 'true') {
        $ERDPeopleQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM books AS b
        JOIN B2R2P ON b.ID = B2R2P.book_ID
        JOIN roles AS r ON r.ID = B2R2P.role_ID AND r.role_name = '$role'
        JOIN people AS p ON p.ID= B2R2P.people_ID
        WHERE b.ID = '$bookIDAltered';
       
       
_END;

        $resultERDPeopleQuery = $conn->query($ERDPeopleQuery);
        if ($debug) {
            echo 'ERDPeopleQuery = ' . $ERDPeopleQuery . '<br/><br/>';

            if (!$resultERDPeopleQuery) echo("\n Error description ERDPeopleQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/


    } elseif($editComposition == 'true') {
        /*logic to make this code useful for all people associated with the composition is at the beginning of the page under the initialized variable section.*/


        $ERDPeopleQuery = <<<_END

        SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
        FROM compositions AS c
        JOIN C2R2P ON c.ID = C2R2P.composition_ID
        JOIN roles AS r ON r.ID = C2R2P.role_ID AND r.role_name = '$role'
        JOIN people AS p ON p.ID = C2R2P.people_ID
        WHERE c.ID = '$compositionIDAltered';
       
       
_END;

        $resultERDPeopleQuery = $conn->query($ERDPeopleQuery);
        if ($debug) {
            echo 'ERDPeopleQuery = ' . $ERDPeopleQuery . '<br/><br/>';

            if (!$resultERDPeopleQuery) echo("\n Error description ERDPeopleQuery: " . mysqli_error($conn) . "\n<br/>");
        }/*end debug*/
    }/*end if editBook elseif editComposition*/






    if ($resultERDPeopleQuery) {
        $numERDPeopleRows = $resultERDPeopleQuery->num_rows;
        $ERDPeopleFound = ($numERDPeopleRows > 0);
        $ERDPeopleNotFound = ($numERDPeopleRows === 0);


        if ($ERDPeopleNotFound) {

            echo <<<_END

             <div class="container-fluid bg-secondary pt-4 pb-3">
                <h2 class="display-4 text-light">Bummer!</h2>
                <h2>No $role for your book "$bookTitle" was found. <br/><br/></h2>
                 <form action='$formAction' method='post'>
                    <input class="btn btn-light" type='submit' value='BACK To $page'/>
                    <input type='hidden' name='bookID' value='$bookID'/>
                    <input type='hidden' name='compositionID' value='$compositionID'/>
                    $sendEditBook
                    $sendEditComposition
                    
                </form><br/><br/><!-- end form -->
             </div> <!-- end container -->


_END;

        } /*END if $editorPeopleNotFound*/




        if($ERDPeopleFound) {

            echo <<<_END
        <div class="container-fluid bg-secondary pt-3 pb-3">
            <h3 class=" text-light pb-2">$role(s) for "$Title".</h3><br>
            <h5 class="text-light pb-2">Click on "Edit", "Replace" or "Delete" to Continue.</h5><br>
            <p class="text-light">EDIT:  Makes changes to this $role information everywhere in the catalog.</p>
            <p class="text-light">REPLACE:  Exchanges this $role information for new $role information for this book only.</p>
            <p class="text-light">DELETE:  Deletes this $role information from this book only. This $role will remain in the library to be used at other times. </p>
        </div>  <!-- end container -->
        
_END;


            for ($j = 0; $j < $numERDPeopleRows; $j++) {
                $row = $resultERDPeopleQuery->fetch_array(MYSQLI_NUM);
                /*var_dump ($row);*/
                $ERDPeopleID = $row[0];
                $ERDPeopleFirstName = $row[1];
                $ERDPeopleMiddleName = $row[2];
                $ERDPeopleLastName = $row[3];
                $ERDPeopleSuffix = $row[4];


                echo <<<_END

                <div class="container-fluid bg-secondary pt-3 pb-3">
                    <div class="card mb-3">
                        <div class="card-body bg-light">
                            <h5> $role Name: $ERDPeopleFirstName $ERDPeopleMiddleName $ERDPeopleLastName $ERDPeopleSuffix</h5><br><br>
    
                            <div class="row">
                                <form action="addPeople.php" method="post">
                                    <div class="col">
                                        <input class="btn btn-sm"  type='submit' value='EDIT'/>
                                        <input type='hidden' name='bookID' value='$bookID'/>
                                        <input type='hidden' name='compositionID' value='$compositionID'/>
                                        <input type='hidden' name='oldPeopleID' value='$ERDPeopleID'/>
                                        $sendEdit
                                        $sendEditBook
                                        $sendEditComposition
                                    </div>  <!-- end col -->
                                </form>  <!-- end form -->
                                <form action="peopleSearch.php" method="post">
                                    <div class="col">
                                        <input class="btn btn-sm "  type='submit' value='REPLACE'/>
                                        <input type='hidden' name='bookID' value='$bookID'/>
                                        <input type='hidden' name='compositionID' value='$compositionID'/>
                                        <input type='hidden' name='oldPeopleID' value='$ERDPeopleID'/>
                                        $sendReplace
                                        $sendEditBook
                                        $sendEditComposition
                                    </div>  <!-- end col -->
                                </form>  <!-- end form -->
                                
                                <form action="delete.php" method="post">
                                    <div class="col">
                                        <input class="btn btn-sm {$deleteButton}"  type='submit' value='DELETE'/>
                                        <input type='hidden' name='bookID' value='$bookID'/>
                                        <input type='hidden' name='bookTitle' value="{$fn_encode($bookTitle)}"/>
                                        <input type='hidden' name='compName' value="{$fn_encode($compName)}"/>
                                        <input type='hidden' name='compositionID' value='$compositionID'/>
                                        <input type='hidden' name='oldPeopleID' value='$ERDPeopleID'/>
                                       
                                        
                                        $sendEditBook
                                        $sendEditComposition
                                        $sendDelete
                                    </div>  <!-- end col -->
                                </form>  <!-- end form -->
                            </div>  <!-- end row -->
                        </div>  <!-- end card-body -->
                    </div>  <!-- end card -->
    
                </div>  <!-- end container -->

_END;

            } /*for loop ending*/
        }/*End if ($editorPeopleFound)*/
    }/*End if ($resultEditorPeopleQuery)*/




    echo<<<_END

<div class="container-fluid bg-secondary pt-4 pb-3">
                
                 <form action='$formAction' method='post'>
                    <input class="btn btn-light" type='submit' value='BACK To $page '/>
                    <input type='hidden' name='bookID' value='$bookID'/>
                    <input type='hidden' name='compositionID' value='$compositionID'/>
                    $sendEditBook
                    $sendEditComposition

                    </form><br/><br/><!-- end form -->
             </div> <!-- end container -->

_END;

}/*End if ($editReplaceDeletePerson)*/






























include 'footer.html';
include 'endingBoilerplate.php';

?>