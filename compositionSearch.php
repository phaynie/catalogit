<?php
include 'boilerplate.php';

if($debug) {
    echo <<<_END

 <p>compositionSearch-34</p>

_END;

}/*end debug*/


include 'beginningNav.php';


/*initializing Variables*/
$bookID = "";
$searchCompositionTitle = "";
$searchCompositionTitleErr = "";
$submit = "";
$validationFailed = false;

/*assign local variables to the REQUEST values*/

if(isset($_REQUEST['bookID']) && is_numeric($_REQUEST['bookID'])) {
    $bookID = $_REQUEST['bookID'];
}

if(isset($_REQUEST['searchCompositionTitle'])) {
    $searchCompositionTitle = $_REQUEST['searchCompositionTitle'];
}

if(isset($_REQUEST['submit'])) {
    $submit = $_REQUEST['submit'];
}

/*logic for variable values in different situations*/




/*retrieve  composition name values from db and put into an array*/


$compositionsArray = "";
$compositionsArrayQuery = "
                SELECT c.comp_name
                FROM compositions AS c 
              
                ORDER by c.comp_name ASC
                  ";

$resultCompositionsArrayQuery = $conn->query($compositionsArrayQuery);
if($debug) {
    $debug_string.=" 'compositionsArrayQuery = ' . $compositionsArrayQuery . '<br/><br/>'";
    if (!$resultCompositionsArrayQuery) $debug_string.='("\n Error description compositionsArrayQuery: " . mysqli_error($conn) . "\n<br/>")';
}/*end debug*/

failureToExecute ($resultCompositionsArrayQuery, 'S530', 'Select ' );


if ($resultCompositionsArrayQuery) {

    $compositionsArrayNumberOfRows = $resultCompositionsArrayQuery->num_rows;
    $compositionsArray = "<script> let compositions=[";

    for ($j = 0 ; $j < $compositionsArrayNumberOfRows ; ++$j)
    {
        $row = $resultCompositionsArrayQuery->fetch_array(MYSQLI_NUM);

        /*  var_dump ($row);*/


        $compositionName = htmlspecialchars($row[0], ENT_QUOTES);


        $compositionsArray .= "'$compositionName'" .", ";

    } /*for loop ending*/

} /*End if ($resultCompositionsArrayQuery)*/

$compositionsArray = rtrim($compositionsArray,', ');
$compositionsArray .="]</script>";

$debug_string .= "<xmp>" . $compositionsArray . "</xmp> \n<br/>";









/*Validation code section
     if $validationFailed is true, we will show form pre-populated with error messages and user can re-submit values.
     no variables will be washed in this page since there will be no variables used in db queries here.*/


if($submit == 'true') {
    if (strlen($searchCompositionTitle) == 0 ) {
        $searchCompositionTitleErr = "<span class= 'error' >* Composition Title is required</span>";
        $validationFailed = true;
    }/*end */

    /*If any validation failed, give values to our initialized variables*/



    /*Validation over*/
    /*Don't need to wash here. Not used to access DB. will wash on next page*/
    if (!$validationFailed ) {



        header('Location: compositionOptions2.php?bookID=' . $bookID . '&searchCompositionTitle=' . $searchCompositionTitle );
        exit();

    } /* End if (!$validationFailed )*/


}/*End if submit == 'true'*/


if($debug) {
    echo $debug_string;
}
echo $compositionsArray;





/*Next we will display form with text box for the composition title and button "Search for this Composition". We will also pass hidden values needed when we validate.
 */




echo <<<_END



<div class="container-fluid bg-light pt-4 pb-5" >
      <div class="col-md-6">
      <form class="form-group  pt-3 " action='compositionSearch.php' method='post'>
          Composition Title: $searchCompositionTitleErr
          <input class="form-control mb-3 " autocomplete="off"  type="text" name="searchCompositionTitle" id="searchCompositionTitle" placeholder = "Please enter a Composition Title" />
          <ul id="cmpsnArray"></ul>
          <input class="btn btn-secondary mt-4" type="submit" value="Search for this Composition"/>
          <input type="hidden" name="submit" value="true"/>
          <input type="hidden" name="bookID" value="$bookID"/>
         
      </form>   <!-- end form -->
      
      <form class="form-group   pb-3" action='displayBook.php' method='post'>
          <input class="btn btn-secondary mt-4" type="submit" value="Back to Display Book"/>
          <input type="hidden" name="bookID" value="$bookID"/>
         
      </form>   <!-- end form -->


      </div>  <!-- end col -->
    </div> <!-- end container -->

_END;





  include 'footer.php';

  include 'endingBoilerplate.php';

echo <<<_END
<script>
listener('searchCompositionTitle', compositions,  'cmpsnArray');
</script>

_END;




 ?>
