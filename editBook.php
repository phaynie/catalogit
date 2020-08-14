<?php
include 'boilerplate.php';
if($debug) {
     echo 'editBook.php-5';
}/*end debug*/


include 'beginningNav.php';
 /*from page 4 (display book)
  This page is for the purpose of giving the user an opportunity to edit the book displayed in the previous page (4)*/
  /*In order to Edit the book found on the editbook page we will collect and display the book information and provide buttons that allow the user to choose which part of the book information they would like to change. We will circle back to this editBook page again and again until the user if finished editing this book and clicks on the Done Editing button which takes them back to the displayBook page. */


$bookID = "";
$editBook = "";
$peopleID="";
$orgID = "";
$physBookLocNote = "";
$deletePublisherFromBookSuccess = "";
$deleteEditorFromBookSuccess = "";


$bookTag1 = "";
$bookTag2 = "";
$bookVolume = "";
$bookNumber = "";
$publisherName = "";
$editorFirstName = "";
$editorMiddleName = "";
$editorLastName = "";
$editorSuffix = "";
$displayEditorPeopleString = "";
$publisherName = "";
$publisherLocation = "";
$displayPublisherOrgString = "";
$physBookLocNote = "";




$editorPeopleID = "";
$editorPeopleFirstName ="";
$editorPeopleMiddleName = "";
$editorPeopleLastName = "";
$editorPeopleSuffix = "";
$publisherOrgID = "";
$publisherOrgName = "";
$publisherOrgLocation = "";
$disableERDPub = "";
$disableERDEditor = "";




if(isset($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if(isset($_REQUEST['editBook'])) {
    $editBook = $_REQUEST['editBook'];
}

if(isset($_REQUEST['deletePublisherFromBookSuccess'])) {
    $deletePublisherFromBookSuccess = $_REQUEST['deletePublisherFromBookSuccess'];
}



/*TODO: finish passing along the variables that need to be here to complete the following code*/
/*Logic for specific instances*/
$notEntered = "<span style='color:rgba(0,0,0,0.4);'>Not Entered</span>";

if($deleteEditorFromBookSuccess=='true') {
    echo 'This ' . $editorPeopleLastName .  'has successfully been deleted from the book called ' . $bookTitle . '.';
}


if($deletePublisherFromBookSuccess=='true') {
    echo 'This ' . $publisherOrgName .  'has successfully been deleted from the book called ' . $bookTitle . '.';
}


if (isset($editBook) || $bookID){


        $bookQuery  = <<<_END

          SELECT b.ID, b.title, b.tag1, b.tag2, b.book_vol, b.book_num, b.physBookLoc
          FROM books AS b

          WHERE b.ID = $bookID ;

_END;

       $bookQueryResult = $conn->query($bookQuery);

       if($debug) {
           echo 'bookQuery =' . $bookQuery . '</br>';
       }
     
      if (!$bookQueryResult) echo ("\n Error description query bookQuery: " . mysqli_error($conn) . "\n<br/>");
if($bookQueryResult) {
    $numberOfBookRows = $bookQueryResult->num_rows;

    for ($j = 0; $j < $numberOfBookRows; ++$j) {
        $row = $bookQueryResult->fetch_array(MYSQLI_NUM);

        $bookID = htmlspecialchars($row[0]);
        $bookTitle = htmlspecialchars($row[1]);
        $bookTag1 = htmlspecialchars($row[2]);
        $bookTag2 = htmlspecialchars($row[3]);
        $bookVolume = htmlspecialchars($row[4]);
        $bookNumber = htmlspecialchars($row[5]);
        $physBookLocNote = htmlspecialchars($row[6]);

    }    /*forloop ending*/

} /*end if bookquery result*/




    /*Retrieving all editor info for this book
   I will also be creating a comma separated list to use in the displayed information, except my comma will be a break and Editor Name: */
    $editorPeopleQuery = <<<_END

      SELECT  p.ID, p.firstname, p.middlename, p.lastname, p.suffix
      FROM books AS b 
      JOIN B2R2P ON b.ID = B2R2P.book_ID
      JOIN people AS p ON p.ID= B2R2P.people_ID
      WHERE b.ID = $bookID;

_END;

    $resultEditorPeopleQuery = $conn->query($editorPeopleQuery);
    if($debug) {
        echo 'editorPeopleQuery = ' . $editorPeopleQuery . '<br/><br/>';

        if (!$resultEditorPeopleQuery) echo ("\n Error description editorPeopleQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    if ($resultEditorPeopleQuery) {
        $numEditorPeopleRows = $resultEditorPeopleQuery->num_rows;
        /*Build comma separated list of editorPeople in a string*/
        $editorPeopleString= "";

        for ($j = 0 ; $j < $numEditorPeopleRows ; ++$j) {
            $row = $resultEditorPeopleQuery->fetch_array(MYSQLI_NUM);
            /*var_dump ($row);*/
            $editorPeopleID = ($row[0]);
            $editorPeopleFirstName = ($row[1]);
            $editorPeopleMiddleName = ($row[2]);
            $editorPeopleLastName = ($row[3]);
            $editorPeopleSuffix = ($row[4]);
            /*$editorPeopleString = implode(',',$instVal);*/
            $editorPeopleString .= $editorPeopleFirstName . " " . $editorPeopleMiddleName . " " . $editorPeopleLastName . " " . $editorPeopleSuffix . ", ";

        } /*for loop ending*/

    } /*End if $resultEditorPeopleQuery query*/


    $displayEditorPeopleString = substr($editorPeopleString, 0, strrpos($editorPeopleString, ", " ));

    if($displayEditorPeopleString == ""){
        $disableERDEditor = 'disabled';
    }




    /*Retrieving all publisher info for this book
   I will also be creating a comma separated list to use in the displayed information, except my comma will be a break and Publisher Name: */
    $publisherOrgQuery = <<<_END

      SELECT  o.ID, o.org_name, o.location
      FROM books AS b 
      JOIN B2R2O ON b.ID = B2R2O.book_ID
      JOIN organizations AS o ON o.ID= B2R2O.org_ID
      WHERE b.ID = $bookID;

_END;

    $resultPublisherOrgQuery = $conn->query($publisherOrgQuery);
    if($debug) {
        echo 'publisherOrgQuery = ' . $publisherOrgQuery . '<br/><br/>';

        if (!$resultPublisherOrgQuery) echo ("\n Error description publisherOrgQuery: " . mysqli_error($conn) . "\n<br/>");
    }/*end debug*/

    if ($resultPublisherOrgQuery) {
        $numPublisherOrgRows = $resultPublisherOrgQuery->num_rows;
        /*Build comma separated list of publisherOrg in a string*/
        $publisherOrgString= "";

        for ($j = 0 ; $j < $numPublisherOrgRows ; ++$j) {
            $row = $resultPublisherOrgQuery->fetch_array(MYSQLI_NUM);
            /*var_dump ($row);*/
            $publisherOrgID = ($row[0]);
            $publisherOrgName = ($row[1]);
            $publisherOrgLocation = ($row[2]);

            /*$editorPeopleString = implode(',',$instVal);*/
            $publisherOrgString .= $publisherOrgName . "</br> Publisher Location: " . $publisherOrgLocation . "</br>Publisher Name: ";

        } /*for loop ending*/

    } /*End if $resultPublisherOrgQuery*/


    $displayPublisherOrgString = substr($publisherOrgString, 0, strrpos($publisherOrgString, "</br>Publisher Name: " ));

    if($displayPublisherOrgString == ""){
        $disableERDPub = 'disabled';
    }


    /*book*/

    if($bookTag1 == "") {
        $bookTag1 = $notEntered;
    }

    if($bookTag2 == "") {
        $bookTag2 = $notEntered;
    }

    if($bookVolume == "") {
        $bookVolume = $notEntered;
    }

    if($bookNumber == "") {
        $bookNumber = $notEntered;
    }

    if($physBookLocNote == "") {
        $physBookLocNote = $notEntered;
    }

    if($displayEditorPeopleString == "" ) {
        $displayEditorPeopleString = $notEntered;
    }

    if($displayPublisherOrgString == "" ) {
        $displayPublisherOrgString = $notEntered;
    }






    echo <<<_END
    <div class="container-fluid bg-secondary pt-3 pb-3 mt-3">
    <h4 class="display-4 text-light text-center "> "$bookTitle"</h4>
    <h4 class="display-5 text-light text-center "> Add or Edit here</h4><br><br>
   <div class=" col-md-8 offset-md-2  ">
    <p class="editpage"> * You will be returned to this page each time UNTIL you are finished editing and you click the "Done Editing" button. The editing you have done will be reflected in the book information you see on this page. Cool, right?</p>
    </div>
      <div class="row"</div> 
      
        <div class=" col-md-4 offset-md-2  ">
       
           <div class="card  mt-4 mb-3">
              <div class="card-body bg-light">
                 
                       Book Title: <strong>$bookTitle</strong> <br/>
                       Tag 1: $bookTag1 <br/>
                       Tag 2: $bookTag2 <br/>
                       Book Volume: $bookVolume <br/>
                       Book Number: $bookNumber <br/>
                       Editor Name: $displayEditorPeopleString<br/>
                       Publisher Name: $displayPublisherOrgString <br/>
                       Book Location: <span style="color:#EB6B42;">$physBookLocNote</span><br/><br/>
                      
                      
                                  
                   
              </div>  <!-- end card-body -->
           </div>  <!-- end card -->
        </div>  <!-- end col -->
        
     
        <div class="col-md-4">
          
               
                   <form class="mt-4" action='addBook.php' method='post'>
                      <div class="form-check">
                          <input class="btn  btn-light" type='submit' value="Edit Existing General Book Information for '$bookTitle' "/>
                          <input type='hidden' name="bookID" value='$bookID'/>
                          <input type='hidden' name="editBook" value= 'true' />
                       </div>  <!-- end form-check -->      
                   </form>  <!-- end form -->
                  
                   <form action='delete.php' method='post'>
                       <div class="form-check">
                            <input class="btn btn-light confirm deletebook_button" type="submit" value="Delete the book '$bookTitle' from library "/>
                            <input type="hidden" name="editBook" value ="true" />
                            <input type="hidden" name="bookID" value= "$bookID" />
                            <input type="hidden" name="bookTitle" value="$bookTitle"/>
                            <input type="hidden" name="deleteBook" value= "true" />
                          </div><!-- end form-check -->
                  </form>
        
                  <form class="mt-4" action='peopleOptions.php' method='post'>
                    <div class="form-check">
                        <input class="btn  btn-light" type='submit' $disableERDEditor value="Edit/Replace/Delete Existing Editor Information for '$bookTitle' "  />
                        <input type='hidden' name="bookID" value='$bookID'/>
                        <input type='hidden' name="bookTitle" value='$bookTitle'/>
                        <input type='hidden' name="editBook" value= 'true' />
                        <input type='hidden' name="editReplaceDeleteEditor" value= 'true' />
                    </div>  <!-- end form-check --> 
                  </form>  <!-- end form -->

                  
                   <form class="mt-4" action='peopleSearch.php' method='post'>
                      <div class="form-check">
                          <input class="btn  btn-light" type='submit' value="Add a NEW Editor to '$bookTitle'"/>
                          <input type='hidden' name="bookID" value='$bookID'/>
                          <input type='hidden' name="bookTitle" value='$bookTitle'/>
                          <input type='hidden' name="editBook" value= 'true' />
                          <input type='hidden' name="oldPeopleID" value= '$peopleID' />
                          <input type='hidden' name="addNewEditor" value= 'true' />
                       </div>  <!-- end form-check -->      
                  </form>  <!-- end form -->
                  
        
                  <form class="mt-4" action='orgOptions.php' method='post'>
                     <div class="form-check">
                        <input class="btn  btn-light" type='submit' $disableERDPub value="Edit/Replace/Delete Existing Publisher Information for '$bookTitle'"  />
                        <input type='hidden' name="bookID" value='$bookID'/>
                        <input type='hidden' name="bookTitle" value='$bookTitle'/>
                        <input type='hidden' name="editBook" value= 'true' />
                        <input type='hidden' name="editReplaceDeletePub" value= 'true' />
                     </div>  <!-- end form-check --> 
                  </form>  <!-- end form -->
               
        
                  <form class="mt-4" action='orgSearch.php' method='post'>
                      <div class="form-check">
                          <input class="btn  btn-light" type='submit' value="Add a NEW Publisher to '$bookTitle'"/>
                          <input type='hidden' name="bookID" value='$bookID'/>
                          <input type='hidden' name="bookTitle" value='$bookTitle'/>
                          <input type='hidden' name="editBook" value= 'true' />
                          <input type='hidden' name="addNewPublisher" value= 'true' />
                       </div>  <!-- end form-check -->      
                  </form>  <!-- end form -->
                                               
                  <form class="mt-4" action='displayBook.php' method='post'>
                      <div class="form-check">
                         <input class="btn  btn-light" type='submit' value="Done Editing '$bookTitle'"/>
                         <input type='hidden' name="bookID" value='$bookID'/>
                      </div>  <!-- end form-check --> 
                  </form>  <!-- end form --><br><br><br>
                  
                  
                  
                  
                  
                  
                  
                  
            
        </div>  <!-- end col -->
        
        
     <div class="col-md-8 offset-md-2  mt-4">
     <h4 class="display-5 text-light  mb-4 "> Some Button Explanation</h4>
    <p class="editpage"> * <b>Edit Existing General Book Information:</b>   This will allow you to correct a mis-spelling or incorrect information that needs to be changed everywhere this book is found through-out the library. </p>
    <p class="editpage">* <b>Edit Existing Editor Information:</b> This will allow you to correct a mis-spelling or incorrect information that needs to be changed everywhere this editor/person is found through-out the library. </p>
     <p class="editpage">* <b>Replace Existing Editor for this book:</b> If an Editor does exist, but you would like to replace it with a different person. </p>
     <p class="editpage">* <b>Add New Editor:</b> If an Editor does NOT exist, and you would like to add a person as an editor to this book. If an editor does exist, adding a new Editor will add to the list of editors for this book. </p>
     <p class="editpage">* <b>Delete person as Editor from this book:</b> This will allow you to delete the editor from this book but not from other instances in the database.  </p>
     <p class="editpage">* <b>Edit Existing Publisher Information:</b> This will allow you to correct a mis-spelling or incorrect information that needs to be changed everywhere this publisher is found through-out the library. </p>
     <p class="editpage">* <b>Replace Existing Publisher for this book:</b> If an Publisher does exist, this allows you to replace it with a different Publisher. </p>
     <p class="editpage">* <b>Add New Publisher to this book:</b> If a Publisher does NOT exist, this allows you to add an organization as a publisher to this book. If a publisher does exist, adding a new Publisher will add to the list of publishers for this book.  </p>
     <p class="editpage">* <b>Delete organization as Editor from this book:</b> This will allow you to delete the publisher from this book but not from other instances in the database.  </p>
     <p class="editpage">* <b>Add a Physical location for your Book:</b> Want to know where the actual location of the book is? Write yourself a note. You can add as much or as little as you like.</p>
      <p> &nbsp&nbsp&nbsp&nbsp&nbsp examples:</p> 
      <p> &nbsp&nbsp&nbsp&nbsp&nbsp shelf, anthologies, alphabetical by title. </p>
      <p> &nbsp&nbsp&nbsp&nbsp&nbsp livingRoom bookcase, shelf two.</p>
      <p> &nbsp&nbsp&nbsp&nbsp&nbsp file cabinet 7, drawer 2, folder number 356  </p>
      
     <p class="editpage">* <b>Edit the Physical location for your Book:</b> Change your location anytime it makes sense. </p>
          <p class="editpage">* <b>DONE EDITING:</b> This ends your editing session and takes you to the book display page where you can choose what to do next.  </p><br/><br/>
     
   
    
    
    </div>
         
        
        
        
     </div>  <!-- end row -->
 </div> <!-- end container -->

_END;

  }  /*end ifisset bookID*/


include 'footer.html';
include 'endingBoilerplate.php';
?>


