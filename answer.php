<?php
include 'boilerplate.php';

if($debug) {
    echo <<<_END
  
   <p>answer - 40</p>
   
_END;

}/*end debug*/

/*include 'beginningNav.html';*/
include 'beginningNav.php';

echo <<<_END

<div class="jumbotron-fluid bg-light pt-3 pb-4">
  <h1 class="text-center display-4">Answer-It!</h1>     
  
  <h3 class=" text-center">Answers to common Questions here at Catalogit Music Library<h3/p>
</div> <!-- end jumbotron-->


_END;



include 'footer.php';

include 'endingBoilerplate.php';

?>