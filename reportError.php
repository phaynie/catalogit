<?php
include 'boilerplate.php';

if($debug) {
    echo <<<_END
<p>reportError.php-33</p>

_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

$bookID = $_POST['bookID'];
/* I want some kind of way to pre-poulate the page the error came from */

 echo <<<_END

<h2>We are sorry you are having trouble</h2>

   
  <form action='don't know yet.php' method='post'> 
    nature of problem: <input type="text-area" name="errorIssue"/><br/>
    <input type='submit' value='Send'/>
    <input type='hidden' name="bookID" value='$bookID'/>
    <input type='hidden' name="compositionID" value='$compositionID'/>
    <!-- will need composition id too. previous page needs to send compid-->
  </form> 
  <form action='arrangerSearch.php' method='post'>
    <input type='submit' value='Continue Adding Composition Information'/>
    <input type='hidden' name="bookID" value='$bookID'/>
    <input type='hidden' name="compositionID" value='$compositionID'/>
    <!-- will need composition id too. previous page needs to send compid-->
  </form> 
  <form action='displayComposition.php' method='post'>
    <input type='submit' value='Stop Process'/><!-- small previous info will be saved-->
    <input type='hidden' name="bookID" value='$bookID'/>
    <input type='hidden' name="compositionID" value='$compositionID'/>
    <!-- will need composition id too. previous page needs to send compid-->
  </form> 
  <form action='exitMessage.php' method='post'>
    <input type='submit' value='Exit'/> <!-- small All composer info will be lost-->
    <input type='hidden' name="bookID" value='$bookID'/>
    <input type='hidden' name="compositionID" value='$compositionID'/>
    <!-- will need composition id too. previous page needs to send compid-->
  </form> 


_END;

include 'footer.html';
include 'endingBoilerplate.php';

?>