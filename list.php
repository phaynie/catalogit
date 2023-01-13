<?php

include 'boilerplate.php';
$debug_string = "";

if($debug) {
    echo <<<_END
  
  <p><strong>list.php-60</strong></p>

_END;

}/*end debug*/


include 'beginningNav.php';

$bookListAccess = "";
$bookID = "";
$compositionListAccess = "";
$composerListAccess = "";
$completeList = "";
$typeOfList = "";
$typeOfID = "";
$typeOfSearch = "";
$searchPage = "";
$listAccess = "";
$print = "";


if(isset($_REQUEST['bookListAccess'])) {
    $bookListAccess = $_REQUEST['bookListAccess'];
    $typeOfList = "Book Titles";
    $typeOfSearch = "Book Title Search";
    $searchPage = "bookTitleSearch.php";
    $listAccess = "bookListAccess";
}

if(isset($_REQUEST['compositionListAccess'])) {
    $compositionListAccess = $_REQUEST['compositionListAccess'];
    $typeOfList = "Composition Titles";
    $typeOfSearch = "Composition Search";
    $searchPage = "compositionSearch.php";
    $listAccess = "compositionListAccess";
}

if(isset($_REQUEST['composerListAccess'])) {
    $composerListAccess = $_REQUEST['composerListAccess'];
    $typeOfList = "Composers";
    $typeOfSearch = "Composer Search";
    $searchPage = "peopleSearch.php";
    $listAccess = "composerListAccess";
}

if(isset($_REQUEST['print'])) {
    $print = $_REQUEST['print'];
    
}





/*Here we retrieve a list of all the books in the db and create
and place them inside the variable $completeList to be echo-ed out lower*/


/*db query*/
echo "bookListAccess = " . $bookListAccess . "<br>";

If($bookListAccess=="true"){
$completeList = "";

    $bookListQuery= "SELECT  b.ID,  b.title
    FROM books AS b
    ORDER BY b.title ASC";
    
    $resultBookListQuery = $conn->query($bookListQuery);
    if($debug) {
        $debug_string.= "bookListQuery = " . $bookListQuery . "<br/><br/>";
        if (!$resultBookListQuery) $debug_string.="('\n Error description bookListQuery: ' . mysqli_error($conn) . '\n<br/>')";
    }/*end debug*/
    
    
    if ($resultBookListQuery) {
        $numberOfBookListRows = $resultBookListQuery->num_rows;
    
        for ($j = 0; $j < $numberOfBookListRows; ++$j) {
              $row = $resultBookListQuery->fetch_array(MYSQLI_NUM);
    
            $bookID = $row[0];
            $bookTitle = $row[1];
              
            $completeList .= " 
                <form action='displayBook.php' method='post'>
                    <input class='btn  btn-link' type='submit' value='{$fn_encode($bookTitle)}' />
                    <input type='hidden' name='bookID' value= '$bookID' />
                </form> <!-- form -->  <br>";  
          }    /*forloop ending*/
    
    } /*end if resultBookListQuery*/
      
/*Here we retrieve a list of all the Compositions in the db and 
place them inside the variable $completeList to be echo-ed out lower*/

}elseIf($compositionListAccess=="true"){
    $completeList = "";
    
    /*db query*/
    
    $compositionListQuery= "SELECT  c.ID,  c.comp_name
    FROM compositions AS c
    ORDER BY c.comp_name ASC";
    
    $resultCompositionListQuery = $conn->query($compositionListQuery);
    if($debug) {
        $debug_string.= "compositionListQuery = " . $compositionListQuery . "<br/><br/>";
        if (!$resultCompositionListQuery) $debug_string.="('\n Error description compositionListQuery: ' . mysqli_error($conn) . '\n<br/>')";
    }/*end debug*/
    
    
    if ($resultCompositionListQuery) {
        $numberOfCompositionListRows = $resultCompositionListQuery->num_rows;
    
        for ($j = 0; $j < $numberOfCompositionListRows; ++$j) {
            $row = $resultCompositionListQuery->fetch_array(MYSQLI_NUM);
    
            $compositionID = $row[0];
            $compositionTitle = $row[1];
              
            $completeList .= " 
                <form action='displayComposition.php' method='post'>
                    <input class='btn  btn-link' type='submit' value='{$fn_encode($compositionTitle)}' />
                    <input type='hidden' name='compositionID' value= '$compositionID' />
                </form> <!-- form -->  <br>";  
        } /*forloop ending*/
    
    } /*end if resultCompositionListQuery*/
      
 /*end If($compositionListAccess=="true")*/
}elseIf($composerListAccess=="true"){
    $completeList = "";
    
    /*db query*/
    
    $composerListQuery= "SELECT DISTINCT p.ID, p.firstname, p.middlename, p.lastname, p.suffix
    FROM people AS p 
    LEFT JOIN c2r2p ON c2r2p.people_ID=p.ID
    LEFT JOIN roles AS r ON r.ID=c2r2p.role_ID
    WHERE r.role_name='Composer'
    ORDER BY lastname ASC";
    
    $resultComposerListQuery = $conn->query($composerListQuery);
    if($debug) {
        $debug_string.= "composerListQuery = " . $composerListQuery . "<br/><br/>";
        if (!$resultComposerListQuery) $debug_string.="('\n Error description composerListQuery: ' . mysqli_error($conn) . '\n<br/>')";
    }/*end debug*/
    
    
    if ($resultComposerListQuery) {
              $numberOfComposerListRows = $resultComposerListQuery->num_rows;
    
              for ($j = 0; $j < $numberOfComposerListRows; ++$j) {
                  $row = $resultComposerListQuery->fetch_array(MYSQLI_NUM);
    
                  $composerID = $row[0];
                  $composerFirstName = $row[1];
                  $composerMiddleName = $row[2];
                  $composerLastName = $row[3];
                  $composerSuffix = $row[4];
                  
                  $completeList .= " 
                     <form action='displayPerson.php' method='post'>
                        <input class='btn  btn-link' type='submit' value='{$fn_encode($composerLastName . ', ' . $composerFirstName)}' />
                        <input type='hidden' name='composerID' value= '$composerID' />
                     </form> <!-- form -->  <br>";  
              }    /*forloop ending*/
    
          } /*end if resultCompositionListQuery*/

} /*end If($compositionListAccess=="true")*/


if($debug){
$debug_string.= "typeOfID =" . $typeOfID . "<br>";
$debug_string.= "typeOfSearch =" . $typeOfSearch . "<br>";
$debug_string.= "listAccess =" . $listAccess . "<br>";
}
if($debug){
echo $debug_string;
}



?>

<div class="container-fluid displayCard bg-dark pt-4 mb-4 pb-5">
    <div class="card ">
        <div class= "card-header bummerText1 " style="text-align:center;"><?php echo "$typeOfList" ?> </div>
        <div class= "card-body bg-light ">
            <div class="row ">
                <div class="col-md-6 pb-4 " >
                    
                    <?php echo $completeList; ?>
                </div> <!-- end col -->
                <div class="col-md-6 pb-4 two">
                    <?php echo "
                    <form action='$searchPage' method='post'>
                        <input class='btn btn-secondary  noPrint' type='submit' value='Return to $typeOfSearch' />
                    </form> <br>
                    <form action='list.php' method='post'>
                        <button class='btn btn-secondary mb-3 noPrint' onclick='window.print()'>Print</button>
                        <input type='hidden' name='$listAccess' value='true'/>
                      
                    </form>
                    <form action='introPage.php' method='post'>
                        <input class='btn btn-secondary  noPrint' type='submit' value='Search Library' />
                    </form> <br>";  ?>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>  <!-- end card-body -->
    </div>  <!-- end card -->
</div>  <!-- end container -->







<?php

include 'footer.php';
include 'endingBoilerplate.php';