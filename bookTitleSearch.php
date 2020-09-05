<?php
/*DB SECURITY
This page has one text box receiving user input: $searchBoxTitle
This page provides a form to collect this user data.
Once data is submitted, this page will validate the submitted info.
This page does not use that info in any db queries.
This user data does not need to be washed on this page*/

include 'boilerplate.php';

if($debug) {
    echo <<<_END

    <p>bookTitleSearch.php-2</p>

_END;

}/*end debug*/

include 'beginningNav.php';

/*initializing Variables*/


$searchBookTitleErr = "";
$searchBookTitle = "";
$submit = "";

$validationFailed = false;


/*create local variables to hold the REQUEST values*/

if(isset($_REQUEST['submit'])) {
    $submit = $_REQUEST['submit'];
}

if(isset($_REQUEST['searchBookTitle'])) {
    $searchBookTitle = $_REQUEST['searchBookTitle'];
}





/*Auto Complete: retrieve book Title values from db and put into an array*/


$bookTitlesArray = "";
$bookTitlesArrayQuery = "
                SELECT distinct b.title
                FROM books AS b 
               
                ORDER by b.title
                  ";

$resultBookTitlesArrayQuery = $conn->query($bookTitlesArrayQuery);
if($debug) {
    $debug_string.=" 'bookTitlesArrayQuery = ' . $bookTitlesArrayQuery . '<br/><br/>'";
    if (!$resultBookTitlesArrayQuery) $debug_string.="('\n Error description bookTitlesArrayQuery: ' . mysqli_error($conn) . '\n<br/>')";
}/*end debug*/

if ($resultBookTitlesArrayQuery) {

    $bookTitlesArrayNumberOfRows = $resultBookTitlesArrayQuery->num_rows;
    $bookTitlesArray = "<script> let bookTitles=[";

    for ($j = 0 ; $j < $bookTitlesArrayNumberOfRows ; ++$j)
    {
        $row = $resultBookTitlesArrayQuery->fetch_array(MYSQLI_NUM);

        /*  var_dump ($row);*/


        $bookTitle = htmlspecialchars($row[0], ENT_QUOTES);

        $bookTitlesArray .= "'$bookTitle'" .", ";





    } /*for loop ending*/

} /*End if ($resultBookTitleArrayQuery)*/

$bookTitlesArray = rtrim($bookTitlesArray,', ');
$bookTitlesArray .="]</script>";












/*Validation code section
     if $validationFailed is true, we will show form pre-populated with error messages and user can re-submit values.
     if $validationFailed is false, we will wash data coming from the form.*/

if($submit == 'true') {
    if (strlen($searchBookTitle) == 0 ) {
        $searchBookTitleErr = "<span class= 'error' >* Book Title is required</span>";
        $validationFailed = true;
    }/*end */


/*I don't wash the data here because it isn't going into the data base here.
The info the user adds will be washed later before it is submitted to the db. */





    if (!$validationFailed ) {



        header('Location: bookOptions2.php?searchBookTitle=' . $searchBookTitle);
        exit();
    } /* End if (!$validationFailed )*/

}/*End if($submit == 'true')*/


if($debug) {
    echo $debug_string;
}
echo $bookTitlesArray;


/*Next we will display form with text box for the book title and button "Search for this Book". We will also pass hidden values needed when we validate.
 */



echo <<<_END



<div class="container-fluid bg-light pt-4 pb-5" >
      <div class="col-md-6">
      <form class="form-group  pt-3 pb-3" action='bookTitleSearch.php' method='post'>
          Book Title: $searchBookTitleErr
          <input class="form-control" autocomplete="off" type="text" name="searchBookTitle" id="searchBookTitle" placeholder = "Please enter a book title" />
          <ul id="bkTtlsArray"></ul>
          <p>If adding sheet music, add your selection to the book titled "Sheet Music Collection"</p>
          <p>OR create your own sheet music "book or collection" by searching for the name of the collection and adding a new "book" when it is not found. You will be able to add this music to as many collections as you like.</p>
          <input class="btn btn-secondary mt-4" type="submit" value="Search for this Book"/>
          <input type="hidden" name="submit" value="true"/>
      </form>   <!-- end form -->

      </div>  <!-- end col -->
    </div> <!-- end container -->

_END;














  include 'footer.html';
  include 'endingBoilerplate.php';


echo <<<_END
<script>
listener('searchBookTitle', bookTitles,  'bkTtlsArray');
</script>

_END;

?>
